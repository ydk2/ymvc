<?php
/*
 * @Author: ydk2 (me@ydk2.tk)
 * @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
 */
namespace App\Controllers\JSON;

use \Library\Core\Helper as Helper;

class Login extends \library\Core\Controller
{
    public function __construct($model)
    {
        parent::__construct($model);
        //if(isset($this->model->guid)) $this->guid = $this->model->guid;
        $this->groups = array("admin", "user", "editor");

        //$this->uid = 4;
        //if(isset($this->model->uid)) $this->uid = $this->model->uid;
        $this->access = 3;


        $this->Run();
    }
    public function Error()
    {
        $this->model->appid = NULL;
        $this->model->scope = 'Error';
        $this->model->request = '{"Error"}';
        $this->model->response = 'Something wrong';
        $this->model->error = $this->error;
        $error = $this->View('/app/views/' . $this->model->theme . '/json/e');
        return $error;
    }
    public function Run()
    {

    //var_dump($this->model);
    //$this->ViewData('testing', 'ddd');
    //Inc('test/views/test/view','.html');  
        $db = new \Library\Core\DB;
        $db->Connect(DBTYPE, DBNAME, DBUSER, DBPASS, DBHOST);
        //$g=$this->GetAccess(2,TRUE);
        //$e=$this->isEnabled(TRUE);
        //var_dump($g);
        //var_dump($this->error);

        $admin = [
            'account_ctime' => time(),
            'account_login' => 'admin',
            'account_email' => 'info@ydk2.tk',
            'account_pass' => hash('sha256', '1AdmIn0Oaz'),
            'account_role' => 'admin',
            'account_role_id' => 1
        ];
        $bbb = [
            'account_ctime' => time(),
            'account_login' => 'bbb',
            'account_email' => 'me@ydk2.tk',
            'account_pass' => hash('sha256', 'bbbbb')
        ];
        //$db->TInsert('accounts',$bbb);

        $sessionid = session_id();
        $token = "";
        $request = FALSE;
        //var_dump($sessionid);
        /* */
        $scope = ['id', 'account_login', 'account_email', 'account_born', 'account_role'];
        $this->ViewData('scope', json_encode($scope));
        //var_dump(hash('sha256',Helper::Post($scope[3])));

        $appid = 'bbj377hnm6sn49i998jrgbr33m';
        /*
        $user = $db->TSelect('accounts', $scope, 'WHERE account_login=? OR account_email=? AND account_pass=?', [Helper::Post('account_login'), Helper::Post('account_login'), hash('sha256', Helper::Post('account_pass'))]);
        //var_dump($user);
        if ($user && isset($user[0])) {
            $userid = $user[0]['id'];
            $auth = ['*'];
            $expires = time() - 60;
            $check_token = $db->TSelect('accounts_token', $auth, 'WHERE user_id=? AND client_id=?', [$userid, $appid]);
            if ($check_token) {
                $expires = $check_token[0]['expires'];
            }
            if (!$check_token || (strtotime($expires) < time())) {
                $token = bin2hex(openssl_random_pseudo_bytes(32));
                $access_token = base64_encode($userid . ',' . $token);
                $tu = [
                    'client_id' => $appid,
                    'access_token' => $access_token,
                    'user_id' => $userid,
                    'scope' => json_encode($scope),
                    'expires' => date('Y-m-d H:i:s', time() + (3600))
                ];
                $set_token = $db->TInsertUpdate('accounts_token', $tu, " WHERE user_id='$userid' AND client_id='$appid'");


                $this->ViewData('token', '?access_token=' . $access_token);
                //header('location: ?access_token='.$access_token);



            }
            else {
                $access_token = $check_token[0]['access_token'];
                $this->ViewData('token', '?access_token=' . $access_token);
                //header('location: ?access_token='.$access_token);



            }
        }
         */
        //require_once "./lauth.php";
        $conf = [
            'appid' => $appid,
            'scope' => $scope,
            'request' => NULL,
            'expires' => 3600 * 24,
            'token' => Helper::Request('access_token'),
            'autoupdate'=>TRUE
        ];


        $auth = new \Library\Core\lAuth($conf);
        //$auth->install();

        if (Helper::Get('logout') == 'true') {
            $auth->deauthorize();
        }
        if (Helper::Get('authorize') == 'true') {
            $auth->authorizeapp();
        }
        if (Helper::Get('authorize') == 'false') {
            $auth->deauthorizeapp();
        }
        
        $auth->request();
        //if(!$auth->error)
        //$auth->regenerate();
        if ($auth->error) {
            $auth->authorize(Helper::Post('account_login'), Helper::Post('account_pass'));
            if (!$auth->error)
                $auth->request();
        }

        $this->ViewData('appid', $sessionid);
        $this->ViewData('token', $auth->token);

        $this->ViewData('error', $auth->error);

        $this->ViewData('request', json_encode($auth->request));
        $this->ViewData('response', '<a href="?path=login&access_token=' . $auth->token . '&logout=true">logout</a>');
        
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

        //$this->ViewData('test', $c->get($r, 1)['string']);
        //$c->write($p,$r);

        //$data = array('type'=>'sqlite','database'=>'db','user'=>$user,'pass'=>$pass);
        
        /* *
        $d->createTable('tested',array(
            'name VARCHAR(255)',
            'string VARCHAR(255)'

        ));
        $d->TInsertIF('tested',array('name'=>'info','string'=>'text'));
         * */
        //$d->dropTable('test');

        //var_dump($d->Select('users'));
        //var_dump(array_flip(get_class_methods($d)));

        if ($this->error) {
            //$this->Error();
            $this->throwError($this->Error());
        }
    }
}

?>