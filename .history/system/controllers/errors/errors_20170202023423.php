<?php
class Errors extends PHPRender {

	public function Init(){
		// call in __constructor
		$this->registerPHPFunctions();
		return TRUE;
	}


	public function Run($model = NULL){
		$this->ViewData('title', "Error!!! ".$this->ViewData('error'));
		$this->ViewData('header', "Error on site!!!");
		$this->ViewData('alert', "System catch error: ");
	}

}
?>