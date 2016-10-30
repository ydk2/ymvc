<?php
class SystemError extends XSLRender {

	public function onInit(){
		// call in __constructor
		$this->registerPHPFunctions();
		$this->ViewData('lang', Helper::Session('locale'));
		$this->setParameter('','fixie','<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		');
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

	public function onRun($model = NULL){
		//$this->error = 40100;
		//$this->ViewData('title', "Error!!! ".$this->ViewData('error'));
		//$this->ViewData('header', "Error on site!!!");
		//$this->ViewData('alert', "System catch error: ");
		$this->ViewData('links', "" );
		$links = $this->data->links->addChild('a',Intl::_p('Back to Index','main_index'));
		$links->addAttribute('href', HOST_URL);
	}
}
?>