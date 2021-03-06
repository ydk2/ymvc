<?php
namespace Library\Core\Plugins;

class sqlite
{
	public $db;
	private $data;
	public function __construct($data)
	{

		try {
			
			$this->data = $data;		
			$database_name = ROOT.'database'.DS. $data['database'] . '.db';
			$this->db = new \PDO($data['type'].':'. $database_name);
			$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			
			$err = $this->db->errorInfo();
			if($err[0]>0){
				throw new \Library\Core\SystemException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
			}
			return $this->db;
		} catch (\PDOException $e){
			//handle PDO
			throw new \Library\Core\SystemException( $e->getMessage( ) , (int)$e->getCode( ) );
		}
		var_dump($this);
	}
	public function Sql(){
		$argv = func_get_args();
		$sql = array(
			'Lock'=>"LOCK TABLE $argv[1] $argv[2]"
		);
		return $sql[$argv[0]];
	}
}



?>