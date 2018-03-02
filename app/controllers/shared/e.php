<?php
/*
* @Author: ydk2 (me@ydk2.tk)
* @Date: 2017-01-21 16:22:09
 * @Last Modified by: ydk2 (me@ydk2.tk)
 * @Last Modified time: 2017-01-21 22:00:35
*/
namespace App\Controllers\Shared;

use Library\Core\Render;

class E extends Render
{   
    public function __construct($model){
        parent::__construct($model);
        $this->ViewData('appid',$model->appid);
        $this->ViewData('error',$model->error);
        $this->ViewData('request',$model->request);
        $this->ViewData('scope',$model->scope);
        $this->ViewData('token',$model->token);
        $this->ViewData('response',$model->response);
        $this->ViewData('host',HOST);
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime(__FILE__)).' GMT', true, $model->error);
    }
}
?>