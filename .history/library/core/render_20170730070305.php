<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
*/
namespace Library\Core;


class Render 
{   
    public $array;
    public $disabled;
    public $enabled;
    public $layouts;
    public $layout_group;
    public $mode;
	public $name;
	public $access;
	public $current_group;
	public $access_groups;
	public $model;
	public $data;
	public $view;
	public $emessage;
	public $error;

    
    public function __construct(){
        //parent::__construct();
        $this->data = new Data();
        $this->name=get_class($this);
        //echo $this->name;
    }
    

    public function Run(){
        //$this->ViewData('testing', 'ddd');
        echo View('test/views/test/view','.html');
    }
}
?>