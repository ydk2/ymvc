<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
* @Last Modified by: ydk2 (me@ydk2.tk)
* @Last Modified time: 2017-01-25 14:02:30
*/

class Layout extends PHPRender {
    
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
        $this->NewData('','',TRUE);
        $this->exceptions = FALSE;
        $this->SetView(SYS.V.'layout'.S.'layout');
    }
    
    public function Run(){
        Config::$data['layouts']['current'] = $this->layout_group;
        $this->ViewData('layout', array());
        $this->Layouts();
        
    }
    
    public function Layouts(){
        $array = $this->layouts;
        $enabled = $this->enabled;
        $disabled = $this->disabled;
        $mode = $this->mode;
        $group = $this->layout_group;
        
        if(!empty($array)){
            
            //unset($array[0]);
            //unset($array[14]);
            $this->sksort($array,'pos');
            $check = array('pos', 'name','module','view','class','group','attr');
            $yes = TRUE;
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
                        $content = new $this;
                        $content->layout_group = $value['name'];
                        $content->enabled = $enabled;
                        $content->disabled = $disabled;
                        $content->layouts = $this->layouts;
                        if(isset($this->default_route_group)){
                            $content->default_route_group= $this->default_route_group;
                        }
                        $contents = "";
                        $content->run();
                        foreach ($content->data->layout as $view) :
                        $contents .= '<div class="'.$view['class'].'">';
                        $contents .= $view['content'];
                        $contents .= '</div>';
                        endforeach;
                        if($contents!=""){
                            $this->data->layout[$i]['content'] = $contents;
                            if(isset($value['class'])) $this->data->layout[$i]['class'] = $value['class'];
                        }
                        $content = NULL;
                        $contents = NULL;
                        $col = NULL;
                    }
                }
                if($value['module']=="route"  && $value['group']!=""){
                    if(!in_array($value['name'],$disabled)){
                        $content = new $this;
                        $content->enabled = $enabled;
                        $content->disabled = $disabled;
                        $content->layouts = $this->layouts;
                        $pos = count($content->layouts);
                        $count = 0;
                        
                        foreach ($_GET as $key => $router) {
                            $controller = str_replace(S,DS,$mode.C.$key);
                            if(in_array($controller,$enabled) && !in_array($controller,$disabled) && $this->ControllerExists($controller)){
                                $content->layouts[] = array('pos' => $pos++, 'name'=>'FromRoute_'.$key,'module'=>$key,'view'=>$router,'class'=>$value['class'],'attr'=>'', 'users'=>'', 'group'=>$value['name'], 'mode'=>$value['mode']);
                                $count++;
                            }
                        }
                        if($value['view']!='' && $value['attr']!=""){
                            $min = $value['attr'];
                        }
                        if(isset($min) && $count<$min){
                            $content->layout_group =  $value['view'];
                        } else {
                            $content->layout_group = $value['name'];
                        }
                        
                        $contents = "";
                        $content->run();
                        foreach ($content->data->layout as $view) :
                        $contents .= '<div class="'.$view['class'].'">';
                        $contents .= $view['content'];
                        $contents .= '</div>';
                        endforeach;
                        if($contents!=""){
                            $this->data->layout[$i]['content'] = $contents;
                            if(isset($value['class'])) $this->data->layout[$i]['class'] = 'row';
                        }
                        $content = NULL;
                        $contents = NULL;
                        $controller = NULL;
                        $col = NULL;
                    }
                }
                if($value['module']!="layout" && $value['module']!="route" && $value['module']!="") {
                    if($value['module']=="menu" || $value['module']=="elements".S."menu"){
                        $content = $this->NewViewExt($mode.V.$value['view'],$mode.C.'elements'.S.'menu');
                        if(isset($content)){
                            $content->groups = ($value['attr']!="")?$value['attr']:NULL;
                            $contents = ($content)? $content->View():"";
                            if($contents!=""){
                                $this->data->layout[$i]['content'] = $contents;
                                if(isset($value['class'])) $this->data->layout[$i]['class'] = $value['class'];
                            }
                        }
                        $content = NULL;
                        $contents = NULL;
                        $controller = NULL;
                        $col = NULL;
                        
                    } else {
                        $controller = str_replace(S,DS,$mode.C.$value['module']);
                        if(in_array($controller, $enabled) && !in_array($controller,$disabled) && $this->ControllerExists($controller)){
                            $content = $this->NewViewExt($mode.V.$value['view'],$mode.C.$value['module']);
                            if(isset($content)){
                                $contents = ($content)? $content->View():"";
                                if($contents!=""){
                                    $this->data->layout[$i]['content'] = $contents;
                                    if(isset($value['class'])) $this->data->layout[$i]['class'] = $value['class'];
                                }
                            }
                            $content = NULL;
                            $contents = NULL;
                            $controller = NULL;
                            $col = NULL;
                        }
                    }
                }
            }
        }
    }
}
public function Element($value=array(),$mode=SYS,$enabled=array(),$disabled=array()){
    $element=array();
    if($value['module']!="layout" && $value['module']!="route" && $value['module']!="") {
        if($value['module']=="menu" || $value['module']=="elements".S."menu"){
            $content = $this->NewViewExt($mode.V.$value['view'],$mode.C.'elements'.S.'menu');
            if(isset($content)){
                $content->groups = ($value['attr']!="")?$value['attr']:NULL;
                $contents = ($content)? $content->View():"";
                if($contents!=""){
                    $this->data->layout[$i]['content'] = $contents;
                    if(isset($value['class'])) $this->data->layout[$i]['class'] = $value['class'];
                }
            }
            $content = NULL;
            $contents = NULL;
            $controller = NULL;
            $col = NULL;
            
        } else {
            $controller = str_replace(S,DS,$mode.C.$value['module']);
            if(in_array($controller, $enabled) && !in_array($controller,$disabled) && $this->ControllerExists($controller)){
                $content = $this->NewViewExt($mode.V.$value['view'],$mode.C.$value['module']);
                if(isset($content)){
                    $contents = ($content)? $content->View():"";
                    if($contents!=""){
                        $this->data->layout[$i]['content'] = $contents;
                        if(isset($value['class'])) $this->data->layout[$i]['class'] = $value['class'];
                    }
                }
                $content = NULL;
                $contents = NULL;
                $controller = NULL;
                $col = NULL;
            }
        }
    }
    return $element;
}
}
?>