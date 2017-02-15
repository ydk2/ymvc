<?php

class MNGMenus extends PHPRender {
    
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
        $this->SetView(SYS.V . "menus".S."manage");
        
        $this->group=(Helper::get('group'))?'main':Helper::get('group');
        
        $this->NewData('','',TRUE);
        //$this -> items = $this -> model -> get_menu($this->group);
    }
    
    public function Run(){
        
        $this->data->link = HOST_URL.'?menus'.S.'mngmenus&group='.$this->group.'';
        
        $this->datalist=unserialize(file_get_contents(ROOT.STORE.'menus.data'));
        $this->menuitems = array();
        /**
        for ($i=0; $i < count($this->datalist)+1; $i++) {
        if(isset($this->datalist[$i]) && $this->datalist[$i]['group']==$this->group){
        $this->menuitems[$i]=$this->datalist[$i];
        }
        }
        **/
        if(!empty($this->datalist)){
            foreach ($this->datalist as $entry) {
                if($entry['group']==$this->group){
                    $this->menuitems[]=$entry;
                }
            }
        }
        $this->sksort($this->menuitems,'pos');
        /**
        if(!empty($this->datalist)){
            foreach ($this->datalist as $value) {
                foreach ($this->menuitems as $updated) {
                    if($value['id']==$updated['id']){
                        $this->out[$value['id']]=$updated;
                    } else {
                        $this->out[$value['id']]=$value;
                    }
                }
            }
        }
        **/
        $updateditems = Helper::post('items');

        $fixedpos = array();
        if(!empty($this->datalist)&&!empty($updateditems)){
        $this->sksort($updateditems,'pos');
        $p = 1;
        foreach ($updateditems as $fix) {
            $fix['pos']=$p;
            $fixedpos[]=$fix;
            $p++;
        }
        reset($this->datalist);
        while (list($a, $value) = each($this->datalist)) {
            reset($fixedpos);
            while (list($b, $updated) = each($fixedpos)) {
                if($value['id']==$updated['id']){
                    $this->out[$value['id']]=$updated;
                } else {
                    $this->out[$value['id']]=$value;
                }
            }
        }
        }
        if($updateditems){
            $save = file_put_contents(ROOT.STORE.'menus.data',serialize($this->out));
        }
        return true;
        /**
        $this->datalist[1]=array('id'=>1,'pos'=>1,'title'=>'none1','link'=>'null','parent'=>'','group'=>'main');
        $this->datalist[2]=array('id'=>2,'pos'=>2,'title'=>'none2','link'=>'null','parent'=>'','group'=>'main');
        $this->datalist[3]=array('id'=>3,'pos'=>3,'title'=>'none3','link'=>'null','parent'=>'','group'=>'main');
        $this->datalist[4]=array('id'=>4,'pos'=>4,'title'=>'none4','link'=>'null','parent'=>'','group'=>'main');
        $this->datalist[5]=array('id'=>5,'pos'=>5,'title'=>'none5','link'=>'null','parent'=>'','group'=>'main');
        $this->datalist[6]=array('id'=>6,'pos'=>6,'title'=>'none6','link'=>'null','parent'=>'','group'=>'main');
        $save = file_put_contents(ROOT.STORE.'menus.data',serialize($this->datalist));
        **/
        $enabled = Config::$data['enabled'];
        $disabled = Config::$data['disabled'];
        
        $this->SetParameter('','current',$this->group);
        $this->SetParameter('','action',HOST_URL.'?menus'.S.'mngmenus&group='.$this->group.'');
        $this->SetParameter('','addgroup',HOST_URL.'?menus'.S.'mngmenus');
        $this->SetParameter('','addgrouphidden','menus'.S.'mngmenus');
        
        $this->group_list();
        $this->add_menus_item();
        $this->ViewData('header', '');
        $this->ViewData('text', '');
        $this->ViewData('header', '');
        
        $this->poslist();
        $this->freekey();
        $this->data->link = HOST_URL.'?menus'.S.'mngmenus&group='.$this->group.'';
        $this->data->header = 'Brak elementów';
        $this->data->text = 'Dodaj nowy';
        if(Helper::get('action')){
            $this->Save();
            
        } else {
            if(!empty($this->datalist)){
                $this->sksort($this->datalist,'pos');
                // $this->ViewData('menus', '');
                //  $this->inColumn();
                $this->editor=$this->edit_menu($this->datalist);
            }
        }
    }

    function menu($data, $parent = '') {

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
    private function freekey(){
        if(!empty($this->datalist)){
            $this->freekey = count($this->datalist)+1;
            foreach ($this->datalist as $pos => $val) {
                $i =$pos+1;
                if ($i > $val['id']) {
                    $this->freekey =  $i;
                }
            }
        } else {
            $this->freekey = 1;
        }
    }
    private function poslist(){
        //$this->freekey = count($this->datalist)+1;
        $this->poslist[0] = 0;
        $i = 1;
        if(!empty($this->datalist)){
            foreach ($this->datalist as $val) {
                if($val['group']===$this->group){
                    $this->poslist[]=$i;
                    $i++;
                }
            }
        } else {
            $this->poslist[1] = 1;
        }
    }
    private function Save(){
        $this->data->header = 'Błąd!!!';
        $this->data->text = 'Operacja Nie Istnieje';
        if(Helper::get('action')=='add' && isset($_POST['add'])){
            $frompost = Helper::post('item');
            reset($frompost);
            $key = key($frompost);
            /**/
            $chk=0;
            if($frompost[$key]['title']!='' && $frompost[$key]['link']!=''){
                
                $freekey = count($this->datalist)+1;
                foreach ($this->datalist as $pos => $val) {
                    $i =$pos+1;
                    if ($i > $val['id']) {
                        $freekey =  $i;
                    }
                }
                $this->datalist[$freekey] = $frompost[$freekey];
                if($this->datalist[$freekey] == $frompost[$freekey]){
                    $this->data->header = 'Udane';
                    $this->data->text = 'Operacja zakończona pomyślnie';
                } else {
                    $this->data->header = 'Nie Udane';
                    $this->data->text = 'Operacja zakończona błędem';
                }
                
            } else {
                $this->data->header = 'Uwaga!!!';
                $this->data->text = 'Pola nie mogą być puste';
            }
            $save = file_put_contents(ROOT.STORE.'menus.data',serialize($this->datalist));
            if(!$save){
                $this->data->header= 'Nie Udane';
                $this->data->text= 'Operacja zakończona błędem';
            }
            
            /**/
        }
        if(Helper::get('action')=='update' && isset($_POST['update'])){
            $frompost = Helper::post('item');
            $chk = 0;
            $this->sksort($frompost,'pos');
            foreach ($frompost as $key => $value) {
                $this->datalist[$key] = $value;
                if($this->datalist[$key] = $value){
                    $chk += 1;
                }
            }
            
            if($chk == count($frompost)){
                $this->data->header = 'Udane';
                $this->data->text = 'Operacja zakończona pomyślnie';
            } else {
                $this->data->header = 'Nie Udane';
                $this->data->text = 'Operacja zakończona błędem';
            }
            $save = file_put_contents(ROOT.STORE.'menus.data',serialize($this->datalist));
            if(!$save){
                $this->data->header= 'Nie Udane';
                $this->data->text= 'Operacja zakończona błędem';
            }
        }
        if(Helper::get('action')=='delete' && Helper::get('item')){
            $chk=0;
            unset($this->datalist[Helper::get('item')]);
            if(!isset($this->datalist[Helper::get('item')])) $chk = 1;
            if($chk){
                $this->data->header = 'Udane';
                $this->data->text = 'Operacja zakończona pomyślnie';
            } else {
                $this->data->header = 'Nie Udane';
                $this->data->text = 'Operacja zakończona błędem';
            }
            $save = file_put_contents(ROOT.STORE.'menus.data',serialize($this->datalist));
            if(!$save){
                $this->data->header= 'Nie Udane';
                $this->data->text= 'Operacja zakończona błędem';
            }
        }
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
    
    
    function menugroups() {
        $data = $this->model->get_menu_groups();
        $tree = '<ul class="list-group">';
        foreach ($data as $item) {
            $tree .= '<li class="list-group-item"><a href="?menus'.S.'mngmenus&groups='.$item.'">' . $item.'</a>';
            $tree .= '</li>' . PHP_EOL;
        }
        $tree .= "</ul>";
        return $tree;
    }
    
    function edit_menu($data, $parent = '') {
        $tree = '';
        $i = 1;
        if($data){
            
            foreach ($data as $item) {
                if($item['group']===$this->group){
                    $tree .= '<tr>';
                    $tree .= "<td>" . $this -> change_pos($data, $item['id'], $item['pos']) . "</td>";
                    //$tree .= '<label for="title">Change Title</label>';
                    $tree .= '<td><input class="form-control" type="text" id="title" name="item[' . $item['id'] . '][title]" value="' . $item['title'] . '"' . "></td>";
                    $tree .= '<input class="form-control" type="hidden" id="ids" name="item[' . $item['id']. '][id]" value="' .$item['id']. '"' . ">";
                    $tree .= '<input class="form-control" type="hidden" id="ids" name="item[' . $item['id']. '][group]" value="' . $this->group. '"' . ">";
                    $tree .= '<td><input class="form-control" type="text" id="link" name="item[' .$item['id']. '][link]" value="' . $item['link'] . '"' . "></td>";
                    $tree .= "<td>" . $this -> change_parent($data, $item['id'], $item['title'], $item['parent']) . "</td>";
                    $tree .= '<td><a class="btn btn-danger" href="' . HOST_URL . '?menus'.S.'mngmenus&action=delete&item=' . $item['id'] . '&group='.$this->group.'">Delete entry</a></td>';
                    //$tree .= call_user_func_array(array($this, 'edit_menu'), array($data, $i));
                    $tree .= "</tr>\n";
                    $i++;
                }
            }
        }
        return $tree;
    }
    
    function change_pos($data, $key, $selected = null) {
        $tree = "<select class='form-control' name='item[$key][pos]'>";
        $i = 1;
        foreach ($data as $item) {
            $tree .= '<option value="' . $i . '"';
            if ($selected == $i) {
                $tree .= ' selected="selected"';
            }
            $tree .= ">".$i."</option>\n";
            $i++;
        }
        $tree .= "</select>\n";
        return $tree;
    }
    
    function change_parent($data, $key, $title, $selected = null) {
        $tree = "<select class='form-control' name='item[$key][parent]'>";
        $tree .= '<option value="">no parent</option>';
        foreach ($data as $item) {
            if ($item['title'] != $title) {
                $tree .= '<option value="' . $item['pos']. '"';
                if ($selected  == $item['pos']) {
                    $tree .= ' selected="selected"';
                }
                $tree .= ">" . $item['title']. "</option>";
            }
        }
        $tree .= "</select>\n";
        return $tree;
    }

    
    function menugroup($data) {
        $tree = '<div class="list-group custom-restricted">';
        $i = 1;
        foreach ($data as $item) {
            $tree .= '<a class="list-group-item" href="'.HOST_URL.'?menus'.S.'mngmenus&group='.$item.'">'.$item.'</a>' . PHP_EOL;
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
        $showsort .= '<li><a href="'.HOST_URL.'?menus'.S.'mngmenus&amp;group='.$this->group.'&amp;showas=one">jednej</a></li>';
        $showsort .= '<li><a href="'.HOST_URL.'?menus'.S.'mngmenus&amp;group='.$this->group.'&amp;showas=two">dwóch</a></li>';
        $showsort .= '<li><a href="'.HOST_URL.'?menus'.S.'mngmenus&amp;group='.$this->group.'&amp;showas=three">trzech</a></li>';
        $showsort .= '</ul></div>';
        $this->ViewData('header', '<h3>Manage menus</h3>'.$showsort);
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
    if(!empty($this->datalist)){
        $group_list = array();
        foreach ($this->datalist as $grp) {
            $group_list[] = $grp['group'];
        }
        $resultgrp = array_unique($group_list);
        
        
        $this->ViewData('menus', '<h3>menus groups</h3>'.$this->menugroup($resultgrp));
    } else {
        $this->ViewData('menus', '<h3>No menu groups</h3>');
    }
}

public function menus($enabled,$disabled){
    
    if(!empty($this->datalist)){
        $this->sksort($this->datalist,'pos');
        $check = array('pos', 'name','module','view','class','group','attrid');
        $yes = TRUE;
        $this->ViewData('menus', '');
        foreach ($this->datalist as $idx => $value) {
            
            foreach ($check as $is) {
                if(!array_key_exists($is,$value)) {
                    $yes = FALSE;
                    break;
            }
        }
        if($value['group']==$this->group && $yes){
            $contents = $this->menus_values($value);
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
    if(!empty($datalist)){
        foreach ($datalist as $value) {
            if(isset($value['group']) && $value['group']==$this->group){
                $used=($pos==$value['pos'])?" selected='selected'":"";
                $options .= "<option value='".trim($nr)."'".$used.">".trim($nr)."</option>";
                $nr++;
            }
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

public function menus_values($value){
    $special = array('menus','route');
    $menus = array('elements-menu','menu');
    $append = '';
    if(in_array($value['module'],$special)){
        $append .= '<a class="btn btn-success" href="'.HOST_URL.'?menus'.S.'mngmenus&amp;group='.$value['name'].'" >Edytuj</a>';
    }
    if(in_array($value['module'],$menus)){
        $append .= '<a class="btn btn-success" href="'.HOST_URL.'?menus'.S.'mngmenus&amp;data='.$value['name'].'" >Dodaj do menu</a>';
    }
    $sbtngrp = '<span class="input-group-btn">';
    $ebtngrp = '</span>';
    $sgroup ='<div class="input-group">';
    $egroup ='</div>'."\n";
    $contents = "<h4>".ucfirst($value['name'])."</h4>";
    $contents .= $sgroup.$this->select($value['id'],$value['pos'],'pos',$this->datalist);
    $contents .= $sbtngrp.$append.'<a class="btn btn-danger" href="'.HOST_URL.'?menus'.S.'mngmenus&amp;group='.$value['group'].'&amp;action=delete&amp;item='.$value['id'].'">Usuń</a>'.$ebtngrp.$egroup;
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
public function add_menus_item(){
    $special = array('menus','route');
    $sbtngrp = '<span class="input-group-btn">';
    $ebtngrp = '</span>';
    $sgroup ='<div class="input-group">';
    $egroup ='</div>'."\n";
    $sform = '<form action="'.HOST_URL.'?menus'.S.'mngmenus&amp;group='.$this->group.'&amp;action=add" method="post">';
    $eform = '</form>';
    $ipos = 1;
    for ($i=1; $i<count($this->datalist)+1; $i++) {
        if(isset($this->datalist[$i]) && $this->datalist[$i]['group']==$this->group){
            $ipos++;
        }
    }
    $pos = $ipos;
    //$idx = $this->model->Get_Free_Idx('menus','menus');
    $idx=999;
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
    $contents .= '<button type="submit" name="add_item" class="btn btn-success btn-block">Dodaj</button>';
    $this->ViewData('addnewitem', $sform.$contents.$eform);
}
public function showwarning()
{
    $error=$this->NewControllerB(SYS.V.'errors'.S.'warning',SYS.C.'errors'.S.'systemerror');
    $error->setParameter('','inside','yes');
    $error->setParameter('','show_link','no');
    $error->model->title= Intl::_p('Warning!!!');
    $error->model->header= Intl::_p('Warning!!!').' '.$this->error;
    $error->model->alert=Intl::_p($this->emessage).' - ';
    $error->model->error= $this->error;
    return $error->View();
}
}
?>