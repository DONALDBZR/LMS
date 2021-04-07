CREATE DATABASE LibrarySystem;
CREATE TABLE LibrarySystem.User (
    UserId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    UserMailAddress VARCHAR(64) NOT NULL,
    UserPassword VARCHAR(32) NOT NULL,
    UserStudentId VARCHAR(32),
    UserType INT,
    UserProfilePicture VARCHAR(64)
);