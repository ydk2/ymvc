<?php
require_once "../bootstrap.php";
require_once(dirname(__FILE__).DS.'config.php');

use \Library\Core\Helper as Helper;
\Library\Core\Session::Start();

$theme = "default";

$model = new \Library\Core\Data;

$model->ext = '.json';
$model->theme = $theme;
$model->guid = "mod";
$model->uid = 4;
$model->enabled = array(
    "app/controllers/json/main",
    "app/controllers/json/login",
    "app/controllers/json/e"
);

$render = new \Library\Core\Controller($model);
//$render->Show("/theme/views/" . $theme . "/theme/header");

if (Helper::Get('path')) {
    $view = $render->View('/app/views/' . $theme . '/json/'. Helper::Get('path').'');
    if ($view) {
        echo $view;
    }
    else {
        $model->header = '404 Not found';
        $model->message = 'View cannot be found';
        $model->error = 404;
        $render->Show('/app/views/' . $theme . "/json/e");
    }
}
else {
    $render->Show('/app/views/' . $theme . '/json/main');
}
//$render->Show("/theme/views/" . $theme . "/theme/footer");

function encode($key,$string){
    $encoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
    return $encoded;
}
function decode($key,$encoded){
    $decoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encoded), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
    return $decoded;
}
?>