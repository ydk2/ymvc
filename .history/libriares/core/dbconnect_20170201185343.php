<?php
/**
*
* PHPRender fast and simple to use PHP MVC framework
*
* MVC Framework for PHP 5.2 + with PHP files views part of YMVC System
* Connector for databases PoSQL, SQLite , MySQL using PDO.
*
* PHP version 5
*
* LICENSE: This source file is subject to version 3.01 of the PHP license
* that is available through the world-wide-web at the following URI:
* http://www.php.net/license/3_01.txt.  If you did not receive a copy of
* the PHP License and are unable to obtain it through the web, please
* send a note to license@php.net so we can mail you a copy immediately.
*
* @category   Framework, MVC, Database
* @package    YMVC System
* @subpackage DBConnect
* @author     ydk2 <me@ydk2.tk>
* @copyright  1997-2016 ydk2.tk
* @license    http://www.php.net/license/3_01.txt  PHP License 3.01
* @version    1.11.0
* @link       http://ymvc.ydk2.tk
* @see        YMVC System
* @since      File available since Release 1.0.0

*/

class DBConnect {
    public $db;
    
    final public function Connect($engin, $database, $host = 'localhost', $user = NULL, $pass = NULL) {
        try {
            if ($engin == 'posql') {
                require_once ROOT.VENDORS.'posql.php';
                $database_name = ROOT.DATA.'database'.DS.$database . '.db';
                //echo $database_name;
                if (!file_exists($database_name.'.php')) {
                    throw new SystemException('Database not exist.',420404);
                }
                // try connect
                //$sql = SQL;
                
                $this->db = new Posql($database_name);
                //$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                
                if ($this->db -> isError()) {
                    abort($this->db);
                    throw new SystemException('Can\'t connect to Database.',420502);
                }
                
            }
            
            if ($engin == 'sqlite') {
                try {
                    
                    $database_name = ROOT.DATA.'database'.DS. $database . '.db';
                    $this->db = new PDO($engin.':'. $database_name);
                    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $err = $this->db->errorInfo();
                    if($err[0]>0){
                        throw new SystemException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
                    }
                    
                } catch (PDOException $e){
                    //handle PDO
                    throw new SystemException( $e->getMessage( ) , (int)$e->getCode( ) );
                }
            }
            if ($engin == 'sqlsrv') {
                try {
                    if ($user === NULL || $pass === NULL) {
                        throw new SystemException('User and Password not filed.');
                    }
                    $this->db = new PDO($engin.':Server=' . $host . ';Database=' . $database.';ConnectionPooling=0', $user, $pass);
                    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $err = $this->db->errorInfo();
                    if($err[0]>0){
                        throw new SystemException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
                    }
                    
                } catch (PDOException $e){
                    //handle PDO
                    throw new SystemException( $e->getMessage( ) , (int)$e->getCode( ) );
                }
            }
            
            if ( !in_array($engin,array('posql','sqlite','sqlsrv'))) {
                try {
                    if ($user === NULL || $pass === NULL) {
                        throw new SystemException('User and Password not filed.');
                    }
                    $this->db = new PDO($engin.':host=' . $host . ';dbname=' . $database, $user, $pass);
                    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $err = $this->db->errorInfo();
                    if($err[0]>0){
                        throw new SystemException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
                    }
                    
                } catch (PDOException $e){
                    //handle PDO
                    throw new SystemException( $e->getMessage( ) , (int)$e->getCode( ) );
                }
            }
        } catch (SystemException $e) {
            return FALSE;
        }
        
    }
    
    public function __destruct() {
        $this->db = NULL;
        unset($this->db);
    }
    
    public function GetId($data,$idx,$name,$gprx=''){
        foreach ($data as $items) {
            if($items['idx']==$idx && $items['name']==$name && $gprx==$items['gprx'])
            return $items['id'];
        }
        return NULL;
    }
    
    public function GetName($data,$idx,$value,$gprx=''){
        foreach ($data as $items) {
            if($items['idx']==$idx && $items['value']==$value && $gprx==$items['gprx'])
            return $items['name'];
        }
        return NULL;
    }
    
    public function GetValue($data,$idx,$name,$gprx=''){
        foreach ($data as $items) {
            if($items['idx']==$idx && $items['name']==$name && $gprx==$items['gprx'])
            return $items['value'];
        }
        return NULL;
    }
    
