<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$host = "localhost";
$user = "kv";
$password = "d5x9keNYUsUFgLT";
$dbname = "kv";

$conn = new mysqli($host, $user, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Fetch active reservations for the user, including reservation_id
    $stmt = $conn->prepare("SELECT reservation_id, store_id, start_time, end_time, treatment_id, date FROM reservations WHERE user_id = ? AND cancelled = 0");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reservations = [];

    while ($row = $result->fetch_assoc()) {
      $reservations[] = $row;
    }

    echo json_encode($reservations);

    $stmt->close();
    $conn->close();
  } else {
    echo json_encode(["status" => "error", "message" => "No user_id provided."]);
  }
} else {
  echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
