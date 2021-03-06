<?php
require_once "../bootstrap.php";
require_once(dirname(__FILE__).DS.'config.php');

use \Library\Core\Helper as Helper;

$theme = "default";

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
$render->Show("/theme/views/" . $theme . "/theme/header");

if (Helper::Get('path')) {
    $view = $render->View('/test/views/' . $theme . '/test'. Helper::Get('path').'');
    if ($view) {
        echo $view;
    }
    else {
        $model->header = '404 Not found';
        $model->message = 'View cannot be found';
        $render->Show('/test/views/' . $theme . '/test/e');
    }
}
else {
    $render->Show('/test/views/' . $theme . '/test/main');
}
$render->Show("/theme/views/" . $theme . "/theme/footer");

?>