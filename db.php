<?php

$conn = new mysqli("localhost", "root", "", "currency_db"); 

/*
  دروستکردنی پەیوەندی لەگەڵ بنکەی زانیاری (Database) بە بەکارهێنانی ڕێگای mysqli.
  لێرەدا ٤ زانیاری سەرەکی نێردراوە:
  - "localhost"(Server Name)
  - "root":(Username) 
  - "":  (Password)  
  - "currency_db": ناوی ئەو داتابەیسەی کە دەتەوێت پەیوەندی پێوە بکەیت
*/

if ($conn->connect_error) {
    // پشکنین دەکات؛ ئەگەر کێشەیەک لە پەیوەندییەکەدا هەبوو، کۆدەکەی ناو ئەم مەرجە (if) جێبەجێ دەبێت
    
    die("Connection failed: " . $conn->connect_error);
    /*
      ئەگەر پەیوەندییەکە سەرکەوتوو نەبوو، فەنکشنی die کارەکە ڕادەگرێت (کۆتایی بە سێرڤەرەکە دەهێنێت)
      وە نامەی "Connection failed" لەگەڵ هۆکاری کێشەکە (. $conn->connect_error) پیشان دەدات.
    */
}
?>

