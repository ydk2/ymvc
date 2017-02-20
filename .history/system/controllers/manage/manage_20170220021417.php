<?php

class Manage extends PHPRender {

    public static function Config() {
        return array(
        'title'=>'Administration Module',
        'access_groups'=>array('admin','editor')
        );
    }
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
        $this->SetView(SYS.V . "manage".S."manage");
        //$this -> items = $this -> model -> get_menu($this->groups);
        
        $this->group=(Helper::get('group')=='')?'main':Helper::get('group');
        
        $enabled = Config::$data['enabled'];
        $disabled = Config::$data['disabled'];
        
        $this->special = array('layout','route');
        $this->menus = array('elements-menu','menu');
        //$this->ViewData('header', 'Manage Layouts');
    }
    
    
    public function Run(){

        $this->data->link = HOST_URL.'?manage'.S.'manage&group='.$this->group.'';
        $this->link = HOST_URL.'?manage'.S.'manage';
        

        $this->datalist=$this->model->getData(Config::$data['layouts_data']);
        $this->model->splitData($this->datalist,$this->group,'group');
        $this->items = $this->model->cache->items;
        $this->others = $this->model->cache->others;
        $this->group_list=$this->model->filter_list($this->datalist,'group');

        if(!empty($this->items)) $this->sortby($this->items,'pos');


        $this->inColumn();

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
            $chk=$this->model->unsetItem($this->items,Helper::get('item'),'id');
            if($chk){
                $this->Save($this->items);
            } else {
                $this->data->header = 'Nie Udane';
                $this->data->text = 'Operacja zakończona błędem';
            }
        }
    }
    private function Save($updateditems=array()){

        $fixedpos = $this->model->fixby($updateditems,'pos');
        if(!$this->model->setData(Config::$data['layouts_data'],$this->model->joinData($fixedpos,$this->others))){
            $this->data->header= 'Nie Udane';
            $this->data->text= 'Operacja zakończona błędem';
        } else {
            $this->data->header= 'Udane';
            $this->data->text= 'Operacja zakończona powodzeniem';
        }
    }
    public function freekey(){
        return $this->model->freekey($this->datalist,'id');
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