<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/User.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../Scripts/Font-Awesome.js"></script>
    <link rel="stylesheet" href="../Stylesheets/MemberHomepage.css">
    <link rel="shortcut icon" href="../Images/Logo.ico" type="image/x-icon">
    <title>Library System</title>
</head>
<body>
    <nav>
        <div id='homepageSection'>
            <a href="../Member">
                <img src="../Images/Logo - 1.png" alt="Homepage">
            </a>
        </div>
        <div id='navigationBarComponents'>
            <div id="profile">
                <a href="./Profile">
                    <?php
                    $User = new User();
                    $User->profileIcon();
                    ?>
                </a>
            </div>
            <form action="" method="get">
                <input type="text" placeholder="Search..">
                <button class="fa fa-search faCustom">
                </button>
            </form>
            <div id="logout">
                <a href="./Logout">
                    <i class="fa fa-sign-out faLogoutCustom"></i>
                </a>
            </div>
        </div>
    </nav>
    <div id="welcomeText">
        <?php
        $User->profileMail();
        ?>
    </div>
    <?php
    print_r($_SESSION);
    ?>
</body>
</html>