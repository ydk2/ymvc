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

    $this->special = array('layout','route');
    $this->menus = array('elements-menu','menu');
        //$this->ViewData('header', 'Manage Layouts');
    }


    public function Run(){

        $this->data->link = HOST_URL.'?manage'.S.'layouts&group='.$this->group.'';
        $this->link = HOST_URL.'?manage'.S.'layouts';


        $this->datalist=$this->model->getSettings('layout_data');
        $this->items = array();
        $this->others = array();
        $this->inColumn();
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
            $save = file_put_contents(Config::$data['layout_data'],serialize($fixedpos));
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
        $show=(Helper::get('cols')=='')?'':Helper::get('cols');
        $showed = Helper::cookie('cols');
        if(!Helper::cookie('cols') && $show!=''){
            Helper::cookie_register('cols',$show,1000);
            $showed = $show;
        }
        elseif(Helper::cookie('cols')!=$show && $show!=''){
            Helper::cookie_set('cols',$show);
            $showed = $show;
        }
        $this->columns=array();
        $this->columns['Jednej']=$this->data->link.'&cols=1';
        $this->columns['Dwóch']=$this->data->link.'&cols=2';
        $this->columns['Trzech']=$this->data->link.'&cols=3';
        switch ($showed) {
            case '3':
                $cols = 'col-sm-4';
                break;
            
            case '1':
                $cols = 'col-sm-12';
                break;

            case '2':
                $cols = 'col-sm-6';
                break;
            
            default:
                $cols = 'col-sm-6';
                break;
    }
    $this->cols=$cols;
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