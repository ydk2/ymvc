<?php
class view extends XCoreRender {

	public function onInit(){
		// call in __constructor
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
		$this->SetView(SYS_V.'time');
		$this->ViewData('time', $this->model->time);
		$this->ViewData('message', " Exec script time: " );
//	if($this->error > 0) $this->Exceptions($this->model,SYS_V.'errors'.DS.'error',SYS_C.'errors'.DS.'errors');
	}	
}
?>