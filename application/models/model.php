<?php
namespace application\models;

use \System\core\Router as router;
use \System\helpers\dbconnect as dbconnect;
use \System\helpers\Intl as Intl;

class model {
	public $page_title;
	public $lang;
	
	public function __construct() {
		//$this -> database_name = __APP__ . '/data/database.db';
		// try connect
		$sql = SQL;
		$this -> db = new dbconnect($sql, 'database','localhost','root','');
		//$this->page_title = (!$this->get_page_title(Router::get('data'))) ? strip_tags($this->page_title_str) : $this->get_page_title(Router::get('data'));
		$this->lang=Router::session('locale');
		$this->lang_menu = 'en';
		$this->lang_strings=$this->get_site_data_lang();
		Intl::$strings=$this->lang_strings;
		$this->page_title="Error!!!";
		$this->get_page_title(Router::get('page'));
		$this -> template = 'new';
		$this -> links = array( 
		array('stylesheet', HOST_URL . '/templates/new/theme/css/style.css', 'text/css'), 
		array('stylesheet', HOST_URL . '/templates/new/theme/bootstrap/themes/default/bootstrap.css', 'text/css'), 
		array('stylesheet', 'http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css', 'text/css'));
		$this -> scripts = array( 
		//array('text/javascript', HOST_URL . '/templates/new/theme/bootstrap/themes/start/js/jquery.js', ''),
		array('text/javascript', HOST_URL . '/templates/new/theme/js/jquery.js', ''), 
		array('text/javascript', HOST_URL . '/templates/new/theme/js/jquery-migrate.js', ''), 
		array('text/javascript', HOST_URL . '/templates/new/theme/js/bootstrap.min.js', ''));
	}

	public function getList($groups) {
		$d = getdate();
		$children = $this -> db -> base -> query("SELECT * FROM ".DBPREFIX."menus WHERE lang='".$this->lang_menu."' AND groups='".$groups."' ORDER BY pos ASC LIMIT 30 OFFSET 0");
		$items = $children->fetchAll(\PDO::FETCH_NAMED);
		if($items):
			return $items;
		endif;
		return FALSE;
	}
	public function get_by_parents($group) {
		$d = getdate();
		$a = $this -> db -> base -> prepare("SELECT id, pos, link, parent, title FROM menus WHERE parent = ? ORDER BY pos ");
		$a->execute([$group]);
		$list = $a -> fetchAll(\PDO::FETCH_NAMED);
		if($list):
			return $list;
		endif;
		return FALSE;
	}

public function get_first()
{
		$a = $this -> db -> base -> prepare("SELECT * FROM ".DBPREFIX."pages WHERE lang=? AND link = ? ORDER BY id");
		$a -> execute([$this->lang,INDEX]);
		$first = $a -> fetchAll(\PDO::FETCH_NAMED);
		if($first):
		$this->page_title=$first[0]['title'];
		return $first[0];
		endif;	
		return FALSE;
}
	public function get_page($link) {
		$page = $this -> db -> base -> prepare("SELECT * FROM ".DBPREFIX."pages WHERE link  =  ? AND lang=?");
		$page->execute([$link,$this->lang]);
		$item = $page -> fetchAll(\PDO::FETCH_NAMED);
		if($item):
		$this->page_title=$item[0]['title'];
		return $item[0];
		endif;
		return FALSE;
	}
	public function get_page_title($link='') {
		if($link==''):
		$this->get_first();
		else: 
		$this->get_page($link);
		endif;
		return FALSE;
	}
	
	public function get_site_data_item($name='') {
		$data = $this -> db -> base -> prepare("SELECT * FROM ".DBPREFIX."sitedata WHERE name=?");
		$data->execute([$name]);
		$string = $data -> fetchAll(\PDO::FETCH_NAMED);
		if($string):
		return Intl::_($string[0]['string']);
		endif;
		return FALSE;		
	}	
	
	public function get_site_data_lang() {
		$array = array();
		$data = $this -> db -> base -> prepare("SELECT * FROM ".DBPREFIX."translatedstrings WHERE lang=?");
		$data->execute([$this->lang]);
		$items = $data -> fetchAll(\PDO::FETCH_NAMED);
		if($items):
		foreach ($items as $key => $value) {
			$array[$value['name']]=$value['string'];
		}
		return $array;
		endif;
		return FALSE;		
	}	
}
?>