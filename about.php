<?php
$page_title = 'About Us';
$meta_description = 'Meet Collins Mwenda and the Colleen Adventures team. Learn about our experience, certifications, and commitment to safe Mount Kenya treks.';
include 'includes/config.php';
include 'includes/functions.php';

// Get lead guide
$sql = "SELECT * FROM team WHERE is_lead = 1 LIMIT 1";
$result = $conn->query($sql);
$lead_guide = $result->fetch_assoc();

// Get other team members if any
$sql_team = "SELECT * FROM team WHERE is_lead = 0 AND is_active = 1";
$team_result = $conn->query($sql_team);

include 'includes/header.php';
?>

<!-- Page Header with Background Image -->
<section class="page-header"
    style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('<?php echo $base_path; ?>/assets/images/about/about-header.jpg'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="container">
        <h1>About Colleen Adventures</h1>
        <div class="breadcrumb">
            <a href="<?php echo $base_path; ?>/index.php">Home</a> / <span>About Us</span>
        </div>
    </div>
</section>

<!-- Our Story -->
<section class="our-story">
    <div class="container">
        <div class="story-grid">
            <div class="story-content" data-aos="fade-right">
                <h2>Our Story</h2>
                <p>Colleen Adventures was founded in 2026 by Collins Mwenda, a passionate Mount Kenya guide who grew up
                    in the shadow of the mountain. What started as helping occasional visitors has grown into a
                    full-fledged guiding service dedicated to showing travelers the true beauty of Kenya's highest peak.
                </p>
                <p>The name "Colleen" comes from Collins' grandmother, who first took him to the mountain as a child and
                    instilled in him a deep love and respect for this incredible landscape.</p>
                <p>Today, we offer treks on all major Mount Kenya routes, day trips to beautiful spots on the mountain,
                    and combined safaris to other national parks. Our philosophy is simple: treat every client like
                    family, prioritize safety above all, and share the mountain with authenticity and passion.</p>

                <div class="mission-vision">
                    <div class="mission">
                        <h3><i class="fas fa-bullseye"></i> Our Mission</h3>
                        <p>To provide safe, memorable, and authentic Mount Kenya experiences while supporting local
                            communities and conserving the mountain environment.</p>
                    </div>
                    <div class="vision">
                        <h3><i class="fas fa-eye"></i> Our Vision</h3>
                        <p>To be the most trusted and recommended guiding service on Mount Kenya, known for exceptional
                            service, local knowledge, and client satisfaction.</p>
                    </div>
                </div>
            </div>
            <div class="story-image" data-aos="fade-left">
                <img src="<?php echo $base_path; ?>/assets/images/about/story.jpg" alt="Collins on Mount Kenya"
                    onerror="this.src='<?php echo $base_path; ?>/assets/images/about/default-story.jpg';">
            </div>
        </div>
    </div>
</section>

<!-- Meet the Guide -->
<section class="meet-guide-detailed">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Meet Your Lead Guide</h2>
        <div class="guide-profile-detailed" data-aos="fade-up">
            <div class="guide-image">
                <img src="<?php echo $base_path; ?>/assets/images/guides/<?php echo strtolower(str_replace(' ', '-', $lead_guide['name'])); ?>.jpg"
                    alt="<?php echo $lead_guide['name']; ?>"
                    onerror="this.src='<?php echo $base_path; ?>/assets/images/guides/default-guide.jpg';">
            </div>
            <div class="guide-info">
                <h3><?php echo $lead_guide['name']; ?></h3>
                <p class="guide-role"><?php echo $lead_guide['role']; ?></p>
                <div class="guide-details">
                    <p><strong>Experience:</strong> <?php echo $lead_guide['experience_years']; ?>+ years on Mount Kenya
                    </p>
                    <p><strong>Languages:</strong> <?php echo $lead_guide['languages']; ?></p>
                    <p><strong>Certifications:</strong> <?php echo $lead_guide['certifications']; ?></p>
                </div>
                <div class="guide-bio">
                    <p><?php echo $lead_guide['bio']; ?></p>
                </div>
                <div class="guide-social">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<?php if ($team_result->num_rows > 0): ?>
<section class="our-team">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Our Team</h2>
        <div class="team-grid">
            <?php while($team_member = $team_result->fetch_assoc()): ?>
            <div class="team-card" data-aos="fade-up">
                <div class="team-image">
                    <img src="<?php echo $base_path; ?>/assets/images/guides/<?php echo strtolower(str_replace(' ', '-', $team_member['name'])); ?>.jpg"
                        alt="<?php echo $team_member['name']; ?>"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/guides/default-guide.jpg';">
                </div>
                <div class="team-info">
                    <h3><?php echo $team_member['name']; ?></h3>
                    <p class="team-role"><?php echo $team_member['role']; ?></p>
                    <p class="team-experience"><?php echo $team_member['experience_years']; ?> years experience</p>
                    <p class="team-languages"><?php echo $team_member['languages']; ?></p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Certifications -->
<section class="certifications">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Our Certifications & Memberships</h2>
        <div class="cert-grid" data-aos="fade-up">
            <div class="cert-card">
                <i class="fas fa-medal"></i>
                <h3>Wilderness First Aid</h3>
                <p>Certified by the Kenya Red Cross</p>
            </div>
            <div class="cert-card">
                <i class="fas fa-mountain"></i>
                <h3>Mountain Guide Certificate</h3>
                <p>Kenya Mountain Guide Association</p>
            </div>
            <div class="cert-card">
                <i class="fas fa-heartbeat"></i>
                <h3>CPR Certified</h3>
                <p>Annual recertification</p>
            </div>
            <div class="cert-card">
                <i class="fas fa-tree"></i>
                <h3>Leave No Trace Trainer</h3>
                <p>Environmental conservation</p>
            </div>
            <div class="cert-card">
                <i class="fas fa-hand-holding-heart"></i>
                <h3>KAGA Member</h3>
                <p>Kenya Association of Guide Agencies</p>
            </div>
            <div class="cert-card">
                <i class="fas fa-shield-alt"></i>
                <h3>Registered Business</h3>
                <p>BN-AYSOE2YW</p>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="values">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Our Core Values</h2>
        <div class="values-grid" data-aos="fade-up">
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Safety</h3>
                <p>Your safety is our top priority. We never compromise on safety protocols.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Integrity</h3>
                <p>Honest pricing, transparent communication, and keeping our promises.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Community</h3>
                <p>Supporting local porters, cooks, and businesses around Mount Kenya.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3>Conservation</h3>
                <p>Protecting the mountain environment for future generations.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action with Background Image -->
<section class="cta"
    style="background: linear-gradient(rgba(139,69,19,0.9), rgba(46,92,62,0.9)), url('<?php echo $base_path; ?>/assets/images/cta-bg.jpg'); background-size: cover; background-attachment: fixed;">
    <div class="container">
        <h2>Ready to Trek with Us?</h2>
        <p>Let's plan your Mount Kenya adventure together</p>
        <a href="<?php echo $base_path; ?>/booking.php" class="btn btn-primary btn-large">Book Your Trek</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>