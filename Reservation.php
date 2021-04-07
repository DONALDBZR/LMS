<?php
require $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/User.php';
require $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/Book.php';
require $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/API.php';
class Reservation {
    // Class Variables
    private int $id;
    private int $priotity;
    private bool $borrowed;
    private int $person;
    private int $book;
    protected $User;
    protected $Book;
    protected $API;
    // Constructor method
    public function __construct() {
        $this->User = new User();
        $this->Book = new Book();
        $this->API = new API();
    }
    // Id accessor method
    public function getId() {
        return $this->id;
    }
    // Priority accessor method
    public function getPriority() {
        return $this->priority;
    }
    // Borrowed accessor method
    public function getBorrowed() {
        return $this->borrowed;
    }
    // Person accessor method
    public function getPerson() {
        return $this->person;
    }
    // Book accessor method
    public function getBook() {
        return $this->book;
    }
    // Id mutator method
    public function setId($id) {
        $this->id = $id;
    }
    // Priority mutator method
    public function setPriority($priority) {
        $this->priority = $priority;
    }
    // Borrowed mutator method
    public function setBorrowed($borrowed) {
        $this->borrowed = $borrowed;
    }
    // Person mutator method
    public function setPerson($person) {
        $this->person = $person;
    }
    // Book mutator method
    public function setBook($book) {
        $this->book = $book;
    }
    // Reserve Book method
    public function reserveBook() {
        $this->User->getId();
        $this->API->query("SELECT * FROM Reservation WHERE ReservationPerson = :ReservationPerson");
        $this->API->bind(":ReservationPerson", $this->User->getId());
        $this->API->execute();
        if (count($this->API->resultSet()) < 3) {
            $this->setBorrowed(false);
            $this->setPerson($this->User->getId());
            $this->setBook($this->Book->getIsbn());
            $this->setPriority($this->User->getType());
            $this->API->query("INSERT INTO Reservation (ReservationPriority, ReservationBook, ReservationPerson) VALUES (:ReservationPriority, :ReservationBook, :ReservationPerson)");
            $this->API->bind(":ReservationPriority", $this->getPriority());
            $this->API->bind(":ReservationBook", $this->getBook());
            $this->API->bind(":ReservationPerson", $this->getPerson());
            $this->API->execute();
            echo $this->Book->getTitle() . " has been reserved!";
            header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/LibrarySystem/Member/Reserved_Books/index.php");
        } else {
            echo "You cannot reserve more books!  Either you wait for your reserved books to be available to be collected or cancel the reservations!";
            header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/LibrarySystem/Member/Reserved_Books/index.php");
        }
    }
    // Cancel Reservation method
    public function cancelReservation() {
        $this->API->query("DELETE FROM Reservation WHERE ReservationId = :ReservationId");
        $this->API->bind(":ReservationId", $this->API->resultSet()[index]['Id']);
        $this->API->execute();
        $this->API->query("SELECT * FROM Reservation WHERE ReservationPerson = :ReservationPerson");
        $this->API->bind(":ReservationPerson", $this->getPerson());
        $this->API->execute();
        $length = count($this->API->resultSet());
        for ($index = 0; $index < $length; $index++) { 
            echo $this->API->resultSet()[index];
        }
    }
    // View Reserved Book method
    public function viewReservedBook() {
        $this->API->query("SELECT * FROM Reservation WHERE ReservationPerson = :ReservationPerson");
        $this->API->bind(":ReservationPerson", $this->getPerson());
        $this->API->execute();
        if (count($this->API->resultSet()) > 0) {
            $length = count($this->API->resultSet());
            for ($index = 0; $index < $length; $index++) { 
                echo $this->API->resultSet()[index];
            }
        } else {
            echo "No book has been reserved!";
        }
    }
}
?>