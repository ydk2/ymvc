<?php
	function convert($size){
	    $unit=array('b','kb','mb','gb','tb','pb');
	    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}
	
	function cpu_get_usage(){
    $load = sys_getloadavg();
    return $load[0];
	}
	
	function dump($var){
    ob_start();
	var_dump($var);
    return ob_get_clean();
	}
	function get_time(){
		# code...
		return microtime(true);
	}
	function get_time_exec($start,$end){
		return ($end - $start)/60;
	}
?>