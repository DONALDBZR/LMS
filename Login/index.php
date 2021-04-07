<?php
// Importing User.php
require $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/User.php';
// Instantiating User.php
$User = new User();
?>
<!-- Front-End Page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link rel="stylesheet" href="../Stylesheets/Login.css" />
    <link rel="shortcut icon" href="../Images/Logo.ico" type="image/x-icon" />
</head>
<body>
    <!-- Header -->
    <div id="header"></div>
    <!-- Section -->
    <section>
        <div id="left">
            <img src="../Images/Education.png" />
        </div>
        <div id="right">
            <div id="loginMessage"></div>
            <div id="loginNotice"></div>
            <div id="form"></div>
            <div id="loginReset"></div>
            <?php
            // Calling login function from User class if the login button is pressed.
            if (isset($_POST['login'])) {
                $User->login();
            }
            ?>
        </div>
    </section>
    <!-- CDN Scripts for React.JS -->
    <script crossorigin src="https://unpkg.com/react@17/umd/react.production.min.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js"></script>
    <!-- Login's script -->
    <script src="../Scripts/Login.js"></script>
</body>
</html>