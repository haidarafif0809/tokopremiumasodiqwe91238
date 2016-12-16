<?php

date_default_timezone_set("Asia/Jakarta");

// perintah untuk mengkoneksikan php ke database mysql
$db = new mysqli('localhost','root','','toko_surya');


// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


?>