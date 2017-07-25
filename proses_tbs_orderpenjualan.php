<?php session_start(); 

    include 'sanitasi.php';
    include 'db.php';
    $session_id = session_id();
    //mengirim data sesuai dengan variabel denagn metode POST 

$pilih_akses_tombol = $db->query("SELECT * FROM otoritas_form_order_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);



    $kode_barang = stringdoang($_POST['kode_barang']);


    $harga_produk = stringdoang($_POST['harga_produk']);
    $harga_konversi = stringdoang($_POST['harga_konversi']);

    if ($harga_konversi != 0) {
      $harga = $harga_konversi;
    }else{
      $harga = $harga_produk;
    }


    $jumlah_barang = angkadoang($_POST['jumlah_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $sales = stringdoang($_POST['sales']);
    $user = $_SESSION['nama'];
    $potongan = stringdoang($_POST['potongan']);
    $a = $harga * $jumlah_barang;

    $tahun_sekarang = date('Y');
    $bulan_sekarang = date('m');
    $tanggal_sekarang = date('Y-m-d');
    $jam_sekarang = date('H:i:s');
    $tahun_terakhir = substr($tahun_sekarang, 2);
    $ppn = stringdoang($_POST['ppn']);


          if(strpos($potongan, "%") !== false)
          {
              $potongan_jadi = $a * $potongan / 100;
              $potongan_tampil = $potongan_jadi;
          }
          else{

             $potongan_jadi = $potongan;
             $potongan_tampil = $potongan;
          }


          $tax = stringdoang($_POST['tax']);
          $subtotal = $harga * $jumlah_barang;
          if ($ppn == 'Exclude') {
              $a = $harga * $jumlah_barang;
              
              $x = $a - $potongan_tampil;

              $hasil_tax = $x * ($tax / 100);

              $tax_persen = round($hasil_tax);
            }
            else{
              $a = $harga * $jumlah_barang;

              $satu = 1;

              $x = $a - $potongan_tampil;

              $hasil_tax = $satu + ($tax / 100);

              $hasil_tax2 = $x / $hasil_tax;

              $tax_persen1 = $x - round($hasil_tax2);

              $tax_persen = round($tax_persen1);
            }

    $tipe = $db->query("SELECT berkaitan_dgn_stok FROM barang WHERE kode_barang = '$kode_barang'");
    $data_tipe = mysqli_fetch_array($tipe);
    $ber_stok = $data_tipe['berkaitan_dgn_stok'];

    $query9 = $db->query("SELECT jumlah_prosentase,jumlah_uang FROM fee_produk WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
    $cek9 = mysqli_fetch_array($query9);
    $prosentase = $cek9['jumlah_prosentase'];
    $nominal = $cek9['jumlah_uang'];


if ($prosentase != 0){
       $query90 = $db->query("SELECT * FROM tbs_penjualan_order WHERE session_id = '$session_id' AND kode_barang = '$kode_barang'");
      $cek01 = mysqli_num_rows($query90);

      $cek90 = mysqli_fetch_array($query90);
      $jumlah1 = $cek90['jumlah_barang'];
      $jumlah0 = $jumlah_barang + $jumlah1;

          $subtotal_prosentase = $harga * $jumlah0;
          
          $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

      $komisi = $fee_prosentase_produk;

      if ($cek01 > 0) {
        $query91 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi' WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
      }

      else
      {

          $subtotal_prosentase = $harga * $jumlah_barang;
          
          $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

          $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, session_id, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$sales', '$session_id', '$kode_barang',
            '$nama_barang', '$fee_prosentase_produk', '$tanggal_sekarang', '$jam_sekarang')");

      }
      
      



    }

    elseif ($nominal != 0) {

      $query900 = $db->query("SELECT * FROM tbs_penjualan_order WHERE session_id = '$session_id' AND kode_barang = '$kode_barang'");
      $cek011 = mysqli_num_rows($query900);

      $cek900 = mysqli_fetch_array($query900);
      $jumlah1 = $cek900['jumlah_barang'];
      $jumlah0 = $jumlah_barang + $jumlah1;

          $fee_nominal_produk = $nominal * $jumlah0;

      $komisi0 = $fee_nominal_produk;

      if ($cek011 > 0) {

        $query911 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi0' WHERE nama_petugas = '$user' AND kode_produk = '$kode_barang'");
      }

      else
        {

      $fee_nominal_produk = $nominal * $jumlah_barang;

      $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, session_id, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$user', '$session_id', '$kode_barang', '$nama_barang', '$fee_nominal_produk', '$tanggal_sekarang', '$jam_sekarang')");
      }

    }


  
$cek = $db->query("SELECT * FROM tbs_penjualan_order WHERE kode_barang = '$kode_barang' AND session_id = '$session_id'");

$jumlah = mysqli_num_rows($cek);
    
    if ($jumlah > 0)
    {
        # code...
        $query1 = $db->prepare("UPDATE tbs_penjualan_order SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ?, potongan = ? WHERE kode_barang = ? AND session_id = ?");

        $query1->bind_param("iisss",
            $jumlah_barang, $subtotal, $potongan_tampil, $kode_barang, $session_id);

            
            $jumlah_barang = angkadoang($_POST['jumlah_barang']);
            $kode_barang = stringdoang($_POST['kode_barang']);
            $tax = angkadoang($_POST['tax']);
            $subtotal = $harga * $jumlah_barang - $potongan_jadi;

        $query1->execute();

    }
    else
    {
            $perintah = $db->prepare("INSERT INTO tbs_penjualan_order (session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax,tanggal,jam,harga_konversi,tipe_barang) VALUES (?,?,
            ?,?,?,?,?,?,?,?,?,?,?)");
            
            
            $perintah->bind_param("sssisiiisssis",
            $session_id, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga_produk, $subtotal_jadi, $potongan_tampil, $tax_persen,$tanggal_sekarang,$jam_sekarang,$harga_konversi,$ber_stok);
            
            
            $kode_barang = stringdoang($_POST['kode_barang']);
            $jumlah_barang = angkadoang($_POST['jumlah_barang']); 
            $nama_barang = stringdoang($_POST['nama_barang']);
            $satuan = stringdoang($_POST['satuan']);
            $tax = angkadoang($_POST['tax']);

            if ($ppn == 'Exclude') {

                $abc = $subtotal - $potongan_tampil;
                
                $hasil_tax411 = $abc * ($tax / 100);
                
                $subtotal_jadi = $harga * $jumlah_barang - $potongan_tampil + round($hasil_tax411); 
                
              }
            else{
                $subtotal_jadi = $harga * $jumlah_barang - $potongan_tampil; 
            }
            
            
            $perintah->execute();

    }




mysqli_close($db);   
    ?>


