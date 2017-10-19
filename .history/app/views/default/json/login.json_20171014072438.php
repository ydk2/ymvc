<?php $login = $this->newController("/App/Controllers/JSON/Login",$this->model);?>
{
    "error": <?=$login->ViewData('error');?>,
    "appid": "<?=$login->ViewData('appid');?>",
    "token": "<?=$login->ViewData('token');?>",
    "scope":<?=$login->ViewData('scope');?>,
    "request":<?=$login->ViewData('request');?>,
    "response":<?=$login->ViewData('response');?>,
    "expires":"<?=$login->ViewData('expires');?>"
}