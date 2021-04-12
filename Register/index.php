<?php
require $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/User.php';
$User = new User();
?>
<!-- Front-End Page -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Library System</title>
        <link rel="stylesheet" href="../Stylesheets/Register.css" />
        <link rel="shortcut icon" href="../Images/Logo.ico" type="image/x-icon" />
        <script src="../Scripts/RegisterMain.js"></script>
    </head>
    <body>
        <header>
            <h1>Library Management System</h1>
        </header>
        <!-- Section -->
        <section>
            <div id="left">
                <img src="../Images/Education.png" />
            </div>
            <div id="right">
                <div id="homeMessage">
                    Welcome to UDM Online System's Registration page
                </div>
                <div id="notice">
                    To register in this system, you should fill this form properly.  Click on the button that correspond to your role in the organization to fill the corresponding form.
                </div>
                <div id="formButtons">
                    <div id="student">
                        <button id="studentFormButton" onClick="showForm(this.id)">
                            Student
                        </button>
                    </div>
                    <div id="staff">
                        <button id="staffFormButton" onClick="showForm(this.id)">
                            Staff
                        </button>
                    </div>
                </div>
                <div id="studentRegistrationForm"></div>
                <div id="staffRegistrationForm"></div>
                <div id="loginSection">
                    Already have an account?  <a href="../Login">Login Here</a>
                </div>
                <?php
                if (isset($_POST['register'])) {
                    $User->register();
                }
                ?>
            </div>
        </section>
        <!-- CDN Scripts for React.JS -->
        <script crossorigin src="https://unpkg.com/react@17/umd/react.production.min.js"></script>
        <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js"></script>
        <!-- Register's script -->
        <script src="../Scripts/Register.js"></script>
    </body>
</html>