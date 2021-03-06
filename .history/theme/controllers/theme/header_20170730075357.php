<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
*/
namespace Theme\Controllers\Theme;


class Header extends \library\Core\Render
{
    public $theme;   
    public function __construct($theme=NULL){
        parent::__construct();
        if($theme!=NULL && $theme!=""){
            $this->view = $this->view.DIRECTORY_SEPARATOR.$theme;
        }
        $this->Run();
    }
}
?>