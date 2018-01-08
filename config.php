<?php
/*
 * First authored by Brian Cray
 * License: http://creativecommons.org/licenses/by/3.0/
 * Contact the author at http://briancray.com/
 */

// db options
define('DB_NAME', 'ceeety_shorturl');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'db01.ceeety.com');
define('DB_TABLE', 'shorturl_');

// connect to database
mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_select_db(DB_NAME);

// base location of script (include trailing slash)
define('BASE_HREF', 'http://ceeety.com/');

// change to limit short url creation to a single IP
define('LIMIT_TO_IP', $_SERVER['REMOTE_ADDR']);

// change to TRUE to start tracking referrals
define('TRACK', TRUE);

// check if URL exists first
define('CHECK_URL', true);

// change the shortened URL allowed characters
define('ALLOWED_CHARS', '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

// do you want to cache?
define('CACHE', true);

// if so, where will the cache files be stored? (include trailing slash)
define('CACHE_DIR', dirname(__FILE__) . '/cache/');
