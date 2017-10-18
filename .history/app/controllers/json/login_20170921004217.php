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

        $insert = [
            'account_ctime' => time(),
            'account_login' => 'admin',
            'account_email' => 'info@ydk2.tk',
            'account_pass' => hash('sha256', 'admin')
        ];
        $sessionid = session_id();
        $token = "";
        $request = FALSE;
        //var_dump($sessionid);
        /* */

        $scope = ['id', 'account_login', 'account_email', 'account_born', 'account_role'];
        $this->ViewData('scope', json_encode($scope));
        //var_dump(hash('sha256',Helper::Post($scope[3])));

        $appid = 'bbj377hnm6sn49i998jrgbr33m';
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

        $this->ViewData('test', 'jest viewdata');
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
<?php
class lAuthConf
{
    public $appid;
    public $token;
    public $scope;
    public $userid;
    public $expires;
    public $secret;
    public $request;
}

class lAuth
{
    public $appid;
    public $token;
    public $scope;
    public $userid;
    public $expires;
    public $secret;
    public $request;

    private $db;

    public function __construct(lAuthConf $config)
    {
        try {
            $this->db = new \Library\Core\DB;
            $this->db->Connect(DBTYPE, DBNAME, DBUSER, DBPASS, DBHOST);
            if ($this->db) {
                $this->appid = $config->appid;
                $this->scope = $config->scope;
                $this->userid = $config->userid;
                $this->request = $config->request;
                $this->expires = $config->expires;
            }
            else {
                return NULL;
            }
        } catch (\Exception $e) {
            return NULL;
        }
    }

    public function login()
    {
        //$sessionid = session_id();
        $token = "";
        $request = FALSE;
        //var_dump($sessionid);
        /* */

        $scope = ['id', 'account_login', 'account_email', 'account_born', 'account_role'];
        $this->ViewData('scope', json_encode($scope));
        //var_dump(hash('sha256',Helper::Post($scope[3])));

        $appid = 'bbj377hnm6sn49i998jrgbr33m';
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
    }

    public function logout()
    {

    }

    public function request()
    {

    }

    public function token()
    {
        $token = bin2hex(openssl_random_pseudo_bytes(32));
        $access_token = base64_encode($this->userid . ',' . $token);
        $tu = [
            'client_id' => $this->appid,
            'access_token' => $access_token,
            'user_id' => $this->userid,
            'scope' => json_encode($this->scope),
            'expires' => date('Y-m-d H:i:s', time() + (3600))
        ];
        $set_token = $this->db->TInsertUpdate('accounts_token', $tu, " WHERE user_id='" . $this->userid . "' AND client_id='" . $this->appid . "'");
        $this->token = $access_token;
    }

    public function install()
    {
        if ($this->db) {
            $this->db->createTable('accounts_token', array(
                'client_id VARCHAR(255) NOT NULL',
                'access_token VARCHAR(255) NOT NULL PRIMARY KEY',
                'user_id VARCHAR(255)',
                'expires TIMESTAMP NOT NULL',
                'scope VARCHAR(4000)',
                'secret VARCHAR(80)'
            ), FALSE);
        }
    }
}

?>