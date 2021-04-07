<?php
require $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/API.php';
class Book {
    // Class variables
    private int $isbn;
    private int $stock;
    private string $author;
    private string $title;
    private string $publisher;
    private string $cover;
    private int $trend;
    private string $bookLocation;
    private int $state;
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
    // Trend accessor method
    public function getTrend() {
        return $this->trend;
    }
    // Book Location accessor method
    public function getBookLocation() {
        return $this->bookLocation;
    }
    // State accessor method
    public function getState() {
        return $this->state;
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
    // Trend mutator method
    public function setTrend($trend) {
        $this->trend = $trend;
    }
    // State mutator method
    public function setState($state) {
        $this->state = $state;
    }
    // Search Books method
    public function searchBooks() {
        $this->setTitle($_POST['Title']);
        $this->API->query("SELECT * FROM Book WHERE BookTitle = :BookTitle");
        $this->API->bind(":BookTitle", $this->getTitle());
        $this->API->execute();
        if (empty($this->API->resultSet())) {
            echo "No result for " . $this->getTitle();
        } else {
            for ($index = 0; $index < $this->API->resultSet()->length; $index++) { 
                echo $this->API->resultSet()[$index]['Title'];
            }
        }
    }
    // Change Cover method
    public function changeCover() {
        $imageDirectory = "../Images";
        $imageFile = $imageDirectory + basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $imageFile)) {
            $this->setCover($imageFile);
            $this->API->query("UPDATE Book SET BookCover = :BookCover WHERE BookIsbn = :BookIsbn");
            $this->API->bind(":BookCover", $this->getCover());
            $this->API->bind(":BookIsbn", $this->getIsbn());
            $this->API->execute();
            echo "The book cover has been changed!";
            header('location: ' . $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/Admin/Management/Book/index.php');
        } else {
            echo("ERROR: No image has been uploaded!");
        }
    }
    // Remove Book method
    public function removeBook() {
        $this->API->query("DELETE FROM Book WHERE BookIsbn = :BookIsbn");
        $this->API->bind(":BookIsbn", $this->API->resultSet()[$index]['Isbn']);
        $this->API->execute();
        $this->API->query("SELECT * FROM Book");
        $this->API->execute();
        $length = count($this->API->resultSet());
        for ($index = 0; $index < $length; $index++) { 
            echo $this->API->resultSet()[$index];
        }
    }
    // Add Book method
    public function addBook() {
        $this->setIsbn($_POST['Isbn']);
        $this->setStock($_POST['Stock']);
        $this->setAuthor($_POST['Author']);
        $this->setPublisher($_POST['Publisher']);
        $this->setBookLocation($_POST['BookLocation']);
        $this->setTitle($_POST['Title']);
        $this->setstate(1);
        $imageDirectory;
        $imageFile = $imageDirectory + basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'])) {
            $this->API->query("INSERT INTO Book (BookIsbn, BookTitle, BookAuthor, BookPublisher, BookBookLocation, BookStock, BookCover, BookState) VALUES (:BookIsbn, :BookTitle, :BookAuthor, :BookPublisher, :BookBookLocation, :BookStock, :BookCover, :BookState)");
            $this->API->bind(":BookCover", $this->getCover());
            $this->API->bind(":BookIsbn", $this->getIsbn());
            $this->API->bind(":BookTitle", $this->getTitle());
            $this->API->bind(":BookAuthor", $this->getAuthor());
            $this->API->bind(":BookPublisher", $this->getPublisher());
            $this->API->bind(":BookBookLocation", $this->getBookLocation());
            $this->API->bind(":BookStock", $this->getStock());
            $this->API->bind(":BookState", $this->getState());
            $this->API->execute();
            echo $this->getTitle() . " has been added!";
        } else {
            echo "ERROR: No image has been uploaded!";
        }
    }
    // Update Book method
    public function updateBook() {
        $this->setIsbn($_POST['Isbn']);
        $this->setStock($_POST['Stock']);
        $this->setAuthor($_POST['Author']);
        $this->setTitle($_POST['Title']);
        $this->setPublisher($_POST['Publisher']);
        $this->setBookLocation($_POST['BookLocation']);
        $this->setstate($_POST['State']);
        $this->API->query("UPDATE Book SET BookStock = :BookStock, BookAuthor = :BookAuthor, BookTitle = :BookTitle, BookPublisher = :BookPublisher, BookBookLocation = :BookBookLocation, BookState = :BookState WHERE BookIsbn = :BookIsbn");
        $this->API->bind(":BookIsbn", $this->getIsbn());
        $this->API->bind(":BookTitle", $this->getTitle());
        $this->API->bind(":BookAuthor", $this->getAuthor());
        $this->API->bind(":BookPublisher", $this->getPublisher());
        $this->API->bind(":BookBookLocation", $this->getBookLocation());
        $this->API->bind(":BookStock", $this->getStock());
        $this->API->bind(":BookState", $this->getState());
        $this->API->execute();
        echo $this->getTitle() . " has been updated!";
    }
}
?>