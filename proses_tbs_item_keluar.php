<?php session_start();

    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    //mengirim data sesuai dengan variabel denagn metode POST 

    $session_id = session_id();


    $kode_barang = stringdoang($_POST['kode_barang']);
    $jumlah = angkadoang($_POST['jumlah_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $satuan = stringdoang($_POST['satuan']);
    $harga = angkadoang($_POST['harga']);
    $subtotal = $harga * $jumlah;

        $perintah = $db->prepare("INSERT INTO tbs_item_keluar (session_id, kode_barang, nama_barang, jumlah, satuan, harga, subtotal) VALUES (?,?,?,?,?,?,?)");


        $perintah->bind_param("sssisii",
        $session_id, $kode_barang, $nama_barang, $jumlah, $satuan, $harga, $subtotal);
        
       

        $perintah->execute();


        if (!$perintah) {
           die('Query Error : '.$db->errno.
           ' - '.$db->error);
        }
        else {

        }




    ?>


    <?php

     $perintah = $db->query("SELECT tik.id,tik.no_faktur,tik.kode_barang,tik.nama_barang,tik.jumlah,tik.harga,tik.subtotal,s.nama FROM tbs_item_keluar tik LEFT JOIN satuan s ON tik.satuan = s.id WHERE tik.session_id = '$session_id' AND tik.kode_barang = '$kode_barang' ORDER BY tik.id DESC LIMIT 1");

      //menyimpan data sementara yang ada pada $perintah

      $data1 = mysqli_fetch_array($perintah);
        //menampilkan data
      echo "<tr class='tr-id-".$data1['id']."'>
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>

      <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."'  value='".$data1['jumlah']."' class='input_jumlah' data-subtotal='".$data1['subtotal']."' data-id='".$data1['id']."' autofocus='' data-harga='".$data1['harga']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."' > </td>

      <td>". $data1['nama'] ."</td>
      <td> <button class='btn btn-sm btn-danger btn-hapus' id='btn-hapus-".$data1['id']."' data-subtotal='".$data1['subtotal']."' data-id='". $data1['id'] ."' data-nama-barang='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 
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
                                    var harga = $(this).attr("data-harga");
                                    var kode_barang = $(this).attr("data-kode");
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-subtotal")))));
                                    var subtotal = harga * jumlah_baru;
                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_keluar").val()))));

                                    
                                    var total_akhir = parseInt(subtotal_penjualan) - parseInt(subtotal_lama) + parseInt(subtotal);


                                    $.post("cek_stok_pesanan_barang.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru},function(data){

                                       if (data == "ya") {

                                       alert ("Jumlah Yang Di Masukan Melebihi Stok !");

                                       $(this).val($(".text-jumlah-"+id+"").text());

                                     }

                                     else{


                                    $("#total_item_keluar").val(tandaPemisahTitik(total_akhir));
                                    $("#input-jumlah-"+id).attr("data-subtotal", subtotal);
                                    $("#btn-hapus-"+id).attr("data-subtotal", subtotal);

                                    $.post("update_jumlah_barang_tbs_item_keluar.php",{id:id,jumlah_baru:jumlah_baru,subtotal:subtotal},function(info){

                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");       
                                    
                                    
                                    });
                                    
                                     }

                                   });

                                   
                                   $("#kode_barang").focus();

                                 });

                             </script>


