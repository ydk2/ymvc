<?php
/**
 * 
 */
class SystemData extends DBConnect {
	public $dump;
	function __construct($import=FALSE)
	{
		# code...
		$data=Config::$data['default']['database'];
		$this->time = get_time();
        $this ->Connect($data['type'], $data['name'], $data['host'],$data['user'], $data['pass']);
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