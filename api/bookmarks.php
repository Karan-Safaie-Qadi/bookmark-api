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
        // کد POST مشابه روز دوم ...
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
    else {
        jsonResponse(['error' => 'Method Not Allowed'], 405);
    }
}