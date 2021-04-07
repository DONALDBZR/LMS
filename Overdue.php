<?php
require $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/API.php';
require $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/Loan.php';
class Overdue {
    // Class variables
    private int $id;
    private int $loan;
    private bool $dealtWith;
    private string $dueDate;
    private string $dateReturned;
    private float $fine;
    protected $API;
    protected $Loan;
    // Constructor method
    public function __construct() {
        $this->API = new API();
        $this->Loan = new Loan();
    }
    // Id accessor method
    public function getId() {
        return $this->id;
    }
    // Loan accessor method
    public function getLoan() {
        return $this->loan;
    }
    // Dealt With accessor method
    public function getDealtWith() {
        return $this->dealtWith;
    }
    // Due Date accessor method
    public function getDueDate() {
        return $this->dueDate;
    }
    // Date Returned accessor method
    public function getDateReturned() {
        return $this->dateReturned;
    }
    // Fine accessor method
    public function getFine() {
        return $this->fine;
    }
    // Id mutator method
    public function setId($id) {
        $this->id = $id;
    }
    // Loan mutator method
    public function setLoan($loan) {
        $this->loan = $loan;
    }
    // Dealt With mutator method
    public function setDealtWith($dealtWith) {
        $this->dealtWith = $dealtWith;
    }
    // Due Date mutator method
    public function setDueDate($dueDate) {
        $this->dueDate = $dueDate;
    }
    // Date Returned mutator method
    public function setDateReturned($dateReturned) {
        $this->dateReturned = $dateReturned;
    }
    // Fine mutator method
    public function setFine($fine) {
        $this->fine = $fine;
    }
    // List Overdue Book method
    public function listOverdueBook() {
        $this->API->query("SELECT * FROM Overdue");
        $this->API->execute();
        if (count($this->API->resultSet()) > 0) {
            $length = count($this->API->resultSet());
            for ($index = 0; $index < $length; $index++) { 
                echo $this->API->resultSet()[index];
            }
        } else {
            echo "There is no book which is overdued!";
        }
    }
    // Calculate Fine method
    public function calculateFine() {
        $dueDate = new DateTime($this->getDueDate());
        $dateReturned = new DateTime($this->getDateReturned());
        $days = $dateReturned->diff($dueDate)->format('%a');
        $totalFine = days * 25;
        $this->setFine($totalFine);
        $this->API->query("UPDATE Overdue SET OverdueFine = :OverdueFine WHERE OverdueLoan = :OverdueLoan");
        $this->API->bind(":OverdueFine", $this->getFine());
        $this->API->bind(":OverdueLoan", $this->getLoan());
        $this->API->execute();
        echo "Fine: Rs " . String.format("%.2f", $this->getFine());
    }
}
?>