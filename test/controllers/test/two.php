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
        $this->groups = array("admin","user","editor","mod");
        $this->access = 10;
        $g=$this->GetAccess(2,TRUE);
        $e=$this->isEnabled(TRUE);
        
        $this->Run();
    }
    
    public function Run(){
        $this->ViewData('test', HOST);
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