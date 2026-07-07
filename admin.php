<?php 
// ١. دەستپێکردنی سێشن
session_start(); 

include 'db.php'; 

// ٢. پاراستنی لاپەڕەکە (بۆ کاتی چاوپێکەوتن بە کاتی کۆمێنت کراوە بۆ ئەوەی ڕاستەوخۆ بکرێتەوە)
/*
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("<h2 style='text-align:center; margin-top:50px; color:red;'>تۆ مۆڵەتی بینینی ئەم لاپەڕەیەت نییە. تکایە سەرەتا داخڵ ببە.</h2>");
}
*/

// ٣. هێنانی نرخی ئێستای ناو داتابەیس بۆ ئەوەی نیشانی ئەدمینی بدەین
$current_rate = "—";
$res = $conn->query("SELECT value FROM settings WHERE name='usd_iqd'");
if ($res && $row = $res->fetch_assoc()) {
    $current_rate = number_format($row['value']);
}
?>

<!DOCTYPE html>
<html lang="ku" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel - ستافی بەڕێوەبردن</title>

<style>
body { font-family: Arial, sans-serif; text-align:center; margin-top:50px; background-color: #f5f5f5; color: #1a1a2e; }
input, button { padding:10px; margin:5px; border-radius: 5px; border: 1px solid #ccc; font-size: 14px; }
button { background-color: #185FA5; color: white; cursor: pointer; font-weight: bold; border: none; }
button:hover { background-color: #134d87; }
.card { border:1px solid #ccc; padding:35px; display:inline-block; background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 400px; width: 100%; }
#msg { font-weight: bold; margin-top: 15px; }
.success { color: green; }
.error { color: red; }
.current-rate-box { background: #e6f2ff; padding: 10px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; color: #185FA5; }
</style>
</head>
<body>

<div class="card">
<h2>Admin Panel</h2>
<p style="color: #666; margin-bottom: 15px;">دیاریکردنی نرخی دۆلار بەرامبەر دینار</p>

<!-- نیشاندانی نرخی ئێستای ناو داتابەیس -->
<div class="current-rate-box">
    نرخی ئێستا لە داتابەیس: <span id="currentRate"><?php echo $current_rate; ?></span> دینار
</div>

<input type="number" id="rate" placeholder="بۆ نموونە: 1540" step="any">
<br>
<button onclick="updateRate()">نوێکردنەوەی نرخ</button>
<p id="msg"></p>
</div>

<script>
function updateRate() {
    let rateInput = document.getElementById('rate');
    let rate = rateInput.value;
    let msgEl = document.getElementById('msg');
    let currentRateEl = document.getElementById('currentRate');

    if(!rate || rate <= 0) {
        msgEl.className = "error";
        msgEl.innerText = "تکایە نرخێکی دروست بنووسە.";
        return;
    }

    msgEl.className = "";
    msgEl.innerText = "چاوەڕوان بە...";

    fetch('update_rate.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `rate=${encodeURIComponent(rate)}`
    })
    .then(res => res.text())
    .then(data => {
        if(data.includes("Success")) {
            msgEl.className = "success";
            msgEl.innerText = "نرخی دۆلار بە سەرکەوتوویی نوێکرایەوە.";
            
            // نوێکردنەوەی نرخی سەر شاشەکە بە شێوازی داینامیکی دوای سەرکەوتن
            currentRateEl.innerText = Number(rate).toLocaleString();
            rateInput.value = ""; 
        } else {
            msgEl.className = "error";
            msgEl.innerText = data; 
        }
    })
    .catch(err => {
        msgEl.className = "error";
        msgEl.innerText = "کێشەیەک لە پەیوەندی سێرڤەردا هەیە.";
    });
}
</script>

</body>
</html>