    public function GetIdx($data,$name,$value,$gprx=''){
        foreach ($data as $items) {
            if($items['name']==$name && $items['value']==$value && $gprx==$items['gprx'])
            return $items['idx'];
        }
        return NULL;
    }
    
    public function Getgprx($data,$name,$value,$idx){
        foreach ($data as $items) {
            if($items['name']==$name && $items['value']==$value && $idx==$items['idx'])
            return $items['gprx'];
        }
        return NULL;
    }
    
    public function SetName(&$data,$idx,$name,$newname,$gprx=''){
        foreach ($data as $i => $items) {
            if($items['idx']==$idx && $items['name']==$name && $gprx==$items['gprx']){
                $data[$i]['name']=$newname;
                return $items['name'];
            }
        }
        return NULL;
    }
    
    public function UnsetName(&$data,$idx,$name,$gprx=''){
        foreach ($data as $i => $items) {
            if($items['idx']==$idx && $items['name']==$name && $gprx==$items['gprx']){
                unset($data[$i]);
            }
        }
        return NULL;
    }
    
    public function UnsetIdx(&$data,$idx,$gprx=''){
        foreach ($data as $i => $items) {
            if($items['idx']==$idx && $gprx==$items['gprx']){
                unset($data[$i]);
            }
        }
        return NULL;
    }
    
    public function SetValue(&$data,$idx,$name,$newvalue,$gprx=''){
        foreach ($data as $i => $items) {
            if($items['idx']==$idx && $items['name']==$name && $gprx==$items['gprx']){
                $data[$i]['value']=$newvalue;
                return $items['value'];
            }
        }
        return NULL;
    }
    
    public function SetItemgprx(&$data,$idx,$name,$newgprx,$gprx=''){
        foreach ($data as $i => $items) {
            if($items['idx']==$idx && $items['name']==$name && $gprx==$items['gprx']){
                $data[$i]['gprx']=$newgprx;
                return $items['gprx'];
            }
        }
        return NULL;
    }
    
    public function SetItemIdx(&$data,$idx,$name,$newidx,$gprx=''){
        foreach ($data as $i => $items) {
            if($items['idx']==$idx && $items['name']==$name && $gprx==$items['gprx']){
                $data[$i]['idx']=$newidx;
                return $items['idx'];
            }
        }
        return NULL;
    }
    
    public function Setgprx(&$data,$idx,$newgprx,$gprx=''){
        foreach ($data as $i => $items) {
            if($items['idx']==$idx && $gprx==$items['gprx']){
                $data[$i]['gprx']=$newgprx;
                return $items['gprx'];
            }
        }
        return NULL;
    }
    
    public function SetIdx(&$data,$idx,$newidx,$gprx=''){
        if(empty($data)) return NULL;
        foreach ($data as $i => $items) {
            if($items['idx']==$idx && $gprx==$items['gprx']){
                $data[$i]['idx']=$newidx;
                return $items['idx'];
            }
        }
        return NULL;
    }
    
    public function searchByName($data,$name='_name',$gprx=''){
        $aout = array();
        if(empty($data)) return $aout;
        foreach ($data as $items) {
            if(isset($items['name']) && isset($items['gprx'])){
                if($name==$items['name'] && $gprx==$items['gprx']){
                    $item = $items['idx'];
                    $values = array();
                    foreach ($data as $value) {
                        if(isset($value['idx']) && $item===$value['idx']){
                            $values[$value['name']]=$value['value'];
                        }
                    }
                    $aout[$item]=$values;
                }
            }
        }
        return $aout;
    }
    public function searchByNameValue($data,$name='_name',$value='',$gprx=''){
        $aout = array();
        if(empty($data)) return $aout;
        foreach ($data as $items) {
            if(isset($items['name']) && isset($items['value']) && isset($items['gprx'])){
                if($name==$items['name'] && $value==$items['value'] && $gprx==$items['gprx']){
                    $item = $items['idx'];
                    $outval = array();
                    foreach ($data as $values) {
                        if(isset($values['idx']) && $item===$values['idx']){
                            $outval[$values['name']]=$values['value'];
                        }
                    }
                    $aout[$item]=$outval;
                }
            }
        }
        return $aout;
    }
    
