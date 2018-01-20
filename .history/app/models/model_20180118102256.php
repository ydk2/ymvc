<?php
namespace App\Models;

use \Library\Core\Helper as Helper;

class Model
{
	public $ext = '.php';
	public $enabled;
	public $db;
	public $theme;
	public $guid;
	public $uid;
	public $auth;
	public $scope;
	public $role;
	public $before;

	function __construct($conf = NULL)
	{
		if($this->isAjax()){
			$this->ext = '.php';
		} else {
			$this->ext = '.xsl';
		}
		$this->theme = (isset($conf->theme)) ? $conf->theme : 'default';
		//$this->guid = "admin";
		//$this->uid = 1;
		$this->enabled = (isset($conf->enabled)) ? $conf->enabled : array(
			"app/controllers/json/main",
			"app/controllers/json/login",
			"app/controllers/json/register",
			"app/controllers/json/time",
			"app/controllers/json/connect",
			"app/controllers/json/langs",
			"app/controllers/json/test",
			"app/controllers/json/test2",
			"app/controllers/json/inbox",
			"app/controllers/json/outbox",
			"app/controllers/json/e",
			"app/controllers/xsl/xsl"
		);

		if ($this->scope == NULL || !is_array($this->scope))
			$this->scope = [
			'id',
			'login',
			'email',
			'born',
			'role',
			'name',
			'car',
			'active',
			'share',
			'phone',
			'country',
			'lang',
			'distance',
			'ice'
		];
		$this->before = 3600 * 47;
		//$appid = 'bbj377hnm6sn49i998jrgbr33m';
		if(!$this->isAjax()){
			$appid = Helper::Request('appid');
		} else {
            $appid = "S13456DFH";
        }
		

		$conf = [
			'appid' => $appid,
			'scope' => $this->scope,
			'request' => NULL,
			'expires' => 3600 * 48,
			'token' => Helper::Request('access_token'),
			'autoupdate' => FALSE
		];
		$excluded = ['langs', 'connect.json'];
		if (!in_array(Helper::Get('path'), $excluded)) {
			$this->auth = new \Library\lAuth($conf);
			$this->auth->request($this->before);

			$this->guid = $this->auth->request['role'];
			$this->uid = $this->auth->request['role_id'];

			$this->db = new \Library\PDOHelper;
			$this->db->Connect(DBTYPE, DBNAME, DBUSER, DBPASS, DBHOST);
		}
	}
	public function Cors()
	{
		$request_headers = getallheaders();
		$origin = $request_headers['Origin'];
		header("Access-Control-Allow-Origin: $origin");
		header("Access-Control-Allow-Credentials: true");
		header("Access-Control-Max-Age: 1000");
		header("Access-Control-Allow-Headers: Custom, X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
		header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
	}
	public function isAjax(){
		//HTTP_X_REQUESTED_WITH
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_ACCEPT']) == '*/*') {
			return TRUE;
		}
		return FALSE;
	}
}
?>