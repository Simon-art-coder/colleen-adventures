<?php
$page_title = 'Book Your Trek';
$meta_description = 'Book your Mount Kenya trek with Colleen Adventures. Select your preferred route, dates, and group size.';
include 'includes/config.php';

// Get tours for dropdown
$tours_sql = "SELECT id, route_name, duration_days, price_kenyan_ksh, price_international_usd FROM tours ORDER BY route_name";
$tours_result = $conn->query($tours_sql);

// Handle form submission
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tour_id = intval($_POST['tour_id']);
    $client_name = sanitize($_POST['client_name']);
    $client_email = sanitize($_POST['client_email']);
    $client_phone = sanitize($_POST['client_phone']);
    $group_size = intval($_POST['group_size']);
    $preferred_date = $_POST['preferred_date'];
    $special_requests = sanitize($_POST['special_requests']);
    
    $sql = "INSERT INTO bookings (tour_id, client_name, client_email, client_phone, group_size, preferred_date, special_requests) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssiss", $tour_id, $client_name, $client_email, $client_phone, $group_size, $preferred_date, $special_requests);
    
    if ($stmt->execute()) {
        // Send confirmation email to client
        $to = $client_email;
        $subject = "Booking Confirmation - Colleen Adventures";
        $message = "
        <html>
        <body>
            <h2>Thank you for booking with Colleen Adventures!</h2>
            <p>Dear $client_name,</p>
            <p>We have received your booking request. Here's what you submitted:</p>
            <ul>
                <li>Tour ID: $tour_id</li>
                <li>Group Size: $group_size</li>
                <li>Preferred Date: $preferred_date</li>
            </ul>
            <p>We will confirm availability within 24 hours and send you payment instructions.</p>
            <p>In the meantime, if you have any questions, contact us at {$settings['company_phone']}</p>
            <p>Safe trekking,<br>Collins and the Colleen Adventures Team</p>
        </body>
        </html>
        ";
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: " . $settings['company_email'] . "\r\n";
        
        mail($to, $subject, $message, $headers);
        
        // Send notification to admin
        $admin_subject = "New Booking Received";
        $admin_message = "New booking from $client_name for tour ID: $tour_id. Group size: $group_size, Date: $preferred_date";
        mail($settings['company_email'], $admin_subject, $admin_message);
        
        $success = "Booking request received! We'll confirm within 24 hours.";
    } else {
        $error = "Booking failed. Please try again or contact us directly.";
    }
}

include 'includes/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1>Book Your Mount Kenya Trek</h1>
        <div class="breadcrumb">
            <a href="index.php">Home</a> / <span>Booking</span>
        </div>
    </div>
</section>

