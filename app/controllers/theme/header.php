<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
*/
namespace App\Controllers\Theme;

use \Library\Core\Intl;

class Header extends \Library\Core\Controller
{
      
    public function __construct($model=NULL){
        parent::__construct($model);
        $this->ViewData('host',HOST);
        $this->ViewData('title','Ymvc System');
        $this->ViewData('lang','pl');
        $translations = array();
    }
}
?>