<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
* @Last Modified by: ydk2 (me@ydk2.tk)
* @Last Modified time: 2017-01-25 14:02:30
*/

class Layout extends Render {
    
    public $registered;
    public $disabled;
    public $enabled;
    public $layouts;
    public $layout_group;
    public $default_layout_group;
    public $default_route_group;
    public $mode;
    public $tag;
    
    public function Init(){
        
        if(isset($this->model->registered) &&  $this->model->registered != ""){
            $this->registered = $this->model->registered;
        } else {
            $this->registered = array("layout");
        }
        $this->default_route_count=0;
        $this->NewData('','',TRUE);
        $this->exceptions = FALSE;
        //$this->SetView(SYS.V.'layout'.S.'layout');
    }
    
    public function Run(){
        Config::$data['layouts']['current'] = $this->layout_group;
        $this->ViewData('layout', array());
        $this->LayoutData();
        
        
    }
    
    public function Views(){
        Config::$data['layouts']['current'] = $this->layout_group;
        $this->ViewData('layout', array());
        $this->LayoutData();
        
        $views = '';
        foreach ($this->data->layout as $view) {
            if($this->tag != null && $this->tag != ""){
                $views .= '<'.$this->tag.' class="'.$view['class'].'">';
            }
            $views .= $view['content'];
            if($this->tag != null && $this->tag != ""){
                $views .= '</'.$this->tag.'>';
            }
        }
        return $views;
    }
    
    
    public function LayoutData(){
        $array = $this->layouts;
        $enabled = $this->enabled;
        $disabled = $this->disabled;
        $mode = $this->mode;
        $group = $this->layout_group;
        
        if(!empty($array)){
            
            
            //unset($array[0]);
            //unset($array[14]);
            $this->sortby($array,'pos');
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
                    $mode = $value['mode'].DS;
                } else {
                    $mode = $this->mode.DS;
                }
                
                
                if($value['module']=="layout" && $value['group']!=""){
                    if(!in_array($value['name'],$disabled)){
                        $content = new $this;
                        $content->layout_group = $value['name'];
                        $content->enabled = $enabled;
                        $content->disabled = $disabled;
                        $content->layouts = $this->layouts;
                        $content->tag = $this->tag;
                        if(isset($this->default_route_group)){
                            $content->default_route_group= $this->default_route_group;
                        }
                        $contents = "";
                        $content->run();
                        foreach ($content->data->layout as $view) {
                            if($this->tag != null && $this->tag != ""){
                                $contents .= '<'.$this->tag.' class="'.$view['class'].'">';
                            }
                            $contents .= $view['content'];
                            if($this->tag != null && $this->tag != ""){
                                $contents .= '</'.$this->tag.'>';
                            }
                        }
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
                    $element = $this->Route($value,$mode,$enabled,$disabled);
                    if(!empty($element)){
                        $this->data->layout[$i] = $element;
                    }
                }
                if($value['module']!="layout" && $value['module']!="route" && $value['module']!="") {
                    $element = $this->Element($value,$mode,$enabled,$disabled);
                    if(!empty($element)){
                        $this->data->layout[$i] = $element;
                    }
                }
            }
        }
    }
}

