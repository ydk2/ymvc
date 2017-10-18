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
    $this->sql = array(
		'Lock'=>"LOCK TABLE $args[1] $args[2]"
	);

} catch (\PDOException $e){
    //handle PDO
    throw new SystemException( $e->getMessage( ) , (int)$e->getCode( ) );
}

	}
}


?>