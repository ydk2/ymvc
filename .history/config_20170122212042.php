<?php
/* */
define('DBTYPE','mysql');

if (DBTYPE=='sqlsrv') {
	define('DBNAME','ymvc');
	define('DBHOST','localhost');
	define('DBUSER','ydk2');
	define('DBPASS','8738');
}
if (DBTYPE=='mysql') {
	define('DBNAME','database');
	define('DBHOST','localhost');
	define('DBUSER','root');
	define('DBPASS','8738');
}
if (DBTYPE=='pgsql') {
	define('DBNAME','ymvc');
	define('DBHOST','localhost');
	define('DBUSER','postgres');
	define('DBPASS','8738');
}
if (DBTYPE=='sqlite') {
	define('DBNAME','database');
	define('DBHOST','localhost');
	define('DBUSER','');
	define('DBPASS','');
} 

define('S',"-");

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