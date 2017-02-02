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

        $this->group=(Helper::get('group')=='')?'main':Helper::get('group');
        //$this->ViewData('header', 'Manage Layouts');
    }
    
    public function Run(){

        
        $table='layouts';
        $gprx = 'layout';
        $this->datalist=$this->model->search_entries($table,$gprx);
        file_put_contents(ROOT.STORE.'layouts.data',serialize($this->datalist));
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
            $this->Save();
            $this->data->message->addChild('link', HOST_URL.'?layout'.S.'mnglayouts&amp;group='.$this->group.'');
        } else {
            if(!empty($this->datalist)){
                $this->ViewData('layouts', '');
                $this->inColumn();
                $this->Layouts($enabled,$disabled);
            }
        }
    }
    private function Save(){
        if(Helper::get('action')=='add' && isset($_POST['add'])){
            $frompost = Helper::post('item');
            reset($frompost);
            $key = key($frompost);
            /**/
            $chk=0;
            if($frompost[$key]['name']!='' && $frompost[$key]['module']!=''){
                    $this->model->Begin();
                    $this->model->doAddItems($frompost,'layouts','layout');
                    $chk=$this->model->Commit();
                if($chk){
                    $this->data->message->addChild('header', 'Udane');
                    $this->data->message->addChild('text', 'Operacja zakończona pomyślnie');
                } else {
                    $this->data->message->addChild('header', 'Nie Udane');
                    $this->data->message->addChild('text', 'Operacja zakończona błędem');
                }
                
            } else {
                $this->data->message->addChild('header', 'Uwaga!!!');
                $this->data->message->addChild('text', 'Pola nazwy i modułu nie mogą być puste');
            }
            /**/
        }
        if(Helper::get('action')=='update' && isset($_POST['update'])){
            $frompost = Helper::post('item');
            $chk = 0;
            $this->model->Begin();
            $this->model->doUpdateItems($frompost,'layouts','layout');
            $chk=$this->model->Commit();
            if($chk){
                $this->data->message->addChild('header', 'Udane');
                $this->data->message->addChild('text', 'Operacja zakończona pomyślnie');
            } else {
                $this->data->message->addChild('header', 'Nie Udane');
                $this->data->message->addChild('text', 'Operacja zakończona błędem');
            }
        }
        if(Helper::get('action')=='delete' && Helper::get('item')){
            $this->model->Begin();
            $this->model->delete_idx('layouts',Helper::get('item'),'layout');
            $chk=$this->model->Commit();
            if($chk){
                $this->data->message->addChild('header', 'Udane');
                $this->data->message->addChild('text', 'Operacja zakończona pomyślnie');
            } else {
                $this->data->message->addChild('header', 'Nie Udane');
                $this->data->message->addChild('text', 'Operacja zakończona błędem');
            }
        }
        $this->data->message->addChild('header', 'Błąd!!!');
        $this->data->message->addChild('text', 'Operacja Nie Istnieje');
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
        $this->ViewData('menus','');
        foreach ($data as $item) {
            $list = $this->data->menus->addChild('list',$item);
            $list->addAttribute('link', HOST_URL.'?layout'.S.'mnglayouts&group='.$item);
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
        $list->addAttribute('link', HOST_URL.'?layout'.S.'mnglayouts&group='.$this->group.'&showas=one');
        $list = $this->data->columns->addChild('list','Dwóch');
        $list->addAttribute('link', HOST_URL.'?layout'.S.'mnglayouts&group='.$this->group.'&showas=two');
        $list = $this->data->columns->addChild('list','Trzech');
        $list->addAttribute('link', HOST_URL.'?layout'.S.'mnglayouts&group='.$this->group.'&showas=three');
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
    
    
    $this->ViewData('menushead', 'Layout groups');
    $this->menu($resultgrp);
}

public function Layouts($enabled,$disabled){
    
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
    $menus = array('elements-menu','menu');
    $append = '';
    if(in_array($value['module'],$special)){
        $append .= '<a class="btn btn-success" href="'.HOST_URL.'?layout'.S.'mnglayouts&amp;group='.$value['name'].'" >Edytuj</a>';
    }
    if(in_array($value['module'],$menus)){
        $append .= '<a class="btn btn-success" href="'.HOST_URL.'?admin'.S.'mngmenus&amp;data='.$this->group.'" >Edytuj menu</a>';
    }
    $sbtngrp = '<span class="input-group-btn">';
    $ebtngrp = '</span>';
    $sgroup ='<div class="input-group">';
    $egroup ='</div>'."\n";
    $contents = "<h4>".ucfirst($value['name'])."</h4>";
    $contents .= $sgroup.$this->select($value['id'],$value['pos'],'pos',$this->datalist);
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