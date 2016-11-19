<?php
class Layout extends XSLRender {

	public function onInit(){
		// call in __constructor
		$this->SetModel(SYS.M.'model');
		//$this->SetView(APP.V.strtolower($this->name));
		//echo $this->view;
		if(isset($_GET['error']))
		$this->error = $_GET['error'];
		if($this->error > 0) $this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'error');
	
		return TRUE;
	}

	public function onEnd(){
		// call after render view
		//if($this->error > 0) $this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'error');
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
		$disabled = array('error','errors','data','item','action','layout','test','load');
		$default = array('one'=>'one');
		$array = array('phpexample'=>'layout/php','two'=>'two','one'=>'one');

		$sections = array(
			'phpexample'=>array('layout/php','php','',''),
			'two'=>array('two','','',''),
			'one'=>array('one','','',''),
			);
		$this->sections($sections,$disabled,SYS);
		//$this->ViewData('layout', '');
	/*
		if(Helper::Get('load')=="row") 
		$xml = $this->rows($array,$disabled,SYS);
		if(Helper::Get('load')=="col") 
		$xml = $this->columns($array,$disabled,SYS);
		if(Helper::Get('load')=="sec") 
		$xml = $this->sections($sections,$disabled,SYS);
	*/
		//echo $xml;
		//$this->ViewData('content',simplexml_load_string($xml));
		//simplexml_import_xml($this->data,$xml);
		//var_dump($this->data);
	}

	public function sections($array,$disabled,$mode=SYS){
		$this->ViewData('layout', '');
		foreach ($array as $key => $value) {
			if(!in_array($key,$disabled)){
				$col = $this->data->layout->addChild('sections',Loader::get_restricted_view($mode.C.$key,$mode.V.$value[0]));
				$col->addAttribute('style', $value[3]);
				$col->addAttribute('class', $value[2]);
				$col->addAttribute('id', $value[1]);	
			}
		}
	}


	public function columns($array,$disabled,$mode=SYS){
		$this->ViewData('layout', '');
		foreach ($array as $key => $value) {
			if(!in_array($key,$disabled)){
				$col = $this->data->layout->addChild('columns',Loader::get_restricted_view($mode.C.$key,$mode.V.$value));
				$col->addAttribute('size', "6");	
			}
		}
	}

	public function rows($array,$disabled,$mode=SYS){
		$this->ViewData('layout', '');
		foreach ($array as $key => $value) {
			if(!in_array($key,$disabled)){
				$this->data->layout->addChild('rows',Loader::get_restricted_view($mode.C.$key,$mode.V.$value));	
			}
		}
	}

	public function route($array,$disabled,$default,$mode=SYS){
		$controller = key($default);
		$view = $default[key($default)];
		$this->ViewData('layout', '');
		foreach ($array as $key => $value) {
			if(!in_array($key,$disabled)){
				$col = $this->data->layout->addChild('columns',Loader::get_restricted_view($mode.C.$key,$mode.V.$value));	
			}
		}
		if(!isset($this->data->layout->sections)){ // get_restricted_view
			$col = $this->data->layout->addChild('columns',Loader::get_restricted_view($mode.V.$controller,$mode.C.$view));
		}
	}	
}
?>