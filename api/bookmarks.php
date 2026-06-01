<?php
function handleBookmarks(string $method): void {
    $db = getDB();

    if ($method === 'GET') {
        $stmt = $db->query('SELECT id, url, title, created_at, updated_at FROM bookmarks ORDER BY created_at DESC');
        $bookmarks = $stmt->fetchAll();
        jsonResponse($bookmarks);
    }
    elseif ($method === 'POST') {
        $input = getJsonInput();
        $url = $input['url'] ?? '';
        $title = $input['title'] ?? '';

        // اعتبارسنجی
        if (!validateUrl($url)) {
            jsonResponse(['error' => 'Invalid URL'], 400);
        }
        $title = trim($title) ?: parse_url($url, PHP_URL_HOST); // اگر عنوان خالی بود، نام دامنه را بگذار

        $stmt = $db->prepare('INSERT INTO bookmarks (url, title) VALUES (:url, :title)');
        $stmt->execute(['url' => $url, 'title' => $title]);

        $id = $db->lastInsertId();
        $newBookmark = $db->prepare('SELECT * FROM bookmarks WHERE id = ?');
        $newBookmark->execute([$id]);

        jsonResponse($newBookmark->fetch(), 201);
    }
    else {
        jsonResponse(['error' => 'Method Not Allowed'], 405);
    }
}