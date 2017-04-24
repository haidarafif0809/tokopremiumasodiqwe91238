<?php 

include 'db.php';
include 'sanitasi.php';
              
$no_faktur = $_GET['no_faktur'];                
//menampilkan seluruh data yang ada pada tabel pembelian
$perintah = $db->query("SELECT * FROM item_masuk WHERE no_faktur = '$no_faktur'");
                              

                              ?>							
                              <table id="tableuser" class="table table-bordered">
                              <thead>
                              <th> Nomor Faktur </th>
                              <th> Kode Barang </th>
                              <th> Nama Barang </th>
                              <th> Jumlah </th>
                              <th> Satuan </th>
                              <th> Harga </th>
                              <th> Subtotal </th>
                              
                              <th> Hapus </th>
                              
                              </thead>
                              
                              <tbody>
                              <?php
                              
                              //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                              $perintah = $db->query("SELECT * FROM tbs_item_masuk
                              WHERE no_faktur = '$no_faktur'");
                              
                              //menyimpan data sementara yang ada pada $perintah
                              
                              while ($data1 = mysqli_fetch_array($perintah))
                              {
                              //menampilkan data
                              echo "<tr class='tr-id-".$data1['id']."'>
                              <td>". $data1['no_faktur'] ."</td>
                              <td>". $data1['kode_barang'] ."</td>
                              <td>". $data1['nama_barang'] ."</td>";

                               $hpp_masuk = $db->query("SELECT no_faktur FROM hpp_masuk WHERE no_faktur = '$no_faktur' AND kode_barang = '$data1[kode_barang]' AND sisa != jumlah_kuantitas");
                               $row = mysqli_num_rows($hpp_masuk);

                               if ($row > 0) 
                               {
                                
                                 echo "<td class='edit-jumlah-alert' data-id='".$data1['id']."' data-kode='".$data1['kode_barang']."' data-faktur='".$data1['no_faktur']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-harga='".$data1['harga']."' data-kode='".$data1['kode_barang']."' > </td>";
                               } 

                               else 
                               {

                                 echo "<td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-harga='".$data1['harga']."' data-subtotal='". $data1['subtotal'] ."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."' > </td>";
                               }
                               

                              


                              echo"<td>". $data1['satuan'] ."</td>
                              <td>". rp($data1['harga']) ."</td>
                              <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>";
                              



                               if ($row > 0) 

                               {
                                echo"<td> <button class='btn btn-danger btn-alert' data-id='". $data1['id'] ."' data-faktur='". $data1['no_faktur'] ."' data-kode='". $data1['kode_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
                               } 

                               else

                               {
                                echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-subtotal='". $data1['subtotal'] ."'
                                id='btn-hapus-".$data1['id']."' data-nama-barang='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
                               }

                              echo"</tr>";
                              }
                              
                              //Untuk Memutuskan Koneksi Ke Database
                              
                              mysqli_close($db); 
                              ?>
                              </tbody>
                              
                              </table>

<script>

      //untuk menampilkan data tabel
      $(document).ready(function(){
      $('.table').dataTable();
      });
                              
</script>
 

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
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-subtotal")))));
                                    var subtotal = harga * jumlah_baru;
                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_masuk").val()))));
                                    
                                    var total_akhir = parseInt(subtotal_penjualan) - parseInt(subtotal_lama) + parseInt(subtotal);
                                    
                                    $("#total_item_masuk").val(tandaPemisahTitik(total_akhir));
                                    $("#input-jumlah-"+id).attr("data-subtotal", subtotal);
                                    $("#btn-hapus-"+id).attr("data-subtotal", subtotal);
                                    
                                    $.post("update_jumlah_barang_tbs_item_masuk.php",{id:id,jumlah_baru:jumlah_baru,subtotal:subtotal},function(info){
                                    

                                    
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    
                                    
                                    });
                                    
                                    $("#kode_barang").focus();
                                    
                                    });
                                    
                                    </script>  
               
<script type="text/javascript">
 
$(".btn-alert").click(function(){
     var no_faktur = $(this).attr("data-faktur");
    var kode_barang = $(this).attr("data-kode");

    $.post('alert_edit_item_masuk.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){
    
 
    $("#modal_alert").modal('show');
    $("#modal-alert").html(data); 

});

  });
</script>

<script type="text/javascript">

  $(".edit-jumlah-alert").dblclick(function(){
  
        var no_faktur = $(this).attr("data-faktur");
        var kode_barang = $(this).attr("data-kode");
                                      
      $.post('alert_edit_item_masuk.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){
                                      
        $("#modal_alert").modal('show');
        $("#modal-alert").html(data);
              
      });
    });

</script>
                     