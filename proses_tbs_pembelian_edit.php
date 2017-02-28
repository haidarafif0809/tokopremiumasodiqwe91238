<?php 
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';
    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
    $no_faktur = stringdoang($_POST['no_faktur']);
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $jumlah_barang = $_POST['jumlah_barang'];
    $satuan = $_POST['satuan'];
    $harga = angkadoang($_POST['harga']);
    $harga_baru = angkadoang($_POST['harga_baru']);
    $potongan = stringdoang($_POST['potongan']);
    $pajak = angkadoang($_POST['tax']);
    $ppn = stringdoang($_POST['ppn']);


    if ( $harga != $harga_baru) {
          $query00 = $db->query("UPDATE barang SET harga_beli = '$harga_baru' WHERE kode_barang = '$kode_barang'");
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

        
        $perintah = "INSERT INTO tbs_pembelian (no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax)VALUES ('$no_faktur','$kode_barang','$nama_barang','$jumlah_barang','$satuan','$harga_beli','$subtotaljadi','$potongan','$tax_persen')";
        
        if ($db->query($perintah) === TRUE)
        {
        }
        else
        {
            echo "Error: " . $perintah . "<br>" . $db->error;
        }

    

?>