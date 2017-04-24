<?php include 'session_login.php';

//memasukkan file db.php
include 'db.php';
include 'sanitasi.php';



// menambah data yang ada pada tabel satuan berdasarka id dan nama
$perintah = $db->prepare("INSERT INTO daftar_pajak (nama_pajak,deskripsi,persen_pajak,jenis_pajak)
			VALUES (?,?,?,?)");

$perintah->bind_param("ssis",
	$nama_pajak, $deskripsi, $nilai_pajak, $jenis_pajak);

	$nama_pajak = stringdoang($_POST['nama_pajak']);
	$deskripsi = stringdoang($_POST['deskripsi']);
	$nilai_pajak = angkadoang($_POST['nilai_pajak']);
	$jenis_pajak = stringdoang($_POST['jenis_pajak']);

$perintah->execute();

if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
   echo 'sukses';
} 

 ?>

 			<?php
            
            $query = $db->query("SELECT * FROM daftar_pajak ORDER BY id DESC LIMIT 1");
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