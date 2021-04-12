<?php
// Starting session
session_start();
// Importing User.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/User.php';
// Importing Book.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/Book.php';
// Importing Reservation.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/Reservation.php';
// Importing Loan.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/Loan.php';
// Instantiating User
$User = new User();
// Instantiating Book
$Book = new Book();
// Instantiating Reservation
$Reservation = new Reservation();
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
    <script src="../Scripts/Font-Awesome.js"></script>
    <link rel="stylesheet" href="../Stylesheets/MemberHomepage.css" />
    <link rel="shortcut icon" href="../Images/Logo.ico" type="image/x-icon" />
    <title>Library System</title>
    <script src="../Scripts/MemberHomepageMain.js"></script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <div id='homepageSection'></div>
        <div id='navigationBarComponents'>
            <div id="profile">
                <a href="./Profile">
                    <?php
                    // Calling Profile Icon method
                    $User->profileIcon();
                    ?>
                </a>
            </div>
            <form method="get">
                <input type="text" name="search" placeholder="Search..." />
                <button type="submit" class="fa fa-search faSearch">
                </button>
            </form>
            <div id="logout"></div>
        </div>
    </nav>
    <div id="welcomeText">
        <?php
        // Calling Profile Mail method
        $User->profileMail();
        ?>
    </div>
    <div id="message1">
        If, you want to borrow or reserve a book, please use the search bar to look to the book.
    </div>
    <div id="message2">
        If, you want to access the list of the books that you have borrowed or reserved, please head to the profile page.
    </div>
    <div id="searchResults">
        <?php
        // If-statement to verify whether the search button is pressed
        if (isset($_GET["search"])) {
            // Calling Search Books function
            $Book->searchBooks();
            // If-statement to verify whether the reserve button is pressed.
            if (isset($_POST["reserveBook"])) {
                // Calling Reserve Book function
                $Reservation->reserveBook();
            } else if (isset($_POST["borrowBook"])) {
                // Calling Borrow Book function
                $Loan->borrowBook();
            }
        }
        ?>
    </div>
    <!-- CDN Scripts for React.JS -->
    <script crossorigin src="https://unpkg.com/react@17/umd/react.production.min.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js"></script>
    <!-- Member Homepage's script -->
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/MemberHomepage.js"></script>
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