<?php
// includes/navbar.php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fa-solid fa-leaf text-success me-2"></i>SriLanka<span class="text-success">Explore</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto py-4 py-lg-0 align-items-center">
                <li class="nav-item"><a class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : '' ?>" href="dashboard.php">Plan Trip</a></li>
                <li class="nav-item"><a class="nav-link <?= ($current_page == 'contact.php') ? 'active' : '' ?>" href="contact.php">Contact</a></li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <span class="text-white me-3 d-none d-lg-inline-block">Hello, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!</span>
                        <a class="btn btn-outline-warning btn-sm rounded-pill px-3" href="auth/logout.php"><i class="fa-solid fa-right-from-bracket me-1"></i>Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <a class="nav-link text-warning fw-bold" href="login.html"><i class="fa-solid fa-right-to-bracket me-1"></i>Login</a>
                    </li>
                    <li class="nav-item mt-3 mt-lg-0">
                        <a class="nav-link text-warning fw-bold border border-warning rounded-pill px-3 ms-lg-2" href="register.html"><i class="fa-solid fa-user-plus me-1"></i>Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
