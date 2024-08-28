<?php
function logActivity($pdo, $userId, $action) {
    try {
        // Prepare and execute the insert query
        $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, action) VALUES (:user_id, :action)");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':action', $action);

        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
