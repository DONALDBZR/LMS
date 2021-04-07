<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/User.php';
// This function will ensure that the Front-End page will be sent only once to the client without creating a bug which will prevent the page to redirect afterwards.
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://stormysystem.ddns.net/LibraryManagementSystem/Stylesheets/MemberEditProfile.css">
    <link rel="shortcut icon" href="http://stormysystem.ddns.net/LibraryManagementSystem/Images/Logo.ico" type="image/x-icon">
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/Font-Awesome.js"></script>
    <title>Library System</title>
</head>
<body>
    <nav>
        <div id='homepageSection'></div>
        <div id='navigationBarComponents'>
            <div id="profile">
                <a href="../">
                    <?php
                    $User = new User();
                    $User->profileIcon();
                    ?>
                </a>
            </div>
            <div id="logout">
                <a href="http://stormysystem.ddns.net/LibraryManagementSystem/Member/Logout">
                    <i class="fa fa-sign-out faLogoutCustom"></i>
                </a>
            </div>
        </div>
    </nav>
    <div id="information">
        <form action="" method="post" enctype="multipart/form-data">
            <div id="formHeader"></div>
            <div id="mail">
                <h1 id="contents">
                    Mail Address: 
                </h1>
                <div id="contents">
                    <div id="UserGetMailAddress">
                        <?php
                        echo $User->getMailAddress();
                        ?>
                    </div>
                    <div id="mailNotice">
                        This account is linked to this mail address, hence, the mail address cannot be changed!
                    </div>
                </div>
            </div>
            <div id="accountId">
                <h1 id="contents">
                    Account ID: 
                </h1>
                <div id="contents">
                    <div id="UserGetId">
                        <?php
                        echo $User->getId();
                        ?>
                    </div>
                    <div id="idNotice">
                        It is the unique identifier of this account, hence, it cannot be changed.
                    </div>
                </div>
            </div>
            <div id="type">
                <h1 id="contents">
                    Account Type: 
                </h1>
                <div id="contents">
                    <div id="UserGetType">
                        <?php
                        echo $User->profileTypeChecker();
                        ?>
                    </div>
                    <div id="typeNotice">
                        It is the type of the account which is limited by your position in the organization.  For any changes to be made, please contact an administrator.
                    </div>
                </div>
            </div>
            <div id="studentId">
                <h1 id="contents">
                    Student ID: 
                </h1>
                <div id="contents">
                    <div id="UserGetStudentId">
                        <?php
                        echo $User->getStudentId();
                        ?>
                    </div>
                    <div id="studentIdNotice">
                        It is the student identity card that is either provided by NTA or by the organization.  For any changes to be made, please contact an administrator.
                    </div>
                </div>
            </div>
            <div id="passwordSection"></div>
            <div id="profilePicture">
                <h1 id="contents">
                    Profile Picture: 
                </h1>
                <div id="contents">
                    <button class="fa fa-upload faUploadCustom"></button>
                    <input type="file" name="image" accept="image/*" id="oldUploadButton" required />
                    <div id="profilePictureNotice">
                        Just for some creativity but have some restraints as NSFW files will not be accepted in this system.
                    </div>
                </div>
            </div>
            <div id="editProfileButton"></div>
        </form>
    </div>
    <?php
    if (isset($_POST['edit'])) {
        $User->changeProfilePicture();
        $User->changePassword();
    }
    ?>
    <!-- CDN Scripts for React.JS -->
    <script crossorigin src="https://unpkg.com/react@17/umd/react.production.min.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js"></script>
    <!-- Login's script -->
    <script src="http://stormysystem.ddns.net/LibraryManagementSystem/Scripts/MemberEditProfile.js"></script>
</body>
</html>
<?php
$out = ob_get_contents();
ob_end_clean();
echo $out;
?>