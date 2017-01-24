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
		$this->time = get_time();
        $this ->Connect($data['type'], $data['name'], $data['host'],$data['user'], $data['pass']);
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


    public function createTable($table,$gprx) {
		$data=Config::$data['default']['database'];
		if ($data['type']=='sqlsrv') {
		$sql="IF OBJECT_ID ('$table', 'U') IS NOT NULL".
			"DROP TABLE  $table;".
			"CREATE TABLE  $table (".
			"id INTEGER NOT NULL PRIMARY KEY IDENTITY(1,1),".
			"name varchar(255),".
			"value TEXT DEFAULT '',".
			"idx INTEGER DEFAULT 0,".
			"gprx varchar(255) DEFAULT '$gprx');";
		} elseif ($data['type']=='pgsql') {
		$sql="DROP TABLE IF EXISTS $table;".
			"CREATE SEQUENCE ".$table."_id_seq;".
			"CREATE TABLE IF NOT EXISTS test (".
			"id INTEGER NOT NULL PRIMARY KEY,".
			"name varchar(255) NOT NULL,".
			"value TEXT DEFAULT '',".
			"idx INTEGER NOT NULL,".
			"gprx varchar(255)  NOT NULL DEFAULT '$gprx');".
			"ALTER TABLE $table ALTER id SET DEFAULT NEXTVAL('".$table."_id_seq');";
		} elseif ($data['type']=='mysql') {
		$sql="DROP TABLE IF EXISTS $table;".
			"CREATE TABLE IF NOT EXISTS $table (".
			"id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,".
			"name varchar(255) NOT NULL,".
			"value TEXT,".
			"idx int(99) DEFAULT 1,".
			"gprx varchar(255) NOT NULL DEFAULT '$gprx');";
		} elseif ($data['type']=='sqlite') {
		$sql="DROP TABLE IF EXISTS ".DBPREFIX."$table;".
			"CREATE TABLE IF NOT EXISTS $table (".
			"id INTEGER NOT NULL PRIMARY KEY,".
			"name varchar(255) NOT NULL,".
			"value TEXT DEFAULT '',".
			"idx int(99) DEFAULT 1,".
			"gprx varchar(255) NOT NULL DEFAULT '$gprx');";
		}
	try {
		$add = $this -> db -> exec($sql);
		//$check = $this->db->query("SELECT name FROM sqlite_master WHERE type='table';");
		//$g = $check -> fetchAll(PDO::FETCH_NAMED);
		//return $g;
        return TRUE;
	} catch(Exception $e){
		return FALSE;
	}
    }

    public function get_entries($table,$gprx) {
        $h = $this -> db -> prepare("SELECT * FROM ".DBPREFIX.$table." WHERE gprx=? ORDER BY idx ASC");
        $h -> execute(array($gprx));
        $pages = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($pages) {
            //sksort($pages,'pos');
        return $pages;
        }	// end get pages
        return false;
    }
    

    public function get_gprx($table,$gprx) {
        $h = $this -> db -> prepare("SELECT gprx FROM ".DBPREFIX.$table." WHERE gprx=? ORDER BY gprx ASC");
        $h -> execute(array($gprx));
        $grp = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($grp) {
        //var_dump($gprx);
        $tmp = array();
        foreach ($grp as $item) {
            $tmp[]=$item['gprx'];
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

    public function add_item($table,$name,$value,$idx,$gprx) {
        try {
            $a = $this -> db -> query("SELECT name, value, idx, gprx FROM ".DBPREFIX.$table." WHERE name='$name' AND idx='$idx' AND gprx='$gprx' ");
            $check = $a -> fetchColumn();
            if ($check == TRUE) {
                return 1069;
            } else {
                $add = $this -> db -> prepare("INSERT INTO ".DBPREFIX.$table." (name, value, idx, gprx) VALUES (?,?,?,?)");
                $add -> execute(array($name,$value,$idx,$gprx));
                $a = $this -> db -> query("SELECT name, value, idx, gprx FROM ".DBPREFIX.$table."  WHERE name='$name' AND idx='$idx' AND gprx='$gprx' ");
                $added = $a -> fetchColumn();
                if ($added == TRUE) {
                    return 0;
                } else return 1068;
            }
        } catch(Exception $e) {
            return 1067;
        }
    }
    
    public function update_item($table,$name,$value,$idx,$gprx) {
        try {
            $a = $this -> db -> query("SELECT * FROM ".DBPREFIX.$table." WHERE name='$name' AND idx='$idx' AND gprx='$gprx' ");
            $check = $a -> fetchColumn();
            if ($check == TRUE) {
                $add = $this -> db -> prepare("UPDATE ".DBPREFIX.$table." SET name=?,value=?,idx=?,gprx=? WHERE idx=? AND gprx=?");
                $add -> execute(array($name, $value, $idx, $gprx, $idx, $gprx));
                $a = $this -> db -> query("SELECT * FROM ".DBPREFIX.$table." WHERE name='$name' AND idx='$idx' AND gprx='$gprx' ");
                $added = $a -> fetchColumn();
                if ($added == TRUE) {
                    return 0;
                } else return 1065;
            } else {
                $add = $this -> db -> prepare("INSERT INTO ".DBPREFIX.$table." (name, value, idx, gprx) VALUES (?,?,?,?)");
                $add -> execute(array($name, $value, $idx, $gprx));
                $a = $this -> db -> query("SELECT * FROM ".DBPREFIX.$table." WHERE name='$name' AND idx='$idx' AND gprx='$gprx' ");
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