<?php
namespace App\Models;

use \Library\Core\Helper;
use \Library\Core\Intl;
use \Library\Core\Session;
use \Library\PDOHelper;
use \Library\Helpers\Files;

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
	public $lang;

	function __construct($conf = NULL)
	{
		$this->theme = (isset($conf->theme)) ? $conf->theme : 'default';
		$this->enabled = (isset($conf->enabled)) ? $conf->enabled : array(
			"app/controllers/login",
			"app/controllers/main",
			"app/controllers/test"
		);
		$this->db = new PDOHelper;
		$this->db->Connect(DBTYPE, DBNAME, DBUSER, DBPASS, DBHOST);
		$this->lang = Intl::get_browser_lang();
		Intl::set_path(ROOT.Files::NativePath('/app/languages'));
		//Intl::po_locale_plural($this->lang);
	}

}
?>