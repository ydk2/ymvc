<?php

class Administration extends Render {

    public static function Config() {
        return array(
        'title'=>'Main Administration Manage',
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
        $this->SetView(SYS.V . "admin".S."administration");
        //$this -> items = $this -> model -> get_menu($this->groups);
        $this->message='System Main';
        $this->group=(Helper::get('group')=='')?'main':Helper::get('group');
        //$this->ViewData('header', 'Manage Layouts');
        $this->groups=Config::$data['layouts']['current'];

        $this->datalist=$this->model->getData(Config::$data['menu_data']);

        $this->subitems = $this->model->itemsData($this->datalist,$this->groups,'group');
        $this->mainitems = $this->model->itemsData($this->datalist,Config::$data['mainitems'],'group');

    }

    public function Run(){


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
        if($this->error > 0) return "<h1>Error</h1>";
        
    }
 
}
?>