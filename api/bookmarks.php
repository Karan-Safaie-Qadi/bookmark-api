<?php
function handleBookmarks(string $method): void {
    $db = getDB();
    
    if ($method === 'GET') {
        $stmt = $db->query('SELECT id, url, title, created_at, updated_at FROM bookmarks ORDER BY created_at DESC');
        $bookmarks = $stmt->fetchAll();
        jsonResponse($bookmarks);
    } else {
        jsonResponse(['error' => 'Method Not Allowed'], 405);
    }
}