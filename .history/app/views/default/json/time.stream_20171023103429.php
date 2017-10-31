<?php 

$time = $this->newController("/App/Controllers/JSON/Time",$this->model);
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

echo "retry: 2000\n";
echo "event: ".$time->ViewData('event')."\n";
echo "data: ".$time->ViewData('data')."\n";
echo "\n";
ob_end_flush();
flush();
?>