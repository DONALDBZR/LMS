<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/API.php';
class Book {
    // Class variables
    private int $isbn;
    private int $stock;
    private string $author;
    private string $title;
    private string $publisher;
    private string $cover;
    private string $bookLocation;
    private int $state;
    private string $category;
    protected $API;
    // Constructor method
    public function __construct() {
        $this->API = new API();
    }
    // ISBN accessor method
    public function getIsbn() {
        return $this->isbn;
    }
    // Stock accessor method
    public function getStock() {
        return $this->stock;
    }
    // Author accessor method
    public function getAuthor() {
        return $this->author;
    }
    // Title accessor method
    public function getTitle() {
        return $this->title;
    }
    // Publisher accessor method
    public function getPublisher() {
        return $this->publisher;
    }
    // Cover accessor method
    public function getCover() {
        return $this->cover;
    }
    // Book Location accessor method
    public function getBookLocation() {
        return $this->bookLocation;
    }
    // State accessor method
    public function getState() {
        return $this->state;
    }
    // Category accessor method
    public function getCategory() {
        return $this->category;
    }
    // ISBN mutator method
    public function setIsbn($isbn) {
        $this->isbn = $isbn;
    }
    // Stock mutator method
    public function setStock($stock) {
        $this->stock = $stock;
    }
    // Author mutator method
    public function setAuthor($author) {
        $this->author = $author;
    }
    // Title mutator method
    public function setTitle($title) {
        $this->title = $title;
    }
    // Publisher mutator method
    public function setPublisher($publisher) {
        $this->publisher = $publisher;
    }
    // Cover mutator method
    public function setCover($cover) {
        $this->cover = $cover;
    }
    // Book Location mutator method
    public function setBookLocation($bookLocation) {
        $this->bookLocation = $bookLocation;
    }
    // State mutator method
    public function setState($state) {
        $this->state = $state;
    }
    // Category mutator method
    public function setCategory($category) {
        $this->category = $category;
    }
    // Search Books method
    public function searchBooks() {
        // Preparing the query to return fields from the value entered that are already in the database.
        $this->API->query("SELECT * FROM LibrarySystem.Book WHERE BookState = :BookState AND BookIsbn LIKE :BookIsbn OR BookTitle LIKE :BookTitle OR BookAuthor LIKE :BookAuthor OR BookPublisher LIKE :BookPublisher OR BookCategory LIKE :BookCategory");
        // Binding the values returned by the search bar for security purposes.
        $this->API->bind(":BookIsbn", "%{$_GET["search"]}%");
        $this->API->bind(":BookTitle", "%{$_GET["search"]}%");
        $this->API->bind(":BookAuthor", "%{$_GET["search"]}%");
        $this->API->bind(":BookPublisher", "%{$_GET["search"]}%");
        $this->API->bind(":BookCategory", "%{$_GET["search"]}%");
        $this->API->bind(":BookState", 1);
        // Executing the query.
        $this->API->execute();
        // If-statement verifying whether values are returned from the query
        if (empty($this->API->resultSet())) {
            echo "
            <h1 id='failure'>
                No results found for : {$_GET['search']}
            </h1>";
        } else {
            // Storing the value of the amount found
            $amountFound = count($this->API->resultSet());
            echo "
            <div id='amountFound'>
                Amount Found: {$amountFound}
            </div>";
            foreach ($this->API->resultSet() as $result) {
                $cover = "http://stormysystem.ddns.net" . $result['BookCover'];
                echo "
                <div id='found'>
                    <div id='left'>
                        <img src='{$cover}' />
                    </div>
                    <div id='right'>
                        <div id='foundIsbn'>
                            <h1>
                                ISBN:
                            </h1>
                            <h1>
                                {$result['BookIsbn']}
                            </h1>
                        </div>
                        <div id='foundStock'>
                            <h1>
                                Stock:
                            </h1>
                            <h1>
                                {$result['BookStock']}
                            </h1>
                        </div>
                        <div id='foundAuthor'>
                            <h1>
                                Author:
                            </h1>
                            <h1>
                                {$result['BookAuthor']}
                            </h1>
                        </div>
                        <div id='foundTitle'>
                            <h1>
                                Title:
                            </h1>
                            <h1>
                                {$result['BookTitle']}
                            </h1>
                        </div>
                        <div id='foundPublisher'>
                            <h1>
                                Publisher:
                            </h1>
                            <h1>
                                {$result['BookPublisher']}
                            </h1>
                        </div>
                        <div id='foundBookLocation'>
                            <h1>
                                Book Location:
                            </h1>
                            <h1>
                                {$result['BookBookLocation']}
                            </h1>
                        </div>
                        <div id='foundCategory'>
                            <h1>
                                Category:
                            </h1>
                            <h1>
                                {$result['BookCategory']}
                            </h1>
                        </div>
                        <div id='actions'>
                            <form method='post'>
                                <div id='borrow'>
                                    <input type='submit' value='Borrow' id='borrowButton {$result['BookIsbn']}' name='borrowBook' onClick='borrowBookCookie(this.id)' />
                                </div>
                                <div id='reserve'>
                                    <input type='submit' value='Reserve' id='reserveButton {$result['BookIsbn']}' name='reserveBook' onClick='reserveBookCookie(this.id)' />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>";
            }
        }
    }
    // Change Cover method
    public function changeCover() {
        // Storing the image directory
        $imageDirectory = "/LibraryManagementSystem/Images/";
        // The path of the image file in the server
        $imageFile = $imageDirectory . basename($_FILES['image']['name']);
        // The uploaded path of the image file in the server
        $uploadedPath = $_SERVER["DOCUMENT_ROOT"] . $imageFile;
        // Verifying if the picture will actually be uploaded in the Uploaded Path.
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadedPath)) {
            // Assigning the path of the image file as the Cover's mutator.
            $this->setCover($imageFile);
            // Preparing the query to insert the book inside the database.
            $this->API->query("UPDATE LibrarySystem.Book SET BookCover = :BookCover WHERE BookIsbn = :BookIsbn");
            // Binding all the values that are going to be updated in the database for security purposes.
            $this->API->bind(":BookCover", $this->getCover());
            $this->API->bind(":BookIsbn", $this->getIsbn());
            // Executing the query.
            $this->API->execute();
        }
    }
    // Remove Book method
    public function removeBook() {
        // Assigning the value returned from the Cookie as the mutator for Book.isbn
        $this->setIsbn($_COOKIE["isbn"]);
        // Preparing query
        $this->API->query("DELETE FROM LibrarySystem.Book WHERE BookIsbn = :BookIsbn");
        // Binding the values for security purposes
        $this->API->bind(":BookIsbn", $this->getIsbn());
        // Executing query
        $this->API->execute();
        // If-statement to verify if, the Execute method is called successfully!
        if (!$this->API->execute() == true) {
            echo "
            <h1 id='failure'>
                The book cannot be removed due to error!  Error: {$this->API->errorInfo()}
            </h1>";
            header("refresh: 1; url=http://stormysystem.ddns.net/LibraryManagementSystem/Admin/Profile/Book_Management");
        } else {
            echo "
            <h1 id='success'>
                Book has been removed from the system!
            </h1>";
            header("refresh: 1; url=http://stormysystem.ddns.net/LibraryManagementSystem/Admin/Profile/Book_Management");
        }
    }
    // Add Book method
    public function addBook() {
        // Assigning the ISBN's POST value as a parameter for the mutator for ISBN.
        $this->setIsbn((int)$_POST['inputAddIsbn']);
        // Assigning the Stock's POST value as a parameter for the mutator for Stock.
        $this->setStock((int)$_POST['inputAddStock']);
        // Assigning the Author's POST value as a parameter for the mutator for Author.
        $this->setAuthor($_POST['inputAddAuthor']);
        // Assigning the Publisher's POST value as a parameter for the mutator for Publisher.
        $this->setPublisher($_POST['inputAddPublisher']);
        // Assigning the Book Location's POST value as a parameter for the mutator for Book Location.
        $this->setBookLocation($_POST['inputAddBookLocation']);
        // Assigning the Category's POST value as a parameter for the mutator for Category.
        $this->setCategory($_POST['inputAddCategory']);
        // Assigning the Title's POST value as a parameter for the mutator for Title.
        $this->setTitle($_POST['inputAddTitle']);
        // Assigning 1 as a parameter for the mutator for State.
        $this->setState(1);
        // Storing the image directory
        $imageDirectory = "/LibraryManagementSystem/Images/";
        // The path of the image file in the server
        $imageFile = $imageDirectory . basename($_FILES['image']['name']);
        // The uploaded path of the image file in the server.
        $uploadedPath = $_SERVER["DOCUMENT_ROOT"] . $imageFile;
        // Verifying if the picture will actually be uploaded in the Uploaded Path.
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedPath)) {
            // Assigning the path of the image file as the Cover's mutator.
            $this->setCover($imageFile);
            // Preparing the query to insert the book inside the database.
            $this->API->query("INSERT INTO LibrarySystem.Book (BookIsbn, BookStock, BookAuthor, BookTitle, BookPublisher, BookCover, BookBookLocation, BookState, BookCategory) VALUES (:BookIsbn, :BookStock, :BookAuthor, :BookTitle, :BookPublisher, :BookCover, :BookBookLocation, :BookState, :BookCategory)");
            // Binding all the values that are going to be inserted in the database for security purposes.
            $this->API->bind(":BookIsbn", $this->getIsbn());
            $this->API->bind(":BookStock", $this->getStock());
            $this->API->bind(":BookAuthor", $this->getAuthor());
            $this->API->bind(":BookTitle", $this->getTitle());
            $this->API->bind(":BookPublisher", $this->getPublisher());
            $this->API->bind(":BookCover", $this->getCover());
            $this->API->bind(":BookBookLocation", $this->getBookLocation());
            $this->API->bind(":BookState", $this->getState());
            $this->API->bind(":BookCategory", $this->getCategory());
            // Executing the query.
            $this->API->execute();
            echo "
            <h1 id='success'>
                {$this->getTitle()} has been added!
            </h1>";
            header("refresh: 3.2; url=http://stormysystem.ddns.net/LibraryManagementSystem/Admin/Profile/Book_Management");
        }
    }
    // Update Book method
    public function updateBook() {
        // Assigning Post's Update Isbn value as Isbn's mutator.
        $this->setIsbn((int)$_POST['inputUpdateIsbn']);
        // Assigning Post's Update Stock value as Stock's mutator.
        $this->setStock((int)$_POST['inputUpdateStock']);
        // Assigning Post's Update Author value as Author's mutator.
        $this->setAuthor($_POST['inputUpdateAuthor']);
        // Assigning Post's Update Title value as Title's mutator.
        $this->setTitle($_POST['inputUpdateTitle']);
        // Assigning Post's Update Publisher value as Publisher's mutator.
        $this->setPublisher($_POST['inputUpdatePublisher']);
        // Assigning Post's Update Category value as Category's mutator.
        $this->setCategory($_POST['inputUpdateCategory']);
        // Assigning Post's Update Book Location value as Book Location's mutator.
        $this->setBookLocation($_POST['inputUpdateBookLocation']);
        // Storing Post's Update State value to be verified.
        $postState = $_POST['inputUpdateState'];
        // If-statement to verify the value of Post State
        if ($postState == "damaged" && $this->getStock() > 0) {
            $this->setState(1);
            $newStock = $this->getStock() - 1;
            $this->setStock($newStock);
        } else if ($postState == "damaged" && $this->getStock() == 0) {
            $this->setState(0);
        } else if ($postState == "not-damaged") {
            $this->setState(1);
        } else {
            $this->setState($this->getState());
        }
        // Preparing query
        $this->API->query("UPDATE LibrarySystem.Book SET BookStock = :BookStock, BookAuthor = :BookAuthor, BookTitle = :BookTitle, BookPublisher = :BookPublisher, BookBookLocation = :BookBookLocation, BookState = :BookState, BookCategory = :BookCategory WHERE BookIsbn = :BookIsbn");
        // Binding all the values for security purposes.
        $this->API->bind(":BookIsbn", $this->getIsbn());
        $this->API->bind(":BookTitle", $this->getTitle());
        $this->API->bind(":BookAuthor", $this->getAuthor());
        $this->API->bind(":BookPublisher", $this->getPublisher());
        $this->API->bind(":BookBookLocation", $this->getBookLocation());
        $this->API->bind(":BookStock", $this->getStock());
        $this->API->bind(":BookState", $this->getState());
        $this->API->bind(":BookCategory", $this->getCategory());
        // Executing the query
        $this->API->execute();
        // Calling Change Cover method
        $this->changeCover();
        echo "
        <h1 id='success'>
            {$this->getTitle()} has been updated!
        </h1>";
        header("refresh: 2.8; url=http://stormysystem.ddns.net/LibraryManagementSystem/Admin/Profile/Book_Management");
    }
    // Admin Search method
    public function adminSearch() {
        // Preparing the query to return fields from the value entered that are already in the database.
        $this->API->query("SELECT * FROM LibrarySystem.Book WHERE BookIsbn = :BookIsbn OR BookTitle = :BookTitle OR BookAuthor = :BookAuthor OR BookPublisher = :BookPublisher OR BookCategory = :BookCategory");
        // Binding the values returned by the search bar for security purposes.
        $this->API->bind(":BookIsbn", $_GET["search"]);
        $this->API->bind(":BookTitle", $_GET["search"]);
        $this->API->bind(":BookAuthor", $_GET["search"]);
        $this->API->bind(":BookPublisher", $_GET["search"]);
        $this->API->bind(":BookCategory", $_GET["search"]);
        // Executing the query.
        $this->API->execute();
        // Storing the HTML elements neeeded
        $nothingFound = "
        <h1 id='failure'>
            {$_GET['search']} does not exist!
        </h1>
        <div id='addFormButton'>
            <button id='formAddButton' onClick='showForm(this.id)'>
                Add
            </button>
        </div>";
        // If-statement that will verify that the value entered is in the database or not.
        if (empty($this->API->resultSet())) {
            echo $nothingFound;
        } else {
            // Storing the value of the amount found.
            $amountFound = count($this->API->resultSet());
            // Displaying the amount of results found.
            echo "
            <div id='amountFound'>
                Amount Found: {$amountFound}
            </div>";
            foreach ($this->API->resultSet() as $result) {
                $cover = "http://stormysystem.ddns.net" . $result['BookCover'];
                echo "
                <div id='found'>
                    <div id='left'>
                        <img src='{$cover}' />
                    </div>
                    <div id='right'>
                        <div id='foundIsbn'>
                            <h1>
                                ISBN:
                            </h1>
                            <h1>
                                {$result['BookIsbn']}
                            </h1>
                        </div>
                        <div id='foundStock'>
                            <h1>
                                Stock:
                            </h1>
                            <h1>
                                {$result['BookStock']}
                            </h1>
                        </div>
                        <div id='foundAuthor'>
                            <h1>
                                Author:
                            </h1>
                            <h1>
                                {$result['BookAuthor']}
                            </h1>
                        </div>
                        <div id='foundTitle'>
                            <h1>
                                Title:
                            </h1>
                            <h1>
                                {$result['BookTitle']}
                            </h1>
                        </div>
                        <div id='foundPublisher'>
                            <h1>
                                Publisher:
                            </h1>
                            <h1>
                                {$result['BookPublisher']}
                            </h1>
                        </div>
                        <div id='foundBookLocation'>
                            <h1>
                                Book Location:
                            </h1>
                            <h1>
                                {$result['BookBookLocation']}
                            </h1>
                        </div>
                        <div id='foundState'>
                            <h1>
                                State:
                            </h1>
                            <h1>
                                {$result['BookState']}
                            </h1>
                        </div>
                        <div id='foundCategory'>
                            <h1>
                                Category:
                            </h1>
                            <h1>
                                {$result['BookCategory']}
                            </h1>
                        </div>
                        <div id='actions'>
                            <div id='updateFormButton'>
                                <button id='formUpdateButton' onClick='showForm(this.id)'>
                                    Update
                                </button>
                            </div>
                            <div id='removeFormButton'>
                                <form method='post'>
                                    <input type='submit' value='Remove' id='removeButton {$result['BookIsbn']}' name='removeBook' onClick='requestServerAttention(this.id)' />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                ";
            }
        }
    }
}
?>