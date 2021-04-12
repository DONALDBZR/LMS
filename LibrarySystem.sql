-- Creating Library System's database
CREATE DATABASE LibrarySystem;
-- Creating User's Table
CREATE TABLE LibrarySystem.User (
    UserId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    UserMailAddress VARCHAR(64) NOT NULL,
    UserPassword VARCHAR(32) NOT NULL,
    UserStudentId VARCHAR(32),
    UserType INT,
    UserProfilePicture VARCHAR(128)
);
-- Creating Book's Table
CREATE TABLE LibrarySystem.Book (
    BookIsbn INT PRIMARY KEY,
    BookStock INT,
    BookAuthor VARCHAR(64),
    BookTitle VARCHAR(64),
    BookPublisher VARCHAR(64),
    BookCover VARCHAR(64),
    BookBookLocation VARCHAR(32),
    BookState INT(1),
    BookCategory VARCHAR(64)
);
-- Creating Reservation's Table
CREATE TABLE LibrarySystem.Reservation (
    ReservationId INT PRIMARY KEY AUTO_INCREMENT,
    ReservationPriority INT,
    ReservationBorrowed BIT,
    ReservationPerson INT,
    ReservationBook INT,
    CONSTRAINT fkReservationPersonUserId FOREIGN KEY (ReservationPerson) REFERENCES LibrarySystem.User (UserId),
    CONSTRAINT fkReservationBookBookIsbn FOREIGN KEY (ReservationBook) REFERENCES LibrarySystem.Book (BookIsbn)
);
-- Creating Loan's Table
CREATE TABLE LibrarySystem.Loan (
    LoanId INT PRIMARY KEY AUTO_INCREMENT,
    LoanTime VARCHAR(16),
    LoanDate VARCHAR(32),
    LoanDueDate VARCHAR(32),
    LoanDateReturned VARCHAR(32),
    LoanReturned BIT,
    LoanOverdue BIT,
    LoanPerson INT,
    LoanBook INT,
    CONSTRAINT fkLoanPersonUserId FOREIGN KEY (LoanPerson)  REFERENCES LibrarySystem.User (UserId),
    CONSTRAINT fkLoanBookBookIsbn FOREIGN KEY (LoanBook) REFERENCES LibrarySystem.Book (BookIsbn)
);
