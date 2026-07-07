<?php
header('Content-Type: application/json');

include 'config.php'; 
include 'db.php';     

// ١. پشکنین و ناچارکردنی داتا بەوەی کە تەنها ژمارە و دەق بن (Data Validation & Sanitization)
$amount = isset($_GET['amount']) ? filter_var($_GET['amount'], FILTER_VALIDATE_FLOAT) : 0;
$from   = isset($_GET['from'])   ? htmlspecialchars(strtoupper(trim($_GET['from']))) : '';
$to     = isset($_GET['to'])     ? htmlspecialchars(strtoupper(trim($_GET['to']))) : '';

if ($amount === false || $amount <= 0 || empty($from) || empty($to)) {
    echo json_encode(["error" => "تکایە بڕ و جۆری دراوەکان بە دروستی دیاری بکە."]);
    exit;
}

// ٢. هێنانی نرخی بازاڕی کوردستان لە داتابەیس
$res = $conn->query("SELECT value FROM settings WHERE name='usd_iqd'");
$row = $res->fetch_assoc();
$kurd_rate = $row ? floatval($row['value']) : 1500; // ئەگەر داتابەیس بەتاڵ بوو، نرخێکی گریمانەیی دادەنێین

// ٣. باشترکردنی داواکاری API بە شێوازی cURL (لەجیاتی file_get_contents چونکە خێراتر و پارێزراوە)
$url = "https://v6.exchangerate-api.com/v6/{$API_KEY}/latest/USD";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5); // ئەگەر سێرڤەرەکە وەڵامی نەبوو لە ٥ چرکەدا دابخرێت بۆ ئەوەی سایتی خۆمان خاو نەبێتەوە
// تێبینی: لێرەدا SSL ناکوژێنینەوە چونکە سێرڤەری ڕاستەقینە بڕوانامەی هەیە.

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if ($data && $data['result'] == 'success') {
    $rates = $data['conversion_rates']; 

    // پشکنینی ئەوەی ئایا دراوە داواکراوەکان لە ناو API هەن یان نا
    if (( $from !== 'USD' && $from !== 'IQD' && !isset($rates[$from]) ) || 
        ( $to !== 'USD' && $to !== 'IQD' && !isset($rates[$to]) )) {
        echo json_encode(["error" => "دراوی داواکراو پشتگیری نەکراوە."]);
        exit;
    }

    // لۆژیکی گۆڕینەوە بۆ USD
    if ($from == "USD") {
        $usdAmount = $amount; 
    } elseif ($from == "IQD") {
        $usdAmount = $amount / $kurd_rate; 
    } else {
        $usdAmount = $amount / $rates[$from]; 
    }

    // لۆژیکی گۆڕینەوە لە USD بۆ دراوی مەبەست
    if ($to == "USD") {
        $result = $usdAmount; 
    } elseif ($to == "IQD") {
        $result = $usdAmount * $kurd_rate; 
    } else {
        $result = $usdAmount * $rates[$to]; 
    }

    echo json_encode(["result" => round($result, 2)]);
} else {
    echo json_encode(["error" => "سیستەمی جیهانی وەڵام ناداتەوە، تکایە دواتر هەوڵ بدەرەوە."]);
}
?>
