<?php
// Importing User
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/User.php';
// Importing Book 
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/Book.php';
// Importing API
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/API.php';
class Reservation {
    // Class Variables
    private int $id; // It will store the ID of the reservation made by the user.
    private int $priority; // It will store the priority of the reservation made which will be used in the priority queue.  The values for priority are 1 for student, 2 for Non-academical staff and 3 for Academical staff as these values are originally the User's Type.
    private int $borrowed; // It will store a process value where 1 when the book reserved is ready to be borrowed and 0 when the book is not ready to be borrowed.
    private int $person; // It will store the ID of the user who will reserve a book.
    private int $book; // It will store the ISBN of the book that is going to be reserved.
    protected $User; // It will be the variable that will act as object to related to the User class.
    protected $Book; // It will be the variable that will act as object to related to the Book class.
    protected $API; // It will be the variable that will act as object to related to the API class.
    // Constructor method
    public function __construct() {
        // Instantiating User
        $this->User = new User();
        // Instantiating Book
        $this->Book = new Book();
        // Instantiating API
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
        // Assigning the returned values from the ID of the session as the mutator for Reservation.Person
        $this->setPerson($_SESSION["id"]);
        // Preparing the query to retrieve data from the database
        $this->API->query("SELECT * FROM LibrarySystem.Reservation WHERE ReservationPerson = :ReservationPerson");
        // Binding all the values for security purposes
        $this->API->bind(":ReservationPerson", $this->getPerson());
        // Executing the query
        $this->API->execute();
        // If-statement to verify if there are less than 3 reservations that are linked to that account.
        if (count($this->API->resultSet()) < 3) {
            // Assignging the value returned from Reservation.getPerson() as the parameter for the mutator for User.id
            $this->User->setId($this->getPerson());
            // Preparing the query to retrieve data from the database.
            $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserId = :UserId");
            // Binding the value for security purposes.
            $this->API->bind(":UserId", $this->User->getId());
            // Executing the query
            $this->API->execute();
            // If-statement to verify whether the data exists in the database
            if (!empty($this->API->resultSet())) {
                // Assigning the value returned from API.resultSet().UserType as the parameter for the mutator for User.type
                $this->User->setType($this->API->resultSet()[0]['UserType']);
                // Assigning the value returned from the Cookie as the parameter for the mutator of Book.isbn
                $this->Book->setIsbn($_COOKIE['isbn']);
                // Preparing the query
                $this->API->query("SELECT * FROM LibrarySystem.Book WHERE BookIsbn = :BookIsbn");
                // Binding the value for security purposes
                $this->API->bind(":BookIsbn", $this->Book->getIsbn());
                // Executing the query
                $this->API->execute();
                // If-statement to verify whether the data exists in the database
                if (!empty($this->API->resultSet())) {
                    // Assigning the value returned from API.resultSet().BookTitle as the parameter for the mutator of Book.title
                    $this->Book->setTitle($this->API->resultSet()[0]['BookTitle']);
                    // Assigning the value returned from User.getType() as the parameter for the mutator of Reservation.priority
                    $this->setPriority($this->User->getType());
                    // Assigning 0 as the parameter for the mutator of Reservation.borrowed
                    $this->setBorrowed(0);
                    // Assigning the value returned from Book.getIsbn() as the parameter for the mutator of Reservation.book
                    $this->setBook($this->Book->getIsbn());
                    // Preparing the query
                    $this->API->query("INSERT INTO LibrarySystem.Reservation (ReservationPriority, ReservationBorrowed, ReservationPerson, ReservationBook) VALUES (:ReservationPriority, :ReservationBorrowed, :ReservationPerson, :ReservationBook)");
                    // Binding all the values for security purposes
                    $this->API->bind(":ReservationPriority", $this->getPriority());
                    $this->API->bind(":ReservationBorrowed", $this->getBorrowed());
                    $this->API->bind(":ReservationPerson", $this->getPerson());
                    $this->API->bind(":ReservationBook", $this->getBook());
                    // Executing the query
                    $this->API->execute();
                    echo "
                    <h1 id='success'>
                        {$this->Book->getTitle()} has been reserved!  You will be redirected to the page where you can see all your reservations.
                    </h1>";
                    header("refresh:4.9; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member/Profile/Reserved_Books");
                } else {
                    echo "
                    <h1 id='failure'>
                        There is a problem with the system.  You will be redirected to the Member's portal but please report the issue to an administrator.
                    </h1>";
                    header("refresh:4.9; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member");
                }
            } else {
                echo "
                <h1 id='failure'>
                    There is either a problem with your account or with the system.  You will be logged out but you can reconnect into the system and can also report the problem to an administrator!
                </h1>";
                header("refresh:4.9; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member/Logout");
            }
        } else {
            echo "
            <h1 id='failure'>
                You cannot make more reservations.  You can either wait for your reservations to be available to be collected or you can also cancel the reservations.  Hence, you will be redirected to the page where you can see all your reservations.
            </h1>";
            header("refresh:4.9; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member/Profile/Reserved_Books");
        }
    }
    // Cancel Reservation method
    public function cancelReservation() {
        // Assinging the return value of Cookie's ID as the parameter for the mutator for Reservation.id
        $this->setId($_COOKIE["id"]);
        // Preparing the query
        $this->API->query("DELETE FROM LibrarySystem.Reservation WHERE ReservationId = :ReservationId");
        // Binding the value for security purposes
        $this->API->bind(":ReservationId", $this->getId());
        // Executing the query
        $this->API->execute();
        // Refreshing the page
        header("Location: ./");
    }
    // View Reserved Book method
    public function viewReservedBook() {
        // Assigning the Session's ID as the parameter for the mutator of Reservation.person
        $this->setPerson($_SESSION["id"]);
        // Preparing the query
        $this->API->query("SELECT * FROM LibrarySystem.Reservation WHERE ReservationPerson = :ReservationPerson");
        // Binding the value for security purposes
        $this->API->bind(":ReservationPerson", $this->getPerson());
        // Executing the query
        $this->API->execute();
        // If-statement to verify whether the data exists
        if (!empty($this->API->resultSet())) {
            // Loop to retrieve and display the data
            foreach ($this->API->resultSet() as $result) {
                // Assigning the returned value from API.resultSet().ReservationBook as the parameter for the mutator of Book.isbn
                $this->Book->setIsbn($result['ReservationBook']);
                // Preparing the query
                $this->API->query("SELECT * FROM LibrarySystem.Book WHERE BookIsbn = :BookIsbn");
                // Binding the value for security purposes
                $this->API->bind(":BookIsbn", $this->Book->getIsbn());
                // Executing the query
                $this->API->execute();
                $bookCover = "http://stormysystem.ddns.net" . $this->API->resultSet()[0]["BookCover"];
                echo "
                <div id='found'>
                    <div id='left'>
                        <img src='{$bookCover}' />
                    </div>
                    <div id='right'>
                        <div id='isbn'>
                            <h1>
                                ISBN:
                            </h1>
                            <h1>
                                {$this->API->resultSet()[0]['BookIsbn']}
                            </h1>
                        </div>
                        <div id='author'>
                            <h1>
                                Author:
                            </h1>
                            <h1>
                                {$this->API->resultSet()[0]['BookAuthor']}
                            </h1>
                        </div>
                        <div id='title'>
                            <h1>
                                Title:
                            </h1>
                            <h1>
                                {$this->API->resultSet()[0]['BookTitle']}
                            </h1>
                        </div>
                        <div id='publisher'>
                            <h1>
                                Publisher:
                            </h1>
                            <h1>
                                {$this->API->resultSet()[0]['BookPublisher']}
                            </h1>
                        </div>
                        <div id='category'>
                            <h1>
                                Category:
                            </h1>
                            <h1>
                                {$this->API->resultSet()[0]['BookCategory']}
                            </h1>
                        </div>
                        <div id='action'>
                            <form method='post'>
                                <input type='submit' value='Cancel' id='cancelButton {$result['ReservationId']}' name='cancelReservation' onClick='cancelReservationCookie(this.id)' />
                            </form>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "
            <div id='notFound'>
                <h1 id='success'>
                    No book has been reserved! You can reserve all the books that you want as long as it does not exceed the limit. 😉
                </h1>
            </div>";
            header("refresh:2; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member");
        }
    }
}
?>