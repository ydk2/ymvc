<?php

class MNGLayouts extends PHPRender {

	public function Init() {
		/*
		 $this->name_model = $model;
		 $this->model = new $model();
		 $this->view = $view;
		 *
		 */
		
		$this->exceptions = TRUE;
		$this->SetAccess(self::ACCESS_ANY);
		$this->access_groups = array('admin','user','any');
		$this->current_group = 'any';
		$this->AccessMode(2);
		$this->SetModel(SYS.M.'menudata');
		if(Helper::Get('admin:menu') == '')
		$this->SetView(SYS.V . "elements:nav");
		$this->Inc(SYS.M.'model');
		$this->groups=(Helper::get('data')=='' || Helper::get('action') == 'delete_item')?'main':Helper::get('data');
		$this -> items = $this -> model -> get_menu($this->groups);
	}

	public function showin($view='')
	{
		
	}

	function menulist($data, $parent = '') {
		// <item id="0" name="1">
		$tree = '';
		$i = 1;
		foreach ($data as $item) {
			if ($item['parent'] === $parent) {
				$tree .= '<item id="'.$item['pos'].'" url="'.htmlspecialchars($item['link']).'" name="'.$item['title'].'">' . PHP_EOL;

				$tree .= call_user_func_array(array($this, 'menulist'), array($data, strval($item['pos'])));

				$tree .= '</item>' . PHP_EOL;
			}
			$i++;
		}
		$tree .= "";
		return $tree;
	}


	public function Exception(){
		//echo "";
		if($this->error > 0) return $this->showwarning();
		
	}
	public function showwarning()
	{
		$error=$this->NewControllerB(SYS.V.'errors'.DS.'warning',SYS.C.'errors'.DS.'systemerror');
		$error->setParameter('','inside','yes');
		$error->setParameter('','show_link','no');
		$error->ViewData('title', Intl::_p('Warning!!!'));
		$error->ViewData('header', Intl::_p('Warning!!!').' '.$this->error);
		$error->ViewData('alert',Intl::_p($this->emessage).' - ');
		$error->ViewData('error', $this->error);
		return $error->View();
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

        if(isset($array[0]['pos'])){
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
                        $content->layout_group = $value['name'];
                        $content->enabled = $enabled;
                        $content->disabled = $disabled;
                        $content->layouts = $this->layouts;
                        $pos = count($content->layouts);

                        if(isset($this->default_route_group)){
                            $content->default_route_group = $this->default_route_group;
                            $content->default_route_count = $this->default_route_count;
                        }
                        $count = 0;

		                foreach ($_GET as $key => $router) {
                            if(in_array($mode.C.$key,$enabled) && !in_array($mode.C.$key,$disabled) && $this->ControllerExists($mode.C.$key)){
			                    $content->layouts[] = array('pos' => $pos++, 'name'=>'FromRoute_'.$key,'module'=>$key,'view'=>$router,'class'=>$value['class'],'attrid'=>'', 'users'=>'', 'group'=>$value['name'], 'mode'=>$value['mode']);
                                $count++;
                            }
		                }
                        if($this->default_route_group!="" && $count<=$this->default_route_count){
                            $content->layout_group = $this->default_route_group;
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
            }
        }
    }
    }
}
?>