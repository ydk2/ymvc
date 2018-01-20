<?php
/*
 * Created on Thu Oct 05 2017
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 ydk2
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Library;

use \Library\Core\Helper as Helper;

class Auth
{
    private $appid;
    protected $userid;
    protected $secret;
    public $scope;
    protected $domain;
    
    public $error = 0;
    public $access_token;
    public $expires;
    public $is_expires;
    public $request;
    public $response;
    public $autoupdate = FALSE;

    private $db;

    public function __construct($config = array())
    {
        try {
            $this->db = new \Library\PDOHelper;
            $this->db->Connect(DBTYPE, DBNAME, DBUSER, DBPASS, DBHOST);
            if ($this->db) {
                $this->appid = (isset($config['appid'])) ? $config['appid'] : NULL;
                $this->scope = (isset($config['scope'])) ? $config['scope'] : array();
                $this->access_token = (isset($config['access_token'])) ? $config['access_token'] : NULL;
                $this->request = (isset($config['request'])) ? $config['request'] : NULL;
                $this->expires = (isset($config['expires'])) ? $config['expires'] : 3600;
                $this->domain = (isset($config['domain'])) ? $config['domain'] : NULL;
                $this->secret = (isset($config['secret'])) ? $config['secret'] : NULL;
                $this->autoupdate = (isset($config['autoupdate'])) ? $config['autoupdate'] : FALSE;
                $this->error = 201;
                if($this->appid==NULL || empty($this->scope)){
                    $this->error = 506;
                }
            }
            else {
                $this->userid = NULL;
                $this->access_token = NULL;
                $this->request = NULL;
                $this->response = NULL;
                $this->secret = NULL;
                $this->error = 501;
                //return NULL;
            }
        } catch (\Exception $e) {
            $this->userid = NULL;
            $this->access_token = NULL;
            $this->request = NULL;
            $this->response = NULL;
            $this->secret = NULL;
            $this->error = 507;
            //return NULL;
        }
    }

    final public function authorize($login, $password, $force = TRUE)
    {
        if(in_array($this->error,[501,506,507])){
            return NULL;
        }
        $enable = $this->db->TCount('accounts_token', 'WHERE client_id=?', [$this->appid]);
        if (!$enable) {
            $this->error = 406;
            return NULL;
        }
        $access_token = "";
        $request = FALSE;
        $user = $this->db->TSelect('accounts', array('*'), "WHERE (login=? OR email=?) AND pass=?", [$login, $login, hash('sha256', $password)]);
        //var_dump($password);
        if ($user && isset($user[0])) {
            $this->userid = $user[0]['id'];

            $auth = ['*'];
            $expires = time() - 60;
            $check_access_token = $this->db->TSelect('accounts_token', $auth, 'WHERE user_id=? AND client_id=?', [$this->userid, $this->appid]);
            if ($check_access_token) {
                $expires = $check_access_token[0]['expires'];
                $this->is_expires = $check_access_token[0]['expires'];
            }
            if (!$check_access_token || (strtotime($expires) < time()) || $force) {
                $this->error = 200;
                $this->generate();
            }
            else {
                $this->error = 200;
                $this->access_token = base64_encode($this->userid . ',' . $check_access_token[0]['access_token']);
                
            }
        }
        else {
            
            $this->access_token = NULL;
            $this->error = 403;
        }
    }

    final public function authorizebyhash($login, $hash, $force = TRUE)
    {
        if(in_array($this->error,[501,506,507])){
            return NULL;
        }

        $enable = $this->db->TCount('accounts_token', 'WHERE client_id=?', [$this->appid]);
        if (!$enable) {
            $this->error = 406;
            return NULL;
        }
        $access_token = "";
        $request = FALSE;
        $user = $this->db->TSelect('accounts', array('*'), "WHERE (login=? OR email=?) AND pass=?", [$login, $login, $hash]);
        //var_dump($password);
        if ($user && isset($user[0])) {
            $this->userid = $user[0]['id'];

            $auth = ['*'];
            $expires = time() - 60;
            $check_access_token = $this->db->TSelect('accounts_token', $auth, 'WHERE user_id=? AND client_id=?', [$this->userid, $this->appid]);
            if ($check_access_token) {
                $expires = $check_access_token[0]['expires'];
                $this->is_expires = $check_access_token[0]['expires'];
            }
            if (!$check_access_token || (strtotime($expires) < time()) || $force) {
                $this->error = 200;
                $this->generate();
            }
            else {
                $this->error = 200;
                $this->access_token = base64_encode($this->userid . ',' . $check_access_token[0]['access_token']);
                
            }
        }
        else {
            
            $this->access_token = NULL;
            $this->error = 403;
        }
    }

    final public function authorizeid($id, $force = TRUE)
    {
        if(in_array($this->error,[501,506,507])){
            return NULL;
        }

        $enable = $this->db->TCount('accounts_token', 'WHERE client_id=?', [$this->appid]);
        if (!$enable) {
            $this->error = 406;
            return NULL;
        }
        $access_token = "";
        $request = FALSE;
        $user = $this->db->TSelect('accounts', array('*'), "WHERE id=?", [$id]);
        if ($user && isset($user[0])) {
            $this->userid = $user[0]['id'];

            $auth = ['*'];
            $expires = time() - 60;
            $check_access_token = $this->db->TSelect('accounts_token', $auth, 'WHERE user_id=? AND client_id=?', [$this->userid, $this->appid]);
            if ($check_access_token) {
                $expires = $check_access_token[0]['expires'];
                $this->is_expires = $check_access_token[0]['expires'];
            }
            if (!$check_access_token || (strtotime($expires) < time()) || $force) {
                $this->error = 200;
                $this->generate();
            }
            else {
                $this->error = 200;
                $this->access_token = base64_encode($this->userid . ',' . $check_access_token[0]['access_token']);
                
            }
        }
        else {
            
            $this->access_token = NULL;
            $this->error = 403;
        }
    }

    final public function deauthorize()
    {
        if(in_array($this->error,[501,506,507])){
            return NULL;
        }

        $expires = date('Y-m-d H:i:s', (time() - 60));
        $access_token = $this->access_token;
        list($user_id, $access_token) = explode(',', base64_decode($access_token));
        $deauthorize = $this->db->TUpdate('accounts_token', array('expires' => $expires), 'WHERE client_id=? AND user_id=? AND access_token=?', [$this->appid, $user_id, $access_token]);
        if ($deauthorize) {
            $this->userid = NULL;
            
            $this->access_token = NULL;
            $this->request = NULL;
            $this->response = NULL;
            $this->secret = NULL;
            $this->error = 403;
        }
        else {
            $this->error = 405;
        }
    }

    final public function forcedeauthorize()
    {
        if(in_array($this->error,[501,506,507])){
            return NULL;
        }

        $expires = date('Y-m-d H:i:s', (time() - 60));
        $deauthorize = $this->db->TUpdate('accounts_token', array('expires' => $expires), 'WHERE client_id=? AND user_id=?', [$this->appid, $this->userid]);
        if ($deauthorize) {
            $this->userid = NULL;
            
            $this->access_token = NULL;
            $this->request = NULL;
            $this->response = NULL;
            $this->secret = NULL;
            $this->error = 403;
        }
        else {
            $this->error = 405;
        }
    }

    final public function deauthorizeall()
    {
        if(in_array($this->error,[501,506,507])){
            return NULL;
        }

        $expires = date('Y-m-d H:i:s', (time() - 60));
        $access_token = $this->access_token;
        list($user_id, $access_token) = explode(',', base64_decode($access_token));
        $deauthorize = $this->db->TUpdate('accounts_token', array('expires' => $expires), 'WHERE client_id=? AND user_id=? AND access_token=?', [$this->appid, $user_id, $access_token]);
        if ($deauthorize) {
            $this->userid = NULL;
            
            $this->access_token = NULL;
            $this->request = NULL;
            $this->response = NULL;
            $this->secret = NULL;
            $this->error = 403;
        }
        else {
            $this->error = 405;
        }
    }

    final public function authorizeapp()
    {
        if(in_array($this->error,[501,506,507])){
            return NULL;
        }

        $auth = array('client_id' => $this->appid, 'access_token' => '', 'user_id' => '');
        $authapp = $this->db->TInsertIF('accounts_token', $auth, "WHERE client_id='" . $this->appid . "'");
        if ($authapp) {
            $this->error = 403;
        }
        else {
            $this->error = 406;
        }
    }

    final public function deauthorizeapp()
    {
        if(in_array($this->error,[501,506,507])){
            return NULL;
        }
        $del_access_token = $this->db->TDelete('accounts_token', 'client_id=?', [$this->appid]);
        if ($del_access_token) {
            $this->userid = NULL;
            
            $this->access_token = NULL;
            $this->request = NULL;
            $this->response = NULL;
            $this->secret = NULL;
            $this->error = 406;
        }
        else {
            $this->error = 405;
        }
    }

    final public function isEnabled()
    {
        if(in_array($this->error,[501,506,507])){
            return NULL;
        }
        $enable = $this->db->TCount('accounts_token', 'WHERE client_id=?', [$this->appid]);
        if (!$enable) {
            $this->error = 406;
        } else {
            $this->error = 403;
        }
    }

    final public function response($fn = NULL)
    {
        if(in_array($this->error,[501,506,507])){
            return NULL;
        }

        $enable = $this->db->TCount('accounts_token', 'WHERE client_id=?', [$this->appid]);
        if (!$enable) {
            $this->error = 406;
            return NULL;
        }
        $auth = ['*'];
        $access_token = $this->access_token;
        list($user_id, $access_token) = explode(',', base64_decode($access_token));
        $check_access_token = $this->db->TSelect('accounts_token', $auth, 'WHERE client_id=? AND user_id=? AND access_token=?', [$this->appid, $user_id, $access_token]);

        if ($check_access_token) {
            $expires = $check_access_token[0]['expires'];
            $scope = json_decode($check_access_token[0]['scope'], TRUE);
            $scope_allowed = array();
            foreach ($this->scope as $key) {
                if (in_array($key, $scope)) {
                    $scope_allowed[] = $key;
                }
            }
            $access_token = $check_access_token[0]['access_token'];
            $user = $this->db->TSelect('accounts', $scope_allowed, 'WHERE id=?', [$check_access_token[0]['user_id']]);

            if ($user && isset($user[0]) && (strtotime($expires) >= time())) {
                $expires = array('expires' => date('Y-m-d H:i:s', time() + ($this->expires)));
                if ($this->autoupdate) {
                    $update_expires = $this->db->TUpdate('accounts_token', $expires, 'WHERE client_id=? AND user_id=? AND access_token=?', [$this->appid, $user_id, $access_token]);
                }
                if (isset($user['pass'])) unset($user['pass']);
                $this->userid = $user_id;
                $this->request = $user[0];
                $this->error = 200;
                $this->is_expires = $check_access_token[0]['expires'];
                if (is_callable($fn)) {
                    $this->response = call_user_func_array($fn, array($this->request, $expires));
                }
            }
            else {
                $this->error = 403;
                $this->is_expires = $check_access_token[0]['expires'];
            }
        }
        else {
            $this->error = 499;
            $this->is_expires = NULL;
        }
    }
    final public function request($time = 0, $fn = NULL)
    {
        if(in_array($this->error,[501,506,507])){
            return NULL;
        }
        $this->response($fn);
        if ($this->error == 200) {
            $now = date("Y-m-d H:i:s", time());
            $expires = strtotime($this->is_expires);
            $d = round( ($expires - time()), 0);
            if ($time > 0 && $d <= $time) {
                $this->regenerate();
            }
        }
    }
    final public function regenerate($force = FALSE)
    {
        if(in_array($this->error,[501,506,507])){
            return NULL;
        }
        $auth = ['*'];
        $access_token = $this->access_token;
        list($user_id, $access_token) = explode(',', base64_decode($access_token));
        $check_access_token = $this->db->TSelect('accounts_token', $auth, 'WHERE client_id=? AND user_id=? AND access_token=?', [$this->appid, $user_id, $access_token]);

        if ($check_access_token) {
            $expires = $check_access_token[0]['expires'];
            $scope = json_decode($check_access_token[0]['scope'], TRUE);
            $user = $this->db->TSelect('accounts', $scope, 'WHERE id=?', [$check_access_token[0]['user_id']]);

            if ($user && isset($user[0]) && (strtotime($expires) >= time()) || $force) {
                $this->userid = $user_id;
                $this->generate();
            }
            else {
                $this->error = 498;
            }
        }
        else {
            $this->error = 499;
        }
    }

    final protected function generate()
    {
        if(in_array($this->error,[501,506,507])){
            return NULL;
        }
        try {
            $access_token = bin2hex(openssl_random_pseudo_bytes(32));
            $access_token = base64_encode($this->userid . ',' . $access_token);
            $tu = [
                'client_id' => $this->appid,
                'secret' => $this->secret,
                'domain' => $this->domain,
                'access_token' => $access_token,
                'user_id' => $this->userid,
                'scope' => json_encode($this->scope),
                'expires' => date('Y-m-d H:i:s', time() + ($this->expires))
            ];
            $isappid = $this->db->TSelect('accounts_token', array("*"), 'WHERE client_id=?', array($this->appid));
            if ($isappid) {
                $set_access_token = $this->db->TInsertUpdate('accounts_token', $tu, " WHERE user_id='" . $this->userid . "' AND client_id='" . $this->appid . "'");
                if ($set_access_token) {
                    $this->access_token = $access_token;
                    
                    $this->is_expires = $tu['expires'];
                    $this->error = 200;
                }
                else {
                    
                    $this->access_token = NULL;
                    $this->is_expires = '';
                    $this->error = 532;
                }
            }
            else {
                
                $this->access_token = NULL;
                $this->error = 530;
            }
        } catch (\Exception $e) {
            $this->error = 540;
            $this->userid = NULL;
            
            $this->access_token = NULL;
            $this->request = NULL;
            $this->response = NULL;
            $this->secret = NULL;
            $this->is_expires = NULL;
        }
    }

    final public function install()
    {
        if ($this->db) {
            $this->db->createTable('accounts_token', array(
                'client_id VARCHAR(255) NOT NULL',
                'access_token VARCHAR(255) NOT NULL',
                'user_id VARCHAR(255)',
                'expires TIMESTAMP NOT NULL',
                'scope VARCHAR(4000)',
                'secret VARCHAR(80)',
                'domain VARCHAR(255)'
            ), TRUE);
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