    public function reverseItems($items,$data,$gprx=''){
        $rout = array();
        if(empty($data) && empty($items)) return $rout;
        foreach ($items as $idx => $item) {
            if(is_array($item)) {
                foreach($item as $name => $value){
                    $id = $this->GetId($data,$idx,$name,$gprx);
                    $rout[] = array('id'=>$id,'idx'=>$idx,'name'=>$name,'value'=>$value,'gprx'=>$gprx);
                }
            }
        }
        return $rout;
    }
    public function reverseNoId($items,$gprx=''){
        $rout = array();
        if(empty($items)) return $rout;
        $id = 1;
        foreach ($items as $idx => $item) {
            if(is_array($item)) {
                foreach($item as $name => $value){
                    $rout[] = array('id'=>$id++,'idx'=>$idx,'name'=>$name,'value'=>$value,'gprx'=>$gprx);
                }
            }
        }
        return $rout;
    }
    
    function GetFreeId($tmp){
        if (!empty($tmp)){
            sksort($tmp,'id');
            foreach ($tmp as $pos => $val) {
                $i =$pos+1;
                if ($i > $val['id']) {
                    return $i;
                }
            }
            return $i;
        }
    }
    
    function GetFreeIdx($data){
        if (!empty($data)){
            sksort($data,'idx');
            foreach ($data as $pos => $val) {
                $i = $pos+1;
                if ($i > $val['idx']) {
                    return $i;
                }
            }
            return $i;
        }
        return 1;
    }
    
    public function array_rotate_delete_id($data,$delete,$control='id'){
        $updatein = array();
        if(empty($data)) return $updatein;
        $updateout = $data;
        foreach ($data as $i => $item) {
            $update=array();
            if(isset($item[$control])){
                if($item[$control]==$delete){
                    echo $item[$control]." $i<br>";
                    unset($updateout[$i]);
                }
            }
        }
        return $updateout;
    }
    
    public function array_rotate_delete($data,$delete,$idx='idx'){
        $updatein = array();
        if(empty($data)) return $updatein;
        $updateout = $data;
        foreach ($data as $i => $item) {
            if(isset($item[$idx])){
                if($item[$idx]==$delete){
                    unset($updateout[$i]);
                }
            }
        }
        return $updateout;
    }
    
    public function array_rotate_update($data,$updated,$control='id'){
        $updatein = array();
        if(empty($data)) return $updatein;
        $updateout = $data;
        foreach ($updated as $entry) {
            foreach ($entry as $key => $value) {
                if(isset($value[$control])){
                    $updatein[$value[$control]] = $value;
                    foreach ($data as $idx => $item) {
                        $update=array();
                        if(isset($item[$control])){
                            if($item[$control]===$updatein[$value[$control]][$control]){
                                $update=$updatein[$value[$control]];
                                $updateout[$idx] = $update;
                            }
                        }
                    }
                }
            }
        }
        return $updateout;
    }
    
    public function array_rotate_key_value($data,$key='name',$val='value',$control='id'){
        $updateout = array();
        if(empty($data)) return $updateout;
        foreach ($data as $i => $idx) {
            foreach ($idx as $keys => $value) {
                if(isset($value[$key]) && isset($value[$val])){
                    $updateout[$i][$value[$key]] = $value[$val];
                }
            }
        }
        return $updateout;
    }
    
    public function array_search_rotate($data,$search_value='',$search_name='_name',$_value='value',$_name='name',$idx='idx',$control='id'){
        $aout = array();
        if(empty($data)) return $aout;
        foreach ($data as $i => $items) {
            if(isset($items[$_name]) && isset($items[$_value])){
                if($search_name==$items[$_name] && $search_value==$items[$_value]){
                    $item = $items[$idx];
                    $values = array();
                    foreach ($data as $value) {
                        if(isset($value[$idx]) && $item===$value[$idx]){
                            if(isset($value[$_name])) $values[$value[$_name]][$_name]=$value[$_name];
                            if(isset($value[$_value])) $values[$value[$_name]][$_value]=$value[$_value];
                            if(isset($value[$idx])) $values[$value[$_name]][$idx]=$value[$idx];
                            if(isset($value[$control])) $values[$value[$_name]][$control]=$value[$control];
                            
                        }
                    }
                    $aout[$item]=$values;
                }
            }
        }
        return $aout;
    }
    
