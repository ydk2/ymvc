<?php

class Menus extends PHPRender {

    public static function Config() {
        return array(
        'title'=>'Menu Administration Manage',
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
        $this->SetView(SYS.V . "manage".S."menus");
        
        $this->group=(!Helper::get('group'))?'main':Helper::get('group');
        
        $this->NewData('','',TRUE);
        //$this -> items = $this -> model -> get_menu($this->group);
    }
    
    public function Run(){
        
        $this->data->link = HOST_URL.'?manage'.S.'menus&group='.$this->group.'';
        $this->link = HOST_URL.'?manage'.S.'menus';
        

        $this->datalist=$this->model->getData(Config::$data['menu_data']);
        $this->model->splitData($this->datalist,$this->group,'group');
        $this->items = $this->model->cache->items;
        $this->others = $this->model->cache->others;
        $this->group_list=$this->model->filter_list($this->datalist,'group');

        if(!empty($this->items)) $this->sksort($this->items,'pos');
        
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
        if(!$this->model->setData(Config::$data['menu_data'],$this->model->joinData($fixedpos,$this->others))){
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