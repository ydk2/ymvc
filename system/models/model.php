<?php
/**
 * 
 */
class model extends DBConnect {
	public $dump;
	function __construct($import=NULL)
	{
		# code...
		$data=Config::$data['default']['database'];
		//$data['type'] = 'sqlite';
		//var_dump($data);
		$this->time = get_time();
        $this ->Connect($data['type'], $data['name'], $data['host'],$data['user'], $data['pass']);
		if($import!== NULL){
		if ($data['type']=='sqlsrv') {
			$queries = file_get_contents(ROOT.DATA.'sqlsrv.sql');
			$queries = explode(";", $queries);
		} elseif ($data['type']=='pgsql') {
			$queries = file_get_contents(ROOT.DATA.'pgsql.sql');
			$queries = explode(";", $queries);
		} elseif ($data['type']=='mysql') {
			$queries = file_get_contents(ROOT.DATA.'mysql.sql');
		} elseif ($data['type']=='sqlite') {
			$queries = file_get_contents(ROOT.DATA.'db.sql');
			$queries = explode(";", $queries);
		}
		
    	foreach ($queries as $query) {
        	$this->db->query($query);
    	}
		}
		
	}
	public function check($array){
		# code...
		$page = $this -> db -> prepare("SELECT * FROM ? ORDER BY id");
		$page -> execute($array);
		$item = $page -> fetchAll(PDO::FETCH_NAMED);
		if ($item) :
			return dump($item);
		endif;
	}
	public function get($table,$array){
		# code...
		$page = $this -> db -> prepare("SELECT * FROM ".$table." ORDER BY ?");
		$page -> execute($array);
		$item = $page -> fetchAll(PDO::FETCH_NAMED);
		if ($item) :
			return $item;
		endif;
	}
}

?>