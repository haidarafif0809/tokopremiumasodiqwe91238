    <?php session_start();
 
    include 'sanitasi.php';
    include 'db.php';


$jabatan = stringdoang($_POST['jabatan']);
$kode_produk = stringdoang($_POST['kode_produk']);
$nama_produk = stringdoang($_POST['nama_produk']);
$jumlah_prosentase = angkadoang($_POST['jumlah_prosentase']);
$jumlah_nominal = angkadoang($_POST['jumlah_uang']);
$user = $_SESSION['user_name'];

$query = $db->query("SELECT id FROM user WHERE jabatan = '$jabatan'");
while ($cek = mysqli_fetch_array($query)){
$nama = $cek['id'];

    $query1 = $db->query("SELECT COUNT(nama_petugas) AS jumlah_data FROM fee_produk WHERE nama_petugas = '$nama' AND kode_produk = '$kode_produk' ");
    $cek1 = mysqli_fetch_array($query1);

    if ($cek1['jumlah_data'] == 0){

            $perintah = $db->prepare("INSERT INTO fee_produk (nama_petugas, kode_produk, nama_produk, jumlah_prosentase, jumlah_uang, user_buat) VALUES (?,?,?,?,?,?)");

                $perintah->bind_param("sssiis",
                    $nama, $kode_produk, $nama_produk, $jumlah_prosentase, $jumlah_nominal, $user);

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