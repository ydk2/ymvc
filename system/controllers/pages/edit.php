<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
* @Last Modified by: ydk2 (me@ydk2.tk)
* @Last Modified time: 2017-04-20 05:40:18
*/

class Edit extends Render {
    
    public $array;
    private $pagedata;
    
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
        $this->SetView(SYS.V.'pages'.S.'edit');
        $this->SetModel(SYS.M.'systemdata');
        
        $acc = Helper::Session('user_role');
        $gacc = array('admin','editor');
        $this->acc = $this->CheckAccess(2,$acc,$gacc);
    }
    
    public function Run(){
        
        $data = array('login','name','born');
        $this->ViewData('test', Helper::Dump($this->acc));
        if($this->acc){
            $this->editpage();
        }
        
    }
    
    public function Page(){
        
    }
    
    public function editpage(){
        
        $title = Helper::Post('title');
        $head = Helper::Post('head');
        $pagelink = Helper::Post('pagelink');
        $lang = Helper::Post('lang');
        $header = Helper::Post('header');
        $body = Helper::Post('body');
        $footer = Helper::Post('footer');
        $elements = array(
        'title'=>$title,
        'head'=>$head,
        'pagelink'=>$pagelink,
        'lang'=>$lang,
        'header'=>$header,
        'body'=>$body,
        'footer'=>$footer
        );
        foreach ($elements as $key => $value) {
            $this->ViewData($key,$value);
        }
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
        if($data){
            foreach ($data[0] as $key => $value) {
                $this->ViewData($key,$value);
            }
        }
        if(Helper::Post('update')){
            
            if($head){
                $insert = $this->model->TInsertUpdate('sitedata',array('name'=>'pagehead','string'=>$head),"WHERE name='pagehead'",array());
                
                $this->ViewData('link', htmlspecialchars(HOST_URL.'?pages'.S.'edit'.'&lang='.$elements['lang'].'&page='.$elements['pagelink']));
                $this->setview(SYS.V.'elements'.S.'msg');
                if(!$insert){
                    $this->data->header= intl::_('Nie Udane');
                    $this->data->text= intl::_('Operacja zakończona błędem');
                } else {
                    $this->data->header= intl::_('Udane');
                    $this->data->text= intl::_('Operacja zakończona powodzeniem');
                }
            }
            
        } else {
            
            if($title && $pagelink && $lang && $header && $body && $footer){
                $insert = $this->model->TInsertUpdate('pages',$elements,"WHERE lang='".$elements['lang']."' AND pagelink='".$elements['pagelink']."'",array());
                
                $this->ViewData('link', htmlspecialchars(HOST_URL.'?pages'.S.'edit'.'&lang='.$elements['lang'].'&page='.$elements['pagelink']));
                $this->setview(SYS.V.'elements'.S.'msg');
                if(!$insert){
                    $this->data->header= intl::_('Nie Udane');
                    $this->data->text= intl::_('Operacja zakończona błędem');
                } else {
                    $this->data->header= intl::_('Udane');
                    $this->data->text= intl::_('Operacja zakończona powodzeniem');
                }
            }
            
        }
        
    }
    
    
}
?>