<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
*/
namespace Test\Controllers\Test;


class One extends \library\Core\Render
{   
    public function __construct(){
        parent::__construct();
        //$this->data = new \Data;
        //echo 'chuj';
        $this->ViewData('test','jest viewdata');
        //$this->Run();
        if($this->error == NULL){
            $this->Error('
        <div class="row">
          <div class="col-md-12">
            <div class="alert alert-dismissable alert-success">
              <strong>Well done!</strong>You successfully read this important alert message.</div>
          </div>
        </div>');
        }
        
    }
   // public function Run(){
        //$this->ViewData('testing', 'ddd');
       // Inc('test/views/test/view','.html');
    //}
}
?>