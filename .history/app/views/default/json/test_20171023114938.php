<?php 
$time = $this->Controller("/App/Controllers/JSON/Time",$this->model);
header('Cache-Control: no-cache');
?>
{
    "event":"<?=$time->ViewData('event')?>",
    "data":<?=$time->ViewData('data')?>
}