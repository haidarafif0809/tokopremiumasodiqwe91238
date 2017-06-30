<?php session_start();


if ($_SESSION['user_name'] == '')
{

   echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
}

 ?>