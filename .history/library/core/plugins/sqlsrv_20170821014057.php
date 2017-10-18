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

class sqlsrv {
    public function __construct($data)
    {
        try {
            $this->data = $data;
            if ($this->data['user'] === NULL || $this->data['pass'] === NULL) {
                throw new SystemException('User and Password not filed.');
            }
            $this->db = new \PDO($this->data['type'].':Server='.$this->data['host'].';Database='.$this->data['database'].';ConnectionPooling=0', $this->data['user'], $this->data['pass']);
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
    
    public function Sql(){
        $args = func_get_args();
        $sql = array(
        'Lock'=>"LOCK TABLE ${args[1]} ${args[2]};",
        'UnLock' => "UNLOCK TABLES;",
        'isLock' => "SELECT * FROM ${args[1]} WITH(XLOCK,ROWLOCK,READCOMMITTED);",
        'SBegin' => "BEGIN TRAN ${args[1]};",
        'SCommit' => "COMMIT TRAN ${args[1]};",
        'SRelease' => "",
        'SRollback' => "ROLLBACK TRAN ${args[1]};",
        'Begin' => "BEGIN;",
        'Commit' => "COMMIT;",
        'Release' => "RELEASE;",
        'Rollback' => "ROLLBACK;",
        'createTable' => "CREATE TABLE IF NOT EXISTS ".$args[1]." (".
        $args[2].
        ");",
        'createTableid' => "IF OBJECT_ID ('${args[1]}', 'U') IS NULL".
        "CREATE TABLE  ${args[1]} (".
        "id INTEGER NOT NULL PRIMARY KEY IDENTITY(1,1),".
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