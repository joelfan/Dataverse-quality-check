<?php
//                     D. BASSET 2022 - Dataverses and datasets quality check                             //
////////////////////// Step 0 - Initialize /////////////////////////////////////////////////////////////////
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

require_once("./qc_constants.php"); 
require_once("./qc_listfunctions.php"); 
require_once("./qc_qualityfunctions.php"); 
require_once("./qc_printfunctions.php"); 
require_once("./qc_utilfunctions.php"); 
scratchFiles();


////////////////////// Step 1 - START /////////////////// //////////////////////////////////////////////////
$executionStartTime = microtime(true);
echoLog("Starting quality check for datasets and files"); 
$usList = getUsList(); 

////////////////////// Step 2 - Retrieve datasets   list  //////////////////////////////////////////////////
$dsList = getDsList(); 
echoLog ("We shall go trough ".count($dsList)." Datasets.");

////////////////////// Step 3 - Check datasets   metadata and data /////////////////////////////////////////
checkDsList($dsList, $usList);
echoLog("Quality check done."); 

////////////////////// Step 4 - Wrap up ////////////////////////////////////////////////////////////////////
$seconds = microtime(true) - $executionStartTime;
echoLog ("This script took ".number_format($seconds,3,',','.')." seconds to execute.");
echoLog ("That's all folks"); 
exit(0);
?>