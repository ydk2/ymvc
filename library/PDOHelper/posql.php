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

use \Library\PDOHelperException as PDOHelperException;

class posql {
    public function __construct($data)
    {
        $this->data = $data;
        if (!file_exists(ROOTDB.DS.'vendors'.DS.'posql'.DS.'posql.php')) {
            throw new PDOHelperException('PoSQL Database engine not exist.',420500);
        }
		require_once ROOTDB.DS.'vendors'.DS.'posql'.DS.'posql.php';
		$database_name = $this->data['host'].DS.$this->data['database'].'.db';
		//echo $database_name;
		if (!file_exists($database_name.'.php')) {
			throw new PDOHelperException('Database not exist.',420404);
		}

		$this->pdo = new Posql($database_name);
		//$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		
		if ($this->pdo -> isError()) {
			abort($this->pdo);
			throw new PDOHelperException('Can\'t connect to Database.',420502);
		}
        
    }
    
    public function Sql(){
        $args = func_get_args();
        $sql = @array(
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
        "${args[3]} ${args[4]} NOT NULL PRIMARY KEY AUTO_INCREMENT,".
        $args[2].
        ");",
        'dropTable' => "DROP TABLE IF EXISTS ".$args[1].";",
        'listTables' => "SELECT name FROM sqlite_master WHERE type='table';",
        'createTableRotate' => "",
        'Columns'=>"SHOW columns FROM ${args[1]}",
        'Columns_data'=>"Field"
        );
        return $sql[$args[0]];
    }
}


?>