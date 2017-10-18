<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
*/
namespace test\controllers\test;

use \library\core as Core;

class Test extends Core\Render {
    
    public $array;
    public $disabled;
    public $enabled;
    public $layouts;
    public $layout_group;
    public $mode;

    public static function Config() {
        return array(
        'title'=>'Empty title',
        'access_groups'=>array(),
        'view'=>"",
        'access_mode'=>0,
        'model'=>NULL
        );
    }
    
    public function __construct(){
        parent::__construct();
        //$this->data = new \Data;
        echo 'chuj';
    }
    
    public function Run(){
        $this->ViewData('testing', 'ddd');

    }
}
?>