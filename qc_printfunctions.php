<?php 

///////////////////////// PRINT   FUNCTIONS /////////////////
function printDs($ds) {

/////////////////////////////////////////////////////////////////////////////////////
// This function prints to files all the characteristics                           //
// of a dataset, including the score                                               //
// It write 2 files: 															   //
// 			a plain text file                                                      //
// 			a CSV file                                                             //
/////////////////////////////////////////////////////////////////////////////////////
	
	$outTextString = "**********************************************************************************\n";
	$outTextString .= "DATASET Id=".$ds->id." Name=".$ds->persistentUrl."\n";
	$outTextString .= "Publisher=".$ds->publisher."\n"; 
	$outTextString .= "Creation date=".$ds->createTime."\n";
	$outTextString .= "Version status=".$ds->versionState."\n";
	$outTextString .= "Publication status=".$ds->pubstatus."\n";
	$outTextString .= "Publication date=".$ds->pubDate."\n";
	$outTextString .= "License=".$ds->license."\n";
	$outTextString .= "Terms of use=".$ds->termsOfUse."\n";
	$outTextString .= "DOI=".$ds->doi."\n";	
	$outTextString .= "dataset Persistent ID=".$ds->datasetPersistentId."\n";	
	$outTextString .= "# of files=".$ds->filesNum."\n";	
	$outTextString .= "Total size of files in MB=".number_format($ds->totalSize, 3, ',', '.' )."\n";	
	$outTextString .= "Readme=".($ds->readme == true ? "YES" : "NO")."\n";	
	$outTextString .= "Entity ID=".$ds->entity_id."\n";	
	$outTextString .= "Global ID=".$ds->global_id."\n";	
	$outTextString .= "Identifier of container Dataverse=".$ds->identifier_of_dataverse."\n";	
	$outTextString .= "Name of container Dataverse=".$ds->name_of_dataverse."\n";	
	$outTextString .= "Terms of use=".$ds->termsOfUse."\n";	
	$outTextString .= "License=".$ds->license."\n";	
	$outTextString .= "Dataset contact=".($ds->datasetContact == true ? "OK" : "NONE")."\n";	
	$outTextString .= "Restricted=".($ds->restricted == true ? "YES" : "NO")."\n";	
	$outTextString .= "File access=".$ds->fileAccessRequest."\n";
	$outTextString .= "Last update=".$ds->lastUpdateTime."\n";	
	$outTextString .= "Creation=".$ds->createTime."\n";	
	$outTextString .= "MSG=".$ds->msg."\n";	
	$outTextString .= "ATTENTION=".$ds->attention."\n";	
	
	$outTextString .= "*** Score ***\n";	
	$outTextString .= "Position score \t\t= ".$ds->score->posit . "\n";	   
	$outTextString .= "Metadata score \t\t= ".$ds->score->metadata . "\n";	   
	$outTextString .= "Data access score \t= ".$ds->score->dataAccess . "\n";	   
	$outTextString .= "Publisher score \t= ".$ds->score->publisher . "\n";	   
	$outTextString .= "User score \t\t= ".$ds->score->user . "\n";	   
	$outTextString .= "File score \t\t= ".$ds->score->file . "\n";	   
	$outTextString .= "File type score \t\t= ".$ds->score->fairTypes . "\n";	   
	$outTextString .= "**********************************************************************************\n\n";
	
	file_put_contents(TXTDS_OUT, $outTextString, FILE_APPEND);

	// Secondly, let's write the CSV file.
	$avgscore = ($ds->score->posit + $ds->score->metadata + $ds->score->dataAccess + $ds->score->user + $ds->score->publisher + $ds->score->file + $ds->score->fairTypes) / 7;
	$row = 	DLM.SPT.
		$ds->id.SPT.
		$ds->persistentUrl.SPT.
		number_format($avgscore, 1, '.', ''  ).SPT.
		SPT.
		$ds->score->posit.SPT.
		$ds->score->metadata.SPT.
		$ds->score->dataAccess.SPT.
		$ds->score->user.SPT.
		$ds->score->publisher.SPT.		
		$ds->score->file.SPT.
		$ds->score->fairTypes.SPT.
		SPT.
		$ds->attention.SPT.
		str_replace("\n", " ", $ds->msg).SPT.
		$ds->pubstatus.SPT.
		$ds->pubDate.SPT.
		$ds->termsOfUse.SPT.
		$ds->license.SPT.
		$ds->restricted.SPT.
		$ds->fileAccessRequest.SPT.
		$ds->filesNum.SPT.
		number_format($ds->totalSize, 3, ',', '' ).SPT.
		//$ds->totalSize.SPT.
		$ds->readme.SPT.
		$ds->identifier_of_dataverse.SPT.
		$ds->name_of_dataverse.SPT.
		($ds->datasetContact == true ? "OK" : "NONE").
		DLM."\n";	
	
	file_put_contents(CSVDS_OUT, utf8_decode($row), FILE_APPEND);
}

function scratchFiles() {
	file_put_contents(T_LOG, ""); 
	$row = "Dataset analysis ".date('Ymd')."\n";
	file_put_contents(TXTDS_OUT, $row); 
	$row = DLM.
		SPT.
		"Id".SPT.
		"URL".SPT.
		"Score".SPT.
		SPT.
		"Pos score".SPT.
		"Met.score".SPT.
		"Access score".SPT.
		"User score".SPT.
		"Pub score".SPT.
		"File score".SPT.
		"FileTyp score".SPT.
		SPT.
		"!ATT!".SPT.
		"Message".SPT.
		"Published".SPT.
		"Pub date".SPT.
		"Terms of use".SPT.
		"License".SPT.
		"Restrict".SPT.
		"File Access".SPT.
		"# of files".SPT.
		"Size of files (MB)".SPT.
		"Readme".SPT.
		"Container ID".SPT.
		"Container name".SPT.
		"Dataset contact".
		DLM."\n";
	file_put_contents(CSVDS_OUT, $row); 
}

?>