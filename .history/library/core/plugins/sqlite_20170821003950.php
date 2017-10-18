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

class sqlite {
    public function __construct($data)
    {
        try {
            $this->data = $data;
            $database_name = ROOT.DS.'database'.DS. $this->data['database'].'.db';
            $this->db = new \PDO($this->data['type'].':'. $database_name);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            $err = $this->db->errorInfo();
            if($err[0]>0){
                throw new SystemException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
            }

        } catch (\PDOException $e){
            //handle PDO
            throw new SystemException( $e->getMessage( ) , (int)$e->getCode( ) );
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
        'dropTable' => "DROP TABLE IF EXISTS ".$args[1].";",
        'listTables' => "SELECT name FROM sqlite_master WHERE type='table';",
        'createTableRotate' => ""
        );
        return $sql[$args[0]];
    }
}


?>