<?php
// Starting Session
session_start();
// Importing Book.php
require_once $_SERVER["DOCUMENT_ROOT"] . "/LibraryManagementSystem/Book.php";
// Importing User.php
require_once $_SERVER["DOCUMENT_ROOT"] . "/LibraryManagementSystem/User.php";
// Importing Loan.php
require_once $_SERVER["DOCUMENT_ROOT"] . "/LibraryManagementSystem/Loan.php";
// Instantiating Book
$Book = new Book();
// Instantiating User
$User = new User();
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
    <title>Library System</title>
    <link rel="stylesheet" href="http://stormysystem.ddns.net/LibraryManagementSystem/Stylesheets/AdminLoanManagement.css" />
    <link rel="shortcut icon" href="http://stormysystem.ddns.net/LibraryManagementSystem/Images/Logo.ico" type="image/x-icon" />
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/Font-Awesome.js"></script>
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/AdminLoanManagementMain.js"></script>
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
            <div id="logout"></div>
        </div>
    </nav>
    <!-- Loan Management -->
    <div id="loanManagement">
        <h1>
            Loan Management
        </h1>
        <p>
            In order to manage the loans, you will need to search for the loan that was recorded in the system.
        </p>
        <div id="searchBar">
            <form method="get">
                <div id="personBook">
                    <div id="person">
                        <h1 id="contents">
                            User's Mail:
                        </h1>
                        <input type="email" name="person" id="searchPerson" placeholder="User's Mail" required />
                    </div>
                    <div id="book">
                        <h1 id="contents">
                            Book's Title:
                        </h1>
                        <input type="text" name="book" id="searchBook" placeholder="Book's Title" required />
                    </div>
                </div>
                <div id="search">
                    <input type="submit" name="search" value="Search" id="searchButton" />
                </div>
            </form>
        </div>
        <div id="searchResults">
            <?php
            // If-statement to verify whether the search button is pressed.
            if (isset($_GET["search"])) {
                // Calling Search function
                $Loan->search();
                // If-statement to verify whether the record return button is pressed.
                if (isset($_POST["recordReturn"])) {
                    // Calling Record Return method
                    $Loan->recordReturn();
                }
            }
            ?>
        </div>
    </div>
    <!-- CDN Scripts for React.JS -->
    <script crossorigin src="https://unpkg.com/react@17/umd/react.production.min.js" ></script>
    <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js" ></script>
    <!-- Admin Loan Management's script -->
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/AdminLoanManagement.js"></script>
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