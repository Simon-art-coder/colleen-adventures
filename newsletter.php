<?php
// Handle newsletter signups
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = sanitize($_POST['email']);
    
    // Here you would typically save to a newsletter table
    // For now, just send an email notification
    
    $to = $settings['company_email'];
    $subject = "New Newsletter Subscription";
    $message = "New subscriber: $email";
    mail($to, $subject, $message);
    
    // Redirect back to previous page
    header('Location: ' . $_SERVER['HTTP_REFERER'] . '?newsletter=success');
    exit();
} else {
    header('Location: index.php');
    exit();
}
?>