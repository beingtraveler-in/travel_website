<?php
$servername = "127.0.0.1";
$username = "xbnaulyx_1";
$password = "Zb100tdwtok@";
$dbname = "xbnaulyx_blogs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM blog_posts ORDER BY date_created DESC";
$result = $conn->query($sql);

$posts = array();
while($row = $result->fetch_assoc()) {
  $postId = $row["id"];

  // Fetch comments for this post
  $commentsSql = "SELECT * FROM comments WHERE post_id = $postId ORDER BY date_created DESC";
  $commentsResult = $conn->query($commentsSql);

  $comments = array();
  while($commentRow = $commentsResult->fetch_assoc()) {
    $comments[] = $commentRow;
  }

  // Add comments to the post
  $row["comments"] = $comments;

  $posts[] = $row;
}

echo json_encode($posts);

$conn->close();
?>