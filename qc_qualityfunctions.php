<?php 
///////////////////////// QUALITY FUNCTIONS /////////////////

function checkDs($p, $users) { 					// Check a single dataset
	$ds = new stdClass();
	$ds->id						= $p->id ?? ""; 
	$ds->identifier				= $p->identifier ?? ""; 
	$ds->publisher				= $p->publisher ?? ""; 
	$ds->pubstatus				= (isset($p->publicationDate)) ? "Published" : "Never published"; 
	$ds->pubDate				= $p->publicationDate ?? ""; 
	$ds->persistentUrl			= $p->persistentUrl ?? ""; 
	$ds->doi 					= $p->persistentUrl ?? "";  
	$ds->datasetPersistentId 	= $p->latestVersion->datasetPersistentId ?? "";
	$ds->versionState 			= $p->latestVersion->versionState ?? "DRAFT"; // DRAFT or RELEASED
	$ds->lastUpdateTime 		= $p->latestVersion->lastUpdateTime ?? "";
	$ds->createTime 			= $p->latestVersion->createTime ?? "";
	$ds->license 				= $p->latestVersion->license ?? "";
	$ds->termsOfUse 			= $p->latestVersion->termsOfUse ?? "";
	$ds->termsOfAccess 			= $p->latestVersion->termsOfAccess ?? "";
	$ds->fileAccessRequest		= $p->latestVersion->fileAccessRequest ?? false; 
	$ds->files 					= $p->latestVersion->files 			?? [];
	$ds->citations				= $p->latestVersion->metadataBlocks->citation ?? [];
	$ds->name_of_dataverse 		= $p->name_of_dataverse;
	$ds->identifier_of_dataverse = $p->identifier_of_dataverse;
	$ds->global_id 				= $p->global_id;
	$ds->entity_id 				= $p->entity_id;
	$ds->filesNum 				= count($ds->files); 
	$ds->msg = "";
	$ds->attention = "";
	
	$ds->score = new stdClass();
	
	///// ORGANIZATIONAL CHECK 		/////
	checkPosition($ds);
	///// COMPLETENESS CHECK 		/////	
	checkMetadata($ds);
	///// DATA-ACCESS CHECKS		/////
	checkDataAccess($ds);
	///// USER-ORIENTED CHECKS		/////
	checkUser($ds, $users);
	///// PUBLISHER CHECKS			/////
	checkPublisher($ds);
	///// FILE-ORIENTED CHECKS 		/////
	checkFile($ds);
	
	///// NOW LETS PRINT  
	printDs($ds);					///// Now Print
}

/////////////////////////// SUB-FUNCTIONS ///////////////////////////////////////////

function checkPosition($ds) {					

/////////////////////////////////////////////////////////////////////////////////////
// This function checks the position of the dataset in the tree                    //
// The dataset must not be appended to root dataverse or department dataverse      //
/////////////////////////////////////////////////////////////////////////////////////

	if ($ds->identifier_of_dataverse == ROOTDV) {
		$ds->score->posit = SCUMVOTE;
		$ds->msg .= "Unclear dataset position. Dataset appended to root - \n";
		$ds->attention .= "!!!!";
	}
	else if (stripos($ds->identifier_of_dataverse, DEPTDV)) {
		$ds->score->posit = LOWVOTE;
		$ds->msg .= "Dataset appended to department - \n";
	}
	else 
		$ds->score->posit = HIGHVOTE;
} 

function checkMetadata($ds) {					

/////////////////////////////////////////////////////////////////////////////////////
// This function checks the completeness of metadata that describe dataset         //
//                                                                                 //
/////////////////////////////////////////////////////////////////////////////////////

	$fields = $ds->citations->fields ?? []; 
	$citScore = 0;
	foreach ($fields as $field) {
		switch ($field->typeName) {
		case "title":
			$v = $field->value ?? "";
			if (strlen($v) > 0)
				$citScore += 4;
			break;
		case "datasetContact":
			$v = $field->value ?? [];
			$ds->datasetContact = true;
			if (count($v) > 0)
				$citScore += 4;
			break;
		case "dsDescription":
			$v = $field->value ?? [];
			if (strlen($v[0]->dsDescriptionValue->value) > 0)
				$citScore += 4;
			break;
		case "author":
			$v = $field->value ?? [];
			if (count($v) > 0)
				$citScore += 4;
			break;
		case "subject":
			$v = $field->value ?? [];
			if (count($v) > 0)
				$citScore += 4;
			break;
		case "publication":
			$v = $field->value ?? [];
			if (count($v) > 0)
				$citScore += 4;
			break;
		case "keyword":
			$v = $field->value ?? [];
			if (count($v) > 0)
				$citScore += 4;
			break;
		case "depositor":
			$v = $field->value ?? "";
			if (strlen($v) > 0)
				$citScore += 4;
			break;
		case "dateOfDeposit":
			$v = $field->value ?? "";
			if (strlen($v) > 0)
				$citScore += 4;
			break;
		}
	}
	if ($citScore > 30) 
		$ds->score->metadata = MEGAVOTE;
	else if ($citScore > 24) 
		$ds->score->metadata = HIGHVOTE;
	else if ($citScore > 18)
		$ds->score->metadata = MEDIUMVOTE;	
	else if ($citScore > 12) 
		$ds->score->metadata = LOWVOTE;
	else 
		$ds->score->metadata = SCUMVOTE;
}

