<?php
$page_title = 'Tour Details';
include 'includes/config.php';

// Get tour ID from URL
$tour_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch tour details
$sql = "SELECT * FROM tours WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tour_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header('Location: tours.php');
    exit();
}

$tour = $result->fetch_assoc();
$page_title = $tour['route_name'] . ' Route';

// Fetch related testimonials
$test_sql = "SELECT * FROM testimonials WHERE tour_route LIKE ? AND approved = 1 LIMIT 3";
$like_route = '%' . $tour['route_name'] . '%';
$test_stmt = $conn->prepare($test_sql);
$test_stmt->bind_param("s", $like_route);
$test_stmt->execute();
$testimonials = $test_stmt->get_result();

include 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header"
    style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/images/tours/<?php echo strtolower(str_replace(' ', '-', $tour['route_name'])); ?>-header.jpg'); background-size: cover;">
    <div class="container">
        <h1><?php echo $tour['route_name']; ?> Route</h1>
        <div class="breadcrumb">
            <a href="index.php">Home</a> / <a href="tours.php">Tours</a> /
            <span><?php echo $tour['route_name']; ?></span>
        </div>
    </div>
</section>

<!-- Tour Overview -->
<section class="tour-overview">
    <div class="container">
        <div class="tour-overview-grid">
            <div class="tour-main" data-aos="fade-right">
                <div class="tour-gallery">
                    <img src="assets/images/tours/<?php echo strtolower(str_replace(' ', '-', $tour['route_name'])); ?>.jpg"
                        alt="<?php echo $tour['route_name']; ?>" class="main-image"
                        onerror="this.src='assets/images/tours/default-route.jpg';">
                </div>

                <div class="tour-description-section">
                    <h2>About the <?php echo $tour['route_name']; ?> Route</h2>
                    <p><?php echo $tour['description']; ?></p>

                    <h3>Route Highlights</h3>
                    <ul class="highlights-list">
                        <?php 
                        $highlights = explode(',', $tour['highlights']);
                        foreach($highlights as $highlight): 
                        ?>
                        <li><i class="fas fa-check-circle"></i> <?php echo trim($highlight); ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <h3>Detailed Itinerary</h3>
                    <?php if($tour['itinerary']): ?>
                    <div class="itinerary">
                        <?php echo nl2br($tour['itinerary']); ?>
                    </div>
                    <?php else: ?>
                    <p>Contact us for a detailed day-by-day itinerary for the <?php echo $tour['route_name']; ?> route.
                    </p>
                    <?php endif; ?>

                    <div class="tour-notes">
                        <h3>Important Notes</h3>
                        <ul>
                            <li><i class="fas fa-info-circle"></i> Acclimatization is built into the itinerary</li>
                            <li><i class="fas fa-info-circle"></i> Vegetarian/vegan meals available on request</li>
                            <li><i class="fas fa-info-circle"></i> Private tours available for this route</li>
                            <li><i class="fas fa-info-circle"></i> Minimum 2 people for guaranteed departure</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="tour-sidebar" data-aos="fade-left">
                <div class="sidebar-widget pricing-widget">
                    <h3>Tour Prices</h3>

                    <?php if($tour['price_international_usd']): ?>
                    <div class="price-item">
                        <span class="price-label">International</span>
                        <span
                            class="price-amount">$<?php echo number_format($tour['price_international_usd']); ?></span>
                        <span class="price-note">per person</span>
                    </div>
                    <?php endif; ?>

                    <?php if($tour['price_kenyan_ksh']): ?>
                    <div class="price-item">
                        <span class="price-label">Kenyan Citizens</span>
                        <span class="price-amount">KSH <?php echo number_format($tour['price_kenyan_ksh']); ?></span>
                        <span class="price-note">per person</span>
                    </div>
                    <?php endif; ?>

                    <?php if($tour['group_discount_ksh']): ?>
                    <div class="price-item discount">
                        <span class="price-label">Group of 3+</span>
                        <span class="price-amount">KSH <?php echo number_format($tour['group_discount_ksh']); ?></span>
                        <span class="price-note">per person</span>
                    </div>
                    <?php endif; ?>

                    <div class="price-actions">
                        <a href="booking.php?tour=<?php echo $tour['id']; ?>" class="btn btn-primary btn-block">Book
                            This Tour</a>
                        <a href="contact.php" class="btn btn-outline btn-block">Ask a Question</a>
                    </div>
                </div>

                <div class="sidebar-widget info-widget">
                    <h3>Tour Information</h3>
                    <ul>
                        <li><i class="fas fa-calendar-alt"></i> <strong>Duration:</strong>
                            <?php echo $tour['duration_days']; ?> days</li>
                        <li><i class="fas fa-chart-line"></i> <strong>Difficulty:</strong>
                            <?php echo $tour['difficulty']; ?></li>
                        <li><i class="fas fa-users"></i> <strong>Group Size:</strong> 2-10 people</li>
                        <li><i class="fas fa-utensils"></i> <strong>Meals:</strong> All meals included</li>
                        <li><i class="fas fa-bed"></i> <strong>Accommodation:</strong> Mountain huts/camping</li>
                        <li><i class="fas fa-flag"></i> <strong>Max Altitude:</strong> 4,985m (Point Lenana)</li>
                    </ul>
                </div>

                <div class="sidebar-widget guide-widget">
                    <h3>Your Guide</h3>
                    <?php
                    $guide_sql = "SELECT * FROM team WHERE is_lead = 1 LIMIT 1";
                    $guide_result = $conn->query($guide_sql);
                    $guide = $guide_result->fetch_assoc();
                    ?>
                    <div class="guide-mini">
                        <img src="assets/images/guides/<?php echo strtolower(str_replace(' ', '-', $guide['name'])); ?>.jpg"
                            alt="<?php echo $guide['name']; ?>"
                            onerror="this.src='assets/images/guides/default-guide.jpg';">
                        <h4><?php echo $guide['name']; ?></h4>
                        <p><?php echo $guide['experience_years']; ?>+ years experience</p>
                        <a href="about.php" class="btn-link">Meet the team <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials for this route -->
