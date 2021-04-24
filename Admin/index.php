<?php
// Starting Session
session_start();
// Importing User.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/User.php';
// Importing Admin.php
require_once $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/Admin.php';
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../Scripts/AdminHomepageMain.js"></script>
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
    <div id="dashboard">
        <div id="up">
            <div id="contents">
                <div id="user" class="left"></div>
                <div id="right">
                    <?php
                    echo $Admin->getAmountUser();
                    ?>
                </div>
            </div>
            <div id="contents">
                <div id="book" class="left"></div>
                <div id="right">
                    <?php
                    echo $Admin->getAmountBook();
                    ?>
                </div>
            </div>
            <div id="contents">
                <div id="loan" class="left"></div>
                <div id="right">
                    <?php
                    echo $Admin->getAmountTodayLoan();
                    ?>
                </div>
            </div>
        </div>
        <div id="down">
            <div id="contents">
                <div class="left" id="bannedUser"></div>
                <div id="right">
                    <?php
                    echo $Admin->getAmountBannedUser();
                    ?>
                </div>
            </div>
            <div id="contents">
                <div class="left" id="damagedBook"></div>
                <div id="right">
                    <?php
                    echo $Admin->getAmountDamagedBook();
                    ?>
                </div>
            </div>
            <div id="contents">
                <div class="left" id="overdue"></div>
                <div id="right">
                    <?php
                    echo $Admin->getAmountOverdue();
                    ?>
                </div>
            </div>
        </div>
        <div id="clock"></div>
    </div>
    <div id="actions">
        <div id="generateReport"></div>
        <div id="sendMailReminder">
            <button class="fa fa-envelope faSendMailReminder" id="formSendButton" onClick="showForm(this.id)"></button>
            <div>
                Send Mail Reminder
            </div>
        </div>
    </div>
    <div id="sendForm">
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
    <?php
    // If-Statement to verify whether the Report button is pressed.
    if (isset($_GET["report"])) {
        // Calling Generate Report method
        $Admin->generateReport();
    }
    // If-Statement to verify whether the Send button is pressed.
    if (isset($_POST["sendMailReminder"])) {
        // Calling Generate Report method
        $Admin->sendMailReminder();
    }
    ?>
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