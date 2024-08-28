<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$host = "localhost";
$user = "kv";
$password = "d5x9keNYUsUFgLT";
$dbname = "kv";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['salon_id'])) {
    $salon_id = $_GET['salon_id'];

    $stmt = $conn->prepare("SELECT * FROM frizers WHERE salon_id = ?");
    $stmt->bind_param("i", $salon_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];

    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }

    echo json_encode($data);

    $stmt->close();
  } else {
    echo json_encode(["status" => "error", "message" => "No salon_id provided."]);
  }
} else {
  echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
