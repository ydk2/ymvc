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
    }
    
    public function Run(){
        $types = array('module','route','layout');
        //$attr = serialize(array('id'=>'','class'=>'row','style'=>''));
        $this->array = array(
        array('id'=>1,'index'=>1,'name'=>'_name','value'=>'one','group'=>"l"),
        array('id'=>2,'index'=>1,'name'=>'_controller','value'=>'one','group'=>"l"),
        array('id'=>3,'index'=>1,'name'=>'_group','value'=>'','group'=>"l"),
        array('id'=>4,'index'=>1,'name'=>'_view','value'=>'one','group'=>"l"),
        array('id'=>5,'index'=>1,'name'=>'_pos','value'=>1,'group'=>"l"),
        array('id'=>6,'index'=>1,'name'=>'_attr','value'=>'{a}','group'=>"l"),
        array('id'=>7,'index'=>1,'name'=>'_type','value'=>'module','group'=>"l"),

        array('id'=>8,'index'=>2,'name'=>'_name','value'=>'two','group'=>"l"),
        array('id'=>9,'index'=>2,'name'=>'_controller','value'=>'two','group'=>"l"),
        array('id'=>10,'index'=>2,'name'=>'_group','value'=>'','group'=>"l"),
        array('id'=>11,'index'=>2,'name'=>'_view','value'=>'two','group'=>"l"),
        array('id'=>12,'index'=>2,'name'=>'_pos','value'=>1,'group'=>"l"),
        array('id'=>13,'index'=>2,'name'=>'_attr','value'=>'{b}','group'=>"l"),
        array('id'=>14,'index'=>2,'name'=>'_type','value'=>'route','group'=>"l"),

        array('id'=>15,'index'=>3,'name'=>'_name','value'=>'three','group'=>"l"),
        array('id'=>16,'index'=>3,'name'=>'_controller','value'=>'two','group'=>"l"),
        array('id'=>17,'index'=>3,'name'=>'_group','value'=>'','group'=>"l"),
        array('id'=>18,'index'=>3,'name'=>'_view','value'=>'two','group'=>"l"),
        array('id'=>19,'index'=>3,'name'=>'_pos','value'=>1,'group'=>"l"),
        array('id'=>20,'index'=>3,'name'=>'_attr','value'=>'{c}','group'=>"l"),
        array('id'=>21,'index'=>3,'name'=>'_type','value'=>'route','group'=>"l"),
        );
/*

*/
        $this->ViewData('testing', '');

    }
}
?>