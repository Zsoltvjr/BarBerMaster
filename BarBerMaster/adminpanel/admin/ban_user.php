<?php
require '../../db_config.php';
require 'email_notifications.php'; 
require 'activity_logs.php';

function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_GET['id']) && isset($_GET['name'])) {
    $userId = sanitize($_GET['id']);
    $username = sanitize($_GET['name']);

    try {
        $conn = new PDO($dsn, PARAMS['USER'], PARAMS['PASSWORD'], $pdoOptions);

        // Prepare and execute the update query
        $stmt = $conn->prepare("UPDATE users SET is_blocked = TRUE WHERE user_id = :id AND username = :name");

        $stmt->bindParam(':id', $userId);
        $stmt->bindParam(':name', $username);

        $stmt->execute();

        // Fetch user email to send notification
        $stmt = $conn->prepare("SELECT email FROM users WHERE user_id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $email = $user['email'];

        // Send notification email
        sendNotificationEmail($email, 'ban', $username);

        // Log the activity
        logActivity($conn, $userId, 'User banned: ' . $username);
        
        echo '<script>alert("Felhasználó sikeresen kitiltva!");</script>';
        echo '<script>window.location = "blocklist.php";</script>';
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
} else {
    echo '<script>alert("Invalid request.");</script>';
    echo '<script>window.location = "blocklist.php";</script>';
    exit;
}
