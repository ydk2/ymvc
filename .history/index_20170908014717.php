<?php
error_reporting(1);
define('DBDEBUG', 1);
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

define('ROOT', realpath(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);

function Loader($class, $ext = ".php")
{
    $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . DIRECTORY_SEPARATOR . $class) . $ext);
    if (file_exists($filename) && is_file($filename)) {
        require_once ($filename);
    }
    //echo $filename."<br/>";

}

function Inc($class, $ext = ".php")
{
    $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . $class) . $ext);
    if (file_exists($filename) && is_file($filename)) {
        require_once ($filename);
        return TRUE;
    }
    return FALSE;
}

function View($view, $ext = ".php")
{
    try {
        ob_start();
        $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . $view) . $ext);
        if (file_exists($filename) && is_file($filename)) {
            require ($filename);
        }
        return ob_get_clean();
    } catch (\Exception $e) {
        return $e->getCode();
    }
}

spl_autoload_register('Loader');

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

$render = new \Library\Core\Controller($model);

//$header = $render->newController("/Theme/Controllers/Theme/Header", 'default');
//$header = new \Theme\Controllers\Theme\Header($theme);
$render->Show("/theme/views/" . $theme . "/theme/header");

//$render->Show('/test/views/' . $theme . '/test/one');
//$render->Show('/test/views/' . $theme . '/test/two');
if (Helper::Get('path')) {
    $view = $render->View('/test/views/' . $theme . Helper::Get('path'));
    if ($view) {
        echo $view;
    }
    else {
        $render->Show('/test/views/' . $theme . '/test/two');
    }
}
else {
    $render->Show('/test/views/' . $theme . '/test/error');
}
//$footer = $render->newController("/Theme/Controllers/Theme/Footer", 'default');
//$footer = new \Theme\Controllers\Theme\Footer($theme);
$render->Show("/theme/views/" . $theme . "/theme/footer");



//var_dump($test);
?>