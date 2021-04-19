<?php
// Starting Session
session_start();
// Importing Book.php
require_once $_SERVER["DOCUMENT_ROOT"] . "/LibraryManagementSystem/Book.php";
// Importing User.php
require_once $_SERVER["DOCUMENT_ROOT"] . "/LibraryManagementSystem/User.php";
// Importing API.php
require_once $_SERVER["DOCUMENT_ROOT"] . "/LibraryManagementSystem/User.php";
// Instantiating Book
$Book = new Book();
// Instantiating User
$User = new User();
// Instantiating API
$API = new API();
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
    <link rel="stylesheet" href="http://stormysystem.ddns.net/LibraryManagementSystem/Stylesheets/AdminBookManagement.css" />
    <link rel="shortcut icon" href="http://stormysystem.ddns.net/LibraryManagementSystem/Images/Logo.ico" type="image/x-icon" />
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/Font-Awesome.js"></script>
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/AdminBookManagementMain.js"></script>
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
        <div id='addForm'>
            <form method='post' enctype='multipart/form-data'>
                <h1>
                    Add Book
                </h1>
                <p>
                    In order to add a new book, you should fill the form below completely.
                </p>
                <div id='addIsbnStock'>
                    <div id='addIsbn'>
                        <input type='number' name='inputAddIsbn' id='inputAddIsbn' placeholder='ISBN' required />
                        <div id='addIsbnNotice'>
                            It is the International Standard Book Number which also serves as the identifier of the book.
                        </div>
                    </div>
                    <div id='addStock'>
                        <input type='number' name='inputAddStock' id='inputAddStock' placeholder='Stock' required />
                        <div id='addStockNotice'>
                            It is the amount of book copies that will be in the store in the library.
                        </div>
                    </div>
                </div>
                <div id='addAuthorTitle'>
                    <div id='addAuthor'>
                        <input type='text' name='inputAddAuthor' id='inputAddAuthor' placeholder='Author' required />
                        <div id='addAuthorNotice'>
                            The writer of the book
                        </div>
                    </div>
                    <div id='addTitle'>
                        <input type='text' name='inputAddTitle' id='inputAddTitle' placeholder='Title' required />
                        <div id='addTitleNotice'>
                            The title of the book
                        </div>
                    </div>
                </div>
                <div id='addPublisherCover'>
                    <div id='addPublisher'>
                        <input type='text' name='inputAddPublisher' id='inputAddPublisher' placeholder='Publisher' required />
                        <div id='addPublisherNotice'>
                            The publisher of the book
                        </div>
                    </div>
                    <div id='addCover'>
                        <input type='file' name='image' id='inputAddCover' accept='image/*' required />
                        <div id='addCoverNotice'>
                            The cover of the book
                        </div>
                    </div>
                </div>
                <div id='addBookLocationCategory'>
                    <div id='addBookLocation'>
                        <input type='text' name='inputAddBookLocation' id='inputAddBookLocation' placeholder='Book Location' required />
                        <div id='addBookLocationNotice'>
                            The location of the book in the library
                        </div>
                    </div>
                    <div id='addCategory'>
                        <input type='text' name='inputAddCategory' id='inputAddCategory' placeholder='Category' required />
                        <div id='addCategoryNotice'>
                            The category of the book
                        </div>
                    </div>
                </div>
                <div id='addButton'>
                    <input type='submit' value='Add Book' name='addBook' />
                </div>
            </form>
        </div>
        <div id='updateForm'>
            <form method='post' enctype='multipart/form-data'>
                <h1>
                    Update Book
                </h1>
                <p>
                    In order to update a book, you should fill the form below completely.
                </p>
                <div id='updateIsbnStock'>
                    <div id='updateIsbn'>
                        <input type='number' name='inputUpdateIsbn' id='inputUpdateIsbn' placeholder='ISBN' required />
                        <div id='updateIsbnNotice'>
                            It is the International Standard Book Number which also serves as the identifier of the book.
                        </div>
                    </div>
                    <div id='updateStock'>
                        <input type='number' name='inputUpdateStock' id='inputUpdateStock' placeholder='Stock' required />
                        <div id='updateStockNotice'>
                            It is the amount of book copies that will be in the store in the library.
                        </div>
                    </div>
                </div>
                <div id='updateAuthorTitle'>
                    <div id='updateAuthor'>
                        <input type='text' name='inputUpdateAuthor' id='inputUpdateAuthor' placeholder='Author' required />
                        <div id='updateAuthorNotice'>
                            The writer of the book
                        </div>
                    </div>
                    <div id='updateTitle'>
                        <input type='text' name='inputUpdateTitle' id='inputUpdateTitle' placeholder='Title' required />
                        <div id='updateTitleNotice'>
                            The title of the book
                        </div>
                    </div>
                </div>
                <div id='updatePublisherCover'>
                    <div id='updatePublisher'>
                        <input type='text' name='inputUpdatePublisher' id='inputUpdatePublisher' placeholder='Publisher' required />
                        <div id='updatePublisherNotice'>
                            The publisher of the book
                        </div>
                    </div>
                    <div id='updateCover'>
                        <input type='file' name='image' id='inputUpdateCover' accept='image/*' required />
                        <div id='updateCoverNotice'>
                            The cover of the book
                        </div>
                    </div>
                </div>
                <div id='updateBookLocationCategory'>
                    <div id='updateBookLocation'>
                        <input type='text' name='inputUpdateBookLocation' id='inputUpdateBookLocation' placeholder='Book Location' required />
                        <div id='updateBookLocationNotice'>
                            The location of the book in the library
                        </div>
                    </div>
                    <div id='updateCategory'>
                        <input type='text' name='inputUpdateCategory' id='inputUpdateCategory' placeholder='Category' required />
                        <div id='updateCategoryNotice'>
                            The category of the book
                        </div>
                    </div>
                </div>
                <div id='updateState'>
                    <label for='inputUpdateState'>
                        What is the state of the book:
                    </label>
                    <select name='inputUpdateState' id='inputUpdateState'>
                        <option value='damaged'>
                            Damaged
                        </option>
                        <option value='not-damaged'>
                            Not-Damaged
                        </option>
                    </select>
                    <div id='updateStateNotice'>
                        The state of the book
                    </div>
                </div>
                <div id='updateButton'>
                    <input type='submit' value='Update Book' name='updateBook' />
                </div>
            </form>
        </div>
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