<?php
// Importing the front-end page
include $_SERVER['DOCUMENT_ROOT'] . '/LibraryManagementSystem/Pages/MemberLogout.html';
// Starting session which is related to its session ID.
session_start();
// Destroying the session that was started.
session_destroy();
// It will redirect the user after printing that message that was stored earlier.
header('refresh:3.4; url=http://stormysystem.ddns.net/LibraryManagementSystem');
?>