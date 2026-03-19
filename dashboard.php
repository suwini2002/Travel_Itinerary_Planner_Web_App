<?php
require_once 'includes/functions.php';
require_once 'includes/db.php';

if (!is_logged_in()) {
    redirect('auth.php');
}

$user_id = $_SESSION['user_id'];

// Get all trips for the user
$stmt = $pdo->prepare("SELECT * FROM itineraries WHERE user_id = ? ORDER BY travel_date ASC");
$stmt->execute([$user_id]);
$trips = $stmt->fetchAll();

$totalDestinations = count($trips);
$totalDays = 0;
foreach ($trips as $trip) {
    $totalDays += (int)$trip['days'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Trip | Sri Lanka Travel</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        header.masthead-inner {
            padding-top: 8rem;
            padding-bottom: 4rem;
            background: linear-gradient(to bottom, rgba(11, 94, 57, 0.8) 0%, rgba(11, 94, 57, 0.9) 100%),
                        url('images/kandy.png');
            background-position: center;
            background-size: cover;
        }
        .trip-card {
            border-left: 4px solid var(--secondary-color);
            transition: transform 0.2s;
        }
        .trip-card:hover {
            transform: translateX(5px);
        }
        #trip-summary-box {
            background-color: var(--text-light);
            border-top: 4px solid var(--primary-color);
        }
    </style>
</head>
<body>

    <?php include 'includes/navbar.php'; ?>

    <header class="masthead-inner text-center text-white">
        <div class="container">
            <h1 class="font-weight-bold">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>
            <p class="fs-5 mt-3">Organize your Sri Lankan itinerary with ease.</p>
        </div>
    </header>

    <section class="page-section">
        <div class="container">
            <div class="row">
            
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="card shadow border-0 h-100">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 text-primary" style="color: var(--primary-color) !important;">Add Destination</h3>
                            
                            <?php if (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
                                <div class="alert alert-danger">Error adding trip. Please verify inputs.</div>
                            <?php endif; ?>
                            <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                                <div class="alert alert-success">Trip added successfully!</div>
                            <?php endif; ?>

                            <!-- Method POST to add_trip.php -->
                            <form action="add_trip.php" method="POST">
                                <div class="mb-3">
                                    <label for="destName" class="form-label fw-bold">Destination Name</label>
                                    <select class="form-select" id="destName" name="destination_name" required>
                                        <option value="" disabled selected>Select a destination...</option>
                                        <option value="Colombo">Colombo</option>
                                        <option value="Kandy">Kandy</option>
                                        <option value="Sigiriya">Sigiriya</option>
                                        <option value="Ella">Ella</option>
                                        <option value="Galle">Galle</option>
                                        <option value="Yala National Park">Yala National Park</option>
                                        <option value="Mirissa">Mirissa</option>
                                        <option value="Nuwara Eliya">Nuwara Eliya</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="travelDate" class="form-label fw-bold">Travel Date</label>
                                    <input type="date" class="form-control" id="travelDate" name="travel_date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="numDays" class="form-label fw-bold">Number of Days</label>
                                    <input type="number" class="form-control" id="numDays" name="days" min="1" max="30" placeholder="e.g. 3" required>
                                </div>
                                <div class="mb-4">
                                    <label for="travelNotes" class="form-label fw-bold">Notes / Activities</label>
                                    <textarea class="form-control" id="travelNotes" name="notes" rows="3" placeholder="What do you plan to do here?"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100 py-2 fw-bold">
                                    <i class="fa-solid fa-plus me-2"></i>Add to Itinerary
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card shadow-sm border-0 mb-4" id="trip-summary-box">
                        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-1" style="color: var(--primary-color);">Trip Summary</h4>
                                <p class="text-muted mb-0">Total Destinations: <span class="fw-bold"><?= $totalDestinations ?></span> | Total Days: <span class="fw-bold"><?= $totalDays ?></span></p>
                            </div>
                        </div>
                    </div>

                    <div id="destinationList">
                        <?php if ($totalDestinations === 0): ?>
                            <div class="text-center py-5 text-muted">
                                <i class="fa-solid fa-map-location-dot fs-1 mb-3 text-light-gray opacity-50"></i>
                                <h5>Your itinerary is empty</h5>
                                <p>Start adding destinations to build your dream Sri Lanka trip!</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($trips as $trip): 
                                $dest = $trip['destination_name'];
                                $imgName = 'hero.png';
                                if ($dest === 'Kandy') $imgName = 'kandy.png';
                                elseif ($dest === 'Ella') $imgName = 'ella.png';
                                elseif ($dest === 'Galle') $imgName = 'galle.png';
                            ?>
                            <div class="card trip-card shadow-sm mb-3">
                                <div class="row g-0">
                                    <div class="col-md-3 d-none d-md-block">
                                        <img src="images/<?= $imgName ?>" class="img-fluid rounded-start h-100 object-fit-cover" alt="<?= htmlspecialchars($dest) ?>">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body position-relative">
                                            <form action="delete_trip.php" method="POST" class="position-absolute top-0 end-0 m-3" onsubmit="return confirm('Are you sure you want to delete this trip?');">
                                                <input type="hidden" name="id" value="<?= $trip['id'] ?>">
                                                <button type="submit" class="btn-close text-danger" aria-label="Delete"></button>
                                            </form>
                                            <h5 class="card-title fw-bold text-primary mb-1" style="color: var(--primary-color) !important"><?= htmlspecialchars($dest) ?></h5>
                                            <div class="d-flex mb-2 flex-wrap">
                                                <span class="badge bg-light text-dark me-2 border"><i class="fa-regular fa-calendar me-1"></i><?= date('M d, Y', strtotime($trip['travel_date'])) ?></span>
                                                <span class="badge bg-light text-dark border"><i class="fa-regular fa-clock me-1"></i><?= htmlspecialchars($trip['days']) ?> Days</span>
                                            </div>
                                            <p class="card-text text-muted fst-italic mb-0"><?= htmlspecialchars($trip['notes']) ?: 'No notes provided.' ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white py-5 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4 text-success font-weight-bold">SriLankaExplore</h5>
                    <p>Your ultimate companion for planning the perfect trip.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <h5 class="text-uppercase mb-4">Follow Us</h5>
                    <div class="social-icons">
                        <a href="#" class="text-white me-3 fs-4"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" class="text-white me-3 fs-4"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="text-white me-3 fs-4"><i class="fa-brands fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    &copy; 2026 SriLankaExplore. All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
