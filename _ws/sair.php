<?
session_start();

unset($_SESSION['ID']);

session_destroy();
Header("Location: login.php"); 

?>