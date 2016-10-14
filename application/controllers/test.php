<?php
class Test extends XCoreRender {

	public function onInit(){
		// call in __constructor
		$this->SetModel(SYS.M.'model');
		if(isset($_GET['error']))
		$this->error = $_GET['error'];
		if($this->error > 0) $this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'error');
	
		return TRUE;
	}

	public function onEnd(){
		// call after render view
		if($this->error > 0) $this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'error');
		return TRUE;
	}

	public function onDestruct(){
		// call in __destructor
		return TRUE;
	}

	public function onRun(){
		// call before render view

		//$this->SetView(SYS.V.'index');
		//if($this->error == 404) $this->Exceptions(NULL,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'error');
		$this->routings();
	}
	public function routings(){
		$disabled = array('error','errors','data','item','action','layout','test');
		$default = array('one'=>'one');
		$array = array('one'=>'one','two'=>'two');
		$xml = Router::routing($array,$disabled,$default,SYS);
		//$this->ViewData('content',simplexml_load_string($xml));
		simplexml_import_xml($this->data,$xml);
		//var_dump($this->data);
	}
	
}
?>