<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['error' => 'Not authenticated']));
}

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, category, energy, due_date, status, tags) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([
    $user_id,
    $data['title'],
    $data['category'] ?? 'Custom',
    $data['energy'] ?? 'low',
    $data['due_date'] ?? null,
    $data['status'] ?? 'todo',
    json_encode($data['tags'] ?? [])
]);

echo json_encode(['success' => true, 'task_id' => $pdo->lastInsertId()]);
?>