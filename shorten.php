<?php
/*
 * First authored by Brian Cray
 * License: http://creativecommons.org/licenses/by/3.0/
 * Contact the author at http://briancray.com/
 */

ini_set('display_errors', 0);
$long_url=$_REQUEST['long_url'];
$long_url=urldecode($long_url);
$url_to_shorten = get_magic_quotes_gpc() ? stripslashes(trim($long_url)) : trim($long_url);
if (!empty($url_to_shorten) && preg_match('|^https?://m.ceeety.com|', $url_to_shorten))
	{
	require ('config.php');
	// check if the client IP is allowed to shorten
	if ($_SERVER['REMOTE_ADDR'] != LIMIT_TO_IP)
		{
		die('You are not allowed to shorten URLs with this service.');
	}
	//check if the URL is valid
	if (CHECK_URL)
		{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url_to_shorten);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($ch);
		$response_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if ($response_status == '404')
			{
			die('Not a valid URL');
		}

	}

	//$randpwd .= chr(mt_rand(33, 126));
	$short_id = getShortenedURL($url_to_shorten);  //生成6位短链接
	//取余
	$mod = abs(crc32($short_id)) % 100;
	
	//查询6位短连接是否存在
		$url = "";
		mysql_query('LOCK TABLES ' . DB_TABLE . ' WRITE;');
		$already_shortened = mysql_result(mysql_query('SELECT id FROM ' . DB_TABLE . $mod . ' WHERE id= "' . $short_id . '"'), 0, 0);
		if ($already_shortened == false) {  //id不存在库中，查询表是否存在，不存在插入表
			$hastab = mysql_result(mysql_query('SELECT table_name FROM information_schema.TABLES WHERE table_name ="' . DB_TABLE . $mod . '"'), 0, 0);
			if ($hastab == false) { 	//表不存在时,创建表'
				$sql = "CREATE TABLE " . DB_TABLE . $mod . " (
			id CHAR (10) NOT NULL,
			long_url VARCHAR (512) NOT NULL,
			created INT (10) UNSIGNED NOT NULL,
			creator CHAR (15) NOT NULL,
			referrals int(10) NOT NULL default '0',
			PRIMARY KEY (id)
		) ENGINE = MyISAM DEFAULT CHARSET = utf8;";
				mysql_select_db(DB_NAME);
				mysql_query($sql);
			}
			mysql_query('INSERT INTO ' . DB_TABLE . $mod . ' (id,long_url, created, creator) VALUES ("' . $short_id . '","' . mysql_real_escape_string($url_to_shorten) . '", "' . time() . '", "' . mysql_real_escape_string($_SERVER['REMOTE_ADDR']) . '")');
			mysql_query('UNLOCK TABLES');
		}
		$str = Array(
		    'short_id' => $short_id,
		    'short_url' => BASE_HREF . $short_id,
		    'long_url' => $url_to_shorten,
		);
        //echo $url_to_shorten;
		echo json_encode($str);
	}

function getShortenedURL($url, $base = ALLOWED_CHARS)
{

	$url = crc32($url);
	$result = sprintf("%u", $url);
	$sUrl = '';
	while ($result > 0) {
		$s = $result % 62;
		if ($s > 35) {
			$s = chr($s + 61);
		}
		elseif ($s > 9 && $s <= 35) {
			$s = chr($s + 55);
		}
		$sUrl .= $s;
		$result = floor($result / 62);
	}
	return $sUrl;
}
