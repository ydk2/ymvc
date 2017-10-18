<?php
namespace App\Models;

class Model
{
	protected $ext = '.php';
	protected $enabled;
	protected $db;
	public $theme;
	public $guid;
	public $uid;

	function __construct($conf = NULL)
	{

		$this->ext = '.php';
		$this->theme = (isset($conf->theme))?$conf->theme:'default';
		$this->guid = "mod";
		$this->uid = 4;
		$this->enabled = (isset($conf->enabled))?$conf->enabled:array(
			"app/controllers/json/main",
			"app/controllers/json/login",
			"app/controllers/json/register",
			"app/controllers/json/time",
			"app/controllers/json/connect",
			"app/controllers/json/langs",
			"app/controllers/json/e"
		);

		$this->db = new \Library\Core\DB;
		$this->db->Connect(DBTYPE, DBNAME, DBUSER, DBPASS, DBHOST);
	}
	protected function Cors(){
		$request_headers = getallheaders();
		$origin = $request_headers['Origin'];
		header("Access-Control-Allow-Origin: $origin");
		header("Access-Control-Allow-Credentials: true");
		header("Access-Control-Max-Age: 1000");
		header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
		header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
	}
}
?>