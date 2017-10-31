<?php 

$time = $this->newController("/App/Controllers/JSON/Time",$this->model);
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

//while (1) {
    echo "retry: 2000\n";
    echo "event: ".$time->ViewData('event')."\n";
    echo "data: ".$time->ViewData('data')."\n";
    echo "\n";
    sleep(1);
    ob_end_flush();
    flush();
//}
?>