<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
*/
namespace test\controllers\test;


class One extends \library\core\Render
{   
    public function __construct(){
        parent::__construct();
        //$this->data = new \Data;
        //echo 'chuj';
        $this->Run();
    }
    
   // public function Run(){
        //$this->ViewData('testing', 'ddd');
       // Inc('test/views/test/view','.html');
    //}
}
?>