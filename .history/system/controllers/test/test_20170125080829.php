<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
*/

class Test extends PHPRender {
    
    public $array;
    public $disabled;
    public $enabled;
    public $layouts;
    public $layout_group;
    public $mode;

    public function Init(){
        $this->SetView(SYS.V.'test'.S.'view');
        $this->SetModel(SYS.M.'systemdata');
    }
    
    public function Run(){
        $types = array('module','route','layout');
        //$attr = serialize(array('id'=>'','class'=>'row','style'=>''));
        $this->array = array(
        array('id'=>1,'idx'=>1,'name'=>'_name','value'=>'one','gprx'=>"l"),
        array('id'=>2,'idx'=>1,'name'=>'_controller','value'=>'one','gprx'=>"l"),
        array('id'=>3,'idx'=>1,'name'=>'_group','value'=>'','gprx'=>"l"),
        array('id'=>4,'idx'=>1,'name'=>'_view','value'=>'one','gprx'=>"l"),
        array('id'=>5,'idx'=>1,'name'=>'_pos','value'=>1,'gprx'=>"l"),
        array('id'=>6,'idx'=>1,'name'=>'_attr','value'=>'{a}','gprx'=>"l"),
        array('id'=>7,'idx'=>1,'name'=>'_type','value'=>'module','gprx'=>"l"),

        array('id'=>8,'idx'=>2,'name'=>'_name','value'=>'two','gprx'=>"l"),
        array('id'=>9,'idx'=>2,'name'=>'_controller','value'=>'two','gprx'=>"l"),
        array('id'=>10,'idx'=>2,'name'=>'_group','value'=>'','gprx'=>"l"),
        array('id'=>11,'idx'=>2,'name'=>'_view','value'=>'two','gprx'=>"l"),
        array('id'=>12,'idx'=>2,'name'=>'_pos','value'=>1,'gprx'=>"l"),
        array('id'=>13,'idx'=>2,'name'=>'_attr','value'=>'{b}','gprx'=>"l"),
        array('id'=>14,'idx'=>2,'name'=>'_type','value'=>'route','gprx'=>"l"),

        array('id'=>15,'idx'=>3,'name'=>'_name','value'=>'three','gprx'=>"l"),
        array('id'=>16,'idx'=>3,'name'=>'_controller','value'=>'two','gprx'=>"l"),
        array('id'=>17,'idx'=>3,'name'=>'_group','value'=>'','gprx'=>"l"),
        array('id'=>18,'idx'=>3,'name'=>'_view','value'=>'two','gprx'=>"l"),
        array('id'=>19,'idx'=>3,'name'=>'_pos','value'=>1,'gprx'=>"l"),
        array('id'=>20,'idx'=>3,'name'=>'_attr','value'=>'{c}','gprx'=>"l"),
        array('id'=>21,'idx'=>3,'name'=>'_type','value'=>'route','gprx'=>"l"),
        );
/*

*/
        $this->ViewData('testing', '');

    }
}
?>