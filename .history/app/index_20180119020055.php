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

$body = new \Library\Core\Render($model);
$body->ext = '.xsl';

$mode = "/json/";
if($model->ext == ".xsl"){
    $mode = "/xsl/";
} 

$render->ext = $model->ext;

//if($model->ext == ".xsl")
//$body->Show("/theme/views/" . $model->theme . "/theme/header");

if (Helper::Get('path')) {
    $view = $render->View('/app/views/' . $model->theme.$mode . Helper::Get('path') . '');
    if(!$view){
        $model->header = '404 Not found';
        $model->response = 'View cannot be found';
        $model->error = 404;
        $view = $render->View('/app/views/' . $model->theme . "/shared/e");
    }
} else {
    //$render->ext = NULL;
    $view = $render->View('/app/views/' . $model->theme.$mode.'main');
}

if(!$model->isAjax()){
    $body->ViewData('contents',$view);
    $body->Show("/theme/views/" . $model->theme . "/theme");
} 
if($model->isAjax()){
    echo $view;
}
//$body->Show("/theme/views/" . $model->theme . "/theme/footer");

?>