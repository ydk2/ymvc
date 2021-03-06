<?php
require_once "../bootstrap.php";
require_once(dirname(__FILE__).DS.'config.php');

use \Library\Core\Helper as Helper;

$theme = "default";

//$header = new theme\Header($theme);
//Inc('/Library/Core/mainController');
//Inc('/Library/Core/Data');
$model = new \Library\Core\Data;

$model->ext = '.html';
$model->theme = $theme;
$model->guid = "mod";
$model->uid = 4;
$model->enabled = array(
    "test/controllers/test/main",
    "test/controllers/test/two",
    "test/controllers/test/one",
    "test/controllers/test/error"
);

$render = new \Library\Core\Controller($model);

//$header = $render->newController("/Theme/Controllers/Theme/Header", 'default');
//$header = new \Theme\Controllers\Theme\Header($theme);
$render->Show("/theme/views/" . $theme . "/theme/header");

//$render->Show('/test/views/' . $theme . '/test/one');
//$render->Show('/test/views/' . $theme . '/test/two');
if (Helper::Get('path')) {
    $view = $render->View('/test/views/' . $theme . '/test'. Helper::Get('path').'');
    if ($view) {
        echo $view;
    }
    else {
       // $render->ViewData('header','404 Not found');
        //$render->ViewData('message','View cannot be found');
        //$render->throwError('View cannot be found');
        $model->header = '404 Not found';
        $model->message = 'View cannot be found';
        $render->Show('/test/views/' . $theme . '/test/e');
    }
}
else {
    $render->Show('/test/views/' . $theme . '/test/main');
}
//$footer = $render->newController("/Theme/Controllers/Theme/Footer", 'default');
//$footer = new \Theme\Controllers\Theme\Footer($theme);
$render->Show("/theme/views/" . $theme . "/theme/footer");

?>