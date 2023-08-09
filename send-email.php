<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $json = file_get_contents('php://input');
  $data = json_decode($json, true);

  $to = 'booking@beingtraveler.in';
  $subject = 'New Booking Request';
  $message = "Name: " . $data['name'] . "\r\n";
  $message .= "Email: " . $data['email'] . "\r\n";
  $message .= "Phone: " . $data['phone'] . "\r\n";
  $message .= "Number of People: " . $data['people'] . "\r\n";
  $message .= "Number of Days: " . $data['days'] . "\r\n";
  $message .= "Pickup Date: " . $data['pickupDate'] . "\r\n";
  $message .= "Comment: " . $data['comment'] . "\r\n";

  $headers = "From: " . $data['email'] . "\r\n";
  $headers .= "Reply-To: " . $data['email'] . "\r\n";
  $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

  if (mail($to, $subject, $message, $headers)) {
    http_response_code(200);
    echo json_encode(['message' => 'Email sent successfully']);
  } else {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to send email']);
  }
} else {
  http_response_code(405);
  echo json_encode(['message' => 'Invalid request method']);
}
?>