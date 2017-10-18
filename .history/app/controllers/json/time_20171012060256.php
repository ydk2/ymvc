<?php
/*
* @Author: ydk2 (info@ydk2.tk)
* @Date: 2017-01-21 16:22:09
* @Last Modified by: ydk2 (me@ydk2.tk)
* @Last Modified time: 2017-01-21 22:00:35
*/
namespace App\controllers\JSON;


class Time extends \library\Core\Controller
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
        $this->ViewData('event', 'message');
        $this->ViewData('data', date("Y-m-d H:i:s",time()));
        if($this->error){
            $this->throwError($this->Error());
        }
    }
    
    public function Error(){
        $this->model->appid = NULL;
        $this->model->scope = 'Error';
        $this->model->request = '{"Error"}';
        $this->model->response = 'Something wrong';
        $this->model->error = $this->error;
        $error = $this->View('/app/views/' . $this->model->theme . '/shared/e');
        return $error;
    }
}
?>