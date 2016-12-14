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
    $tax = stringdoang($_POST['tax']);

    $potongan = stringdoang($_POST['potongan']);
    $a = $harga * $jumlah_barang;


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
    $satu = 1;
    $x = $a - $potongan_tampil;

        $hasil_tax = $satu + ($tax / 100); 
        
        $hasil_tax2 = $x / $hasil_tax; 

        $tax_persen = $x - $hasil_tax2; 
        
       $tax_persen = round($tax_persen);


    if ( $harga != $harga_baru) {

      $query00 = $db->query("UPDATE barang SET harga_beli = '$harga_baru' WHERE kode_barang = '$kode_barang'");
      $harga_beli = $harga_baru;
    }

else {

      $harga_beli = $harga;

    }

  
        $perintah = $db->prepare("INSERT INTO tbs_pembelian (session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax) VALUES (?,?,?,?,?,?,?,?,?)");

        $perintah->bind_param("sssisiisi",
          $session_id, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga_beli, $subtotal, $potongan_tampil, $tax_persen);
          
          $kode_barang = stringdoang($_POST['kode_barang']);
          $nama_barang = stringdoang($_POST['nama_barang']);
          $jumlah_barang = angkadoang($_POST['jumlah_barang']);
          $satuan = stringdoang($_POST['satuan']);
          $subtotal = $harga_beli * $jumlah_barang - $potongan_jadi;

        $perintah->execute();

        
if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
   
}

    


    //untuk menampilkan semua data yang ada pada tabel tbs pembelian dalam DB
    $perintah = $db->query("SELECT tp.id, tp.no_faktur, tp.session_id, tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.satuan, tp.harga, tp.subtotal, tp.potongan, tp.tax, s.nama FROM tbs_pembelian tp INNER JOIN satuan s ON tp.satuan = s.id WHERE tp.session_id = '$session_id' ORDER BY id DESC LIMIT 1");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr class='tr-id-".$data1['id']."'>
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>

      <td class='edit-jumlah' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' > </td>

      <td>". $data1['nama'] ."</td>
      <td>". rp($data1['harga']) ."</td>
      <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
      <td><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
      <td><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>

     <td> <button class='btn btn-danger btn-hapus-tbs' id='hapus-tbs-". $data1['id'] ."' data-id='". $data1['id'] ."' data-subtotal='".$data1['subtotal']."' data-barang='". $data1['nama_barang'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 
                

      </tr>";


      }


          //Untuk Memutuskan Koneksi Ke Database
          mysqli_close($db); 
    ?>


                                        
                                       
                                        
                                        <script type="text/javascript">
                                        
                                        $(".edit-jumlah").dblclick(function(){
                                        
                                        var id = $(this).attr("data-id");
                                        
                                        
                                        $("#text-jumlah-"+id+"").hide();                                        
                                        $("#input-jumlah-"+id+"").attr("type", "text");
                                        
                                        
                                        });
                                        
                                        
                                        $(".input_jumlah").blur(function(){
                                        
                                        var id = $(this).attr("data-id");
                                        var jumlah_baru = $(this).val();
                                        var kode_barang = $(this).attr("data-kode");
                                        var harga = $(this).attr("data-harga");
                                        var jumlah_lama = $("#text-jumlah-"+id+"").text();
                                        
                                        var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                        
                                        var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));
                                        
                                        var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
                                        
                                        var subtotal = parseInt(harga,10) * parseInt(jumlah_baru,10) - parseInt(potongan,10);
                                        
                                        var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian").val()))));
                                        
                                        subtotal_penjualan = parseInt(subtotal_penjualan,10) - parseInt(subtotal_lama,10) + parseInt(subtotal,10);
                                        
                                        var tax_tbs = tax / subtotal_lama * 100;
                                        var jumlah_tax = tax_tbs * subtotal / 100;
                                        
                                        $("#text-jumlah-"+id+"").show();
                                        $("#text-jumlah-"+id+"").text(jumlah_baru);
                                        $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                        $("#hapus-tbs-"+id+"").attr('data-subtotal', subtotal);
                                        $("#text-tax-"+id+"").text(jumlah_tax);
                                        $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                        $("#total_pembelian").val(tandaPemisahTitik(subtotal_penjualan));   
                                        $("#total_pembelian1").val(tandaPemisahTitik(subtotal_penjualan));  

                                        $.post("update_pesanan_barang_beli.php",{harga:harga,jumlah_lama:jumlah_lama,jumlah_tax:jumlah_tax,potongan:potongan,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang},function(){
                                        
                                               
                                        
                                        });
                                        
                                        
                                        $("#kode_barang").focus();
                                        $("#pembayaran_pembelian").val("");
                                        
                                        });
                                        
                                        </script>


