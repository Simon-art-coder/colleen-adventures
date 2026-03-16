<?php
$page_title = 'Photo Gallery';
$meta_description = 'Browse photos of Mount Kenya treks, stunning landscapes, happy clients, and the Colleen Adventures team.';
include 'includes/config.php';

// Get gallery images
$sql = "SELECT * FROM gallery ORDER BY upload_date DESC";
$result = $conn->query($sql);

// Get categories for filtering
$cat_sql = "SELECT DISTINCT category FROM gallery WHERE category IS NOT NULL";
$cat_result = $conn->query($cat_sql);
$categories = [];
if ($cat_result->num_rows > 0) {
    while($cat = $cat_result->fetch_assoc()) {
        $categories[] = $cat['category'];
    }
}

include 'includes/header.php';
?>

<style>
/* GALLERY PAGE SPECIFIC STYLES */

/* Page Header with Background */
.page-header {
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('<?php echo $base_path; ?>/assets/images/gallery/default.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    padding: 100px 0;
    text-align: center;
    color: white;
    position: relative;
}

.page-header h1 {
    font-size: 3.5rem;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 2px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.breadcrumb {
    font-size: 1.1rem;
}

.breadcrumb a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: 0.3s;
}

.breadcrumb a:hover {
    color: white;
}

/* Gallery Intro */
.gallery-intro {
    padding: 60px 0 30px;
    text-align: center;
}

.gallery-intro p {
    font-size: 1.2rem;
    color: var(--text-light);
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.8;
}

/* Gallery Filters */
.gallery-filters {
    padding: 20px 0 40px;
}

.filter-buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
}

.filter-btn {
    padding: 12px 30px;
    background: transparent;
    border: 2px solid var(--primary-color);
    border-radius: 50px;
    color: var(--primary-color);
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s;
}

.filter-btn:hover,
.filter-btn.active {
    background: var(--primary-color);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
}

/* Gallery Grid */
.gallery-section {
    padding: 20px 0 60px;
    background: var(--background-light);
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 25px;
    margin-top: 30px;
}

.gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 15px;
    box-shadow: var(--shadow);
    aspect-ratio: 4/3;
    cursor: pointer;
    transition: all 0.3s;
}

.gallery-item:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-hover);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}

.gallery-item:hover img {
    transform: scale(1.1);
}

.gallery-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
    color: white;
    padding: 30px 20px 20px;
    transform: translateY(100%);
    transition: transform 0.4s ease;
}

.gallery-item:hover .gallery-overlay {
    transform: translateY(0);
}

.gallery-overlay h3 {
    font-size: 1.3rem;
    margin-bottom: 8px;
    font-weight: 600;
}

.gallery-overlay p {
    font-size: 0.95rem;
    opacity: 0.9;
    line-height: 1.5;
}

/* Category Badge */
.gallery-item::before {
    content: attr(data-category);
    position: absolute;
    top: 15px;
    left: 15px;
    background: var(--primary-color);
    color: white;
    padding: 5px 15px;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 2;
    text-transform: capitalize;
    opacity: 0;
    transition: opacity 0.3s;
}

.gallery-item:hover::before {
    opacity: 1;
}

/* Lightbox Customization */
.fancybox__container {
    --fancybox-bg: rgba(0, 0, 0, 0.95);
}

.fancybox__caption {
    font-size: 1.1rem;
    padding: 15px;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.5));
}

/* Instagram Feed Section */
.instagram-feed {
    padding: 80px 0;
    background: white;
}

