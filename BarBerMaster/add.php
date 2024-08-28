<?php
require 'db_config.php';
require_once "phpmailer/PHPMailerAutoload.php";

//
function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function generateToken()
{
    return bin2hex(random_bytes(32)); // Generate a 64-character hex token
}
 //Ezeket mind le kell nullazni
$userName= 0;
$lastName= 0;
$firstName = 0;
$mobile = 0;
$email = 0;
$password = 0; 
$token=0;
$active =0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debug: Print the entire $_POST array
    // echo '<pre>'; 
    // print_r($_POST); 
    // echo '</pre>';

    // Check if all required fields are present
    if (!isset($_POST['userName'], $_POST['lastName'], $_POST['firstName'], $_POST['mobile'], $_POST['email'], $_POST['password'])) {
        echo "Error: Missing form fields.";
        exit;
    }

// echo "$userName <br>";
// echo "$lastName <br>";
// echo "$firstName <br>";
// echo "$mobile <br>";
// echo "$email <br>";
// echo "$password <br>";
// echo "$token <br>";

    $userName = sanitize($_POST['userName']);
    $lastName = sanitize($_POST['lastName']);
    $firstName = sanitize($_POST['firstName']);
    $mobile = sanitize($_POST['mobile']);
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);

    // Debug: Output sanitized inputs
    // echo "Sanitized Inputs: <br>";
    // echo "UserName: $userName<br>";
    // echo "LastName: $lastName<br>";
    // echo "FirstName: $firstName<br>";
    // echo "Mobile: $mobile<br>";
    // echo "Email: $email<br>";
    // echo "Password: $password<br>";

    $token = generateToken();
    //echo "Generated Token: $token<br>"; // Debugging line

    try {
        $conn = new PDO($dsn, PARAMS['USER'], PARAMS['PASSWORD'], $pdoOptions);
        //echo "Database connected successfully.<br>"; // Debugging line

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
       // echo "Prepared statement for user check.<br>"; // Debugging line
        $stmt->execute();
        $existingUser = $stmt->fetch();
// le van kezelve akkor.
        if ($existingUser) {
            echo '<script>alert("Ez az email már foglalt!");</script>';
            echo '<script>window.location.href = "register.php";</script>';
            exit;
        }
    } catch (PDOException $e) {
        //echo "Error: " . $e->getMessage() . "<br>"; // Debugging line
        $_SESSION['errors'] = "Error: " . $e->getMessage();
        header('Location: register.php'); // nezzuk meg ezt ez is jo
        exit; // nezzuk meg ezt ez is jo
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    //echo "Hashed Password: $hashedPassword<br>"; // Debugging line ez is jo

    try {
        $stmt = $conn->prepare("INSERT INTO users (username, last_name, first_name, mobile, email, password, token, active) 
            VALUES (:username, :last_name, :first_name, :mobile, :email, :password, :token, :active)");
        $pwToken = '';
        $stmt->bindParam(':username', $userName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':active', $active);
       
        $stmt->execute();
        //echo "User registered successfully.<br>"; // Debugging line

        // Send verification email
        sendVerificationEmail($email, $token, $lastName, $firstName);
        //echo "Verification email sent.<br>"; // Debugging line

        echo '<script>alert("Regisztráció sikeres, kérlek nézd meg az emailjeid.");</script>';
        echo '<script>window.location = "index.php";</script>';
        exit; // megnezzuk ezt, ez is jo.
      
    } catch (PDOException $e) {
        //echo "Error: " . $e->getMessage() . "<br>"; // Debugging line
        $_SESSION['errors'] = "Hiba: " . $e->getMessage();
        header('Location: register.php'); // megnezzuk ezt ez is jo
        exit;   // megnezzuk ezt ez is jo
    } finally {
        $conn = null;
    }
}

function sendVerificationEmail($email, $token, $lastName, $firstName)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';

        $mail->Username = 'vtsfrizer@gmail.com';
        $mail->Password = 'uyuy ltjk rzfe mwvl';

        //Recipients
        $mail->setFrom('vtsfrizer@gmail.com', '');
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Email validation';
        $mail->Body = "Hello $lastName $firstName! Kérlek kattints a linkre a fiókod aktiváláshoz! :
      https://kv.stud.vts.su.ac.rs/BarBerMaster/activate.php?token=" . $token;

        $mail->send();
        //echo "Verification email has been sent.<br>"; // Debugging line
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo, "<br>";
    }
}
