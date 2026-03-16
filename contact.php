<?php
$page_title = 'Contact Us';
$meta_description = 'Get in touch with Colleen Adventures. Ask questions about Mount Kenya treks, get advice, or request a custom itinerary.';
include 'includes/config.php';

// Handle form submission
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $subject = sanitize($_POST['subject']);
    $message = sanitize($_POST['message']);
    
    $sql = "INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
    
    if ($stmt->execute()) {
        // Send email notification
        $to = $settings['company_email'];
        $email_subject = "New Contact Form Message: $subject";
        $email_message = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";
        mail($to, $email_subject, $email_message);
        
        $success = "Thank you for contacting us! We'll get back to you within 24 hours.";
    } else {
        $error = "Sorry, there was an error sending your message. Please try again.";
    }
}

include 'includes/header.php';
?>

<style>
/* CONTACT PAGE SPECIFIC STYLES */

/* Page Header with Background */
.page-header {
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('<?php echo $base_path; ?>/assets/images/guides/contact-header.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    padding: 100px 0;
    text-align: center;
    color: white;
}

.page-header h1 {
    font-size: 3.5rem;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 2px;
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

/* Contact Section */
.contact-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    position: relative;
}

.contact-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('<?php echo $base_path; ?>/assets/images/contact/contact-bg-pattern.png');
    opacity: 0.1;
    pointer-events: none;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    position: relative;
    z-index: 1;
}

/* Contact Form */
.contact-form-wrapper {
    background: white;
    padding: 50px;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
}

.contact-form-wrapper:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 50px rgba(139, 69, 19, 0.2);
}

.contact-form-wrapper h2 {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 30px;
    position: relative;
    padding-bottom: 15px;
}

.contact-form-wrapper h2:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background: var(--primary-color);
}

.contact-form {
    margin-top: 30px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--text-dark);
    font-size: 0.95rem;
}

.form-group label.optional:after {
    content: ' (optional)';
    font-weight: normal;
    color: var(--text-light);
    font-size: 0.85rem;
}

.form-group label.required:after {
    content: ' *';
    color: #e74c3c;
    font-weight: bold;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 15px;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    font-family: inherit;
    font-size: 1rem;
    transition: all 0.3s;
    background: #f9f9f9;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    background: white;
    box-shadow: 0 5px 15px rgba(139, 69, 19, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 150px;
}

.phone-note {
    margin-top: 8px;
    font-size: 0.85rem;
    color: var(--text-light);
    display: flex;
    align-items: center;
    gap: 5px;
}

.phone-note i {
    color: var(--primary-color);
    font-size: 0.9rem;
}

.contact-form .btn {
    width: 100%;
    padding: 15px;
    font-size: 1.1rem;
    margin-top: 10px;
}

/* Contact Information */
.contact-info-wrapper {
    background: white;
    padding: 50px;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
}

.contact-info-wrapper:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 50px rgba(46, 92, 62, 0.2);
}

.contact-info-wrapper h2 {
    font-size: 2rem;
    color: var(--secondary-color);
    margin-bottom: 30px;
    position: relative;
    padding-bottom: 15px;
}

.contact-info-wrapper h2:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background: var(--secondary-color);
}

.contact-info-card {
    margin: 30px 0;
}

.contact-item {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 15px;
    transition: all 0.3s;
}

.contact-item:hover {
    background: var(--primary-color);
    transform: translateX(10px);
}

.contact-item:hover .contact-icon {
    background: white;
    color: var(--primary-color);
}

.contact-item:hover h3,
.contact-item:hover p,
.contact-item:hover a {
    color: white;
}

.contact-icon {
    width: 60px;
    height: 60px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
    transition: all 0.3s;
}

.contact-details h3 {
    margin-bottom: 8px;
    font-size: 1.2rem;
    color: var(--text-dark);
}

.contact-details p {
    color: var(--text-light);
    line-height: 1.6;
    margin-bottom: 5px;
}

.contact-details a {
    color: var(--text-light);
    text-decoration: none;
    transition: 0.3s;
    display: inline-block;
}

.contact-details a:hover {
    color: var(--primary-color);
    transform: translateX(5px);
}

.contact-item:hover .contact-details a:hover {
    color: var(--secondary-color);
}

/* International Call Note */
.international-note {
    margin-top: 20px;
    padding: 15px;
    background: #e8f5e9;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 15px;
    border-left: 4px solid var(--secondary-color);
}

.international-note i {
    font-size: 2rem;
    color: var(--secondary-color);
}

