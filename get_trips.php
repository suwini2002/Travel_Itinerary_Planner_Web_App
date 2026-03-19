<?php
// get_trips.php - Returns logged in user's trips as JSON
require_once 'includes/functions.php';
require_once 'includes/db.php';

header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM itineraries WHERE user_id = ? ORDER BY travel_date ASC");
    $stmt->execute([$user_id]);
    $trips = $stmt->fetchAll();
    echo json_encode(['status' => 'success', 'data' => $trips]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error']);
}
?>
