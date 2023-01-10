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

// If you want to limit the job for testing purposes, put this value, otherwise comment the line.
// define("MAXITEMS", 10); 						// limit list just for debugging purposes

// If you have a proxy for outgoing call, set it here.
// define("PROXY", 'proxy.unimi.it:8080'); 		// just in case the configuration has a proxy. 

// If you want to set how many items return in a call, set it here. 
define("PERPAGE", 100); 						// limit returned list in a request

// Set the output files that contains results
define("TXTDS_OUT", $config['TXTDS_OUT']); 
define("CSVDS_OUT", $config['CSVDS_OUT']);
define("T_LOG", $config['T_LOG']);

// Set CSV delimiters
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

// 20230110 - filetypes
// Containers: TAR, GZIP, ZIP 
// Databases: XML, CSV, JSON 
// Geospatial: SHP, DBF, GeoTIFF, NetCDF 
// Video: MPEG, AVI, MXF, MKV, MP4 
// Sounds: WAVE, AIFF, MP3, MXF, FLAC 
// Statistics: DTA, POR, SAS, SAV 
// Images: TIFF, JPEG 2000, PDF, PNG, GIF, BMP, SVG 
// Tabular data: CSV, TXT 
// Text: XML, PDF/A, HTML, JSON, TXT, RTF 
// Web archive: WARC 
define("FAIRTYPES", array(
			'tar', 'gzip', 'zip', 'xml', 'csv', 'json', 
			'shp', 'dbf', 'geotiff', 'netcdf', 'mpeg', 'md',
			'avi', 'mxf', 'mp4', 'mkv', 'shp', 'wav', 'wave', 'aiff', 'tab', 
			'mp3', 'flac', 'dta', 'por', 'sas', 'sav', 'tiff', 'jpg', 'jpeg', 'jpg2000', 
			'jpeg2000', 'pdf', 'png', 'gif', 'bmp', 'svg', 'txt', 'html', 'txt', 'rtf', 'warc'));

?>