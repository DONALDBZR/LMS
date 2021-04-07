<?php
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
    <link rel="stylesheet" href="../Stylesheets/ResetPassword.css" />
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
            <div id="resetPasswordMessage"></div>
            <div id="resetPasswordNotice"></div>
            <div id="form"></div>
            <?php
            // Calling Reset Password function from User class if the Reset Password button is pressed.
            if (isset($_POST['resetPassword'])) {
                $User->forgotPassword();
            }
            ?>
        </div>
    </section>
    <!-- CDN Scripts for React.JS -->
    <script crossorigin src="https://unpkg.com/react@17/umd/react.production.min.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js"></script>
    <!-- Login's script -->
    <script src="../Scripts/ResetPassword.js"></script>
</body>
</html>