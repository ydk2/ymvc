<?php
class One extends XSLRender {

	public function onInit(){
		// call in __constructor
		$this->model = new stdclass;
		if(Helper::Get('inside_errors') == 11023){
			$this->error = 11023;
		}
		$this->ViewData('links', "" );
		$links = $this->data->links->addChild('a','Index');
		$links->addAttribute('href', HOST_URL);
		$links = $this->data->links->addChild('a','Two');
		$links->addAttribute('href', HOST_URL.'?two=two');
		$links = $this->data->links->addChild('a','Two &amp; One');
		$links->addAttribute('href', HOST_URL.'?two=two&one=one');
		$links = $this->data->links->addChild('a','Two and One and php view');
		$links->addAttribute('href', HOST_URL.'?two=two&one=one&phpcall=phpcall');
		$links = $this->data->links->addChild('a','Load only PHP view');
		$links->addAttribute('href', HOST_URL.'?phpview=yes');
		$links = $this->data->links->addChild('a','Load Test view');
		$links->addAttribute('href', HOST_URL.'?test=yes');
		$links = $this->data->links->addChild('a','Throw Error');
		$links->addAttribute('href', HOST_URL.'?errors=110');
		$links = $this->data->links->addChild('a','Throw Error inside controller');
		$links->addAttribute('href', HOST_URL.'?inside_errors=11023');
		$links = $this->data->links->addChild('a','Second throw Error inside controller');
		$links->addAttribute('href', HOST_URL.'?one=one&two=two&inside_errors=11023');

		$links = $this->data->links->addChild('a','emulate logout');
		$links->addAttribute('href', HOST_URL.'?one=one&two=two&access=10');
		$links = $this->data->links->addChild('a','emulate login mod');
		$links->addAttribute('href', HOST_URL.'?one=one&two=two&access=2');

		$links = $this->data->links->addChild('a','emulate login user');
		$links->addAttribute('href', HOST_URL.'?one=one&two=two&access=5');

		$links = $this->data->links->addChild('a','xsl');
		$links->addAttribute('href', HOST_URL.'?load=xsl');

		$links = $this->data->links->addChild('a','php');
		$links->addAttribute('href', HOST_URL.'?load=php');

		$links = $this->data->links->addChild('a','theme');
		$links->addAttribute('href', HOST_URL.'?load=theme');

		$links = $this->data->links->addChild('a','route');
		$links->addAttribute('href', HOST_URL.'?load=route');

		$links = $this->data->links->addChild('a','Docs');
		$links->addAttribute('href', HOST_URL.'docs');
		
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
		if($this->error == 11023) {
			$this->Exceptions($this->model,SYS.V.'errors'.DS.'info',SYS.C.'errors'.DS.'systemerror');
			$this->exception->setParameter('','inside','yes');
			$this->exception->setParameter('','show_link','yes');
			$this->exception->ViewData('title', "Inside Error!!! ".$this->error);
			$this->exception->ViewData('header', "Controller Error!!!");
			$this->exception->ViewData('alert',"<b>Controller catch inside error:  </b>");
			$this->exception->ViewData('error', $this->error);
		}
		//$this->SetView(SYS.V.'time');
		$this->ViewData('title', 'Section One');
		$this->ViewData('message', " Content for One" );

		//echo $this->data->links->asXml();
//	if($this->error > 0) $this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'errors');
	}	

	public function onException(){
		return TRUE;
	}
}
?>