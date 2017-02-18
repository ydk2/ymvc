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
	public function setData($settings,$data){
        if(!empty($data)){
            $save = file_put_contents(Config::$data[$settings],serialize($data));
            if(!$save){
                return FALSE;
            } else {
                return TRUE;
            }
        }
	}
	public function getData($settings){
		return unserialize(file_get_contents(Config::$data[$settings]));
	}

}

?>