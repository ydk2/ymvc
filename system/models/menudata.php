<?php

class MenuData extends DBConnect {
	public function __construct() {
		$data=Config::$data['default']['database'];
		//$data['type'] = 'sqlite';
		//var_dump($data);
		
        $this ->Connect($data['type'], $data['name'], $data['host'],$data['user'], $data['pass']);
		$this->lang=Helper::session('locale');
		$this->lang_menu = (Helper::session('lang'))?Helper::session('lang'):'en';
		$this->lang_strings=$this->get_site_data_lang();
		//Intl::$strings=$this->lang_strings;
		$this -> template = 'admin';
		$this -> links = array( 
		array('stylesheet', HOST_URL . '/templates/admin/theme/css/style.css', 'text/css'), 
		array('stylesheet', HOST_URL . '/templates/new/theme/bootstrap/themes/default/bootstrap.css', 'text/css'), 
		array('stylesheet', 'http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css', 'text/css'));
		$this -> scripts = array( 
		array('text/javascript', HOST_URL . '/templates/new/theme/bootstrap/themes/start/js/jquery.js', ''),
		array('text/javascript', HOST_URL . '/templates/new/theme/js/jquery.js', ''), 
		array('text/javascript', HOST_URL . '/templates/new/theme/js/jquery-migrate.js', ''), 
		array('text/javascript', HOST_URL . '/templates/new/theme/js/bootstrap.min.js', ''));

	}

	public function get_page_title($link) {
		$page = $this -> db -> prepare("SELECT title FROM ".DBPREFIX."pages WHERE link=?");
		$page -> execute(array($link));
		$item = $page -> fetchAll(PDO::FETCH_NAMED);
		if ($item) :
			return $item[0]['title'];
		endif;
		return FALSE;
	}


	public function get_menu($groups) {
		$h = $this -> db -> prepare("SELECT * FROM ".DBPREFIX."menus WHERE lang=? AND groups=? ORDER BY pos ASC");
		$h -> execute(array($this->lang_menu,$groups));
		$pages = $h -> fetchAll(PDO::FETCH_NAMED);
		if ($pages) :
			//sksort($pages,'pos');
			return $pages;
		endif;	// end get pages
		return false;
	}

	public function add_menu_item($item_title, $item_link, $groups) {
		try {
			$a = $this -> db -> query("SELECT title, link, lang, groups FROM ".DBPREFIX."menus WHERE link='$item_link' AND groups='$groups' AND lang='".$this->lang_menu."'");
			$check = $a -> fetchColumn();
			if ($check == TRUE) {
				return 1069;
			} else {
				$i = count($this -> get_menu($groups)) + 1;
				$add = $this -> db -> prepare("INSERT INTO ".DBPREFIX."menus (pos, title, parent, link, lang, groups) VALUES (?,?,?,?,?,?)");
				$add -> execute(array($i, $item_title, '', $item_link, $this->lang_menu,$groups));
				$a = $this -> db -> query("SELECT title, link, lang, groups FROM ".DBPREFIX."menus WHERE link='$item_link' AND groups='$groups' AND lang='".$this->lang_menu."'");
				$added = $a -> fetchColumn();
				if ($added == TRUE) {
					return 0;
				} else return 1068;
				
			}
		} catch(Exception $e) {
			return 1067;
		}
	}

	public function update_menu_items($pos, $parent, $title, $link, $access, $ids, $groups) {
		try {
			$a = $this -> db -> query("SELECT * FROM ".DBPREFIX."menus WHERE pos=$pos OR link='$link' AND lang='".$this->lang_menu."' AND groups='$groups' ");
			$check = $a -> fetchColumn();
			if ($check == TRUE) {
				$add = $this -> db -> prepare("UPDATE ".DBPREFIX."menus SET pos=?,title=?,parent=?,link=?,access=?, lang=?, groups=? WHERE id=? AND lang=?");
				$add -> execute(array($pos, $title, $parent, $link, $access,$this->lang_menu, $groups, $ids, $this->lang_menu));
				$a = $this -> db -> query("SELECT * FROM ".DBPREFIX."menus WHERE pos=$pos AND link='$link' AND title='$title' AND parent='$parent' AND lang='".$this->lang_menu."' AND groups='".$groups."'");
				$added = $a -> fetchColumn();
				if ($added == TRUE) {
					return 0;
				} else return 1065;
			} else {
				$add = $this -> db -> prepare("INSERT INTO ".DBPREFIX."menus (pos, title, parent, link, access, lang, groups) VALUES (?,?,?,?,?,?,?)");
				$add -> execute(array($pos, $title, $parent, $link, $access, $this->lang_menu,$groups));
				$a = $this -> db -> query("SELECT * FROM ".DBPREFIX."menus WHERE pos=$pos AND link='$link' AND title='$title' AND parent='$parent' AND lang='".$this->lang_menu."' AND groups='$groups'");
				$added = $a -> fetchColumn();
				if ($added == TRUE) {
					return 0;
				} else return 1066;
				
			}
		} catch(Exception $e) {
			return 1067;
		}
	}
	
	public function get_site_data_item($name='') {
		$data = $this -> db -> prepare("SELECT * FROM ".DBPREFIX."sitedata WHERE name=?");
		$data->execute(array($name));
		$string = $data -> fetchAll(PDO::FETCH_NAMED);
		if($string):
		return Intl::_($string[0]['string']);
		endif;
		return FALSE;		
	}	
	
	public function get_site_data_lang() {
		$array = array();
		$data = $this -> db -> prepare("SELECT * FROM ".DBPREFIX."translatedstrings WHERE lang=?");
		$data->execute(array($this->lang));
		$items = $data -> fetchAll(PDO::FETCH_NAMED);
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