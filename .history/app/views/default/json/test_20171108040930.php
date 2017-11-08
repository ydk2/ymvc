<?php 
$time = $this->newController("/App/Controllers/JSON/Test",$this->model);
header('Cache-Control: no-cache no-store');
echo $time->ViewData('data');
?>