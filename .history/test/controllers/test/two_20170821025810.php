<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
* @Last Modified by: ydk2 (me@ydk2.tk)
* @Last Modified time: 2017-01-21 22:00:35
*/
namespace test\controllers\test;


class Two extends \library\Core\Controller
{
    public function __construct($model){
        parent::__construct($model);
        //if(isset($this->model->guid)) $this->guid = $this->model->guid;
        $this->groups = array("admin","user","editor","mod");
        
        //$this->uid = 4;
        //if(isset($this->model->uid)) $this->uid = $this->model->uid;
        $this->access = 10;
        
        
        $this->Run();
    }
    
    public function Run(){
        $this->ViewData('test', 'ddd');
        if($this->error){
            $this->throwError($this->Error());
        }
    }
    
    public function Error(){
        $this->ViewData('header','Error '.$this->error);
        $this->ViewData('message','Error throwed with success');
        $error = $this->View('/test/views/'.$this->model->theme.'/test/error');
        return $error;
    }
}
?>