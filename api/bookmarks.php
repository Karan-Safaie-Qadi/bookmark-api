<?php
function handleBookmarks(string $method): void {
    $db = getDB();
    $id = $_GET['id'] ?? null;

    if ($method === 'GET' && !$id) {
        // لیست همه (بدون شرط جستجو)
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
    elseif ($method === 'DELETE') {
        if (!$id || !is_numeric($id)) {
            jsonResponse(['error' => 'Missing or invalid id parameter'], 400);
        }
        $stmt = $db->prepare('DELETE FROM bookmarks WHERE id = :id');
        $stmt->execute(['id' => (int)$id]);
        if ($stmt->rowCount() === 0) {
            jsonResponse(['error' => 'Bookmark not found'], 404);
        }
        jsonResponse(['message' => 'Bookmark deleted successfully']);
    }
    elseif ($method === 'PUT') {
    if (!$id || !is_numeric($id)) {
        jsonResponse(['error' => 'Missing or invalid id parameter'], 400);
    }
    $input = getJsonInput();
    $url = $input['url'] ?? null;
    $title = $input['title'] ?? null;

    $fields = [];
    $params = ['id' => (int)$id];

    if ($url !== null) {
        if (!validateUrl($url)) {
            jsonResponse(['error' => 'Invalid URL'], 400);
        }
        $fields[] = 'url = :url';
        $params['url'] = $url;
    }
    if ($title !== null) {
        $title = trim($title);
        $fields[] = 'title = :title';
        $params['title'] = $title;
    }
    if (empty($fields)) {
        jsonResponse(['error' => 'No fields to update'], 400);
    }

    $stmt = $db->prepare('UPDATE bookmarks SET ' . implode(', ', $fields) . ' WHERE id = :id');
    $stmt->execute($params);
    if ($stmt->rowCount() === 0) {
        jsonResponse(['error' => 'Bookmark not found or no changes'], 404);
    }
    $updated = $db->prepare('SELECT * FROM bookmarks WHERE id = ?');
    $updated->execute([(int)$id]);
    jsonResponse($updated->fetch());
}
    else {
        jsonResponse(['error' => 'Method Not Allowed'], 405);
    }
}