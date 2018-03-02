<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
*/
namespace App\Controllers\Theme;


class Footer extends \library\Core\Controller
{      
    public function __construct($model=NULL){
        parent::__construct($model);
        $this->viewdata('header','Sample app');
        $this->viewdata('github','https://github.com/ydk2');
        $this->viewdata('link','https://ydk2.tk');
        $this->viewdata('powered','ymvc framework');
        $this->viewdata('author','ydk2');
    }
}
?>