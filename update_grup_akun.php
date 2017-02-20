<?php session_start();
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';


//EDIT NAMA GRUP AKUN

    $id = angkadoang($_POST['id']);
    $input_nama = stringdoang($_POST['input_nama']);
    $jenis_edit = stringdoang($_POST['jenis_edit']);
    $user = $_SESSION['nama'];

if ($jenis_edit == 'nama_grup_akun') {

       $query =$db->prepare("UPDATE grup_akun SET nama_grup_akun = ?, user_edit = ?  WHERE id = ?");

       $query->bind_param("ssi",
        $input_nama, $user, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}

//EDIT PARENT

    $id = angkadoang($_POST['id']);
    $select_parent = stringdoang($_POST['select_parent']);
    $jenis_select = stringdoang($_POST['jenis_select']);
    $user = $_SESSION['nama'];

if ($jenis_select == 'parent') {

       $query =$db->prepare("UPDATE grup_akun SET parent = ?, user_edit = ?  WHERE id = ?");

       $query->bind_param("ssi",
        $select_parent, $user, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}

//EDIT KATEGORI

    $id = angkadoang($_POST['id']);
    $select_kategori = stringdoang($_POST['select_kategori']);
    $jenis_select = stringdoang($_POST['jenis_select']);
    $user = $_SESSION['nama'];

if ($jenis_select == 'kategori_akun') {

       $query =$db->prepare("UPDATE grup_akun SET kategori_akun = ?, user_edit = ?  WHERE id = ?");

       $query->bind_param("ssi",
        $select_kategori, $user, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}


//EDIT TIPE

    $id = angkadoang($_POST['id']);
    $select_tipe = stringdoang($_POST['select_tipe']);
    $jenis_select = stringdoang($_POST['jenis_select']);
    $user = $_SESSION['nama'];

if ($jenis_select == 'tipe_akun') {

       $query =$db->prepare("UPDATE grup_akun SET tipe_akun = ?, user_edit = ?  WHERE id = ?");

       $query->bind_param("ssi",
        $select_tipe, $user, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}

  //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>