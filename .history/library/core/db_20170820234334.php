<?php
/**
* 
*
* PHPRender fast and simple to use PHP MVC framework
*
* MVC Framework for PHP 5.2 + with PHP files views part of YMVC System
* Connector for databases PoSQL, SQLite , MySQL using \PDO.
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
namespace Library\Core;

class DB {
    /**
     * \PDO Object
     * 
     * @var \PDO DB
     */
    public $db;
    public $data; 
    public $sql; 
    /**
     * DB Connector
     *
     * @param string $engin
     * @param string $database
     * @param string $host
     * @param string $user
     * @param string $pass
     * @return void
     */
    final public function LoadPlugin($plugin){

    }

    function Inc($class){
        $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . $class));
        //echo $filename;
        if (file_exists($filename) && is_file($filename)) {
            require_once ($filename);
            return TRUE;
        }
        return FALSE;
    }

    public function Sql(){
        $args = func_get_args();

        return $this->sql[$args[0]];
    }

    final public function Connect($engin, $database, $host = 'localhost', $user = NULL, $pass = NULL) {
        try {
            $this->data = array('type'=>$engin,'database'=>$database,'host'=>$host,'user'=>$user,'pass'=>$pass);

            if ($engin == 'posql') {
                require_once ROOT.VENDORS.'posql.php';
                $database_name = ROOT.DATA.'database'.DS.$database . '.db';
                //echo $database_name;
                if (!file_exists($database_name.'.php')) {
                    throw new SystemException('Database not exist.',420404);
                }

                $this->db = new Posql($database_name);
                //$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                
                if ($this->db -> isError()) {
                    abort($this->db);
                    throw new SystemException('Can\'t connect to Database.',420502);
                }
                
            }
            
            if ($engin == 'sqlite') {
                if($this->Inc('/library/core/plugins/'.$engin.".php")){
                    $e = new $engin($data);
                    $this->db = $e->db;
                    $this->sql = $e->sql;
                    //var_dump($this);
                }
            }
            
            if ($engin == 'sqlsrv') {
                try {
                    if ($user === NULL || $pass === NULL) {
                        throw new SystemException('User and Password not filed.');
                    }
                    $this->db = new \PDO($engin.':Server=' . $host . ';Database=' . $database.';ConnectionPooling=0', $user, $pass);
                    $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                    
                    $err = $this->db->errorInfo();
                    if($err[0]>0){
                        throw new SystemException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
                    }
                    
                } catch (\PDOException $e){
                    //handle \PDO
                    throw new SystemException( $e->getMessage( ) , (int)$e->getCode( ) );
                }
            }
            
            if ( !in_array($engin,array('posql','sqlite','sqlsrv'))) {
                try {
                    if ($user === NULL || $pass === NULL) {
                        throw new SystemException('User and Password not filed.');
                    }
                    $this->db = new \PDO($engin.':host=' . $host . ';dbname=' . $database, $user, $pass);
                    $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                    
                    $err = $this->db->errorInfo();
                    if($err[0]>0){
                        throw new SystemException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
                    }
                    
                } catch (\PDOException $e){
                    //handle \PDO
                    throw new SystemException( $e->getMessage( ) , (int)$e->getCode( ) );
                }
            }
        } catch (SystemException $e) {
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
        
    }
/**
 * \PDO Begin transaction
 *
 * @return void
 */
    public function dobegin(){
        return $this->db->beginTransaction();
    }

/**
 * \PDO Commit transaction
 *
 * @return void
 */
    public function docommit(){
        return $this->db->commit();
    }

/**
 * \PDO Rollback transaction
 *
 * @return void
 */
    public function dorollback(){
        return $this->db->rollback();
    }
/**
 * \PDO Quote
 * 
 * @param string $string
 * @return string
 */
    public function quote($string){
        return $this->db->quote($string);
    }
/**
 * DB Lock
 * 
 * @param string $name
 * @param string $which can be WRITE or READ
 * @return void
 */
    public function Lock($name,$which='WRITE'){
        $data=$this->data;
        /*
        if ($data['type']=='sqlsrv') {
            $this->sql['']="LOCK TABLE $name $which;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="LOCK TABLE $name $which;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="LOCK TABLE $name $which;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="LOCK TABLE $name $which;";
        }
        */
        try {
            $add = $this -> db -> exec($this->Sql(__FUNCTION__,$name,$which));
            return TRUE;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }
    /**
     * DB UnLock
     * 
     * @param string $name
     * @return void
     */
    public function UnLock($name){
        /*
        $data=$this->data;
        if ($data['type']=='sqlsrv') {
            $this->sql['']="UNLOCK TABLES;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="UNLOCK TABLES;";
        } elseif ($data['type']=='mysql') {
                $this->sql['']="UNLOCK TABLES;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="UNLOCK TABLES;";
        }
        */
        try {
            $add = $this -> db -> exec($this->Sql(__FUNCTION__,$name));
            return TRUE;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }
    public function isLock($name){
        /*
        $data=$this->data;
        if ($data['type']=='sqlsrv') {
            $this->sql['']="SELECT \n".
                "OBJECT_NAME(".$name.".OBJECT_ID) AS TableName \n".
                "FROM \n".
                "sys.dm_tran_locks l \n".
                "JOIN sys.partitions ".$name." ON l.resource_associated_entity_id = ".$name.".hobt_id";
            $this->sql[''] = "SELECT * FROM ".$name." WITH(XLOCK,ROWLOCK,READCOMMITTED);";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="UNLOCK TABLES;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="SHOW OPEN TABLES  WHERE `Table` LIKE '%".$name."%' AND  `Database` LIKE '%".$data['name']."%' AND In_use > 0 OR Name_locked > 0;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="PRAGMA lock_status;";
        }
        */
        try {
            $query = $this -> db -> query($this->Sql(__FUNCTION__,$name));
            $rows = $query -> fetchAll(\PDO::FETCH_NAMED);
            if ($rows) {
                return $rows;
            }
            return FALSE;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }

    public function SBegin($name='T1'){
        /*
        $data=$this->data;
        if ($data['type']=='sqlsrv') {
            $this->sql['']="BEGIN TRAN $name;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="BEGIN; SAVEPOINT $name;";
        } elseif ($data['type']=='mysql') {
                $this->sql['']="SET autocommit = 0; START TRANSACTION; SAVEPOINT $name;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="BEGIN; SAVEPOINT $name;";
        }
        */
        try {
            $add = $this -> db -> exec($this->Sql(__FUNCTION__,$name));
            return TRUE;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }
    public function SCommit($name='T1'){
        /*
        $data=$this->data;
        if ($data['type']=='sqlsrv') {
            $this->sql['']="COMMIT TRAN $name;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="COMMIT;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="COMMIT;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="COMMIT;";
        }
        */
        try {
            $add = $this -> db -> exec($this->Sql(__FUNCTION__,$name));
            return TRUE;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }
    public function SRelease($name='T1'){
        $data=$this->data;
        if ($data['type']=='sqlsrv') {
            $this->sql['']="";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="RELEASE $name;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="RELEASE SAVEPOINT $name;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="RELEASE $name;";
        }
        try {
            $add = $this -> db -> exec($this->Sql(__FUNCTION__,$name));
            return TRUE;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }
    public function SRollback($name='T1'){
        $data=$this->data;
        if ($data['type']=='sqlsrv') {
            $this->sql['']="ROLLBACK TRAN $name;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="ROLLBACK TO SAVEPOINT $name;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="ROLLBACK TO $name;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="ROLLBACK TO $name;";
        }
        try {
            $add = $this -> db -> exec($this->Sql(__FUNCTION__,$name));
            return TRUE;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }

    public function Begin(){
        /*
        $data=$this->data;
        if ($data['type']=='sqlsrv') {
            $this->sql['']="BEGIN TRAN;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="BEGIN;";
        } elseif ($data['type']=='mysql') {
                $this->sql['']="SET autocommit = 0; START TRANSACTION;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="BEGIN;";
        }
        */
        try {
            $add = $this -> db -> exec($this->Sql(__FUNCTION__));
            return TRUE;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }
    public function Commit(){
        $data=$this->data;
        if ($data['type']=='sqlsrv') {
            $this->sql['']="COMMIT TRAN;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="COMMIT;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="COMMIT;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="COMMIT;";
        }
        try {
            $add = $this -> db -> exec($this->sql['Commit']);
            return TRUE;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }
    public function Release(){
        $data=$this->data;
        if ($data['type']=='sqlsrv') {
            $this->sql['']="";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="";
        }
        try {
            //$add = $this -> db -> exec($this->sql['Release']);
            return TRUE;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }

    public function Rollback(){
        $data=$this->data;
        if ($data['type']=='sqlsrv') {
            $this->sql['']="ROLLBACK TRAN;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="ROLLBACK;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="ROLLBACK;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="ROLLBACK;";
        }
        try {
            $add = $this -> db -> exec($this->sql['Rollback']);
            return TRUE;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }

    public function Query($sql){
        try {
            $query = $this->db->query($sql);
            $rows = $query -> fetchAll(\PDO::FETCH_NAMED);
            if ($rows) {
                return $rows;
            }
            return FALSE;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }

    public function Prepare($sql,$values=array()) {
        try {
        $query = $this -> db -> prepare($sql);
        $query -> execute($values);
        $rows = $query -> fetchAll(\PDO::FETCH_NAMED);
        if ($rows) {
           return $rows;
        }	// end get pages
        return false;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }

    public function Exec($sql){
        try {
            $chk = $this -> db -> exec($sql);
            return $chk;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }

    public function createTable($table,$columns,$addid=TRUE) {

        if(is_array($columns)){
            $string = implode(",", $columns);
        } else {
            $string = $columns;
        }
        /*
        $data=$this->data;
        if ($data['type']=='sqlsrv') {
            if($addid){
            $this->sql['']="IF OBJECT_ID ('$table', 'U') IS NULL".
            "CREATE TABLE  $table (".
            "id INTEGER NOT NULL PRIMARY KEY IDENTITY(1,1),".
            $string.
            ");";
            } else {
            $this->sql['']="IF OBJECT_ID ('$table', 'U') IS NULL".
            "CREATE TABLE  $table (".
            $string.
            ");";
            }
        } elseif ($data['type']=='pgsql') {
            if($addid){
            $this->sql['']="CREATE SEQUENCE ".$table."_id_seq;".
            "CREATE TABLE IF NOT EXISTS test (".
            "id INTEGER NOT NULL PRIMARY KEY,".
            $string.
            ");".
            "ALTER TABLE $table ALTER id SET DEFAULT NEXTVAL('".$table."_id_seq');";
            } else {
            $this->sql['']="CREATE TABLE IF NOT EXISTS test (".
            $string.
            ");";
            }
        } elseif ($data['type']=='mysql') {
            if($addid){
            $this->sql['']="CREATE TABLE IF NOT EXISTS $table (".
            "id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,".
            $string.
            ");";
            } else {
            $this->sql['']="CREATE TABLE IF NOT EXISTS $table (".
            $string.
            ");";
            }
        } elseif ($data['type']=='sqlite') {
            if($addid){
            $this->sql['']="CREATE TABLE IF NOT EXISTS $table (".
            "id INTEGER NOT NULL PRIMARY KEY,".
            $string.
            ");";
            } else {
            $this->sql['']="CREATE TABLE IF NOT EXISTS $table (".
            $string.
            ");";
            }
        }
        */
        try {
            $chk = $this -> db -> exec($this->db->Sql(__FUNCTION__,$table,$string));
            return TRUE;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }

    public function dropTable($table) {
        $data=$this->data;
        if ($data['type']=='sqlsrv') {
            $this->sql['']="IF OBJECT_ID ('$table', 'U') IS NOT NULL".
            "DROP TABLE  $table;";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="DROP TABLE IF EXISTS $table;";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="DROP TABLE IF EXISTS $table;";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="DROP TABLE IF EXISTS "."$table;";
        }
        try {
            $chk = $this -> db -> exec($this->db->sql['dropTable']);
            return TRUE;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }

    public function listTables() {
        $data=$this->data;
            if ($data['type']=='sqlsrv') {
                $this->sql['']="SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_CATALOG='dbName';";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="SELECT table_name FROM information_schema.tables WHERE table_schema = 'public';";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='dbName';";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="SELECT name FROM sqlite_master WHERE type='table';";
        }
        try {
            $check = $this->db->query($this->sql['listTables']);
            $rows = $check -> fetchAll(\PDO::FETCH_NAMED);
            if ($rows) {
                return $rows;
            }
            return FALSE;
        } catch(Exception $e){
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }

    public function Count($table,$sql='',$values=array()) {
        $count = $this -> db -> query('SELECT count(*) FROM '.$table.' '.$sql);
        $count -> execute($values);
        $check = $count->fetchColumn();
        if (is_string($check) && intval($check) > 0) {
            return intval($check);
        } else {
            return false;
        }
    }

    public function Delete($table,$sql,$values=array()) {
        $del = $this -> db -> prepare('DELETE FROM '.$table.' WHERE '.$sql);
        $del -> execute($values);
        $check = $del->rowCount();
        if ($check > 0) {
            return $check;
        } else {
            return false;
        }
    }

    public function Insert($table,$data,$query='') {

        try {
            $chk = 0;
            $keys = array();
            $values = array_values($data);
            $string='';
            reset($data);
            while (list($key, $value) = each($data)) {
                $string .= "?,";
                $keys[]=$key;
                //$values[]=$value;
            }

            $add = $this -> db -> prepare("INSERT INTO ".$table." (".implode(",", $keys).") VALUES (".substr($string,0,strlen($string)-1).")".$query.";");

            $add->execute($values);

            $chk = $add -> rowCount();
            if ($chk > 0) {
                return $chk;
            }
            return FALSE;
        } catch(Exception $e) {
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }

    public function InsertIF($table,$data,$query='',$items=array()) {
        $if = $this->Count($table,$query,$items);
        if($if == 0){
            return $this->Insert($table,$data);
        }
        return FALSE;
    }

    public function InsertIfNot($table,$data,$query='',$items=array()) {
        $if = $this->Count($table,$query,$items);
        if(!$if){
            return $this->Insert($table,$data);
        }
        return FALSE;
    }

    public function InsertUpdate($table,$data,$query='',$items=array()) {
        $if = $this->InsertIF($table,$data,$query,$items);
        if($if){
            return TRUE;
        } else {
            return $this->Update($table,$data,$query,$items);
        }
        return FALSE;
    }

    public function Update($table,$data,$query='',$items=array()) { // ".$query[]."
        try {
            $chk = 0;
            $keys = array();
            $values = array();
            $string='';
            reset($data);
            while (list($key, $value) = each($data)) {
                $string .= "$key=?,";
                $values[]=$value;
            }
            $add = $this -> db -> prepare("UPDATE ".$table." SET ".substr($string,0,strlen($string)-1)." ".$query);
            for ($i=0; $i < count($items); $i++) {
                $values[]=$items[$i];
            }
            $add -> execute($values);
            $chk = $add -> rowCount();
            if ($chk > 0) {
                return $chk;
            }
            return FALSE;
        } catch(Exception $e) {
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }

    public function Select($table,$from=array('*'),$query='',$values=array()) {
        try {
            $rows = FALSE;
            $keys = array();
            $query = $this -> db -> prepare("SELECT ".implode(',',$from)." FROM ".$table." ".$query);
            $query -> execute($values);
            $rows = $query->fetchAll(\PDO::FETCH_NAMED);
            if ($rows) {
                return $rows;
            }
            return FALSE;
        } catch(Exception $e) {
            if(defined('DBDEBUG'))
            var_dump($e);
            return FALSE;
        }
    }

    public function DeleteIFId($table,$id) {
        $del = $this -> db -> prepare('DELETE FROM '.$table.' WHERE id=?');
        $del -> execute(array($id));
        $check = $del->rowCount();
        if ($check > 0) {
            return $check;
        } else {
            return 0;
        }
    }

	public function TSQuery($query=''){
		$savepoint = base64_encode(microtime());
		$this->SBegin($savepoint);

		$insert = $this->Query($query);
			
		if($insert){
			$this->SCommit();
			$this->SRelease($savepoint);
			return $insert;
		} else {
			$this->SRollback($savepoint);
			return FALSE;
		}		
	}

	public function TSPrepare($query='',$values=array()){
		$savepoint = base64_encode(microtime());
		$this->SBegin($savepoint);

		$insert = $this->Prepare($query,$values);
			
		if($insert){
			$this->SCommit();
			$this->SRelease($savepoint);
			return $insert;
		} else {
			$this->SRollback($savepoint);
			return FALSE;
		}		
	}
    
	public function TSExec($query=''){
		$savepoint = base64_encode(microtime());
		$this->SBegin($savepoint);

		$insert = $this->TQuery($query);
			
		if($insert){
			$this->SCommit();
			$this->SRelease($savepoint);
			return $insert;
		} else {
			$this->SRollback($savepoint);
			return FALSE;
		}		
	}

	public function TSCount($table,$query='',$values=array()){
		$savepoint = base64_encode(microtime());
		$this->SBegin($savepoint);

		$insert = $this->Count($table,$query,$values);
			
		if($insert){
			$this->SCommit();
			$this->SRelease($savepoint);
			return $insert;
		} else {
			$this->SRollback($savepoint);
			return FALSE;
		}		
	}

	public function TSSelect($table,$elements=array('*'),$query='',$values=array()){
		$savepoint = base64_encode(microtime());
		$this->SBegin($savepoint);

		$insert = $this->Select($table,$elements,$query,$values);
			
		if($insert){
			$this->SCommit();
			$this->SRelease($savepoint);
			return $insert;
		} else {
			$this->SRollback($savepoint);
			return FALSE;
		}		
	}

	public function TSInsertIF($table,$elements,$query="",$values=array()){
		$savepoint = base64_encode(microtime());
		$this->SBegin($savepoint);

		$insert = $this->InsertIF($table,$elements,$query,$values);
			
		if($insert){
			$this->SCommit();
			$this->SRelease($savepoint);
			return TRUE;
		} else {
			$this->SRollback($savepoint);
			return FALSE;
		}		
	}
	public function TSInsertIFNot($table,$elements,$query="",$values=array()){
		$savepoint = base64_encode(microtime());
		$this->SBegin($savepoint);

		$insert = $this->InsertIfNot($table,$elements,$query,$values);
			
		if($insert){
			$this->SCommit();
			$this->SRelease($savepoint);
			return TRUE;
		} else {
			$this->SRollback($savepoint);
			return FALSE;
		}		
	}

	public function TSInsertUpdate($table,$elements,$query="",$values=array()){
		$savepoint = base64_encode(microtime());
		$this->SBegin($savepoint);

		$insert = $this->InsertUpdate($table,$elements,$query,$values);
			
		if($insert){
			$this->SCommit();
			$this->SRelease($savepoint);
			return TRUE;
		} else {
			$this->SRollback($savepoint);
			return FALSE;
		}		
	}

	public function TSInsert($table,$elements){
		$savepoint = base64_encode(microtime());
		$this->SBegin($savepoint);

		$insert = $this->Insert($table,$elements);
			
		if($insert){
			$this->SCommit();
			$this->SRelease($savepoint);
			return TRUE;
		} else {
			$this->SRollback($savepoint);
			return FALSE;
		}		
	}

	public function TSUpdate($table,$elements,$query="",$values=array()){
		$savepoint = base64_encode(microtime());
		$this->SBegin($savepoint);

		$insert = $this->Update($table,$elements,$query,$values);
			
		if($insert){
			$this->SCommit();
			$this->SRelease($savepoint);
			return TRUE;
		} else {
			$this->SRollback($savepoint);
			return FALSE;
		}		
	}

	public function TSDelete($table,$query="",$values=array()){
		$savepoint = base64_encode(microtime());
		$this->SBegin($savepoint);

		$insert = $this->Delete($table,$query,$values);
			
		if($insert){
			$this->SCommit();
			$this->SRelease($savepoint);
			return TRUE;
		} else {
			$this->SRollback($savepoint);
			return FALSE;
		}		
	}

	public function TSDeleteIFId($table,$id){
		$savepoint = base64_encode(microtime());
		$this->SBegin($savepoint);

		$insert = $this->DeleteIFId($table,$id);
			
		if($insert){
			$this->SCommit();
			$this->SRelease($savepoint);
			return TRUE;
		} else {
			$this->SRollback($savepoint);
			return FALSE;
		}		
	}

	public function TSCreateTable($table,$elements,$addid=TRUE){
		$savepoint = base64_encode(microtime());
		$this->SBegin($savepoint);

		$insert = $this->createTable($table,$elements,$addid);
			
		if($insert){
			$this->SCommit();
			$this->SRelease($savepoint);
			return TRUE;
		} else {
			$this->SRollback($savepoint);
			return FALSE;
		}		
	}

	public function TSDropTable($table){
		$savepoint = base64_encode(microtime());
		$this->SBegin($savepoint);

		$insert = $this->dropTable($table);
			
		if($insert){
			$this->SCommit();
			$this->SRelease($savepoint);
			return TRUE;
		} else {
			$this->SRollback($savepoint);
			return FALSE;
		}		
	}

	public function TQuery($query=''){
		$this->Begin();

		$insert = $this->Query($query);
			
		if($insert){
			$this->Commit();
			return $insert;
		} else {
			$this->Rollback();
			return FALSE;
		}		
	}

	public function TPrepare($query='',$values=array()){
		$this->Begin();

		$insert = $this->Prepare($query,$values);
			
		if($insert){
			$this->Commit();
			return $insert;
		} else {
			$this->Rollback();
			return FALSE;
		}		
	}
    
	public function TExec($query=''){
		$savepoint = base64_encode(microtime());
		$this->Begin();

		$insert = $this->TQuery($query);
			
		if($insert){
			$this->Commit();
			return $insert;
		} else {
			$this->Rollback();
			return FALSE;
		}		
	}

	public function TCount($table,$query='',$values=array()){
		$this->Begin();

		$insert = $this->Count($table,$query,$values);
			
		if($insert){
			$this->Commit();
			return $insert;
		} else {
			$this->Rollback();
			return FALSE;
		}		
	}

	public function TSelect($table,$elements=array('*'),$query='',$values=array()){
		$this->Begin();

		$insert = $this->Select($table,$elements,$query,$values);
			
		if($insert){
			$this->Commit();
			return $insert;
		} else {
			$this->Rollback();
			return FALSE;
		}		
	}

	public function TInsertIF($table,$elements,$query="",$values=array()){
		$this->Begin();

		$insert = $this->InsertIF($table,$elements,$query,$values);
			
		if($insert){
			$this->Commit();
			return TRUE;
		} else {
			$this->Rollback();
			return FALSE;
		}		
	}
	public function TInsertIFNot($table,$elements,$query="",$values=array()){
		$this->Begin();

		$insert = $this->InsertIfNot($table,$elements,$query,$values);
			
		if($insert){
			$this->Commit();
			return TRUE;
		} else {
			$this->Rollback();
			return FALSE;
		}		
	}

	public function TInsertUpdate($table,$elements,$query="",$values=array()){
		$this->Begin();

		$insert = $this->InsertUpdate($table,$elements,$query,$values);
			
		if($insert){
			$this->Commit();
			return TRUE;
		} else {
			$this->Rollback();
			return FALSE;
		}		
	}

	public function TInsert($table,$elements){
		$this->Begin();

		$insert = $this->Insert($table,$elements);
			
		if($insert){
			$this->Commit();
			return TRUE;
		} else {
			$this->Rollback();
			return FALSE;
		}		
	}

	public function TUpdate($table,$elements,$query="",$values=array()){
		$this->Begin();

		$insert = $this->Update($table,$elements,$query,$values);
			
		if($insert){
			$this->Commit();
			return TRUE;
		} else {
			$this->Rollback();
			return FALSE;
		}		
	}

	public function TDelete($table,$query="",$values=array()){
		$this->Begin();

		$insert = $this->Delete($table,$query,$values);
			
		if($insert){
			$this->Commit();
			return TRUE;
		} else {
			$this->Rollback();
			return FALSE;
		}		
	}

	public function TDeleteIFId($table,$id){
		$this->Begin();

		$insert = $this->DeleteIFId($table,$id);
			
		if($insert){
			$this->Commit();
			return TRUE;
		} else {
			$this->Rollback();
			return FALSE;
		}		
	}

	public function TCreateTable($table,$elements,$addid=TRUE){
		$this->Begin();

		$insert = $this->createTable($table,$elements,$addid);
			
		if($insert){
			$this->Commit();
			return TRUE;
		} else {
			$this->Rollback();
			return FALSE;
		}		
	}

	public function TDropTable($table){
		$this->Begin();

		$insert = $this->dropTable($table);
			
		if($insert){
			$this->Commit();
			return TRUE;
		} else {
			$this->Rollback();
			return FALSE;
		}		
	}

    public function __destruct() {
        $this->db = NULL;
        unset($this->db);
    }

    function GetFreeId($tmp){
        if (!empty($tmp)){
            $this->sortby($tmp,'id');
            foreach ($tmp as $pos => $val) {
                $i =$pos+1;
                if ($i > $val['id']) {
                    return $i;
                }
            }
            return $i;
        }
    }


    public function createTableRotate($table,$gprx) {
        $data=$this->data;
        if ($data['type']=='sqlsrv') {
            $this->sql['']="IF OBJECT_ID ('$table', 'U') IS NOT NULL".
            "DROP TABLE  $table;".
            "CREATE TABLE  $table (".
            "id INTEGER NOT NULL PRIMARY KEY IDENTITY(1,1),".
            "name varchar(255),".
            "value TEXT DEFAULT '',".
            "idx INTEGER DEFAULT 0,".
            "gprx varchar(255) DEFAULT '$gprx');";
        } elseif ($data['type']=='pgsql') {
            $this->sql['']="DROP TABLE IF EXISTS $table;".
            "CREATE SEQUENCE ".$table."_id_seq;".
            "CREATE TABLE IF NOT EXISTS test (".
            "id INTEGER NOT NULL PRIMARY KEY,".
            "name varchar(255) NOT NULL,".
            "value TEXT DEFAULT '',".
            "idx INTEGER NOT NULL,".
            "gprx varchar(255)  NOT NULL DEFAULT '$gprx');".
            "ALTER TABLE $table ALTER id SET DEFAULT NEXTVAL('".$table."_id_seq');";
        } elseif ($data['type']=='mysql') {
            $this->sql['']="DROP TABLE IF EXISTS $table;".
            "CREATE TABLE IF NOT EXISTS $table (".
            "id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,".
            "name varchar(255) NOT NULL,".
            "value TEXT,".
            "idx int(99) DEFAULT 1,".
            "gprx varchar(255) NOT NULL DEFAULT '$gprx');";
        } elseif ($data['type']=='sqlite') {
            $this->sql['']="DROP TABLE IF EXISTS $table;".
            "CREATE TABLE IF NOT EXISTS $table (".
            "id INTEGER NOT NULL PRIMARY KEY,".
            "name varchar(255) NOT NULL,".
            "value TEXT DEFAULT '',".
            "idx int(99) DEFAULT 1,".
            "gprx varchar(255) NOT NULL DEFAULT '$gprx');";
        }
        try {
            $add = $this -> db -> exec($this->sql['createTableRotate']);
            return TRUE;
        } catch(Exception $e){
            return FALSE;
        }
    }


/**
* Sort array by key
* @param Array $array
* @param String $subkey
* @param bool $sort_ascending
*/
function sortby(&$array, $subkey="", $sort_ascending=TRUE) {
	if (count($array))
	$temp_array[key($array)] = array_shift($array);
	foreach($array as $key => $val){
		$offset = 0;
		$found = false;
		foreach($temp_array as $tmp_key => $tmp_val) {
			if(!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey])) {
				$temp_array = array_merge((array)array_slice($temp_array,0,$offset), array($key => $val), array_slice($temp_array,$offset));
				$found = true;
			}
			$offset++;
		}
		if(!$found) $temp_array = array_merge($temp_array, array($key => $val));
	}
	if ($sort_ascending) $array = array_reverse($temp_array);
	else $array = $temp_array;
}
}
?>