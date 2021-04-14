<?php
// Importing API
require_once $_SERVER['DOCUMENT_ROOT'] . "/LibraryManagementSystem/API.php";
// Importing all the dependencies of PHPMailer
require_once $_SERVER['DOCUMENT_ROOT'] . "/LibraryManagementSystem/PHPMailer/src/PHPMailer.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/LibraryManagementSystem/PHPMailer/src/Exception.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/LibraryManagementSystem/PHPMailer/src/SMTP.php";
// User class
class User {
    // Class variables
    private int $id;
    private string $mailAddress;
    private string $password;
    private string $studentId;
    private int $type;
    private string $profilePicture;
    protected $API;
    protected $Mail;
    // Constructor method
    public function __construct() {
        $this->API = new API();
        $this->Mail = new PHPMailer\PHPMailer\PHPMailer(true);
    }
    // ID accessor method
    public function getId() {
        return $this->id;
    }
    // Mail Address accessor method
    public function getMailAddress() {
        return $this->mailAddress;
    }
    // Password accessor method
    public function getPassword() {
        return $this->password;
    }
    // Student Id accessor method
    public function getStudentId() {
        return $this->studentId;
    }
    // Type accessor method
    public function getType() {
        return $this->type;
    }
    // Profile Picture accessor method
    public function getProfilePicture() {
        return $this->profilePicture;
    }
    // ID mutator method
    public function setId($id) {
        $this->id = $id;
    }
    // Mail Address mutator method
    public function setMailAddress($mailAddress) {
        $this->mailAddress = $mailAddress;
    }
    // Password mutator method
    public function setPassword($password) {
        $this->password = $password;
    }
    // Student ID mutator method
    public function setStudentID($studentId) {
        $this->studentId = $studentId;
    }
    // Type mutator method
    public function setType($type) {
        $this->type = $type;
    }
    // Profile Picture mutator method
    public function setProfilePicture($profilePicture) {
        $this->profilePicture = $profilePicture;
    }
    // Register method
    public function register() {
        // If-statement to verify which form is handled by verifying the value returned from the cookie
        if ($_COOKIE["type"] == "student") {
            // Setting the mail address from the register page as a parameter in the mutator.
            $this->setMailAddress($_POST['mailAddress']);
            // Setting the student ID from the register page as a parameter in the mutator.
            $this->setStudentId($_POST['studentId']);
            // Preparing the query to verify if the mail entered is already in the database.
            $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserMailAddress = :UserMailAddress");
            // Binding the value returned by the User class for security purposes.
            $this->API->bind(":UserMailAddress", $this->getMailAddress());
            // Executing the query.
            $this->API->execute();
            // If-statement to verify whether the user does not exist
            if (empty($this->API->resultSet())) {
                // If-statement to verify the mail of the student
                if (strpos($this->getMailAddress(), "@student.udm.ac.mu") == true) {
                    // Assigning 1 as the parameter for the mutator or User.type.
                    $this->setType(1);
                    // Assigning the value returned from Generate Password method as the parameter for password's mutator.
                    $this->setPassword($this->generatePassword());
                    // Adding the Insert query for the User table.
                    $this->API->query("INSERT INTO LibrarySystem.User (UserMailAddress, UserPassword, UserStudentId, UserType) VALUES (:UserMailAddress, :UserPassword, :UserStudentId, :UserType)");
                    // Binding all the required values for security purposes.
                    $this->API->bind(":UserMailAddress", $this->getMailAddress());
                    $this->API->bind(":UserPassword", $this->getPassword());
                    $this->API->bind(":UserStudentId", $this->getStudentId());
                    $this->API->bind(":UserType", $this->getType());
                    // Executing the query added on line 90.
                    $this->API->execute();
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
                    $this->Mail->Username = "";
                    // Sender's password
                    $this->Mail->Password = "";
                    // Assigning sender as a parameter in the sender's zone.
                    $this->Mail->setFrom($this->Mail->Username);
                    // Assinging the receiver mail's address which is retrieved from the User class.
                    $this->Mail->addAddress($this->getMailAddress());
                    $this->Mail->subject = "Library System: Notification";
                    $this->Mail->Body = "Your password is " . $this->getPassword() . ".  Please consider to change your password after logging in!";
                    // Sending the mail.
                    $this->Mail->send();
                    echo "
                    <h1 id='success'>
                        You have been registered into the system, you will be redirected to the login page.
                    </h1>";
                    // Redirecting the user towards the Login page.
                    header('refresh:5.8; url = http://stormysystem.ddns.net/LibraryManagementSystem/Login');
                } else {
                    echo "
                    <h1 id='failure'>
                        You cannot have access to this service as you are not a member of this organization!
                    </h1>";
                }
            } else {
                echo "
                <h1 id='failure'>
                    You already have an account on the system!  You will be redirected to the login page!
                </h1>";
                // Redirecting the user towards the Login page.
                header('refresh:1.2; url=http://stormysystem.ddns.net/LibraryManagementSystem/Login');
            }
        } elseif ($_COOKIE["type"] == "staff") {
            // Setting the mail address from the register page as a parameter in the mutator.
            $this->setMailAddress($_POST['mailAddress']);
            // Preparing the query to verify if the mail entered is already in the database.
            $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserMailAddress = :UserMailAddress");
            // Binding the value returned by the User class for security purposes.
            $this->API->bind(":UserMailAddress", $this->getMailAddress());
            // Executing the query.
            $this->API->execute();
            // If-statement to verify whether the user does not exist
            if (empty($this->API->resultSet())) {
                // If-statement to verify the mail of the student
                if (strpos($this->getMailAddress(), "@udm.ac.mu") == true) {
                    // Assigning the value returned by User.registerTypeChecker() as the parameter for the mutator or User.type.
                    $this->setType($this->registerTypeChecker());
                    // Assigning the value returned from Generate Password method as the parameter for password's mutator.
                    $this->setPassword($this->generatePassword());
                    // Adding the Insert query for the User table.
                    $this->API->query("INSERT INTO LibrarySystem.User (UserMailAddress, UserPassword, UserType) VALUES (:UserMailAddress, :UserPassword, :UserType)");
                    // Binding all the required values for security purposes.
                    $this->API->bind(":UserMailAddress", $this->getMailAddress());
                    $this->API->bind(":UserPassword", $this->getPassword());
                    $this->API->bind(":UserType", $this->getType());
                    // Executing the query added on line 90.
                    $this->API->execute();
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
                    $this->Mail->Username = "";
                    // Sender's password
                    $this->Mail->Password = "";
                    // Assigning sender as a parameter in the sender's zone.
                    $this->Mail->setFrom($this->Mail->Username);
                    // Assinging the receiver mail's address which is retrieved from the User class.
                    $this->Mail->addAddress($this->getMailAddress());
                    $this->Mail->subject = "Library System: Notification";
                    $this->Mail->Body = "Your password is " . $this->getPassword() . ".  Please consider to change your password after logging in!";
                    // Sending the mail.
                    $this->Mail->send();
                    echo "
                    <h1 id='success'>
                        You have been registered into the system, you will be redirected to the login page.
                    </h1>";
                    // Redirecting the user towards the Login page.
                    header('refresh:5.6; url = http://stormysystem.ddns.net/LibraryManagementSystem/Login');
                } else {
                    echo "
                    <h1 id='failure'>
                        You cannot have access to this service as you are not a member of this organization!
                    </h1>";
                }
            } else {
                echo "
                <h1 id='failure'>
                    You already have an account on the system!  You will be redirected to the login page!
                </h1>";
                // Redirecting the user towards the Login page.
                header('refresh:1.0; url=http://stormysystem.ddns.net/LibraryManagementSystem/Login');
            }
        }
    }
    // Login method
    public function login() {
        // Setting the mail address from the login page as a parameter in the mutator.
        $this->setMailAddress($_POST['mailAddress']);
        // Setting the password from the login page as a parameter in the mutator.
        $this->setPassword($_POST['password']);
        // Preparing the query to verify if the mail and password entered are already in the database.
        $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserMailAddress = :UserMailAddress AND UserPassword = :UserPassword");
        // Binding the values returned by the User class for security purposes.
        $this->API->bind(":UserMailAddress", $this->getMailAddress());
        $this->API->bind(":UserPassword", $this->getPassword());
        // Executing the query.
        $this->API->execute();
        // Verifying if, the results from the database is 0 and in the case that it is 0, the user will be redirected to the homepage, else, another if-statement will be called where it will verify whether there is a profile picture or a student ID given that in the end, Check Session method will be called.
        if (empty($this->API->resultSet())) {
            echo "
            <h1 id='failure'>
                Incorrect Credentials!
            </h1>";
            // Redirecting towards the login page.
            header('refresh:1.2; url=http://stormysystem.ddns.net/LibraryManagementSystem/Login');
        } else {
            if ($this->API->resultSet()[0]['UserProfilePicture'] != null) {
                if ($this->API->resultSet()[0]['UserStudentId'] != null) {
                    $this->setId($this->API->resultSet()[0]['UserId']);
                    $this->setMailAddress($this->API->resultSet()[0]['UserMailAddress']);
                    $this->setPassword($this->API->resultSet()[0]['UserPassword']);
                    $this->setStudentId($this->API->resultSet()[0]['UserStudentId']);
                    $this->setProfilePicture($this->API->resultSet()[0]['UserProfilePicture']);
                    $this->setType($this->API->resultSet()[0]['UserType']);
                    session_start();
                    $_SESSION["id"] = $this->getId();
                    $this->checkSession();
                } else {
                    $this->setId($this->API->resultSet()[0]['UserId']);
                    $this->setMailAddress($this->API->resultSet()[0]['UserMailAddress']);
                    $this->setPassword($this->API->resultSet()[0]['UserPassword']);
                    $this->setProfilePicture($this->API->resultSet()[0]['UserProfilePicture']);
                    $this->setType($this->API->resultSet()[0]['UserType']);
                    session_start();
                    $_SESSION["id"] = $this->getId();
                    $this->checkSession();
                }
            } else {
                if ($this->API->resultSet()[0]['UserStudentId'] != null) {
                    $this->setId($this->API->resultSet()[0]['UserId']);
                    $this->setMailAddress($this->API->resultSet()[0]['UserMailAddress']);
                    $this->setPassword($this->API->resultSet()[0]['UserPassword']);
                    $this->setStudentId($this->API->resultSet()[0]['UserStudentId']);
                    $this->setType($this->API->resultSet()[0]['UserType']);
                    session_start();
                    $_SESSION["id"] = $this->getId();
                    $this->checkSession();
                } else {
                    $this->setId($this->API->resultSet()[0]['UserId']);
                    $this->setMailAddress($this->API->resultSet()[0]['UserMailAddress']);
                    $this->setPassword($this->API->resultSet()[0]['UserPassword']);
                    $this->setType($this->API->resultSet()[0]['UserType']);
                    session_start();
                    $_SESSION["id"] = $this->getId();
                    $this->checkSession();
                }
            }
        }
    }
    // Check Session method
    public function checkSession() {
        // Verifying if, the session ID is the same as the ID of the user and if, it is the case, another switch-statement will verify will check the account type so that the the system will redirect the user to its designated page.
        if ($_SESSION["id"] == $this->getId()) {
            switch ($this->getType()) {
                case '0':
                    echo "
                    <h1 id='failure'>
                        You cannot have access to this service as you are currently banned from this service!  A mail will be sent to you!
                    </h1>";
                    $this->Mail->IsSMTP();$this->Mail->CharSet = "UTF-8";
                    $this->Mail->Host = "ssl://smtp.gmail.com";
                    $this->Mail->SMTPDebug = 0;
                    $this->Mail->Port = 465;
                    $this->Mail->SMTPSecure = 'ssl';
                    $this->Mail->SMTPAuth = true;
                    $this->Mail->IsHTML(true);$this->Mail->Username = "";
                    $this->Mail->setFrom($this->Mail->Username);
                    $this->Mail->addAddress($this->getMailAddress());
                    $this->Mail->subject = "Library System: Notification";
                    $this->Mail->Body = "You are currently banned from the system!  Before, you can actually get accessed to the system once again, you will have to get it unban by contacting an administrator.";
                    $this->Mail->send();
                    header('refresh:4.4; url=http://stormysystem.ddns.net/LibraryManagementSystem');
                    break;
                case '1':
                    header('refresh:0.2; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member');
                    break;
                case '2':
                    header('refresh:0.2; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member');
                    break;
                case '3':
                    header('refresh:0.2; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member');
                    break;
                case '4':
                    header('refresh:0.2; url=http://stormysystem.ddns.net/LibraryManagementSystem/Admin');
                    break;
                default:
                echo"
                <h1 id='failure'>
                    You cannot have access to this service as you are not a member of this organization!
                </h1>";
                    header('refresh:0.2; url=http://stormysystem.ddns.net/LibraryManagementSystem');
                    break;
            }
        } else {
            echo "
            <h1 id='failure'>
                You cannot have access to this service as you are not a member of this organization!
            </h1>";
            header('refresh:0.2; url=http://stormysystem.ddns.net/LibraryManagementSystem');
        }
    }
    // Generate Password method
    public function generatePassword() {
        return uniqid();
    }
    // Forgot Password method
    public function forgotPassword() {
        // Setting the mail address entered from Reset_Password page as the parameter for the mutator.
        $this->setMailAddress($_POST['mailAddress']);
        // Preparing the query which will fetch data from the database.
        $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserMailAddress = :UserMailAddress");
        // Binding the mail address which is returned from the accessor to prevent any SQL injection in the database.
        $this->API->bind(":UserMailAddress", $this->getMailAddress());
        // Executing the query.
        $this->API->execute();
        // If, the query does not return any value, the user will be redirected to the homepage, else, a mail will be sent to him with a new password and he will be redirected to the login page afterwards.
        if (empty($this->API->resultSet())) {
            echo "
            <h1 id='failure'>
                This mail is not registered in the system!
            </h1>";
            header('refresh:0.2; url=http://stormysystem.ddns.net/LibraryManagementSystem');
        } else {
            $this->setPassword($this->generatePassword());
            $this->API->query("UPDATE LibrarySystem.User SET UserPassword = :UserPassword WHERE UserMailAddress = :UserMailAddress");
            $this->API->bind(":UserMailAddress", $this->getMailAddress());
            $this->API->bind(":UserPassword", $this->getPassword());
            $this->API->execute();
            $this->Mail->IsSMTP();
            $this->Mail->CharSet = "UTF-8";
            $this->Mail->Host = "ssl://smtp.gmail.com";
            $this->Mail->SMTPDebug = 0;
            $this->Mail->Port = 465;
            $this->Mail->SMTPSecure = 'ssl';
            $this->Mail->SMTPAuth = true;
            $this->Mail->IsHTML(true);
            $this->Mail->Username = "";
            $this->Mail->Password = "";
            $this->Mail->setFrom($this->Mail->Username);
            $this->Mail->addAddress($this->getMailAddress());
            $this->Mail->subject = "Library System: Notification";
            $this->Mail->Body = "Your password has been resetted.  Your new password is " . $this->getPassword() . ".";
            $this->Mail->send();
            echo "
            <h1 id='success'>
                Your password have been resetted, you will be redirected to the login page.
            </h1>";
            header('refresh:4; url=http://stormysystem.ddns.net/LibraryManagementSystem/Login');
        }
    }
    // Change Password method
    public function changePassword() {
        $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserId = :UserId");
        $this->API->bind(":UserId", $this->getId());
        $this->API->execute();
        if ($_POST['oldPassword'] == $this->API->resultSet()[0]['UserPassword']) {
            if ($_POST['newPassword'] == $_POST['confirmNewPassword']) {
                $this->setPassword($_POST['newPassword']);
                $this->API->query("UPDATE User SET UserPassword = :UserPassword WHERE UserId = :UserId");
                $this->API->bind(":UserId", $this->getId());
                $this->API->bind(":UserPassword", $this->getPassword());
                $this->API->execute();$this->Mail->IsSMTP();
                $this->Mail->CharSet = "UTF-8";
                $this->Mail->Host = "ssl://smtp.gmail.com";
                $this->Mail->SMTPDebug = 0;
                $this->Mail->Port = 465;
                $this->Mail->SMTPSecure = 'ssl';
                $this->Mail->SMTPAuth = true;
                $this->Mail->IsHTML(true);
                $this->Mail->Username = "";
                $this->Mail->Password = "";
                $this->Mail->setFrom($this->Mail->Username);
                $this->Mail->addAddress($this->getMailAddress());
                $this->Mail->subject = "Library System: Notification";
                $this->Mail->Body = "Your password has been changed.  Your new password is " . $this->getPassword() . ".  If, you are not the one, please consider to reset your password on this link http://stormysystem.ddns.net/LibraryManagementSystem/Reset_Password";
                $this->Mail->send();
                echo "
                <h1 id='success'>
                    Your password has been successfully been changed.  You will be logged out of the system and your new password will be sent to you by mail.
                </h1>";
                header('refresh:4.4; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member/Logout');
            } else {
                echo "
                <h1 id='failure'>
                    The passwords entered, are not identical!
                </h1>";
            }
        } else {
            echo "
            <h1 id='failure'>
                This is not your password!  You will be logged out of this account!
            </h1>";
            header('refresh:0.2; url=http://stormysystem.ddns.net/LibraryManagementSystem/Member/Logout');
        }
    }
    // Change Profile Picture method
    public function changeProfilePicture() {
        // Storing the image directory
        $imageDirectory = "/LibraryManagementSystem/Images/";
        // The path of the image file in the server
        $imageFile = $imageDirectory . basename($_FILES['image']['name']);
        // The uploaded path of the image file in the server.
        $uploadedPath = $_SERVER["DOCUMENT_ROOT"] . $imageFile;
        // Verifying if the picture will actually be uploaded in the Uploaded Path.
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadedPath)) {
            // Assigning the path of the image file as the Profile Picture's mutator.
            $this->setProfilePicture($imageFile);
            // Preparing the query to update the profile picture of the user inside the database.
            $this->API->query("UPDATE User SET UserProfilePicture = :UserProfilePicture WHERE UserId = :UserId");
            // Binding all the values that are going to be inserted in the database for security purposes.
            $this->API->bind(":UserProfilePicture", $this->getProfilePicture());
            $this->API->bind(":UserId", $this->getId());
            // Executing the query.
            $this->API->execute();
            echo "
            <h1 id='success'>
                Your profile picture has been changed!
            </h1>";
        }
    }
    // Freeze Membership method
    public function freezeMembership() {
        // Preparing the query for banning the member in question by changing its account type.
        $this->API->query("UPDATE LibrarySystem.User SET UserType = 0 WHERE UserId = :UserId OR UserMailAddress = :UserMailAddress OR UserStudentId = :UserStudentId");
        // Binding the values for security purposes.
        $this->API->bind(":UserId", $_GET['search']);
        $this->API->bind(":UserMailAddress", $_GET['search']);
        $this->API->bind(":UserStudentId", $_GET['search']);
        // Executing the Update query.
        $this->API->execute();
        // Retrieving data from the database to send a mail to the banned user.
        $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserId = :UserId");
        // Binding the value for the security purposes.
        $this->API->bind(":UserId", $_GET['search']);
        $this->API->execute();
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
        $this->Mail->Username = "";
        // Sender's password
        $this->Mail->Password = "";
        // Assigning sender as a parameter in the sender's zone.
        $this->Mail->setFrom($this->Mail->Username);
        // Assinging the receiver mail's address which is retrieved from the User class.
        $this->Mail->addAddress($this->API->resultSet()[0]['UserMailAddress']);
        $this->Mail->subject = "Library System: Notification";
        $this->Mail->Body = "Your account has been banned!  In order to get it unban please contact an administrator to find out the causes and what should be done for you to get access back into the system.";
        // Sending the mail.
        $this->Mail->send();
        // Message that will be displayed to the administrator.
        echo "
        <h1 id='success'>
            {$this->API->resultSet()[0]['UserMailAddress']} has been banned and a mail has also been sent to him.
        </h1>";
    }
    // Unfreeze Membership method
    public function unfreezeMembership() {
        // Preparing the query to return fields from the value entered entered are already in the database.
        $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserId = :UserId OR UserMailAddress = :UserMailAddress OR UserStudentId = :UserStudentId");
        // Binding the values returned by the User class for security purposes.
        $this->API->bind(":UserId", $_GET["search"]);
        $this->API->bind(":UserMailAddress", $_GET["search"]);
        $this->API->bind(":UserStudentId", $_GET["search"]);
        // Executing the query.
        $this->API->execute();
        // Verifying the mail address of the banned user.
        if (strpos($this->API->resultSet()[0]['UserMailAddress'], "@student.udm.ac.mu")) {
            // Preparing the query for banning the member in question by changing its account type.
            $this->API->query("UPDATE LibrarySystem.User SET UserType = 1 WHERE UserId = :UserId OR UserMailAddress = :UserMailAddress OR UserStudentId = :UserStudentId");
            // Binding the values returned by the User class for security purposes.
            $this->API->bind(":UserId", $_GET["search"]);
            $this->API->bind(":UserMailAddress", $_GET["search"]);
            $this->API->bind(":UserStudentId", $_GET["search"]);
            // Executing the Update query.
            $this->API->execute();
            // Retrieving data from the database to send a mail to the banned user.
            $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserId = :UserId");
            // Binding the value for the security purposes.
            $this->API->bind(":UserId", $_GET['search']);
            $this->API->execute();
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
            $this->Mail->Username = "";
            // Sender's password
            $this->Mail->Password = "";
            // Assigning sender as a parameter in the sender's zone.
            $this->Mail->setFrom($this->Mail->Username);
            // Assinging the receiver mail's address which is retrieved from the User class.
            $this->Mail->addAddress($this->API->resultSet()[0]['UserMailAddress']);
            $this->Mail->subject = "Library System: Notification";
            $this->Mail->Body = "Your account has been unbanned!  You can now have access back into the system.  Welcome back, it is nice to have you back in the system!";
            // Sending the mail.
            $this->Mail->send();
            // Message that will be displayed to the administrator.
            echo "
            <h1 id='success'>
                {$this->API->resultSet()[0]['UserMailAddress']} has been unbanned and a mail has also been sent to him.
            </h1>";
        } else if (strpos($this->API->resultSet()[0]['UserMailAddress'], "@udm.ac.mu")) {
            // Preparing the query for banning the member in question by changing its account type.
            $this->API->query("UPDATE LibrarySystem.User SET UserType = 2 WHERE UserId = :UserId OR UserMailAddress = :UserMailAddress OR UserStudentId = :UserStudentId");
            // Binding the values returned by the User class for security purposes.
            $this->API->bind(":UserId", $_GET["search"]);
            $this->API->bind(":UserMailAddress", $_GET["search"]);
            $this->API->bind(":UserStudentId", $_GET["search"]);
            // Executing the Update query.
            $this->API->execute();
            // Retrieving data from the database to send a mail to the banned user.
            $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserId = :UserId");
            // Binding the value for the security purposes.
            $this->API->bind(":UserId", $_GET['search']);
            $this->API->execute();
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
            $this->Mail->Username = "";
            // Sender's password
            $this->Mail->Password = "";
            // Assigning sender as a parameter in the sender's zone.
            $this->Mail->setFrom($this->Mail->Username);
            // Assinging the receiver mail's address which is retrieved from the User class.
            $this->Mail->addAddress($this->API->resultSet()[0]['UserMailAddress']);
            $this->Mail->subject = "Library System: Notification";
            $this->Mail->Body = "Your account has been unbanned!  You can now have access back into the system.  Welcome back, it is nice to have you back in the system! However, if you are a member of the academical staff you should consider into contacting an administrator to change your account type back just in case";
            // Sending the mail.
            $this->Mail->send();
            // Message that will be displayed to the administrator.
            echo "
            <h1 id='success'>
                {$this->API->resultSet()[0]['UserMailAddress']} has been unbanned and a mail has also been sent to him.
            </h1>";
        } else {
            echo "
            <h1 id='failure'>
                This is not a member of this organization!
            </h1>";
        }
    }
    // Profile Checker method
    public function profileChecker() {
        // Setting the Session ID as a parameter in the User ID which will be used to verify if it exists in the database.
        $this->setId($_SESSION['id']);
        // Preparing the query.
        $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserId = :UserId");
        // Binding the values which will be used in the query to prevent a sql injection.
        $this->API->bind(":UserId", $this->getId());
        // Executing the query
        $this->API->execute();
        // It will verify if there is a profile picture which is related to the User searched, when another if-statement will verify if the User has a student ID.
        if ($this->API->resultSet()[0]['UserProfilePicture'] != null) {
            if ($this->API->resultSet()[0]['UserStudentId'] != null) {
                $this->setMailAddress($this->API->resultSet()[0]['UserMailAddress']);
                $this->setPassword($this->API->resultSet()[0]['UserPassword']);
                $this->setStudentId($this->API->resultSet()[0]['UserStudentId']);
                $this->setProfilePicture($this->API->resultSet()[0]['UserProfilePicture']);
                $this->setType($this->API->resultSet()[0]['UserType']);
            } else {
                $this->setMailAddress($this->API->resultSet()[0]['UserMailAddress']);
                $this->setPassword($this->API->resultSet()[0]['UserPassword']);
                $this->setProfilePicture($this->API->resultSet()[0]['UserProfilePicture']);
                $this->setType($this->API->resultSet()[0]['UserType']);
            }
        } else {
            if ($this->API->resultSet()[0]['UserStudentId'] != null) {
                $this->setMailAddress($this->API->resultSet()[0]['UserMailAddress']);
                $this->setPassword($this->API->resultSet()[0]['UserPassword']);
                $this->setStudentId($this->API->resultSet()[0]['UserStudentId']);
                $this->setType($this->API->resultSet()[0]['UserType']);
            } else {
                $this->setMailAddress($this->API->resultSet()[0]['UserMailAddress']);
                $this->setPassword($this->API->resultSet()[0]['UserPassword']);
                $this->setType($this->API->resultSet()[0]['UserType']);
            }
        }
    }
    // Profile Icon method
    public function profileIcon() {
        // Calling Profile Checker method
        $this->profileChecker();
        // The statement will verify there is a profile picture which is related to the user and if, it is the case, it will fetch the url of that picture, else, it will fetch an .svg file from a script.
        if ($this->API->resultSet()[0]['UserProfilePicture'] != null) {
            $pp = "http://stormysystem.ddns.net" . $this->getProfilePicture();
            echo "<img src='{$pp}' />";
        } else {
            echo "<i class='fa fa-user faProfileCustom faProfile'></i>";
        }
    }
    // Profile Mail method
    public function profileMail() {
        // Calling Profile Checker method
        $this->profileChecker();
        // Creating a h1 tag which will be rendered given that User.getMailAddress() is called.
        $h1WelcomeText = "
        <h1>
            Hello, {$this->getMailAddress()}
        </h1>";
        echo $h1WelcomeText;
    }
    // Profile Type Checker method
    public function profileTypeChecker() {
        // This statement will check for the value to print the type into a string given that it is saved in the system as an integer.
        switch ($this->getType()) {
            case 1:
                echo "Student";
                break;
            case 2:
                echo "Non-Academical Staff";
                break;
            case 3:
                echo "Academical Staff";
                break;
            case 4:
                echo "Administrator";
                break;
            default:
                echo "<h1 id='detail'>Banned</h1>";
                break;
        }
    }
    // Search method
    public function search() {
        // Preparing the query to return fields from the value entered that are already in the database.
        $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserId = :UserId OR UserMailAddress = :UserMailAddress OR UserStudentId = :UserStudentId");
        // Binding the values returned by the search bar for security purposes.
        $this->API->bind(":UserId", $_GET["search"]);
        $this->API->bind(":UserMailAddress", $_GET["search"]);
        $this->API->bind(":UserStudentId", $_GET["search"]);
        // Executing the query.
        $this->API->execute();
        // If-statement that will verify that the value entered is in the database or not.
        if (empty($this->API->resultSet())) {
            echo "<h1 id='failure'>{$_GET['search']} does not exist!</h1>";
        } else {
            // Storing the value of the amount found.
            $amountFound = count($this->API->resultSet());
            // Storing html forms that will be used depending on the conditions.
            $studentBanningOptions = "
            <div id='ban'>
                <form method='post'>
                    <input type='submit' value='Ban' id='banButton' name='ban' />
                </form>
            </div>
            ";
            $studentUnbanningOptions = "
            <div id='unban'>
                <form method='post'>
                    <input type='submit' value='Unban' id='unbanButton' name='unban' />
                </form>
            </div>
            ";
            $staffBanningOptions = "
            <div id='options'>
                <div id='ban'>
                    <form method='post'>
                        <input type='submit' value='Ban' name='ban' id='banButton' />
                    </form>
                </div>
                <div id='promote'>
                    <form method='post'>
                        <input type='submit' value='Promote' name='promote' id='promoteButton' />
                    </form>
                </div>
            </div>";
            $staffUnbanningOptions = "
            <div id='options'>
                <div id='unban'>
                    <form method='post'>
                        <input type='submit' value='Unban' name='unban' id='unbanButton' />
                    </form>
                </div>
                <div id='promote'>
                    <form method='post'>
                        <input type='submit' value='Promote' name='promote' id='promoteButton' />
                    </form>
                </div>
            </div>";
            // Displaying the amount of results found.
            echo "
            <div id='amountFound'>
                Amount Found: {$amountFound}
            </div>";
            // Displaying each row that corresponds to the value searched.
            foreach ($this->API->resultSet() as $result) {
                $type;
                switch ($result['UserType']) {
                    case 1:
                        $type = "Student";
                        break;
                    case 2:
                        $type = "Non-Academical Staff";
                        break;
                    case 3:
                        $type = "Academical Staff";
                        break;
                    case 4:
                        $type = "Administrator";
                        break;
                    default:
                        $type = "Banned";
                        break;
                }
                if ($result['UserProfilePicture'] != null) {
                    if (!empty($result['UserStudentId'])) {
                        $pp = "http://stormysystem.ddns.net" . $this->getProfilePicture();
                        if ($result['UserType'] == 0) {
                            echo "
                            <div id='found'>
                                <div id='titlesWithSID'>
                                    <h1>
                                        User ID
                                    </h1>
                                    <h1>
                                        Student ID
                                    </h1>
                                    <h1>
                                        Mail
                                    </h1>
                                    <h1>
                                        Account Type
                                    </h1>
                                    <h1>
                                        Profile Picture
                                    </h1>
                                    <h1>
                                        Actions
                                    </h1>
                                </div>
                                <div id='resultsWithSID'>
                                    <div id='UserID'>
                                        <h1>
                                            {$result['UserId']}
                                        </h1>
                                    </div>
                                    <div id='UserStudentID'>
                                        <h1>
                                            {$result['UserStudentId']}
                                        </h1>
                                    </div>
                                    <div id='UserMailAddress'>
                                        <h1>
                                            {$result['UserMailAddress']}
                                        </h1>
                                    </div>
                                    <div id='UserType'>
                                        <h1>
                                            {$type}
                                        </h1>
                                    </div>
                                    <div id='UserProfilePicture'>
                                        <img src='{$pp}' />
                                    </div>
                                    {$studentUnbanningOptions}
                                </div>
                            </div>";
                        } else if ($result['UserType'] == 1) {
                            echo "
                            <div id='found'>
                                <div id='titlesWithSID'>
                                    <h1>
                                        User ID
                                    </h1>
                                    <h1>
                                        Student ID
                                    </h1>
                                    <h1>
                                        Mail
                                    </h1>
                                    <h1>
                                        Account Type
                                    </h1>
                                    <h1>
                                        Profile Picture
                                    </h1>
                                    <h1>
                                        Actions
                                    </h1>
                                </div>
                                <div id='resultsWithSID'>
                                    <div id='UserID'>
                                        <h1>
                                            {$result['UserId']}
                                        </h1>
                                    </div>
                                    <div id='UserStudentID'>
                                        <h1>
                                            {$result['UserStudentId']}
                                        </h1>
                                    </div>
                                    <div id='UserMailAddress'>
                                        <h1>
                                            {$result['UserMailAddress']}
                                        </h1>
                                    </div>
                                    <div id='UserType'>
                                        <h1>
                                            {$type}
                                        </h1>
                                    </div>
                                    <div id='UserProfilePicture'>
                                        <img src='{$pp}' />
                                    </div>
                                    {$studentBanningOptions}
                                </div>
                            </div>";
                        }
                    } else {
                        $pp = "http://stormysystem.ddns.net" . $this->getProfilePicture();
                        if ($result['UserType'] == 0) {
                            echo "
                            <div id='found'>
                                <div id='titles'>
                                    <h1>
                                        User ID
                                    </h1>
                                    <h1>
                                        Mail
                                    </h1>
                                    <h1>
                                        Account Type
                                    </h1>
                                    <h1>
                                        Profile Picture
                                    </h1>
                                    <h1>
                                        Actions
                                    </h1>
                                </div>
                                <div id='results'>
                                    <div id='UserID'>
                                        <h1>
                                            {$result['UserId']}
                                        </h1>
                                    </div>
                                    <div id='UserMailAddress'>
                                        <h1>
                                            {$result['UserMailAddress']}
                                        </h1>
                                    </div>
                                    <div id='UserType'>
                                        <h1>
                                            {$type}
                                        </h1>
                                    </div>
                                    <div id='UserProfilePicture'>
                                        <img src='{$pp}' />
                                    </div>
                                    {$staffUnbanningOptions}
                                </div>
                            </div>";
                        } else if ($result['UserType'] == 2 || $result['UserType'] == 3) {
                            echo "
                            <div id='found'>
                                <div id='titles'>
                                    <h1>
                                        User ID
                                    </h1>
                                    <h1>
                                        Mail
                                    </h1>
                                    <h1>
                                        Account Type
                                    </h1>
                                    <h1>
                                        Profile Picture
                                    </h1>
                                    <h1>
                                        Actions
                                    </h1>
                                </div>
                                <div id='results'>
                                    <div id='UserID'>
                                        <h1>
                                            {$result['UserId']}
                                        </h1>
                                    </div>
                                    <div id='UserMailAddress'>
                                        <h1>
                                            {$result['UserMailAddress']}
                                        </h1>
                                    </div>
                                    <div id='UserType'>
                                        <h1>
                                            {$type}
                                        </h1>
                                    </div>
                                    <div id='UserProfilePicture'>
                                        <img src='{$pp}' />
                                    </div>
                                    {$staffBanningOptions}
                                </div>
                            </div>";
                        } else if($result['UserType'] == 4) {
                            echo "
                            <div id='found'>
                                <div id='titles'>
                                    <h1>
                                        User ID
                                    </h1>
                                    <h1>
                                        Mail
                                    </h1>
                                    <h1>
                                        Account Type
                                    </h1>
                                    <h1>
                                        Profile Picture
                                    </h1>
                                </div>
                                <div id='resultsForAdmin'>
                                    <div id='UserID'>
                                        <h1>
                                            {$result['UserId']}
                                        </h1>
                                    </div>
                                    <div id='UserMailAddress'>
                                        <h1>
                                            {$result['UserMailAddress']}
                                        </h1>
                                    </div>
                                    <div id='UserType'>
                                        <h1>
                                            {$type}
                                        </h1>
                                    </div>
                                    <div id='UserProfilePicture'>
                                        <img src='{$pp}' />
                                    </div>
                                </div>
                            </div>";
                        }
                    }
                } else {
                    if (!empty($result['UserStudentId'])) {
                        if ($result['UserType'] == 0) {
                            echo "
                            <div id='found'>
                                <div id='titlesWithSID'>
                                    <h1>
                                        User ID
                                    </h1>
                                    <h1>
                                        Student ID
                                    </h1>
                                    <h1>
                                        Mail
                                    </h1>
                                    <h1>
                                        Account Type
                                    </h1>
                                    <h1>
                                        Profile Picture
                                    </h1>
                                    <h1>
                                        Actions
                                    </h1>
                                </div>
                                <div id='resultsWithSID'>
                                    <div id='UserID'>
                                        <h1>
                                            {$result['UserId']}
                                        </h1>
                                    </div>
                                    <div id='UserStudentID'>
                                        <h1>
                                            {$result['UserStudentId']}
                                        </h1>
                                    </div>
                                    <div id='UserMailAddress'>
                                        <h1>
                                            {$result['UserMailAddress']}
                                        </h1>
                                    </div>
                                    <div id='UserType'>
                                        <h1>
                                            {$type}
                                        </h1>
                                    </div>
                                    <div id='UserProfilePicture'>
                                        <i class='fa fa-user faProfile'></i>
                                    </div>
                                    {$studentUnbanningOptions}
                                </div>
                            </div>";
                        } else if ($result['UserType'] == 1) {
                            echo "
                            <div id='found'>
                                <div id='titlesWithSID'>
                                    <h1>
                                        User ID
                                    </h1>
                                    <h1>
                                        Student ID
                                    </h1>
                                    <h1>
                                        Mail
                                    </h1>
                                    <h1>
                                        Account Type
                                    </h1>
                                    <h1>
                                        Profile Picture
                                    </h1>
                                    <h1>
                                        Actions
                                    </h1>
                                </div>
                                <div id='resultsWithSID'>
                                    <div id='UserID'>
                                        <h1>
                                            {$result['UserId']}
                                        </h1>
                                    </div>
                                    <div id='UserStudentID'>
                                        <h1>
                                            {$result['UserStudentId']}
                                        </h1>
                                    </div>
                                    <div id='UserMailAddress'>
                                        <h1>
                                            {$result['UserMailAddress']}
                                        </h1>
                                    </div>
                                    <div id='UserType'>
                                        <h1>
                                            {$type}
                                        </h1>
                                    </div>
                                    <div id='UserProfilePicture'>
                                        <i class='fa fa-user faProfile'></i>
                                    </div>
                                    {$studentBanningOptions}
                                </div>
                            </div>";
                        }
                    } else {
                        if ($result['UserType'] == 0) {
                            echo "
                            <div id='found'>
                                <div id='titles'>
                                    <h1>
                                        User ID
                                    </h1>
                                    <h1>
                                        Mail
                                    </h1>
                                    <h1>
                                        Account Type
                                    </h1>
                                    <h1>
                                        Profile Picture
                                    </h1>
                                    <h1>
                                        Actions
                                    </h1>
                                </div>
                                <div id='results'>
                                    <div id='UserID'>
                                        <h1>
                                            {$result['UserId']}
                                        </h1>
                                    </div>
                                    <div id='UserMailAddress'>
                                        <h1>
                                            {$result['UserMailAddress']}
                                        </h1>
                                    </div>
                                    <div id='UserType'>
                                        <h1>
                                            {$type}
                                        </h1>
                                    </div>
                                    <div id='UserProfilePicture'>
                                        <i class='fa fa-user faProfile'></i>
                                    </div>
                                    {$staffUnbanningOptions}
                                </div>
                            </div>";
                        } else if ($result['UserType'] == 2 || $result['UserType'] == 3) {
                            echo "
                            <div id='found'>
                                <div id='titles'>
                                    <h1>
                                        User ID
                                    </h1>
                                    <h1>
                                        Mail
                                    </h1>
                                    <h1>
                                        Account Type
                                    </h1>
                                    <h1>
                                        Profile Picture
                                    </h1>
                                    <h1>
                                        Actions
                                    </h1>
                                </div>
                                <div id='results'>
                                    <div id='UserID'>
                                        <h1>
                                            {$result['UserId']}
                                        </h1>
                                    </div>
                                    <div id='UserMailAddress'>
                                        <h1>
                                            {$result['UserMailAddress']}
                                        </h1>
                                    </div>
                                    <div id='UserType'>
                                        <h1>
                                            {$type}
                                        </h1>
                                    </div>
                                    <div id='UserProfilePicture'>
                                        <i class='fa fa-user faProfile'></i>
                                    </div>
                                    {$staffBanningOptions}
                                </div>
                            </div>";
                        } else if ($result['UserType'] == 4) {
                            echo "
                            <div id='found'>
                                <div id='titles'>
                                    <h1>
                                        User ID
                                    </h1>
                                    <h1>
                                        Mail
                                    </h1>
                                    <h1>
                                        Account Type
                                    </h1>
                                    <h1>
                                        Profile Picture
                                    </h1>
                                </div>
                                <div id='resultsForAdmin'>
                                    <div id='UserID'>
                                        <h1>
                                            {$result['UserId']}
                                        </h1>
                                    </div>
                                    <div id='UserMailAddress'>
                                        <h1>
                                            {$result['UserMailAddress']}
                                        </h1>
                                    </div>
                                    <div id='UserType'>
                                        <h1>
                                            {$type}
                                        </h1>
                                    </div>
                                    <div id='UserProfilePicture'>
                                        <i class='fa fa-user faProfile'></i>
                                    </div>
                                </div>
                            </div>";
                        }
                    }
                }
            }
        }
    }
    // Promote method
    public function promote() {
        // Preparing the query to return fields from the value entered entered are already in the database.
        $this->API->query("SELECT * FROM LibrarySystem.User WHERE UserId = :UserId OR UserMailAddress = :UserMailAddress OR UserStudentId = :UserStudentId");
        // Binding the values returned by the User class for security purposes.
        $this->API->bind(":UserId", $_GET["search"]);
        $this->API->bind(":UserMailAddress", $_GET["search"]);
        $this->API->bind(":UserStudentId", $_GET["search"]);
        // Executing the query.
        $this->API->execute();
        // Verifying the user type before changing its type.
        if ($this->API->resultSet()[0]['UserType'] == 2) {
            // Preparing the query for banning the member in question by changing its account type.
            $this->API->query("UPDATE LibrarySystem.User SET UserType = 3 WHERE UserId = :UserId OR UserMailAddress = :UserMailAddress OR UserStudentId = :UserStudentId");
            // Binding the values for security purposes.
            $this->API->bind(":UserId", $_GET['search']);
            $this->API->bind(":UserMailAddress", $_GET['search']);
            $this->API->bind(":UserStudentId", $_GET['search']);
            // Executing the Update query.
            $this->API->execute();
        } else if ($this->API->resultSet()[0]['UserType'] == 3) {
            // Preparing the query for banning the member in question by changing its account type.
            $this->API->query("UPDATE LibrarySystem.User SET UserType = 2 WHERE UserId = :UserId OR UserMailAddress = :UserMailAddress OR UserStudentId = :UserStudentId");
            // Binding the values for security purposes.
            $this->API->bind(":UserId", $_GET['search']);
            $this->API->bind(":UserMailAddress", $_GET['search']);
            $this->API->bind(":UserStudentId", $_GET['search']);
            // Executing the Update query.
            $this->API->execute();
        }
    }
    // Register Type Checker method
    public function registerTypeChecker() {
        if ($_POST["type"] == "non-academics") {
            return 2;
        } else if ($_POST["type"] == "academics") {
            return 3;
        }
    }
}
?>
