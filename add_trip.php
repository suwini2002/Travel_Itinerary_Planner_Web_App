<?php
require_once 'includes/functions.php';
require_once 'includes/db.php';

if (!is_logged_in()) {
    redirect('auth.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $destination_name = sanitize_input($_POST['destination_name'] ?? '');
    $travel_date = sanitize_input($_POST['travel_date'] ?? '');
    $days = (int)($_POST['days'] ?? 0);
    $notes = sanitize_input($_POST['notes'] ?? '');

    if (empty($destination_name) || empty($travel_date) || $days <= 0) {
        redirect('dashboard.php?status=error');
    }

    $stmt = $pdo->prepare("INSERT INTO itineraries (user_id, destination_name, travel_date, days, notes) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$user_id, $destination_name, $travel_date, $days, $notes])) {
        redirect('dashboard.php?status=success');
    } else {
        redirect('dashboard.php?status=error');
    }
} else {
    redirect('dashboard.php');
}
?>
