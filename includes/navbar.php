<?php
if (!isset($base_path)) {
    require_once 'includes/config.php';
}
?>
<nav class="navbar">
    <div class="container">
        <div class="logo">
            <a href="<?php echo $base_path; ?>/index.php">
                <img src="<?php echo $base_path; ?>/assets/images/logo/logo.png"
                    alt="<?php echo htmlspecialchars($settings['company_name']); ?>"
                    onerror="this.style.display='none';">
                <span class="logo-text"><?php echo htmlspecialchars($settings['company_name']); ?></span>
            </a>
        </div>

        <ul class="nav-menu">
            <li><a href="<?php echo $base_path; ?>/index.php"
                    class="<?php echo (getCurrentPage() == 'index') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="<?php echo $base_path; ?>/about.php"
                    class="<?php echo (getCurrentPage() == 'about') ? 'active' : ''; ?>">About Us</a></li>
            <li class="dropdown">
                <a href="<?php echo $base_path; ?>/tours.php"
                    class="<?php echo (in_array(getCurrentPage(), ['tours', 'tour-detail', 'day-trips'])) ? 'active' : ''; ?>">Tours
                    <i class="fas fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo $base_path; ?>/tours.php?route=chogoria">Chogoria Route</a></li>
                    <li><a href="<?php echo $base_path; ?>/tours.php?route=sirimon">Sirimon Route</a></li>
                    <li><a href="<?php echo $base_path; ?>/tours.php?route=naromoru">Naro Moru Route</a></li>
                    <li><a href="<?php echo $base_path; ?>/tours.php?route=burguret">Burguret Route</a></li>
                    <li><a href="<?php echo $base_path; ?>/day-trips.php">Day Trips</a></li>
                </ul>
            </li>
            <li><a href="<?php echo $base_path; ?>/gallery.php"
                    class="<?php echo (getCurrentPage() == 'gallery') ? 'active' : ''; ?>">Gallery</a></li>
            <li><a href="<?php echo $base_path; ?>/contact.php"
                    class="<?php echo (getCurrentPage() == 'contact') ? 'active' : ''; ?>">Contact</a></li>
            <li><a href="<?php echo $base_path; ?>/booking.php" class="btn-nav">Book Now</a></li>
        </ul>

        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>

<a href="https://wa.me/<?php echo $settings['whatsapp']; ?>?text=Hello%20Colleen%20Adventures%2C%20I'm%20interested%20in%20Mount%20Kenya%20trekking"
    class="whatsapp-float" target="_blank">
    <i class="fab fa-whatsapp"></i>
</a>