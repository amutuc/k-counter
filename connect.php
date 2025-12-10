<?php
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$artistname = filter_input(INPUT_POST, 'aName', FILTER_SANITIZE_STRING);
$artistlabel = filter_input(INPUT_POST, 'aLabel', FILTER_SANITIZE_STRING);
$lastrelease = filter_input(INPUT_POST, 'lastRelease', FILTER_SANITIZE_STRING);

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "requests";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
  die('Connect Error ('. $conn->connect_errno .') '.$conn->connect_error);
} else {
  $stmt = $conn->prepare("INSERT INTO k_requests (Name,Email,ArtistName,ArtistLabel,LastRelease) VALUES
  (?,?,?,?,?)");

  if ($stmt === false) {
    die('Prepare failed: ' . $conn->error);
  }

  $stmt->bind_param("sssss", $name, $email, $artistname, $artistlabel, $lastrelease);

  if ($stmt->execute()) {
    echo "You have successfully submitted!";
  } else {
    echo "Error: " . $stmt->error;
  }
  
  $stmt->close();
  $conn->close();
}
?>