<?php
require '../../db_config.php';

header('Content-Type: application/json'); // JSON válasz

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $userId = intval($_POST['user_id']);

    try {
        // Begin a transaction
        $pdo->beginTransaction();

        // Delete related records from activity_logs
        $query = "DELETE FROM activity_logs WHERE user_id = :user_id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $statement->execute();

        // Delete the user
        $query = "DELETE FROM users WHERE user_id = :user_id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $statement->execute();

        // Commit the transaction
        $pdo->commit();

        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        // Rollback the transaction if something goes wrong
        $pdo->rollBack();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
