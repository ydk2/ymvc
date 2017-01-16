<?php
class Layout extends XSLRender {

	public function onInit(){
		// call in __constructor
		//$this->SetModel(SYS.M.'model');
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
		$disabled = array('error','errors','data','item','action','layout','load');
		$default = array('one'=>'one');
		$array = array('phpexample'=>'layout/php','two'=>'two','one'=>'one');

		$sections = array(
			''=>array('layout/php','php','',''),
			'two'=>array('two','','',''),
			'one'=>array('one','','',''),
			);
		$this->ordered_views($this->model->sections,$this->model->disabled,SYS,$this->model->layout_group);
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
		//var_dump($this->model->sections);
	}

	public function ordered_views($array,$disabled,$mode=SYS,$group='main'){
		sksort($array,'pos');
		$this->ViewData('layout', '');
		foreach ($array as $value) {
			if($value['group']==$group || $value['group']==""){
			if(in_array($mode.C.$value['module'], Config::$data['enabled']) && !in_array($mode.C.$value['module'],$disabled) && $this->ControllerExists($mode.C.$value['module'])){
				$col = $this->data->layout->addChild('views', htmlspecialchars( Loader::get_restricted_view($mode.C.$value['module'],$mode.V.$value['view'])));

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['id']);	

			} elseif(in_array($value['module'], Config::$data['layouts'])){
				$this->SetModule(SYS.V.'layout:views',SYS.C.'layout:layout');
				$content = $this->GetModule(SYS.C.'layout:layout');
				$content->model->layout_group = $value['module'];
				$content = ($content)? htmlspecialchars($content->View()):"";
				$col = $this->data->layout->addChild('views', $content);

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['id']);	

			}
			}
		}
	}
	public function ordered_sections($array,$disabled,$mode=SYS,$group='main'){
		sksort($array,'pos');
		$this->ViewData('layout', '');
		foreach ($array as $value) {
			if($value['group']==$group || $value['group']==""){
			if(in_array($mode.C.$value['module'], Config::$data['enabled']) && !in_array($mode.C.$value['module'],$disabled) && $this->ControllerExists($mode.C.$value['module'])){
				$col = $this->data->layout->addChild('sections', htmlspecialchars( Loader::get_restricted_view($mode.C.$value['module'],$mode.V.$value['view'])));

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['id']);	

			} elseif(in_array($value['module'], Config::$data['layouts'])){
				$this->SetModule(SYS.V.'layout:views',SYS.C.'layout:layout');
				$content = $this->GetModule(SYS.C.'layout:layout');
				$content->model->layout_group = $value['module'];
				$content = ($content)? htmlspecialchars($content->View()):"";
				if($content!=""){
				$col = $this->data->layout->addChild('sections', $content);

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['id']);	
				}
			}
			}
		}
	}
	public function sections($array,$disabled,$mode=SYS){
		$this->ViewData('layout', '');
		foreach ($array as $key => $value) {
			if(!in_array($key,$disabled)){
				$col = $this->data->layout->addChild('sections',htmlspecialchars(Loader::get_module_view($mode.C.$key,$mode.V.$value[0])));
				$col->addAttribute('style', $value[3]);
				$col->addAttribute('class', $value[2]);
				$col->addAttribute('id', $value[1]);	
			}
		}
	}


	public function views($array,$disabled,$mode=SYS){
		$this->ViewData('layout', '');
		foreach ($array as $key => $value) {
			if(!in_array($key,$disabled)){
				$col = $this->data->layout->addChild('views', htmlspecialchars( Loader::get_restricted_view($mode.C.$key,$mode.V.$value[0])));
				$col->addAttribute('style', $value[3]);
				$col->addAttribute('class', $value[2]);
				$col->addAttribute('id', $value[1]);	
			}
		}
	}


	public function route($array,$disabled,$default,$mode=SYS){
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