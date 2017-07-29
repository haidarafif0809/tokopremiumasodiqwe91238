<?php 
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';

    $session_id = $_POST['session_id'];

    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $jumlah_barang = angkadoang($_POST['jumlah_barang']);
    $satuan = stringdoang($_POST['satuan']);
    $harga = angkadoang($_POST['harga']);
    $harga_baru = angkadoang($_POST['harga_baru']);
    $pajak = stringdoang($_POST['tax']);
    $ppn = stringdoang($_POST['ppn']);

    $potongan = stringdoang($_POST['potongan']);



  if ( $harga != $harga_baru) {
          $harga_beli = $harga_baru;
    }

  else {
          $harga_beli = $harga;
     }

    $a = $harga_beli * $jumlah_barang;
    $subtotal = $harga_beli * $jumlah_barang;


          if(strpos($potongan, "%") !== false)
          {
               $potongan_jadi = $a * $potongan / 100;
               $potongan_tampil = $potongan_jadi;
          }
          else{              
              $potongan_jadi = $potongan;
              $potongan_tampil = $potongan;
          }

      if ($ppn == 'Exclude') {
              $a = $harga_beli * $jumlah_barang;
              
              $x = $a - $potongan_tampil;

              $hasil_tax = $x * ($pajak / 100);

              $tax_persen = round($hasil_tax);
        }

      else {
              $a = $harga_beli * $jumlah_barang;

              $satu = 1;

              $x = $a - $potongan_tampil;

              $hasil_tax = $satu + ($pajak / 100);

              $hasil_tax2 = $x / $hasil_tax;

              $tax_persen1 = $x - round($hasil_tax2);

              $tax_persen = round($tax_persen1);
        }


      if ($ppn == 'Exclude') {
        $abc = $subtotal - $potongan_jadi;
        $hasil_tax411 = $abc * ($pajak / 100);
        $subtotaljadi = $harga_beli * $jumlah_barang - $potongan_jadi + round($hasil_tax411);
      }
      else
      {
        $subtotaljadi = $harga_beli * $jumlah_barang - $potongan_jadi; 
      }

  
        $perintah = $db->prepare("INSERT INTO tbs_pembelian (session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax) VALUES (?,?,?,?,?,?,?,?,?)");

        $perintah->bind_param("sssisiisi",
          $session_id, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga_beli, $subtotaljadi, $potongan_tampil, $tax_persen);
          
          $kode_barang = stringdoang($_POST['kode_barang']);
          $nama_barang = stringdoang($_POST['nama_barang']);
          $jumlah_barang = angkadoang($_POST['jumlah_barang']);
          $satuan = stringdoang($_POST['satuan']);

        $perintah->execute();

        if (!$perintah) 
        {
         die('Query Error : '.$db->errno.
         ' - '.$db->error);
        }
        else 
        {
           
        }
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>