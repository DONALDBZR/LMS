<?php
// Importing User.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/User.php';
// Importing Book.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/Book.php';
// Importing API.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/API.php';
// Importing all the dependencies of PHPMailer
require_once $_SERVER['DOCUMENT_ROOT'] . "/LibraryManagementSystem/PHPMailer/src/PHPMailer.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/LibraryManagementSystem/PHPMailer/src/Exception.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/LibraryManagementSystem/PHPMailer/src/SMTP.php";
// Importing Reservation.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/Reservation.php';
class Loan {
    // Class variables
    private int $id;
    private string $time;
    private string $date;
    private string $dueDate;
    private string $dateReturned;
    private int $overdue;
    private int $person;
    private int $book;
    private int $returned;
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
        $this->Mail = new PHPMailer\PHPMailer\PHPMailer(true);
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
    // Date Returned accessor method
    public function getDateReturned() {
        return $this->dateReturned;
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
    // Returned accessor method
    public function getReturned() {
        return $this->returned;
    }
    // Id mutator method
    public function setId($id) {
        $this->id = $id;
    }
    // Set Time method
    public function setTime() {
        date_default_timezone_set("Indian/Mauritius");
        $this->time = date("H:i:s");
    }
    // Set Date method
    public function setDate() {
        $this->date = date("Y-m-d");
    }
    // Set Date Returned method
    public function setDateReturned() {
        $this->dateReturned = date("Y-m-d");
    }
    // Set Due Date method
    public function setDueDate() {
        // Assigning the returned value from the session's id as the the parameter for the mutator of User.id
        $this->User->setId($_SESSION["id"]);
        // Preparing the query
        $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserId = :UserId");
        // Binding the value for security purposes
        $this->API->bind(":UserId", $this->User->getId());
        // Executing the query
        $this->API->execute();
        $this->User->setType($this->API->resultSet()[0]['UserType']);
        // If-statement to verify the type of the user
        if ($this->User->getType() == 1 OR $this->User->getType() == 2) {
            $this->dueDate = date("Y-m-d", strtotime("+1 Week"));
        } else if ($this->User->getType() == 3) {
            $this->dueDate = date("Y-m-d", strtotime("+2 Week"));
        }
    }
    // Overdue mutator method
    public function setOverdue($overdue) {
        $this->overdue = $overdue;
    }
    // Person mutator method
    public function setPerson($person) {
        $this->person = $person;
    }
    // Book mutator method
    public function setBook($book) {
        $this->book = $book;
    }
    // Returned mutator method
    public function setReturned($returned) {
        $this->returned = $returned;
    }
    // Borrow Book method
    public function borrowBook() {
        // Assigning the returned value from the ID of the session as the parameter for the  mutator for Loan.person.
        $this->User->setId($_SESSION["id"]);
        // Preparing the query to retrive values from the database
        $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserId = :UserId");
        // Binding all the values for security purposes
        $this->API->bind(":UserId", $this->User->getId());
        // Executing the query
        $this->API->execute();
        // If-statement to verify whether the data exists in the database
        if (!empty($this->API->resultSet())) {
            // Assigning the returned value from API.resultSet().UserType as the parameter for the mutator for User.type
            $this->User->setType($this->API->resultSet()[0]['UserType']);
            // Assigning the returned value from User.getId() as the parameter for the mutator for Loan.person
            $this->setPerson($this->User->getId());
            // Preparing the query to retrive values from the database
            $this->API->query("SELECT * FROM LibrarySystem.Loan WHERE LoanPerson = :LoanPerson AND LoanReturned = :LoanReturned");
            // Binding all the values for security purposes
            $this->API->bind(":LoanPerson", $this->getPerson());
            $this->API->bind(":LoanReturned", 0);
            // Executing the query
            $this->API->execute();
            // If-statement to verify the type of the user.
            if ($this->User->getType() == 1 OR $this->User->getType() == 2) {
                // If-statement to verify whether the user has borrowed less than two books
                if (count($this->API->resultSet()) < 2) {
                    // Assigning the value returned from the Cookie as the parameter for the mutator of Book.isbn
                    $this->Book->setIsbn($_COOKIE['isbn']);
                    // Assigning the value returned from Book.getIsbn() as the parameter for the mutator for Loan.book
                    $this->setBook($this->Book->getIsbn());
                    // Preparing the query to retrieve data from the database
                    $this->API->query("SELECT * FROM LibrarySystem.Book WHERE BookIsbn = :BookIsbn");
                    // Binding the value for security purposes
                    $this->API->bind(":BookIsbn", $this->Book->getIsbn());
                    // Executing the query
                    $this->API->execute();
                    // If-statement to verify whether the data exists
                    if (!empty($this->API->resultSet())) {
                        // Assigning the value returned from API.resultSet().BookTitle as the parameter for the mutator of Book.title
                        $this->Book->setTitle($this->API->resultSet()[0]['BookTitle']);
                        // Assigning the value returned from API.resultSet().BookStock as the parameter for the mutator of Book.stock
                        $this->Book->setStock($this->API->resultSet()[0]['BookStock']);
                        // If-statement to verify whether the book is in stock.
                        if ($this->Book->getStock() > 0) {
                            // Calling Set Time method
                            $this->setTime();
                            // Calling Set Date method
                            $this->setDate();
                            // Calling Set Due Date method
                            $this->setDueDate();
                            // Assigning 0 as the parameter for the mutator of Loan.overdue
                            $this->setOverdue(0);
                            // Assigning 0 as the parameter for the mutator of Loan.returned
                            $this->setReturned(0);
                            // Removing 1 book copy
                            $newStock = $this->Book->getStock() - 1;
                            // Assigning New Stock as the parameter of the mutator of Book.stock
                            $this->Book->setStock($newStock);
                            // Preparing the query to update the data in the database.
                            $this->API->query("UPDATE LibrarySystem.Book SET BookStock = :BookStock WHERE BookIsbn = :BookIsbn");
                            // Binding the values for security purposes
                            $this->API->bind(":BookStock", $this->Book->getStock());
                            $this->API->bind(":BookIsbn", $this->Book->getIsbn());
                            // Executing the query
                            $this->API->execute();
                            // Preparing the query for inserting the data in the database
                            $this->API->query("INSERT INTO LibrarySystem.Loan (LoanTime, LoanDate, LoanDueDate, LoanOverdue, LoanPerson, LoanBook, LoanReturned) VALUES (:LoanTime, :LoanDate, :LoanDueDate, :LoanOverdue, :LoanPerson, :LoanBook, :LoanReturned)");
                            // Binding all the values for security purposes
                            $this->API->bind(":LoanTime", $this->getTime());
                            $this->API->bind(":LoanDate", $this->getDate());
                            $this->API->bind(":LoanDueDate", $this->getDueDate());
                            $this->API->bind(":LoanOverdue", $this->getOverdue());
                            $this->API->bind(":LoanPerson", $this->getPerson());
                            $this->API->bind(":LoanBook", $this->getBook());
                            $this->API->bind(":LoanReturned", $this->getReturned());
                            // Executing the query
                            $this->API->execute();
                            echo "
                            <h1 id='success'>
                                {$this->Book->getTitle()} has been borrowed!  You will be notified by mail to come and take your book at the counter as well as you will be redirected to the page where you can see all your loans.
                            </h1>";
                            // Calling Collect Book method
                            $this->collectBook();
                            header("refresh:7.8; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member/Profile/Borrowed_Books");
                        } else {
                            echo "
                            <h1 id='failure'>
                                This book is not in stock for the moment.  Hence, a reservation will be made for you and after that you will be redirected to the page where you can see all your reservations!
                            </h1>";
                            // Calling Reserve Book method
                            $this->Reservation->reserveBook();
                        }
                    } else {
                        echo "
                        <h1 id='failure'>
                            There is a problem with the system.  You will be redirected to the Member's portal but please report the issue to an administrator.
                        </h1>";
                        header("refresh:7.8; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member");
                    }
                } else {
                    echo "
                    <h1 id='failure'>
                        You cannot borrow more books as you have not returned the books that you have taken.  You should return your books before you can take more but a reservation will be made for you.
                    </h1>";
                    // Calling Reserve Book method
                    $this->Reservation->reserveBook();
                }
            } else if ($this->User->getType() == 3) {
                // If-statement to verify whether the user has borrowed less than five books
                if (count($this->API->resultSet()) < 5) {
                    // Assigning the value returned from the Cookie as the parameter for the mutator of Book.isbn
                    $this->Book->setIsbn($_COOKIE['isbn']);
                    // Assigning the value returned from Book.getIsbn() as the parameter for the mutator for Loan.book
                    $this->setBook($this->Book->getIsbn());
                    // Preparing the query to retrieve data from the database
                    $this->API->query("SELECT * FROM LibrarySystem.Book WHERE BookIsbn = :BookIsbn");
                    // Binding the value for security purposes
                    $this->API->bind(":BookIsbn", $this->Book->getIsbn());
                    // Executing the query
                    $this->API->execute();
                    // If-statement to verify whether the data exists
                    if (!empty($this->API->resultSet())) {
                        // Assigning the value returned from API.resultSet().BookTitle as the parameter for the mutator of Book.title
                        $this->Book->setTitle($this->API->resultSet()[0]['BookTitle']);
                        // Assigning the value returned from API.resultSet().BookStock as the parameter for the mutator of Book.stock
                        $this->Book->setStock($this->API->resultSet()[0]['BookStock']);
                        // If-statement to verify whether the book is in stock.
                        if ($this->Book->getStock() > 0) {
                            // Calling Set Time method
                            $this->setTime();
                            // Calling Set Date method
                            $this->setDate();
                            // Calling Set Due Date method
                            $this->setDueDate();
                            // Assigning 0 as the parameter for the mutator of Loan.overdue
                            $this->setOverdue(0);
                            // Preparing the query for inserting the data in the database
                            $this->API->query("INSERT INTO LibrarySystem.Loan (LoanTime, LoanDate, LoanDueDate, LoanOverdue, LoanPerson, LoanBook) VALUES (:LoanTime, :LoanDate, :LoanDueDate, :LoanOverdue, :LoanPerson, :LoanBook)");
                            // Binding all the values for security purposes
                            $this->API->bind(":LoanTime", $this->getTime());
                            $this->API->bind(":LoanDate", $this->getDate());
                            $this->API->bind(":LoanDueDate", $this->getDueDate());
                            $this->API->bind(":LoanOverdue", $this->getOverdue());
                            $this->API->bind(":LoanPerson", $this->getPerson());
                            $this->API->bind(":LoaBook", $this->geBook());
                            // Executing the query
                            $this->API->execute();
                            echo "
                            <h1 id='success'>
                                {$this->Book->getTitle()} has been borrowed!  You will be notified by mail to come and take your book at the counter as well as you will be redirected to the page where you can see all your loans.
                            </h1>";
                            // Calling Collect Book method
                            $this->collectBook();
                            header("refresh:7.8; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member/Profile/Borrowed_Books");
                        } else {
                            echo "
                            <h1 id='failure'>
                                This book is not in stock for the moment.  Hence, a reservation will be made for you and after that you will be redirected to the page where you can see all your reservations!
                            </h1>";
                            // Calling Reserve Book method
                            $this->Reservation->reserveBook();
                        }
                    } else {
                        echo "
                        <h1 id='failure'>
                            There is a problem with the system.  You will be redirected to the Member's portal but please report the issue to an administrator.
                        </h1>";
                        header("refresh:7.8; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member");
                    }
                } else {
                    echo "
                    <h1 id='failure'>
                        You cannot borrow more books as you have not returned the books that you have taken.  You should return your books before you can take more but a reservation will be made for you.
                    </h1>";
                    // Calling Reserve Book method
                    $this->Reservation->reserveBook();
                }
            } else {
                echo "
                <h1 id='failure'>
                    There is either a problem with your account or with the system.  You will be logged out but you can reconnect into the system and can also report the problem to an administrator!
                </h1>";
                header("refresh:7.8; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member/Logout");
            }
        } else {
            echo "
            <h1 id='failure'>
                There is either a problem with your account or with the system.  You will be logged out but you can reconnect into the system and can also report the problem to an administrator!
            </h1>";
            header("refresh:7.8; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member/Logout");
        }
    }
    // Collect Book method
    public function collectBook() {
        // Preparing the query to retrieve data from the database
        $this->API->query("SELECT * FROM LibrarySystem.Loan WHERE LoanPerson = :LoanPerson AND LoanBook = :LoanBook");
        // Binding all the value for security purposes
        $this->API->bind(":LoanPerson", $this->getPerson());
        $this->API->bind(":LoanBook", $this->getBook());
        // Executing the query
        $this->API->execute();
        // If-statement to verify whether the data exists
        if (!empty($this->API->resultset())) {
            // Preparing the query
            $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserId = :UserId");
            // Binding the value for security purposes
            $this->API->bind(":UserId", $this->User->getId());
            // Executing the query
            $this->API->execute();
            // If-statement to verify whether the data exists
            if (!empty($this->API->resultSet())) {
                // Assigning the value from API.resultSet().UserMailAddress as the parameter for the mutator of User.mailAddress
                $this->User->setMailAddress($this->API->resultSet()[0]['UserMailAddress']);
                // Calling Is SMTP function from PHPMailer.
                $this->Mail->IsSMTP();
                // Assigning "UTF-8" as the value for the charset.
                $this->Mail->CharSet = "UTF-8";
                // Assigning the host for gmail's SMTP.
                $this->Mail->Host = "ssl://smtp.gmail.com";
                // Setting the debug mode to 0.
                $this->Mail->SMTPDebug = 0;
                // Assigning the Port to 465 as GMail uses 465 as it also means that port 465 has been forwarded for its use.
                $this->Mail->Port = 465;
                // Securing the SMTP connection by using SSL.
                $this->Mail->SMTPSecure = 'ssl';
                // Enabling authorization for SMTP.
                $this->Mail->SMTPAuth = true;
                // Ensuring that PHPMailer is called from a .html file.
                $this->Mail->IsHTML(true);
                // Sender's mail address.
                $this->Mail->Username = "andygaspard003@gmail.com";
                // Sender's password
                $this->Mail->Password = "Aegis050200";
                // Assigning sender as a parameter in the sender's zone.
                $this->Mail->setFrom($this->Mail->Username);
                // Assinging the receiver mail's address which is retrieved from the User class.
                $this->Mail->addAddress($this->User->getMailAddress());
                $this->Mail->Subject = "Library System: Notification";
                $this->Mail->Body = "The book titled, {$this->Book->getTitle()} can be taken at the counter!  Please come and take it as soon as possible!";
                // Sending the mail.
                $this->Mail->send();
            }
        }
    }
    // View Borrowed Book method
    public function viewBorrowedBook() {
        // Assigning the Session's ID as the parameter for the mutator of Loan.person
        $this->setPerson($_SESSION["id"]);
        // Preparing the query
        $this->API->query("SELECT * FROM LibrarySystem.Loan WHERE LoanPerson = :LoanPerson AND LoanReturned = :LoanReturned");
        // Binding all the values
        $this->API->bind(":LoanPerson", $this->getPerson());
        $this->API->bind(":LoanReturned", 0);
        // Executing the query
        $this->API->execute();
        // If-statement to verify whether the data exists
        if (!empty($this->API->resultSet())) {
            // Loop to retrieve and display the data
            foreach ($this->API->resultSet() as $result) {
                // Assigning the returned value from API.resultSet().LoanDueDate as the parameter for the mutator of Loan.dueDate
                $this->setDueDate($result['LoanDueDate']);
                // Assigning the returned value from API.resultSet().LoanBook as the parameter for the mutator of Book.isbn
                $this->Book->setIsbn($result['LoanBook']);
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
                        <div id='dueDate'>
                            <h1>
                                Due Date:
                            </h1>
                            <h1>
                                {$this->getDueDate()}
                            </h1>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "
            <div id='notFound'>
                <h2 id='success'>
                    No book has been borrowed! You can borrow all the books that you want as long as it does not exceed the limit. 😉
                </h2>
            </div>";
            header("refresh:2; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member");
        }
    }
    // Record Return method
    public function recordReturn() {
        // Assigning the value returned by the Cookie as the parameter for the mutator for Loan.id
        $this->setId($_COOKIE["id"]);
        // Preparing the query
        $this->API->query("SELECT * FROM LibrarySystem.Loan WHERE LoanId = :LoanId");
        // Binding the value for security purpose
        $this->API->bind(":LoanId", $this->getId());
        // Executing the query
        $this->API->execute();
        // If-statement to verify whether the data exists
        if (!empty($this->API->resultSet())) {
            // Retrieving all the variables and assigning all of them to their respective class variables
            // Assigning the value returned for API.resultSet()['LoanId'] as the parameter for Loan.id
            $this->setId($this->API->resultSet()[0]['LoanId']);
            // Assigning the value returned for API.resultSet()['LoanOverdue'] as the parameter for Loan.overdue
            $this->setOverdue($this->API->resultSet()[0]['LoanOverdue']);
            // Assigning the value returned for API.resultSet()['LoanPerson'] as the parameter for Loan.person
            $this->setPerson($this->API->resultSet()[0]['LoanPerson']);
            // Assigning the value returned for API.resultSet()['LoanBook'] as the parameter for Loan.book
            $this->setBook($this->API->resultSet()[0]['LoanBook']);
            // Assigning the value returned for API.resultSet()['LoanReturned'] as the parameter for Loan.returned
            $this->setReturned($this->API->resultSet()[0]['LoanReturned']);
            // Calling Set Date Returned method
            $this->setDateReturned();
            // Converting the value returned from API.resultSet()[0]['LoanDueDate']
            $dueDate = new DateTime($this->API->resultSet()[0]['LoanDueDate']);
            // Converting the value returned from Loan.getDateReturned()
            $dateReturned = new DateTime($this->getDateReturned());
            // Calling the difference between the due date and the date returned
            $days = $dueDate->diff($dateReturned)->format("%d");
            // If-statement to verify whether the book is not returned in late
            if ($days >= 0) {
                // Assigning 1 as the parameter for the mutator of Loan.returned
                $this->setReturned(1);
                // Assigning 0 as the parameter for the mutator for Loan.overdue
                $this->setOverdue(0);
                // Preparing the query
                $this->API->query("UPDATE LibrarySystem.Loan SET LoanDateReturned = :LoanDateReturned, LoanReturned = :LoanReturned, LoanOverdue = :LoanOverdue WHERE LoanId = :LoanId");
                // Binding all the values for security purposes
                $this->API->bind(":LoanId", $this->getId());
                $this->API->bind(":LoanDateReturned", $this->getDateReturned());
                $this->API->bind(":LoanReturned", $this->getReturned());
                $this->API->bind(":LoanOverdue", $this->getOverdue());
                // Executing the query
                $this->API->execute();
                // Assigning the value returned from Loan.getBook() as the parameter for the mutator of Book.isbn
                $this->Book->setIsbn($this->getBook());
                // Preparing the query
                $this->API->query("SELECT * FROM LibrarySystem.Book WHERE BookIsbn = :BookIsbn");
                // Binding the value security purposes
                $this->API->bind(":BookIsbn", $this->Book->getIsbn());
                // Executing the query
                $this->API->execute();
                // If-statement to verify whether the data exists
                if (!empty($this->API->resultSet())) {
                    // Assigning the value returned from API.resultSet()[0]['BookStock'] as the parameter for the mutator of Book.stock
                    $this->Book->setStock($this->API->resultSet()[0]['BookStock']);
                    // Calculating the new stock
                    $newStock = $this->Book->getStock() + 1;
                    // Assigning New Stock as the parameter for the mutator of Book.stock
                    $this->Book->setStock($newStock);
                    // Preparing the query
                    $this->API->query("UPDATE LibrarySystem.Book SET BookStock = :BookStock WHERE BookIsbn = :BookIsbn");
                    // Binding all the values for security purposes
                    $this->API->bind(":BookIsbn", $this->Book->getIsbn());
                    $this->API->bind(":BookStock", $this->Book->getStock());
                    // Executing the query
                    $this->API->execute();
                    echo "
                    <h2 id='success'>
                        The book has been returned
                    </h2>";
                    header("refresh:2; url=http://stormysystem.ddns.net/LibraryManagementSystem/Admin/Profile/Loan_Management");
                } else {
                    echo "
                    <h2 id='failure'>
                        There is an issue with the system!  The page will refresh to fix the issue...
                    </h2>";
                    header("refresh:1; url=http://stormysystem.ddns.net/LibraryManagementSystem/Admin/Profile/Loan_Management");
                }
            } else {
                // Converting the value returned from API.resultSet()[0]['LoanDueDate']
                $dueDate = new DateTime($this->API->resultSet()[0]['LoanDueDate']);
                // Converting the value returned from Loan.getDateReturned()
                $dateReturned = new DateTime($this->getDateReturned());
                // Calling the difference between the due date and the date returned
                $days = $dueDate->diff($dateReturned)->format("%d");
                // Calculating the fine
                $totalFine = $days * 25;
                $fine = String.format("%.2f", $totalFine);
                echo "
                <div id='overdue'>
                    <form method='post'>
                        <input type='submit' value='Pay Rs {$fine}' name='payFine' />
                    </form>
                </div>";
                // If-statement to verify whether the Pay Fine button is pressed
                if (isset($_POST["payFine"])) {
                    // Assigning 1 as the parameter for the mutator for Loan.returned
                    $this->setReturned(1);
                    // Assigning 0 as the parameter for the mutator for Loan.overdue
                    $this->setOverdue(0);
                    // Preparing the query
                    $this->API->query("UPDATE LibrarySystem.Loan SET LoanDateReturned = :LoanDateReturned, LoanReturned = :LoanReturned, LoanOverdue = :LoanOverdue WHERE LoanId = :LoanId");
                    // Binding all the values for security purposes
                    $this->API->bind(":LoanId", $this->getId());
                    $this->API->bind(":LoanDateReturned", $this->getDateReturned());
                    $this->API->bind(":LoanReturned", $this->getReturned());
                    $this->API->bind(":LoanOverdue", $this->getOverdue());
                    // Executing the query
                    $this->API->execute();
                    // Assigning the value returned from Loan.getBook() as the parameter for the mutator of Book.isbn
                    $this->Book->setIsbn($this->getBook());
                    // Preparing the query
                    $this->API->query("SELECT * FROM LibrarySystem.Book WHERE BookIsbn = :BookIsbn");
                    // Binding the value security purposes
                    $this->API->bind(":BookIsbn", $this->Book->getIsbn());
                    // Executing the query
                    $this->API->execute();
                    // If-statement to verify whether the data exists
                    if (!empty($this->API->resultSet())) {
                        // Assigning the value returned from API.resultSet()[0]['BookStock'] as the parameter for the mutator of Book.stock
                        $this->Book->setStock($this->API->resultSet()[0]['BookStock']);
                        // Calculating the new stock
                        $newStock = $this->Book->getStock() + 1;
                        // Assigning New Stock as the parameter for the mutator of Book.stock
                        $this->Book->setStock($newStock);
                        // Preparing the query
                        $this->API->query("UPDATE LibrarySystem.Book SET BookStock = :BookStock WHERE BookIsbn = :BookIsbn");
                        // Binding all the values for security purposes
                        $this->API->bind(":BookIsbn", $this->Book->getIsbn());
                        $this->API->bind(":BookStock", $this->Book->getStock());
                        // Executing the query
                        $this->API->execute();
                        echo "
                        <h2 id='success'>
                            The book has been returned and the fine has been paid!
                        </h2>";
                    } else {
                        echo "
                        <h2 id='failure'>
                            There is an issue with the system!  The page will refresh to fix the issue...
                        </h2>";
                        header("refresh:1; url=http://stormysystem.ddns.net/LibraryManagementSystem/Admin/Profile/Loan_Management");
                    }
                }
            }
        } else {
            echo "
            <h2 id='failure'>
                There is an issue with the system!  The page will refresh to fix the issue...
            </h2>";
            header("refresh:1; url=http://stormysystem.ddns.net/LibraryManagementSystem/Admin/Profile/Loan_Management");
        }
    }
    // Search method
    public function search() {
        // Preparing the query
        $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserMailAddress = :UserMailAddress");
        // Binding the value for security reason
        $this->API->bind(":UserMailAddress", $_GET["person"]);
        // Executing the query
        $this->API->execute();
        // If-statement to verify whether the data exists
        if (!empty($this->API->resultSet())) {
            // Assigning the value returned from API.resultSet()[0]['UserId'] as the parameter for the mutator for Reservation.person
            $this->setPerson($this->API->resultSet()[0]['UserId']);
            // Preparing the query
            $this->API->query("SELECT * FROM LibrarySystem.Book WHERE BookTitle = :BookTitle");
            // Binding the value for security purpose
            $this->API->bind(":BookTitle", $_GET["book"]);
            // Executing the query
            $this->API->execute();
            // If-statement to verify whether the data exists
            if (!empty($this->API->resultSet())) {
                // Assigning the value returned from API.resultSet()[0]['BookIsbn'] as the parameter for the mutator for Reservation.book
                $this->setBook($this->API->resultSet()[0]['BookIsbn']);
                // Preparing the query
                $this->API->query("SELECT * FROM LibrarySystem.Loan WHERE LoanPerson = :LoanPerson AND LoanBook = :LoanBook AND LoanReturned = :LoanReturned");
                // Binding the values for security purposes
                $this->API->bind(":LoanPerson", $this->getPerson());
                $this->API->bind(":LoanBook", $this->getBook());
                $this->API->bind(":LoanReturned", 0);
                // Executing the query
                $this->API->execute();
                // If-statement to verify whether the data exists
                if (!empty($this->API->resultSet())) {
                    // Calling Set Date Returned method
                    $this->setDateReturned();
                    echo "
                    <div id='returnForm'>
                        <form method='post'>
                            <div id='loanIdTime'>
                                <div id='loanId'>
                                    <h1>
                                        ID:
                                    </h1>
                                    <h1>
                                        {$this->API->resultSet()[0]['LoanId']}
                                    </h1>
                                </div>
                                <div id='loanTime'>
                                    <h1>
                                        Time:
                                    </h1>
                                    <h1>
                                        {$this->API->resultSet()[0]['LoanTime']}
                                    </h1>
                                </div>
                            </div>
                            <div id='loanDateDueDate'>
                                <div id='loanDate'>
                                    <h1>
                                        Date:
                                    </h1>
                                    <h1>
                                        {$this->API->resultSet()[0]['LoanDate']}
                                    </h1>
                                </div>
                                <div id='loanDueDate'>
                                    <h1>
                                        Due Date:
                                    </h1>
                                    <h1>
                                        {$this->API->resultSet()[0]['LoanDueDate']}
                                    </h1>
                                </div>
                            </div>
                            <div id='loanPersonBook'>
                                <div id='loanPerson'>
                                    <h1>
                                        Person:
                                    </h1>
                                    <h1>
                                        {$_GET['person']}
                                    </h1>
                                </div>
                                <div id='loanBook'>
                                    <h1>
                                        Book:
                                    </h1>
                                    <h1>
                                        {$_GET['book']}
                                    </h1>
                                </div>
                            </div>
                            <div id='loanDateReturned'>
                                <h1>
                                    Date Returned:
                                </h1>
                                <input type='text' name='dateReturned' value='{$this->getDateReturned()}' />
                            </div>
                            <div id='recordReturn'>
                                <input type='submit' name='recordReturn' value='Return' id='ID {$this->API->resultSet()[0]['LoanId']}' onClick='requestServerAttention(this.id)' />
                            </div>
                        </form>
                    </div>";
                } else {
                    echo "
                    <h1 id='failure'>
                        There is an issue with the system!  The page will refresh to fix the issue...
                    </h1>";
                    header("refresh:2.6; url=http://stormysystem.ddns.net/LibraryManagementSystem/Admin/Profile/Loan_Management");
                }
            } else {
                echo "
                <h1 id='failure'>
                    This book does not exist!
                </h1>";
            }
        } else {
            echo "
            <h1 id='failure'>
                This user does not exist!
            </h1>";
        }
    }
}
?>