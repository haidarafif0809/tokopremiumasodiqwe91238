<?php include 'session_login.php';
include 'sanitasi.php';
include 'db.php';


$id = angkadoang($_POST['id']);
$nama_pajak = stringdoang($_POST['nama_pajak']);
$deskripsi = stringdoang($_POST['deskripsi']);
$nilai_pajak = angkadoang($_POST['nilai_pajak']);
$jenis_pajak = stringdoang($_POST['jenis_pajak']);



$query = $db->prepare("UPDATE daftar_pajak SET nama_pajak = ?, deskripsi = ?, persen_pajak = ?, jenis_pajak = ? WHERE id = ?");

$query->bind_param("ssisi",
	$nama_pajak, $deskripsi, $nilai_pajak, $jenis_pajak, $id);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {

    }


?>


            <?php
            
            $query = $db->query("SELECT * FROM daftar_pajak WHERE id = '$id' ORDER BY id DESC LIMIT 1");
            $data = mysqli_fetch_array($query);
            
            echo "<tr class='tr-id-".$data['id']."'>
            <td>". $data['nama_pajak'] ."</td>
            <td>". $data['deskripsi'] ."</td>
            <td>". $data['persen_pajak'] ."</td>
            <td>". $data['jenis_pajak'] ."</td>";
            
            
            include 'db.php';
            
            $pilih_akses_daftar_pajak_hapus = $db->query("SELECT daftar_pajak_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND daftar_pajak_hapus = '1'");
            $daftar_pajak_hapus = mysqli_num_rows($pilih_akses_daftar_pajak_hapus);
            
            
            if ($daftar_pajak_hapus > 0){
            echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-daftar-pajak='". $data['nama_pajak'] ."'> <i class='fa fa-trash'> </i> Hapus </button> </td>";

            }

            $pilih_akses_daftar_pajak_edit = $db->query("SELECT daftar_pajak_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND daftar_pajak_edit = '1'");
            $daftar_pajak_edit = mysqli_num_rows($pilih_akses_daftar_pajak_edit);
            
            
            if ($daftar_pajak_edit > 0){
            echo "<td> <button class='btn btn-secondary btn-edit' data-id='". $data['id'] ."' data-daftar-pajak='". $data['nama_pajak'] ."' data-deskripsi='". $data['deskripsi'] ."' data-persen-pajak='". $data['persen_pajak'] ."' data-jenis-pajak='". $data['jenis_pajak'] ."'> <i class='fa fa-edit'> </i> Edit </button> </td>";
            
            }

            echo "</tr>";
            

            //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);  
            ?>