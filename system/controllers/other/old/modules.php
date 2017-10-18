<?php

class Modules extends PHPRender {
    protected $ul="";
    protected $li="";

    public static function Config() {
        return array(
        'title'=>'Modules Manage',
        'access_groups'=>array('admin','editor'),
        'view'=>SYS.V . "manage".S."modules",
        'access_mode'=>2,
        'model'=>SYS.M.'systemdata',
        'exceptions'=>TRUE,
        'access'=>self::ACCESS_ANY
        );
    }

    public function Init() {
        /*
        $this->name_model = $model;
        $this->model = new $model();
        $this->view = $view;
        *
        */
        $this->inc(CORE.'fileutils');
        $config=self::Config();
        $this->exceptions = TRUE;
        $this->SetAccess(self::ACCESS_ANY);
        $this->access_groups = $config['access_groups'];//array('admin','editor');
        $this->current_group = Helper::Session('user_role');
        $this->AccessMode($config['access_groups']);
        $this->SetModel($config['model']);

        if(Helper::get("manage".S."modules")=="" || $this->error == 20404)
        $this->SetView($config['view']);

        $this->group=(!Helper::get('group'))?'main':Helper::get('group');
        
        $this->NewData('','',TRUE);
        $this->data->link = HOST_URL.'?manage'.S.'modules'.'='.'manage'.S.'modules'.S.'list&group='.$this->group.'';
        $this->link = HOST_URL.'?manage'.S.'modules';
        //$this -> items = $this -> model -> get_menu($this->group);
        //Config::$data['modules_data']=DOCROO

    }

    public function Run(){

        $this->data->link = HOST_URL.'?manage'.S.'modules'.'='.'manage'.S.'modules'.S.'list&group='.$this->group.'';
        $this->link = HOST_URL.'?manage'.S.'modules';
        $this->datalist=$this->model->getData(Config::$data['modules_data']);
        $this->model->splitData($this->datalist,'manage','group');
        $this->items = $this->model->cache->items;
        $this->others = $this->model->cache->others;
        $this->group_list=$this->model->filter_list($this->datalist,'group');

        if(!empty($this->items)) $this->sortby($this->items,'pos');

        $this->data->header = 'Brak elementów';
        $this->data->text = 'Dodaj nowy';
        if(Helper::get('action')){
            $this->Action();
        } else {
            $this->files=FileUtils::inDir(ROOT.SYS.C.Helper::get('path').'/*'); //+FileUtils::inDir(ROOT.APP.C.Helper::get('path').'/*');
        }

        $enabled = Config::$data['enabled'];
        $disabled = Config::$data['disabled'];


    }
    private function Action(){
        if(Helper::get('add')){
            $this->setview(SYS.V . "manage".S."modules".S.'edit');
        }
    }

    private function Actions(){
        $this->setview(SYS.V.'elements'.S.'msg');
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
        if(!$this->model->setData(Config::$data['modules_data'],$this->model->joinData($fixedpos,$this->others))){
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


public function showwarning()
{
    $error=$this->NewViewExt(SYS.V.'errors'.S.'warning',SYS.C.'errors'.S.'systemerror');
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