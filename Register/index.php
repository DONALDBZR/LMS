<?php
// Importing User.php
require $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/User.php';
// Instantiation User
$User = new User();
// Starting Output Buffer
ob_start();
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
            <div id="left"></div>
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
                <div id="studentRegistrationForm">
                    <form method="post">
                        <input type="email" name="mailAddress" id="mailAddress" placeholder="Mail Address" required />
                        <div id="mailAddressNotice">
                            You need to use your UDM Mail to register into this system.
                        </div>
                        <input type="text" name="studentId" id="studentId" placeholder="Student ID" />
                        <div id="studentIdNotice">
                            You need to use either your NTA bus pass or your UDM Student ID to register into the system.
                        </div>
                        <input type="submit" value="Register" id="registerButton" name="register" class="student" onClick="requestServerAttention(this.className)" />
                    </form>
                </div>
                <div id="staffRegistrationForm">
                    <form method="post">
                        <input type="email" name="mailAddress" id="mailAddress" placeholder="Mail Address" required />
                        <div id="mailAddressNotice">
                            You need to use your UDM Mail to register into this system.
                        </div>
                        <label for="type">
                            Staff's Type:
                        </label>
                        <select name="type" id="type" required>
                            <option value=""></option>
                            <option value="academics">
                                Academics
                            </option>
                            <option value="non-academics">
                                Non-Academics
                            </option>
                        </select>
                        <div id="typeNotice">
                            You need to choose according to the role that you occupy in the organization. 
                        </div>
                        <input type="submit" value="Register" id="registerButton" class="staff" name="register" onClick="requestServerAttention(this.className)" />
                    </form>
                </div>
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
<?php
// Storing the contents of the output buffer into a variable
$html = ob_get_contents();
// Deleting the contents of the output buffer.
ob_end_clean();
// Printing the html page
echo $html;
?>