<?php
error_reporting(1);
define('DBDEBUG', 1);
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

define('ROOT', realpath(dirname(__FILE__)));

function Loader($class, $ext = ".php")
{
    $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . $class) . $ext);
    if (file_exists($filename) && is_file($filename)) {
        require_once ($filename);
    }
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
$theme = "/default";

//$header = new theme\Header($theme);
//Inc('/Library/Core/mainController');
//Inc('/Library/Core/Data');

//$render = new \Library\Core\Render();
$render = new \Library\Core\mainController('default');

$header = $render->newController("/Theme/Controllers/Theme/Header", 'default');
//$header->Show();

echo $render->View('/test/views' . $theme . '/test/one', '.html');

$footer = $render->newController("/Theme/Controllers/Theme/Footer", 'default');
//$footer->View($footer->view,'.html');
//$footer->View('theme/views/v52/footer','.html');


//$footer = new theme\Footer($theme);

//var_dump($test);
?>