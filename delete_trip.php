<?php
require_once 'includes/functions.php';
require_once 'includes/db.php';

if (!is_logged_in()) {
    redirect('auth.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $trip_id = (int)($_POST['id'] ?? 0);

    if ($trip_id > 0) {
        $stmt = $pdo->prepare("DELETE FROM itineraries WHERE id = ? AND user_id = ?");
        $stmt->execute([$trip_id, $user_id]);
    }
}

redirect('dashboard.php');
?>
