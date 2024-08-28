<?php

require '../../db_config.php';

function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize($_POST['name']);
    $password = sanitize($_POST['password']);
    $ownerid =  sanitize($_POST['ownerid']);
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    try {
        $conn = new PDO($dsn, PARAMS['USER'], PARAMS['PASSWORD'], $pdoOptions);
        
        // Check if the name already exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM salon_owner WHERE owner_name = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // If the name exists, return a warning
            echo '<script>alert("This name already exists. Please choose another name.");</script>';
            echo '<script>window.location = "user_add.php";</script>';
            exit;
        }

        // If the name does not exist, proceed to insert the new record
        $stmt = $conn->prepare("INSERT INTO salon_owner (owner_name, salon_owner_id, password) VALUES (:name, :ownerid, :password)");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':ownerid', $ownerid); 
        $stmt->bindParam(':password', $hashedPassword);
        
        $stmt->execute();

        echo '<script>alert("Felhasználó sikeresen hozzáadva!");</script>';
        echo '<script>window.location = "user_add.php";</script>';
        exit;
    } catch (PDOException $e) {
        $_SESSION['errors'] = "Error: " . $e->getMessage();
        header('Location: user_add.php');
        exit;
    } finally {
        $conn = null;
    }
}
