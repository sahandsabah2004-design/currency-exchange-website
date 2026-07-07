<?php
// دەستپێکردنی سێشن
session_start();

include 'db.php';

// ١. پاراستنی پەڕەکە (بۆ کاتی چاوپێکەوتن بە کاتی کۆمێنت کراوە بۆ ئەوەی ڕاستەوخۆ کار بکات)
/*
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('HTTP/1.1 403 Forbidden');
    die("Error: تۆ مۆڵەتی ئەنجامدانی ئەم کارەت نییە.");
}
*/

// پشکنینی ئەوەی ئایا داواکارییەکە بە شێوازی POST هاتووە
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // ٢. پشکنین و پاککردنەوەی داتا (Validation & Sanitization)
    $newRate = isset($_POST['rate']) ? filter_var($_POST['rate'], FILTER_VALIDATE_FLOAT) : null;

    if ($newRate === false || $newRate === null || $newRate <= 0) {
        die("Error: تکایە نرخێکی دروست و ئەرێنی بنووسە.");
    }

    // ٣. بەکارهێنانی Prepared Statements بۆ ڕێگری ڕەها لە هێرشی SQL Injection
    $stmt = $conn->prepare("UPDATE settings SET value = ? WHERE name = 'usd_iqd'");
    
    if ($stmt) {
        // بەستنەوەی گۆڕاوەکە بە نیشانەی پرسیارەکەوە (d وەک کورتکراوەی double/float)
        $stmt->bind_param("d", $newRate);
        
        // جێبەجێکردنی فەرمانەکە
        if ($stmt->execute()) {
            echo "Success: نرخی دۆلار بە سەرکەوتوویی نوێکرایەوە.";
        } else {
            echo "Error: کێشەیەک لە نوێکردنەوەی داتاکاندا ڕوویدا.";
        }
        
        // داخستنی فەرمانەکە
        $stmt->close();
    } else {
        echo "Error: کێشەی تەکنیکی لە سێرڤەردا هەیە.";
    }
} else {
    echo "Error: شێوازی ناردنی داتا دروست نییە.";
}
?>
