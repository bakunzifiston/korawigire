<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');          // restrict to your domain in production
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

define('DB_HOST', 'localhost');
define('DB_NAME', 'korawigire_db');   // database name
define('DB_USER', 'root');             // db username
define('DB_PASS', '');                 // db password
define('DB_CHARSET', 'utf8mb4');

function getDB(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
    return $pdo;
}


function success($data, int $code = 200): void {
    http_response_code($code);
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

function error(string $message, int $code = 400): void {
    http_response_code($code);
    echo json_encode(['success' => false, 'message' => $message]);
    exit;
}


try {
    $method = $_SERVER['REQUEST_METHOD'];
    $id     = isset($_GET['id']) ? (int) $_GET['id'] : null;

    match ($method) {
        'GET'    => $id ? getAd($id) : listAds(),
        'POST'   => createAd(),
        'PUT'    => updateAd(),
        'DELETE' => deleteAd($id),
        default  => error('Method not allowed.', 405),
    };
} catch (PDOException $e) {
    error('Database error: ' . $e->getMessage(), 500);
} catch (Throwable $e) {
    error('Server error: ' . $e->getMessage(), 500);
}


function listAds(): void {
    $db     = getDB();
    $where  = ['1=1'];
    $params = [];

    if (!empty($_GET['status'])) {
        $where[]           = 'status = :status';
        $params[':status'] = $_GET['status'];
    }

    if (!empty($_GET['category'])) {
        $where[]             = 'category = :category';
        $params[':category'] = $_GET['category'];
    }

    if (isset($_GET['featured'])) {
        $where[]              = 'is_featured = :featured';
        $params[':featured']  = (int) $_GET['featured'];
    }

    if (!empty($_GET['search'])) {
        $where[]            = '(title LIKE :search OR description LIKE :search2)';
        $params[':search']  = '%' . $_GET['search'] . '%';
        $params[':search2'] = '%' . $_GET['search'] . '%';
    }


    if (!empty($_GET['public'])) {
        $where[] = "status = 'active'";
        $where[] = "(end_date IS NULL OR end_date >= CURDATE())";
    }

    $sql  = 'SELECT * FROM advertisements WHERE ' . implode(' AND ', $where) . ' ORDER BY is_featured DESC, created_at DESC';
    $stmt = $db->prepare($sql);
    $stmt->execute($params);

    success($stmt->fetchAll());
}


function getAd(int $id): void {
    $db   = getDB();
    $stmt = $db->prepare('SELECT * FROM advertisements WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $ad   = $stmt->fetch();
    if (!$ad) error('Advertisement not found.', 404);
    success($ad);
}

function createAd(): void {
    $body = json_decode(file_get_contents('php://input'), true);
    if (!$body) error('Invalid JSON body.');

    // Required fields
    if (empty($body['title']))    error('Title is required.');
    if (empty($body['category'])) error('Category is required.');

    $db   = getDB();
    $stmt = $db->prepare("
        INSERT INTO advertisements
            (title, description, category, status, cta_type, cta_link,
             start_date, end_date, is_featured, image_url,
             price, bedrooms, location, created_at, updated_at)
        VALUES
            (:title, :description, :category, :status, :cta_type, :cta_link,
             :start_date, :end_date, :is_featured, :image_url,
             :price, :bedrooms, :location, NOW(), NOW())
    ");

    $stmt->execute([
        ':title'       => sanitize($body['title']),
        ':description' => sanitize($body['description'] ?? ''),
        ':category'    => sanitize($body['category']),
        ':status'      => in_array($body['status'] ?? '', ['draft','active','archived']) ? $body['status'] : 'draft',
        ':cta_type'    => sanitize($body['cta_type'] ?? 'call'),
        ':cta_link'    => sanitize($body['cta_link'] ?? ''),
        ':start_date'  => !empty($body['start_date']) ? $body['start_date'] : null,
        ':end_date'    => !empty($body['end_date'])   ? $body['end_date']   : null,
        ':is_featured' => (int) ($body['is_featured'] ?? 0),
        ':image_url'   => sanitize($body['image_url'] ?? ''),
        ':price'       => sanitize($body['price']     ?? ''),
        ':bedrooms'    => !empty($body['bedrooms']) ? (int) $body['bedrooms'] : null,
        ':location'    => sanitize($body['location']  ?? ''),
    ]);

    success(['id' => (int) $db->lastInsertId(), 'message' => 'Advertisement created.'], 201);
}

function updateAd(): void {
    $body = json_decode(file_get_contents('php://input'), true);
    if (!$body)            error('Invalid JSON body.');
    if (empty($body['id'])) error('ID is required for update.');

    $db   = getDB();
    $stmt = $db->prepare("
        UPDATE advertisements SET
            title       = :title,
            description = :description,
            category    = :category,
            status      = :status,
            cta_type    = :cta_type,
            cta_link    = :cta_link,
            start_date  = :start_date,
            end_date    = :end_date,
            is_featured = :is_featured,
            image_url   = :image_url,
            price       = :price,
            bedrooms    = :bedrooms,
            location    = :location,
            updated_at  = NOW()
        WHERE id = :id
    ");

    $stmt->execute([
        ':id'          => (int) $body['id'],
        ':title'       => sanitize($body['title']       ?? ''),
        ':description' => sanitize($body['description'] ?? ''),
        ':category'    => sanitize($body['category']    ?? ''),
        ':status'      => in_array($body['status'] ?? '', ['draft','active','expired','archived']) ? $body['status'] : 'draft',
        ':cta_type'    => sanitize($body['cta_type']    ?? 'call'),
        ':cta_link'    => sanitize($body['cta_link']    ?? ''),
        ':start_date'  => !empty($body['start_date'])   ? $body['start_date'] : null,
        ':end_date'    => !empty($body['end_date'])     ? $body['end_date']   : null,
        ':is_featured' => (int) ($body['is_featured']   ?? 0),
        ':image_url'   => sanitize($body['image_url']   ?? ''),
        ':price'       => sanitize($body['price']       ?? ''),
        ':bedrooms'    => !empty($body['bedrooms'])     ? (int) $body['bedrooms'] : null,
        ':location'    => sanitize($body['location']    ?? ''),
    ]);

    if ($stmt->rowCount() === 0) error('Advertisement not found or no changes made.', 404);
    success(['message' => 'Advertisement updated.']);
}


function deleteAd(?int $id): void {
    if (!$id) error('ID is required.');
    $db   = getDB();
    $stmt = $db->prepare('DELETE FROM advertisements WHERE id = :id');
    $stmt->execute([':id' => $id]);
    if ($stmt->rowCount() === 0) error('Advertisement not found.', 404);
    success(['message' => 'Advertisement deleted.']);
}


function sanitize(mixed $value): string {
    return htmlspecialchars(strip_tags((string) $value), ENT_QUOTES, 'UTF-8');
}