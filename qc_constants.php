<?php
// Votes
$config = parse_ini_file("qc.ini");

// The following are the constants for scoring. Votes are 1 to 5, with 5 the best
define("SCUMVOTE", $config['SCUMVOTE']); 
define("LOWVOTE", $config['LOWVOTE']); 
define("MEDIUMVOTE", $config['MEDIUMVOTE']); 
define("HIGHVOTE", $config['HIGHVOTE']);
define("MEGAVOTE", $config['MEGAVOTE']);

// MAXMB is the number of MegaBytes that a dataset should not overcome
define("MAXMB", $config['MAXMB']); 
// When you want to limit the job for testing purposes, put this value, otherwise comment the line.
// define("MAXITEMS", 10); 						// limit list just for debugging purposes
define("PROXY", 'proxy.unimi.it:8080'); 		// just in case the configuration has a proxy. 
define("PERPAGE", 100); 						// limit returned list in a request

// output files
define("TXTDS_OUT", $config['TXTDS_OUT']); 
define("CSVDS_OUT", $config['CSVDS_OUT']);
define("T_LOG", $config['T_LOG']);

// CSV delimiters
define("DLM", '"'); 
define("SPT", '";"');

// Some configuration, as specified in qc.ini
if (!isset($config['T_URL']))
	exit("Check your qc.ini; T_URL is mandatory!\n");
if (!isset($config['T_DVURL']))
	exit("Check your qc.ini; T_DVURL is mandatory!\n");
if (!isset($config['ROOTPUBLISHER']))
	exit("Check your qc.ini; ROOTPUBLISHER is mandatory!\n");
if (!isset($config['ROOTDV']))
	exit("Check your qc.ini; ROOTDV is mandatory!\n");
if (!isset($config['DEPTDV']))
	exit("Check your qc.ini; DEPTDV is mandatory!\n");
define("T_URL", $config['T_URL']);
define("T_DVURL", $config['T_DVURL']);
define("ROOTDV", $config['ROOTDV']);
define("DEPTDV", $config['DEPTDV']);
define("ROOTPUBLISHER", $config['ROOTPUBLISHER']);
define("T_APIK", $config['T_APIK']);
define("T_UNBLOCK", $config['T_UNBLOCK']);
?>