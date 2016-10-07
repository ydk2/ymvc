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
//	if($this->error > 0) $this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'errors');
	}	
}
?>