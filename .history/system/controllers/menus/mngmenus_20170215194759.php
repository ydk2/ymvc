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
        
        $this->group=(!Helper::get('group'))?'main':Helper::get('group');
        
        $this->NewData('','',TRUE);
        //$this -> items = $this -> model -> get_menu($this->group);
    }
    
    public function Run(){
        
        $this->data->link = HOST_URL.'?menus'.S.'mngmenus&group='.$this->group.'';
        $this->link = HOST_URL.'?menus'.S.'mngmenus';
        

        $this->datalist=unserialize(file_get_contents(Config::$data['menu_data']));
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
        return true;
        
        /**/
        $this->datalist=null;
        $this->datalist[1]=array('id'=>1,'pos'=>1,'title'=>'none1','link'=>'null','parent'=>'','group'=>'main');
        $this->datalist[2]=array('id'=>2,'pos'=>2,'title'=>'none2','link'=>'null','parent'=>'','group'=>'main');
        $this->datalist[3]=array('id'=>3,'pos'=>3,'title'=>'none3','link'=>'null','parent'=>'','group'=>'main');
        $this->datalist[4]=array('id'=>4,'pos'=>4,'title'=>'none4','link'=>'null','parent'=>'','group'=>'m');
        $this->datalist[5]=array('id'=>5,'pos'=>5,'title'=>'none5','link'=>'null','parent'=>'','group'=>'m');
        $this->datalist[6]=array('id'=>6,'pos'=>6,'title'=>'none6','link'=>'null','parent'=>'','group'=>'m');
        $save = file_put_contents(ROOT.STORE.'menus.data',serialize($this->datalist));
        /**/
        $enabled = Config::$data['enabled'];
        $disabled = Config::$data['disabled'];
        
        
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
    
    public function menu($data, $parent = '') {
        
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
        $this->setview(SYS.V.'menus'.S.'msg');
        $this->data->header = 'Błąd!!!';
        $this->data->text = 'Operacja Nie Istnieje';
        if(Helper::get('action')=='add' && isset($_POST['add'])){
            $frompost = Helper::post('item');

            /**/
            $chk=0;
            if($frompost['title']!='' && $frompost['link']!=''){
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
        
        if(!empty($this->others)&&!empty($updateditems)){
            $this->sksort($updateditems,'pos');
            $p = 1;
            foreach ($updateditems as $fix) {
                $fix['pos']=$p;
                $fixedpos[]=$fix;
                $p++;
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