<?php
class Layout extends XSLRender {

public $registered;
public $disabled;
public $enabled;
public $layouts;
public $layout_group;
public $mode;

	public function Init(){

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

		Config::$data['layouts']['current'] = $this->layout_group;
		//$this->SetView(SYS.V.'index');
		//var_dump($this->layouts);
		$types = array('module','route','layout');
		$attr = serialize(array('id'=>'','class'=>'row','style'=>''));
		$data = array(
			array('id'=>1,'index'=>1,'type'=>'module','name'=>'_name','group'=>'one','value'=>'one','category'=>'layout','option'=>"1",'data'=>''),
			array('id'=>2,'index'=>1,'type'=>'module','name'=>'_controller','group'=>'one','value'=>'one','category'=>'layout','option'=>"2",'data'=>''),
			array('id'=>3,'index'=>1,'type'=>'module','name'=>'_group','group'=>'one','value'=>'','category'=>'layout','option'=>"2",'data'=>''),
			array('id'=>4,'index'=>1,'type'=>'module','name'=>'_view','group'=>'one','value'=>'one','category'=>'layout','option'=>"2",'data'=>''),
			array('id'=>5,'index'=>1,'type'=>'module','name'=>'_pos','group'=>'one','value'=>1,'category'=>'layout','option'=>"2",'data'=>''),
			array('id'=>6,'index'=>1,'type'=>'module','name'=>'_attr','group'=>'one','value'=>'a:3:{s:2:"id";s:0:"";s:5:"class";s:3:"row";s:5:"style";s:0:"";}','category'=>'layout','option'=>"2",'data'=>''),
			array('id'=>7,'index'=>1,'type'=>'module','name'=>'_type','group'=>'one','value'=>'module','category'=>'layout','option'=>"2",'data'=>''),

			array('id'=>8,'index'=>2,'type'=>'route','name'=>'_name','group'=>'two','value'=>'two','category'=>'layout','option'=>"1",'data'=>''),
			array('id'=>9,'index'=>2,'type'=>'route','name'=>'_controller','group'=>'two','value'=>'two','category'=>'layout','option'=>"2",'data'=>''),
			array('id'=>10,'index'=>2,'type'=>'route','name'=>'_group','group'=>'two','value'=>'','category'=>'layout','option'=>"2",'data'=>''),
			array('id'=>11,'index'=>2,'type'=>'route','name'=>'_view','group'=>'two','value'=>'two','category'=>'layout','option'=>"2",'data'=>''),
			array('id'=>12,'index'=>2,'type'=>'route','name'=>'_pos','group'=>'two','value'=>1,'category'=>'layout','option'=>"2",'data'=>''),
			array('id'=>13,'index'=>2,'type'=>'route','name'=>'_attr','group'=>'two','value'=>'a:1:{s:5:"style";s:0:"";}','category'=>'layout','option'=>"2",'data'=>''),
			array('id'=>14,'index'=>2,'type'=>'route','name'=>'_type','group'=>'two','value'=>'route','category'=>'layout','option'=>"2",'data'=>''),
		);
		//var_dump($data);
		$aout=$this->array_search_rotate($data,'one');
		var_dump($aout);
		$allout=$this->array_rotate($data);
		var_dump($allout);
		$allupdateout=$this->array_update_rotate_all($data,$aout);
		var_dump($allupdateout);
		$this->ViewData('layout', '');
			//$this->data->layout->addChild('views', $out);
		$this->Layouts();

	}
	public function array_update_rotate_all($data,$update){

		$updateout = array('id'=>14,'index'=>2,'type'=>'route','name'=>'_type','group'=>'two','value'=>'route','category'=>'layout','option'=>"2",'data'=>'');
		$aout = array();
		$indexed = 1;
		foreach ($data as $items) {
			$item = $items['index'];
			$values = array();
				foreach ($data as $value) {
					if($item===$value['index']){
						if(!$indexed){
							$values[$value['name']]=$value['value'];
						} else {
							$values[$value['name']]['data']=$value['value'];
							$values[$value['name']]['index']=$value['id'];
						}

					foreach ($update as $key => $entry) {
						echo $entry['data'];
						if($value['name']==$key){
							$updateout['name']=$entry['data'].' bb';
						}
					}
					}
				}
				$aout[$items['index']]=$values;
				$i=0;
					//var_dump($values);

		}

		return $updateout;
	}

	public function array_search_rotate($data,$search_value='',$search_name='_name',$_value='value',$_name='name',$indexed=0){
		$aout = array();
		foreach ($data as $items) {
			if(isset($items[$_name]) && isset($items[$_value])){
			if($search_name==$items[$_name] && $search_value==$items[$_value]){
			$item = $items['index'];
			$values = array();
				foreach ($data as $value) {
					if($item===$value['index']){
						if(!$indexed){
							$values[$value['name']]=$value['value'];
						} else {
							$values[$value['name']]['data']=$value['value'];
							$values[$value['name']]['index']=$value['id'];
						}

					}
				}
				$aout[$items['index']]=$values;
			}
			}
		}
		return $aout;
	}

	public function array_rotate($data,$search_name='_name',$_name='name',$indexed=0){
		$aout = array();
		foreach ($data as $items) {
			if(isset($items[$_name])){
			if($search_name==$items[$_name]){
			$item = $items['index'];
			$values = array();
				foreach ($data as $value) {
					if($item===$value['index']){
						if(!$indexed){
							$values[$value['name']]=$value['value'];
						} else {
							$values[$value['name']]['data']=$value['value'];
							$values[$value['name']]['index']=$value['id'];
						}

					}
				}
				$aout[$items['index']]=$values;
			}
			}
		}
		return $aout;
	}

public function Layouts($layouts=null){

}
	public function Layouts2($group='main'){
		$array = $this->layouts;
		$enabled = $this->enabled;
		$disabled = $this->disabled;
		$mode = $this->mode;
		$group = $this->layout_group;
		if(isset($array[0]['pos'])){
		$this->sksort($array,'pos');
		$check = array('pos', 'name','module','view','class','group','attrid');
		$yes = TRUE;
//var_dump($enabled);
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
				$content->layout_group = $value['name'];
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
				$content->layout_group = $value['name'];
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
			var_dump($enabled);
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