<!-- Booking Section -->
<section class="booking-section">
    <div class="container">
        <div class="booking-grid">
            <!-- Booking Form -->
            <div class="booking-form-wrapper" data-aos="fade-right">
                <h2>Booking Request Form</h2>

                <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="" class="booking-form" id="bookingForm">
                    <div class="form-group">
                        <label for="tour_id">Select Tour Route *</label>
                        <select name="tour_id" id="tour_id" required>
                            <option value="">-- Choose a route --</option>
                            <?php while($tour = $tours_result->fetch_assoc()): ?>
                            <option value="<?php echo $tour['id']; ?>"
                                data-kenyan="<?php echo $tour['price_kenyan_ksh']; ?>"
                                data-intl="<?php echo $tour['price_international_usd']; ?>">
                                <?php echo $tour['route_name']; ?> (<?php echo $tour['duration_days']; ?> days)
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="client_name">Full Name *</label>
                            <input type="text" name="client_name" id="client_name" required>
                        </div>

                        <div class="form-group">
                            <label for="client_email">Email Address *</label>
                            <input type="email" name="client_email" id="client_email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="client_phone">Phone Number (WhatsApp) *</label>
                            <input type="tel" name="client_phone" id="client_phone" placeholder="0712 490 970" required>
                        </div>

                        <div class="form-group">
                            <label for="group_size">Number of People *</label>
                            <input type="number" name="group_size" id="group_size" min="1" max="20" value="2" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="preferred_date">Preferred Start Date *</label>
                        <input type="date" name="preferred_date" id="preferred_date"
                            min="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="special_requests">Special Requests</label>
                        <textarea name="special_requests" id="special_requests" rows="4"
                            placeholder="Dietary requirements, medical conditions, specific needs..."></textarea>
                    </div>

                    <!-- Price Display -->
                    <div class="price-summary" id="priceSummary" style="display: none;">
                        <h3>Price Estimate</h3>
                        <p id="priceDisplay"></p>
                        <p class="price-note">*Final price confirmed upon booking</p>
                    </div>

                    <button type="submit" class="btn btn-primary btn-large">Submit Booking Request</button>
                </form>
            </div>

            <!-- Booking Information -->
            <div class="booking-info-wrapper" data-aos="fade-left">
                <div class="info-card">
                    <h3>Booking Information</h3>
                    <div class="info-item">
                        <i class="fas fa-check-circle" style="color: var(--secondary-color);"></i>
                        <div>
                            <h4>No Deposit Required</h4>
                            <p>Book now and pay later. Deposit only required for large groups.</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-check-circle" style="color: var(--secondary-color);"></i>
                        <div>
                            <h4>Free Cancellation</h4>
                            <p>Up to 30 days before your trek. See our full policy below.</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-check-circle" style="color: var(--secondary-color);"></i>
                        <div>
                            <h4>Group Discounts</h4>
                            <p>Save 15,000 KSH per person for groups of 3 or more on 5-day treks.</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-check-circle" style="color: var(--secondary-color);"></i>
                        <div>
                            <h4>Quick Confirmation</h4>
                            <p>We'll confirm availability within 24 hours of your request.</p>
                        </div>
                    </div>
                </div>

                <div class="info-card">
                    <h3>Payment Methods</h3>
                    <ul class="payment-methods">
                        <li><i class="fas fa-mobile-alt"></i> M-Pesa (Paybill/Till)</li>
                        <li><i class="fas fa-university"></i> Bank Transfer</li>
                        <li><i class="fab fa-cc-visa"></i> Credit/Debit Card (via link)</li>
                        <li><i class="fas fa-money-bill-wave"></i> Cash on arrival</li>
                        <li><i class="fab fa-paypal"></i> PayPal (international)</li>
                    </ul>
                </div>

                <div class="info-card">
                    <h3>Cancellation Policy</h3>
                    <ul class="policy-list">
                        <li><strong>More than 30 days:</strong> Full refund</li>
                        <li><strong>15-30 days:</strong> 50% refund</li>
                        <li><strong>7-14 days:</strong> 25% refund</li>
                        <li><strong>Less than 7 days:</strong> No refund</li>
                        <li><strong>No-show:</strong> No refund</li>
                    </ul>
                    <p class="policy-note">*Refunds processed within 7 working days</p>
                </div>

                <div class="info-card">
                    <h3>Need Help?</h3>
                    <p>Contact us directly:</p>
                    <p><i class="fas fa-phone"></i> <a
                            href="tel:<?php echo $settings['company_phone']; ?>"><?php echo $settings['company_phone']; ?></a>
                    </p>
                    <p><i class="fab fa-whatsapp"></i> <a
                            href="https://wa.me/<?php echo $settings['whatsapp']; ?>">WhatsApp</a></p>
                    <p><i class="fas fa-envelope"></i> <a
                            href="mailto:<?php echo $settings['company_email']; ?>"><?php echo $settings['company_email']; ?></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Booking Tips -->
<section class="booking-tips">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Tips Before You Book</h2>
        <div class="tips-grid" data-aos="fade-up">
            <div class="tip-card">
                <i class="fas fa-calendar-check"></i>
                <h3>Choose Your Season</h3>
                <p>Best months: January-February and August-September. Avoid March-April rains.</p>
            </div>
            <div class="tip-card">
                <i class="fas fa-chart-line"></i>
                <h3>Pick Your Difficulty</h3>
                <p>Beginners: Sirimon. Experienced: Chogoria or Burguret. Short on time: Naro Moru.</p>
            </div>
            <div class="tip-card">
                <i class="fas fa-users"></i>
                <h3>Travel in Groups</h3>
                <p>Save money and have more fun! Group discounts available for 3+ people.</p>
            </div>
            <div class="tip-card">
                <i class="fas fa-clock"></i>
                <h3>Book in Advance</h3>
                <p>Peak season books up quickly. Reserve at least 1-2 months ahead.</p>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('tour_id').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const kenyanPrice = selected.dataset.kenyan;
    const intlPrice = selected.dataset.intl;
    const groupSize = document.getElementById('group_size').value;
    const priceSummary = document.getElementById('priceSummary');
    const priceDisplay = document.getElementById('priceDisplay');

    if (this.value) {
        let priceText = '';
        if (kenyanPrice) {
            priceText += `Kenyan Citizens: KSH ${Number(kenyanPrice).toLocaleString()}/person`;
            if (groupSize >= 3) {
                priceText += ` (Group discount: KSH 50,000/person for 5-day tours)`;
            }
        }
        if (intlPrice) {
            if (priceText) priceText += '<br>';
            priceText += `International: $${Number(intlPrice).toLocaleString()}/person`;
        }
        priceDisplay.innerHTML = priceText;
        priceSummary.style.display = 'block';
    } else {
        priceSummary.style.display = 'none';
    }
});

document.getElementById('group_size').addEventListener('change', function() {
    document.getElementById('tour_id').dispatchEvent(new Event('change'));
});
</script>

<?php include 'includes/footer.php'; ?>