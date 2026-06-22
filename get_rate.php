<?php
include 'db.php';


$res = $conn->query("SELECT value FROM settings WHERE name='usd_iqd'");


$row = $res->fetch_assoc();


echo json_encode(["rate" => $row['value']]);


?>