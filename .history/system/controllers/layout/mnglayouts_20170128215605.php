<?php

class MNGLayouts extends XSLRender {

	public function Init() {
		/*
		 $this->name_model = $model;
		 $this->model = new $model();
		 $this->view = $view;
		 *
		 */
		
		$this->exceptions = TRUE;
		$this->SetAccess(self::ACCESS_ANY);
		$this->access_groups = array(null);
		$this->current_group = null;
		$this->AccessMode(2);
		$this->SetModel(SYS.M.'systemdata');
		$this->SetView(SYS.V . "layout".S."manage");
		//$this -> items = $this -> model -> get_menu($this->groups);
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

	function menu($data) {
		$tree = '<ul>';
		$i = 1;
		foreach ($data as $item) {
				$tree .= '<li><a href="'.HOST_URL.'?layout'.S.'mnglayouts&amp;group='.$item.'">'.$item.'</a></li>' . PHP_EOL;
			}
		$tree .= "</ul>";
		return $tree;
	}


	public function Exception(){
		//echo "";
		if($this->error > 0) return $this->showwarning();
		
	}
    public function Run(){
        //Config::$data['layouts']['current'] = $this->layout_group;
		$group=(Helper::get('group')=='')?'main':Helper::get('group');
		$show=(Helper::get('showas')=='')?'':Helper::get('showas');
        if(!Helper::cookie('showas') && $show!=''){
            Helper::cookie_register('showas',$show,1000);
        }
        elseif(Helper::cookie('showas')!=$show && $show!=''){
            Helper::cookie_set('showas',$show);
        }

        $this->ViewData('header', '<h3>'.Helper::cookie('showas').'</h3>');
        switch (Helper::cookie('showas')) {
            case 'items':
                $showas = 'col-sm-4';
                break;

            case 'list':
                $showas = 'col-sm-12';
                break;

            case 'plate':
                $showas = 'col-sm-6';
                break;

            default:
                $showas = 'col-sm-4';
                break;
        }

        $table='layouts';
		$gprx = 'layout';
		$data = $this->model->get_entries($table,$gprx);
        $array=$this->model->searchByName($data,'name',$gprx);


        $group_list = array();
        foreach ($array as $grp) {
            $group_list[] = $grp['group'];
        }
        $resultgrp = array_unique($group_list);



        $this->ViewData('menus', '<h3>Layout groups</h3>'.$this->menu($resultgrp));
        $this->ViewData('layouts', '');

        $enabled = Config::$data['enabled'];
        $disabled = Config::$data['disabled'];

        $this->Layouts($array,$enabled,$disabled,$group,$showas);
    }

    public function Layouts($array,$enabled,$disabled,$group,$showas='col-sm-4'){

        if(isset($array[0]['pos'])){
            $this->sksort($array,'pos');
            $check = array('pos', 'name','module','view','class','group','attrid');
            $yes = TRUE;
            $this->ViewData('layouts', '');
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
                    $mode = SYS;
                }

                if($value['module']=="layout" && $value['group']!=""){
                    if(!in_array($value['name'],$disabled)){
                        $contents = htmlspecialchars("<h4>".$value['name']."</h4>");
                        $contents .= htmlspecialchars("<p>".$value['module']."</p>");
                        $contents .= htmlspecialchars("<p>".$value['view']."</p>");
                        $contents .= htmlspecialchars("<p>".$value['mode']."</p>");
                        if($contents!=""){
                            $col = $this->data->layouts->addChild('items', $contents);
                            if(isset($value['style'])) $col->addAttribute('style', $value['style']);
                            if(isset($value['class'])) $col->addAttribute('class', $showas);
                            if(isset($value['attrid'])) $col->addAttribute('id', $value['attrid']);
                        }
                        $contents = NULL;
                        $col = NULL;
                    }
                }
                if($value['module']=="route"  && $value['group']!=""){
                    if(!in_array($value['name'],$disabled)){
                        $contents = htmlspecialchars("<h4>".$value['name']."</h4>");
                        $contents .= htmlspecialchars("<p>".$value['module']."</p>");
                        $contents .= htmlspecialchars("<p>".$value['view']."</p>");
                        $contents .= htmlspecialchars("<p>".$value['mode']."</p>");
                        if($contents!=""){
                            $col = $this->data->layouts->addChild('items', $contents);
                            if(isset($value['style'])) $col->addAttribute('style', $value['style']);
                            if(isset($value['class'])) $col->addAttribute('class', $showas);
                            if(isset($value['attrid'])) $col->addAttribute('id', $value['attrid']);
                        }
                        $contents = NULL;
                        $col = NULL;

                    }
                }
                if($value['module']!="layout" && $value['module']!="route" && $value['module']!="") {
                    if(in_array($mode.C.$value['module'], $enabled) && !in_array($mode.C.$value['module'],$disabled) && $this->ControllerExists($mode.C.$value['module'])){

                        $contents = htmlspecialchars("<h4>".$value['name']."</h4>");
                        $contents .= htmlspecialchars("<p>".$value['module']."</p>");
                        $contents .= htmlspecialchars("<p>".$value['view']."</p>");
                        $contents .= htmlspecialchars("<p>".$value['mode']."</p>");
                        if($contents!=""){
                            $col = $this->data->layouts->addChild('items', $contents);
                            if(isset($value['style'])) $col->addAttribute('style', $value['style']);
                            if(isset($value['class'])) $col->addAttribute('class', $showas);
                            if(isset($value['attrid'])) $col->addAttribute('id', $value['attrid']);
                        }
                        $contents = NULL;
                        $col = NULL;
                    }
                }
            }
        }
    }
    }

	public function showwarning()
	{
		$error=$this->NewControllerB(SYS.V.'errors'.S.'warning',SYS.C.'errors'.S.'systemerror');
		$error->setParameter('','inside','yes');
		$error->setParameter('','show_link','no');
		$error->ViewData('title', Intl::_p('Warning!!!'));
		$error->ViewData('header', Intl::_p('Warning!!!').' '.$this->error);
		$error->ViewData('alert',Intl::_p($this->emessage).' - ');
		$error->ViewData('error', $this->error);
		return $error->View();
	}
}
?>