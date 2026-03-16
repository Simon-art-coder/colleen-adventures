<?php
// File: includes/functions.php
// Additional helper functions

function getTours($conn, $limit = null, $featured = false) {
    $sql = "SELECT * FROM tours WHERE 1=1";
    if ($featured) {
        $sql .= " AND (is_best_seller = 1 OR is_beginner_friendly = 1)";
    }
    $sql .= " ORDER BY is_best_seller DESC, duration_days ASC";
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }
    $result = $conn->query($sql);
    $tours = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tours[] = $row;
        }
    }
    return $tours;
}

function getTestimonials($conn, $limit = null) {
    $sql = "SELECT * FROM testimonials WHERE approved = 1 ORDER BY date DESC";
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }
    $result = $conn->query($sql);
    $testimonials = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $testimonials[] = $row;
        }
    }
    return $testimonials;
}

function getDayTrips($conn) {
    $sql = "SELECT * FROM day_trips";
    $result = $conn->query($sql);
    $dayTrips = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dayTrips[] = $row;
        }
    }
    return $dayTrips;
}

function sendEmail($to, $subject, $message, $from = "") {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: " . ($from ?: "noreply@colleenadventures.co.ke") . "\r\n";
    
    return mail($to, $subject, $message, $headers);
}

function createSlug($string) {
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
}
?>