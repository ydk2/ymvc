<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
*/
namespace App\Controllers\JSON;


class Main extends \library\Core\Controller
{   
    public function __construct($model){
        parent::__construct($model);
        //if(isset($this->model->guid)) $this->guid = $this->model->guid;
        $this->groups = array("admin","user","editor","mod");

        //$this->uid = 4;
        //if(isset($this->model->uid)) $this->uid = $this->model->uid;
        $this->access = 3;
        
        $g=$this->GetAccess(2,TRUE);
        $e=$this->isEnabled(TRUE);


        if(!$this->error) $this->error = 0;
        $this->ViewData('error',$this->error);
        if($this->error){
            //$this->Error();
            $this->throwError($this->Error());
        }

        $this->Run();
    }
    public function Error(){

        //$this->ViewData('header','Error '.$this->error);
        //$this->ViewData('message','Error throwed with success');
        
        $this->model->header = $this->error.' Error';
        $this->model->message = 'Something wrong';
        $this->model->error = $this->error;
        $error = $this->View('/app/views/'.$this->model->theme.'/json/e');
        return $error;
    }
    public function Run(){

    //var_dump($this->model);
    //$this->ViewData('testing', 'ddd');
    //Inc('test/views/test/view','.html');  

        //var_dump($g);
        //var_dump($this->error);
        //$this->Run();
        $p = ROOT.DS.'p.cache';
        $a = array(
            array('id'=>1,'name'=>'theme','string'=>'default')
        );
        $c = new \Library\Core\Cache();
        //if($c->write($p,$a))
        $r = $c->read($p);

        //$c->set($r,0,array('group'=>'one'));
        //$c->set($r,count($r)+1,array('group'=>'one'));

        $this->ViewData('test',$c->get($r,1)['string']);
        //$c->write($p,$r);

        //$data = array('type'=>'sqlite','database'=>'db','user'=>$user,'pass'=>$pass);

        $db = new \Library\Core\DB;
        $db->Connect(DBTYPE,DBNAME,DBUSER,DBPASS);
        /* */
        //var_dump($db->db);
        /* */
        $db->createTable('accounts_token',array(
            'client_id VARCHAR(255) NOT NULL',
            'access_token VARCHAR(255) NOT NULL PRIMARY KEY',
            'user_id VARCHAR(255)',
            'expires TIMESTAMP NOT NULL',
            'scope VARCHAR(4000)'

        ),FALSE);

        $insert = [
            'account_ctime'=>time(),
            'account_login'=>'admin',
            'account_email'=>'info@ydk2.tk',
            'account_pass'=>hash('sha256','admin')];
        $update = [
            'account_role'=>'admin',
            'account_role_id'=>0
        ];
        //$db->TInsertIF('accounts',$insert);
        //$db->TUpdate('accounts',$update,"WHERE id=1");
        //$data = $db->TSelect('accounts');
        //$browser = $_SERVER['HTTP_USER_AGENT'];
       // var_dump($browser);

       $sessionid = session_id();
       $token = bin2hex(openssl_random_pseudo_bytes(32));
       $request = FALSE;
       //if(empty($a)) session_start();
       //echo "SID: ".SID."<br>session_id(): ".session_id()."<br>COOKIE: ".$_COOKIE["PHPSESSID"];
        /* */
        $this->ViewData('appid',$sessionid);
        $this->ViewData('token',$token);

        $scope = ['id','account_login','account_email','account_pass'];
        $this->ViewData('scope',json_encode($scope));

        $user = $db->TSelect('accounts',$scope,'WHERE '.$scope[1].'=?',[$insert[$scope[1]]]);
        
        if($user){
            //$check_token = TSelect('accounts_token',$auth,'WHERE access_token=')
        }
        $request = $db->Query("SHOW COLUMNS FROM accounts_token WHERE Field='access_token'");


        $this->ViewData('request',json_encode($request));
        //$this->ViewData('data',json_encode($db->db->Query("SHOW TABLES")->fetchAll(\PDO::FETCH_NAMED)));

        //$this->ViewData('data',json_encode($db->listTables()));
        /* */
        //$d->dropTable('test');

        //var_dump($d->Select('users'));
        //var_dump(array_flip(get_class_methods($d)));

        if(!$this->error) $this->error = 0;
        $this->ViewData('error',$this->error);
        if($this->error){
            //$this->Error();
            $this->throwError($this->Error());
        }
    }
}
?>