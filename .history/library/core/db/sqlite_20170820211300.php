<?php
namespace Library\Core\BD;
class Sqlite
{
	public $db;
	public function __construct($data)
	{
		try {			
			$database_name = ROOT.DATA.'database'.DS. $data['database'] . '.db';
			$this->db = new \PDO($data['engin'].':'. $database_name);
			$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			
			$err = $this->db->errorInfo();
			if($err[0]>0){
				throw new SystemException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
			}
			return $this->db;
		} catch (\PDOException $e){
			//handle PDO
			throw new SystemException( $e->getMessage( ) , (int)$e->getCode( ) );
		}
	}
	public function Sql(){
		$argv = func_get_args();
		$sql = array(
			'Lock'=>''
		);
		return $sql[$argv[0]];
	}
}



?>