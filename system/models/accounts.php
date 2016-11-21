<?php

class Accounts extends DBConnect {
	public function __construct() {
		$data=Config::$data['default']['database'];
		//$data['type'] = 'sqlite';
		//var_dump($data);
		
        $this ->Connect($data['type'], $data['name'], $data['host'],$data['user'], $data['pass']);
		$this->lang=Helper::session('locale');
		$this->lang_menu = 'en';
		$this->lang_strings=$this->get_site_data_lang();
		Intl::$strings=$this->lang_strings;
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
		$page = $this -> db -> prepare("SELECT title FROM ".DBPREFIX."pages WHERE link  =  ?");
		$page -> execute([$link]);
		$item = $page -> fetchAll(PDO::FETCH_NAMED);
		if ($item) :
			return $item[0]['title'];
		endif;
		return FALSE;
	}

	public function login() {
		/*** if we are here the data is valid and we can insert it into database ***/
		$name = filter_var(Helper::post('name'), FILTER_SANITIZE_STRING);
		$password = filter_var(Helper::post('password'), FILTER_SANITIZE_STRING);

		/*** now we can encrypt the password ***/
		$password = sha1($password);

		try {
			//$dbh = $db->base;
			//$stmt= $dbh->base->query("SELECT id, name, password FROM users WHERE name = '$name' AND password = '$password'");
			$stmt = $this -> db -> prepare("SELECT id, name, email, password FROM ".DBPREFIX."users WHERE (name = ? OR email = ?) AND password = ?");
			$stmt -> execute([$name, $name, $password]);

			/*** check for a result ***/
			$user_id = $stmt -> fetchColumn();

			/*** if we have no result then fail boat ***/
			if ($user_id == FALSE) {
				return 101;
			} else {
				Helper::session_set('id', $user_id);
				//Helper::session_set('user_name', $row['name']);
				//Helper::session_set('user_email', $row['email']);
				//$search = "%$search%";
				$user_data = $this -> db -> prepare("SELECT * FROM ".DBPREFIX."users WHERE name = ? OR email = ?");
				$user_data -> execute([$name, $name]);
				$data = $user_data -> fetchAll();
				Helper::session_set('user_name', $data[0]['name']);
				Helper::session_set('user_email', $data[0]['email']);
				Helper::session_set('user_role', $data[0]['role']);
				//var_dump($data[0]);
				//while ($row = $stmt -> fetch()) {

				//}
				return 0;
			}

		} catch(Exception $e) {
			/*** if we are here, something has gone wrong with the database ***/
			return 102;
		}
	}

	public function register() {
		$name = filter_var(Helper::post('name'), FILTER_SANITIZE_STRING);
		$email = filter_var(Helper::post('email'), FILTER_SANITIZE_STRING);
		$password = filter_var(Helper::post('password'), FILTER_SANITIZE_STRING);
		$password = sha1($password);
		try {

			$users = $this -> db -> query("SELECT name, email FROM ".DBPREFIX."users WHERE name = '$name' OR email = '$email'");
			$u = $users -> fetchColumn();
			if ($u == false) {
				$stmt = $this -> db -> prepare("INSERT INTO ".DBPREFIX."users (name, email, password) VALUES (?,?,?)");

				/*** execute the prepared statement ***/
				$stmt -> execute([$name, $email, $password]);

			} else {
				$a = $this -> db -> query("SELECT name, email FROM ".DBPREFIX."users WHERE name = '$name'");
				$check = $a -> fetchColumn();
				if ($check == false) {
					return 110;
				} else {
					return 0;
				}
				return 111;
			}
		} catch(Exception $e) {
			return 112;
		}
	}

	function build_sorter($key) {
		return function($a, $b) use ($key) {
			return strnatcmp($a[$key], $b[$key]);
		};
	}

	public function get_menu($groups) {
		$h = $this -> db -> prepare("SELECT * FROM ".DBPREFIX."menus WHERE lang=? AND groups=? ORDER BY pos ASC");
		$h -> execute([$this->lang_menu,$groups]);
		$pages = $h -> fetchAll(PDO::FETCH_NAMED);
		if ($pages) :
			usort($pages, $this -> build_sorter('pos'));
			return $pages;
		endif;	// end get pages
		return false;
	}

	public function add_menu_item($item_title, $item_link, $groups) {
		try {
			$a = $this -> db -> query("SELECT title, link, lang, groups FROM ".DBPREFIX."menus WHERE link = '$item_link' AND groups = '$groups' AND lang='".$this->lang_menu."'");
			$check = $a -> fetchColumn();
			if ($check == TRUE) {
				return 1069;
			} else {
				$i = count($this -> get_menu($groups)) + 1;
				$add = $this -> db -> prepare("INSERT INTO ".DBPREFIX."menus (pos, title, parent, link, lang, groups) VALUES (?,?,?,?,?,?)");
				$add -> execute([$i, $item_title, '', $item_link, $this->lang_menu,$groups]);
				$a = $this -> db -> query("SELECT title, link, lang, groups FROM ".DBPREFIX."menus WHERE link = '$item_link' AND groups = '$groups' AND lang='".$this->lang_menu."'");
				$added = $a -> fetchColumn();
				if ($added == TRUE) {
					return 0;
				} else return 1068;
				
			}
		} catch(Exception $e) {
			return 1067;
		}
	}

	public function update_menu_items($id, $parent, $title, $link, $access, $ids, $groups) {
		try {
			$a = $this -> db -> query("SELECT * FROM ".DBPREFIX."menus WHERE pos = $id OR link='$link' AND lang='".$this->lang_menu."' AND groups='$groups' ");
			$check = $a -> fetchColumn();
			if ($check == TRUE) {
				$add = $this -> db -> prepare("UPDATE ".DBPREFIX."menus SET pos=?,title=?,parent=?,link=?,access=?, lang=?, groups=? WHERE id=? AND lang=?");
				$add -> execute([$id, $title, $parent, $link, $access,$this->lang_menu, $groups, $ids, $this->lang_menu]);
				$a = $this -> db -> query("SELECT * FROM ".DBPREFIX."menus WHERE pos = $id AND link='$link' AND title='$title' AND parent='$parent' AND lang='".$this->lang_menu."' AND groups = '".$groups."'");
				$added = $a -> fetchColumn();
				if ($added == TRUE) {
					return 0;
				} else return 1065;
			} else {
				$add = $this -> db -> prepare("INSERT INTO ".DBPREFIX."menus (pos, title, parent, link, access, lang, groups) VALUES (?,?,?,?,?,?,?)");
				$add -> execute([$id, $title, $parent, $link, $access, $this->lang_menu,$groups]);
				$a = $this -> db -> query("SELECT * FROM ".DBPREFIX."menus WHERE pos = $id AND link='$link' AND title='$title' AND parent='$parent' AND lang='".$this->lang_menu."' AND groups = '$groups'");
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
		$data->execute([$name]);
		$string = $data -> fetchAll(PDO::FETCH_NAMED);
		if($string):
		return Intl::_($string[0]['string']);
		endif;
		return FALSE;		
	}	
	
	public function get_site_data_lang() {
		$array = array();
		$data = $this -> db -> prepare("SELECT * FROM ".DBPREFIX."translatedstrings WHERE lang=?");
		$data->execute([$this->lang]);
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