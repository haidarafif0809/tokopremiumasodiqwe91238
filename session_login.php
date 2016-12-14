<?php session_start();


if ($_SESSION['user_name'] == '')
{

header('location:index.php');

}

 ?>