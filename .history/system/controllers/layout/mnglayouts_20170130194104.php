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
		$this->access_groups = array('admin','editor');
		$this->current_group = Helper::Session('user_role');
		$this->AccessMode(2);
		$this->SetModel(SYS.M.'systemdata');
		$this->SetView(SYS.V . "layout".S."manage");
		//$this -> items = $this -> model -> get_menu($this->groups);
	}

    public function Run(){

        //Config::$data['layouts']['current'] = $this->layout_group;
		$this->group=(Helper::get('group')=='')?'main':Helper::get('group');



        $table='layouts';
		$gprx = 'layout';
		$this->array = $this->model->get_entries($table,$gprx);
       // $this->sksort($this->array,'idx');
        $this->datalist=$this->model->searchByName($this->array,'name',$gprx);

        //var_dump($this->datalist);
        $enabled = Config::$data['enabled'];
        $disabled = Config::$data['disabled'];

        $this->SetParameter('','current',$this->group);
        $this->SetParameter('','action',HOST_URL.'?layout'.S.'mnglayouts&group='.$this->group.'');
        $this->SetParameter('','addgroup',HOST_URL.'?layout'.S.'mnglayouts');
        $this->SetParameter('','addgrouphidden','layout'.S.'mnglayouts');

        $this->group_list();
        $this->add_layout_item();
        if(Helper::get('action')){
            $this->ViewData('message', '');
             $this->data->message->addChild('header', 'Success');
             $this->Save();
             $this->data->message->addChild('link', HOST_URL.'?layout'.S.'mnglayouts&amp;group='.$this->group.'');
        } else {
            if(!empty($this->datalist)){
            $this->ViewData('layouts', '');
            $this->inColumn();
            $this->Layouts($enabled,$disabled);
            }
        }
         $this->ViewData('dump', $this->dump($this->datalist));
    }
    private function Save(){
        if(Helper::get('action')=='add' && isset($_POST['add_item'])){
            $frompost = Helper::post('item');
            reset($frompost);
            $key = key($frompost);
            $add =json_decode('{
	"pos": '.$frompost[$key]['pos'].',
	"name": "'.$frompost[$key]['name'].'",
	"module": "'.$frompost[$key]['module'].'",
	"view": "'.$frompost[$key]['view'].'",
	"class": "'.$frompost[$key]['class'].'",
	"attrid": "'.$frompost[$key]['attrid'].'",
	"mode": "'.$frompost[$key]['mode'].'",
	"group": "'.$this->group.'",
	"id": '.$frompost[$key]['id'].'
}',true);
            $this->ViewData('dump', $this->dump($frompost));
            /**/
          //  if($add['name']!='' && $add['module']!=''){
                $data = $this->model->reverseNoId($frompost,'layout');
                  //  $idx = $this->model->get_free_idx('layouts','layout');
                foreach ($data as $name => $items) {
                    $this->model->add_item('layouts',$items['name'],$items['value'],$add['id'],'layout');
                }
                 $this->data->message->addChild('text', $this->dump($frompost));
        //    } else {
          //       $this->data->message->addChild('text', 'Pola nazwy i modułu nie mogą być puste');
        //    }
            /**/
            $this->data->message->addChild('text', $this->dump($frompost));
        }
        if(Helper::get('action')=='update' && isset($_POST['update_items'])){
            $frompost = Helper::post('item');

            $data = $this->model->reverseItems($frompost,$this->array,'layout');
            foreach ($data as $key => $items) {
                $frompost[$key]['id']=intval($frompost[$key]['id']);
                $out=$this->model->delete_idx('layouts',$items['idx'],'layout');
                $this->model->update_item('layouts',$items['name'],$items['value'],$items['idx'],'layout');
            }
            $this->data->message->addChild('text', $this->dump($data));
        }
        if(Helper::get('action')=='delete' && Helper::get('item')){
			$out=$this->model->delete_idx('layouts',Helper::get('item'),'layout');
            $this->data->message->addChild('text', $this->dump($out));
        }
    }

    public function oldsave($items='') {
        $msg = "";
        $tosave = $items;

        $_delete = (isset($_GET['delete']))?$_GET['delete']:"";
        if ($_delete!="") {
            foreach ($tosave as $key => $value) {
                if ($value['id']==$_delete) {
                    unset($tosave[$key]);
                    if(!isset($tosave[$key])) $msg = "<h3>Item deleted</h3>";
                }
            }
        }

        if(isset($_POST['item'])){
            $save = (isset($_POST['item']))?$_POST['item']:array();
            foreach ($tosave as $key => $value) {
                $tosave[$key]['id'] = intval($tosave[$key]['id']);
                $tosave[$key]['pos'] = intval($tosave[$key]['pos']);
                foreach ($save as $changed) {
                  if ($value['id']==$changed['id']) {
                        $tosave[$key]=$changed;
                        break;
                  }
                }
            }
            $msg = "<h3>Changes saved</h3>";
        }  

        if(isset($_POST['addgroup']) && $_POST['addgroup']==$this->_group){
            $msg = "<h3>Successed</h3>";
            $msg .= "<p class=\"lead\">Now add new item to ”".$this->_group."”</p>";
        }

    if(isset($_POST['add'])){

      $t = count($tosave)+1;
      foreach ($tosave as $pos => $val) {
        $i =$pos+1;
        if ($i < $val['id']) {
                $t = $i;
                break;
        }
      }
      $add = $_POST['add'];
      $add['id'] = intval($t);
      $add['pos'] = intval($add['pos']);
      array_push($tosave, $add);
      $msg = "<h3>New item saved</h3>";
    }

if(isset($_POST['item']) || isset($_GET['delete']) || isset($_POST['add'])){
    if (!empty($tosave)) {
        if(@file_put_contents(ROOT.SYS.STORE.$this->model->layout_data, json_encode($tosave))){
            $msg .= "<h3>successed</h3>";
            $msg .= "<a class=\"btn-success btn\" href=\"?admin".S."mnglayout=layout".S."manage&group=".$this->_group."\">OK</a>";
        } else {
            $msg .= "<h3>failure</h3>";
            $msg .= "<a class=\"button-error btn\" href=\"?admin".S."mnglayout=layout".S."manage&group=".$this->_group."\">OK</a>";
        }
    }
}
return $msg;

}

