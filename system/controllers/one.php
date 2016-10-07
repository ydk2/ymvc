<?php
class One extends XCoreRender {

	public function onInit(){
		// call in __constructor
		$this->model = new stdclass;
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
		//$this->SetView(SYS.V.'time');
		$this->ViewData('title', 'Section One');
		$this->ViewData('message', " Content for One" );

		$this->ViewData('links', "" );
		$links = $this->data->links->addChild('a','Index');
		$links->addAttribute('href', HOST_URL.'?errors=0');
		$links = $this->data->links->addChild('a','Two');
		$links->addAttribute('href', HOST_URL.'?two=two&errors=0');
		$links = $this->data->links->addChild('a','Two and One');
		$links->addAttribute('href', HOST_URL.'?two=two&one=one&errors=0');
		$links = $this->data->links->addChild('a','Throw Error');
		$links->addAttribute('href', HOST_URL.'?errors=110');
		//echo $this->data->links->asXml();
//	if($this->error > 0) $this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'errors');
	}	
}
?>