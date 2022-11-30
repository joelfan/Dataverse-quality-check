<?php 

function getUsList() {

/////////////////////////////////////////////////////////////////////////////////////
// This function return the list of users                                          //
//                                                                                 //
/////////////////////////////////////////////////////////////////////////////////////

	$start = $pageCount = 0; 
	$perPage = PERPAGE; 
	$u = T_URL.'admin/list-users?itemsPerPage=10000&'.T_APIK.'&'.T_UNBLOCK;
	$pageString = webGet($u);
	if ($pageString) $page = json_decode($pageString);
	$total = $page->data->userCount ?? 0; 
	$usList = [];
	foreach($page->data->users as $user) {
		$us = new stdClass(); 
		$us->id = $user->id;
		$us->userIdentifier = $user->userIdentifier;
		$us->lastName = $user->lastName;
		$us->firstName = $user->firstName;
		$us->email = $user->email;
		$us->isSuperuser = $user->isSuperuser;
		$us->authenticationProvider = $user->authenticationProvider;
		$usList[] = $us;
	}
	return($usList);
}

function getDsList() {					

/////////////////////////////////////////////////////////////////////////////////////
// This function return the list of published dataset                              //
//                                                                                 //
/////////////////////////////////////////////////////////////////////////////////////

	$start = $pageCount = 0; 
	$perPage = PERPAGE; 
	if (defined('MAXITEMS')) $perPage = MAXITEMS; 
	$u = T_URL.'search?q=*&type=dataset&per_page=0&start=0&'.T_APIK;
	$pageString = webGet($u);
	if ($pageString) $page = json_decode($pageString);
	$total = $page->data->total_count ?? 0; 
	if (defined('MAXITEMS')) $total = MAXITEMS; 
	$dsList = [];
	while ($pageCount < $total) {
		//$u = T_URL.'search?q=*&type=dataset&show_entity_ids=true&per_page='.$perPage.'&start='.$pageCount.'&'.T_APIK;
		$u = T_URL.'search?q=*&type=dataset&show_entity_ids=true&per_page='.$perPage.'&start='.$pageCount;
		$pageString = webGet($u);
		$page = json_decode($pageString);
		$pageCount += $perPage;
		foreach($page->data->items as $i) {
			$ds = new stdClass(); 
			$ds->identifier_of_dataverse = $i->identifier_of_dataverse;
			$ds->name_of_dataverse = $i->name_of_dataverse;
			$ds->global_id = $i->global_id;
			$ds->entity_id = $i->entity_id;
			$dsList[] = $ds;
		}
	}
	return($dsList);
}

function checkDsList($dsList, $users) {				

/////////////////////////////////////////////////////////////////////////////////////
// This function return the list of published dataset                              //
// Starting from the list produced with getDsList, this function harvests          //
// all the detailed data for each datasets	                                       //
// then it calls checkDs(), that is the function that checks the quality           //
//                                                                                 //
/////////////////////////////////////////////////////////////////////////////////////

	$outString = "";
	foreach($dsList as $i) {
		//$u = T_URL.'datasets/'.$i->entity_id.'?'.T_APIK;
		$u = T_URL.'datasets/'.$i->entity_id;
		$pageString = webGet($u);
		if ($pageString) $page = json_decode($pageString);
		$status	= $page->status ?? ""; 
		if ($status == 'OK') {
			$ds = $page->data;
			$ds->{"name_of_dataverse"} = $i->name_of_dataverse;   			
			$ds->{"identifier_of_dataverse"} = $i->identifier_of_dataverse; 
			$ds->{"global_id"} = $i->global_id;								
			$ds->{"entity_id"} = $i->entity_id;								
			checkDs($ds, $users);
		}
	}
}

?>