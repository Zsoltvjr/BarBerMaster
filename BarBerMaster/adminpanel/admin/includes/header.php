<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/ollo.jpg">
  <title>
   Admin 
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- CSS Files -->
  <link id="pagestyle" href="assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />

  <script>
        function validateForm() {
            var password = document.getElementById('password').value;

            if (password.length < 8 && !/\d/.test(password)) {
                alert("Password must contain 8 characters and a number!");
                document.getElementById('password').value = '';
                return false; // Prevent form submission
            } else if (password.length < 8) {
                alert("Password must contain 8 characters!");
                document.getElementById('password').value = '';
                return false; // Prevent form submission
            } else if (!/\d/.test(password)) {
                alert("Password must contain a number!");
                document.getElementById('password').value = '';
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }

        function goBack() {
            window.location.href = 'index.php';
        }
    </script>


  
</head>

<body class="g-sidenav-show  bg-gray-100">
    <?php  include ('sidebar.php')          ?>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

    <?php  include ('navbar.php')          ?>

    <div class="container-fluid py-4">

