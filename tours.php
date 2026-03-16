<?php
$page_title = 'Mount Kenya Trekking Routes';
$meta_description = 'Explore all Mount Kenya trekking routes including Chogoria, Sirimon, Naro Moru, and Burguret. Compare prices, difficulty, and highlights.';
include 'includes/config.php';
include 'includes/functions.php';

// Get filter from URL
$filter = isset($_GET['route']) ? $_GET['route'] : 'all';

// Build query based on filter - FIXED VERSION
$sql = "SELECT * FROM tours";

if ($filter != 'all') {
    // Map URL parameter to actual route name in database
    $route_map = [
        'chogoria' => 'Chogoria',
        'sirimon' => 'Sirimon',
        'naromoru' => 'Naro Moru',
        'burguret' => 'Burguret'
    ];
    
    if (isset($route_map[$filter])) {
        $route_name = $route_map[$filter];
        $sql .= " WHERE route_name LIKE '%$route_name%'";
    }
}

$sql .= " ORDER BY 
    CASE 
        WHEN route_name LIKE '%Chogoria%' THEN 1
        WHEN route_name LIKE '%Sirimon%' THEN 2
        WHEN route_name LIKE '%Naro Moru%' THEN 3
        WHEN route_name LIKE '%Burguret%' THEN 4
        ELSE 5
    END";

$result = $conn->query($sql);

include 'includes/header.php';
?>

<style>
/* TOURS PAGE SPECIFIC STYLES */

/* Page Header */
.page-header {
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('<?php echo $base_path; ?>/assets/images/tours/tours-header.jpg');
    background-size: cover;
    background-position: center;
    padding: 80px 0;
    text-align: center;
    color: white;
}

.page-header h1 {
    font-size: 3rem;
    margin-bottom: 15px;
}

.breadcrumb {
    font-size: 1rem;
}

.breadcrumb a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: 0.3s;
}

.breadcrumb a:hover {
    color: white;
}

/* Route Filters */
.route-filters {
    padding: 40px 0 20px;
}

.filter-buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
}

.filter-btn {
    padding: 10px 25px;
    background: transparent;
    border: 2px solid var(--primary-color);
    border-radius: 50px;
    color: var(--primary-color);
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
    font-size: 0.95rem;
}

.filter-btn:hover,
.filter-btn.active {
    background: var(--primary-color);
    color: white;
}

/* Tours Listing */
.tours-listing {
    padding: 40px 0;
}

.tour-grid-full {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.tour-card-full {
    display: grid;
    grid-template-columns: 0.4fr 1.6fr;
    gap: 20px;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.tour-card-full:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
}

.tour-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.tour-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}

.tour-card-full:hover .tour-image img {
    transform: scale(1.1);
}

.badge {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 5px 15px;
    border-radius: 25px;
    color: white;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 1;
}

.badge.best-seller {
    background: #FFD700;
    color: #333;
}

.tour-content {
    padding: 20px 20px 20px 0;
}

.tour-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    flex-wrap: wrap;
    gap: 10px;
}

.tour-header h2 {
    font-size: 1.6rem;
    color: var(--primary-color);
    margin: 0;
}

.tour-meta {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
}

.difficulty-badge {
    padding: 5px 15px;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-block;
}

.difficulty-badge.moderate {
    background: #FFD700;
    color: #333;
}

.difficulty-badge.challenging {
    background: #e74c3c;
    color: white;
}

.difficulty-badge.easy\moderate {
    background: var(--secondary-color);
    color: white;
}

.duration {
    color: var(--text-light);
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
}

.duration i {
    margin-right: 5px;
    color: var(--primary-color);
}

.tour-description {
    color: var(--text-light);
    line-height: 1.7;
    margin-bottom: 15px;
    font-size: 0.95rem;
}

.tour-highlights {
    margin: 15px 0;
    padding: 15px 0;
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
}

.tour-highlights h3 {
    font-size: 1.1rem;
    color: var(--primary-color);
    margin-bottom: 8px;
}

.tour-highlights p {
    color: var(--text-light);
    line-height: 1.6;
    font-size: 0.95rem;
}

.tour-pricing {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 12px;
    margin: 15px 0;
}

.price-box {
    padding: 12px;
    background: var(--background-light);
    border-radius: 8px;
    text-align: center;
}

