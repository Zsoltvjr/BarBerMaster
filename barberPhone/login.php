<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$host = "localhost";
$user = "kv";
$password = "d5x9keNYUsUFgLT";
$dbname = "kv";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
  die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $input = json_decode(file_get_contents('php://input'), true);

  if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON input."]);
    exit;
  }

  $username = $input['username'] ?? '';
  $password = $input['password'] ?? '';

  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode(["status" => "success", "userId" => $user['user_id']]);
  } else {
    echo json_encode(["status" => "error", "message" => "Invalid username or password."]);
  }

  $stmt->close();
  $conn->close();
} else {
  echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
