<?php 
/*
$time = $this->newController("/App/Controllers/JSON/Time",$this->model);
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$lastEventId = floatval(isset($_SERVER["HTTP_LAST_EVENT_ID"]) ? $_SERVER["HTTP_LAST_EVENT_ID"] : 0);
if ($lastEventId == 0) {
  $lastEventId = floatval(isset($_GET["lastEventId"]) ? $_GET["lastEventId"] : 0);
}
echo "id:".$lastEventId."\n";
echo "event: ".$time->ViewData('event')."\n";
echo "data: ".$time->ViewData('data')."\n";
echo "\n";
flush();
*/
date_default_timezone_set("America/New_York");
header('Cache-Control: no-cache');
header("Content-Type: text/event-stream\n\n");

  // Every second, send a "ping" event.
  
  echo "event: message\n";
  $curDate = date(DATE_ISO8601);
  echo 'data: {"time": "' . $curDate . '"}';
  echo "\n\n";
  
  // Send a simple message at random intervals.

  
  ob_end_flush();
  flush();
?>