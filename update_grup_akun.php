<?php session_start();
  // memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';


//EDIT NAMA GRUP AKUN

    $id = angkadoang($_POST['id']);
    $jenis_select = stringdoang($_POST['jenis_select']);
    $user = $_SESSION['nama'];

if ($jenis_select == 'nama_grup_akun') {

    $input_nama = stringdoang($_POST['input_nama']);
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
    $jenis_select = stringdoang($_POST['jenis_select']);
    $user = $_SESSION['nama'];

if ($jenis_select == 'parent') {

    $select_parent = stringdoang($_POST['select_parent']);
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
    $jenis_select = stringdoang($_POST['jenis_select']);
    $user = $_SESSION['nama'];

if ($jenis_select == 'kategori_akun') {

    $select_kategori = stringdoang($_POST['select_kategori']);
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
    $jenis_select = stringdoang($_POST['jenis_select']);
    $user = $_SESSION['nama'];

if ($jenis_select == 'tipe_akun') {

    $select_tipe = stringdoang($_POST['select_tipe']);
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