<?php
require_once "../bootstrap.php";
require_once (dirname(__FILE__) . DS . 'config.php');

use \Library\Core\Helper as Helper;

\Library\Core\Session::Start();

$theme = "default";

//$model = new \Library\Core\Data;
$model = new \App\Models\Model();
$model->Cors();
$render = new \Library\Core\Controller($model);
//$render->Show("/theme/views/" . $theme . "/theme/header");
if (Helper::Get('path')) {
    $view = $render->View('/app/views/' . $model->theme . '/json' . Helper::Get('path') . '');
    if ($view) {
        echo $view;
    }
    else {
        $model->header = '404 Not found';
        $model->message = 'View cannot be found';
        $model->error = 404;
        $render->Show('/app/views/' . $model->theme . "/shared/e.json");
    }
}
else {
    $render->Show('/app/views/' . $model->theme . '/json/main.json');
}
//$render->Show("/theme/views/" . $theme . "/theme/footer");

?>