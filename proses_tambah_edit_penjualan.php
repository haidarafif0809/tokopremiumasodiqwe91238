<?php session_start();
 
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';

    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
    $nomor_faktur = stringdoang($_POST['no_faktur']);
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $jumlah_barang = angkadoang($_POST['jumlah_barang']);
    $ppn = stringdoang($_POST['ppn']);
    $satuan = stringdoang($_POST['satuan']);
    $harga_produk = angkadoang($_POST['harga_produk']);
    $harga_konversi = angkadoang($_POST['harga_konversi']);

    if ($harga_konversi != 0) {
    $harga = $harga_konversi;
    }else{
    $harga = $harga_produk;

    }


    $potongan = angkadoang($_POST['potongan']);
    $tax = stringdoang($_POST['tax']);
    $subtotal = $harga * $jumlah_barang - $potongan;

    $tax = stringdoang($_POST['tax']);
    $satu = 1;

if ($potongan == '')
    {
      $potongan_jadi = 0;
      $potongan_tampil = 0;
    }
    else
    {
           if(strpos($potongan, "%") !== false)
          {
              $potongan_jadi = $a * $potongan / 100;
              $potongan_tampil = $potongan_jadi;
          }
          else
          {
             $potongan_jadi = $potongan;
             $potongan_tampil = $potongan;
          }
    }

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



    if ($ppn == 'Exclude') {
  # code...

              $abc = $subtotal - $potongan_tampil;

              $hasil_tax411 = $abc * ($tax / 100);

              $subtotaljadi = $harga * $jumlah_barang - $potongan_tampil + round($hasil_tax411); 

}
else
{
  $subtotaljadi = $harga * $jumlah_barang - $potongan_tampil; 
}
//PPN END



//
    /*$hasil_tax = $satu + ($tax / 100);

    $hasil_tax2 = $subtotal / $hasil_tax;

    $tax_jadi = $subtotal - $hasil_tax2;*/
//
    



    // menampilkan data yang ada dari tabel tbs_pembelian berdasarkan kode barang
    $cek = $db->query("SELECT * FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND no_faktur = '$nomor_faktur'");

    // menyimpan data sementara berupa baris yang dijalankan dari $cek
    $jumlah = mysqli_num_rows($cek);
    
    // jika $jumlah >0 maka akan menjalakan perintah $query1 jika tidak maka akan menjalankan perintah $perintah
    
    if ($jumlah > 0)
    {
        # code...
        $query1 = $db->query("UPDATE tbs_penjualan SET jumlah_barang = jumlah_barang + '$jumlah_barang', subtotal = subtotal + '$subtotal' WHERE kode_barang = '$kode_barang' AND no_faktur = '$nomor_faktur'");

    }

    else

    {
        $perintah = "INSERT INTO tbs_penjualan (no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax,harga_konversi)VALUES ('$nomor_faktur','$kode_barang',
        '$nama_barang','$jumlah_barang','$satuan','$harga_produk','$subtotaljadi','$potongan',
        '$tax_persen','$harga_konversi')";
        
        if ($db->query($perintah) === TRUE)
        {
        }
        else
        {
            echo "Error: " . $perintah . "<br>" . $db->error;
        }

    }
                
                

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>


<!--<script type="text/javascript">

//fungsi hapus data 
    $(".btn-hapus-tbs").click(function(){
    var nama_barang = $(this).attr("data-barang");
    var kode_barang = $(this).attr("data-kode-barang");
    var id = $(this).attr("data-id");
    
    $.post("hapus_edit_tbs_penjualan.php",{id:id,kode_barang:kode_barang},function(data){
    
    $(".tr-id-"+id+"").remove();
    $("#kode_barang").focus();
    $("#pembayaran_penjualan").val('');

    
    
    });
    
                  $('form').submit(function(){
              
              return false;
              });

    });

//end fungsi hapus data
</script>-->

