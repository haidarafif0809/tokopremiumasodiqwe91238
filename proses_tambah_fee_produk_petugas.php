<?php session_start();
 
    include 'sanitasi.php';
    include 'db.php';


    $nama_petugas = stringdoang($_POST['nama_petugas']);
    $kode_produk = stringdoang($_POST['kode_produk']);

    $perintah0 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$nama_petugas' AND kode_produk = '$kode_produk'");

    $cek = mysqli_num_rows($perintah0);

    if ($cek == 0) {
        
            $perintah = $db->prepare("INSERT INTO fee_produk (nama_petugas, kode_produk, nama_produk, jumlah_prosentase, jumlah_uang, user_buat)
            VALUES (?,?,?,?,?,?)");

    $perintah->bind_param("sssiis",
        $nama_petugas, $kode_produk, $nama_produk, $jumlah_prosentase, $jumlah_nominal, $user);

    $nama_petugas = stringdoang($_POST['nama_petugas']);
    $kode_produk = stringdoang($_POST['kode_produk']);
    $nama_produk = stringdoang($_POST['nama_produk']);
    $jumlah_prosentase = angkadoang($_POST['jumlah_prosentase']);
    $jumlah_nominal = angkadoang($_POST['jumlah_uang']);
    $user = $_SESSION['user_name'];

    $perintah->execute();

                    if (!$perintah) 
                    {
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


    else {
  echo '<div class="alert alert-danger" id="alert_gagal" style="display:none">
        <strong>Gagal!</strong> Penambahan Data Fee Sudah Ada
        </div>';
    }



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   



    ?>