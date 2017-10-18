<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
*/
class One extends mainController 
{   
    public function __construct($theme){
        parent::__construct();
        //$this->data = new \Data;
        //echo 'chuj';
        $this->ViewData('test','jest viewdata');
        //$this->Run();
        if($this->error){
            $this->ViewData('header','Error');
            $this->ViewData('message','Error throwed with success '.$this->error);
            $this->throwError($this->View('test/views/core/error','.html'));
        }
        
    }
   // public function Run(){
        //$this->ViewData('testing', 'ddd');
       // Inc('test/views/test/view','.html');
    //}
}
?>