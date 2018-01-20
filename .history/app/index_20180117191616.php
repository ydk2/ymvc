<?php
require_once "../bootstrap.php";
require_once (dirname(__FILE__) . DS . 'config.php');

use \Library\Core\Helper as Helper;

\Library\Core\Session::Start();

$theme = "default";

$data = new \Library\Core\Data;
$data->theme = $theme;
$model = new \App\Models\Model($data);


$model->Cors();
$render = new \Library\Core\Render($model);

$ext = "json";
if($model->ext == ".xsl"){
    $ext = "xsl";
} 

$render->ext = $model->ext;
//$render->Show("/theme/views/" . $theme . "/theme/header");
if (Helper::Get('path')) {
    $view = $render->View('/app/views/' . $model->theme . '/'.$ext . Helper::Get('path') . '');
    if ($view) {
        echo $view;
    }
    else {
        $model->header = '404 Not found';
        $model->message = 'View cannot be found';
        $model->error = 404;
        $render->Show('/app/views/' . $model->theme . "/shared/e.".$ext);
    }
}
else {
    //$render->ext = NULL;
    $render->Show('/app/views/' . $model->theme . '/'.$ext.'/xsl');
}
//$render->Show("/theme/views/" . $theme . "/theme/footer");

?>