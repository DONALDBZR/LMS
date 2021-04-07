<?php
require $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/User.php';
require $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/Book.php';
require $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/API.php';
require $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/Mail.php';
require $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/Reservation.php';
class Loan {
    // Class variables
    private int $id;
    private string $time;
    private string $date;
    private string $dueDate;
    private bool $overdue;
    private int $person;
    private int $book;
    protected $User;
    protected $Book;
    protected $API;
    protected $Mail;
    protected $Reservation;
    // Constructor method
    public function __construct() {
        $this->User = new User();
        $this->Book = new Book();
        $this->API = new API();
        $this->Mail = new Mail();
        $this->Reservation = new Reservation();
    }
    // Id accessor method
    public function getId() {
        return $this->id;
    }
    // Time accessor method
    public function getTime() {
        return $this->time;
    }
    // Date accessor method
    public function getDate() {
        return $this->date;
    }
    // Due Date accessor method
    public function getDueDate() {
        return $this->dueDate;
    }
    // Overdue accessor method
    public function getOverdue() {
        return $this->overdue;
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
    // Set Time method
    public function setTime() {
        $this->time = DateTime("now")->format("H:M:S");
    }
    // Set Date method
    public function setDate() {
        $this->date = DateTime("now")->format("Y-M-D");
    }
    // Set Due Date method
    public function setDueDate() {
        $this->API->query("SELECT * FROM User WHERE UserId = :UserId");
        $this->API->bind(":UserId", $this->User->getId());
        $this->API->execute();
        $this->User->setType($this->API->resultSet()[0]['Type']);
        if ($this->User->getType() == 1 OR $this->User->getType() == 2) {
            $this->dueDate = date("Y-M-D", strtotime("+1 Week"));
        } else if ($this->User->getType() == 3) {
            $this->dueDate = date("Y-M-D", strtotime("+2 Week"));
        }
    }
    // Overdue mutator method
    public function setOverdue($overdue) {
        $this->overdue = $overdue;
    }
    // Person mutator method
    public function setPerson() {
        $this->person = $this->User->getId();
    }
    // Book mutator method
    public function setBook() {
        $this->book = $this->Book->getIsbn();
    }
    // Borrow Book method
    public function borrowBook() {
        $this->User->getId();
        $this->User->getType();
        $this->API->query("SELECT * FROM Loan WHERE LoanPerson = :LoanPerson");
        $this->API->bind(":LoanPerson", $this->User->getId());
        $this->API->execute();
        if ($this->User->getType() == 1 OR $this->User->getType() == 2) {
            if (count($this->API->resultSet()) < 2) {
                $this->API->query("SELECT * FROM Book WHERE BookIsbn = :BookIsbn");
                $this->API->bind(":BookIsbn", $this->Book->getIsbn());
                $this->API->execute();
                $this->Book->setStock($this->API->resultSet()[0]['Stock']);
                if ($this->Book->getStock() > 0) {
                    $this->setTime();
                    $this->setDate();
                    $this->setDueDate();
                    $this->setPerson($this->User->getId());
                    $this->setBook($this->Book->getIsbn());
                    $this->API->query("INSERT INTO Loan (LoanTime, LoanDate, LoanDueDate, LoanBook, LoanPerson) VALUES (:LoanTime, :LoanDate, :LoanDueDate, :LoanBook, :LoanPerson)");
                    $this->API->bind(":LoanTime", $this->getTime());
                    $this->API->bind(":LoanDate", $this->getDate());
                    $this->API->bind(":LoanDueDate", $this->getDueDate());
                    $this->API->bind(":LoanBook", $this->getBook());
                    $this->API->bind(":LoanPerson", $this->getPerson());
                    $this->API->execute();
                    $newStock = $this->Book->getStock() - 1;
                    $this->Book->setStock($newStock);
                    $this->API->query("UPDATE Book SET BookStock = :BookStock WHERE BookIsbn = :BookIsbn");
                    $this->API->bind(":BookStock", $this->Book->getStock());
                    $this->API->bind(":BookIsbn", $this->getBook());
                    $this->API->execute();
                    echo $this->Book->getTitle() . " can now be taken at the counter before you leave the library.";
                    header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/LibrarySystem/Member/Borrowed_Books/index.php");
                } else {
                    echo $this->Book->getTitle() . " cannot be borrowed at the moment.  Please reserve the book before you can borrow it after it is available again!";
                    $this->Reservation->reserveBook();
                    header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/LibrarySystem/Member/Reserved_Books/index.php");
                }
            } else {
                echo $this->Book->getTitle() . " cannot be borrowed at the moment.  Please reserve the book before you can borrow it after it is available again!";
                $this->Reservation->reserveBook();
                header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/LibrarySystem/Member/Reserved_Books/index.php");
            }
        } else if ($this->User->getType() == 3) {
            if (count($this->API->resultSet()) < 5) {
                $this->API->query("SELECT * FROM Book WHERE BookIsbn = :BookIsbn");
                $this->API->bind(":BookIsbn", $this->Book->getIsbn());
                $this->API->execute();
                $this->Book->setStock($this->API->resultSet()[0]['Stock']);
                if ($this->Book->getStock() > 0) {
                    $this->setTime();
                    $this->setDate();
                    $this->setDueDate();
                    $this->setPerson($this->User->getId());
                    $this->setBook($this->Book->getIsbn());
                    $this->API->query("INSERT INTO Loan (LoanTime, LoanDate, LoanDueDate, LoanBook, LoanPerson) VALUES (:LoanTime, :LoanDate, :LoanDueDate, :LoanBook, :LoanPerson)");
                    $this->API->bind(":LoanTime", $this->getTime());
                    $this->API->bind(":LoanDate", $this->getDate());
                    $this->API->bind(":LoanDueDate", $this->getDueDate());
                    $this->API->bind(":LoanBook", $this->getBook());
                    $this->API->bind(":LoanPerson", $this->getPerson());
                    $this->API->execute();
                    $newStock = $this->Book->getStock() - 1;
                    $this->Book->setStock($newStock);
                    $this->API->query("UPDATE Book SET BookStock = :BookStock WHERE BookIsbn = :BookIsbn");
                    $this->API->bind(":BookStock", $this->Book->getStock());
                    $this->API->bind(":BookIsbn", $this->getBook());
                    $this->API->execute();
                    echo $this->Book->getTitle() . " can now be taken at the counter before you leave the library.";
                    header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/LibrarySystem/Member/Borrowed_Books/index.php");
                } else {
                    echo $this->Book->getTitle() . " cannot be borrowed at the moment.  Please reserve the book before you can borrow it after it is available again!";
                    $this->Reservation->reserveBook();
                    header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/LibrarySystem/Member/Reserved_Books/index.php");
                }
            } else {
                echo $this->Book->getTitle() . " cannot be borrowed at the moment.  Please reserve the book before you can borrow it after it is available again!";
                $this->Reservation->reserveBook();
                header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/LibrarySystem/Member/Reserved_Books/index.php");
            }
        }
    }
    // Collect Book method
    public function collectBook() {
        $this->getPerson();
        $this->getBook();
        $this->Mail->addAddress($this->User->getMail());
        $this->API->query("SELECT * FROM Book WHERE BookIsbn = :BookIsbn");
        $this->API->bind(":BookIsbn", $this->getBook());
        $this->API->execute();
        $this->Book->setTitle($this->API->resultSet()[0]['Title']);
        $this->Mail->body = "Your book titled, " . $this->Book->getTitle() . " can now be taken at the counter before you leave the library.  Please come at anytime!";
        $this->Mail->send();
        echo "Mail has been sent to " . $this->User->getMail();
    }
    // View Borrowed Book method
    public function viewBorrowedBook() {
        $this->getPerson();
        $this->API->query("SELECT * FROM Loan WHERE LoanPerson = :LoanPerson");
        $this->API->bind(":LoanPerson", $this->getPerson());
        $this->API->execute();
        if (count($this->API->resultSet()) > 0) {
            $length = count($this->API->resultSet());
            for ($index = 0; $index < $length; $index++) { 
                echo $this->API->resultSet()[index];
            }
        } else {
            echo "No book has been borrowed!";
        }
    }
    // Record Return method
    public function recordReturn() {
        $this->setOverdue(false);
        $this->API->query("UPDATE Loan SET LoanOverdue = :LoanOverdue WHERE LoanPerson = :LoanPerson");
        $this->API->bind(":LoanOverdue", $this->getOverdue());
        $this->API->bind(":LoanPerson", $this->getPerson());
        $this->API->execute();
    }
}
?>