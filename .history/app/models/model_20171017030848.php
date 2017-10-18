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

	function __construct()
	{

		$this->ext = '.php';
		$this->theme = (isset($conf->theme))?$conf->theme:'default';
		$this->guid = "mod";
		$this->uid = 4;
		$this->enabled = array(
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

}
?>