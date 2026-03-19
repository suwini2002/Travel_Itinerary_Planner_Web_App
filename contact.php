<?php
require_once 'includes/functions.php';
require_once 'includes/db.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize_input($_POST['contactName'] ?? '');
    $email = sanitize_input($_POST['contactEmail'] ?? '');
    $subject = sanitize_input($_POST['contactSubject'] ?? '');
    $message = sanitize_input($_POST['contactMessage'] ?? '');
    
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$name, $email, $subject, $message])) {
            $success = true;
        } else {
            $error = "Failed to send message. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Sri Lanka Travel</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        header.masthead-inner {
            padding-top: 8rem;
            padding-bottom: 4rem;
            background: linear-gradient(to bottom, rgba(11, 94, 57, 0.8) 0%, rgba(11, 94, 57, 0.9) 100%),
                        url('images/galle.png');
            background-position: center;
            background-size: cover;
        }
        .contact-info-card {
            background-color: var(--primary-color);
            color: white;
            border-radius: 10px;
        }
        .contact-icon {
            font-size: 2rem;
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }
        .map-container {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            height: 400px;
            background: #e9ecef url('https://via.placeholder.com/1200x400.png?text=Google+Map+Placeholder') center/cover;
        }
    </style>
</head>
<body>

    <?php include 'includes/navbar.php'; ?>

    <header class="masthead-inner text-center text-white">
        <div class="container">
            <h1 class="font-weight-bold">Contact Us</h1>
            <p class="fs-5 mt-3">We'd love to hear from you. Get in touch!</p>
        </div>
    </header>

    <section class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0 order-lg-2">
                    <div class="contact-info-card p-5 h-100 shadow">
                        <h3 class="font-weight-bold mb-4">Get In Touch</h3>
                        
                        <div class="d-flex mb-4 align-items-start">
                            <div class="contact-icon me-3"><i class="fa-solid fa-location-dot"></i></div>
                            <div>
                                <h5 class="mb-1 text-white">Address</h5>
                                <p class="mb-0 text-white-50">123 Lotus Road, Colombo 01,<br>Sri Lanka</p>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-4 align-items-start">
                            <div class="contact-icon me-3"><i class="fa-solid fa-phone"></i></div>
                            <div>
                                <h5 class="mb-1 text-white">Phone</h5>
                                <p class="mb-0 text-white-50">+94 11 234 5678</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start">
                            <div class="contact-icon me-3"><i class="fa-solid fa-envelope"></i></div>
                            <div>
                                <h5 class="mb-1 text-white">Email</h5>
                                <p class="mb-0 text-white-50">hello@srilankaexplore.lk</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 pe-lg-5 order-lg-1">
                    <h2 class="mb-4" style="color: var(--primary-color);">Send Us a Message</h2>
                    <p class="text-muted mb-5">Have questions about your Sri Lankan adventure? Fill out the form below and our team will get back to you shortly.</p>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <i class="fa-solid fa-circle-check me-2"></i> Your message has been sent successfully!
                        </div>
                    <?php endif; ?>

                    <!-- Removed id="contactForm" to bypass js/script.js e.preventDefault(), as requested standard POST method -->
                    <form method="POST" action="contact.php">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contactName" class="form-label fw-bold">Full Name</label>
                                    <input type="text" class="form-control bg-light" id="contactName" name="contactName" placeholder="Your Name" required value="<?= htmlspecialchars($_POST['contactName'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contactEmail" class="form-label fw-bold">Email Address</label>
                                    <input type="email" class="form-control bg-light" id="contactEmail" name="contactEmail" placeholder="Your Email" required value="<?= htmlspecialchars($_POST['contactEmail'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="contactSubject" class="form-label fw-bold">Subject</label>
                                    <input type="text" class="form-control bg-light" id="contactSubject" name="contactSubject" placeholder="Message Subject" required value="<?= htmlspecialchars($_POST['contactSubject'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="contactMessage" class="form-label fw-bold">Message</label>
                                    <textarea class="form-control bg-light" id="contactMessage" name="contactMessage" rows="6" placeholder="How can we help you?" required><?= htmlspecialchars($_POST['contactMessage'] ?? '') ?></textarea>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-success btn-xl rounded-pill w-100 fw-bold">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="row mt-5 pt-4">
                <div class="col-12">
                    <h3 class="mb-4 text-center">Find Us Here</h3>
                    <div class="map-container w-100 d-flex align-items-center justify-content-center text-muted">
                        <div class="text-center bg-white p-4 rounded shadow-sm opacity-75">
                            <i class="fa-solid fa-map-location-dot fs-1 text-primary mb-2"></i>
                            <h5 class="mb-0">Google Maps Placeholder</h5>
                            <p class="mb-0 small">Interactive Map Would Load Here</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <footer class="bg-dark text-white py-5 mt-auto">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    &copy; 2026 SriLankaExplore. All Rights Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                   <div class="social-icons">
                        <a href="#" class="text-white me-3 fs-5"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" class="text-white me-3 fs-5"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="text-white fs-5"><i class="fa-brands fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
