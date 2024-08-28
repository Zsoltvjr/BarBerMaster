<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$host = "localhost";
$user = "kv";
$password = "d5x9keNYUsUFgLT";
$dbname = "kv";

$conn = new mysqli($host, $user, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $input = json_decode(file_get_contents('php://input'), true);

  $store_id = $input['store_id'];
  $date = $input['date'];
  $start_time = $input['start_time'];
  $end_time = $input['end_time'];
  $user_id = $input['user_id'];
  $frizer_id = $input['frizer_id'];
  $treatment_id = $input['treatment_id'];
  $comment = $input['comment'];

  $stmt = $conn->prepare("INSERT INTO reservations (store_id, date, start_time, end_time, user_id, frizer_id, treatment_id, comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("isssiiss", $store_id, $date, $start_time, $end_time, $user_id, $frizer_id, $treatment_id, $comment);

  if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Reservation successful!"]);
  } else {
    echo json_encode(["status" => "error", "message" => "Failed to create reservation."]);
  }

  $stmt->close();
  $conn->close();
} else {
  echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
