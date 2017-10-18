<?php

error_reporting(1);
define('DBDEBUG', 1);
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
/* */
define('DBTYPE','mysql');


if (DBTYPE=='sqlsrv') {
    define('DBNAME','e');
    define('DBHOST','localhost');
    define('DBUSER','ydk2');
    define('DBPASS','8378');
}
if (DBTYPE=='mysql') {
    if($_SERVER['SERVER_NAME'] == 'truckdriver.eu'){
        define('DBNAME','truckdri_mapsec');
        define('DBHOST','localhost');
        define('DBUSER','truckdri_root');
        define('DBPASS','Vp42y44qLo');
    } else {
        define('DBNAME','truckdri_mapsec');
        define('DBHOST','localhost');
        define('DBUSER','root');
        define('DBPASS','8378');
    }
}
if (DBTYPE=='pgsql') {
    define('DBNAME','e');
    define('DBHOST','localhost');
    define('DBUSER','postgres');
    define('DBPASS','8738');
}
if (DBTYPE=='sqlite') {
    define('DBNAME','database');
    define('DBHOST','library');
    define('DBUSER','');
    define('DBPASS','');
}

define('S',"-");
define('DISTANCE',300);

define('DEBUG',null);
define('MEDIA_LEN',100);
define('INDEX', 'start');
define('LANG', 'en');
define('DBPREFIX', '');

?>