    public function array_rotate($data,$search_name='_name',$_value='value',$_name='name',$idx='idx',$control='id'){
        $aout = array();
        if(empty($data)) return $aout;
        foreach ($data as $i => $items) {
            if(isset($items[$_name])){
                if($search_name==$items[$_name]){
                    $item = $items[$idx];
                    $values = array();
                    foreach ($data as $value) {
                        if(isset($value[$idx]) && $item===$value[$idx]){
                            if(isset($value[$_name])) $values[$value[$_name]][$_name]=$value[$_name];
                            if(isset($value[$_value])) $values[$value[$_name]][$_value]=$value[$_value];
                            if(isset($value[$idx])) $values[$value[$_name]][$idx]=$value[$idx];
                            if(isset($value[$control])) $values[$value[$_name]][$control]=$value[$control];
                            
                        }
                    }
                    $aout[$item]=$values;
                }
            }
        }
        return $aout;
    }

    public function createTableRotate($table,$gprx) {
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
            return TRUE;
        } catch(Exception $e){
            return FALSE;
        }
    }
    public function Begin($name='T1'){
        $data=Config::$data['default']['database'];
        if ($data['type']=='sqlsrv') {
            $sql="BEGIN TRAN $name;";
        } elseif ($data['type']=='pgsql') {
            $sql="BEGIN;";
        } elseif ($data['type']=='mysql') {
                $sql="SET autocommit = 0; BEGIN TRANSACTION; SAVEPOINT $name;";
        } elseif ($data['type']=='sqlite') {
            $sql="BEGIN; SAVEPOINT $name;";
        }
        try {
            $add = $this -> db -> exec($sql);
            return TRUE;
        } catch(Exception $e){
            return FALSE;
        }
    }
    public function Commit($name='T1'){
        $data=Config::$data['default']['database'];
        if ($data['type']=='sqlsrv') {
            $sql="COMMIT TRAN $name;";
        } elseif ($data['type']=='pgsql') {
            $sql="COMMIT;";
        } elseif ($data['type']=='mysql') {
            $sql="COMMIT;";
        } elseif ($data['type']=='sqlite') {
            $sql="COMMIT;";
        }
        try {
            $add = $this -> db -> exec($sql);
            return TRUE;
        } catch(Exception $e){
            return FALSE;
        }
    }
    public function Release($name='T1'){
        $data=Config::$data['default']['database'];
        if ($data['type']=='sqlsrv') {
            $sql="COMMIT TRAN $name;";
        } elseif ($data['type']=='pgsql') {
            $sql="RELEASE $name;";
        } elseif ($data['type']=='mysql') {
            $sql="RELEASE $name;";
        } elseif ($data['type']=='sqlite') {
            $sql="RELEASE $name;";
        }
        try {
            $add = $this -> db -> exec($sql);
            return TRUE;
        } catch(Exception $e){
            return FALSE;
        }
    }
    public function Rollback($name='T1'){
        $data=Config::$data['default']['database'];
        if ($data['type']=='sqlsrv') {
            $sql="ROLLBACK TRAN $name;";
        } elseif ($data['type']=='pgsql') {
            $sql="ROLLBACK;";
        } elseif ($data['type']=='mysql') {
            $sql="ROLLBACK TO $name;";
        } elseif ($data['type']=='sqlite') {
            $sql="ROLLBACK TO $name;";
        }
        try {
            $add = $this -> db -> exec($sql);
            return TRUE;
        } catch(Exception $e){
            return FALSE;
        }
    }
