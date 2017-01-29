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
		$tree = '<div class="list-group">';
		$i = 1;
		foreach ($data as $item) {
				$tree .= '<a class="list-group-item" href="'.HOST_URL.'?layout'.S.'mnglayouts&amp;group='.$item.'">'.$item.'</a>' . PHP_EOL;
			}
		$tree .= "</div>";
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
        $showed = Helper::cookie('showas');
        if(!Helper::cookie('showas') && $show!=''){
            Helper::cookie_register('showas',$show,1000);
            $showed = $show;
        }
        elseif(Helper::cookie('showas')!=$show && $show!=''){
            Helper::cookie_set('showas',$show);
            $showed = $show;
        }
        $showsort = '<div class="row"><strong>Pokaż w kolumnach</strong><ul class="breadcrumb">';
        $showsort .= '<li><a href="'.HOST_URL.'?layout'.S.'mnglayouts&amp;group='.$group.'&amp;showas=one">jednej</a></li>';
        $showsort .= '<li><a href="'.HOST_URL.'?layout'.S.'mnglayouts&amp;group='.$group.'&amp;showas=two">dwóch</a></li>';
        $showsort .= '<li><a href="'.HOST_URL.'?layout'.S.'mnglayouts&amp;group='.$group.'&amp;showas=three">trzech</a></li>';
        $showsort .= '</ul></div>';
        $this->ViewData('header', '<h3>Manage Layouts</h3>'.$showsort);
        switch ($showed) {
            case 'three':
                $showas = 'col-sm-4';
                break;

            case 'one':
                $showas = 'col-sm-12';
                break;

            case 'two':
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


        $this->SetParameter('','action',HOST_URL.'?layout'.S.'mnglayouts&group='.$group);
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
                        $contents = htmlspecialchars($this->layout_values($value));
                        if($contents!=""){
                            $col = $this->data->layouts->addChild('items', $contents);
                            if(isset($value['style'])) $col->addAttribute('style', $value['style']);
                            if(isset($value['class'])) $col->addAttribute('class', $showas.' well');
                            if(isset($value['attrid'])) $col->addAttribute('id', $value['attrid']);
                        }
                        $contents = NULL;
                        $col = NULL;
                    }
                }
                if($value['module']=="route"  && $value['group']!=""){
                    if(!in_array($value['name'],$disabled)){
                        $contents = htmlspecialchars($this->layout_values($value));
                        if($contents!=""){
                            $col = $this->data->layouts->addChild('items', $contents);
                            if(isset($value['style'])) $col->addAttribute('style', $value['style']);
                            if(isset($value['class'])) $col->addAttribute('class', $showas.' well');
                            if(isset($value['attrid'])) $col->addAttribute('id', $value['attrid']);
                        }
                        $contents = NULL;
                        $col = NULL;

                    }
                }
                if($value['module']!="layout" && $value['module']!="route" && $value['module']!="") {
                    if(in_array($mode.C.$value['module'], $enabled) && !in_array($mode.C.$value['module'],$disabled) && $this->ControllerExists($mode.C.$value['module'])){

                        $contents = htmlspecialchars($this->layout_values($value));
                        if($contents!=""){
                            $col = $this->data->layouts->addChild('items', $contents);
                            if(isset($value['style'])) $col->addAttribute('style', $value['style']);
                            if(isset($value['class'])) $col->addAttribute('class', $showas.' well');
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
    public function input($name,$value='',$type='text',$for='text1',$datalist=''){
        $sgroup ='<div class="input-group">';
        $egroup ='</div>';
        $input = '<input type="'.$type.'" class="form-control" name="'.$name.'" value="'.$value.'"  placeholder="'.$name.'"aria-describedby="'.$for.'">
        '.$datalist.'';
        $span = '<span class="input-group-addon" id="'.$for.'">'.ucfirst($name).'</span>';
        $btn = '<span class="input-group-btn">
                    <a class="btn btn-success" >Edit</a>
                  </span>';
        $special = array('layout','route');
        if(in_array($value['module'],$special)){
            $append = $btn;
        } else {
            $append = $span;
        }
        return $sgroup.$input.$append.$egroup;
    }
    public function layout_values($value){
        $id = 1;
        $contents = "<h4>".ucfirst($value['name'])."</h4>";
        $contents .= "<p>".$value['pos']."</p>";
        $contents .= $this->input('name',$value['name'],'text','text'.$id++);
        $contents .= $this->input('module',$value['module'],'text','text'.$id++);
        $contents .= $this->input('view',$value['view'],'text','text'.$id++);
        $contents .= $this->input('class',$value['class'],'text','text'.$id++);
        $contents .= $this->input('attrid',$value['attrid'],'text','text'.$id++);
        $contents .= $this->input('mode',$value['mode'],'text','text'.$id++);
        return $contents;
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