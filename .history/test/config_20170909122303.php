<?php
/* */
define('DBTYPE','sqlite');


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
        define('DBNAME','e');
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
    define('DBNAME','e');
    define('DBHOST','localhost');
    define('DBUSER','');
    define('DBPASS','');
}

define('S',"-");
define('DISTANCE',300);
/* *

define('DBTYPE','pgsql');
define('DBNAME','ymvc');
define('DBHOST','localhost');
define('DBUSER','postgres');
define('DBPASS','8738');
/* */


/* *

define('DBTYPE','sqlite');
define('DBNAME','database');
/* */

?>