/**
* Set colemns
* @access public
* @param Array $attr Attributes list
* @return String Styled attr=value
* array('key','type','option')
**/
	public function Columns($columns){
		$out = '';
		if(!empty($columns)){
		foreach ($columns as $value) {
			$out.= " ".$value[0].""." ".$value[1].""." ".$value[2].",";
		}
		}
		return $out = substr($out,-2);
	}
    public function createTable($table,$columns) {
        $data=Config::$data['default']['database'];
        if ($data['type']=='sqlsrv') {
            $sql="IF OBJECT_ID ('$table', 'U') IS NOT NULL".
            "DROP TABLE  $table;".
            "CREATE TABLE  $table (".
            "id INTEGER NOT NULL PRIMARY KEY IDENTITY(1,1),".
            $this->Columns($columns).
            ");";
        } elseif ($data['type']=='pgsql') {
            $sql="DROP TABLE IF EXISTS $table;".
            "CREATE SEQUENCE ".$table."_id_seq;".
            "CREATE TABLE IF NOT EXISTS test (".
            "id INTEGER NOT NULL PRIMARY KEY,".
            $this->Columns($columns).
            ");".
            "ALTER TABLE $table ALTER id SET DEFAULT NEXTVAL('".$table."_id_seq');";
        } elseif ($data['type']=='mysql') {
            $sql="DROP TABLE IF EXISTS $table;".
            "CREATE TABLE IF NOT EXISTS $table (".
            "id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,".
            $this->Columns($columns).
            ");";
        } elseif ($data['type']=='sqlite') {
            $sql="DROP TABLE IF EXISTS ".DBPREFIX."$table;".
            "CREATE TABLE IF NOT EXISTS $table (".
            "id INTEGER NOT NULL PRIMARY KEY,".
            $this->Columns($columns).
            ");";
        }
        try {
            $add = $this -> db -> exec($sql);
            return TRUE;
        } catch(Exception $e){
            return FALSE;
        }
    }

    public function get_tables_list() {
        $data=Config::$data['default']['database'];
            if ($data['type']=='sqlsrv') {
                $sql="SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_CATALOG='dbName';";
        } elseif ($data['type']=='pgsql') {
            $sql="SELECT table_name FROM information_schema.tables WHERE table_schema = 'public';";
        } elseif ($data['type']=='mysql') {
            $sql="SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='dbName';";
        } elseif ($data['type']=='sqlite') {
            $sql="SELECT name FROM sqlite_master WHERE type='table';";
        }
        try {
            $check = $this->db->query($sql);
            $rows = $check -> fetchAll(PDO::FETCH_NAMED);
            if ($rows) {
                //sksort($rows,'pos');
                return $rows;
            }
            return FALSE;
        } catch(Exception $e){
            return FALSE;
        }
    }

    public function search_entries($table,$gprx,$limit=100,$offset=0) {
        $max = $offset+$limit;
        $h = $this -> db -> prepare("SELECT * FROM ".DBPREFIX.$table." WHERE gprx=? AND idx>=? AND idx<? ORDER BY idx ASC");
        $h -> execute(array($gprx,$offset,$max));
        $rows = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($rows) {
           return $this->searchByName($rows,$rows[0]['name'],$gprx);
        }	// end get pages
        return false;
    }

    public function search_name_value($table,$name,$value,$gprx,$limit=100,$offset=0) {
        $max = $offset+$limit;
        $h = $this -> db -> prepare("SELECT * FROM ".DBPREFIX.$table." WHERE name=? AND value=? AND gprx=? AND idx>=? AND idx<? ORDER BY idx ASC");
        $h -> execute(array($name,$value,$gprx,$offset,$max));
        $rows = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($rows) {
           return $this->searchByNameValue($rows,$name,$value,$gprx);
        }	// end get pages
        return false;
    }

    public function search_name($table,$name,$gprx,$limit=100,$offset=0) {
        $max = $offset+$limit;
        $h = $this -> db -> prepare("SELECT * FROM ".DBPREFIX.$table." WHERE name=? AND gprx=? AND idx>=? AND idx<? ORDER BY idx ASC");
        $h -> execute(array($name,$gprx,$offset,$max));
        $rows = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($rows) {
           return $this->searchByName($rows,$name,$gprx);
        }	// end get pages
        return false;
    }

    public function search_name_idx($table,$name,$idx,$gprx) {
        $h = $this -> db -> prepare("SELECT * FROM ".DBPREFIX.$table." WHERE name=? AND idx=? AND gprx=? ORDER BY idx ASC");
        $h -> execute(array($name,$idx,$gprx));
        $rows = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($rows) {
           return $this->searchByName($rows,$name,$gprx);
        }	// end get pages
        return false;
    }

    public function search_idx_enteries($table,$idx,$gprx) {
        $h = $this -> db -> prepare("SELECT * FROM ".DBPREFIX.$table." WHERE idx=? AND gprx=? ORDER BY idx ASC");
        $h -> execute(array($idx,$gprx));
        $rows = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($rows) {
            return $this->searchByName($rows,$rows[0]['name'],$gprx);
        }	// end get pages
        return false;
    }