.international-note p {
    color: var(--text-dark);
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0;
}

.international-note a {
    color: var(--primary-color);
    font-weight: 600;
    text-decoration: none;
}

.international-note a:hover {
    text-decoration: underline;
}

/* Social Contact */
.social-contact {
    margin-top: 40px;
    text-align: center;
    padding-top: 30px;
    border-top: 2px solid #f0f0f0;
}

.social-contact h3 {
    color: var(--text-dark);
    margin-bottom: 20px;
    font-size: 1.3rem;
}

.social-links {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.social-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.3rem;
    transition: all 0.3s;
    text-decoration: none;
}

.social-btn.facebook {
    background: #3b5998;
}

.social-btn.instagram {
    background: linear-gradient(45deg, #f09433, #d62976, #962fbf, #4f5bd5);
}

.social-btn.tiktok {
    background: #000000;
}

.social-btn.whatsapp {
    background: #25D366;
}

.social-btn.email {
    background: var(--primary-color);
}

.social-btn:hover {
    transform: translateY(-8px) scale(1.1);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

/* Map Section */
.map-section {
    padding: 80px 0;
    background: white;
}

.map-container {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    margin-top: 40px;
}

.map-container iframe {
    display: block;
    width: 100%;
    height: 450px;
    border: none;
}

/* FAQ Section */
.faq-quick {
    padding: 80px 0;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    position: relative;
    overflow: hidden;
}

.faq-quick::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('<?php echo $base_path; ?>/assets/images/contact/faq-bg-pattern.png');
    opacity: 0.1;
    pointer-events: none;
}

.faq-quick .section-title {
    color: white;
    position: relative;
    z-index: 1;
}

.faq-quick .section-title:after {
    background: white;
}

.faq-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
    position: relative;
    z-index: 1;
}

.faq-item {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    padding: 30px;
    border-radius: 15px;
    transition: all 0.3s;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.faq-item:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-10px);
}

