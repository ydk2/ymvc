<?php
class SystemError extends XSLRender {

	public function Init(){
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

	public function Run($model = NULL){
		//$this->error = 40100;
		$this->ViewData('title', $this->model->title);
		$this->ViewData('header', $this->model->header);
		$this->ViewData('alert', $this->model->alert);
		$this->ViewData('links', "" );
		$links = $this->data->links->addChild('a',Intl::_p('Back to Index'));
		$links->addAttribute('href', HOST_URL);
	}
}
?>