<?php
require_once "../bootstrap.php";
require_once (dirname(__FILE__) . DS . 'config.php');

use \Library\Core\Helper as Helper;

\Library\Core\Session::Start();

$theme = "default";

$model = new \Library\Core\Data;

$model->ext = '.php';
$model->theme = $theme;
$model->guid = "mod";
$model->uid = 4;
$model->enabled = array(
    "app/controllers/json/main",
    "app/controllers/json/login",
    "app/controllers/json/time",
    "app/controllers/json/connect",
    "app/controllers/json/langs",
    "app/controllers/json/e"
);

$model->db = new \Library\Core\DB;
$model->db->Connect(DBTYPE, DBNAME, DBUSER, DBPASS, DBHOST);
Cors();
$render = new \Library\Core\Controller($model);
//$render->Show("/theme/views/" . $theme . "/theme/header");
if (Helper::Get('path')) {
    $view = $render->Views('/app/views/' . $theme . '/json' . Helper::Get('path') . '');
    if ($view) {
        echo $view;
    }
    else {
        $model->header = '404 Not found';
        $model->message = 'View cannot be found';
        $model->error = 404;
        $render->Show('/app/views/' . $theme . "/shared/e.json");
    }
}
else {
    $render->Show('/app/views/' . $theme . '/json/main.json');
}
//$render->Show("/theme/views/" . $theme . "/theme/footer");
function Cors(){
    $request_headers = getallheaders();
    $origin = $request_headers['Origin'];
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Max-Age: 1000");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
    header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
}
?>