.price-box.discount {
    background: #e8f5e9;
    border: 1px solid var(--secondary-color);
}

.price-label {
    display: block;
    font-size: 0.8rem;
    color: var(--text-light);
    margin-bottom: 4px;
}

.price-value {
    font-size: 1rem;
    font-weight: 700;
    color: var(--primary-color);
}

.tour-actions {
    display: flex;
    gap: 12px;
    margin: 15px 0;
    flex-wrap: wrap;
}

.tour-actions .btn {
    padding: 8px 20px;
    font-size: 0.9rem;
}

.tour-badge {
    padding: 8px 15px;
    background: #e3f2fd;
    border-radius: 5px;
    color: #1976d2;
    display: inline-block;
    font-size: 0.9rem;
}

.tour-badge i {
    margin-right: 5px;
}

/* Route Comparison Table */
.route-comparison {
    padding: 60px 0;
    background: var(--background-light);
}

.comparison-table-wrapper {
    overflow-x: auto;
    margin-top: 30px;
}

.comparison-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow);
}

.comparison-table th {
    background: var(--primary-color);
    color: white;
    padding: 12px;
    text-align: left;
    font-weight: 600;
    font-size: 0.95rem;
}

.comparison-table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    font-size: 0.95rem;
}

.comparison-table tr:last-child td {
    border-bottom: none;
}

.comparison-table tr:hover {
    background: var(--background-light);
}

/* What's Included Section */
.included-section {
    padding: 60px 0;
}

.included-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-top: 30px;
}

.included-col h3 {
    margin-bottom: 20px;
    font-size: 1.2rem;
}

.included-col h3 i {
    margin-right: 8px;
}

.included-list,
.not-included-list {
    list-style: none;
    padding: 0;
}

.included-list li,
.not-included-list li {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
    display: flex;
    align-items: center;
    font-size: 0.95rem;
}

.included-list li:last-child,
.not-included-list li:last-child {
    border-bottom: none;
}

.included-list i {
    color: var(--secondary-color);
    margin-right: 12px;
    font-size: 1rem;
}

.not-included-list i {
    color: #e74c3c;
    margin-right: 12px;
    font-size: 1rem;
}

.no-results {
    text-align: center;
    padding: 60px;
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow);
    font-size: 1.1rem;
    color: var(--text-light);
}

/* Responsive */
@media (max-width: 992px) {
    .tour-card-full {
        grid-template-columns: 1fr;
        gap: 0;
    }

    .tour-image {
        height: 220px;
    }

    .tour-content {
        padding: 20px;
    }

    .page-header h1 {
        font-size: 2.5rem;
    }

    .included-grid {
        grid-template-columns: 1fr;
        gap: 25px;
    }
}

