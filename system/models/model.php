<?php
/**
 * 
 */
class model extends DBConnect {
	public $dump;
	function __construct()
	{
		# code...
		$data=Config::$data['default']['database'];
		//$data['type'] = 'sqlite';
		//var_dump($data);
		$this->time = get_time();
        $this ->Connect($data['type'], $data['name'], $data['host'],$data['user'], $data['pass']);
		if(isset($this->import)){
		$queries = file_get_contents(ROOT.CACHE.'database.sql');
		$queries = explode(";", $queries);
    	foreach ($queries as $query) {
        	$this->db->query($query);
    	}
		}
		
	}
	public function check(){
		# code...
		$page = $this -> db -> prepare("SELECT * FROM sitedata ORDER BY id");
		$page -> execute();
		$item = $page -> fetchAll(PDO::FETCH_NAMED);
		if ($item) :
			return dump($item);
		endif;
	}
	public function get(){
		# code...
		$page = $this -> db -> prepare("SELECT * FROM sitedata ORDER BY id");
		$page -> execute();
		$item = $page -> fetchAll(PDO::FETCH_NAMED);
		if ($item) :
			return $item;
		endif;
	}
}

?>