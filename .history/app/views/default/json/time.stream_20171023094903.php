<?php 

$time = $this->newController("/App/Controllers/JSON/Time",$this->model);
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header("Access-Control-Allow-Origin: *");
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

echo "retry: 1000\n";
echo "event: ".$time->ViewData('event')."\n";
echo "data: ".$time->ViewData('data')."\n";
echo "\n";
ob_flush();
flush();

?>