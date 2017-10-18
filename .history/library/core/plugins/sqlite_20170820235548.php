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
	public function __construct($data = null)
	{
		# code...

try {
	$this->data = $data; 
    $database_name = ROOT.DS.'database'.DS. $this->data['database'].'.db';
    $this->db = new \PDO('sqlite:'. $database_name);
    $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    
    $err = $this->db->errorInfo();
    if($err[0]>0){
        throw new SystemException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
	}
	
	//$args = $this->args; 


} catch (\PDOException $e){
    //handle PDO
    throw new SystemException( $e->getMessage( ) , (int)$e->getCode( ) );
}

	}

    public function Sql(){
		$args = func_get_args();    
		$this->sql = array(
			'quote' => "",
			'Lock'=>"LOCK TABLE $args[1] $args[2];",
			'UnLock' => "UNLOCK TABLES;",
			'isLock' => "PRAGMA lock_status;",
			'SBegin' => "",
			'SCommit' => "",
			'SRelease' => "",
			'SRollback' => "",
			'Begin' => "",
			'Commit' => "",
			'Release' => "",
			'Rollback' => "",
			'Query' => "",
			'Prepare' => "",
			'Exec' => "",
			'createTable' => "CREATE TABLE IF NOT EXISTS ".$args[1]." (".
			$args[2].
			");",
			'dropTable' => "",
			'listTables' => "",
			'Count' => "",
			'Delete' => "",
			'Insert' => "",
			'InsertIF' => "",
			'InsertIfNot' => "",
			'InsertUpdate' => "",
			'Update' => "",
			'Select' => "",
			'DeleteIFId' => "",
			'TSQuery' => "",
			'TSPrepare' => "",
			'TSExec' => "",
			'TSCount' => "",
			'TSSelect' => "",
			'TSInsertIF' => "",
			'TSInsertIFNot' => "",
			'TSInsertUpdate' => "",
			'TSInsert' => "",
			'TSUpdate' => "",
			'TSDelete' => "",
			'TSDeleteIFId' => "",
			'TSCreateTable' => "",
			'TSDropTable' => "",
			'TQuery' => "",
			'TPrepare' => "",
			'TExec' => "",
			'TCount' => "",
			'TSelect' => "",
			'TInsertIF' => "",
			'TInsertIFNot' => "",
			'TInsertUpdate' => "",
			'TInsert' => "",
			'TUpdate' => "",
			'TDelete' => "",
			'TDeleteIFId' => "",
			'TCreateTable' => "",
			'TDropTable' => "",
			'createTableRotate' => "",
		);
		
        return $this->sql[$args[0]];
    }
}


?>