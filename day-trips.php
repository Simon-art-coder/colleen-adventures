<?php
$page_title = 'Day Trips on Mount Kenya';
$meta_description = 'Explore day trips on the Chogoria route including Lake Ellis, Nithi Falls, and Mau Mau Caves. Perfect for acclimatization or short adventures.';
include 'includes/config.php';
include 'includes/functions.php';

$day_trips = getDayTrips($conn);

include 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1>Day Trips on Chogoria Route</h1>
        <div class="breadcrumb">
            <a href="index.php">Home</a> / <span>Day Trips</span>
        </div>
    </div>
</section>

<!-- Day Trips Intro -->
<section class="day-trips-intro">
    <div class="container">
        <div class="intro-content" data-aos="fade-up">
            <p>If you're short on time or want to acclimatize before a summit attempt, our day trips on the beautiful
                Chogoria route are perfect. Experience the stunning landscapes of Mount Kenya without the multi-day
                commitment.</p>
            <p>All day trips include transport from Chogoria town, a guide, packed lunch, and park fees.</p>
        </div>
    </div>
</section>

<!-- Day Trips Grid -->
<section class="day-trips-detailed">
    <div class="container">
        <div class="day-trip-detailed-grid">
            <?php foreach($day_trips as $index => $trip): ?>
            <div class="day-trip-detailed-card" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                <div class="trip-image">
                    <img src="assets/images/day-trips/<?php echo strtolower(str_replace(' ', '-', $trip['trip_name'])); ?>.jpg"
                        alt="<?php echo $trip['trip_name']; ?>"
                        onerror="this.src='assets/images/day-trips/default-daytrip.jpg';">
                </div>
                <div class="trip-content">
                    <h2><?php echo $trip['trip_name']; ?></h2>
                    <div class="trip-meta">
                        <?php if($trip['duration_hours']): ?>
                        <span><i class="far fa-clock"></i> <?php echo $trip['duration_hours']; ?> hours</span>
                        <?php endif; ?>
                        <?php if($trip['difficulty']): ?>
                        <span><i class="fas fa-chart-line"></i> <?php echo $trip['difficulty']; ?></span>
                        <?php endif; ?>
                    </div>
                    <p class="trip-description"><?php echo $trip['description']; ?></p>

                    <div class="trip-details">
                        <h3>What's Included:</h3>
                        <ul>
                            <li><i class="fas fa-check"></i> Professional guide</li>
                            <li><i class="fas fa-check"></i> Park entry fees</li>
                            <li><i class="fas fa-check"></i> Packed lunch and water</li>
                            <li><i class="fas fa-check"></i> Transport from Chogoria</li>
                        </ul>
                    </div>

                    <?php if($trip['price_ksh']): ?>
                    <div class="trip-price">
                        <span class="price">KSH <?php echo number_format($trip['price_ksh']); ?></span>
                        <span class="price-note">per person</span>
                    </div>
                    <?php else: ?>
                    <div class="trip-price">
                        <span class="price">Contact for price</span>
                    </div>
                    <?php endif; ?>

                    <div class="trip-actions">
                        <a href="booking.php?trip=<?php echo urlencode($trip['trip_name']); ?>"
                            class="btn btn-primary">Book This Trip</a>
                        <a href="contact.php?trip=<?php echo urlencode($trip['trip_name']); ?>"
                            class="btn btn-outline">Inquire</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Custom Day Trips -->
<section class="custom-trips">
    <div class="container">
        <div class="custom-trips-content" data-aos="fade-up">
            <h2>Custom Day Trips Available</h2>
            <p>Looking for something different? We can arrange custom day trips to other areas of Mount Kenya based on
                your interests. Whether you're a bird watcher, photographer, or history enthusiast, we'll create the
                perfect day for you.</p>
            <a href="contact.php" class="btn btn-primary">Contact Us for Custom Trips</a>
        </div>
    </div>
</section>

<!-- What to Bring -->
<section class="what-to-bring">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">What to Bring on Day Trips</h2>
        <div class="bring-grid" data-aos="fade-up">
            <div class="bring-category">
                <h3>Essential</h3>
                <ul>
                    <li><i class="fas fa-check"></i> Comfortable hiking boots</li>
                    <li><i class="fas fa-check"></i> Warm jacket (it gets cold!)</li>
                    <li><i class="fas fa-check"></i> Rain jacket/poncho</li>
                    <li><i class="fas fa-check"></i> Day backpack (20-30L)</li>
                    <li><i class="fas fa-check"></i> Water bottle (2L)</li>
                    <li><i class="fas fa-check"></i> Sunscreen and hat</li>
                </ul>
            </div>
            <div class="bring-category">
                <h3>Recommended</h3>
                <ul>
                    <li><i class="fas fa-check"></i> Camera</li>
                    <li><i class="fas fa-check"></i> Snacks</li>
                    <li><i class="fas fa-check"></i> Sunglasses</li>
                    <li><i class="fas fa-check"></i> Personal medications</li>
                    <li><i class="fas fa-check"></i> Walking poles (available to rent)</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta">
    <div class="container">
        <h2>Ready for a Day Adventure?</h2>
        <p>Book your day trip to Lake Ellis, Nithi Falls, or Mau Mau Caves</p>
        <a href="booking.php" class="btn btn-primary btn-large">Book Your Day Trip</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>