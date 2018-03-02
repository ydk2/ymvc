<?php
/**
 * Created on Thu Mar 01 2018
 *
 * YMVC framework License
 * Copyright (c) 1996 - 2018 ydk2 All rights reserved.
 * 
 * YMVC version 3 fast and simple to use 
 * PHP MVC framework for PHP 5.4 + with PHP and XSLT files 
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * Redistribution and use of this software in source and binary forms, with or without modification,
 * are permitted provided that the following condition is met:
 * Redistributions of source code must retain the above copyright notice, 
 * this list of conditions and the following disclaimer.
 *   
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, 
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, 
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, 
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * For more information on the YMVC project, 
 * please see <http://ydk2.tk>. 
 *   
 **/

require_once "bootstrap.php";
require_once (ROOT . DS . 'config.php');


\Library\Core\Session::Start();

$theme = "default";
$default = 'main';

$app='/app/views/'.$theme;

$data = new \Library\Core\Data;
$data->theme = $theme;

$model = new \App\Models\Model($data);
$model->theme = $theme;

$render = new \Library\Core\Render($model);
$render->ext = '.php';

$body = new \Library\Core\Render($model);
$body->ext = '.php';


$body->Show($app."/theme/header");

$index = $render->Route($app,'view',$default);
if($render->is($index)){
    echo $index;
} else {
    $render->model->header = '404 Not found';
    $render->model->response = 'View cannot be found';
    $render->model->code = '404';
    $error = $render->View($app. '/shared/e');
    echo $error;
}

$body->Show($app."/theme/footer");


?>