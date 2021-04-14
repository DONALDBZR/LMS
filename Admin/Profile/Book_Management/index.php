<?php
// Starting Session
session_start();
// Importing Book.php
require_once $_SERVER["DOCUMENT_ROOT"] . "/LibrarySystem/Book.php";
// Importing User.php
require $_SERVER["DOCUMENT_ROOT"] . "/LibrarySystem/User.php";
// Instantiating Book
$Book = new Book();
// Instantiating User
$User = new User();
// Statrting Output Buffer
ob_start();
?>
<!-- Front-End page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link rel="stylesheet" href="http://stormysystem.ddns.net/LibrarySystem/Stylesheets/AdminBookManagement.css" />
    <link rel="shortcut icon" href="http://stormysystem.ddns.net/LibrarySystem/Images/Logo.ico" type="image/x-icon" />
    <script src="http://stormysystem.ddns.net/LibrarySystem/Scripts/Font-Awesome.js"></script>
    <script src="http://stormysystem.ddns.net/LibrarySystem/Scripts/AdminBookManagementMain.js"></script>
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
    <!-- Book Management -->
    <div id="bookManagement">
        <h1>
            Book Management
        </h1>
        <p>
            In order to manage the books, you will need to use the buttons to be able to manage the books but you will actually need to search to see if the book exists in the database.
        </p>
        <div id="searchBar"></div>
        <div id="searchResults">
            <?php
            // If-statement verifying if, the Search button was pressed.
            if (isset($_GET["search"])) {
                // Calling Admin Search function
                $Book->adminSearch();
                // If-statement verifying if, any button was pressed.
                if (isset($_POST["addBook"])) {
                    // Calling Add Book method
                    $Book->addBook();
                } else if (isset($_POST["updateBook"])) {
                    // Calling Update Book method
                    $Book->updateBook();
                } else if (isset($_POST["removeBook"])) {
                    // Calling Remove Book method
                    $Book->removeBook();
                }
            }
            ?>
        </div>
        <div id='addForm'></div>
        <div id="updateForm"></div>
    </div>
    <!-- CDN Scripts for React.JS -->
    <script crossorigin src="https://unpkg.com/react@17/umd/react.production.min.js" ></script>
    <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js" ></script>
    <!-- Profile's script -->
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/AdminBookManagement.js"></script>
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