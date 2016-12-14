<?php 
    // memasukan file yang ada pada db.php
    include 'sanitasi.php';
    include 'db.php';

    
   $kode_barang = stringdoang($_POST['kode_barang']);
   $harga = angkadoang($_POST['harga']);
   $jumlah_retur = angkadoang($_POST['jumlah_retur']);
   $satuan_produk = stringdoang($_POST['satuan_produk']);
   $satuan_beli = stringdoang($_POST['satuan_beli']);

      $pajak = angkadoang($_POST['tax1']);

          $potongan = stringdoang($_POST['potongan1']);
          $a = $harga * $jumlah_retur;


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

    $satu = 1;
    $x = $a - $potongan_tampil;

    $hasil_tax = $satu + ($pajak / 100);

    $hasil_tax2 = $x / $hasil_tax;

    $tax_persen1 = $x - $hasil_tax2;

    $tax_persen = round($tax_persen1);
    
    $subtotal = $harga * $jumlah_retur - $potongan_jadi;


    
    $no_faktur_retur = stringdoang($_POST['no_faktur_retur']);
    $no_faktur_pembelian = stringdoang($_POST['no_faktur_pembelian']);
    
    $cek2 = $db->query("SELECT * FROM detail_pembelian WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur_pembelian'");
    $data= mysqli_fetch_array($cek2); 

    $konversi = $db->query("SELECT $data[jumlah_barang] / konversi AS jumlah_beli FROM satuan_konversi WHERE kode_produk = '$kode_barang' AND id_satuan = '$data[satuan]' ");
     $num_rows = mysqli_num_rows($konversi);
     $data_konversi = mysqli_fetch_array($konversi); 
     
     if ($num_rows > 0 ){
     
     $jumlah_beli = $data_konversi['jumlah_beli'];
     }
     else{ 
     
     $jumlah_beli = $data['jumlah_barang'];
     }


   $perintah = $db->prepare("INSERT INTO tbs_retur_pembelian (no_faktur_retur,no_faktur_pembelian,kode_barang,nama_barang,jumlah_beli,jumlah_retur,harga,subtotal,potongan,tax,satuan,satuan_beli) VALUES (?,?,?,?,'$jumlah_beli',?,'$harga',?,?,?,?,?)");

   $perintah->bind_param("ssssiiiiss",
    $no_faktur_retur, $no_faktur_pembelian, $kode_barang, $nama_barang, $jumlah_retur, $subtotal, $potongan_tampil, $tax_persen,$satuan_produk,$satuan_beli);

    $no_faktur_retur = stringdoang($_POST['no_faktur_retur']);
    $no_faktur_pembelian = stringdoang($_POST['no_faktur_pembelian']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $kode_barang = stringdoang($_POST['kode_barang']);

   $perintah->execute();

 
if (!$perintah) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {

}



    
 
    ?>

    <?php

    //untuk menampilkan semua data yang ada pada tabel tbs pembelian dalam DB
    $perintah = $db->query("SELECT tp.id,tp.no_faktur_pembelian,tp.kode_barang,tp.nama_barang,tp.jumlah_beli,tp.jumlah_retur,tp.satuan,tp.harga,tp.potongan,tp.tax,tp.subtotal, s.nama AS satuan_retur, ss.nama AS satuan_beli FROM tbs_retur_pembelian tp INNER JOIN satuan s ON tp.satuan = s.id INNER JOIN satuan ss ON tp.satuan_beli = ss.id WHERE tp.no_faktur_retur = '$no_faktur_retur' ORDER BY id DESC LIMIT 1");

    //menyimpan data sementara yang ada pada $perintah
     $data1 = mysqli_fetch_array($perintah);

        // menampilkan data
      echo "<tr class='tr-id-".$data1['id']."'>
      <td>". $data1['no_faktur_pembelian'] ."</td>
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>
      <td>". rp($data1['jumlah_beli']) ." ".$data1['satuan_beli']."</td>


      <td class='edit-jumlah' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur_pembelian']."' data-kode='".$data1['kode_barang']."'> <span id='text-jumlah-".$data1['id']."'> ".$data1['jumlah_retur']." </span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_retur']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-faktur='".$data1['no_faktur_pembelian']."' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' data-satuan='".$data1['satuan']."' onkeydown='return numbersonly(this, event);'> </td>

      <td>". $data1['satuan_retur']."</td>
      <td>". rp($data1['harga']) ."</td>

      <td><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
      <td><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>
      <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>


      <td><button class='btn btn-danger btn-hapus-tbs' id='btn-hapus-".$data1['id']."' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-faktur='". $data1['no_faktur_pembelian'] ."' data-subtotal='". $data1['subtotal'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>

      </tr>";
  

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
                                    if (jumlah_baru == '')
                                    {
                                      jumlah_baru = 0;
                                    }
                                    var kode_barang = $(this).attr("data-kode");
                                    var no_faktur = $(this).attr("data-faktur");
                                    var harga = $(this).attr("data-harga");
                                    var jumlah_retur = $("#text-jumlah-"+id+"").text();
                                    var no_faktur_retur = $("#nomorfaktur").val();
                                    var satuan = $(this).attr("data-satuan");

                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                   
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    var sub_total = parseInt(harga,10) * parseInt(jumlah_baru,10);
                                   
                                   var total_tbs = parseInt(harga,10) * parseInt(jumlah_retur,10);
                                   // rupiah to persen
                                    var potongan_tbs = parseInt(Math.round(potongan, 10)) / parseInt(total_tbs) * 100;
                                    //rupiah to persen

                                    var jumlah_potongan = parseInt(Math.round(potongan_tbs)) * parseInt(sub_total) / 100;


                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));

                                    var subtotal = parseInt(harga,10) * parseInt(jumlah_baru,10) - parseInt(jumlah_potongan,10);
                                    
                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian").val()))));
                                    
                                    subtotal_penjualan = parseInt(subtotal_penjualan,10) - parseInt(subtotal_lama,10) + parseInt(subtotal,10);

                                    var tax_tbs = tax / subtotal_lama * 100;
                                    var jumlah_tax = tax_tbs * subtotal / 100;


                                     if (jumlah_baru == 0) {

                                       alert ("Jumlah Retur Tidak Boleh 0!");
                                       
                                       $("#input-jumlah-"+id+"").val(jumlah_retur);
                                       $("#text-jumlah-"+id+"").text(jumlah_retur);
                                       $("#text-jumlah-"+id+"").show();
                                       $("#input-jumlah-"+id+"").attr("type", "hidden");
                                    }

                                    else{

                                   $.post("cek_total_tbs_edit_retur_pembelian.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru, no_faktur:no_faktur,no_faktur_retur:no_faktur_retur,satuan:satuan},function(data){

                                       if (data < 0) {

                                       alert ("Jumlah Yang Di Masukan Melebihi Stok !");
                                        $("#input-jumlah-"+id+"").val(jumlah_retur);
                                        $("#text-jumlah-"+id+"").show();
                                        $("#input-jumlah-"+id+"").attr("type", "hidden");
                                     }


                                      else{

                                     $.post("update_pesanan_barang_retur_pembelian.php",{harga:harga,jumlah_retur:jumlah_retur,jumlah_tax:Math.round(jumlah_tax),jumlah_potongan:jumlah_potongan,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,subtotal:subtotal},function(info){

                                  
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#btn-hapus-"+id).attr("data-subtotal", subtotal);
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                    $("#text-potongan-"+id+"").text(Math.round(jumlah_potongan));
                                    $("#total_retur_pembelian").val(tandaPemisahTitik(subtotal_penjualan)); 
                                    $("#total_retur_pembelian1").val(tandaPemisahTitik(subtotal_penjualan));         
                                    });

                                   }


                                 });


                                    }


 

       
                                    $("#kode_barang").focus();

                                 });

                             </script>

