<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
*/
namespace App\Controllers\JSON;


class E extends \Library\Core\Controller
{   
    public function __construct($model){
        parent::__construct();
        $this->ViewData('error',$model->error);
        $this->ViewData('request',$model->request);
        $this->ViewData('scope',$model->scope);
        $this->ViewData('token',$model->token);
        $this->ViewData('response',$model->response);
    }
   // public function Run(){
        //$this->ViewData('testing', 'ddd');
       // Inc('test/views/test/view','.html');
    //}
}
?>