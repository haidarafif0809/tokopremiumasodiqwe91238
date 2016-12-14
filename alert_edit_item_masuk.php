<?php 


include 'db.php';

 $no_faktur = $_POST['no_faktur'];
 $kode_barang = $_POST['kode_barang'];

 $hpp_masuk_penjualan = $db->query("SELECT no_faktur_hpp_masuk, tanggal, kode_barang, jenis_transaksi FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$no_faktur' AND kode_barang = '$kode_barang' ");

 ?>



    <style>
table {
    border-collapse: collapse;
    width: 100%;
}

.th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

.th {
    background-color: #4CAF50;
    color: white;
}
</style>

<h4>Maaf No Transaksi <strong><?php echo $no_faktur; ?></strong> tidak dapat dihapus, karena telah terdapat Transaksi Penjualan atau Item Keluar. Dengan daftar sebagai berikut :</h4>

<table id="tableuser" class="table table-hover">
    <thead>

          <th class="th"> Nomor Faktur</th>
          <th class="th"> Tanggal </th>
          <th class="th"> Keterangan </th>
          </thead>
          
          
    <tbody>
          
          <?php
          
          //menyimpan data sementara yang ada pada $perintah
          while ($data1 = mysqli_fetch_array($hpp_masuk_penjualan))
          {
          //menampilkan data
          echo "<tr>
          <td>". $data1['no_faktur_hpp_masuk'] ."</td>
          <td>". $data1['tanggal'] ."</td>
          <td> Transaksi ". $data1['jenis_transaksi'] ." </td>

          </tr>";


          }

      //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db);        
          ?>



    </tbody>
</table>



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
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    var jumlah_kuantitas = $("#jumlah_kuantitas").val();

                                    var subtotal = harga * jumlah_baru;
                                    var x = jumlah_kuantitas - jumlah_baru;

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_masuk").val()))));

                                    subtotal_penjualan = subtotal_penjualan - subtotal_lama + subtotal;

                                    if (x > 0) {

                                      var no_faktur = $(this).attr("data-faktur");
                                      var kode_barang = $(this).attr("data-kode");
                                      
                                      $.post('alert_edit_item_masuk.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){
                                      
                                        $("#modal_alert").modal('show');
                                        $("#modal-alert").html(data);
                                        $("#text-jumlah-"+id+"").show();
                                        $("#input-jumlah-"+id+"").attr("type", "hidden"); 
              
                                      });

                                    }

                                    else{
                                     $.post("update_jumlah_barang_edit_tbs_item_masuk.php",{id:id,jumlah_baru:jumlah_baru},function(info){

                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total_item_masuk").val(tandaPemisahTitik(subtotal_penjualan));         


                                 });
                                    }





                                    $("#kode_barang").focus();

                                 });

                             </script>    
               