public function Inside($value=array(),$mode='',$enabled=array(),$disabled=array()){
    $element = array();
    
    return $element;
}
public function Element($value=array(),$mode='',$enabled=array(),$disabled=array()){
    $element=array();
    $items = array();
    foreach($enabled as $item){
        //$tmp = str_replace(S,DS,$item);
        $items[] =  str_replace(array(S,'/'),array(DS,DS),$item);
    }
    $enabled = $items;
    if($value['module']!="layout" && $value['module']!="route" && $value['module']!="") {
        if($value['module']=="menu" || $value['module']=="elements".S."menu"){
            $content = $this->NewViewExt($mode.V.$value['view'],$mode.C.'elements'.S.'menu');
            if(isset($content)){
                $content->groups = ($value['attr']!="")?$value['attr']:NULL;
                $contents = ($content)? $content->View():"";
                if($contents!=""){
                    $element['content'] = $contents;
                    if(isset($value['class'])) $element['class'] = $value['class'];
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
                        $element['content'] = $contents;
                        if(isset($value['class'])) $element['class'] = $value['class'];
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

public function Route($value=array(),$mode='',$enabled=array(),$disabled=array()){
    $element=array();
    $items = array();
    foreach($enabled as $item){
        //$tmp = str_replace(S,DS,$item);
        $items[] =  str_replace(array(S,'/'),array(DS,DS),$item);
    }
    $enabled = $items;
    if($value['module']=="route"  && $value['group']!=""){
        if(!in_array($value['name'],$disabled)){
            $content = new $this;
            $content->enabled = $enabled;
            $content->disabled = $disabled;
            $content->layouts = $this->layouts;
            $content->tag = $this->tag;
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
            foreach ($content->data->layout as $view) {
                if($this->tag != null && $this->tag != ""){
                    $contents .= '<'.$this->tag.' class="'.$view['class'].'">';
                }
                $contents .= $view['content'];
                if($this->tag != null && $this->tag != ""){
                    $contents .= '</'.$this->tag.'>';
                }
            }
            if($contents!=""){
                $element['content'] = $contents;
                if(isset($value['class'])) $element['class'] = 'row';
            }
            $content = NULL;
            $contents = NULL;
            $controller = NULL;
            $col = NULL;
        }
    }
    return $element;
}


public function Render(){
    $views = '';
    foreach ($this->data->layout as $view) {
        if($this->tag != null && $this->tag != ""){
            $views .= '<'.$this->tag.' class="'.$view['class'].'">';
        }
        $views .= $view['content'];
        if($this->tag != null && $this->tag != ""){
            $views .= '</'.$this->tag.'>';
        }
    }
    return $views;
}

public function Layouts($array=array(),$group='',$enabled=array(),$disabled=array()){
    $contents = "";
    if(!empty($array)){
        $this->sortby($array,'pos');
        foreach ($array as $i => $value) {
            if($value['group']==$group && $value['group']!=$value['name']){
                if($value['module']=="layout" && $value['group']!=""){
                    $content = new $this;
                    $content->tag = $this->tag;
                    $content->Layouts($array,$value['group'],$enabled,$disabled);
                    $this->data->layout[$i] = $content->data->layout[$i];
                    $content = NULL;
                }
                if($value['module']=="route"  && $value['group']!=""){
                    $element = $this->Routing($value,$value['group'],$enabled,$disabled);
                    if(!empty($element)){
                        foreach ($element as $c => $v) {
                            $this->data->layout[$i+$c] = $v;
                        }
                    } else {
                        $content = new $this;
                        $content->tag = $this->tag;
                        $content->Layouts($array,$value['name'],$enabled,$disabled);

                        foreach ($content->data->layout as $c => $v) {
                            $this->data->layout[$i+$c] = $v;
                        }
                        $content = NULL;   
                    }
                }
                if($value['module']!="layout" && $value['module']!="route" && $value['module']!="") {
                    $controller = str_replace(S,DS,$value['mode'].S.C.$value['module']);
                    if($value['view']!=''){
                        $view = str_replace(S,DS,$value['mode'].S.V.$value['view']);
                    } else {
                        $view = NULL;
                    }
                    if(in_array($controller,$enabled)){
                        $element = $this->NewViewExt($view,$controller);
                        if(isset($element)){
                            $contents = $element->View();
                            $this->data->layout[$i]['class']=$value['class'];
                            $this->data->layout[$i]['content'] = (!empty($contents)) ? $contents:"";
                        }
                    }
                }
            }
        }
    }
}

public function Routing($value=array(),$group='',$enabled=array(),$disabled=array()){
    $element=array();
    $elements=array();
    $items = array();
    foreach($enabled as $item){
        $items[] =  str_replace(array(S,'/'),array(DS,DS),$item);
    }
    $enabled = $items;
    if($value['module']=="route"  && $value['group']!=""){
        $pos = count($this->data->layout);
        $count = 0;
        
        foreach ($_GET as $key => $router) {
            $controller = str_replace(S,DS,$value['mode'].S.C.$key);
            if($this->ControllerExists($controller)){
                $elements[] = array('pos' => $pos++, 'name'=>$value['name'].'_'.$key,'module'=>$key,'view'=>$router,'class'=>$value['class'],'attr'=>$value['attr'], 'group'=>$value['name'], 'mode'=>$value['mode']);
                $count++;
            }
        }
        $content = new $this;
        $content->tag = $this->tag;
        $content->Layouts($elements,$value['name'],$enabled,$disabled);
        $element = $content->data->layout;
        $content = NULL;
    }
    return $element;
}
}
?>