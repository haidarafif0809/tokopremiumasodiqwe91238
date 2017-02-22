<?php session_start();

    include 'sanitasi.php';
    include 'db.php';

    $id = angkadoang($_POST['id']);
    $input_debit = angkadoang($_POST['input_debit']);
    $input_kredit = angkadoang($_POST['input_kredit']);
    $jenis_edit = stringdoang($_POST['jenis_edit']);

if ($jenis_edit == 'debit') {

       $query =$db->prepare("UPDATE tbs_jurnal SET debit = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_debit, $id);


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


if ($jenis_edit == 'kredit') {

       $query =$db->prepare("UPDATE tbs_jurnal SET kredit = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_kredit, $id);


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

 ?>