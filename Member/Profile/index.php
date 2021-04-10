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
    <link rel="stylesheet" href="http://stormysystem.ddns.net/LibraryManagementSystem/Stylesheets/MemberProfile.css" />
    <link rel="shortcut icon" href="http://stormysystem.ddns.net/LibraryManagementSystem/Images/Logo.ico" type="image/x-icon" />
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/Font-Awesome.js"></script>
    <title>Library System</title>
</head>
<body>
    <nav>
        <div id="homepageSection"></div>
        <div id='navigationBarComponents'>
            <div id="profile">
                <a href="./">
                    <?php
                    $User = new User();
                    $User->profileIcon();
                    ?>
                </a>
            </div>
            <div id="logout">
                <a href="../Logout">
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
    <div id="actions"></div>
    <div id="information">
        <div id="profilePicture">
            <div id="profilePictureLabel"></div>
            <div id="detail">
                <?php
                $User->profileIcon();
                ?>
            </div>
        </div>
        <div id="mailAddress">
            <div id="mailAddressLabel"></div>
            <div id="detail">
                <?php
                echo $User->getMailAddress();
                ?>
            </div>
        </div>
        <div id="type">
            <div id="typeLabel"></div>
            <div id="detail">
                <?php
                $User->profileTypeChecker();
                ?>
            </div>
        </div>
    </div>
    <!-- CDN Scripts for React.JS -->
    <script crossorigin src="https://unpkg.com/react@17/umd/react.production.min.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js"></script>
    <!-- Login's script -->
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/MemberProfile.js"></script>
</body>
</html>