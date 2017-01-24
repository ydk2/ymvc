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
    public $layout_groups;
    public $mode;

    public function Init(){
        $this->SetView(SYS.V.'test'.S.'view');
        $this->SetModel(SYS.M.'SystemData');
    }
    
    public function Run(){
        $types = array('module','route','layout');
        //$attr = serialize(array('id'=>'','class'=>'row','style'=>''));
        $this->array = array(
        array('id'=>1,'index'=>1,'name'=>'_name','value'=>'one','groups'=>"l"),
        array('id'=>2,'index'=>1,'name'=>'_controller','value'=>'one','groups'=>"l"),
        array('id'=>3,'index'=>1,'name'=>'_group','value'=>'','groups'=>"l"),
        array('id'=>4,'index'=>1,'name'=>'_view','value'=>'one','groups'=>"l"),
        array('id'=>5,'index'=>1,'name'=>'_pos','value'=>1,'groups'=>"l"),
        array('id'=>6,'index'=>1,'name'=>'_attr','value'=>'{a}','groups'=>"l"),
        array('id'=>7,'index'=>1,'name'=>'_type','value'=>'module','groups'=>"l"),

        array('id'=>8,'index'=>2,'name'=>'_name','value'=>'two','groups'=>"l"),
        array('id'=>9,'index'=>2,'name'=>'_controller','value'=>'two','groups'=>"l"),
        array('id'=>10,'index'=>2,'name'=>'_group','value'=>'','groups'=>"l"),
        array('id'=>11,'index'=>2,'name'=>'_view','value'=>'two','groups'=>"l"),
        array('id'=>12,'index'=>2,'name'=>'_pos','value'=>1,'groups'=>"l"),
        array('id'=>13,'index'=>2,'name'=>'_attr','value'=>'{b}','groups'=>"l"),
        array('id'=>14,'index'=>2,'name'=>'_type','value'=>'route','groups'=>"l"),

        array('id'=>15,'index'=>3,'name'=>'_name','value'=>'three','groups'=>"l"),
        array('id'=>16,'index'=>3,'name'=>'_controller','value'=>'two','groups'=>"l"),
        array('id'=>17,'index'=>3,'name'=>'_group','value'=>'','groups'=>"l"),
        array('id'=>18,'index'=>3,'name'=>'_view','value'=>'two','groups'=>"l"),
        array('id'=>19,'index'=>3,'name'=>'_pos','value'=>1,'groups'=>"l"),
        array('id'=>20,'index'=>3,'name'=>'_attr','value'=>'{c}','groups'=>"l"),
        array('id'=>21,'index'=>3,'name'=>'_type','value'=>'route','groups'=>"l"),
        );
/*

*/
        $this->ViewData('testing', '');

    }
}
?>