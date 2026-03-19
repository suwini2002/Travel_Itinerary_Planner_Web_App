<?php
require_once '../includes/functions.php';
require_once '../includes/db.php';

if (is_logged_in()) {
    redirect('../dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        redirect('../login.html?error=' . urlencode('Please enter both email and password.'));
    }

    // Validate if the email exists
    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Start session and store user info
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        redirect('../dashboard.php');
    } else {
        redirect('../login.html?error=' . urlencode('Invalid email or password.'));
    }
} else {
    redirect('../login.html');
}
?>