.faq-item h3 {
    color: white;
    margin-bottom: 15px;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.faq-item h3 i {
    font-size: 1.5rem;
}

.faq-item p {
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.6;
}

.faq-item a {
    color: white;
    text-decoration: underline;
    font-weight: 600;
}

.faq-item a:hover {
    color: var(--primary-color);
}

.faq-quick .text-center {
    position: relative;
    z-index: 1;
}

.faq-quick .btn-outline {
    color: white;
    border-color: white;
    background: transparent;
}

.faq-quick .btn-outline:hover {
    background: white;
    color: var(--primary-color);
}

/* Alerts */
.alert {
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 30px;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 15px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert i {
    font-size: 1.5rem;
}

/* Responsive */
@media (max-width: 992px) {
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .page-header h1 {
        font-size: 2.8rem;
    }

    .contact-form-wrapper,
    .contact-info-wrapper {
        padding: 40px;
    }
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
        gap: 0;
    }

    .page-header h1 {
        font-size: 2.3rem;
    }

    .contact-form-wrapper,
    .contact-info-wrapper {
        padding: 30px 20px;
    }

    .contact-item {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .contact-icon {
        margin-bottom: 10px;
    }

    .international-note {
        flex-direction: column;
        text-align: center;
    }

    .faq-grid {
        grid-template-columns: 1fr;
    }

    .map-container iframe {
        height: 350px;
    }
}

@media (max-width: 576px) {
    .page-header {
        padding: 60px 0;
    }

    .page-header h1 {
        font-size: 2rem;
    }

    .contact-form-wrapper h2,
    .contact-info-wrapper h2 {
        font-size: 1.6rem;
    }

    .social-links {
        gap: 10px;
    }

    .social-btn {
        width: 45px;
        height: 45px;
        font-size: 1.1rem;
    }
}
</style>

<!-- Page Header with Background -->
<section class="page-header">
    <div class="container">
        <h1>Contact Us</h1>
        <div class="breadcrumb">
            <a href="<?php echo $base_path; ?>/index.php">Home</a> / <span>Contact</span>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <!-- Contact Form -->
            <div class="contact-form-wrapper" data-aos="fade-right">
                <h2>Send Us a Message</h2>

                <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $success; ?>
                </div>
                <?php endif; ?>

                <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>

                <form method="POST" action="" class="contact-form">
                    <div class="form-group">
                        <label for="name" class="required">Your Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email" class="required">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="your@email.com" required>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="optional">Phone Number</label>
                            <input type="tel" id="phone" name="phone" placeholder="+254 712 490 970">
                            <div class="phone-note">
                                <i class="fas fa-info-circle"></i>
                                <span>Not necessary for international visitors. WhatsApp is preferred.</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject" class="required">Subject</label>
                        <input type="text" id="subject" name="subject" placeholder="What is this about?" required>
                    </div>

                    <div class="form-group">
                        <label for="message" class="required">Your Message</label>
                        <textarea id="message" name="message" rows="6"
                            placeholder="Tell us about your trek plans or questions..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane" style="margin-right: 10px;"></i>
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="contact-info-wrapper" data-aos="fade-left">
                <h2>Get in Touch</h2>

                <div class="contact-info-card">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Phone / WhatsApp</h3>
                            <p><a
                                    href="tel:<?php echo $settings['company_phone']; ?>"><?php echo $settings['company_phone']; ?></a>
                                (Kenya)</p>
                            <p><a
                                    href="tel:<?php echo $settings['company_phone_2']; ?>"><?php echo $settings['company_phone_2']; ?></a>
                                (Alternative)</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Email</h3>
                            <p><a
                                    href="mailto:<?php echo $settings['company_email']; ?>"><?php echo $settings['company_email']; ?></a>
                            </p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Office</h3>
                            <p><?php echo $settings['company_address']; ?></p>
                            <p><strong>Meeting point:</strong> Nanyuki town (for mountain pickups)</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Business Hours</h3>
                            <p>Monday - Sunday: 8:00 AM - 8:00 PM (East Africa Time)</p>
                            <p>Emergency contact: 24/7</p>
                        </div>
                    </div>
                </div>

                <!-- International Visitors Note -->
                <div class="international-note">
                    <i class="fas fa-globe-africa"></i>
                    <p>
                        <strong>International Visitors:</strong> Phone numbers are optional.
                        We recommend contacting us via <a href="https://wa.me/<?php echo $settings['whatsapp']; ?>"
                            target="_blank">WhatsApp</a>
                        or email for faster response.
                    </p>
                </div>

                <div class="social-contact">
                    <h3>Follow Our Adventures</h3>
                    <div class="social-links">
                        <?php if (!empty($settings['facebook'])): ?>
                        <a href="https://facebook.com/<?php echo $settings['facebook']; ?>" target="_blank"
                            class="social-btn facebook" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($settings['instagram'])): ?>
                        <a href="https://instagram.com/<?php echo $settings['instagram']; ?>" target="_blank"
                            class="social-btn instagram" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($settings['tiktok'])): ?>
                        <a href="https://tiktok.com/@<?php echo $settings['tiktok']; ?>" target="_blank"
                            class="social-btn tiktok" title="TikTok">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <?php endif; ?>
                        <a href="https://wa.me/<?php echo $settings['whatsapp']; ?>" target="_blank"
                            class="social-btn whatsapp" title="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="mailto:<?php echo $settings['company_email']; ?>" class="social-btn email"
                            title="Email">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Find Us</h2>
        <div class="map-container" data-aos="fade-up">
            <iframe src="<?php echo $settings['map_embed']; ?>" width="100%" height="450" style="border:0;"
                allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>

<!-- FAQ Quick Links -->
<section class="faq-quick">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Frequently Asked Questions</h2>
        <div class="faq-grid" data-aos="fade-up">
            <div class="faq-item">
                <h3><i class="fas fa-question-circle"></i> How do I book?</h3>
                <p>Use our <a href="<?php echo $base_path; ?>/booking.php">booking form</a> or contact us via
                    email/WhatsApp. We'll confirm within 24 hours.</p>
            </div>
            <div class="faq-item">
                <h3><i class="fas fa-question-circle"></i> Best route for beginners?</h3>
                <p>The Sirimon route is recommended for beginners due to gradual acclimatization and stunning views.</p>
            </div>
            <div class="faq-item">
                <h3><i class="fas fa-question-circle"></i> Do I need a local SIM?</h3>
                <p>No need! You can reach us via WhatsApp, email, or international call to +254 712 490 970.</p>
            </div>
            <div class="faq-item">
                <h3><i class="fas fa-question-circle"></i> Nairobi pickup?</h3>
                <p>Yes, we offer pickup from Nairobi for an additional fee. Contact us for arrangements.</p>
            </div>
        </div>
        <div class="text-center" data-aos="fade-up">
            <a href="<?php echo $base_path; ?>/tours.php" class="btn btn-outline btn-large">
                <i class="fas fa-mountain" style="margin-right: 10px;"></i>
                Explore Our Tours
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>