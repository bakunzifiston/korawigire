<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

define('DB_HOST',    'localhost');
define('DB_NAME',    'korawigire_db');
define('DB_USER',    'root');
define('DB_PASS',    '');
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
        'GET'    => $id ? getCategory($id) : listCategories(),
        'POST'   => createCategory(),
        'PUT'    => updateCategory(),
        'DELETE' => deleteCategory($id),
        default  => error('Method not allowed.', 405),
    };
} catch (PDOException $e) {
    error('Database error: ' . $e->getMessage(), 500);
} catch (Throwable $e) {
    error('Server error: ' . $e->getMessage(), 500);
}


function listCategories(): void {
    $db   = getDB();
  
    $stmt = $db->query("
        SELECT
            c.*,
            COUNT(a.id) AS ad_count
        FROM ad_categories c
        LEFT JOIN advertisements a
            ON a.category = c.slug AND a.status = 'active'
        GROUP BY c.id
        ORDER BY c.sort_order ASC, c.name ASC
    ");
    success($stmt->fetchAll());
}


function getCategory(int $id): void {
    $db   = getDB();
    $stmt = $db->prepare('SELECT * FROM ad_categories WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $cat  = $stmt->fetch();
    if (!$cat) error('Category not found.', 404);
    success($cat);
}


function createCategory(): void {
    $body = json_decode(file_get_contents('php://input'), true);
    if (!$body)            error('Invalid JSON body.');
    if (empty($body['name'])) error('Category name is required.');
    if (empty($body['slug'])) error('Slug is required.');

    $db = getDB();

    // Check slug is unique
    $check = $db->prepare('SELECT id FROM ad_categories WHERE slug = :slug');
    $check->execute([':slug' => $body['slug']]);
    if ($check->fetch()) error('A category with this slug already exists.');

    $stmt = $db->prepare("
        INSERT INTO ad_categories (name, slug, icon, description, is_builtin, is_enabled, sort_order, created_at)
        VALUES (:name, :slug, :icon, :description, 0, 1, :sort_order, NOW())
    ");


    $maxOrder = $db->query('SELECT MAX(sort_order) FROM ad_categories')->fetchColumn();

    $stmt->execute([
        ':name'        => sanitize($body['name']),
        ':slug'        => sanitize($body['slug']),
        ':icon'        => sanitize($body['icon'] ?? 'bi-tag'),
        ':description' => sanitize($body['description'] ?? ''),
        ':sort_order'  => ((int) $maxOrder) + 1,
    ]);

    success(['id' => (int) $db->lastInsertId(), 'message' => 'Category created.'], 201);
}


function updateCategory(): void {
    $body = json_decode(file_get_contents('php://input'), true);
    if (!$body)             error('Invalid JSON body.');
    if (empty($body['id'])) error('ID is required.');

    $db   = getDB();
    $stmt = $db->prepare("
        UPDATE ad_categories SET
            name        = :name,
            icon        = :icon,
            description = :description,
            is_enabled  = :is_enabled
        WHERE id = :id
    ");
   

    $stmt->execute([
        ':id'          => (int) $body['id'],
        ':name'        => sanitize($body['name']        ?? ''),
        ':icon'        => sanitize($body['icon']        ?? 'bi-tag'),
        ':description' => sanitize($body['description'] ?? ''),
        ':is_enabled'  => (int) ($body['is_enabled']    ?? 1),
    ]);

    if ($stmt->rowCount() === 0) error('Category not found or no changes made.', 404);
    success(['message' => 'Category updated.']);
}


function deleteCategory(?int $id): void {
    if (!$id) error('ID is required.');

    $db = getDB();


    $check = $db->prepare('SELECT is_builtin FROM ad_categories WHERE id = :id');
    $check->execute([':id' => $id]);
    $cat = $check->fetch();
    if (!$cat)               error('Category not found.', 404);
    if ((int)$cat['is_builtin']) error('Built-in categories cannot be deleted.', 403);


    $db->prepare("UPDATE advertisements SET category = 'other' WHERE category = (SELECT slug FROM ad_categories WHERE id = :id)")
       ->execute([':id' => $id]);

    $db->prepare('DELETE FROM ad_categories WHERE id = :id')
       ->execute([':id' => $id]);

    success(['message' => 'Category deleted. Its ads have been moved to Other.']);
}

function sanitize(mixed $value): string {
    return htmlspecialchars(strip_tags((string) $value), ENT_QUOTES, 'UTF-8');
}