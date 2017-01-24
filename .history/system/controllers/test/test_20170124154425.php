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
    public function GetId($data,$index,$name){
        foreach ($data as $items) {
            if($items['index']==$index && $items['name']==$name)
            return $items['id'];
        }
        return NULL;
    }

    public function GetValue($data,$index,$name){
        foreach ($data as $items) {
            if($items['index']==$index && $items['name']==$name)
            return $items['value'];
        }
        return NULL;
    }

    public function SetName(&$data,$index,$name,$newname){
        foreach ($data as $i => $items) {
            if($items['index']==$index && $items['name']==$name){
                $data[$i]['name']=$newname;
                return $items['value'];
            }
        }
        return NULL;
    }

    public function SetValue(&$data,$index,$name,$value){
        foreach ($data as $i => $items) {
            if($items['index']==$index && $items['name']==$name){
                $data[$i]['value']=$value;
                return $items['value'];
            }
        }
        return NULL;
    }

    public function searchByName($data,$name='_name',$group=''){
        $aout = array();
        foreach ($data as $items) {
            if(isset($items['name']) && isset($items['group'])){
                if($name==$items['name'] && $group==$items['group']){
                    $item = $items['index'];
                    $values = array();
                    foreach ($data as $value) {
                        if(isset($value['index']) && $item===$value['index']){
                            $values[$value['name']]=$value['value'];
                        }
                    }
                    $aout[$item]=$values;
                }
            }
        }
        return $aout;
    }
    public function searchByNameValue($data,$name='_name',$value='',$group=''){
        $aout = array();
        foreach ($data as $items) {
            if(isset($items['name']) && isset($items['value']) && isset($items['group'])){
                if($name==$items['name'] && $value==$items['value'] && $group==$items['group']){
                    $item = $items['index'];
                    $outval = array();
                    foreach ($data as $values) {
                        if(isset($values['index']) && $item===$values['index']){
                            $values[$value['name']]=$value['value'];
                        }
                    }
                    $aout[$item]=$outval;
                }
            }
        }
        return $aout;
    }

    public function reverseItems($data,$group=''){
        $rout = array();
        foreach ($data as $index => $items) {
            foreach ($items as $key => $value) {
                $rout[] = array('id'=>$key,'index'=>$index,'name'=>key($value),'value'=>$value[key($value)],'group'=>$group);
            }
        }
        return $rout;
    }

    function GetFreeId($tmp,$add,$grp){
        if (!empty($tmp)){
            $tmp += $this->reverseItems($add,$grp);
            sksort($tmp,'id');
            foreach ($tmp as $pos => $val) {
                $i =$pos+1;
                if ($i > $val['id']) {
                    return $i;
                }
            }
            return $i;
        }
    }

    public function array_rotate_delete_id($data,$delete,$control='id'){
        $updatein = array();
        $updateout = $data;
                foreach ($data as $i => $item) {
                    $update=array();
                    if(isset($item[$control])){
                        if($item[$control]==$delete){
                            echo $item[$control]." $i<br>";
                            unset($updateout[$i]);
                        }
                    }
                }
        return $updateout;
    }

    public function array_rotate_delete($data,$delete,$index='index'){
        $updatein = array();
        $updateout = $data;
                foreach ($data as $i => $item) {
                    if(isset($item[$index])){
                        if($item[$index]==$delete){
                            unset($updateout[$i]);
                        }
                    }
                }
        return $updateout;
    }

    public function array_rotate_update($data,$updated,$control='id'){
        $updatein = array();
        $updateout = $data;
        foreach ($updated as $entry) {
            foreach ($entry as $key => $value) {
                if(isset($value[$control])){
                    $updatein[$value[$control]] = $value;
                foreach ($data as $index => $item) {
                    $update=array();
                    if(isset($item[$control])){
                        if($item[$control]===$updatein[$value[$control]][$control]){
                            $update=$updatein[$value[$control]];
                            $updateout[$index] = $update;
                        }
                    }
                }
                }
            }
        }
        return $updateout;
    }
    
    public function array_rotate_key_value($data,$key='name',$val='value',$control='id'){
        $updateout = array();
        foreach ($data as $i => $index) {
            foreach ($index as $keys => $value) {
                if(isset($value[$key]) && isset($value[$val])){
                $updateout[$i][$value[$key]] = $value[$val];
                }
            }
        }
        return $updateout;
    }
    
    public function array_search_rotate($data,$search_value='',$search_name='_name',$_value='value',$_name='name',$index='index',$control='id'){
        $aout = array();
        foreach ($data as $i => $items) {
            if(isset($items[$_name]) && isset($items[$_value])){
                if($search_name==$items[$_name] && $search_value==$items[$_value]){
                    $item = $items[$index];
                    $values = array();
                    foreach ($data as $value) {
                        if(isset($value[$index]) && $item===$value[$index]){
                            if(isset($value[$_name])) $values[$value[$_name]][$_name]=$value[$_name];
                            if(isset($value[$_value])) $values[$value[$_name]][$_value]=$value[$_value];
                            if(isset($value[$index])) $values[$value[$_name]][$index]=$value[$index];
                            if(isset($value[$control])) $values[$value[$_name]][$control]=$value[$control];

                        }
                    }
                    $aout[$item]=$values;
                }
            }
        }
        return $aout;
    }

    public function array_rotate($data,$search_name='_name',$_value='value',$_name='name',$index='index',$control='id'){
        $aout = array();
        foreach ($data as $i => $items) {
            if(isset($items[$_name])){
                if($search_name==$items[$_name]){
                    $item = $items[$index];
                    $values = array();
                    foreach ($data as $value) {
                        if(isset($value[$index]) && $item===$value[$index]){
                            if(isset($value[$_name])) $values[$value[$_name]][$_name]=$value[$_name];
                            if(isset($value[$_value])) $values[$value[$_name]][$_value]=$value[$_value];
                            if(isset($value[$index])) $values[$value[$_name]][$index]=$value[$index];
                            if(isset($value[$control])) $values[$value[$_name]][$control]=$value[$control];

                        }
                    }
                    $aout[$item]=$values;
                }
            }
        }
        return $aout;
    }


}
?>