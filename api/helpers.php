<?php
function jsonResponse($data, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function getJsonInput(): array {
    $input = json_decode(file_get_contents('php://input'), true);
    return is_array($input) ? $input : [];
}

function validateUrl(string $url): bool {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}
function authenticate(): void {
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!preg_match('/^Bearer\s+(.+)$/i', $authHeader, $matches)) {
        jsonResponse(['error' => 'Authorization token required'], 401);
    }

    $token = $matches[1];
    $db = getDB();
    $stmt = $db->prepare('SELECT id, expires_at FROM api_tokens WHERE token = :token');
    $stmt->execute(['token' => $token]);
    $row = $stmt->fetch();

    if (!$row || strtotime($row['expires_at']) < time()) {
        jsonResponse(['error' => 'Invalid or expired token'], 401);
    }
}