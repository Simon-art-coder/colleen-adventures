<?php
// debug.php - Place in root folder
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>
<html>
<head>
    <title>Colleen Adventures Debug</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
        h1 { color: #8B4513; }
        h2 { color: #2E5C3E; margin-top: 30px; }
        .success { color: green; }
        .error { color: red; font-weight: bold; }
        .info { background: #f5f5f5; padding: 10px; border-radius: 5px; }
        table { border-collapse: collapse; width: 100%; }
        td, th { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #8B4513; color: white; }
        .pass { background: #d4edda; color: #155724; }
        .fail { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>🔍 Colleen Adventures Debug Tool</h1>";

// Server Information
echo "<h2>Server Information</h2>";
echo "<div class='info'>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Current Script: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "Base URL: http://" . $_SERVER['HTTP_HOST'] . "/colleen-adventures/<br>";
echo "</div>";

// Folder Structure Check
echo "<h2>Folder Structure Check</h2>";
$root = __DIR__;
echo "Root folder: $root<br>";

$folders = ['includes', 'assets', 'assets/css', 'assets/js', 'assets/images', 'assets/images/tours', 'assets/images/guides', 'assets/images/logo'];
echo "<table>";
echo "<tr><th>Folder</th><th>Status</th><th>Path</th></tr>";

foreach ($folders as $folder) {
    $path = $root . '/' . $folder;
    if (file_exists($path) && is_dir($path)) {
        echo "<tr class='pass'><td>$folder</td><td>✅ EXISTS</td><td>$path</td></tr>";
    } else {
        echo "<tr class='fail'><td>$folder</td><td>❌ MISSING</td><td>$path</td></tr>";
    }
}
echo "</table>";

// Critical Files Check
echo "<h2>Critical Files Check</h2>";
$files = [
    'includes/config.php',
    'includes/header.php',
    'includes/footer.php',
    'includes/navbar.php',
    'index.php',
    'about.php',
    'tours.php',
    'booking.php',
    'contact.php',
    'gallery.php'
];

echo "<table>";
echo "<tr><th>File</th><th>Status</th><th>Path</th></tr>";

foreach ($files as $file) {
    $path = $root . '/' . $file;
    if (file_exists($path)) {
        echo "<tr class='pass'><td>$file</td><td>✅ EXISTS</td><td>$path</td></tr>";
    } else {
        echo "<tr class='fail'><td>$file</td><td>❌ MISSING</td><td>$path</td></tr>";
    }
}
echo "</table>";

// Database Connection Test
echo "<h2>Database Connection Test</h2>";
if (file_exists($root . '/includes/config.php')) {
    try {
        require_once 'includes/config.php';
        echo "<p class='success'>✅ config.php loaded successfully</p>";
        
        if (isset($conn) && $conn) {
            echo "<p class='success'>✅ Database connection successful</p>";
            echo "Connected to: " . DB_NAME . "<br>";
            
            // Check if tables exist
            $tables = ['tours', 'team', 'testimonials', 'bookings', 'contact_messages', 'gallery', 'site_settings'];
            echo "<h3>Table Check:</h3>";
            echo "<table>";
            echo "<tr><th>Table</th><th>Status</th><th>Records</th></tr>";
            
            foreach ($tables as $table) {
                $result = $conn->query("SHOW TABLES LIKE '$table'");
                if ($result->num_rows > 0) {
                    $count = $conn->query("SELECT COUNT(*) as count FROM $table")->fetch_assoc()['count'];
                    echo "<tr class='pass'><td>$table</td><td>✅ EXISTS</td><td>$count records</td></tr>";
                } else {
                    echo "<tr class='fail'><td>$table</td><td>❌ MISSING</td><td>-</td></tr>";
                }
            }
            echo "</table>";
        } else {
            echo "<p class='error'>❌ Database connection failed</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='error'>❌ config.php not found</p>";
}

// Base Path Test
echo "<h2>Base Path Configuration</h2>";
echo "Current base_path in config.php should be: <strong>/colleen-adventures</strong><br>";
echo "Your current URL suggests base_path is: <strong>" . dirname($_SERVER['SCRIPT_NAME']) . "</strong><br>";

if (dirname($_SERVER['SCRIPT_NAME']) == '/colleen-adventures' || dirname($_SERVER['SCRIPT_NAME']) == '\\colleen-adventures') {
    echo "<p class='success'>✅ Base path looks correct</p>";
} else {
    echo "<p class='error'>⚠️ Base path may need adjustment. Update \$base_path in config.php to: <strong>" . dirname($_SERVER['SCRIPT_NAME']) . "</strong></p>";
}

// CSS Path Test
echo "<h2>CSS Path Test</h2>";
$css_path = '/colleen-adventures/assets/css/style.css';
$full_css_url = 'http://' . $_SERVER['HTTP_HOST'] . $css_path;

echo "Expected CSS URL: $full_css_url<br>";
echo "<a href='$full_css_url' target='_blank'>Click to test CSS file</a><br>";

// PHP Extensions
echo "<h2>Required PHP Extensions</h2>";
$extensions = ['mysqli', 'session', 'json'];
echo "<table>";
echo "<tr><th>Extension</th><th>Status</th></tr>";

foreach ($extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<tr class='pass'><td>$ext</td><td>✅ Loaded</td></tr>";
    } else {
        echo "<tr class='fail'><td>$ext</td><td>❌ Not loaded</td></tr>";
    }
}
echo "</table>";

// Recommendations
echo "<h2>Next Steps</h2>";
echo "<div class='info'>";
echo "1. ✅ Make sure your folder is named <strong>colleen-adventures</strong><br>";
echo "2. ✅ Create all missing folders and files shown in red above<br>";
echo "3. ✅ Update database credentials in includes/config.php if needed<br>";
echo "4. ✅ Import the SQL file into phpMyAdmin<br>";
echo "5. ✅ Update \$base_path in config.php if recommended above<br>";
echo "6. ✅ Visit <a href='/colleen-adventures/'>http://localhost:8080/colleen-adventures/</a> to view your site<br>";
echo "</div>";

echo "</body></html>";
?>