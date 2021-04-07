<?php
// Starting session.
session_start();
// Importing User.php.
require $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/User.php';
// Instantiating User
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
    <link rel="stylesheet" href="http://stormysystem.ddns.net/LibraryManagementSystem/Stylesheets/AdminEditProfile.css" />
    <link rel="shortcut icon" href="http://stormysystem.ddns.net/LibraryManagementSystem/Images/Logo.ico" type="image/x-icon" />
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/Font-Awesome.js"></script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <div id="homepageSection"></div>
        <div id="navigationBarComponents">
            <div id="profile">
                <a href="../">
                    <?php
                    // Calling Profile Icon method
                    $User->profileIcon();
                    ?>
                </a>
            </div>
            <div id="logout">
                <a href="http://stormysystem.ddns.net/LibrarySystem/Admin/Logout">
                    <i class="fa fa-sign-out faLogoutCustom"></i>
                </a>
            </div>
        </div>
    </nav>
    <div id="information">
        <form method="post" enctype="multipart/form-data">
            <div id="formHeader"></div>
            <div id="mail">
                <div id="mailHeader"></div>
                <div id="contents">
                    <div id="UserGetMailAddress">
                        <?php
                        // Printing the value from the accessor method for Mail Address.
                        echo $User->getMailAddress();
                        ?>
                    </div>
                    <div id="mailGuide"></div>
                </div>
            </div>
            <div id="accountId">
                <div id="accountHeader"></div>
                <div id="contents">
                    <div id="UserGetId">
                        <?php
                        // Printing the value from the accessor method for ID.
                        echo $User->getId();
                        ?>
                    </div>
                    <div id="accountIdGuide"></div>
                </div>
            </div>
            <div id="type">
                <div id="typeHeader"></div>
                <div id="contents">
                    <div id="UserGetType">
                        <?php
                        // Printing the value returned from Profile Type Checker method
                        echo $User->profileTypeChecker();
                        ?>
                    </div>
                    <div id="typeGuide"></div>
                </div>
            </div>
            <div id="password"></div>
            <div id="profilePicture">
                <div id="profilePictureHeader"></div>
                <div id="contents">
                    <button class="fa fa-upload faUploadCustom"></button>
                    <input type="file" name="image" accept="image/*" id="oldUploadButton" required />
                    <div id="profilePictureGuide"></div>
                </div>
            </div>
            <div id="edit"></div>
        </form>
    </div>
    <?php
    // It verifies if the Edit Button was pressed and in the condition that it was pressed, it will call the Change Profile Picture and Change Password functions.
    if (isset($_POST['edit'])) {
        $User->changeProfilePicture();
        $User->changePassword();
    }
    ?>
    <!-- CDN Scripts for React.JS -->
    <script crossorigin src="https://unpkg.com/react@17/umd/react.production.min.js" ></script>
    <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js" ></script>
    <!-- Profile's script -->
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/AdminEditProfile.js"></script>
</body>
</html>
<?php
// Storing the contents of the output buffer into a variable
$html = ob_get_contents();
// Deleting the contents of the output buffer.
ob_end_clean();
// Printing the html page
echo $html;
?>