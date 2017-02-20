<?php session_start();


include 'db.php';
include 'sanitasi.php';


$session_id = session_id();
                              
//menampilkan seluruh data yang ada pada tabel pembelian
$perintah = $db->query("SELECT * FROM item_masuk");
                              

                              ?>							
                              <table id="tableuser" class="table table-bordered">
                              <thead>
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
                              WHERE session_id = '$session_id'");
                              
                              //menyimpan data sementara yang ada pada $perintah
                              
                              while ($data1 = mysqli_fetch_array($perintah))
                              {
                              //menampilkan data
                              echo "<tr class='tr-id-".$data1['id']."'>
                              <td>". $data1['kode_barang'] ."</td>
                              <td>". $data1['nama_barang'] ."</td>

                             <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-subtotal='".$data1['subtotal']."' data-harga='".$data1['harga']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."' > </td>
                             

                              <td>". $data1['satuan'] ."</td>
                              <td>". rp($data1['harga']) ."</td>
                              <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
                              
                              <td> <button class='btn btn-danger btn-hapus' id='btn-hapus-".$data1['id']."' data-id='". $data1['id'] ."' data-nama-barang='". $data1['nama_barang'] ."' data-subtotal='". $data1['subtotal'] ."' > <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 
                              </tr>";
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
   