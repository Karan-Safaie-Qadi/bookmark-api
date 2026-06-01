<?php
// public/router.php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// اگر درخواست به api/ است، به api/index.php هدایت کن
if (strpos($uri, '/api/') === 0) {
    require __DIR__ . '/../api/index.php';
    return;
}

// در غیر این صورت، فایل استاتیک را برگردان (پیش‌فرض خود PHP)
return false;