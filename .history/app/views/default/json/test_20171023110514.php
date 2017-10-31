<?php 

//$time = $this->newController("/App/Controllers/JSON/Time",$this->model);
header('Cache-Control: no-cache');


$request_headers = getallheaders();
echo json_encode($request_headers);
?>