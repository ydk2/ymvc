<?php
class Layout extends XSLRender {

public $registered;
public $disabled;
public $enabled;
public $layouts;
public $layout_group;
public $mode;

	public function onInit(){
		if(isset($this->model->registered)) $this->registered = $this->model->registered;
		if(isset($this->model->disabled)) $this->disabled = $this->model->disabled;
		if(isset($this->model->enabled)) $this->enabled = $this->model->enabled;
		if(isset($this->model->layouts)) $this->layouts = $this->model->layouts;
		if(isset($this->model->layout_group)) $this->layout_group = $this->model->layout_group;
		$this->mode = (isset($this->model->mode) && $this->model->mode!="")?$this->model->mode:SYS;
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
		//if(array_key_exists(array(),)){
			$this->Layouts($this->layouts,$this->disabled,$this->mode,$this->layout_group);
		//}
	}

	public function Layouts($array,$disabled,$mode=SYS,$group=''){
		sksort($array,'pos');
		$check = array('pos', 'name','module','view','class','model','group','attrid','users');
		$this->SetView(SYS.V.'layout:views');
		$this->ViewData('layout', '');
		foreach ($array as $value) {
			if($value['group']==$group || $value['group']==""){
			if(in_array($value['module'], $this->model->registered)){
				$this->SetModule(SYS.V.'layout:views',SYS.C.'layout:layout');
				$content = $this->GetModule(SYS.C.'layout:layout');
				$content->model->layout_group = $value['module'];
				$content = ($content)? htmlspecialchars($content->View()):"";
				if($content!=""){
				$col = $this->data->layout->addChild('views', $content);

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['id']);	
				}
			} else {
			if(in_array($mode.C.$value['module'], $this->model->enabled) && !in_array($mode.C.$value['module'],$disabled) && $this->ControllerExists($mode.C.$value['module'])){
				$col = $this->data->layout->addChild('views', htmlspecialchars( Loader::get_restricted_view($mode.C.$value['module'],$mode.V.$value['view'])));

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['id']);	

			}
			}
			}
		}
	}
	public function Sections($array,$disabled,$mode=SYS,$group=''){
		sksort($array,'pos');
		$this->SetView(SYS.V.'layout:sections');
		$this->ViewData('layout', '');
		foreach ($array as $value) {
			if($value['group']==$group || $value['group']==""){
			if(in_array($value['module'], $this->model->registered)){
				$this->SetModule(SYS.V.'layout:sections',SYS.C.'layout:layout');
				$content = $this->GetModule(SYS.C.'layout:layout');
				$content->model->layout_group = $value['module'];
				$content = ($content)? htmlspecialchars($content->View()):"";
				if($content!=""){
				$col = $this->data->layout->addChild('sections', $content);

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['id']);	
				}
			} else {
			if(in_array($mode.C.$value['module'], $this->model->enabled) && !in_array($mode.C.$value['module'],$disabled) && $this->ControllerExists($mode.C.$value['module'])){
				$col = $this->data->layout->addChild('sections', htmlspecialchars( Loader::get_restricted_view($mode.C.$value['module'],$mode.V.$value['view'])));

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['id']);	

			}
			}
			}
		}
	}
	public function _sections($array,$disabled,$mode=SYS){
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


	public function _views($array,$disabled,$mode=SYS){
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