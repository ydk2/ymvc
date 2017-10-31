<?php 
$time = $this->newController("/App/Controllers/JSON/Test2",$this->model);
header('Cache-Control: no-cache no-store');
echo $time->ViewData('data');
?>