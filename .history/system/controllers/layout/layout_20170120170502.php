<?php
class Layout extends XSLRender {

public $registered;
public $disabled;
public $enabled;
public $layouts;
public $layout_group;
public $mode;

	public function Init(){
		
		return TRUE;
	}

	public function onEnd(){
		// call after render view
		//if($this->error > 0) $this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'error');
		return TRUE;
	}

	public function Destruct(){
		// call in __destructor
		return TRUE;
	}

	public function Run(){
		// call before render view

		if(isset($this->model->registered) &&  $this->model->registered != ""){
			$this->registered = $this->model->registered;
		} else {
			$this->registered = array("layout");
		}
		if(isset($this->model->disabled)) $this->disabled = $this->model->disabled;
		if(isset($this->model->enabled)) $this->enabled = $this->model->enabled;
		if(isset($this->model->layouts)) $this->layouts = $this->model->layouts;
		if(isset($this->model->layout_group)) $this->layout_group = $this->model->layout_group;
		$this->mode = (isset($this->model->mode) && $this->model->mode!="")?$this->model->mode:SYS;
		Config::$data['layouts']['current'] = $this->layout_group;
		//$this->SetView(SYS.V.'index');
		var_dump($this->enabled);
		$this->Layouts();
		
	}

	public function Layouts($group='main'){
		$array = $this->layouts;
		$enabled = $this->enabled;
		$disabled = $this->disabled;
		$mode = $this->mode;
		$group = $this->layout_group;
		if(isset($array[0]['pos'])){
		$this->sksort($array,'pos');
		$check = array('pos', 'name','module','view','class','group','attrid');
		$yes = TRUE;
		
		$this->ViewData('layout', '');
		foreach ($array as $value) {
			foreach ($check as $is) {
				if(!array_key_exists($is,$value)) {
					$yes = FALSE;
					break;
				}
			}

			if($value['group']==$group && $yes && $value['group']!=$value['name']){
				if ($value['mode']=='sys') {
					$mode = SYS;
				} elseif ($value['mode']=='app') {
					$mode = APP;
				} elseif ($value['mode']!='') {
					$mode = $value['mode'];
				} else {
					$mode = $this->mode;
				}
			if($value['module']=="layout" && $value['group']!=""){

			if(!in_array($value['name'],$disabled)){
				$this->SetView(SYS.V.'layout'.S.'views');
				$this->SetModule(SYS.V.'layout'.S.'views',SYS.C.'layout'.S.'layout');
				$content = $this->GetModule(SYS.C.'layout'.S.'layout');
				$content->model->layout_group = $value['name'];
				$contents = ($content)? htmlspecialchars($content->View()):"";
				if($contents!=""){
				$col = $this->data->layout->addChild('views', $contents);

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['attrid']);	
				}
				$content = NULL;
				$contents = NULL;
				$col = NULL;
			}

			} elseif($value['module']=="route" && $value['group']!="route"){

			if(!in_array($value['name'],$disabled)){
				$this->SetView(SYS.V.'layout'.S.'content');
				$this->SetModule(SYS.V.'layout'.S.'content',SYS.C.'layout'.S.'route');
				$content = $this->GetModule(SYS.C.'layout'.S.'route');
				$content->model->attrclass = $value['class'];
				$content->model->mode = $value['mode'];
				$content->model->layout_group = "route";
				$contents = ($content)? htmlspecialchars($content->View()):"";
				if($contents!=""){
				$col = $this->data->layout->addChild('views', $contents);
				$col->addAttribute('class', 'row');
/**
				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['attrid']);
**/
				}
				//var_dump($content);
				$content = NULL;
				$contents = NULL;
				$col = NULL;
			}

			} elseif($value['module']=="section" && $value['group']!=""){

			if(!in_array($value['name'],$disabled)){
				$this->SetView(SYS.V.'layout'.S.'sections');
				$this->SetModule(SYS.V.'layout'.S.'views',SYS.C.'layout'.S.'layout');
				$content = $this->GetModule(SYS.C.'layout'.S.'layout');
				$content->model->layout_group = $value['name'];
				$contents = ($content)? htmlspecialchars($content->View()):"";
				if($contents!=""){
				$col = $this->data->layout->addChild('sections', $contents);

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['attrid']);	
				}
				$content = NULL;
				$contents = NULL;
				$col = NULL;
			}

			}  elseif($value['module']!="section" && $value['module']!="layout" && $value['module']!="route") {
			if(in_array($mode.C.$value['module'], $enabled) && !in_array($mode.C.$value['module'],$disabled) && $this->ControllerExists($mode.C.$value['module'])){
				$this->SetView(SYS.V.'layout'.S.'views');
				if ($value['mode']=='sys' || $value['mode']=="") {
					$mode = SYS;
				} elseif ($value['mode']=='app') {
					$mode = APP;
				} elseif ($value['mode']!='') {
					$mode = $value['mode'];
				} else {
					$mode = $this->mode;
				}
				
				
				$this->SetModule($mode.V.$value['view'],$mode.C.$value['module']);
				$content = $this->GetModule($mode.C.$value['module']);
				$content->model->layout_group = $value['name'];
				$contents = ($content)? htmlspecialchars($content->View()):"";
				if($contents!=""){
				$col = $this->data->layout->addChild('views', $contents);

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['attrid']);	
				}
				$content = NULL;
				$contents = NULL;
				$col = NULL;
				
			}
			}
			}
		}
		}
	}
	public function Sections($array,$disabled,$mode=SYS,$group=''){
		if(isset($array[0]['pos'])){
		$this->sksort($array,'pos');
		$check = array('pos', 'name','module','view','class','model','group','attrid','users');
		$yes = TRUE;
		$this->SetView(SYS.V.'layout'.S.'sections');
		$this->ViewData('layout', '');
		foreach ($array as $value) {
			foreach ($check as $is) {
				if(!array_key_exists($is,$value)) {
					$yes = FALSE;
					break;
				}
			}
			if($value['group']==$group || $value['group']=="" && $yes){
			if($value['module']==$this->registered){
				$this->SetModule(SYS.V.'layout'.S.'sections',SYS.C.'layout'.S.'layout');
				$content = $this->GetModule(SYS.C.'layout'.S.'layout');
				$content->model->layout_group = $value['name'];
				$content = ($content)? htmlspecialchars($content->View()):"";
				if($content!=""){
				$col = $this->data->layout->addChild('sections', $content);

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['attrid']);	
				}
			} else {
			if(in_array($mode.C.$value['module'], $this->model->enabled) && !in_array($mode.C.$value['module'],$disabled) && $this->ControllerExists($mode.C.$value['module'])){
				$col = $this->data->layout->addChild('sections', htmlspecialchars( Loader::get_restricted_view($mode.C.$value['module'],$mode.V.$value['view'])));

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['attrid']);	

			}
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