public function dump($value){
    ob_start();
    var_dump($value);
    $out = ob_get_clean();
    return $out;
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
		$tree = '<div class="list-group custom-restricted">';
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
    public function inColumn(){
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
        $showsort .= '<li><a href="'.HOST_URL.'?layout'.S.'mnglayouts&amp;group='.$this->group.'&amp;showas=one">jednej</a></li>';
        $showsort .= '<li><a href="'.HOST_URL.'?layout'.S.'mnglayouts&amp;group='.$this->group.'&amp;showas=two">dwóch</a></li>';
        $showsort .= '<li><a href="'.HOST_URL.'?layout'.S.'mnglayouts&amp;group='.$this->group.'&amp;showas=three">trzech</a></li>';
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
                $showas = 'col-sm-6';
                break;
        }
        $this->showas=$showas;
    }
    public function group_list(){

        $group_list = array();
        foreach ($this->datalist as $grp) {
            $group_list[] = $grp['group'];
        }
        $resultgrp = array_unique($group_list);


        $this->ViewData('menus', '<h3>Layout groups</h3>'.$this->menu($resultgrp));
    }

    public function Layouts($enabled,$disabled){

        if(isset($this->datalist[0]['pos'])){
            $this->sksort($this->datalist,'pos');
            $check = array('pos', 'name','module','view','class','group','attrid');
            $yes = TRUE;
            $this->ViewData('layouts', '');
            foreach ($this->datalist as $idx => $value) {

                foreach ($check as $is) {
                    if(!array_key_exists($is,$value)) {
                        $yes = FALSE;
                        break;
                }
            }
            if($value['group']==$this->group && $yes && $value['group']!=$value['name']){
                if ($value['mode']=='sys') {
                    $mode = SYS;
                } elseif ($value['mode']=='app') {
                    $mode = APP;
                } elseif ($value['mode']!='') {
                    $mode = $value['mode'];
                } else {
                    $mode = SYS;
                }

                  //  if(in_array($mode.C.$value['module'], $enabled) && !in_array($mode.C.$value['module'],$disabled) && $this->ControllerExists($mode.C.$value['module'])){

                        $contents = htmlspecialchars($this->layout_values($value));
                        if($contents!=""){
                            $col = $this->data->layouts->addChild('items', $contents);
                            if(isset($value['class'])) $col->addAttribute('class', $this->showas.' well');
                        }
                        $contents = NULL;
                        $col = NULL;
                   // }

            }
        }
    }
    }
    public function input($pos,$name,$value='',$type='text',$datalist=''){
        $list = '';
        if($datalist!=''){
            $list = ' list="item-'.$pos.'-'.$name.'" autocomplete="off"';
        }
        $input = '<input'.$list.' type="'.$type.'" class="form-control" name="item['.$pos.']['.$name.']" value="'.$value.'"  placeholder="'.$name.'" aria-describedby="item-'.$pos.'-'.$name.'">
        '.$datalist.'';
        $span = '<span class="input-group-addon" id="item-'.$pos.'-'.$name.'">'.ucfirst($name).'</span>';

        return $input.$span;
    }
    public function select($id,$pos,$name,$new=FALSE){
        $sselect = '<select  class="form-control" name="item['.$id.']['.$name.']"  placeholder="'.$name.'" aria-describedby="item-'.$id.'-'.$name.'">';
        $eselect = '</select>';
        $span = '<span class="input-group-addon" id="item-'.$id.'-'.$name.'">'.ucfirst($name).'</span>';
        $options = '';
        $ipos = 1;
        for ($i=1; $i<count($this->datalist)-1; $i++) {
            if(isset($this->datalist[$i]) && $this->datalist[$i]['group']==$this->group){
                $sel = ($pos == $ipos)?" selected='selected'":"";
                $options .= "<option value='".trim($ipos)."'".$sel.">".trim($ipos)."</option>";
                $ipos++;
            }
        }
        if($new){
            $options .= "<option value='".trim($pos)."' selected='selected'>".trim($pos)."</option>";
        }
        return $sselect.$options.$eselect.$span;
    }

    public function datalist($pos,$name,$datalist){
        $slist = '<datalist name="item['.$pos.']['.$name.']"  placeholder="'.$name.'" id="item-'.$pos.'-'.$name.'">';
        $elist = '</datalist>';
        $options = ''; //
        foreach ($datalist as $value) {
            $used=($name==$value)?" selected='selected'":"";
            $options .= "<option value='".trim($value)."'".$used.">".trim($value)."</option>";
        }
        return $slist.$options.$elist;
    }

    public function layout_values($value){
        $special = array('layout','route');
        if(in_array($value['module'],$special)){
            $append = '<a class="btn btn-success" href="'.HOST_URL.'?layout'.S.'mnglayouts&amp;group='.$value['name'].'" >Edytuj</a>';
        } else {
            $append = '';
        }
        $sbtngrp = '<span class="input-group-btn">';
        $ebtngrp = '</span>';
        $sgroup ='<div class="input-group">';
        $egroup ='</div>'."\n";
        $id = 1;
        $contents = "<h4>".ucfirst($value['name'])."</h4>";
        $contents .= $sgroup.$this->select($value['id'],$value['pos'],'pos');
        //$itemid = $data = $this->model->GetId($this->array,$idx,$name,'layout');
        $contents .= $sbtngrp.$append.'<a class="btn btn-danger" href="'.HOST_URL.'?layout'.S.'mnglayouts&amp;group='.$value['group'].'&amp;action=delete&amp;item='.$value['id'].'">Usuń</a>'.$ebtngrp.$egroup;
        $contents .= $sgroup.$this->input($value['id'],'name',$value['name'],'text').$egroup;
        $datamodules=$this->datalist($value['id'],'module',$special);
        $contents .= $sgroup.$this->input($value['id'],'module',$value['module'],'text',$datamodules).$egroup;
        $contents .= $sgroup.$this->input($value['id'],'view',$value['view'],'text').$egroup;
        $contents .= $sgroup.$this->input($value['id'],'class',$value['class'],'text').$egroup;
        $contents .= $sgroup.$this->input($value['id'],'attrid',$value['attrid'],'text').$egroup;
        $contents .= $sgroup.$this->input($value['id'],'mode',$value['mode'],'text').$egroup;
        $contents .= '<input type="hidden" name="item['.$value['id'].'][group]" value="'.$this->group.'">';
        $contents .= '<input type="hidden" name="item['.$value['id'].'][id]" value="'.$value['id'].'">';
        return $contents;
    }
    public function add_layout_item(){
        $special = array('layout','route');
        $sbtngrp = '<span class="input-group-btn">';
        $ebtngrp = '</span>';
        $sgroup ='<div class="input-group">';
        $egroup ='</div>'."\n";
        $sform = '<form action="'.HOST_URL.'?layout'.S.'mnglayouts&amp;group='.$this->group.'&amp;action=add" method="post">';
        $eform = '</form>';
        $ipos = 1;
        for ($i=1; $i<count($this->datalist)+1; $i++) {
            if(isset($this->datalist[$i]) && $this->datalist[$i]['group']==$this->group){
                $ipos++;
            }
        }
        $pos = $ipos;
        $idx = $this->model->Get_Free_Idx('layouts','layout');
        echo $idx;
        $contents = "<h4>Dodaj do '".$this->group."' '.$idx.'</h4>";
        $contents .= $sgroup.$this->select($idx,$pos,'pos',TRUE).$egroup;
        //$contents .= $sbtngrp.$append.'<a class="btn btn-danger" href="'.HOST_URL.'?layout'.S.'mnglayouts&amp;group='.$value['group'].'&amp;delete='.$value['pos'].'">Usuń</a>'.$ebtngrp.$egroup;
        $contents .= '<input type="text" class="form-control" name="item['.$idx.'][name]" value=""  placeholder="name">';
        $contents .= '<input type="text" class="form-control" name="item['.$idx.'][module]" value=""  placeholder="module">';
        $contents .= '<input type="text" class="form-control" name="item['.$idx.'][view]" value=""  placeholder="view">';
        $contents .= '<input type="text" class="form-control" name="item['.$idx.'][class]" value=""  placeholder="class">';
        $contents .= '<input type="text" class="form-control" name="item['.$idx.'][attrid]" value=""  placeholder="attrid">';
        $contents .= '<input type="text" class="form-control" name="item['.$idx.'][mode]" value=""  placeholder="mode">';
        $contents .= '<input type="hidden" name="item['.$idx.'][group]" value="'.$this->group.'">';
        $contents .= '<input type="hidden" name="item['.$idx.'][id]" value="'.$idx.'">';
        $contents .= '<button type="submit" name="add_item" class="btn btn-success btn-block">Dodaj</button>';
        $this->ViewData('addnewitem', $sform.$contents.$eform);
        //return $contents;
        //$datamodules=$this->datalist($idx,'module',$special);
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