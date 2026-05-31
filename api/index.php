<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/helpers.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

// مسیر API ما: /api/bookmarks
if ($requestUri === '/api/bookmarks' || $requestUri === '/api/bookmarks/') {
    require_once __DIR__ . '/bookmarks.php';
    handleBookmarks($requestMethod);
} else {
    jsonResponse(['error' => 'Not Found'], 404);
}