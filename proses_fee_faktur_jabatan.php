<?php session_start();

    include 'sanitasi.php';
    include 'db.php';


$jabatan = stringdoang($_POST['jabatan']);

$query = $db->query("SELECT * FROM user WHERE jabatan = '$jabatan'");
while ($cek = mysqli_fetch_array($query)){
$nama = $cek['nama'];

    $query1 = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$cek[nama]'");
    $cek1 = mysqli_fetch_array($query1);
    $nama_petugas_fee = $cek1['nama_petugas'];


    if ($nama_petugas_fee == ""){

            $perintah = $db->prepare("INSERT INTO fee_faktur (nama_petugas, jumlah_prosentase, jumlah_uang, user_buat) VALUES (?,?,?,?)");

    $perintah->bind_param("siis",
        $nama, $jumlah_prosentase, $jumlah_nominal, $user);

    $jumlah_prosentase = angkadoang($_POST['jumlah_prosentase']);
    $jumlah_nominal = angkadoang($_POST['jumlah_uang']);
    $user = $_SESSION['user_name'];

    $perintah->execute();

                    if (!$perintah) {
                    die('Query Error : '.$db->errno.
                    ' - '.$db->error);
                    }
                    else 
                    
                    {
                    echo '<div class="alert alert-success" id="alert_berhasil" style="display:none">
                    <strong>Sukses!</strong> Penambahan Berhasil
                    </div>';
                    }


    }
    else 
    {
    echo '<div class="alert alert-danger" id="alert_gagal" style="display:none">
        <strong>Gagal!</strong> Penambahan Data Fee Sudah Ada
        </div>';
    }

}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   




    ?>