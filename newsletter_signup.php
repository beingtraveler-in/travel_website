<?php
// Replace the following with your own database credentials
$servername = "127.0.0.1";
$username = "xbnaulyx_1";
$password = "Zb100tdwtok@";
$dbname = "xbnaulyx_tms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email_address'];

// Check if email is already in the database
$sql = "SELECT email FROM newsletter_emails WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Insert new email address into the database
    $sql = "INSERT INTO newsletter_emails (email) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    echo file_get_contents('newsletter_confirmation.html');

    // Send notification email
    $to = "contact@beingtraveler.com";
    $subject = "New newsletter subscriber";
    $message = "A new user has subscribed to your newsletter: " . $email;
    $headers = "From: contact@beingtraveler.com" . "\r\n" .
               "Reply-To: reply@beingtraveler.com" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();
    mail($to, $subject, $message, $headers);
} else {
    echo "You're already subscribed to our newsletter!";
}

$stmt->close();
$conn->close();
?>