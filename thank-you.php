<?php
$page_title = 'Thank You';
include 'includes/config.php';
include 'includes/header.php';
?>

<section class="thank-you-section">
    <div class="container">
        <div class="thank-you-card" data-aos="fade-up">
            <div class="thank-you-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Thank You!</h1>
            <p class="thank-you-message">Your booking request has been received successfully.</p>

            <div class="thank-you-details">
                <h2>What Happens Next?</h2>
                <div class="steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h3>Confirmation</h3>
                            <p>We'll review availability and confirm your booking within 24 hours via email and
                                WhatsApp.</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h3>Payment Instructions</h3>
                            <p>We'll send you payment details (M-Pesa, bank transfer, or card link). No deposit required
                                unless specified.</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h3>Preparation</h3>
                            <p>We'll send you a detailed packing list and answer any questions you have about your trek.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="thank-you-actions">
                <a href="index.php" class="btn btn-primary">Return to Home</a>
                <a href="tours.php" class="btn btn-outline">Explore Other Tours</a>
            </div>

            <div class="contact-reminder">
                <p>Have questions? Contact us immediately:</p>
                <p>
                    <i class="fas fa-phone"></i> <a
                        href="tel:<?php echo $settings['company_phone']; ?>"><?php echo $settings['company_phone']; ?></a>
                    |
                    <i class="fab fa-whatsapp"></i> <a
                        href="https://wa.me/<?php echo $settings['whatsapp']; ?>">WhatsApp</a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>