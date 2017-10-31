<?php 
$time = $this->newController("/App/Controllers/JSON/Time",$this->model);
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
/*
try {
    $user = 'truckdri_root';
    $pass = 'Vp42y44qLo';
    $dbh = new PDO('mysql:host=localhost;dbname=truckdri_mapsec', $user, $pass);
    foreach($dbh->query('SELECT id,account_name,account_login,account_role,account_email FROM accounts  LIMIT 5 OFFSET 0;') as $row) {
        var_dump($row);
    }
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    
}
*/
//echo sha1("1AdmIn0Oaz");
//$to_time = strtotime("2008-12-13 10:42:00");
//$from_time = strtotime("2008-12-13 10:21:00");
//echo round(abs($to_time - $from_time) / 60,2). " minute";

$lastEventId = floatval(isset($_SERVER["HTTP_LAST_EVENT_ID"]) ? $_SERVER["HTTP_LAST_EVENT_ID"] : 0);
if ($lastEventId == 0) {
  $lastEventId = floatval(isset($_GET["lastEventId"]) ? $_GET["lastEventId"] : 0);
}
echo "id:".$lastEventId."\n";
echo "event: ".$time->ViewData('event')."\n";
echo "data: ".$time->ViewData('data')."\n";
echo "\n";
flush();
?>