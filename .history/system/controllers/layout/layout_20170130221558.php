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
    public $default_route_group;
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

    public function Layouts(){
        $array = $this->layouts;
        $enabled = $this->enabled;
        $disabled = $this->disabled;
        $mode = $this->mode;
        $group = $this->layout_group;
        if(!empty($array)){
            $this->sksort($array,'pos');
            $check = array('pos', 'name','module','view','class','group','attrid');
            $yes = TRUE;
            $this->ViewData('layout', '');
            foreach ($array as $i => $value) {
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
                        $content = $this->NewControllerB(SYS.V.'layout'.S.'views',SYS.C.'layout'.S.'layout');
                        $content->layout_group = $value['name'];
                        $content->enabled = $enabled;
                        $content->disabled = $disabled;
                        $content->layouts = $this->layouts;
                        if(isset($this->default_route_group)){
                            $content->default_route_group= $this->default_route_group;
                        }
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
                if($value['module']=="route"  && $value['group']!=""){
                    if(!in_array($value['name'],$disabled)){
                        $this->SetView(SYS.V.'layout'.S.'views');
                        $content = $this->NewControllerB(SYS.V.'layout'.S.'content',SYS.C.'layout'.S.'layout');

                        $content->enabled = $enabled;
                        $content->disabled = $disabled;
                        $content->layouts = $this->layouts;
                        $pos = count($content->layouts);
                        $count = 0;

		                foreach ($_GET as $key => $router) {
                            if(in_array($mode.C.$key,$enabled) && !in_array($mode.C.$key,$disabled) && $this->ControllerExists($mode.C.$key)){
			                    $content->layouts[] = array('pos' => $pos++, 'name'=>'FromRoute_'.$key,'module'=>$key,'view'=>$router,'class'=>$value['class'],'attrid'=>'', 'users'=>'', 'group'=>$value['name'], 'mode'=>$value['mode']);
                                $count++;
                            }
		                }
                        if($value['view']!='' && $value['attrid']!=""){
                            $min = $value['attrid'];
                        }
                        if(isset($min) && $count<=$min){
                            $content->layout_group =  $value['view'];
                        } else {
                            $content->layout_group = $value['name'];
                        }

                        $contents = ($content)? htmlspecialchars($content->View()):"";
                        if($contents!=""){
                            $col = $this->data->layout->addChild('views', $contents);
                        }
                        $content = NULL;
                        $contents = NULL;
                        $col = NULL;
                    }
                }
                if($value['module']!="layout" && $value['module']!="route" && $value['module']!="") {
                    if(in_array($mode.C.$value['module'], $enabled) && !in_array($mode.C.$value['module'],$disabled) && $this->ControllerExists($mode.C.$value['module'])){
                        $this->SetView(SYS.V.'layout'.S.'views');
                        $content = $this->NewControllerB($mode.V.$value['view'],$mode.C.$value['module']);
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
}
?>