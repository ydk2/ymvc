<?php

class Layouts extends PHPRender {
    
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
        $this->SetView(SYS.V . "manage".S."layouts");
        //$this -> items = $this -> model -> get_menu($this->groups);

        $this->group=(Helper::get('group')=='')?'main':Helper::get('group');

        $enabled = Config::$data['enabled'];
        $disabled = Config::$data['disabled'];
        //$this->ViewData('header', 'Manage Layouts');
    }


    public function Run(){

        $this->data->link = HOST_URL.'?manage'.S.'layouts&group='.$this->group.'';
        $this->link = HOST_URL.'?manage'.S.'layouts';


        $this->datalist=unserialize(file_get_contents(Config::$data['layout_data']));
        $this->items = array();
        $this->others = array();

        $this->group_list();

        if(!empty($this->datalist)){
            foreach ($this->datalist as $entry) {
                if($entry['group']==$this->group){
                    $this->items[]=$entry;
                } else {
                    $this->others[]=$entry;
                }
            }
            if(!empty($this->items))
            $this->sksort($this->items,'pos');
        }
        
        $this->data->header = 'Brak elementów';
        $this->data->text = 'Dodaj nowy';
        if(Helper::get('action')){
            $this->Action();
        }


    }

    public function group_list(){
        if(!empty($this->datalist)){
            $group_list = array();
            foreach ($this->datalist as $grp) {
                $group_list[] = $grp['group'];
            }
            $resultgrp = array_unique($group_list);


            $this->group_list=$resultgrp;
        } else {
            $this->group_list=array();
        }
    }
    
    public function amenu($data, $parent = '') {

        $tree = '<ul>';

        foreach ($data as $item) {
            if ($item['parent'] === $parent) {
                $tree .= '<li url="'.htmlspecialchars($item['link']).'">' .$item['title']. PHP_EOL;
                
                $tree .= call_user_func_array(array($this, __FUNCTION__), array($data, strval($item['id'])));
                
                $tree .= '</li>' . PHP_EOL;
            }
        }
        $tree .= "</ul>";
        return $tree;
    }

    private function Action(){
        $this->setview(SYS.V.'elements'.S.'msg');
        $this->data->header = 'Błąd!!!';
        $this->data->text = 'Operacja Nie Istnieje';
        if(Helper::get('action')=='add' && isset($_POST['add'])){
            $frompost = Helper::post('item');

            /**/
            $chk=0;
            if($frompost['name']!='' && $frompost['module']!=''){
                array_push($this->items,$frompost);
                $this->Save($this->items);
            } else {
                $this->data->header = 'Uwaga!!!';
                $this->data->text = 'Pola nie mogą być puste';
            }
            /**/
        }
        if(Helper::get('action')=='update'){
            $updateditems = Helper::post('items');
            $this->Save($updateditems);
        }
        if(Helper::get('action')=='delete' && Helper::get('item')){
            $chk=0;

            reset($this->items);
            while (list($a, $value) = each($this->items)) {
                if($value['id'] == Helper::get('item')){
                    unset($this->items[$a]);
                    if(!isset($this->items[$a])) $chk = 1;
                }
            }
            if($chk){
                $this->Save($this->items);
            } else {
                $this->data->header = 'Nie Udane';
                $this->data->text = 'Operacja zakończona błędem';
            }
            
        }
    }
    private function Save($updateditems=array()){
        $fixedpos = array();
        
        if(!empty($this->others)){
            if(!empty($updateditems)){
            $this->sksort($updateditems,'pos');
            $p = 1;
            foreach ($updateditems as $fix) {
                $fix['pos']=$p;
                $fixedpos[]=$fix;
                $p++;
            }
            }
            reset($this->others);
            while (list($a, $value) = each($this->others)) {
                $fixedpos[]=$value;
            }
        }
        
        if(!empty($fixedpos)){
            $save = file_put_contents(Config::$data['menu_data'],serialize($fixedpos));
            if(!$save){
                $this->data->header= 'Nie Udane';
                $this->data->text= 'Operacja zakończona błędem';
            } else {
                $this->data->header= 'Udane';
                $this->data->text= 'Operacja zakończona powodzeniem';
            }
        }
    }
    public function freekey(){
        $freekey = count($this->datalist)+1;
        foreach ($this->datalist as $pos => $val) {
            $i =$pos+1;
            if ($i > $val['id']) {
                $freekey =  $i;
            }
        }
        return $freekey;
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
        $this->ViewData('layouts','');
        foreach ($data as $item) {
            $list = $this->data->layouts->addChild('list',$item);
            $list->addAttribute('link', HOST_URL.'?manage'.S.'layouts&group='.$item);
        }
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
        $this->ViewData('columns','');
        $list = $this->data->columns->addChild('list','Jednej');
        $list->addAttribute('link', HOST_URL.'?manage'.S.'layouts&group='.$this->group.'&showas=one');
        $list = $this->data->columns->addChild('list','Dwóch');
        $list->addAttribute('link', HOST_URL.'?manage'.S.'layouts&group='.$this->group.'&showas=two');
        $list = $this->data->columns->addChild('list','Trzech');
        $list->addAttribute('link', HOST_URL.'?manage'.S.'layouts&group='.$this->group.'&showas=three');
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

public function Manage($enabled,$disabled){
    
    if(!empty($this->datalist)){
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
        if($value['group']==$this->group && $yes){
            if ($value['mode']=='sys') {
                $mode = SYS;
            } elseif ($value['mode']=='app') {
                $mode = APP;
            } elseif ($value['mode']!='') {
                $mode = $value['mode'];
            } else {
                $mode = SYS;
            }
            $contents = htmlspecialchars($this->layout_values($value));
            if($contents!=""){
                $col = $this->data->layouts->addChild('items', $contents);
                if(isset($value['class'])) $col->addAttribute('class', $this->showas.' well');
            }
            $contents = NULL;
            $col = NULL;
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
public function select($id,$pos,$name,$datalist,$new=FALSE){
    $sselect = '<select  class="form-control" name="item['.$id.']['.$name.']"  placeholder="'.$name.'" aria-describedby="item-'.$id.'-'.$name.'">';
    $eselect = '</select>';
    $span = '<span class="input-group-addon" id="item-'.$id.'-'.$name.'">'.ucfirst($name).'</span>';
    $options = '';
    
    $nr = 1;
    foreach ($datalist as $value) {
        if(isset($value['group']) && $value['group']==$this->group){
            $used=($pos==$value['pos'])?" selected='selected'":"";
            $options .= "<option value='".trim($nr)."'".$used.">".trim($nr)."</option>";
            $nr++;
        }
    }
    if($new){
        $options .= "<option value='".trim($nr)."' selected='selected'>".trim($nr)."</option>";
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
    $layouts = array('elements-menu','menu');
    $append = '';
    if(in_array($value['module'],$special)){
        $append .= '<a class="btn btn-success" href="'.HOST_URL.'?manage'.S.'layouts&amp;group='.$value['name'].'" >Edytuj</a>';
    }
    if(in_array($value['module'],$layouts)){
        $append .= '<a class="btn btn-success" href="'.HOST_URL.'?manage'.S.'layouts&amp;data='.$this->group.'" >Edytuj menu</a>';
    }
    $sbtngrp = '<span class="input-group-btn">';
    $ebtngrp = '</span>';
    $sgroup ='<div class="input-group">';
    $egroup ='</div>'."\n";
    $contents = "<h4>".ucfirst($value['name'])."</h4>";
    $contents .= $sgroup.$this->select($value['id'],$value['pos'],'pos',$this->datalist);
    $contents .= $sbtngrp.$append.'<a class="btn btn-danger" href="'.HOST_URL.'?manage'.S.'layouts&amp;group='.$value['group'].'&amp;action=delete&amp;item='.$value['id'].'">Usuń</a>'.$ebtngrp.$egroup;
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
    $sform = '<form action="'.HOST_URL.'?manage'.S.'layouts&amp;group='.$this->group.'&amp;action=add" method="post">';
    $eform = '</form>';
    $ipos = 1;
    for ($i=1; $i<count($this->datalist)+1; $i++) {
        if(isset($this->datalist[$i]) && $this->datalist[$i]['group']==$this->group){
            $ipos++;
        }
    }
    $pos = $ipos;
    $idx = $this->model->Get_Free_Idx('layouts','layout');
    $contents = "<h4>Dodaj do '".$this->group."' '.$idx.'</h4>";
    $contents .= $sgroup.$this->select($idx,$pos,'pos',$this->datalist,TRUE).$egroup;
    $contents .= $sgroup.$this->input($idx,'name','','text').$egroup;
    $datamodules=$this->datalist($idx,'module',$special);
    $contents .= $sgroup.$this->input($idx,'module','','text',$datamodules).$egroup;
    $contents .= $sgroup.$this->input($idx,'view','','text').$egroup;
    $contents .= $sgroup.$this->input($idx,'class','','text').$egroup;
    $contents .= $sgroup.$this->input($idx,'attrid','','text').$egroup;
    $contents .= $sgroup.$this->input($idx,'mode','','text').$egroup;
    $contents .= '<input type="hidden" name="item['.$idx.'][group]" value="'.$this->group.'">';
    $contents .= '<input type="hidden" name="item['.$idx.'][id]" value="'.$idx.'">';
    $contents .= '<button type="submit" name="add" class="btn btn-success btn-block">Dodaj</button>';
    $this->ViewData('addnewitem', $sform.$contents.$eform);
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