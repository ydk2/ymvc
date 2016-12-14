<?php 
$dsn = "sqlsrv:Server=localhost,1433;Database=ymvc;ConnectionPooling=0";
$conn = new PDO($dsn, "ydk2", "8738");
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

$sql = "SELECT * FROM Table";

foreach ($conn->query($sql) as $row) {
    print_r($row);
} 
?>