<?php
namespace App\Controllers\JSON;

use \Library\Core\Helper as Helper;


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
                //$this->userid = $config->userid;
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
        $token = "";
        $request = FALSE;
        $user = $this->db->TSelect('accounts', $this->scope, 'WHERE account_login=? OR account_email=? AND account_pass=?', [Helper::Post('account_login'), Helper::Post('account_login'), hash('sha256', Helper::Post('account_pass'))]);
 
        if ($user && isset($user[0])) {
            $this->userid = $user[0]['id'];
            $auth = ['*'];
            $expires = time() - 60;
            $check_token = $this->db->TSelect('accounts_token', $auth, 'WHERE user_id=? AND client_id=?', [$this->userid, $this->appid]);
            if ($check_token) {
                $expires = $check_token[0]['expires'];
            }
            if (!$check_token || (strtotime($expires) < time())) {
                $this->token();
            }
            else {
                $this->token = $check_token[0]['access_token'];
            }
        }
    }

    public function logout()
    {

    }

    public function request()
    {
        $auth = ['*'];
        $token = Helper::Request('access_token');
        list($user_id, $access_token) = explode(',', base64_decode($token));
        $check_token = $this->db->TSelect('accounts_token', $auth, 'WHERE client_id=? AND user_id=? AND access_token=?', [$this->appid, $user_id, $token]);
        
        if ($check_token) {
            $expires = $check_token[0]['expires'];
            $scope = json_decode($check_token[0]['scope'],TRUE);
            $token = $check_token[0]['access_token'];
            $user = $this->db->TSelect('accounts', $scope, 'WHERE id=?', [$check_token[0]['user_id']]);

            if ($user && isset($user[0]) && (strtotime($expires) > time())) {
                $this->request = $user[0];
            }
            else {
                $this->error = 401;
            }
        }
        else {
            $this->error = 401;
        }
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