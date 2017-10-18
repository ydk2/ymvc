<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
* @Last Modified by: ydk2 (me@ydk2.tk)
* @Last Modified time: 2017-04-20 05:36:59
*/

class Start extends Render {
    
    public $array;
    
    public static function Config() {
        return array(
        'title'=>'Empty user',
        'access_groups'=>array(),
        'view'=>"",
        'access_mode'=>0,
        'model'=>NULL
        );
    }
    
    public function Init(){
        //echo "chuj";
        $this->SetView(APP.THEMES.S.'theme');
        $this->SetModel(SYS.M.'systemdata');
        
        if(!helper::Get('lang')){
            $lang = "en";
        } else {
            $lang = helper::Get('lang');
        }
        if(!helper::Get('page')){
            $pagelink = "index";
        } else {
            $pagelink = helper::Get('page');
        }
        $data = $this->model->Select("pages",array("*"),"WHERE lang=? AND pagelink=?",array($lang,$pagelink));
        $head = $this->model->Select("sitedata",array("*"),"WHERE name=?",array('pagehead'));
        //var_dump($data);
        if($data && $head){
            $this->title = $data[0]['title'];
            $this->head = $head[0]['string'];
            
            $this->header = $data[0]['header'];
            $this->page = $data[0]['body'];
            $this->footer = $data[0]['footer'];
            
        } else {
            $this->page = "<div class='row'>
            <div class='col-sm-12'>
            Empty Page
            </div>
            </div>";
            $this->head = "";
            $this->header = "";
            $this->footer = "";
            $this->title = "Empty Page";
        }
        $this->pagelink = $pagelink;
        $this->lang = $lang;
    }
    
    protected function contents(){
        
        $contents = '';

       // $content->mode = 'system';

        //$content->layout_data=Config::$data['layout_data'];
        //$content->registered = array("layout","views");

        
        $layouts = $this->model->getData(Config::$data['layout_data']);
        $modules = $this->model->getData(Config::$data['modules_data']);
        
        
        //$layouts = $this->model->storeRead("layouts");
        $modules = $this->model->storeRead("modules");
        //$content->layout_group = 'users';
        //$content->current_group = 'users';
        
        $moduleitems = $this->model->itemsData($modules,'user','group');
        $layoutitems = $this->model->itemsData($layouts,'users','group');
        
        $items = array();
        foreach ($moduleitems as $module) {
            $items[]= str_replace('/',DS,$module['path']);
        }

        $content = $this->NewControllerExt(CORE.'layout');
        $content->tag = 'div';
        $content->Layouts($layouts,'users',$items,array());
        $this->page = $content->Render();
    }

    public function Run(){
        
        $this->ViewData('lang',$this->lang);
        $this->ViewData('head',$this->head);
        $this->ViewData('title',$this->title);

        $this->ViewData('user',Helper::Session('user_name'));
        
        $this->navbar();
        $this->langs();
        $this->ViewData('header',$this->autobrakets($this->header));
        //$this->ViewData('page',$this->autobrakets($this->page));
        $this->contents();

        
        $this->ViewData('page',$this->autobrakets($this->page));
        //$this->autobrakets($this->contents));
        $this->ViewData('footer',$this->autobrakets($this->footer));
        //var_dump($this->ViewData('page'));
    }
    
    public function navbar(){
        $sub = $this->Loader(SYS.C.'elements'.DS.'menu');
        $sub->groups = "pages-".$this->lang;
        $sub->ReadDB();
        $this->ViewData('menu', htmlspecialchars($sub->View(SYS.V.'elements'.DS.'navbar')));
    }
    public function langs(){
        $sub = $this->Loader(SYS.C.'elements'.DS.'menu');
        $sub->groups = "pages-lang";
        $sub->ul = "btn-group";
        $sub->li = "btn btn-default";
        $sub->ReadDB();
        $this->ViewData('langmenu', htmlspecialchars($sub->View(SYS.V.'elements'.DS.'menu')));
    }
    
    public function menu($value){
        $menu = '<ul class="nav nav-stacked nav-tabs">';
        foreach($value as $entry):
        $menu .='<li><a href="'.$entry['pagelink'].'">'.$entry['title'].'</a></li>';
        endforeach;
        $menu .= '</ul>';
        return $menu;
    }
}
?>