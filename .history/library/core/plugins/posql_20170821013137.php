<?php
/*
function Sql(){
$argv = func_get_args();
$sql = array(
'Lock'=>"LOCK TABLE $argv[1] $argv[2]"
);
return $sql[$argv[0]];
}
*/

use \Library\Core\SystemException as SystemException;

class posql {
    public function __construct($data)
    {
		$this->data = $data;
		require_once ROOT.VENDORS.'posql.php';
		$database_name = ROOT.DATA.'database'.DS.$this->data['database']. '.db';
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
    
    public function Sql(){
        $args = func_get_args();
        $sql = array(
        'Lock'=>"LOCK TABLE ${args[1]} ${args[2]};",
        'UnLock' => "UNLOCK TABLES;",
        'isLock' => "PRAGMA lock_status;",
        'SBegin' => "BEGIN; SAVEPOINT ${args[1]};",
        'SCommit' => "COMMIT;",
        'SRelease' => "RELEASE ${args[1]};",
        'SRollback' => "ROLLBACK TO ${args[1]};",
        'Begin' => "BEGIN;",
        'Commit' => "COMMIT;",
        'Release' => "RELEASE;",
        'Rollback' => "ROLLBACK;",
        'createTable' => "CREATE TABLE IF NOT EXISTS ".$args[1]." (".
        $args[2].
        ");",
        'createTableid' => "CREATE TABLE IF NOT EXISTS ${args[1]} (".
        "id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,".
        $args[2].
        ");",
        'dropTable' => "DROP TABLE IF EXISTS ".$args[1].";",
        'listTables' => "SELECT name FROM sqlite_master WHERE type='table';",
        'createTableRotate' => ""
        );
        return $sql[$args[0]];
    }
}


?>