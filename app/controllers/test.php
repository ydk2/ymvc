<?php
/*
 * @Author: ydk2 (info@ydk2.tk)
 * @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
 */
namespace App\Controllers;

use \Library\Core\Helper;
use \Library\Core\Render;
use \Library\Core\Cookie;
use \Library\Core\Session;
use \Library\Helpers\Files;

class Test extends Render
{
    public function __construct($model)
    {
        parent::__construct($model);

        $this->auth = $this->model->auth;

        if(isset($this->model->guid)) $this->guid = $this->model->guid;
        $this->groups = array("admin", "user", "editor", "mod");
        if(isset($this->model->uid)) $this->uid = $this->model->uid;
        //$g = $this->GetAccess(2,TRUE);
        $e = $this->isEnabled(TRUE);


        //$this->error = $this->auth->error;
        if (!$this->error) $this->error = 0;
        if ($this->error>0) $this->error = 501;
        $this->ViewData('error', $this->error);
        if ($this->error) {
            $this->throwError($this->Error());
        } else {
            $this->Run();
        }

        
    }

    private function a(){
        $db = $this->model->db;
        /* */
        $db->TcreateTable('test_accounts', array(
            'login VARCHAR(255) UNIQUE',
            'pass VARCHAR(255)',
            "role VARCHAR(255) DEFAULT 'user'",
            "active INT NOT NULL DEFAULT 1",
            "online INT NOT NULL DEFAULT 1",
            'scope VARCHAR(4000)'

        ), TRUE,'user_id','INT');

        //$sql = "CREATE TABLE T2 (c1 int PRIMARY KEY, c2 varchar(50) SPARSE NULL);";
        //var_dump($db->exec($sql));
        /* */
        /* *
        $db->TcreateTable('test_accounts', array(
            'login VARCHAR(255) UNIQUE',
            'pass VARCHAR(255)',
            "role VARCHAR(255) DEFAULT 'user'",
            "active BOOLEAN NOT NULL DEFAULT 1",
            "online BOOLEAN NOT NULL DEFAULT 1",
            'scope VARCHAR(4000)'

        ), FALSE,'user_id','INTEGER');
        * */
        /* */
        $db->TcreateTable('test_statistic', array(
            'lastseen VARCHAR(255)',
            'isnow VARCHAR(255)',
            'created VARCHAR(255)',
            'scope VARCHAR(4)',
            'user_id INT',
            'FOREIGN KEY (user_id) REFERENCES test_accounts(user_id)'
        ));
        /* */
        /* */
        $db->TcreateTable('test_token', array(
            'client_id VARCHAR(255) NOT NULL',
            'access_token VARCHAR(255) NOT NULL PRIMARY KEY',
            'user_id INT',
            'expires TIMESTAMP NOT NULL',
            'scope VARCHAR(4000)',
            'FOREIGN KEY (user_id) REFERENCES test_accounts(user_id)'

        ), FALSE);

        /* */

        /* */
        $db->TcreateTable('test_personal', array(
            'user_id INT',
            'username VARCHAR(255) NOT NULL',
            'firstname VARCHAR(255) NOT NULL',
            'lastname VARCHAR(255) NOT NULL',
            'FOREIGN KEY (user_id) REFERENCES test_accounts(user_id)'

        ), FALSE);
        /* */
        /* */
        $db->TcreateTable('test_user_data', array(
            'user_id INT',
            'name VARCHAR(255) NOT NULL',
            'value VARCHAR(255) NOT NULL',
            'scope VARCHAR(255) NOT NULL',
            'FOREIGN KEY (user_id) REFERENCES test_accounts(user_id)'

        ), FALSE);
        /* */

        $insert = [
            'login' => 'me@ydk2.tk',
            'pass' => hash('sha256', 'bbbbb')
        ];

        $config = [
            'user_id'   => 1,
            'name'      => 'test1',
            'value'     => 'testing1',
            'scope'     => 'settings'
        ];

        $update = [
            'user_id' => 1,
            'access_token' => 'dd356789cs0',
            'client_id' => 'user',
            'expires' => date('Y-m-d H:i:s',time()+(3600*24))
        ];
        $statistic = [
            //'user_id' => 1,
            //'created' => date('Y-m-d H:i:s',time()),
            'lastseen' => date('Y-m-d H:i:s',time())
        ];
        $db->TInsertUpdate('test_statistic', $statistic ,"WHERE user_id=1");
        $db->TInsertIF('test_accounts', $insert);
        $db->TInsertUpdate('test_token', $update ,"WHERE user_id=1 AND access_token=?",[$update['access_token']]);
    }

    function genHash($qtd){
        //Under the string $Caracteres you write all the characters you want to be used to randomly generate the code.
        $Characters = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
        $CharactersLen = strlen($Characters);
        $CharactersLen--;
        
        $Hash=NULL;
            for($x=1;$x<=$qtd;$x++){
                $Position = mt_rand(0,$CharactersLen);
                $Hash .= substr($Characters,$Position,1);
            }
        
        return $Hash;
    } 
        
    private function RandomToken($length = 32){
        if(!isset($length) || intval($length) <= 8 ){
          $length = 32;
        }
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        }
        if (function_exists('mcrypt_create_iv')) {
            return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
        }
        if (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($length));
        }
    }

    private function get_user_id($login=NULL,$pass=NULL){
        $db = $this->model->db;
        $user_id = $db->Select('test_accounts',['user_id'],'WHERE login=? AND pass=? AND online=1',[$login,hash('sha256', $pass)]);
        return intval(($user_id)?$user_id[0]['user_id']:0);
    }

    public function Run()
    {
        $db = $this->model->db;
        $this->ViewData('header','Test controller');
        $this->ViewData('host',HOST);
        
        //$this->a();
        
        $table = "ddddd";
        $string = "";
        $scope = [];
        $user_data = [];
        $user_id=$this->get_user_id('me@ydk2.tk','bbbbb');
        if(FALSE !== $user_id){
            
        }
        $this->ViewData('xml',$table);
        $this->ViewData('error',"1");
    }

    public function Error()
    {
        //header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime(__FILE__)).' GMT', true, $this->error);
        $this->model->appid = '';
        $this->model->scope = 'Error';
        $this->model->request = '{"Error"}';
        $this->model->response = 'Something wrong';
        $this->model->error = $this->error;
        $error = $this->View('/app/views/' . $this->model->theme . '/shared/e');
        return $error;
    }
}

class Encryption
{

    public static $pubkey = '';
    public static $privkey = '';

    public static function encrypt($data)
    {

        self::$pubkey = file_get_contents('public_key.pem');
        //self::$privkey = file_get_contents('private_key.pem');
        if (openssl_public_encrypt($data, $encrypted, self::$pubkey))
            $data = base64_encode($encrypted);
        else
            throw new Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');

        return $data;
    }

    public function decrypt($data)
    {
        //self::$pubkey = file_get_contents('public_key.pem');
        self::$privkey = file_get_contents('private_key.pem');
        if (openssl_private_decrypt(base64_decode($data), $decrypted, self::$privkey))
            $data = $decrypted;
        else
            $data = '';

        return $data;
    }
}
?>