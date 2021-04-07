<?php
// Starting Session
session_start();
// Importing User.php
require $_SERVER["DOCUMENT_ROOT"] . '/LibraryManagementSystem/User.php';
// Instantiating User
$User = new User();
// Starting Output Buffer
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link rel="stylesheet" href="http://stormysystem.ddns.net/LibraryManagementSystem/Stylesheets/AdminUserManagement.css" />
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
            <div id="searchBar"></div>
            <div id="logout"></div>
        </div>
    </nav>
    <div id="searchResults">
        <?php
        if (isset($_GET["search"])) {
            // Calling Search method.
            $User->search();
            if (isset($_POST['ban'])) {
                // Calling Freeze Membership method.
                $User->freezeMembership();
            } else if (isset($_POST['unban'])) {
                // Calling Unfreeze Membership method.
                $User->unfreezeMembership();
            } else if (isset($_POST['promote'])) {
                // Calling Promote method
                $User->promote();
            }
        }
        ?>
    </div>
    <!-- CDN Scripts for React.JS -->
    <script crossorigin src="https://unpkg.com/react@17/umd/react.production.min.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js"></script>
    <!-- User Management's script -->
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/AdminUserManagement.js"></script>
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