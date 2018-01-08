<?php
/*
 * First authored by Brian Cray
 * License: http://creativecommons.org/licenses/by/3.0/
 * Contact the author at http://briancray.com/
 */

ini_set('display_errors', 0);
if (!preg_match('|^[0-9a-zA-Z]{1,6}$|', $_GET['short_id']))
	{
	die('That is not a valid short url');
}

require ('config.php');
$short_id=$_GET['short_id'];
$crccount= abs(crc32($_GET['short_id']));
$mod = $crccount % 100;

if (CACHE){
	$long_url = file_get_contents(CACHE_DIR . $shortened_id);
	if (empty($long_url) || !preg_match('|^https?://|', $long_url) || !preg_match('|^http?://|', $long_url))
		{
		$long_url = mysql_result(mysql_query('SELECT long_url FROM ' . DB_TABLE . $mod . ' WHERE id="' . mysql_real_escape_string($short_id) . '"'), 0, 0);
		@mkdir(CACHE_DIR, 0777);
		$handle = fopen(CACHE_DIR . $shortened_id, 'w+');
		fwrite($handle, $long_url);
		fclose($handle);
	}
}else{
	$long_url = mysql_result(mysql_query('SELECT long_url FROM ' . DB_TABLE . $mod . ' WHERE id="' . mysql_real_escape_string($short_id) . '"'), 0, 0);
}
if(TRACK){
	mysql_query('UPDATE ' . DB_TABLE . $mod . ' SET referrals=referrals+1 WHERE id="' . mysql_real_escape_string($short_id) . '"');
}

header('HTTP/1.1 301 Moved Permanently');
header('Location: ' . $long_url);
exit;