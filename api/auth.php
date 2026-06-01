<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/helpers.php';

function handleAuth(string $method): void {
    if ($method !== 'POST') {
        jsonResponse(['error' => 'Method Not Allowed'], 405);
    }

    $input = getJsonInput();
    $username = $input['username'] ?? '';
    $password = $input['password'] ?? '';

    // فعلاً یک کاربر ثابت (می‌توان بعداً از دیتابیس خواند)
    if ($username === 'admin' && $password === 'admin123') {
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $db = getDB();
        $stmt = $db->prepare('INSERT INTO api_tokens (token, expires_at) VALUES (:token, :expires_at)');
        $stmt->execute(['token' => $token, 'expires_at' => $expiresAt]);

        jsonResponse(['token' => $token, 'expires_at' => $expiresAt]);
    } else {
        jsonResponse(['error' => 'Invalid credentials'], 401);
    }
}