function checkDataAccess($ds) {					

/////////////////////////////////////////////////////////////////////////////////////
// This function checks the contact name when access restrictions are in place     //
//                                                                                 //
/////////////////////////////////////////////////////////////////////////////////////

	$ds->score->dataAccess = HIGHVOTE;
	if ($ds->fileAccessRequest) {
		if ((strlen($ds->termsOfAccess) < 4) || (!stripos($ds->termsOfAccess, "contact"))) {
			$ds->msg .= "Unclear Terms of Access, should specify Contact and clear terms of access -\n"; 	
			$ds->attention .= "!!!!";	
			$ds->score->dataAccess = LOWVOTE;
		}
	}	
}

function checkPublisher($ds) {					

/////////////////////////////////////////////////////////////////////////////////////
// This function checks the publisher                                              //
//                                                                                 //
/////////////////////////////////////////////////////////////////////////////////////

	$ds->score->publisher = HIGHVOTE;
	if ($ds->publisher <> ROOTPUBLISHER) {	
		$ds->msg .= "Correct publisher. Publisher not ".ROOTPUBLISHER.", it must be ".$d['publisher']." -\n"; 		
		$ds->score->publisher = LOWVOTE;	
	}
}

function checkFile($ds) {					

/////////////////////////////////////////////////////////////////////////////////////
// This function performs checks on deposited files                                //
//                                                                                 //
/////////////////////////////////////////////////////////////////////////////////////

	$ds->totalSize = 0;
	$ds->restricted = false; 	
	$ds->readme = false; 	
	$ds->score->file = HIGHVOTE;		

	foreach ($ds->files as $f) {
		$name 				= $f->label;
		$size				= (($f->dataFile->filesize)/1048576) ?? 0; // MB
		$ds->totalSize		+= $size;
		
		if (stripos($name,"read") !== false) {
			$ds->readme = true;	
		}
		
	// file restrictions      // 
		if (($f->restricted) && (!$ds->datasetContact)) {
			$ds->restricted = true;
			$ds->msg .= "The dataset has files with restricted access but it is not correctly instructed -\n"; 	
			$ds->attention .= "!!!!";
			$ds->score->file = LOWVOTE;
		}
	}

	// check README          // 
	if (!$ds->readme) {
		$ds->msg .= "Missing Readme file -\n"; 	
		$ds->score->file = LOWVOTE;
	}

	// check total file size // 
	if (($ds->totalSize > MAXMB)  && ($ds->versionState == "DRAFT")) {
		$ds->msg .= "Dataset is not published and has ".number_format($ds->totalSize, 0, ',', '.' )."MB -\n"; 	
		$ds->attention .= "!!!!";
		$ds->score->file = LOWVOTE;
	}

	// check activity on non-published datasets // 
	if ((count($ds->files) > 10) && ($ds->versionState == "DRAFT")) {
		$ds->msg .= "Dataset is not published and has - ".count($ds->files)." files -\n"; 	
		$ds->attention .= "!!!!";
		$ds->score->file = LOWVOTE;
	}
}

function checkUser($ds, $users) {
	$contacts = [];
	if (defined('T_UNBLOCK'))  {
		$fields = $ds->citations->fields ?? []; 
		foreach ($fields as $field) {
			if ($field->typeName == "datasetContact") {
				$values = $field->value;
				foreach ($values as $value) {
					if (isset($value->datasetContactName)) {
						$contacts[] = $value->datasetContactName->value;
					}
				}
			}
		}
	}
	$score = MEDIUMVOTE;
	foreach ($contacts as $contact) {
		foreach($users as $user) {
			if (((stripos($contact, $user->lastName) !== false ) && (stripos($contact, $user->firstName) !== false)) && ($user->authenticationProvider == "oauth2"))  {
				$score = HIGHVOTE;				
			}
		}
	}
	$ds->score->user = $score;
}

?>