<?php $e = new \App\Controllers\Shared\E($this->model);?> 
{
    "error": <?=$e->ViewData('error');?>,
    "appid": "<?=$e->ViewData('appid');?>",
    "token": "<?=$e->ViewData('token');?>",
    "scope": "<?=$e->ViewData('scope');?>",
    "request": "<?=$e->ViewData('request');?>",
    "response": "<?=$e->ViewData('response');?>"
}