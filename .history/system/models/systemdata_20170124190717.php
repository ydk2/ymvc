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


    public function get_entries($table,$grpx) {
        $h = $this -> db -> prepare("SELECT * FROM ".DBPREFIX.$table." WHERE gprx=? ORDER BY idx ASC");
        $h -> execute(array($grpx));
        $pages = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($pages) {
            //sksort($pages,'pos');
        return $pages;
        }	// end get pages
        return false;
    }
    

    public function get_grpx($table,$gprx) {
        $h = $this -> db -> prepare("SELECT gprx FROM ".DBPREFIX.$table." WHERE gprx=? ORDER BY idx ASC");
        $h -> execute(array($gprx));
        $grp = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($grp) {
        //var_dump($grpx);
        $tmp = array();
        foreach ($grp as $item) {
            $tmp[]=$item['grpx'];
        }
        $result = array_unique($tmp);
        return $result;
		}	// end get pages
        return false;
    }

    public function get_idx($table,$gprx) {
        $h = $this -> db -> prepare("SELECT idx,gprx FROM ".DBPREFIX.$table." WHERE gprx=? ORDER BY idx ASC");
        $h -> execute(array($gprx));
        $grp = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($grp) {
        $tmp = array();
        foreach ($grp as $item) {
            $tmp[]=$item['idx'];
        }
        $result = array_unique($tmp);
        return $result;
		}	// end get pages
        return false;
    }

    public function delete_item($table,$item_id) {
        $del = $this -> db -> prepare('DELETE FROM '.DBPREFIX.$table.' WHERE id=?');
        $del -> execute(array($item_id));
		$check = $del->rowCount();
            if ($check > 0) {
                return 0;
            } else {
				return 1070;
			}
    }

    public function delete_idx($table,$idx,$gprx) {
        $del = $this -> db -> prepare('DELETE FROM '.DBPREFIX.$table.' WHERE idx=? AND gprx=? ');
        $del -> execute(array($idx,$gprx));
		$check = $del->rowCount();
            if ($check > 0) {
                return 0;
            } else {
				return 1070;
			}
    }

    public function add_item($table,$name,$value,$idx,$grpx) {
        try {
            $a = $this -> db -> query("SELECT name, value, idx, grpx FROM ".DBPREFIX.$table." WHERE name='$name' AND idx='$idx' AND grpx='$grpx' ");
            $check = $a -> fetchColumn();
            if ($check == TRUE) {
                return 1069;
            } else {
                $i = count($this -> get_menu($grpx)) + 1;
                $add = $this -> db -> prepare("INSERT INTO ".DBPREFIX.$table." (name, value, idx, grpx) VALUES (?,?,?,?)");
                $add -> execute(array($name,$value,$idx,$grpx));
                $a = $this -> db -> query("SELECT name, value, idx, grpx FROM ".DBPREFIX.$table."  WHERE name='$name' AND idx='$idx' AND grpx='$grpx' ");
                $added = $a -> fetchColumn();
                if ($added == TRUE) {
                    return 0;
                } else return 1068;
            }
        } catch(Exception $e) {
            return 1067;
        }
    }
    
    public function update_item($table,$name,$value,$idx,$grpx) {
        try {
            $a = $this -> db -> query("SELECT * FROM ".DBPREFIX.$table." WHERE name='$name' AND idx='$idx' AND grpx='$grpx' ");
            $check = $a -> fetchColumn();
            if ($check == TRUE) {
                $add = $this -> db -> prepare("UPDATE ".DBPREFIX.$table." SET name=?,value=?,idx=?,grpx=? WHERE idx=? AND grpx=?");
                $add -> execute(array($name, $value, $idx, $grpx, $idx, $grpx));
                $a = $this -> db -> query("SELECT * FROM ".DBPREFIX.$table." WHERE name='$name' AND idx='$idx' AND grpx='$grpx' ");
                $added = $a -> fetchColumn();
                if ($added == TRUE) {
                    return 0;
                } else return 1065;
            } else {
                $add = $this -> db -> prepare("INSERT INTO ".DBPREFIX.$table." (name, value, idx, grpx) VALUES (?,?,?,?)");
                $add -> execute(array($name, $value, $idx, $grpx));
                $a = $this -> db -> query("SELECT * FROM ".DBPREFIX.$table." WHERE name='$name' AND idx='$idx' AND grpx='$grpx' ");
                $added = $a -> fetchColumn();
                if ($added == TRUE) {
                    return 0;
                } else return 1066;
                
            }
        } catch(Exception $e) {
            return 1067;
        }
    }

}

?>