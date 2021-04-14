<?php
// Importing API
require_once $_SERVER['DOCUMENT_ROOT'] . "/LibraryManagementSystem/API.php";
// Importing all the dependencies of PHPMailer
require_once $_SERVER['DOCUMENT_ROOT'] . "/LibraryManagementSystem/PHPMailer/src/PHPMailer.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/LibraryManagementSystem/PHPMailer/src/Exception.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/LibraryManagementSystem/PHPMailer/src/SMTP.php";
class Admin extends User {
    // Class variables
    protected $API;
    protected $Mail;
    // Constructor method
    public function __construct() {
        // Instantiating API
        $this->API = new API();
        // Instantiating Mail
        $this->Mail = new PHPMailer\PHPMailer\PHPMailer(true);
    }
    // Get Amount User method
    public function getAmountUser() {
        // Preparing the query
        $this->API->query("SELECT * FROM LibrarySystem.User");
        // Executing the query
        $this->API->execute();
        // Counting the amount of users that are registered in the system.
        $amountUser = count($this->API->resultSet());
        // Returning the amount of users
        return $amountUser;
    }
    // Get Amount Banned User method
    public function getAmountBannedUser() {
        // Preparing the query
        $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserType = :UserType");
        // Binding the value for security purposes
        $this->API->bind(":UserType", 0);
        // Executing the query
        $this->API->execute();
        // Counting the amount of banned users that are registered in the system
        $amountBannedUser = count($this->API->resultSet());
        // Returning the amount of banned users.
        return $amountBannedUser;
    }
    // Get Amount Book method
    public function getAmountBook() {
        // Preparing the query
        $this->API->query("SELECT * FROM LibrarySystem.Book");
        // Executing the query
        $this->API->execute();
        // Counting the amount of Books that are stored in the library.
        $amountBook = count($this->API->resultSet());
        // Returning the amount of books
        return $amountBook;
    }
    // Get Amount Damaged Book method
    public function getAmountDamagedBook() {
        // Preparing the query
        $this->API->query("SELECT * FROM LibrarySystem.Book WHERE BookState = :BookState");
        // Binding the value for security purposes
        $this->API->bind(":BookState", 0);
        // Executing the query
        $this->API->execute();
        // Counting the amount of damaged books
        $amountDamagedBook =  count($this->API->resultSet());
        // Returning the amount of damaged books
        return $amountDamagedBook;
    }
    // Get Amount Today Loan method
    public function getAmountTodayLoan() {
        $today = date("Y-m-d");
        // Preparing the query
        $this->API->query("SELECT * FROM LibrarySystem.Loan WHERE LoanDate = :LoanDate AND LoanReturned = :LoanReturned");
        // Binding the value for security purposes
        $this->API->bind(":LoanDate", $today);
        $this->API->bind(":LoanReturned", 0);
        // Executing the query
        $this->API->execute();
        // Counting the amount
        $amountTodayLoan = count($this->API->resultSet());
        // Returning the amount of today's loan
        return $amountTodayLoan;
    }
    // Get Amount Overdue method
    public function getAmountOverdue() {
        // Preparing the query
        $this->API->query("SELECT * FROM LibrarySystem.Loan WHERE LoanOverdue = :LoanOverdue");
        // Binding the value for security purpose
        $this->API->bind(":LoanOverdue", 1);
        // Executing the query
        $this->API->execute();
        // Counting the amount of overdued loans
        $amountOverdue = count($this->API->resultSet());
        // Returning the amount of overdued loans
        return $amountOverdue;
    }
    // Generate Report method
    public function generateReport() {
        $report = "Amount of Users: {$this->getAmountUser()}
        \r\nAmount of Banned Users: {$this->getAmountBannedUser()}
        \r\nAmount of Books: {$this->getAmountBook()}
        \r\nAmount of Damaged Books: {$this->getAmountDamagedBook()}
        \r\nAmount of Today's Loan: {$this->getAmountTodayLoan()}
        \r\nAmount of Overdue: {$this->getAmountOverdue()}";
        // Assigning the value returned by the Session's ID as the parameter for User.setId()
        $this->setId($_SESSION["id"]);
        // Preparing the query
        $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserId = :UserId");
        // Binding the value for security purposes
        $this->API->bind(":UserId", $this->getId());
        // Executing the query
        $this->API->execute();
        // If-statement to verify whether the data exists
        if (!empty($this->API->resultSet())) {
            // Assigning the value returned by API.resultSet()[0]['UserMailAddress'] as the parameter for User.setMailAddress
            $this->setMailAddress($this->API->resultSet()[0]['UserMailAddress']);
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
            $this->Mail->addAddress($this->getMailAddress());
            $this->Mail->subject = "Library System: Notification";
            $this->Mail->Body = $report;
            // Sending the mail.
            $this->Mail->send();
            echo "
            <h1 id='success'>
                The report has been sent!
            </h1>";
            header('refresh:4.2; url=http://stormysystem.ddns.net/LibraryManagementSystem/Admin');
        } else {
            echo "
            <h1 id='failure'>
                There is an error in the system! The page will refresh to fix the issue.
            </h1>";
            header('refresh:1.2; url=http://stormysystem.ddns.net/LibraryManagementSystem/Admin');
        }
    }
    // Send Mail Reminder method
    public function sendMailReminder() {
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
        $this->Mail->addAddress($_POST['mail']);
        $this->Mail->subject = "Library System: Notification";
        $this->Mail->Body = $_POST['message'];
        // Sending the mail.
        $this->Mail->send();
        echo "
        <h1 id='success'>
            The mail has been sent!
        </h1>";
        header('refresh:3.2; url=http://stormysystem.ddns.net/LibraryManagementSystem/Admin');
    }
}
?>