@media (max-width: 768px) {
    .tour-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .tour-meta {
        width: 100%;
    }

    .tour-actions {
        flex-direction: column;
    }

    .tour-actions .btn {
        width: 100%;
        text-align: center;
    }

    .filter-buttons {
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .filter-btn {
        width: 100%;
        max-width: 250px;
        text-align: center;
    }

    .page-header h1 {
        font-size: 2rem;
    }
}

@media (max-width: 576px) {
    .tour-pricing {
        grid-template-columns: 1fr;
    }

    .tour-header h2 {
        font-size: 1.4rem;
    }

    .tour-image {
        height: 200px;
    }
}
</style>

<!-- Page Header with Background Image -->
<section class="page-header">
    <div class="container">
        <h1>Mount Kenya Trekking Routes</h1>
        <div class="breadcrumb">
            <a href="<?php echo $base_path; ?>/index.php">Home</a> / <span>Tours</span>
        </div>
    </div>
</section>

<!-- Route Filters -->
<section class="route-filters">
    <div class="container">
        <div class="filter-buttons">
            <a href="<?php echo $base_path; ?>/tours.php"
                class="filter-btn <?php echo $filter == 'all' ? 'active' : ''; ?>">All Routes</a>
            <a href="<?php echo $base_path; ?>/tours.php?route=chogoria"
                class="filter-btn <?php echo $filter == 'chogoria' ? 'active' : ''; ?>">Chogoria</a>
            <a href="<?php echo $base_path; ?>/tours.php?route=sirimon"
                class="filter-btn <?php echo $filter == 'sirimon' ? 'active' : ''; ?>">Sirimon</a>
            <a href="<?php echo $base_path; ?>/tours.php?route=naromoru"
                class="filter-btn <?php echo $filter == 'naromoru' ? 'active' : ''; ?>">Naro Moru</a>
            <a href="<?php echo $base_path; ?>/tours.php?route=burguret"
                class="filter-btn <?php echo $filter == 'burguret' ? 'active' : ''; ?>">Burguret</a>
        </div>
    </div>
</section>

<!-- Tours Grid -->
<section class="tours-listing">
    <div class="container">
        <?php if ($result && $result->num_rows > 0): ?>
        <div class="tour-grid-full">
            <?php while($tour = $result->fetch_assoc()): 
                // Map route names to image filenames
                $route_name = $tour['route_name'];
                $image_filename = 'default-route.jpg';
                
                if (stripos($route_name, 'Chogoria') !== false) {
                    $image_filename = 'chogoria.jpg';
                } elseif (stripos($route_name, 'Sirimon') !== false) {
                    $image_filename = 'sirimon.jpg';
                } elseif (stripos($route_name, 'Naro Moru') !== false) {
                    $image_filename = 'naromoru.jpg';
                } elseif (stripos($route_name, 'Burguret') !== false) {
                    $image_filename = 'burguret.jpg';
                }
                
                // Format difficulty class
                $difficulty_class = strtolower(str_replace(' ', '-', $tour['difficulty']));
                if ($difficulty_class == 'easy/moderate') {
                    $difficulty_class = 'easy-moderate';
                }
            ?>
            <div class="tour-card-full" data-aos="fade-up">
                <div class="tour-image">
                    <img src="<?php echo $base_path; ?>/assets/images/tours/<?php echo $image_filename; ?>"
                        alt="<?php echo $tour['route_name']; ?>"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/tours/default-route.jpg';">
                    <?php if($tour['is_best_seller']): ?>
                    <span class="badge best-seller">Best Seller</span>
                    <?php endif; ?>
                </div>
                <div class="tour-content">
                    <div class="tour-header">
                        <h2><?php echo $tour['route_name']; ?></h2>
                        <div class="tour-meta">
                            <span class="difficulty-badge <?php echo $difficulty_class; ?>">
                                <?php echo $tour['difficulty']; ?>
                            </span>
                            <span class="duration"><i class="far fa-clock"></i> <?php echo $tour['duration_days']; ?>
                                Days</span>
                        </div>
                    </div>

                    <p class="tour-description"><?php echo $tour['description']; ?></p>

                    <div class="tour-highlights">
                        <h3>Highlights</h3>
                        <p><?php echo $tour['highlights']; ?></p>
                    </div>

                    <div class="tour-pricing">
                        <?php if($tour['price_international_usd']): ?>
                        <div class="price-box">
                            <span class="price-label">International</span>
                            <span
                                class="price-value">$<?php echo number_format($tour['price_international_usd']); ?>/person</span>
                        </div>
                        <?php endif; ?>

                        <?php if($tour['price_kenyan_ksh']): ?>
                        <div class="price-box">
                            <span class="price-label">Kenyan Citizens</span>
                            <span class="price-value">KSH
                                <?php echo number_format($tour['price_kenyan_ksh']); ?>/person</span>
                        </div>
                        <?php endif; ?>

                        <?php if($tour['group_discount_ksh']): ?>
                        <div class="price-box discount">
                            <span class="price-label">Group (3+ people)</span>
                            <span class="price-value">KSH
                                <?php echo number_format($tour['group_discount_ksh']); ?>/person</span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="tour-actions">
                        <a href="<?php echo $base_path; ?>/tour-detail.php?id=<?php echo $tour['id']; ?>"
                            class="btn btn-primary">View Full Itinerary</a>
                        <a href="<?php echo $base_path; ?>/booking.php?tour=<?php echo $tour['id']; ?>"
                            class="btn btn-secondary">Book Now</a>
                    </div>

                    <?php if($tour['is_beginner_friendly']): ?>
                    <div class="tour-badge">
                        <i class="fas fa-thumbs-up"></i> Recommended for beginners
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <div class="no-results">
            <i class="fas fa-map-marked-alt"
                style="font-size: 3rem; color: var(--primary-color); margin-bottom: 20px; display: block;"></i>
            <p>No tours found matching your criteria.</p>
            <a href="<?php echo $base_path; ?>/tours.php" class="btn btn-primary" style="margin-top: 20px;">View All
                Routes</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Route Comparison Table -->
<section class="route-comparison">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Route Comparison</h2>
        <div class="comparison-table-wrapper" data-aos="fade-up">
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Route</th>
                        <th>Duration</th>
                        <th>Difficulty</th>
                        <th>Scenery</th>
                        <th>Crowds</th>
                        <th>Best For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Chogoria</strong></td>
                        <td>5 days</td>
                        <td>Moderate</td>
                        <td>⭐⭐⭐⭐⭐ (Most scenic)</td>
                        <td>Moderate</td>
                        <td>Photographers, scenery lovers</td>
                    </tr>
                    <tr>
                        <td><strong>Sirimon</strong></td>
                        <td>5 days</td>
                        <td>Moderate</td>
                        <td>⭐⭐⭐⭐</td>
                        <td>Moderate</td>
                        <td>Beginners, wildlife viewing</td>
                    </tr>
                    <tr>
                        <td><strong>Naro Moru</strong></td>
                        <td>3 days</td>
                        <td>Easy/Moderate</td>
                        <td>⭐⭐⭐</td>
                        <td>Busy</td>
                        <td>Short trips, budget options</td>
                    </tr>
                    <tr>
                        <td><strong>Burguret</strong></td>
                        <td>5 days</td>
                        <td>Challenging</td>
                        <td>⭐⭐⭐⭐</td>
                        <td>Quiet</td>
                        <td>Adventure seekers, solitude</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- What's Included -->
<section class="included-section">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">What's Included in All Tours</h2>
        <div class="included-grid" data-aos="fade-up">
            <div class="included-col">
                <h3><i class="fas fa-check-circle" style="color: var(--secondary-color);"></i> Included</h3>
                <ul class="included-list">
                    <li><i class="fas fa-check"></i> Professional guide (Collins or team)</li>
                    <li><i class="fas fa-check"></i> Assistant guide for groups >4</li>
                    <li><i class="fas fa-check"></i> Porters for gear</li>
                    <li><i class="fas fa-check"></i> Cook and all meals</li>
                    <li><i class="fas fa-check"></i> Trekking poles</li>
                    <li><i class="fas fa-check"></i> Sleeping bag and mat</li>
                    <li><i class="fas fa-check"></i> Head torch</li>
                    <li><i class="fas fa-check"></i> Duffel bag for porters</li>
                    <li><i class="fas fa-check"></i> Park entry fees (KWS)</li>
                    <li><i class="fas fa-check"></i> Camping/hut fees</li>
                    <li><i class="fas fa-check"></i> Rescue fees</li>
                    <li><i class="fas fa-check"></i> Guide/porter permits</li>
                    <li><i class="fas fa-check"></i> Pickup from Nanyuki</li>
                </ul>
            </div>
            <div class="included-col">
                <h3><i class="fas fa-times-circle" style="color: #e74c3c;"></i> Not Included</h3>
                <ul class="not-included-list">
                    <li><i class="fas fa-times"></i> Tips for guides/porters (recommended: 1/3 of total)</li>
                    <li><i class="fas fa-times"></i> Personal hiking gear (boots, jackets)</li>
                    <li><i class="fas fa-times"></i> Travel insurance</li>
                    <li><i class="fas fa-times"></i> Alcoholic drinks</li>
                    <li><i class="fas fa-times"></i> Personal snacks</li>
                    <li><i class="fas fa-times"></i> Evacuation insurance</li>
                    <li><i class="fas fa-times"></i> Items of personal nature</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta"
    style="background: linear-gradient(rgba(139,69,19,0.9), rgba(46,92,62,0.9)), url('<?php echo $base_path; ?>/assets/images/cta-bg.jpg'); background-size: cover; background-attachment: fixed;">
    <div class="container">
        <h2>Ready to Choose Your Route?</h2>
        <p>Contact us for personalized recommendations based on your fitness and preferences</p>
        <a href="<?php echo $base_path; ?>/booking.php" class="btn btn-primary btn-large">Book Your Trek</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>