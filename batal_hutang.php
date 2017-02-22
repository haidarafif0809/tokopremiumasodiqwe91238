<?php session_start();
//memasukan file db.php
include 'db.php';


$session_id = session_id();

//menghapus seluruh data yang ada pada tabel tbs_pembelian berdasarkan id
$query = $db->query("DELETE FROM tbs_pembayaran_hutang WHERE session_id = '$session_id'");
//jika $query benar maka akan menuju file formpembelian.php , jika salah maka failed
if ($query == TRUE)
{
header('location:form_pembayaran_hutang.php');
}
else
{
echo "gagal";
}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);

?>
