<?php 
$time = $this->Controller("/App/Controllers/JSON/Time",$this->model);
header('Cache-Control: no-cache');
?>
{
    "error":<?=$main->ViewData('error');?>,
    "appid":"<?=$main->ViewData('appid');?>",
    "access_token":"<?=$main->ViewData('access_token');?>",
    "scope":<?=$main->ViewData('scope');?>,
    "request":<?=$main->ViewData('request');?>,
    "response":<?=$main->ViewData('response');?>,
    "expires":"<?=$main->ViewData('expires');?>"
}