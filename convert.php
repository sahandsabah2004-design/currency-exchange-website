<?php
header('Content-Type: application/json');

include 'config.php'; 
include 'db.php';     

$amount = $_GET['amount']; 
$from = $_GET['from'];    
$to = $_GET['to'];        

$res = $conn->query("SELECT value FROM settings WHERE name='usd_iqd'");

$row = $res->fetch_assoc();
$kurd_rate = $row['value']; 

$url = "https://v6.exchangerate-api.com/v6/$API_KEY/latest/USD";

$arrContextOptions = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
);

$response = file_get_contents($url, false, stream_context_create($arrContextOptions));

$data = json_decode($response, true);

if ($data && $data['result'] == 'success') {
    
    $rates = $data['conversion_rates']; 

    if ($from == "USD") {
        $usdAmount = $amount; 
    } elseif ($from == "IQD") {
        $usdAmount = $amount / $kurd_rate; 
    } else {
        $usdAmount = $amount / $rates[$from]; 
    }

    if ($to == "USD") {
        $result = $usdAmount; 
    } elseif ($to == "IQD") {
        $result = $usdAmount * $kurd_rate; 
    } else {
        $result = $usdAmount * $rates[$to]; 
    }

    echo json_encode(["result" => round($result, 2)]);
} else {
    echo json_encode(["error" => "API failed"]);
}
?>