.insta-placeholder {
    text-align: center;
    padding: 60px;
    background: linear-gradient(135deg, #f9f9f9, #ffffff);
    border-radius: 20px;
    box-shadow: var(--shadow);
    border: 2px dashed var(--primary-color);
}

.insta-placeholder i {
    font-size: 5rem;
    color: var(--primary-color);
    margin-bottom: 20px;
    transition: all 0.3s;
}

.insta-placeholder:hover i {
    transform: scale(1.1) rotate(10deg);
    color: var(--secondary-color);
}

.insta-placeholder p {
    font-size: 1.2rem;
    color: var(--text-light);
    margin-bottom: 25px;
}

/* Loading Animation */
.gallery-item {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* No Images State */
.no-images {
    text-align: center;
    padding: 100px 20px;
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow);
}

.no-images i {
    font-size: 4rem;
    color: var(--primary-color);
    margin-bottom: 20px;
}

.no-images h3 {
    font-size: 1.8rem;
    color: var(--text-dark);
    margin-bottom: 15px;
}

.no-images p {
    color: var(--text-light);
    margin-bottom: 25px;
}

/* CTA Section */
.cta {
    background: linear-gradient(rgba(139, 69, 19, 0.9), rgba(46, 92, 62, 0.9)), url('<?php echo $base_path; ?>/assets/images/cta-bg.jpg');
    background-size: cover;
    background-attachment: fixed;
    padding: 100px 0;
    text-align: center;
    color: white;
}

.cta h2 {
    font-size: 3rem;
    margin-bottom: 20px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.cta p {
    font-size: 1.3rem;
    margin-bottom: 30px;
    opacity: 0.9;
}

/* Responsive Design */
@media (max-width: 992px) {
    .page-header h1 {
        font-size: 2.8rem;
    }

    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
}

@media (max-width: 768px) {
    .page-header {
        padding: 70px 0;
    }

    .page-header h1 {
        font-size: 2.3rem;
    }

    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }

    .filter-buttons {
        gap: 10px;
    }

    .filter-btn {
        padding: 8px 20px;
        font-size: 0.9rem;
    }

    .gallery-overlay h3 {
        font-size: 1.1rem;
    }

    .gallery-overlay p {
        font-size: 0.85rem;
    }

    .insta-placeholder {
        padding: 40px 20px;
    }

    .insta-placeholder i {
        font-size: 4rem;
    }

    .cta h2 {
        font-size: 2.2rem;
    }

    .cta p {
        font-size: 1.1rem;
    }
}

@media (max-width: 576px) {
    .page-header h1 {
        font-size: 2rem;
    }

    .gallery-grid {
        grid-template-columns: 1fr;
    }

    .gallery-item {
        aspect-ratio: 16/9;
    }

    .filter-buttons {
        flex-direction: column;
        align-items: center;
    }

    .filter-btn {
        width: 100%;
        max-width: 250px;
    }

    .cta h2 {
        font-size: 1.8rem;
    }
}
</style>

<!-- Page Header with Background -->
<section class="page-header">
    <div class="container">
        <h1>Photo Gallery</h1>
        <div class="breadcrumb">
            <a href="<?php echo $base_path; ?>/index.php">Home</a> / <span>Gallery</span>
        </div>
    </div>
</section>

<!-- Gallery Intro -->
<section class="gallery-intro">
    <div class="container">
        <p data-aos="fade-up">Browse through our collection of photos from Mount Kenya treks. See the stunning
            landscapes, happy clients, and the team behind Colleen Adventures.</p>
    </div>
</section>

<!-- Gallery Filters -->
<?php if (!empty($categories)): ?>
<section class="gallery-filters">
    <div class="container">
        <div class="filter-buttons" data-aos="fade-up">
            <button class="filter-btn active" data-filter="all">All Photos</button>
            <?php foreach($categories as $category): ?>
            <button class="filter-btn"
                data-filter="<?php echo strtolower($category); ?>"><?php echo $category; ?></button>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Gallery Grid -->
<section class="gallery-section">
    <div class="container">
        <?php if ($result && $result->num_rows > 0): ?>
        <div class="gallery-grid" id="gallery-grid">
            <?php while($image = $result->fetch_assoc()): ?>
            <div class="gallery-item" data-category="<?php echo strtolower($image['category'] ?? 'uncategorized'); ?>"
                data-aos="fade-up">
                <a href="<?php echo $base_path; ?>/assets/images/gallery/<?php echo $image['image_path']; ?>"
                    class="gallery-link" data-fancybox="gallery" data-caption="<?php echo $image['image_title']; ?>">
                    <img src="<?php echo $base_path; ?>/assets/images/gallery/thumbnails/<?php echo $image['image_path']; ?>"
                        alt="<?php echo $image['image_title']; ?>"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/gallery/default.jpg';">
                    <div class="gallery-overlay">
                        <h3><?php echo $image['image_title']; ?></h3>
                        <?php if($image['description']): ?>
                        <p><?php echo $image['description']; ?></p>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <!-- Fallback gallery if no images in database -->
        <div class="gallery-grid">
            <!-- Summit Shots -->
            <div class="gallery-item" data-category="summit">
                <a href="<?php echo $base_path; ?>/assets/images/gallery/summit-1.jpg" class="gallery-link"
                    data-fancybox="gallery" data-caption="Sunrise at Point Lenana">
                    <img src="<?php echo $base_path; ?>/assets/images/gallery/thumbnails/summit-1.jpg"
                        alt="Sunrise at Point Lenana"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/gallery/default.jpg';">
                    <div class="gallery-overlay">
                        <h3>Sunrise at Point Lenana</h3>
                        <p>The moment every trekker waits for</p>
                    </div>
                </a>
            </div>

            <div class="gallery-item" data-category="summit">
                <a href="<?php echo $base_path; ?>/assets/images/gallery/summit-2.jpg" class="gallery-link"
                    data-fancybox="gallery" data-caption="Happy trekkers at the summit">
                    <img src="<?php echo $base_path; ?>/assets/images/gallery/thumbnails/summit-2.jpg"
                        alt="Happy trekkers at the summit"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/gallery/default.jpg';">
                    <div class="gallery-overlay">
                        <h3>Summit Success</h3>
                        <p>Celebrating reaching Point Lenana</p>
                    </div>
                </a>
            </div>

            <!-- Route Shots -->
            <div class="gallery-item" data-category="chogoria">
                <a href="<?php echo $base_path; ?>/assets/images/gallery/chogoria-1.jpg" class="gallery-link"
                    data-fancybox="gallery" data-caption="Gorges Valley on Chogoria Route">
                    <img src="<?php echo $base_path; ?>/assets/images/gallery/thumbnails/chogoria-1.jpg"
                        alt="Gorges Valley"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/gallery/default.jpg';">
                    <div class="gallery-overlay">
                        <h3>Gorges Valley</h3>
                        <p>Chogoria Route's stunning landscape</p>
                    </div>
                </a>
            </div>

            <div class="gallery-item" data-category="chogoria">
                <a href="<?php echo $base_path; ?>/assets/images/gallery/lake-ellis.jpg" class="gallery-link"
                    data-fancybox="gallery" data-caption="Lake Ellis">
                    <img src="<?php echo $base_path; ?>/assets/images/gallery/thumbnails/lake-ellis.jpg"
                        alt="Lake Ellis"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/gallery/default.jpg';">
                    <div class="gallery-overlay">
                        <h3>Lake Ellis</h3>
                        <p>Beautiful alpine lake on Chogoria route</p>
                    </div>
                </a>
            </div>

            <div class="gallery-item" data-category="sirimon">
                <a href="<?php echo $base_path; ?>/assets/images/gallery/sirimon-1.jpg" class="gallery-link"
                    data-fancybox="gallery" data-caption="Moorlands on Sirimon Route">
                    <img src="<?php echo $base_path; ?>/assets/images/gallery/thumbnails/sirimon-1.jpg"
                        alt="Sirimon Moorlands"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/gallery/default.jpg';">
                    <div class="gallery-overlay">
                        <h3>Sirimon Moorlands</h3>
                        <p>Beautiful high-altitude vegetation</p>
                    </div>
                </a>
            </div>

            <div class="gallery-item" data-category="naromoru">
                <a href="<?php echo $base_path; ?>/assets/images/gallery/naromoru-1.jpg" class="gallery-link"
                    data-fancybox="gallery" data-caption="Vertical Bog, Naro Moru">
                    <img src="<?php echo $base_path; ?>/assets/images/gallery/thumbnails/naromoru-1.jpg"
                        alt="Vertical Bog"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/gallery/default.jpg';">
                    <div class="gallery-overlay">
                        <h3>Vertical Bog</h3>
                        <p>The famous section on Naro Moru route</p>
                    </div>
                </a>
            </div>

            <div class="gallery-item" data-category="burguret">
                <a href="<?php echo $base_path; ?>/assets/images/gallery/burguret-1.jpg" class="gallery-link"
                    data-fancybox="gallery" data-caption="Remote Burguret Route">
                    <img src="<?php echo $base_path; ?>/assets/images/gallery/thumbnails/burguret-1.jpg"
                        alt="Burguret Route"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/gallery/default.jpg';">
                    <div class="gallery-overlay">
                        <h3>Burguret Wilderness</h3>
                        <p>The most remote route</p>
                    </div>
                </a>
            </div>

            <!-- Team Shots -->
            <div class="gallery-item" data-category="team">
                <a href="<?php echo $base_path; ?>/assets/images/gallery/team-1.jpg" class="gallery-link"
                    data-fancybox="gallery" data-caption="Collins with clients">
                    <img src="<?php echo $base_path; ?>/assets/images/gallery/thumbnails/team-1.jpg"
                        alt="Collins with clients"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/gallery/default.jpg';">
                    <div class="gallery-overlay">
                        <h3>Collins with clients</h3>
                        <p>Making memories on the mountain</p>
                    </div>
                </a>
            </div>

            <div class="gallery-item" data-category="team">
                <a href="<?php echo $base_path; ?>/assets/images/gallery/team-2.jpg" class="gallery-link"
                    data-fancybox="gallery" data-caption="The Colleen Adventures team">
                    <img src="<?php echo $base_path; ?>/assets/images/gallery/thumbnails/team-2.jpg" alt="Team photo"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/gallery/default.jpg';">
                    <div class="gallery-overlay">
                        <h3>The Team</h3>
                        <p>Guides, porters, and cooks</p>
                    </div>
                </a>
            </div>

            <!-- Wildlife -->
            <div class="gallery-item" data-category="wildlife">
                <a href="<?php echo $base_path; ?>/assets/images/gallery/wildlife-1.jpg" class="gallery-link"
                    data-fancybox="gallery" data-caption="Hyrax on the mountain">
                    <img src="<?php echo $base_path; ?>/assets/images/gallery/thumbnails/wildlife-1.jpg" alt="Hyrax"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/gallery/default.jpg';">
                    <div class="gallery-overlay">
                        <h3>Rock Hyrax</h3>
                        <p>Common sight on Mount Kenya</p>
                    </div>
                </a>
            </div>

            <div class="gallery-item" data-category="wildlife">
                <a href="<?php echo $base_path; ?>/assets/images/gallery/wildlife-2.jpg" class="gallery-link"
                    data-fancybox="gallery" data-caption="Sunbirds">
                    <img src="<?php echo $base_path; ?>/assets/images/gallery/thumbnails/wildlife-2.jpg" alt="Sunbirds"
                        onerror="this.src='<?php echo $base_path; ?>/assets/images/gallery/default.jpg';">
                    <div class="gallery-overlay">
                        <h3>Sunbirds</h3>
                        <p>Colorful visitors to the moorlands</p>
                    </div>
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Instagram Feed Section -->
<section class="instagram-feed">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Follow Our Adventures</h2>
        <p class="section-subtitle" data-aos="fade-up">@<?php echo $settings['instagram']; ?></p>
        <div class="insta-grid" data-aos="fade-up">
            <div class="insta-placeholder">
                <i class="fab fa-instagram"></i>
                <p>Connect with us on Instagram for daily Mount Kenya photos and updates!</p>
                <a href="https://instagram.com/<?php echo $settings['instagram']; ?>" target="_blank"
                    class="btn btn-primary">Follow Us @<?php echo $settings['instagram']; ?></a>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta">
    <div class="container">
        <h2 data-aos="fade-up">Inspired by These Photos?</h2>
        <p data-aos="fade-up">Create your own Mount Kenya memories with Colleen Adventures</p>
        <a href="<?php echo $base_path; ?>/booking.php" class="btn btn-primary btn-large" data-aos="fade-up">
            <i class="fas fa-calendar-check" style="margin-right: 10px;"></i>
            Book Your Trek
        </a>
    </div>
</section>

<!-- Fancybox CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

<script>
// Gallery Filtering
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    if (filterBtns.length > 0) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                filterBtns.forEach(b => b.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');

                // Filter gallery items
                galleryItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-category') ===
                        filterValue) {
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'scale(1)';
                        }, 50);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.8)';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
    }

    // Initialize Fancybox
    Fancybox.bind("[data-fancybox]", {
        Toolbar: {
            display: {
                left: ["infobar"],
                middle: [
                    "zoomIn",
                    "zoomOut",
                    "toggle1to1",
                    "rotateCCW",
                    "rotateCW",
                    "flipX",
                    "flipY",
                ],
                right: ["slideshow", "thumbs", "close"],
            },
        },
    });

    // Add loading animation
    galleryItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>

<?php include 'includes/footer.php'; ?>