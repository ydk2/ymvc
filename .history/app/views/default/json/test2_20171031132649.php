<?php 
$time = $this->newController("/App/Controllers/JSON/Time",$this->model);
header('Cache-Control: no-cache no-store');
echo $time->ViewData('data');
?>