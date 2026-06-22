<?php
include 'db.php';


$newRate = $_POST['rate'];


$conn->query("UPDATE settings SET value='$newRate' WHERE name='usd_iqd'");


echo "Updated";


?>