// get
    public function get_entries($table,$gprx,$limit=100,$offset=0) {
        $max = $offset+$limit;
        $h = $this -> db -> prepare("SELECT * FROM ".DBPREFIX.$table." WHERE gprx=? AND idx>=? AND idx<? ORDER BY idx ASC");
        $h -> execute(array($gprx,$offset,$max));
        $rows = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($rows) {
            //sksort($rows,'pos');
            return $rows;
        }	// end get pages
        return false;
    }

    public function get_name_value($table,$name,$value,$gprx,$limit=100,$offset=0) {
        $max = $offset+$limit;
        $h = $this -> db -> prepare("SELECT * FROM ".DBPREFIX.$table." WHERE name=? AND value=? AND gprx=? AND idx>=? AND idx<? ORDER BY idx ASC");
        $h -> execute(array($name,$value,$gprx,$offset,$max));
        $rows = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($rows) {
            //sksort($rows,'pos');
            return $rows;
        }	// end get pages
        return false;
    }

    public function get_name($table,$name,$gprx,$limit=100,$offset=0) {
        $max = $offset+$limit;
        $h = $this -> db -> prepare("SELECT * FROM ".DBPREFIX.$table." WHERE name=? AND gprx=? AND idx>=? AND idx<? ORDER BY idx ASC");
        $h -> execute(array($name,$gprx,$offset,$max));
        $rows = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($rows) {
            //sksort($rows,'pos');
            return $rows;
        }	// end get pages
        return false;
    }

    public function get_name_id($table,$name,$idx,$gprx) {
        $h = $this -> db -> prepare("SELECT id FROM ".DBPREFIX.$table." WHERE name=? AND idx=? AND gprx=? ORDER BY id ASC");
        $h -> execute(array($name,$idx,$gprx));
        $rows = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($rows) {
            //sksort($rows,'pos');
            return $rows[0]['id'];
        }	// end get pages
        return false;
    }

    public function get_name_idx($table,$name,$idx,$gprx) {
        $h = $this -> db -> prepare("SELECT * FROM ".DBPREFIX.$table." WHERE name=? AND idx=? AND gprx=? ORDER BY idx ASC");
        $h -> execute(array($name,$idx,$gprx));
        $rows = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($rows) {
            //sksort($rows,'pos');
            return $rows;
        }	// end get pages
        return false;
    }

    public function get_idx_enteries($table,$idx,$gprx) {
        $h = $this -> db -> prepare("SELECT * FROM ".DBPREFIX.$table." WHERE idx=? AND gprx=? ORDER BY idx ASC");
        $h -> execute(array($idx,$gprx));
        $rows = $h -> fetchAll(PDO::FETCH_NAMED);
        if ($rows) {
            //sksort($rows,'pos');
            return $rows;
        }	// end get pages
        return false;
    }

    public function get_gprx_list($table) {
        $h = $this -> db -> prepare("SELECT gprx FROM ".DBPREFIX.$table." ORDER BY gprx ASC");
        $h -> execute(array());
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
    
    public function get_idx_list($table,$gprx) {
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
    
    public function get_free_idx($table,$gprx) {
        $list = $this -> get_idx_list($table,$gprx);
        $i = 0;
        if (!empty($list)){
            foreach ($list as $idx) {
                if ($i > $idx) {
                    return $i;
                }
                $i = $idx+1;
            }
            return $i;
        }
        return 1;
    }
    
    public function delete_item_by_id($table,$item_id) {
        $del = $this -> db -> prepare('DELETE FROM '.DBPREFIX.$table.' WHERE id=?');
        $del -> execute(array($item_id));
        $check = $del->rowCount();
        if ($check > 0) {
            return 0;
        } else {
            return 1070;
        }
    }
    
    public function delete_item($table,$name,$idx,$gprx) {
        $del = $this -> db -> prepare('DELETE FROM '.DBPREFIX.$table.' WHERE name=? AND  idx=? AND gprx=?');
        $del -> execute(array($name,$idx,$gprx));
        $check = $del->rowCount();
        if ($check > 0) {
            return 0;
        } else {
            return 1070;
        }
    }
    // DELETE FROM layouts WHERE idx=10 AND gprx=layout
    public function delete_idx($table,$idx,$gprx) {
        $del = $this -> db -> prepare('DELETE FROM '.DBPREFIX.$table.' WHERE idx=? AND gprx=?');
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
            if ($check != FALSE) {
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
    
    public function doSavePost($item='item',$table,$group){
        if(isset($_POST)){
            switch ($_POST) {
                case 'add':
                if(isset($_POST[$item]) && !empty($_POST[$item])){
                    $frompost = $_POST[$item];
                    reset($frompost);
                    $chk = 0;
                    $data = $this->reverseNoId($frompost,$group);
                    foreach ($data as $items) {
                        $chk+=$this->add_item($table,$items['name'],$items['value'],$items['idx'],$group);
                    }
                    if($chk == 0){
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                }
                break;
            
            case 'update':
            if(isset($_POST[$item]) && !empty($_POST[$item])){
                $frompost = $_POST[$item];
                reset($frompost);
                $chk = 0;
                $data = $this->reverseNoId($frompost,$group);
                foreach ($data as $items) {
                    $chk+=$this->update_item($table,$items['name'],$items['value'],$items['idx'],$group);
                }
                if($chk == 0){
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
            break;

        case 'delete':
        if(isset($_POST[$item]) && !empty($_POST[$item])){
            $frompost = $_POST[$item];
            reset($frompost);
            $chk = 0;
            $data = $this->reverseNoId($frompost,$group);
            foreach ($data as $items) {
                $chk+=$this->delete_item($table,$items['name'],$items['idx'],$group);
            }
            if($chk == 0){
                return TRUE;
            } else {
                return FALSE;
            }
        }
        break;
    
    default:
        return FALSE;
        break;
    }
    }
    if(isset($_GET['delete']) && $_GET['delete']==$item){
        $out=$this->delete_idx($table,$_GET['delete'],$group);
        if($chk == 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
        return FALSE;
  }
  public function doAddItems($action,$table,$group){
    if(isset($action) && !empty($action)){
      reset($action);
      $chk = 0;
      $data = $this->reverseNoId($action,$group);
      foreach ($data as $items) {
        $chk+=$this->add_item($table,$items['name'],$items['value'],$items['idx'],$group);
      }
      if($chk == 0){
        return TRUE;
      } else {
        return FALSE;
      }
    }
    return FALSE;
  }
    public function doUpdateItems($action,$table,$group){
        if(isset($action) && !empty($action)){
            reset($action);
            $chk = 0;
            $data = $this->reverseNoId($action,$group);
            foreach ($data as $items) {
                $chk+=$this->update_item($table,$items['name'],$items['value'],$items['idx'],$group);
            }
            if($chk == 0){
                return TRUE;
            } else {
                return FALSE;
            }
        }
        return FALSE;
    }
    public function doDeleteItems($action,$table,$group){
        if(isset($action) && !empty($action)){
            reset($action);
            $chk = 0;
            $data = $this->reverseNoId($action,$group);
            foreach ($data as $items) {
                $chk+=$this->delete_item($table,$items['name'],$items['idx'],$group);
            }
            if($chk == 0){
                return TRUE;
            } else {
                return FALSE;
            }
        }
        return FALSE;
    }
    public function doDeleteIdx($action,$table,$group){
    if(isset($action) && $action!=''){
        $chk=$this->delete_idx($table,$action,$group);
        if($chk == 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    return FALSE;
    }
    public function doSave($item='item',$table,$group){
        if(Helper::get('action')=='add' && isset($_POST['add'])){
            $frompost = Helper::post($item);
            reset($frompost);
            $chk = 0;
            $data = $this->model->reverseNoId($frompost,$group);

            foreach ($data as $items) {
                $chk+=$this->model->add_item($table,$items['name'],$items['value'],$items['idx'],$group);
            }
            if($chk == 0){
            return TRUE;
            } else {
            return FALSE;
            }
        }
        if(Helper::get('action')=='update' && isset($_POST['update'])){
            $frompost = Helper::post($item);
            reset($frompost);
            $chk = 0;
            $data = $this->model->reverseNoId($frompost,$group);

            foreach ($data as $items) {
                $chk+=$this->model->update_item($table,$items['name'],$items['value'],$items['idx'],$group);
            }
            if($chk == 0){
            return TRUE;
            } else {
            return FALSE;
            }
        }
        if(Helper::get('action')=='delete' && Helper::get($item)){
			$chk=$this->model->delete_idx($table,Helper::get($item),$group);
            if($chk == 0){
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
}
?>