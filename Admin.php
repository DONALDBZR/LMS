<?php
require $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/User.php';
require $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/API.php';
require $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/Mail.php';
class Admin extends User {
    // Class variables
    protected $User;
    protected $API;
    protected $Mail;
    // Constructor method
    public function __construct() {
        $this->User = new User();
        $this->API = new API();
        $this->Mail = new Mail();
    }
    // Get Amount User method
    public function getAmountUser() {
        $this->API->query("SELECT * FROM User");
        $this->API->execute();
        return count($this->API->resultSet());
    }
    // Get Amount Banned User method
    public function getAmountBannedUser() {
        $this->API->query("SELECT * FROM User WHERE UserType = 0");
        $this->API->execute();
        return count($this->API->resultSet());
    }
    // Get Amount Book method
    public function getAmountBook() {
        $this->API->query("SELECT * FROM Book");
        $this->API->execute();
        return count($this->API->resultSet());
    }
    // Get Amount Damaged Book method
    public function getAmountDamagedBook() {
        $this->API->query("SELECT * FROM Book WHERE BookState = 0");
        $this->API->execute();
        return count($this->API->resultSet());
    }
    // Get Most Trendy Book method
    // Get Amount Today Loan method
    public function getAmountTodayLoan() {
        $date = DateTime("now")->format("Y-M-D");
        $this->API->query("SELECT * FROM Loan WHERE LoanDate = :LoanDate");
        $this->API->bind(":LoanDate", $date);
        $this->API->execute();
        return count($this->API->resultSet());
    }
    // Get Amount Overdue method
    public function getAmountOverdue() {
        $this->API->query("SELECT * FROM Overdue");
        $this->API->execute();
        return count($this->API->resultSet());
    }
    // Get Amount Fine method
    public function getAmountFine() {
        $date = DateTime("now")->format("Y-M-D");
        $this->API->query("SELECT * Overdue WHERE OverdueDateReturned = :OverdueDateReturned");
        $this->API->bind(":OverdueDateReturned", $date);
        $this->API->execute();
        $length = count($this->API->resultSet());
        $totalFine = 0;
        for ($index = 0; $index < $length; $index++) { 
            $totalFine += $this->API->resultSet()[index]['Fine'];
        }
        return $totalFine;
    }
    // Generate Report method
    public function generateReport() {
        $report = $report . "Amount of Users: " . $this->getAmountUser() . \n;
        $report = $report . "Amount of Banned Users: " . $this->getAmountBannedUser() . \n;
        $report = $report . "Amount of Books: " . $this->getAmountBook() . \n;
        $report = $report . "Amount of Damaged Books: " . $this->getAmountDamagedBook() . \n;
        $report = $report . "Amount of Today's Loan: " . $this->getAmountTodayLoan() . \n;
        $report = $report . "Amount of Overdue: " . $this->getAmountOverdue() . \n;
        $report = $report . "Amount of Fine: Rs " . String.format("%.2f", $this->getAmountFine());
        $this->Mail->AddAddress($_POST['Mail']);
        $this->Mail->body = $report;
        $this->Mail->send();
        echo "The report has been sent!";
    }
    // Send Mail Reminder method
    public function sendMailReminder() {
        $this->Mail->addAddress($_POST['Mail']);
        $this->Mail->body = $_POST['Message'];
        $this->Mail->send();
        echo "The mail has been sent!";
    }
}
?>