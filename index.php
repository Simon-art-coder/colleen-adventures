<?php
$page_title = 'Home';
$meta_description = 'Experience Mount Kenya hiking with Colleen Adventures. Professional guides, multiple routes including Chogoria, Sirimon, Naro Moru. Book your adventure today!';
require_once 'includes/config.php';
include 'includes/header.php';
?>

<!-- Hero Section with Background Image -->
<section class="hero"
    style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('<?php echo $base_path; ?>/assets/images/hero-bg.jpg'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <h1>Discover Mount Kenya with <span>Colleen Adventures</span></h1>
            <p><?php echo htmlspecialchars($settings['company_tagline']); ?></p>
            <div class="hero-buttons">
                <a href="<?php echo $base_path; ?>/tours.php" class="btn btn-primary">View Tours</a>
                <a href="<?php echo $base_path; ?>/booking.php" class="btn btn-secondary">Book Now</a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="container">
        <div class="feature-grid">
            <div class="feature-card" data-aos="fade-up">
                <i class="fas fa-mountain"></i>
                <h3>4+ Routes</h3>
                <p>Chogoria, Sirimon, Naro Moru, and Burguret routes to suit all levels</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <i class="fas fa-users"></i>
                <h3>Expert Guides</h3>
                <p>Led by Collins Mwenda with 4+ years of Mount Kenya experience</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <i class="fas fa-utensils"></i>
                <h3>All-Inclusive</h3>
                <p>Meals, equipment, park fees, and transport from Nanyuki included</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <i class="fas fa-tag"></i>
                <h3>Group Discounts</h3>
                <p>Special rates for groups of 3 or more - save up to 15,000 KSH!</p>
            </div>
        </div>
    </div>
</section>

<!-- Popular Tours -->
<section class="popular-tours">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Popular Mount Kenya Routes</h2>
        <p class="section-subtitle" data-aos="fade-up">Choose from our most loved trekking routes</p>

        <div class="tour-grid">
            <?php
            $sql = "SELECT * FROM tours LIMIT 3";
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                while($tour = $result->fetch_assoc()) {
                    // Map database route names to actual image filenames
                    $route_name = $tour['route_name'];
                    $image_filename = 'default-route.png'; // Default fallback
                    
                    if (stripos($route_name, 'Chogoria') !== false) {
                        $image_filename = 'chogoria.jpg';
                    } elseif (stripos($route_name, 'Sirimon') !== false) {
                        $image_filename = 'sirimon.jpg';
                    } elseif (stripos($route_name, 'Naro Moru') !== false) {
                        $image_filename = 'naromoru.jpg';
                    } elseif (stripos($route_name, 'Burguret') !== false) {
                        $image_filename = 'burguret.jpg';
                    }
            ?>
            <div class="tour-card" data-aos="fade-up">
                <div class="tour-image">
                    <img src="<?php echo $base_path; ?>/assets/images/tours/<?php echo $image_filename; ?>"
                        alt="<?php echo $tour['route_name']; ?>"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/tours/default-route.png';">

                    <?php if($tour['is_best_seller']): ?>
                    <span class="badge best-seller">Best Seller</span>
                    <?php endif; ?>
                    <?php if($tour['is_beginner_friendly']): ?>
                    <span class="badge beginner">Beginner Friendly</span>
                    <?php endif; ?>
                </div>
                <div class="tour-content">
                    <h3><?php echo $tour['route_name']; ?></h3>
                    <p class="difficulty"><?php echo $tour['difficulty']; ?> • <?php echo $tour['duration_days']; ?>
                        Days</p>
                    <p class="highlights"><?php echo substr($tour['description'], 0, 100); ?>...</p>
                    <div class="tour-price">
                        <?php if($tour['price_international_usd']): ?>
                        <span
                            class="price-usd">$<?php echo number_format($tour['price_international_usd']); ?>/person</span>
                        <?php endif; ?>
                        <?php if($tour['price_kenyan_ksh']): ?>
                        <span class="price-ksh">KSH
                            <?php echo number_format($tour['price_kenyan_ksh']); ?>/person</span>
                        <?php endif; ?>
                    </div>
                    <a href="<?php echo $base_path; ?>/tour-detail.php?id=<?php echo $tour['id']; ?>"
                        class="btn btn-outline">View Details</a>
                </div>
            </div>
            <?php 
                }
            } else {
                // Fallback if no database data
            ?>
            <div class="tour-card" data-aos="fade-up">
                <div class="tour-image">
                    <img src="<?php echo $base_path; ?>/assets/images/tours/chogoria.jpg" alt="Chogoria Route">
                    <span class="badge best-seller">Best Seller</span>
                </div>
                <div class="tour-content">
                    <h3>Chogoria Route</h3>
                    <p class="difficulty">Moderate • 5 Days</p>
                    <p class="highlights">The most scenic route with stunning landscapes including Lake Ellis and Nithi
                        Falls...</p>
                    <div class="tour-price">
                        <span class="price-usd">$900/person</span>
                        <span class="price-ksh">KSH 65,000/person</span>
                    </div>
                    <a href="<?php echo $base_path; ?>/tour-detail.php?id=1" class="btn btn-outline">View Details</a>
                </div>
            </div>

            <div class="tour-card" data-aos="fade-up" data-aos-delay="100">
                <div class="tour-image">
                    <img src="<?php echo $base_path; ?>/assets/images/tours/sirimon.jpg" alt="Sirimon Route">
                    <span class="badge beginner">Beginner Friendly</span>
                </div>
                <div class="tour-content">
                    <h3>Sirimon Route</h3>
                    <p class="difficulty">Moderate • 5 Days</p>
                    <p class="highlights">Best route for beginners with gradual acclimatization and beautiful
                        moorlands...</p>
                    <div class="tour-price">
                        <span class="price-usd">$900/person</span>
                        <span class="price-ksh">KSH 65,000/person</span>
                    </div>
                    <a href="<?php echo $base_path; ?>/tour-detail.php?id=2" class="btn btn-outline">View Details</a>
                </div>
            </div>

            <div class="tour-card" data-aos="fade-up" data-aos-delay="200">
                <div class="tour-image">
                    <img src="<?php echo $base_path; ?>/assets/images/tours/naromoru.jpg" alt="Naro Moru Route">
                </div>
                <div class="tour-content">
                    <h3>Naro Moru Route</h3>
                    <p class="difficulty">Easy/Moderate • 3 Days</p>
                    <p class="highlights">The shortest route to Point Lenana, perfect for those with limited time...</p>
                    <div class="tour-price">
                        <span class="price-ksh">KSH 45,000/person</span>
                    </div>
                    <a href="<?php echo $base_path; ?>/tour-detail.php?id=3" class="btn btn-outline">View Details</a>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="text-center" style="text-align: center; margin-top: 50px;">
            <a href="<?php echo $base_path; ?>/tours.php" class="btn btn-primary">View All Routes</a>
        </div>
    </div>
</section>
<!-- Day Trips -->
<section class="day-trips">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Day Trips on Chogoria Route</h2>
        <p class="section-subtitle" data-aos="fade-up">Perfect for acclimatization or short adventures</p>

        <div class="day-trip-grid">
            <!-- Lake Ellis -->
            <div class="day-trip-card" data-aos="fade-up">
                <div class="trip-image-container">
                    <img src="<?php echo $base_path; ?>/assets/images/day-trips/lake-ellis.jpg" alt="Lake Ellis"
                        class="trip-image"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/day-trips/default-daytrip.jpg';">
                </div>
                <div class="trip-icon">
                    <i class="fas fa-water"></i>
                </div>
                <h3>Lake Ellis</h3>
                <p>Beautiful alpine lake on the Chogoria route. Perfect for day hikes and picnics with stunning views.
                </p>
                <div class="trip-features">
                    <span class="feature-tag"><i class="fas fa-tree"></i> Alpine Lake</span>
                    <span class="feature-tag"><i class="fas fa-camera"></i> Photography</span>
                </div>
                <div class="trip-duration">
                    <i class="far fa-clock"></i> 6 hours
                </div>
                <a href="<?php echo $base_path; ?>/contact.php?trip=Lake%20Ellis" class="btn btn-outline">Inquire</a>
            </div>

            <!-- Nithi Falls -->
            <div class="day-trip-card" data-aos="fade-up" data-aos-delay="100">
                <div class="trip-image-container">
                    <img src="<?php echo $base_path; ?>/assets/images/day-trips/nithi-falls.jpg" alt="Nithi Falls"
                        class="trip-image"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/day-trips/default-daytrip.jpg';">
                </div>
                <div class="trip-icon">
                    <i class="fas fa-waterfall"></i>
                </div>
                <h3>Nithi Falls</h3>
                <div class="trip-location">
                    <i class="fas fa-map-marker-alt"></i> Chogoria, Kenya
                </div>
                <p>High bamboo forests lead to this spectacular waterfall. A refreshing hike through lush vegetation.
                </p>
                <div class="trip-features">
                    <span class="feature-tag"><i class="fas fa-leaf"></i> Bamboo Forest</span>
                    <span class="feature-tag"><i class="fas fa-tint"></i> Waterfall</span>
                </div>
                <div class="trip-duration">
                    <i class="far fa-clock"></i> 4 hours
                </div>
                <a href="<?php echo $base_path; ?>/contact.php?trip=Nithi%20Falls" class="btn btn-outline">Inquire</a>
            </div>

            <!-- Mau Mau Caves -->
            <div class="day-trip-card" data-aos="fade-up" data-aos-delay="200">
                <div class="trip-image-container">
                    <img src="<?php echo $base_path; ?>/assets/images/day-trips/mau-mau-caves.jpg" alt="Mau Mau Caves"
                        class="trip-image"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/day-trips/default-daytrip.jpg';">
                </div>
                <div class="trip-icon">
                    <i class="fas fa-mountain"></i>
                </div>
                <h3>Mau Mau Caves</h3>
                <p>Historical caves with significance to the Mau Mau struggle. Learn about Kenyan history while
                    exploring.</p>
                <div class="trip-features">
                    <span class="feature-tag"><i class="fas fa-history"></i> Historical</span>
                    <span class="feature-tag"><i class="fas fa-hiking"></i> Easy Hike</span>
                </div>
                <div class="trip-duration">
                    <i class="far fa-clock"></i> 4 hours
                </div>
                <a href="<?php echo $base_path; ?>/contact.php?trip=Mau%20Mau%20Caves"
                    class="btn btn-outline">Inquire</a>
            </div>
        </div>
    </div>
</section>
<!-- About Preview -->
<section class="about-preview">
    <div class="container">
        <div class="about-grid">
            <div class="about-content" data-aos="fade-right">
                <h2>Meet Collins Mwenda</h2>
                <h3>Your Guide to Mount Kenya</h3>
                <p>Born and raised in the shadows of Mount Kenya, Collins has been guiding visitors to the peak since he
                    was 18. His passion for the mountain, combined with professional training and local knowledge,
                    ensures every trek is safe, educational, and unforgettable.</p>
                <p>With certifications in Wilderness First Aid and Mountain Guiding, Collins leads a team of dedicated
                    porters and cooks who make your mountain experience comfortable and authentic.</p>

                <div class="stats">
                    <div class="stat">
                        <span class="stat-number">4+</span>
                        <span class="stat-label">Years Experience</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">100+</span>
                        <span class="stat-label">Happy Clients</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">4</span>
                        <span class="stat-label">Routes</span>
                    </div>
                </div>

                <a href="<?php echo $base_path; ?>/about.php" class="btn btn-primary">Learn More About Us</a>
            </div>
            <div class="about-image" data-aos="fade-left">
                <img src="<?php echo $base_path; ?>/assets/images/guides/collins-mwenda.jpg"
                    alt="Collins Mwenda - Lead Guide"
                    onerror="this.src='<?php echo $base_path; ?>/assets/images/guides/default-guide.jpg';">
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">What Our Clients Say</h2>
        <p class="section-subtitle" data-aos="fade-up">Read experiences from trekkers who climbed with us</p>

        <div class="testimonial-slider">
            <?php
            $test_sql = "SELECT * FROM testimonials WHERE approved = 1 LIMIT 3";
            $test_result = $conn->query($test_sql);
            
            if ($test_result && $test_result->num_rows > 0) {
                while($test = $test_result->fetch_assoc()) {
            ?>
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                    <i class="fas fa-star <?php echo $i <= $test['rating'] ? 'active' : ''; ?>"></i>
                    <?php endfor; ?>
                </div>
                <p class="testimonial-text">"<?php echo htmlspecialchars($test['testimonial_text']); ?>"</p>
                <div class="testimonial-author">
                    <div>
                        <strong><?php echo htmlspecialchars($test['client_name']); ?></strong>
                        <span><?php echo htmlspecialchars($test['client_country']); ?></span>
                        <?php if($test['tour_route']): ?>
                        <span class="tour-route"><?php echo htmlspecialchars($test['tour_route']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php 
                }
            } else {
            ?>
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star active"></i>
                    <i class="fas fa-star active"></i>
                    <i class="fas fa-star active"></i>
                    <i class="fas fa-star active"></i>
                    <i class="fas fa-star active"></i>
                </div>
                <p class="testimonial-text">"Collins made our Mount Kenya trek unforgettable! His knowledge of the
                    mountain and constant encouragement helped our group reach Point Lenana. Highly recommend Colleen
                    Adventures!"</p>
                <div class="testimonial-author">
                    <div>
                        <strong>Sarah Johnson</strong>
                        <span>United Kingdom</span>
                        <span class="tour-route">Chogoria Route</span>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star active"></i>
                    <i class="fas fa-star active"></i>
                    <i class="fas fa-star active"></i>
                    <i class="fas fa-star active"></i>
                    <i class="fas fa-star active"></i>
                </div>
                <p class="testimonial-text">"Amazing experience with Colleen Adventures. The team was professional, food
                    was great, and we felt safe throughout. Already planning my next trip!"</p>
                <div class="testimonial-author">
                    <div>
                        <strong>David Ochieng</strong>
                        <span>Kenya</span>
                        <span class="tour-route">Sirimon Route</span>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star active"></i>
                    <i class="fas fa-star active"></i>
                    <i class="fas fa-star active"></i>
                    <i class="fas fa-star active"></i>
                    <i class="fas fa-star active"></i>
                </div>
                <p class="testimonial-text">"I was nervous about altitude sickness but Collins monitored everyone
                    carefully and we all made it. The Burguret route is wild and beautiful!"</p>
                <div class="testimonial-author">
                    <div>
                        <strong>Emma Weber</strong>
                        <span>Germany</span>
                        <span class="tour-route">Burguret Route</span>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="why-choose">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Why Choose Colleen Adventures?</h2>
        <p class="section-subtitle" data-aos="fade-up">What makes us different from other guiding services</p>

        <div class="why-grid">
            <div class="why-card" data-aos="fade-up">
                <i class="fas fa-shield-alt"></i>
                <h3>Safety First</h3>
                <p>Certified guides, first aid equipment, and emergency protocols ensure your safety on the mountain.
                </p>
            </div>
            <div class="why-card" data-aos="fade-up" data-aos-delay="100">
                <i class="fas fa-hand-holding-heart"></i>
                <h3>Local Knowledge</h3>
                <p>Born and raised in Mount Kenya region, our guides know every trail, plant, and story.</p>
            </div>
            <div class="why-card" data-aos="fade-up" data-aos-delay="200">
                <i class="fas fa-users"></i>
                <h3>Small Groups</h3>
                <p>Personalized attention with maximum group sizes of 8-10 people.</p>
            </div>
            <div class="why-card" data-aos="fade-up" data-aos-delay="300">
                <i class="fas fa-utensils"></i>
                <h3>Great Food</h3>
                <p>Enjoy hot, delicious meals prepared by our experienced mountain cooks.</p>
            </div>
            <div class="why-card" data-aos="fade-up" data-aos-delay="400">
                <i class="fas fa-tree"></i>
                <h3>Eco-Friendly</h3>
                <p>We practice Leave No Trace principles and support local conservation.</p>
            </div>
            <div class="why-card" data-aos="fade-up" data-aos-delay="500">
                <i class="fas fa-tag"></i>
                <h3>Best Value</h3>
                <p>All-inclusive prices with no hidden costs. Group discounts available.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta">
    <div class="container">
        <h2 data-aos="fade-up">Ready for Your Mount Kenya Adventure?</h2>
        <p data-aos="fade-up" data-aos-delay="100">Book now and experience the mountain with local experts</p>
        <div data-aos="fade-up" data-aos-delay="200">
            <a href="<?php echo $base_path; ?>/booking.php" class="btn btn-primary btn-large">Start Your Journey</a>
            <a href="<?php echo $base_path; ?>/contact.php" class="btn btn-secondary btn-large">Ask a Question</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>