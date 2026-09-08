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

    $redirect_url = $base_url . '/index.php?newsletter=success';
    if (!empty($_SERVER['HTTP_REFERER'])) {
        $referer_host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
        $base_host = parse_url($base_url, PHP_URL_HOST);

        if ($referer_host === $base_host && !empty($_SERVER['HTTP_REFERER'])) {
            $redirect_url = $_SERVER['HTTP_REFERER'];
            if (strpos($redirect_url, '?') === false) {
                $redirect_url .= '?newsletter=success';
            } else {
                $redirect_url .= '&newsletter=success';
            }
        }
    }

    header('Location: ' . $redirect_url);
    exit();
} else {
    header('Location: index.php');
    exit();
}
?>