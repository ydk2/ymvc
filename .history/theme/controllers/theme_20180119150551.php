<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
*/
namespace Theme\Controllers;


class Theme extends \Library\Core\Render
{
      
    public function __construct($model=NULL){
        parent::__construct($model);
        $this->ViewData('contents',$model->contents);
        //var_dump($this->view);
        //$this->Show();
    }
}
?>