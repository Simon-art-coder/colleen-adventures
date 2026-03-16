<?php
// Turn on error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Empty for XAMPP
define('DB_NAME', 'colleen_adventures');

// IMPORTANT: Change this to match your folder name
$base_path = '/colleen-adventures';
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . $base_path;

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8");

// Site settings with defaults
$settings = [
    'company_name' => 'Colleen Adventures',
    'company_tagline' => 'Your Local Guide to Mount Kenya\'s Peaks',
    'company_email' => 'collenadventures@gmail.com',
    'company_phone' => '0712490970',
    'company_phone_2' => '0734467422',
    'company_address' => 'Nairobi, Kenya',
    'facebook' => 'collenadventures',
    'instagram' => 'collenadventures',
    'tiktok' => 'collenadventures',
    'tripadvisor' => 'collenadventures',
    'business_reg' => 'BN-AYSOE2YW',
    'established_year' => '2026',
    'primary_color' => '#8B4513',
    'secondary_color' => '#2E5C3E',
    'accent_color' => '#FFFFFF',
    'whatsapp' => '0712490970'
];

// Try to load from database if available
$sql = "SELECT setting_key, setting_value FROM site_settings";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
}

// Function to sanitize input
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}

// Function to get current page
function getCurrentPage() {
    return basename($_SERVER['PHP_SELF'], '.php');
}

// Function to format price
function formatPrice($price, $currency = 'KSH') {
    if ($price) {
        if ($currency == 'KSH') {
            return 'KSH ' . number_format($price);
        } else {
            return '$' . number_format($price, 2);
        }
    }
    return 'Contact for price';
}
?>