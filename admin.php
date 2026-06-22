<?php include 'db.php'; ?>
<!-- هێنان و بەشدارکردنی پەڕەی داتابەیس بۆ بەکارهێنان لەم لاپەڕەیەدا -->

<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>
<!-- دیاریکردنی ناونیشانی سەرەکی لاپەڕەکە لە تاب-ی براوسەرەکەدا -->



<style>
/* دەستپێکردنی ستایلی ناوخۆیی (CSS) */
body { font-family: Arial; text-align:center; margin-top:50px; }
/* ڕێکخستنی جۆری فۆنت، هێنانی دەقەکان بۆ ناوەڕاست، و جێهێشتنی مەودا لە سەرەوەی لاپەڕەکە */

input, button { padding:10px; margin:5px; }
/* دیاریکردنی قەبارە (Padding) و دووری (Margin) بۆ خانەکانی نووسین و دوگمەکان */

.card { border:1px solid #ccc; padding:20px; display:inline-block; }
/* دروستکردنی چوارچێوەیەکی خۆڵەمێشی و ڕێکخستنی بۆشایی ناوەوە بۆ کارتە سەرەکییەکە */
</style>
</head>
<body>

<div class="card">
<!-- دروستکردنی کارتێک بۆ کۆکردنەوەی بەشەکانی پانێڵی ئەدمینەکە -->

<h2>Admin Panel</h2>
<!-- سەردێڕی سەرەکی بۆ پانێڵەکە -->

<p>Set USD → IQD Rate</p>
<!-- دەقێکی ڕوونکەرەوە بۆ دیاریکردنی نرخی دۆلار بۆ دینار -->

<input type="number" id="rate" placeholder="e.g. 1540">
<!-- خانەیەک لە جۆری ژمارە بۆ وەرگرتنی نرخە نوێیەکە لە ئەدمینەکە -->

<br>
<!-- دابەزین بۆ دێڕێکی نوێ -->

<button onclick="updateRate()">Update</button>
<!-- دوگمەیەک کە لە کاتی کلیک لێکردنیدا فەنکشنی updateRate دەخاتە کار -->

<p id="msg"></p>
<!-- دەقێکی بەتاڵ بۆ پیشاندانی نامەی سەرکەوتنی پڕۆسەکە دوای گۆڕینی نرخەکە -->
</div>

<script>
// دەستپێکردنی کۆدەکانی جاڤاسکڕێپت (JavaScript)

function updateRate() {
    // دروستکردنی فەنکشنێک بۆ ناردنی نرخە نوێیەکە بەبێ ڕیفرێشکردنی لاپەڕەکە
    
    let rate = document.getElementById('rate').value;
    // وەرگرتنی ئەو بەهایەی (نرخەی) کە ئەدمینەکە لە خانەی نووسینەکەدا نووسیویەتی

    fetch('update_rate.php', {
        // ناردنی داتاکە بۆ فایلی update_rate.php بە شێوازی پشتخلفیی (AJAX)
        
        method: 'POST', // دیاریکردنی شێوازی ناردنەکە بە POST
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}, // ڕێکخستنی جۆری داتا نێردراوەکە
        body: `rate=${rate}` // ناردنی نرخە نوێیەکە لە ناو جەستەی داواکارییەکەدا
    })
    .then(res => res.text()) // وەرگرتنی وەڵامی فایلی PHP کەکە بە شێوازی دەق (Text)
    .then(data => {
        document.getElementById('msg').innerText = "Updated successfully";
        // پیشاندانی نامەی سەرکەوتن لە ناو ئەو پەرەگرافەی (p) کە ئایدییەکەی msg بوو
    });
}
</script>

</body>
</html>