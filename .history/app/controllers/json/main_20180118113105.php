<?php

/*
 * @Author: ydk2 (me@ydk2.tk)
 * @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-09-26 07:32:35
 */
namespace App\Controllers\JSON;

use \Library\Core\Helper as Helper;


class Main extends \library\Core\Controller
{
    public function __construct($model)
    {
        parent::__construct($model);

        $this->auth = $this->model->auth;
        //$this->auth->install();
        if (isset($this->model->guid)) $this->guid = $this->model->guid;
        $this->groups = array("admin", "user", "editor", "mod");
        if (isset($this->model->uid)) $this->uid = $this->model->uid;
        $g = $this->GetAccess(2, TRUE);
        $e = $this->isEnabled(TRUE);
        
        $this->test();

        //$this->error = $this->auth->error;
        if (!$this->error) $this->error = 0;
        if ($this->error > 0) $this->error = 501;
                //$this->ViewData('error', $this->error);
        if ($this->error) {
                    //$this->Error();
            $this->throwError($this->Error());
        }

        $this->Run();
    }
    public function Error()
    {
        $this->model->appid = '';
        $this->model->scope = 'Error';
        $this->model->request = '{"Error"}';
        $this->model->response = 'Something wrong';
        $this->model->error = $this->error;
        $error = $this->View('/app/views/' . $this->model->theme . '/shared/e');
        return $error;
    }

    public function Run()
    {

    //var_dump($this->model);
    //$this->ViewData('testing', 'ddd');
    //Inc('test/views/test/view','.html');  

        //var_dump($g);
        //var_dump($this->error);
        //$this->Run();

        $p = ROOT . DS . 'p.cache';
        $a = array(
            array('id' => 1, 'name' => 'theme', 'string' => 'default')
        );
        $c = new \Library\Core\Cache();
        //if($c->write($p,$a))
        $r = $c->read($p);
        
        //$c->set($r,0,array('group'=>'one'));
        //$c->set($r,count($r)+1,array('group'=>'one'));

        $this->ViewData('test', $c->get($r, 1)['string']);
        //$c->write($p,$r);

        //$data = array('type'=>'sqlite','database'=>'db','user'=>$user,'pass'=>$pass);

        //$db = new \Library\Core\DB;
        //$db->Connect(DBTYPE, DBNAME, DBUSER, DBPASS, DBHOST);
        /* */
        //var_dump($db->db);
        /* *
        $db->createTable('accounts_token', array(
            'client_id VARCHAR(255) NOT NULL',
            'access_token VARCHAR(255) NOT NULL PRIMARY KEY',
            'user_id VARCHAR(255)',
            'expires TIMESTAMP NOT NULL',
            'scope VARCHAR(4000)'

        ), FALSE);

        $insert = [
            'ctime' => time(),
            'login' => 'bbb',
            'email' => 'me@ydk2.tk',
            'pass' => hash('sha256', 'bbbbb')
        ];
        $update = [
            'role' => 'admin',
            'role_id' => 0
        ];
        $db->TInsertIF('accounts', $insert, " WHERE email='me@ydk2.tk'");
        //$db->TUpdate('accounts',$update,"WHERE id=1");
        //$data = $db->TSelect('accounts');
        //$browser = $_SERVER['HTTP_USER_AGENT'];
       // var_dump($browser);

        $sessionid = session_id();
        $token = "";
        $request = FALSE;
       //if(empty($a)) session_start();
       //echo "SID: ".SID."<br>session_id(): ".session_id()."<br>COOKIE: ".$_COOKIE["PHPSESSID"];
        /* */

        /*
        $user = $db->TSelect('accounts', $scope, 'WHERE ' . $scope[1] . '=?', [$insert[$scope[1]]]);

        if ($user && isset($user[0])) {

            $this->auth = ['*'];
            $check_token = $db->TSelect('accounts_token', $this->auth, 'WHERE user_id=?', [$user[0]['id']]);
            if (!$check_token) {
                $token = bin2hex(openssl_random_pseudo_bytes(32));
                $tu = [
                    'client_id' => $sessionid,
                    'access_token' => $token,
                    'user_id' => $user[0]['id'],
                    'scope' => json_encode($scope),
                    'expires' => date('Y-m-d H:i:s',time()+(3600*24))
                ];
                $set_token = $db->TInsertUpdate('accounts_token', $tu);
            } else {
                $token = $check_token[0]['access_token'];
            }
        }
         */
        //$request = $db->Query("SHOW COLUMNS FROM accounts_token WHERE Field='access_token'");
        /* *
        $this->auth = ['*'];
        $token = Helper::Get('access_token');
        $appid = 'bbj377hnm6sn49i998jrgbr33m';
        list($user_id, $access_token) = explode(',', base64_decode($token));
        $check_token = $db->TSelect('accounts_token', $this->auth, 'WHERE client_id=? AND user_id=? AND access_token=?', [$appid, $user_id, $token]);
        
        if ($check_token) {
            $expires = $check_token[0]['expires'];
            $scope = json_decode($check_token[0]['scope'],TRUE);
            $token = $check_token[0]['access_token'];
            $user = $db->TSelect('accounts', $scope, 'WHERE id=?', [$check_token[0]['user_id']]);

            if ($user && isset($user[0]) && (strtotime($expires) > time())) {
                $request = $user[0];
            }
            else {
                //header('location: ?path=login');
                $this->error = 401;
            }
        }
        else {
            //$token = $check_token[0]['access_token'];
            //header('location: ?path=login');
            $this->error = 401;
        }
        /* */

        //require_once "./lauth.php";

        $this->auth = $this->model->auth;
        
        $this->ViewData('scope', json_encode($this->auth->scope));
        //$this->auth->install();

        $this->auth->request($this->model->before, array($this, 'test'));
        //$request = $check_token;
        $this->ViewData('expires', $this->auth->is_expires);

        $this->ViewData('request', json_encode($this->auth->request));
        //$this->ViewData('data',json_encode($db->db->Query("SHOW TABLES")->fetchAll(\PDO::FETCH_NAMED)));

        $this->ViewData('appid', $sessionid);
        if ($this->auth->access_token) $this->ViewData('access_token', $this->auth->access_token);

        $request_headers = getallheaders();
        $origin = $request_headers['appid'];
        $this->ViewData('response', json_encode($this->auth->response));
        //$this->ViewData('response', $this->auth->decode(sha1($appid), $this->auth->encode(sha1($appid), '<a href="?access_token=' . $this->auth->token . '&logout=true">logout</a>')));
        //$this->ViewData('data',json_encode($db->listTables()));
        /* */
        //$d->dropTable('test');

        //var_dump($this->auth);
        //var_dump(array_flip(get_class_methods($d)));
        if (Helper::Get('logout') == 'true') {
            $this->auth->deauthorize();
        }
        if($this->ext == '.php')
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime(__FILE__)) . ' GMT', true, $this->auth->error);

        $this->ViewData('error', $this->auth->error);
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