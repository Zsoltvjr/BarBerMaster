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
    $ownerid = sanitize($_POST['ownerid']);

    try {
        $conn = new PDO($dsn, PARAMS['USER'], PARAMS['PASSWORD'], $pdoOptions);
        
        // Check if the name and salon_owner_id exist and get the stored hashed password
        $stmt = $conn->prepare("SELECT password FROM salon_owner WHERE owner_name = :name AND salon_owner_id = :ownerid");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':ownerid', $ownerid);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $storedHashedPassword = $result['password'];

            // Verify the password
            if (password_verify($password, $storedHashedPassword)) {
                // Password is correct, proceed with deletion
                $stmt = $conn->prepare("DELETE FROM salon_owner WHERE owner_name = :name AND salon_owner_id = :ownerid");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':ownerid', $ownerid);
                $stmt->execute();

                echo '<script>alert("Felhasználó sikeresen törölve!");</script>';
                echo '<script>window.location = "users.php";</script>';
                exit;
            } else {
                // Password is incorrect
                echo '<script>alert("Incorrect password. Please try again.");</script>';
                echo '<script>window.location = "user_delete.php";</script>';
                exit;
            }
        } else {
            // Name or salon_owner_id does not exist
            echo '<script>alert("User does not exist or the ID does not match.");</script>';
            echo '<script>window.location = "user_delete.php";</script>';
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['errors'] = "Error: " . $e->getMessage();
        header('Location: user_delete.php');
        exit;
    } finally {
        $conn = null;
    }
}
