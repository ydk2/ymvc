<?php
class Modules extends PHPRender {

	public function onInit(){
		// call in __constructor
		$this->registerPHPFunctions();
		Intl::set_path(SYS.LANGS.$this->name);
		$langs = Intl::available_locales(Intl::PO);
		Intl::po_locale_plural(Helper::Session('locale'),$this->name);
		
		return TRUE;
	}

	public function onEnd(){
		// call after render view
		return TRUE;
	}

	public function onDestruct(){
		// call in __destructor
		return TRUE;
	}


	public function onException(){
			$this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'systemerror');

			$this->exception->ViewData('title', "Error!!! ".$this->error);
			$this->exception->ViewData('header', $this->emessage);
			$this->exception->ViewData('alert',"<b>Please check loader options</b> Catch error:  ");
			$this->exception->ViewData('error', $this->error);
		//return TRUE;
	}
	
	public function onRun(){

	}

}
?>