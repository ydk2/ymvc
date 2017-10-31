<?php $main = new \App\Controllers\JSON\Main($this->model);?>
{
    "error":<?=$main->ViewData('error');?>,
    "appid":"<?=$main->ViewData('appid');?>",
    "token":"<?=$main->ViewData('token');?>",
    "access_token":"<?=$main->ViewData('access_token');?>",
    "scope":<?=$main->ViewData('scope');?>,
    "request":<?=$main->ViewData('request');?>,
    "response":<?=$main->ViewData('response');?>,
    "expires":"<?=$main->ViewData('expires');?>"
}