<?php 

$time = $this->Controller("/App/Controllers/JSON/Time",$this->model);
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$lastEventId = floatval(isset($_SERVER["HTTP_LAST_EVENT_ID"]) ? $_SERVER["HTTP_LAST_EVENT_ID"] : 0);
if ($lastEventId == 0) {
  $lastEventId = floatval(isset($_GET["lastEventId"]) ? $_GET["lastEventId"] : 0);
}
echo "id:".$lastEventId."\n";
echo "retry: 2000\n";
echo "event: ".$time->ViewData('event')."\n";
echo "data: ".$time->ViewData('data')."\n";
echo "\n";
ob_end_flush();
flush();
?>