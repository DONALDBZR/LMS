<?php
// Starting session.
session_start();
// Importing User.php.
require $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/User.php';
// Instantiating User
$User = new User();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link rel="stylesheet" href="http://stormysystem.ddns.net/LibraryManagementSystem/Stylesheets/AdminProfile.css" />
    <link rel="shortcut icon" href="http://stormysystem.ddns.net/LibraryManagementSystem/Images/Logo.ico" type="image/x-icon" />
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/Font-Awesome.js"></script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <div id="homepageSection"></div>
        <div id="navigationBarComponents">
            <div id="profile">
                <a href="./">
                    <?php
                    // Calling Profile Icon method
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
    <div id="activities"></div>
    <div id="information">
        <div id="profilePicture">
            <div>
                <h1>
                    Profile Picture: 
                </h1>
            </div>
            <div id="detail">
                <?php
                // Calling Profile Icon method
                $User->profileIcon();
                ?>
            </div>
        </div>
        <div id="mailAddress">
            <div>
                <h1>
                    Mail Address: 
                </h1>
            </div>
            <div id="detail">
                <?php
                // Printing the value from the accessor method for mail.
                echo $User->getMailAddress();
                ?>
            </div>
        </div>
        <div id="type">
            <div>
                <h1>
                    Account Type:
                </h1>
            </div>
            <div id="detail">
                <?php
                // Calling Profile Type Checker method
                $User->profileTypeChecker();
                ?>
            </div>
        </div>
    </div>
    <!-- CDN Scripts for React.JS -->
    <script crossorigin src="https://unpkg.com/react@17/umd/react.production.min.js" ></script>
    <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js" ></script>
    <!-- Profile's script -->
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/AdminProfile.js"></script>
</body>
</html>