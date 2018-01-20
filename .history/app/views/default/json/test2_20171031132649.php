<?php 
$time = $this->Controller("/App/Controllers/JSON/Time",$this->model);
header('Cache-Control: no-cache no-store');
echo $time->ViewData('data');
?>