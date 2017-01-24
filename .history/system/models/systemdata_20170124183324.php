<?php
/**
 * 
 */
class SystemData extends DBConnect {
	public $dump;
	function __construct($import=FALSE)
	{
		# code...
		$data=Config::$data['default']['database'];
		//$data['type'] = 'sqlite';
		//var_dump($data);
		$this->time = get_time();
        $this ->Connect($data['type'], $data['name'], $data['host'],$data['user'], $data['pass']);
		if($import){
		if ($data['type']=='sqlsrv') {
			$queries = file_get_contents(ROOT.DATA.'sqlsrv.sql');
			$queries = explode(";", $queries);
		} elseif ($data['type']=='pgsql') {
			$queries = file_get_contents(ROOT.DATA.'pgsql.sql');
			$queries = explode(";", $queries);
		} elseif ($data['type']=='mysql') {
			$queries = file_get_contents(ROOT.DATA.'mysql.sql');
		} elseif ($data['type']=='sqlite') {
			$queries = file_get_contents(ROOT.DATA.'db.sql');
			$queries = explode(";", $queries);
		}
		
    	foreach ($queries as $query) {
        	$this->db->query($query);
    	}
		}
		
	}
	public function check($array){
		# code...
		$page = $this -> db -> prepare("SELECT * FROM ? ORDER BY id");
		$page -> execute($array);
		$item = $page -> fetchAll(PDO::FETCH_NAMED);
		if ($item) :
			return dump($item);
		endif;
	}
	public function get($table,$array){
		# code...
		$page = $this -> db -> prepare("SELECT * FROM ".$table." ORDER BY ?");
		$page -> execute($array);
		$item = $page -> fetchAll(PDO::FETCH_NAMED);
		if ($item) :
			return $item;
		endif;
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
    
    
    public function get_groups() {
        $h = $this -> db -> prepare("SELECT groups FROM ".DBPREFIX."menus WHERE lang=? ORDER BY pos ASC");
        $h -> execute(array($this->lang_menu));
        $groups = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($groups) :
        //var_dump($groups);
        $tmp = array();
        foreach ($groups as $item) {
            $tmp[]=$item['groups'];
        }
        $result = array_unique($tmp);
        return $result;
        endif;	// end get pages
        return false;
    }

    public function delete_item($item_id) {
        $del = $this -> db -> prepare('DELETE FROM '.DBPREFIX.'menus WHERE id=? AND lang=?');
        $del -> execute(array($item_id, $this->lang_menu));
		$check = $del->rowCount();
            if ($check > 0) {
                return 0;
            } else {
				return 1070;
			}
    }

    public function add_item($item_title, $item_link, $groups) {
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
    
    public function update_items($table,$name,$value,$index,$groups) {
        try {
            $a = $this -> db -> query("SELECT * FROM ".DBPREFIX.$table." WHERE name='$name' AND index='$index' AND groups='$groups' ");
            $check = $a -> fetchColumn();
            if ($check == TRUE) {
                $add = $this -> db -> prepare("UPDATE ".DBPREFIX.$table." SET name=?,value=?,index=?,groups=? WHERE index=? AND groups=?");
                $add -> execute(array($name, $value, $index, $groups, $index, $groups));
                $a = $this -> db -> query("SELECT * FROM ".DBPREFIX.$table." WHERE name='$name' AND index='$index' AND groups='$groups' ");
                $added = $a -> fetchColumn();
                if ($added == TRUE) {
                    return 0;
                } else return 1065;
            } else {
                $add = $this -> db -> prepare("INSERT INTO ".DBPREFIX.$table." (name, value, index, groups) VALUES (?,?,?,?)");
                $add -> execute(array($name, $value, $index, $groups));
                $a = $this -> db -> query("SELECT * FROM ".DBPREFIX.$table." WHERE name='$name' AND index='$index' AND groups='$groups' ");
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
        $data = $this -> db -> prepare("SELECT * FROM ".DBPREFIX."strings WHERE lang=?");
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