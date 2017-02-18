<?php
/**
 * 
 */
class SystemData extends DBConnect {
	public $dump;
	public $datalist;
	function __construct($import=FALSE)
	{
		# code...
		$data=Config::$data['default']['database'];
		$this->time = get_time();
        $this ->Connect($data['type'], $data['name'], $data['host'],$data['user'], $data['pass']);
	}
	public function check($array){

	}
	public function getSettings($settings){
		return unserialize(file_get_contents(Config::$data[$settings]));
	}

}

?>