<?php

class Manage extends Render {
    protected $link;
    protected $postvals;
    private $store;
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
        if(helper::get("manage".S."manage")=="")
        $this->SetView(SYS.V . "manage".S."manage");
        $this->group=(Helper::get('group')=='')?'main':Helper::get('group');
        //$this -> items = $this -> model -> get_menu($this->groups);

        $inuse = staticCache::getCache(Config::$data['inuse']);
        if(!$inuse){
            $inuse = array();
        }
        $this->subview = '';
        if(!in_array(helper::session('token'),$inuse) && !array_key_exists($this->name,$inuse)){
        $inuse[$this->name]=helper::session('token');
        staticCache::setCache(Config::$data['inuse'],$inuse);
        } else {
            if($inuse[$this->name]!=helper::session('token')){
            $this->data->link_yes=$this->data->link."&answer=yes";
            $this->data->link_no=$this->data->link."&answer=no";
            $this->data->header=intl::_("Uwaga!!!");
            $this->data->text=intl::_("używane przez").' '.$inuse[$this->name];
            $this->data->type = "alert-danger";
            $this->subview = $this->subView(SYS.V."elements-alert");
            }
        }

        $enabled = Config::$data['enabled'];
        $disabled = Config::$data['disabled'];
        
        $this->special = array('layout','route');
        $this->menus = array('elements-menu','menu');
        //$this->ViewData('header', 'Manage Layouts');
    }
    
    public function storeWrite($store){
        //$this->data->link = $this->data->link.'&group='.$this->group.'';
        $this->setview(SYS.V.'elements'.S.'msg');
        $data = $this->model->getData(Config::$data[$store.'_data']);
        $stored = $this->model->storeWrite($store,$data);
        if(!$stored){
            $this->data->header= intl::_('Nie Udane');
            $this->data->text= intl::_('Operacja zakończona błędem');
        } else {
            $this->data->header= intl::_('Udane');
            $this->data->text= intl::_('Operacja zakończona powodzeniem');
        }
    }
    public function storeRead($store){
        //$this->data->link = $this->data->link.'&group='.$this->group.'';
        $this->setview(SYS.V.'elements'.S.'msg');
        $readed = $this->model->storeReadString($store);
        if(!$readed){
            $this->data->header= intl::_('Nie Udane');
            $this->data->text= intl::_('Operacja zakończona błędem');
        } else {
            if(!file_put_contents(Config::$data['saved_data'],$readed)){
                $this->data->header= intl::_('Nie Udane');
                $this->data->text= intl::_('Operacja zakończona błędem');
            } else {
                $this->data->header= intl::_('Udane');
                $this->data->text= intl::_('Operacja zakończona powodzeniem');
                //$this->data->text= intl::_($this->Dump($readed['string']));
            }
        }  
    }

    public function choose(){
        $this->data->link = HOST_URL.'?manage'.S.'manage&group='.$this->group.'';
        $this->link = HOST_URL.'?manage'.S.'manage';
        $one1 = $this->model->getData(Config::$data['menu_data']);
        $one2 = $this->model->getData(Config::$data['layout_data']);
        $one3 = $this->model->getData(Config::$data['modules_data']);
        $this->datalist=$one1+$one2+$one3;
        $this->group_list=$this->model->filter_list($this->datalist,'group');

        $this->data->header = 'Brak elementów';
        $this->data->text = 'Dodaj nowy';
        if(Helper::get('action')){
            $this->ActionGroups();
        }


    }

    public function groups(){
        $this->data->link = HOST_URL.'?manage'.S.'manage=manage'.S.'groups&group='.$this->group.'';
        $this->link = HOST_URL.'?manage'.S.'manage';
        //$one = $this->model->getData(Config::$data['layout_data']);
        $one1 = $this->model->getData(Config::$data['menu_data']);
        $one2 = $this->model->getData(Config::$data['layout_data']);
        $one3 = $this->model->getData(Config::$data['modules_data']);
        $this->datalist=array();
        $this->datalist=$this->model->joinData($one3,$one1);
        $this->datalist=$this->model->joinData($this->datalist,$one2);
        $this->group_list=$this->model->filter_list($this->datalist,'group');

        $this->data->header = 'Brak elementów';
        $this->data->text = 'Dodaj nowy';
        if(Helper::get('action')){
            $this->ActionGroups();
        }


    }
    
    public function ActionGroups(){}

    public function Run(){
        switch ($this->view) {
            case SYS.V . "manage".DS."manage":
                Config::$data['saved_data']=Config::$data['group_data'];
                $this->store = 'group';
                $this->choose();
                break;
            case SYS.V . "manage".DS."layouts":
                Config::$data['saved_data']=Config::$data['layout_data'];
                $this->store = 'layout';
                $this->layout();
                break;
            case SYS.V . "manage".DS."menus":
                Config::$data['saved_data']=Config::$data['menu_data'];
                $this->store = 'menu';
                $this->menus();
                break;
            case SYS.V . "manage".DS."groups":
                Config::$data['saved_data']=Config::$data['group_data'];
                $this->store = 'group';
                $this->groups();
                break;

            case SYS.V."manage".DS."modules":
            case SYS.V."manage".DS."modules".DS."list":
            case SYS.V."manage".DS."modules".DS.'edit':
            case SYS.V."manage".DS."modules".DS.'available':
                $this->inc(CORE.'fileutils');
                Config::$data['saved_data']=Config::$data['modules_data'];
                $this->store = 'modules';
                $this->modules();
                break;
            default:
                $this->choose();
                break;
        }

        if(Helper::Get('read')){
            return $this->storeRead($this->store);
        }
        if(Helper::Get('write')){
            return $this->storeWrite($this->store);
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


    public function Menus(){

        $this->data->link = HOST_URL.'?manage'.S.'manage=manage'.S.'menus&group='.$this->group.'';
        $this->data->link_yes = HOST_URL.'?manage'.S.'manage=manage'.S.'menus&group='.$this->group.'&answer=yes';
        $this->data->link_no = HOST_URL.'?manage'.S.'manage=manage'.S.'menus&group='.$this->group.'';
        $this->link = HOST_URL.'?manage'.S.'manage=manage'.S.'menus';


        $this->datalist=$this->model->getData(Config::$data['saved_data']);
        $this->model->splitData($this->datalist,$this->group,'group');
        $this->items = $this->model->cache->items;
        $this->others = $this->model->cache->others;
        $this->group_list=$this->model->filter_list($this->datalist,'group');

        if(!empty($this->items)) $this->sortby($this->items,'pos');

        $this->data->header = intl::_('Brak elementów');
        $this->data->text = intl::_('Dodaj nowy');
        if(Helper::get('action')){
            $this->ActionMenu();
        }
        /**/
        $enabled = Config::$data['enabled'];
        $disabled = Config::$data['disabled'];


    }

    private function ActionMenu(){
        $this->data->header = intl::_('Błąd!!!');
        $this->data->text = intl::_('Operacja Nie Istnieje');
        if(Helper::get('action')=='add' && isset($_POST['add'])){
            $frompost = Helper::post('item');

            $this->setview(SYS.V.'elements'.S.'msg');
            /**/
            $chk=0;
            if($frompost['title']!='' && $frompost['link']!=''){
                array_push($this->items,$frompost);
                $this->Save($this->items);
            } else {
                $this->data->header = intl::_('Uwaga!!!');
                $this->data->text = intl::_('Pola nie mogą być puste');
            }
            /**/
        }
        if(Helper::get('action')=='update'){
            $updateditems = Helper::post('items');
            $this->Save($updateditems);
        }
        if(Helper::get('action')=='delete' && Helper::get('item')){

            $this->data->link_yes=$this->data->link."&action=delete&item=".Helper::get('item')."&answer=yes";
            $this->data->link_no=$this->data->link."&answer=no";
                $this->data->header = intl::_('Hej!!!');
                $this->data->text = intl::_('Napewno usunąć');
            $this->setview(SYS.V.'elements'.S.'answer');
            if(helper::get('answer')=='yes'){
            $chk=$this->model->unsetItem($this->items,Helper::get('item'),'id');
                $this->setview(SYS.V.'elements'.S.'msg');
            if($chk){
                $this->Save($this->items);
            } else {
                $this->data->header = intl::_('Nie Udane');
                $this->data->text = intl::_('Operacja zakończona błędem');
            }
            }
        }
    }
    public function Layout(){

        $this->data->link = HOST_URL.'?manage'.S.'manage=manage'.S.'layouts&group='.$this->group.'';
        $this->link = HOST_URL.'?manage'.S.'manage=manage'.S.'layouts';


        $this->datalist=$this->model->getData(Config::$data['saved_data']);
        $this->model->splitData($this->datalist,$this->group,'group');
        $this->items = $this->model->cache->items;
        $this->others = $this->model->cache->others;
        $this->group_list=$this->model->filter_list($this->datalist,'group');

        if(!empty($this->items)) $this->sortby($this->items,'pos');


        $this->inColumn();

        $this->data->header = intl::_('Brak elementów');
        $this->data->text = intl::_('Dodaj nowy');
        if(Helper::get('action')){
            $this->ActionLayout();
        }


    }
    private function ActionLayout(){
        $this->setview(SYS.V.'elements'.S.'msg');
        $this->data->header = intl::_('Błąd!!!');
        $this->data->text = intl::_('Operacja Nie Istnieje');
        if(Helper::get('action')=='add' && isset($_POST['add'])){
            $frompost = Helper::post('item');

            /**/
            $chk=0;
            if($frompost['name']!='' && $frompost['module']!=''){
                array_push($this->items,$frompost);
                $this->Save($this->items);
            } else {
                $this->data->header = intl::_('Uwaga!!!');
                $this->data->text = intl::_('Pola nie mogą być puste');
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
                $this->data->header = intl::_('Nie Udane');
                $this->data->text = intl::_('Operacja zakończona błędem');
            }
        }
    }

    public function modules(){
        switch ($this->view) {
            case SYS.V."manage".DS."modules":
                $this->data->link = HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'modules&group='.$this->group.'';
                break;
            case SYS.V."manage".DS."modules".DS."list":
                $this->data->link = HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'modules'.S.'list&group='.$this->group.'';
                break;
            case SYS.V."manage".DS."modules".DS.'available':
                $this->data->link = HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'modules'.S.'available&group='.$this->group.'';
                break;
            default:
                $this->data->link = HOST_URL.'?manage'.S.'manage'.'='.'manage'.S.'modules&group='.$this->group.'';
                break;
        }
        $this->app=(Helper::get('app')=='')?'system':Helper::get('app');
        $this->link = HOST_URL.'?manage'.S.'manage';
        $this->datalist=$this->model->getData(Config::$data['saved_data']);
        $this->model->splitData($this->datalist,$this->group,'group');
        $this->items = $this->model->cache->items;
        $this->others = $this->model->cache->others;
        $this->group_list=$this->model->filter_list($this->datalist,'group');

        //if(!empty($this->items)) $this->sortby($this->items,'pos');
        //var_dump($this->app);
        $this->data->header = intl::_('Brak elementów');
        $this->data->text = intl::_('Dodaj nowy');
        if(helper::get('action') || is_file(ROOT.base64_decode(helper::get('path')).EXT)){
            $this->Actionmodules();
        } else {
            $path = (helper::get('path')=="")?ROOT.$this->app.DS.C:ROOT.base64_decode(helper::get('path'));
            //var_dump($path);
            $this->files=FileUtils::inDir($path.'/*'); //+FileUtils::inDir(ROOT.APP.C.Helper::get('path').'/*');
        }

        $enabled = Config::$data['enabled'];
        $disabled = Config::$data['disabled'];


    }
    private function Actionmodules(){
        $this->setview(SYS.V . "manage".S."modules".S.'edit');
        $post = Helper::post('items');
        if($post && Helper::get('action')=="edit"){
            if(!$this->model->cache->itemExists($this->items,$post['path'],'path')){
                $this->postvals = $this->dump(helper::post('items'));
                array_push($this->items,helper::post('items'));
                $this->SaveModules();
            } else {
            $this->setview(SYS.V . "elements".S."msg");
            $this->data->header= intl::_('Nie Udane');
            $this->data->text= intl::_('Operacja zakończona niepowodzeniem, wpis już istnieje');
            $this->data->link=$this->data->link.'&path='.Helper::get('path');
            }
        }
        if(Helper::get('action')=='delete' && Helper::get('item')){
            $chk=$this->model->unsetItem($this->items,helper::get('item'),'id');
            if($chk){
                $this->SaveModules();
            } else {
                $this->setview(SYS.V . "elements".S."msg");
                $this->data->header= intl::_('Nie Udane');
                $this->data->text= intl::_('Operacja zakończona błędem');
                $this->data->link= $this->data->link.'&path='.Helper::get('path');
            }
        }


    }

    private function SaveModules(){

        if(!$this->model->setData(Config::$data['saved_data'],$this->model->joinData($this->items,$this->others))){
            $this->setview(SYS.V . "elements".S."msg");
            $this->data->header= intl::_('Nie Udane');
            $this->data->text= intl::_('Operacja zakończona błędem');
            $this->data->link= $this->data->link.'&path='.Helper::get('path');
        } else {
            $this->setview(SYS.V . "elements".S."msg");
            $this->data->header= intl::_('Udane');
            $this->data->text= intl::_('Operacja zakończona powodzeniem');
            $this->data->link=$this->data->link.'&path='.Helper::get('path');
        }
    }

    private function Save($updateditems=array()){

        $fixedpos = $this->model->fixby($updateditems,'pos');
        if(!$this->model->setData(Config::$data['saved_data'],$this->model->joinData($fixedpos,$this->others))){
            $this->data->header= intl::_('Nie Udane');
            $this->data->text= intl::_('Operacja zakończona błędem');
        } else {
            $this->data->header= intl::_('Udane');
            $this->data->text= intl::_('Operacja zakończona powodzeniem');
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
    return "<h1>Error $this->error</h1>";
}

}
?>