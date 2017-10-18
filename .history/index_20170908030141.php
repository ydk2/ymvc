<?php
error_reporting(1);
define('DBDEBUG', 1);
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

/*
define('ROOT', realpath(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);
*/
require_once "bootstrap.php";


?>
<?php
/*
use \Theme\Controllers\Theme as theme;
use \Test\Controllers as app;
use \test\controllers\test as test;

$data = new \Library\Core\Data();
 */

use \Library\Core\Helper as Helper;

$theme = "default";

//$header = new theme\Header($theme);
//Inc('/Library/Core/mainController');
//Inc('/Library/Core/Data');
$model = new \Library\Core\Data;

$model->theme = $theme;
$model->guid = "mod";
$model->uid = 4;
$model->enabled = array(
    "test/controllers/test/two",
    "test/controllers/test/one",
    "test/controllers/test/error"
);

//var_dump($model);


//var_dump($test);
?>