<?php
namespace Library\Core;

use \Library\Core\Helper as Helper;

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
    public $access_token;
    public $scope;
    public $userid;
    public $expires;
    public $secret;
    public $request;
    public $response;
    public $domain;
    public $error = 0;

    private $db;

    public function __construct($config = array())
    {
        try {
            $this->db = new \Library\Core\DB;
            $this->db->Connect(DBTYPE, DBNAME, DBUSER, DBPASS, DBHOST);
            if ($this->db) {
                $this->appid = (isset($config['appid'])) ? $config['appid'] : NULL;
                $this->scope = (isset($config['scope'])) ? $config['scope'] : array();
                $this->token = (isset($config['token'])) ? $config['token'] : NULL;
                $this->request = (isset($config['request'])) ? $config['request'] : NULL;
                $this->expires = (isset($config['expires'])) ? $config['expires'] : 3600;
                $this->domain = (isset($config['domain'])) ? $config['domain'] : NULL;
                $this->secret = (isset($config['secret'])) ? $config['secret'] : NULL;
            }
            else {
                $this->userid = NULL;
                $this->token = NULL;
                $this->request = NULL;
                $this->response = NULL;
                $this->secret = NULL;
                $this->error = 450;
                return NULL;
            }
        } catch (\Exception $e) {
            $this->userid = NULL;
            $this->token = NULL;
            $this->request = NULL;
            $this->response = NULL;
            $this->secret = NULL;
            $this->error = 451;
            return NULL;
        }
    }

    public function authorize($login, $password, $force = FALSE)
    {
        $token = "";
        $request = FALSE;
        $user = $this->db->TSelect('accounts', $this->scope, 'WHERE account_login=? OR account_email=? AND account_pass=?', [$login, $login, hash('sha256', $password)]);

        if ($user && isset($user[0])) {
            $this->userid = $user[0]['id'];

            $auth = ['*'];
            $expires = time() - 60;
            $check_token = $this->db->TSelect('accounts_token', $auth, 'WHERE user_id=? AND client_id=?', [$this->userid, $this->appid]);
            if ($check_token) {
                $expires = $check_token[0]['expires'];
            }
            if (!$check_token || (strtotime($expires) < time()) || $force) {
                $this->error = 0;
                $this->generate();
            }
            else {
                $this->error = 0;
                //$this->token = $check_token[0]['access_token'];
                $this->token = base64_encode($this->userid . ',' .$check_token[0]['access_token']);
            }
        }
        else {
            $this->error = 401;
        }
    }

    public function deauthorize()
    {
        $expires = date('Y-m-d H:i:s', (time() - 60));
        $del_token = $this->db->TUpdate('accounts_token',array('expires'=>$expires) 'WHERE client_id=? AND user_id=?', [$this->appid, $this->userid]);
        if ($del_token) {
            $this->userid = NULL;
            $this->token = NULL;
            $this->request = NULL;
            $this->response = NULL;
            $this->secret = NULL;
            $this->error = 401;
        }
        else {
            $this->error = 400;
        }
    }

    public function deauthorizeall()
    {
        $del_token = $this->db->TDelete('accounts_token', 'user_id=?', [$this->userid]);
        if ($del_token) {
            $this->userid = NULL;
            $this->token = NULL;
            $this->request = NULL;
            $this->response = NULL;
            $this->secret = NULL;
            $this->error = 401;
        }
        else {
            $this->error = 400;
        }
    }

    public function deauthorizeapp()
    {
        $del_token = $this->db->TDelete('accounts_token', 'client_id=?', [$this->appid]);
        if ($del_token) {
            $this->userid = NULL;
            $this->token = NULL;
            $this->request = NULL;
            $this->response = NULL;
            $this->secret = NULL;
            $this->error = 401;
        }
        else {
            $this->error = 400;
        }
    }

    public function request($fn=NULL)
    {
        $auth = ['*'];
        $token = $this->token;
        list($user_id, $access_token) = explode(',', base64_decode($token));
        $check_token = $this->db->TSelect('accounts_token', $auth, 'WHERE client_id=? AND user_id=? AND access_token=?', [$this->appid, $user_id, $access_token]);

        if ($check_token) {
            $expires = $check_token[0]['expires'];
            $scope = json_decode($check_token[0]['scope'], TRUE);
            $token = $check_token[0]['access_token'];
            $user = $this->db->TSelect('accounts', $scope, 'WHERE id=?', [$check_token[0]['user_id']]);

            if ($user && isset($user[0]) && (strtotime($expires) >= time())) {  
                if(isset($user['account_pass'])) unset($user['account_pass']);
                $this->userid = $user_id;
                $this->request = $user[0];
                $this->error = 0;
                if(is_callable($fn)){
                    $this->response = call_user_func_array($fn, array($this->request, $expires));
                }
            }
            else {
                $this->error = 402;
            }
        }
        else {
            $this->error = 401;
        }
    }

    public function regenerate($force=FALSE)
    {
        $auth = ['*'];
        $token = $this->token;
        list($user_id, $access_token) = explode(',', base64_decode($token));
        $check_token = $this->db->TSelect('accounts_token', $auth, 'WHERE client_id=? AND user_id=? AND access_token=?', [$this->appid, $user_id, $access_token]);

        if ($check_token) {
            $expires = $check_token[0]['expires'];
            $scope = json_decode($check_token[0]['scope'], TRUE);
            $user = $this->db->TSelect('accounts', $scope, 'WHERE id=?', [$check_token[0]['user_id']]);

            if ($user && isset($user[0]) && (strtotime($expires) >= time()) || $force) { 
                $this->userid = $user_id;
                $this->generate();
            }
            else {
                $this->error = 402;
            }
        }
        else {
            $this->error = 401;
        }
    }

    public function generate()
    {
        try {
            $token = bin2hex(openssl_random_pseudo_bytes(32));
            $access_token = base64_encode($this->userid . ',' . $token);
            $tu = [
                'client_id' => $this->appid,
                'secret' => $this->secret,
                'domain' => $this->domain,
                'access_token' => $token,
                'user_id' => $this->userid,
                'scope' => json_encode($this->scope),
                'expires' => date('Y-m-d H:i:s', time() + ($this->expires))
            ];
            $set_token = $this->db->TInsertUpdate('accounts_token', $tu, " WHERE user_id='" . $this->userid . "' AND client_id='" . $this->appid . "'");
            $this->token = $access_token;
            $this->error = 0;
        } catch (\Exception $e) {
            $this->error = 440;
            $this->userid = NULL;
            $this->token = NULL;
            $this->request = NULL;
            $this->response = NULL;
            $this->secret = NULL;
        }
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
                'secret VARCHAR(80)',
                'domain VARCHAR(255)'
            ), FALSE);
        }
    }

    public function encode($key, $string)
    {
        $encoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
        return $encoded;
    }

    public function decode($key, $encoded)
    {
        $decoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encoded), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
        return $decoded;
    }
}

?>