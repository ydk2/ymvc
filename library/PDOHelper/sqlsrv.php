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

class sqlsrv {
    public function __construct($data)
    {
        try {
            $this->data = $data;
            if ($this->data['user'] === NULL || $this->data['pass'] === NULL) {
                throw new PDOHelperException('User and Password not filed.');
            }
            $this->pdo = new \PDO($this->data['type'].':Server='.$this->data['host'].';Database='.$this->data['database'].';ConnectionPooling=0', $this->data['user'], $this->data['pass']);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            $err = $this->pdo->errorInfo();
            if($err[0]>0){
                throw new PDOHelperException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
            }
            
        } catch (\PDOException $e){
            //handle \PDO
            throw new PDOHelperException( $e->getMessage( ) , (int)$e->getCode( ) );
        }
        
    }
    
    public function Sql(){
        $args = func_get_args();
        $sql = @array(
        'Lock'=>"LOCK TABLE ${args[1]} ${args[2]};",
        'UnLock' => "UNLOCK TABLES;",
        'isLock' => "SELECT * FROM ${args[1]} WITH(XLOCK,ROWLOCK,READCOMMITTED);",
        'SBegin' => "BEGIN TRAN ${args[1]};",
        'SCommit' => "COMMIT TRAN ${args[1]};",
        'SRelease' => "",
        'SRollback' => "ROLLBACK TRAN ${args[1]};",
        'Begin' => "BEGIN TRAN;",
        'Commit' => "COMMIT TRAN;",
        'Release' => "",
        'Rollback' => "ROLLBACK TRAN;",
        'createTable' => "IF OBJECT_ID ('${args[1]}', 'U') IS NULL \n".
        "CREATE TABLE  ${args[1]} (${args[2]});",
        'createTableid' => "IF OBJECT_ID ('${args[1]}', 'U') IS NULL \n".
        "CREATE TABLE  ${args[1]} (".
        "${args[3]} ${args[4]} NOT NULL PRIMARY KEY IDENTITY(1,1),".
        $args[2].
        ");",
        'dropTable' => "IF OBJECT_ID ('${args[1]}', 'U') IS NOT NULL".
        "DROP TABLE  ${args[1]};",
        'listTables' => "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_CATALOG='".$this->data['database']."';",
        'createTableRotate' => "",
        'Columns'=>"SELECT COLUMN_NAME FROM ".$this->data['database'].".INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'${args[1]}'",
        'Columns_data'=>"COLUMN_NAME"
        );
        return $sql[$args[0]];
    }
}


?>