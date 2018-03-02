<?php

error_reporting(1);
//define('DBDEBUG', 1);
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
/* */
define('DBTYPE','mysql');

if (DBTYPE=='mysql') {
    define('DBNAME','ymvc');
    define('DBHOST','localhost');
    define('DBUSER','root');
    define('DBPASS','8378');
}
define('DBPREFIX', '');

?>