<?php $login = $this->newController("/App/Controllers/JSON/Register",$this->model);?>
{
    "error": <?=$login->ViewData('error');?>,
    "appid": "<?=$login->ViewData('appid');?>",
    "access_token": "<?=$login->ViewData('access_token');?>",
    "scope":<?=$login->ViewData('scope');?>,
    "request":<?=$login->ViewData('request');?>,
    "response":<?=$login->ViewData('response');?>,
    "expires":"<?=$login->ViewData('expires');?>"
}