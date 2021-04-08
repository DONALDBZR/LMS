<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/User.php';
$User = new User();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Stylesheets/AdminHomepage.css">
    <link rel="shortcut icon" href="../Images/Logo.ico" type="image/x-icon">
    <script src="../Scripts/Font-Awesome.js"></script>
    <title>Library System</title>
</head>
<body>
<nav>
        <div id='homepageSection'>
            <a href="./">
                <img src="../Images/Logo - 1.png" alt="Homepage">
            </a>
        </div>
        <div id='navigationBarComponents'>
            <div id="profile">
                <a href="./Profile">
                    <?php
                    $User->profileIcon();
                    ?>
                </a>
            </div>
            <div id="logout">
                <a href="./Logout">
                    <i class="fa fa-sign-out faLogoutCustom"></i>
                </a>
            </div>
        </div>
    </nav>
    <?php
    print_r($_SESSION);
    ?>
</body>
</html>