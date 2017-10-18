<?php

/*
 * @Author: ydk2 (me@ydk2.tk)
 * @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-09-26 07:32:35
 */
namespace App\Controllers\JSON;

use \Library\Core\Helper as Helper;


class Langs extends \library\Core\Controller
{
    public function __construct($model)
    {
        parent::__construct($model);
        //if(isset($this->model->guid)) $this->guid = $this->model->guid;
        $this->groups = array("admin", "user", "editor", "mod");

        //$this->uid = 4;
        //if(isset($this->model->uid)) $this->uid = $this->model->uid;
        $this->access = 3;

        $g = $this->GetAccess(2, TRUE);
        $e = $this->isEnabled(TRUE);


        if (!$this->error) $this->error = 0;
        $this->ViewData('error', $this->error);
        if ($this->error) {
            //$this->Error();
            $this->throwError($this->Error());
        }

        $this->Run();
    }
    public function Error()
    {
        $this->model->appid = NULL;
        $this->model->scope = 'Error';
        $this->model->request = '{"Error"}';
        $this->model->response = 'Something wrong';
        $this->model->error = $this->error;
        $error = $this->View('/app/views/' . $this->model->theme . '/shared/e');
        return $error;
    }
    public function Run()
    {

        $db = new \Library\Core\DB;
        $db->Connect(DBTYPE, DBNAME, DBUSER, DBPASS, DBHOST);

        $scope = ['id'];
        $appid = 'bbj377hnm6sn49i998jrgbr33m';

        $this->ViewData('scope', json_encode($scope));

        $conf = [
            'appid' => $appid,
            'scope' => $scope,
            'request' => NULL,
            'expires' => 3600*1,
            'token' => Helper::Request('access_token'),
            'autoupdate'=>FALSE
        ];

        $auth = new \Library\Core\lAuth($conf);
        $auth->request(10*60,array($this, 'test'));
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime(__FILE__)).' GMT', true, $auth->error);
        //$request = $check_token;
        $this->ViewData('expires', $auth->is_expires);
        
        $this->ViewData('request', json_encode($auth->request));
        //$this->ViewData('data',json_encode($db->db->Query("SHOW TABLES")->fetchAll(\PDO::FETCH_NAMED)));

        $this->ViewData('appid', $sessionid);
        $this->ViewData('token', $auth->token);
        if($auth->access_token) $this->ViewData('access_token', $auth->access_token);

        $request_headers = getallheaders();
        $origin = $request_headers['appid'];
        $this->ViewData('response', json_encode(array("appidh"=>$origin)));
        //$this->ViewData('response', $auth->decode(sha1($appid), $auth->encode(sha1($appid), '<a href="?access_token=' . $auth->token . '&logout=true">logout</a>')));
        //$this->ViewData('data',json_encode($db->listTables()));
        /* */
        //$d->dropTable('test');

        //var_dump($auth);
        //var_dump(array_flip(get_class_methods($d)));
        if (Helper::Get('logout') == 'true') {
            $auth->deauthorize();
        }

        $this->ViewData('error', $auth->error);
        if (!$this->error) $this->error = 0;
        //$this->ViewData('error', $this->error);
        if ($this->error) {
            //$this->Error();
            $this->throwError($this->Error());
        }
    }

    function test($test, $obj)
    {
        //var_dump($obj);
        return $test;
    }

}
function timestamp($date, $slash_time = true, $timezone = 'Europe/London', $expression = "#^\d{2}([^\d]*)\d{2}([^\d]*)\d{4}$#is")
{
    $return = false;
    $_timezone = date_default_timezone_get();
    date_default_timezone_set($timezone);
    if (preg_match($expression, $date, $matches))
        $return = date("Y-m-d " . ($slash_time ? '00:00:00' : "h:i:s"), strtotime(str_replace(array($matches[1], $matches[2]), '-', $date) . ' ' . date("h:i:s")));
    date_default_timezone_set($_timezone);
    return $return;
}
?>