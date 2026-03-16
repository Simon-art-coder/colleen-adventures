<?php
$page_title = 'Page Not Found';
include 'includes/config.php';
include 'includes/header.php';
?>

<section class="error-section">
    <div class="container">
        <div class="error-card" data-aos="fade-up">
            <div class="error-code">404</div>
            <h1>Page Not Found</h1>
            <p class="error-message">Sorry, the page you're looking for doesn't exist or has been moved.</p>

            <div class="error-actions">
                <a href="index.php" class="btn btn-primary">Go to Homepage</a>
                <a href="tours.php" class="btn btn-outline">Browse Tours</a>
            </div>

            <div class="error-suggestions">
                <h3>Looking for something?</h3>
                <ul>
                    <li><a href="tours.php">Mount Kenya Trekking Routes</a></li>
                    <li><a href="day-trips.php">Day Trips</a></li>
                    <li><a href="about.php">Meet Our Guide</a></li>
                    <li><a href="booking.php">Book a Trek</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>