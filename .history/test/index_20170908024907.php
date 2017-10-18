<?php
require_once "../index.php";

use \Library\Core\Helper as Helper;

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
       // $render->ViewData('header','404 Not found');
        //$render->ViewData('message','View cannot be found');
        //$render->throwError('View cannot be found');
        $model->header = '404 Not found';
        $model->message = 'View cannot be found';
        $render->Show('/test/views/' . $theme . '/test/e');
    }
}
else {
    $render->Show('/test/views/' . $theme . '/test/two');
}
//$footer = $render->newController("/Theme/Controllers/Theme/Footer", 'default');
//$footer = new \Theme\Controllers\Theme\Footer($theme);
$render->Show("/theme/views/" . $theme . "/theme/footer");


?>