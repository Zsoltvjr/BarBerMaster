<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PATCH, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$host = "localhost";
$user = "kv";
$password = "d5x9keNYUsUFgLT";
$dbname = "kv";

$conn = new mysqli($host, $user, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  $input = json_decode(file_get_contents('php://input'), true);
  $reservation_id = $input['reservation_id'];
  error_log($reservation_id);

  $stmt = $conn->prepare("DELETE FROM reservations WHERE reservation_id = ?");
  $stmt->bind_param("i", $reservation_id);

  if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Reservation deleted successfully!"]);
  } else {
    echo json_encode(["status" => "error", "message" => "Failed to delete the reservation."]);
  }

  $stmt->close();
  $conn->close();
} else {
  echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