<?php if ($testimonials->num_rows > 0): ?>
<section class="route-testimonials">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">What Trekkers Say About <?php echo $tour['route_name']; ?></h2>
        <div class="testimonial-grid" data-aos="fade-up">
            <?php while($test = $testimonials->fetch_assoc()): ?>
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                    <i class="fas fa-star <?php echo $i <= $test['rating'] ? 'active' : ''; ?>"></i>
                    <?php endfor; ?>
                </div>
                <p class="testimonial-text">"<?php echo $test['testimonial_text']; ?>"</p>
                <div class="testimonial-author">
                    <strong><?php echo $test['client_name']; ?></strong>
                    <span><?php echo $test['client_country']; ?></span>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Related Routes -->
<section class="related-routes">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Other Routes You Might Like</h2>
        <div class="tour-grid" data-aos="fade-up">
            <?php
            $related_sql = "SELECT * FROM tours WHERE id != ? LIMIT 3";
            $related_stmt = $conn->prepare($related_sql);
            $related_stmt->bind_param("i", $tour_id);
            $related_stmt->execute();
            $related = $related_stmt->get_result();
            
            while($related_tour = $related->fetch_assoc()):
            ?>
            <div class="tour-card">
                <div class="tour-image">
                    <img src="assets/images/tours/<?php echo strtolower(str_replace(' ', '-', $related_tour['route_name'])); ?>.jpg"
                        alt="<?php echo $related_tour['route_name']; ?>"
                        onerror="this.src='assets/images/tours/default-route.jpg';">
                </div>
                <div class="tour-content">
                    <h3><?php echo $related_tour['route_name']; ?></h3>
                    <p class="difficulty"><?php echo $related_tour['difficulty']; ?> •
                        <?php echo $related_tour['duration_days']; ?> Days</p>
                    <a href="tour-detail.php?id=<?php echo $related_tour['id']; ?>" class="btn btn-outline">View
                        Route</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta">
    <div class="container">
        <h2>Ready to Trek the <?php echo $tour['route_name']; ?> Route?</h2>
        <p>Book now or contact us for more information</p>
        <a href="booking.php?tour=<?php echo $tour['id']; ?>" class="btn btn-primary btn-large">Book This Tour</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>