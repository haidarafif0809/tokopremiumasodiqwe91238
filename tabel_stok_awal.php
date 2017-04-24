<?php 
                  

                  include 'db.php';
                  include 'sanitasi.php';
                  
                  //menampilkan seluruh data yang ada pada tabel pembelian
                  $perintah = $db->query("SELECT * FROM stok_awal");
                  
                  $data1 = mysqli_fetch_array($perintah);
                  
                  $id = $data1['id'];
                  $kode_barang = $data1['kode_barang'];
                  
            ?>
                  
                <table id="tableuser" class="table table-bordered">
                  <thead>
                  
                  <th> Kode Barang </th>
                  <th> Nama Barang </th>
                  <th> Jumlah  </th>
                  <th> Satuan </th>
                  <th> Harga </th>
                  <th> Total </th>
                  
                  <th> Hapus </th>
                  
                  </thead>
                  
                  <tbody>
                  <?php
                  
                  
                  $perintah = $db->query("SELECT s.nama AS nama_satuan,tsa.id,kode_barang,tsa.nama_barang,tsa.jumlah_awal,tsa.harga,tsa.total FROM tbs_stok_awal tsa INNER JOIN satuan s ON tsa.satuan = s.id");
                  
                  //menyimpan data sementara yang ada pada $perintah
                  while ($data1 = mysqli_fetch_array($perintah))
                  {
                  
                  
                  echo "<tr>
                  
                  <td>". $data1['kode_barang'] ."</td>
                  <td>". $data1['nama_barang'] ."</td>

                  <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_awal'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_awal']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-harga='".$data1['harga']."' data-kode='".$data1['kode_barang']."' > </td>

                  
                  <td>". $data1['nama_satuan'] ."</td>
                  <td>". rp($data1['harga']) ."</td>
                  <td><span id='text-total-".$data1['id']."'>". rp($data1['total']) ."</span></td>

                  
                  
                  <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-nama-barang='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 

                  </tr>";
                  }

                  //Untuk Memutuskan Koneksi Ke Database
                  mysqli_close($db);   

                  ?>
                  </tbody>
                  
                  </table>
  <script>
    
    $(document).ready(function(){
    $('.table').DataTable();
    });
  </script>


                 <script type="text/javascript">
                               
                                  $(document).ready(function(){
                                  
                                  //fungsi hapus data 
                                  $(".btn-hapus").click(function(){
                                  var nama_barang = $(this).attr("data-nama-barang");
                                  var kode_barang = $(this).attr("data-kode-barang");
                                  $("#hapus_barang").val(nama_barang);
                                  $("#kode_hapus").val(kode_barang);
                                  $("#modal_hapus").modal('show');
                                  
                                  
                                  });
                                  
                                  $("#btn_jadi_hapus").click(function(){
                                  
                                  var kode_barang = $("#kode_hapus").val();
                                  $.post("hapus_tbs_stok_awal.php",{kode_barang:kode_barang},function(data){

                                  if (data != '') {
                                  $("#result").load('tabel_stok_awal.php');
                                  $("#modal_hapus").modal('hide');
                                  
                                  
                                  }
                                  });                      
                                  });
                                  
                                  
                                  //end fungsi hapus data

                                  
                                  
                                  
                                  
                                  });
                                  
                                  
                                  $('form').submit(function(){
                                  
                                  return false;
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
                                    var kode_barang = $(this).attr("data-kode");
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-total-"+id+"").text()))));
                                    var subtotal = harga * jumlah_baru;

                              
                                  $.post("update_tbs_stok_awal.php", {jumlah_baru:jumlah_baru,harga:harga,id:id}, function(info){


                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-total-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");        
                                    
                                    
                                    });
                                    
                           

                                   
                                   $("#kode_barang").focus();

                                 });

                             </script>
