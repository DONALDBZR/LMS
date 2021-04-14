<?php
// Starting session
session_start();
// Importing User.php
require $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/User.php';
// Importing Book.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/Book.php';
// Importing Loan.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/Loan.php';
// Instantiating User
$User = new User();
// Instantiating Book
$Book = new Book();
// Instantiating Loan
$Loan = new Loan();
// Statrting Output Buffer
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/Font-Awesome.js"></script>
    <link rel="stylesheet" href="http://stormysystem.ddns.net/LibraryManagementSystem/Stylesheets/MemberBorrowedBooks.css" />
    <link rel="shortcut icon" href="http://stormysystem.ddns.net/LibraryManagementSystem/Images/Logo.ico" type="image/x-icon" />
    <title>Library System</title>
</head>
<body>
    <nav>
        <div id='homepageSection'></div>
        <div id='navigationBarComponents'>
            <div id="profile">
                <a href="../">
                    <?php
                    // Calling Profile Icon method
                    $User->profileIcon();
                    ?>
                </a>
            </div>
            <div id="logout"></div>
        </div>
    </nav>
    <div id="reservationList">
        <?php
        // Calling View Borrowed Book function
        $Loan->viewBorrowedBook();
        ?>
    </div>
    <!-- CDN Scripts for React.JS -->
    <script crossorigin src="https://unpkg.com/react@17/umd/react.production.min.js" ></script>
    <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js" ></script>
    <!-- Borrowed Book's script -->
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/MemberBorrowedBooks.js"></script>
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