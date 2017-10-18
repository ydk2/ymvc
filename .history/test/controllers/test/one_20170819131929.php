<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
*/
namespace Test\Controllers\Test;


class One extends \library\Core\mainController
{   
    public function __construct(){
        parent::__construct();
        //$this->data = new \Data;
        //echo 'chuj';
        $this->ViewData('test','jest viewdata');
        //$this->Run();
        if($this->error){
            $this->ViewData('header','Error');
            $this->ViewData('message','Error throwed with success');
            $this->throwError($this->View('test/views/test/error','.html'));
        }
        $p = ROOT.DS.'p.cache';
        $a = array(
            array('id'=>1,'name'=>'theme','string'=>'default')
        );
        $c = new \Library\Core\Cache();
        //if($c->write($p,$a))
        $r = $c->read($p);

        $c->set($r,4,array('group'=>'one'));

        $this->ViewData('test',$c->encode($r));
        
        
    }
   // public function Run(){
        //$this->ViewData('testing', 'ddd');
       // Inc('test/views/test/view','.html');
    //}
}
?>