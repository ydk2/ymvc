<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
* @Last Modified by: ydk2 (me@ydk2.tk)
* @Last Modified time: 2017-10-03 00:41:31
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
        //$this->access = 3;
        $this->data->attr = array(
        '@attributes'=>array(
        'type'=>'ddd',
        'name'=>'main'
        ),
        'test');
        
        $this->Run();
        
    }
    public function Error()
    {
        $this->model->appid = NULL;
        $this->model->scope = 'Error';
        $this->model->request = '{"Error"}';
        $this->model->response = 'Something wrong';
        $this->model->error = $this->error;
        $error = $this->View('/app/views/' . $this->model->theme . '/shared/e.json');
        return $error;
    }
    public function Run()
    {
        
        //var_dump($this->model);
        //$this->ViewData('testing', 'ddd');
        //Inc('test/views/test/view','.html');
        //$db = new \Library\Core\DB;
        //$db->Connect(DBTYPE, DBNAME, DBUSER, DBPASS, DBHOST);
        //$g=$this->GetAccess(2,TRUE);
        //$e=$this->isEnabled(TRUE);
        //var_dump($g);
        //var_dump($this->error);
        
        $db = $this->model->db;
        $admin = [
        'ctime' => time(),
        'login' => 'admin',
        'email' => 'info@ydk2.tk',
        'pass' => hash('sha256', '1AdmIn0Oaz'),
        'role' => 'admin',
        'role_id' => 1
        ];
        $bbb = [
        'ctime' => time(),
        'login' => 'bbb',
        'email' => 'me@ydk2.tk',
        'pass' => hash('sha256', 'bbbbb')
        ];
        //$db->TInsert('accounts',$bbb);
        
        $sessionid = session_id();
        $access_token = "";
        $request = FALSE;
        
        
        
        $scope = ['id', 'login', 'email', 'born', 'role'];
        $this->ViewData('scope', json_encode($scope));
        $auth = $this->model->auth;
        
        if (Helper::Get('logout') == 'true') {
            $auth->deauthorize();
        }
        if (Helper::Get('authorize') == 'true') {
            $auth->authorizeapp();
        }
        if (Helper::Get('authorize') == 'false') {
            $auth->deauthorizeapp();
        }
        
        $auth->isEnabled();
        
        
        if (Helper::Post('appid') && $auth->error == 406) {
            $auth->authorizeapp();
            //$auth->request();
        }
        
        //if(!$auth->error)
        //$auth->regenerate();
        $test = 0;
        if (!$this->model->isAjax()) {
            $this->ViewData('has-message','Enter login data');
            $login = Helper::Post('login');
            $pass = Helper::Post('pass');
            if(!empty($_POST)){
                if(Helper::Validate($login,'email')){
                    $this->ViewData('has-email','has-success');
                    $this->ViewData('has-email-sign','fa-check');
                    $test += 1;
                } else {
                    $this->ViewData('has-email','has-error');
                    $this->ViewData('has-email-sign','fa-exclamation');
                }
                
                if(Helper::Validate($pass,'alphanum')){
                    $this->ViewData('has-pass','has-success');
                    $this->ViewData('has-pass-sign','fa-check');
                    $test += 1;
                } else {
                    $this->ViewData('has-pass','has-error');
                    $this->ViewData('has-pass-sign','fa-exclamation');
                }

                if(1 >= $test) $this->ViewData('has-message','Fill all fields');
            }
        }
        
        if ($auth->error != 200) {
            $auth->authorize(Helper::Post('login'), Helper::Post('pass'));
            if(2 === $test) $this->ViewData('has-message','Incorrect login data');
        }
        if ($auth->error == 200 && $auth->access_token){
            $auth->response();
            
            if (!$this->model->isAjax()) {
                header('Location: '.HOST.'?access_token='.$auth->access_token);
                exit();
            }
        } else {
            
        }
        
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime(__FILE__)).' GMT', true, $auth->error);
        
        $sendedid = Helper::Post('appid');
        
        $this->ViewData('appid', $sendedid);
        //$this->ViewData('token', $auth->token);
        if($auth->access_token) $this->ViewData('access_token', $auth->access_token);
        $this->ViewData('expires', $auth->is_expires);
        
        $this->ViewData('error', $auth->error);
        
        $this->ViewData('request', json_encode($auth->request));
        $this->ViewData('response', '{}');
        
        $this->ViewData('post', $_POST);
        $this->ViewData('host', HOST);
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