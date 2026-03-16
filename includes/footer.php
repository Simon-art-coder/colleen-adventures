<?php
if (!isset($base_path)) {
    require_once 'includes/config.php';
}
?>
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3><?php echo htmlspecialchars($settings['company_name']); ?></h3>
                <p><?php echo htmlspecialchars($settings['company_tagline']); ?></p>
                <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($settings['company_address']); ?>
                </p>
                <p><i class="fas fa-phone"></i> <a
                        href="tel:<?php echo $settings['company_phone']; ?>"><?php echo $settings['company_phone']; ?></a>
                </p>
                <p><i class="fas fa-phone"></i> <a
                        href="tel:<?php echo $settings['company_phone_2']; ?>"><?php echo $settings['company_phone_2']; ?></a>
                </p>
                <p><i class="fas fa-envelope"></i> <a
                        href="mailto:<?php echo $settings['company_email']; ?>"><?php echo $settings['company_email']; ?></a>
                </p>
                <p><i class="fas fa-registered"></i> Reg: <?php echo htmlspecialchars($settings['business_reg']); ?></p>
            </div>

            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="<?php echo $base_path; ?>/index.php">Home</a></li>
                    <li><a href="<?php echo $base_path; ?>/about.php">About Us</a></li>
                    <li><a href="<?php echo $base_path; ?>/tours.php">Tours</a></li>
                    <li><a href="<?php echo $base_path; ?>/day-trips.php">Day Trips</a></li>
                    <li><a href="<?php echo $base_path; ?>/gallery.php">Gallery</a></li>
                    <li><a href="<?php echo $base_path; ?>/contact.php">Contact</a></li>
                    <li><a href="<?php echo $base_path; ?>/booking.php">Book Now</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Popular Routes</h3>
                <ul>
                    <li><a href="<?php echo $base_path; ?>/tours.php?route=chogoria">Chogoria Route</a></li>
                    <li><a href="<?php echo $base_path; ?>/tours.php?route=sirimon">Sirimon Route</a></li>
                    <li><a href="<?php echo $base_path; ?>/tours.php?route=naromoru">Naro Moru Route</a></li>
                    <li><a href="<?php echo $base_path; ?>/tours.php?route=burguret">Burguret Route</a></li>
                    <li><a href="<?php echo $base_path; ?>/day-trips.php">Day Trips</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Connect With Us</h3>
                <p>Follow us on social media for updates and Mount Kenya photos!</p>
                <div class="social-links">
                    <?php if (!empty($settings['facebook'])): ?>
                    <a href="https://facebook.com/<?php echo $settings['facebook']; ?>" target="_blank"><i
                            class="fab fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($settings['instagram'])): ?>
                    <a href="https://instagram.com/<?php echo $settings['instagram']; ?>" target="_blank"><i
                            class="fab fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($settings['tiktok'])): ?>
                    <a href="https://tiktok.com/@<?php echo $settings['tiktok']; ?>" target="_blank"><i
                            class="fab fa-tiktok"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($settings['tripadvisor'])): ?>
                    <a href="https://tripadvisor.com/Profile/<?php echo $settings['tripadvisor']; ?>" target="_blank"><i
                            class="fab fa-tripadvisor"></i></a>
                    <?php endif; ?>
                    <a href="https://wa.me/<?php echo $settings['whatsapp']; ?>" target="_blank"><i
                            class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($settings['company_name']); ?>. All rights
                reserved. | Built with <i class="fas fa-heart" style="color: #e74c3c;"></i> for Mount Kenya adventures
            </p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

<script>
// JavaScript for Colleen Adventures
document.addEventListener('DOMContentLoaded', function() {

    // Initialize AOS
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });

    // Initialize Fancybox
    Fancybox.bind("[data-fancybox]", {});

    // Mobile menu toggle
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');

    if (hamburger) {
        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
    }

    // Close menu when clicking a link
    const navLinks = document.querySelectorAll('.nav-menu a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
        });
    });

    // Dropdown for mobile
    const dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                this.querySelector('.dropdown-menu').classList.toggle('show');
            }
        });
    });

    // Testimonial slider
    const testimonialCards = document.querySelectorAll('.testimonial-card');
    if (testimonialCards.length > 0) {
        let currentIndex = 0;

        // Show only first testimonial on mobile
        if (window.innerWidth <= 768) {
            testimonialCards.forEach((card, index) => {
                if (index !== 0) {
                    card.style.display = 'none';
                }
            });

            // Rotate every 5 seconds
            setInterval(() => {
                testimonialCards[currentIndex].style.display = 'none';
                currentIndex = (currentIndex + 1) % testimonialCards.length;
                testimonialCards[currentIndex].style.display = 'block';
            }, 5000);
        }
    }

    // Back to top button
    const backToTop = document.createElement('button');
    backToTop.innerHTML = '<i class="fas fa-arrow-up"></i>';
    backToTop.style.cssText = `
                position: fixed;
                bottom: 100px;
                right: 30px;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                background: <?php echo $settings['primary_color']; ?>;
                color: white;
                border: none;
                cursor: pointer;
                display: none;
                z-index: 99;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                transition: all 0.3s;
                font-size: 20px;
            `;

    backToTop.addEventListener('mouseenter', function() {
        this.style.background = '<?php echo $settings['secondary_color']; ?>';
    });

    backToTop.addEventListener('mouseleave', function() {
        this.style.background = '<?php echo $settings['primary_color']; ?>';
    });

    backToTop.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    document.body.appendChild(backToTop);

    window.addEventListener('scroll', function() {
        if (window.scrollY > 500) {
            backToTop.style.display = 'block';
        } else {
            backToTop.style.display = 'none';
        }
    });

    // Gallery filter (if on gallery page)
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    if (filterBtns.length > 0) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');

                galleryItems.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-category') ===
                        filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }

    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const required = this.querySelectorAll('[required]');
            let isValid = true;

            required.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#e74c3c';

                    let errorMsg = field.parentNode.querySelector('.error-message');
                    if (!errorMsg) {
                        errorMsg = document.createElement('small');
                        errorMsg.className = 'error-message';
                        errorMsg.style.color = '#e74c3c';
                        errorMsg.textContent = 'This field is required';
                        field.parentNode.appendChild(errorMsg);
                    }
                } else {
                    field.style.borderColor = '#ddd';
                    const errorMsg = field.parentNode.querySelector('.error-message');
                    if (errorMsg) errorMsg.remove();
                }
            });

            if (!isValid) e.preventDefault();
        });
    });

    console.log('Colleen Adventures website loaded successfully!');
});
</script>
</body>

</html>
<?php 
if (isset($conn) && $conn) {
    $conn->close(); 
}
?>