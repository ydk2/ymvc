<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-25 14:02:30
*/

class Layout extends XSLRender {
    
    public $registered;
    public $disabled;
    public $enabled;
    public $layouts;
    public $layout_group;
    public $default_layout_group;
    public $mode;
    
    public function Init(){
        
        if(isset($this->model->registered) &&  $this->model->registered != ""){
            $this->registered = $this->model->registered;
        } else {
            $this->registered = array("layout");
        }
        $this->default_route_count=0;
    }
    
    public function Run(){
        Config::$data['layouts']['current'] = $this->layout_group;
        $this->ViewData('layout', '');
        $this->Layouts();
    }

	public static function Layouts($model){
		$array=$model->layouts;
		$enabled=$model->enabled;
		$disabled=$model->disabled;
		$mode=(isset($model->mode) && $model->mode!="")?$model->mode:SYS;
		$group=(isset($model->group) && $model->group!="")?$model->group:"main";

		if(isset($array[0]['pos'])){

		$layout = self::get_module(SYS.C.'layout'.S.'layout',SYS.V.'layout'.S.'views',$model);
		$layout->sksort($array,'pos');


		$check = array('pos', 'name','module','view','class','group','attrid');
		$yes = TRUE;

		$layout->ViewData('layout', '');
		foreach ($array as $value) {
			foreach ($check as $is) {
				if(!array_key_exists($is,$value)) {
					$yes = FALSE;
					break;
				}
			}

			if($value['group']==$group && $yes && $value['group']!=$value['name']){
			if($value['module']=="layout" && $value['group']!=""){

			if(!in_array($value['name'],$disabled)){
				$layout->SetView(SYS.V.'layout'.S.'views');
				$layout->SetModule(SYS.V.'layout'.S.'views',SYS.C.'layout'.S.'layout');
				$content = $this->GetModule(SYS.C.'layout'.S.'layout');
				$content->model->layout_group = $value['name'];
				$contents = ($content)? htmlspecialchars($content->View()):"";
				if($contents!=""){
				$col = $layout->data->layout->addChild('views', $contents);

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
				$layout->SetView(SYS.V.'layout'.S.'content');
				$layout->SetModule(SYS.V.'layout'.S.'content',SYS.C.'layout'.S.'route');
				$content = $layout->GetModule(SYS.C.'layout'.S.'route');
				$content->model->layout_group = "route";
				$contents = ($content)? htmlspecialchars($content->View()):"";
				if($contents!=""){
				$col = $layout->data->layout->addChild('views', $contents);

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['attrid']);
				}
				$content = NULL;
				$contents = NULL;
				$col = NULL;
			}

			} elseif($value['module']=="section" && $value['group']!=""){

			if(!in_array($value['name'],$disabled)){
				$layout->SetView(SYS.V.'layout'.S.'sections');
				$layout->SetModule(SYS.V.'layout'.S.'views',SYS.C.'layout'.S.'layout');
				$content = $layout->GetModule(SYS.C.'layout'.S.'layout');
				$content->model->layout_group = $value['name'];
				$contents = ($content)? htmlspecialchars($content->View()):"";
				if($contents!=""){
				$col = $layout->data->layout->addChild('sections', $contents);

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['attrid']);	
				}
				$content = NULL;
				$contents = NULL;
				$col = NULL;
			}

			}  elseif($value['module']!="section" && $value['module']!="layout" && $value['module']!="route") {
			if(in_array($mode.C.$value['module'], $enabled) && !in_array($mode.C.$value['module'],$disabled) && $layout->ControllerExists($mode.C.$value['module'])){
				$layout->SetView(SYS.V.'layout'.S.'views');
				$layout->SetModule($mode.V.$value['view'],$mode.C.$value['module']);
				$content = $layout->GetModule($mode.C.$value['module']);
				$content->model->layout_group = $value['name'];
				$contents = ($content)? htmlspecialchars($content->View()):"";
				if($contents!=""){
				$col = $layout->data->layout->addChild('views', $contents);

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
		return $layout->View();
		}
		return "";
	}
}
?>