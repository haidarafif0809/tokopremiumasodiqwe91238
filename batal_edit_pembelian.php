<?php 
    
include 'db.php';
include 'sanitasi.php';

$no_faktur = stringdoang($_POST['no_faktur']);

$query = $db->query("DELETE FROM tbs_pembelian WHERE no_faktur = '$no_faktur'");
    
    if ($query == TRUE){
        header('location:pembelian.php');
    }
    else{
        echo "failed";
    }

mysqli_close($db);
        
?>