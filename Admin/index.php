<?php
// Starting Session
session_start();
// Importing User.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/User.php';
// Importing Admin.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibrarySystem/Admin.php';
// Instantiating User
$User = new User();
// Instantiating Admin
$Admin = new Admin();
// Starting Output Buffer
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Stylesheets/AdminHomepage.css">
    <link rel="shortcut icon" href="../Images/Logo.ico" type="image/x-icon">
    <script src="../Scripts/Font-Awesome.js"></script>
    <title>Library System</title>
</head>
<body>
    <nav>
        <div id='homepageSection'></div>
        <div id='navigationBarComponents'>
            <div id="profile">
                <a href="./Profile">
                    <?php
                    $User->profileIcon();
                    ?>
                </a>
            </div>
            <div id="logout"></div>
        </div>
    </nav>
    <h1 id="notice">
        Other functionalities are in the profile page
    </h1>
    <div id="adminForms">
        <div id="report">
            <h1>
                To generate and send the report for the management, click on the report button below.
            </h1>
            <form method="post">
                <div id="reportButton">
                    <input type="submit" value="Report" name="generateReport" />
                </div>
            </form>
        </div>
        <div id="mail">
            <h1>
                Mail Form
            </h1>
            <p>
                Please fill in this form to send a mail reminder.
            </p>
            <form method="post">
                <input type="email" name="mail" id="mailInput" placeholder="E-Mail" required />
                <input type="text" name="message" id="mailMessage" placeholder="Message" required />
                <div id="sendMailButton">
                    <input type="submit" value="Send" id="sendMail" name="sendMailReminder" />
                </div>
            </form>
        </div>
    </div>
    <div id="response">
        <?php
        // If-statement to verify whether the Generate Report button is pressed
        if (isset($_POST["generateReport"])) {
            // Calling Generate Report method
            $Admin->generateReport();
        }
        // If-statement to verify whether the Send Mail Reminder is pressed
        if (isset($_POST["sendMailReminder"])) {
            // Calling Send Mail Reminder method
            $Admin->sendMailReminder();
        }
        ?>
    </div>
    <!-- CDN Scripts for React.JS -->
    <script crossorigin src="https://unpkg.com/react@17/umd/react.production.min.js" ></script>
    <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js" ></script>
    <!-- Admin Homepage's script -->
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/AdminHomepage.js"></script>
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