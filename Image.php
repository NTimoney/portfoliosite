<?php
// image.php

// Example: Get image filename from query parameter
if (!isset($_GET['file'])) {
    http_response_code(400);
    exit('No image specified.');
}

$file = basename($_GET['file']); // sanitize input, remove path traversal

// Define image directory
$imageDir = __DIR__ . '/images/';

// Full path to image
$imagePath = $imageDir . $file;

// Check if file exists and is an image
if (!file_exists($imagePath) || !getimagesize($imagePath)) {
    http_response_code(404);
    exit('Image not found.');
}

// Optional: Check referrer or user session for access control
/*
if ($_SERVER['HTTP_REFERER'] !== 'https://yourdomain.com/') {
    http_response_code(403);
    exit('Forbidden');
}
*/

// Send appropriate headers
header('Content-Type: ' . mime_content_type($imagePath));
header('Content-Length: ' . filesize($imagePath));
header('Cache-Control: private, max-age=86400'); // cache for 1 day

// Read and output the image
readfile($imagePath);
exit;
?>
