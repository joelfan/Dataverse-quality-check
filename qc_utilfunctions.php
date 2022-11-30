<?php 

///////////////////////// UTILITY FUNCTIONS /////////////////

// This function calls the server to get data
function webGet($u) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$u);
	curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 0);
	if (defined('PROXY'))  
		curl_setopt($ch, CURLOPT_PROXY, PROXY);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
	curl_setopt($ch, CURLOPT_HEADER, false);
	$text = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);
	if ($info['http_code'] < 300) return($text); else return(false);
}

// This function writes a message to the log and to the screen
function echoLog ($string) {
	file_put_contents(T_LOG, date('Ymd:H:i:s')." ".$string."\n", FILE_APPEND);
	echo $string."\n";
}
?>