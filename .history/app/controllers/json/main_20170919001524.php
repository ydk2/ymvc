<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
*/
namespace App\Controllers\JSON;


class Main extends \library\Core\Controller
{   
    public function __construct($model){
        parent::__construct($model);
        //if(isset($this->model->guid)) $this->guid = $this->model->guid;
        $this->groups = array("admin","user","editor","mod");

        //$this->uid = 4;
        //if(isset($this->model->uid)) $this->uid = $this->model->uid;
        $this->access = 3;
        

        $this->Run();
    }
    public function Error(){

        //$this->ViewData('header','Error '.$this->error);
        //$this->ViewData('message','Error throwed with success');
        
        $this->model->header = '404 Not found';
        $this->model->message = 'View cannot be found';
        $error = $this->View('/app/views/'.$this->model->theme.'/json/e');
        return $error;
    }
    public function Run(){

    //var_dump($this->model);
    //$this->ViewData('testing', 'ddd');
    //Inc('test/views/test/view','.html');  

        $g=$this->GetAccess(2,TRUE);
        $e=$this->isEnabled(TRUE);
        var_dump($g);
        //var_dump($this->error);

        $this->ViewData('test','jest viewdata');
        //$this->Run();
        $p = ROOT.DS.'p.cache';
        $a = array(
            array('id'=>1,'name'=>'theme','string'=>'default')
        );
        $c = new \Library\Core\Cache();
        //if($c->write($p,$a))
        $r = $c->read($p);

        //$c->set($r,0,array('group'=>'one'));
        //$c->set($r,count($r)+1,array('group'=>'one'));

        $this->ViewData('test',$c->get($r,1)['string']);
        //$c->write($p,$r);

        //$data = array('type'=>'sqlite','database'=>'db','user'=>$user,'pass'=>$pass);
        $db = new \Library\Core\DB;
        $db->Connect(DBTYPE,DBNAME,DBUSER,DBPASS);
        /* */
        $db->createTable('tested',array(
            'name VARCHAR(255)',
            'string VARCHAR(255)'

        ));
        $db->TInsertIF('tested',array('name'=>'info','string'=>'text'));
        /* */
        //$d->dropTable('test');

        //var_dump($d->Select('users'));
        //var_dump(array_flip(get_class_methods($d)));

        if($this->error){
            //$this->Error();
            $this->throwError($this->Error());
        }
    }
}
?>