<?php
require_once '../includes/functions.php';
require_once '../includes/db.php';

if (is_logged_in()) {
    redirect('../dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_input($_POST['username'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        redirect('../register.html?error=' . urlencode('Please fill in all fields.'));
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirect('../register.html?error=' . urlencode('Please enter a valid email format.'));
    } else {
        // Check if username or email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            redirect('../register.html?error=' . urlencode('Username or Email already exists.'));
        } else {
            // Hash password and insert
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            
            if ($stmt->execute([$username, $email, $hashed_password])) {
                redirect('../login.html?success=' . urlencode('Registration successful! You can now login.'));
            } else {
                redirect('../register.html?error=' . urlencode('Database error. Please try again.'));
            }
        }
    }
} else {
    redirect('../register.html');
}
?>
