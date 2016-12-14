<?php include 'session_login.php';


// memasukan file session login,  header, navbar, db.php,
include 'db.php';
include 'sanitasi.php';

$session_id = session_id();

 $query = $db->query("SELECT * FROM barang");

 ?>
  <table id="tableuser" class="table table-bordered" style="width:100%">
        

        <thead>


          <th> Nama Barang </th>
          <th> Jumlah Barang </th>
          <th> Subtotal </th>

        </thead>
        <tbody>
        <?php
        
        // menampilkan seluruh data yang ada pada tabel barang
        $perintah = "SELECT * FROM tbs_penjualan WHERE session_id = '$session_id'";
        $perintah1 = $db->query($perintah);
        
        // menyimpoan data sementara yang ada pada $perintah1
        while ($data1 = mysqli_fetch_array($perintah1))
        {
        // menampilkan data
            echo "<tr class='hapus_edit tr-id-". $data1['id'] ."' data-jumlah-barang='". $data1['jumlah_barang'] ."' data-harga='". $data1['harga'] ."' data-id='". $data1['id'] ."' data-pesanan='". $data1['nama_barang'] ."' data-kode='". $data1['kode_barang'] ."'>
            <td>". $data1['nama_barang'] ."</td>
            <td>". $data1['jumlah_barang'] ."</td>
            <td>". $data1['subtotal'] ."</td> 
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

          
          //fungsi edit data 
          $(".hapus_edit").click(function(){
          
          $("#modal_edit").modal('show');
          var jumlah_barang = $(this).attr("data-jumlah-barang");
          var harga = $(this).attr("data-harga");
          var id  = $(this).attr("data-id");
          var kode_barang = $(this).attr("data-kode");
                                     var nama_barang = $(this).attr("data-pesanan");
          $("#harga_edit").val(harga);
          $("#barang_lama").val(jumlah_barang);
          $("#id_edit").val(id);
          $("#kode_edit").val(kode_barang);
                                    $("#data_nama_barang").val(nama_barang);
          
          
          });
          
          $("#submit_edit").click(function(){
          var jumlah_barang = $("#barang_lama").val();
          var jumlah_baru = $("#barang_edit").val();
          var harga = $("#harga_edit").val();
          var id = $("#id_edit").val();
          var kode_barang = $("#kode_edit").val();
          var no_faktur = $("#nofaktur").val();
          
          $.post("update_tbs_pos.php",{id:id,jumlah_barang:jumlah_barang,jumlah_baru:jumlah_baru,harga:harga,kode_barang:kode_barang,no_faktur:no_faktur},function(data){
          
          $("#alert").html(data);
          $("#result").load('tabel-pesanan.php');
          
          setTimeout(tutupmodal, 2000);
          setTimeout(tutupalert, 2000);
          
                  
          });
                  
          });


                $("#btn_jadi_hapus").click(function(){
                
                var id = $("#id_edit").val();
                var kode_barang = $("#kode_edit").val();
                $.post("hapus_pos_penjualan.php",{id:id,kode_barang:kode_barang},function(data){
                if (data != "") {
                $(".tr-id-"+id+"").remove();
                $("#modal_edit").modal('hide');
                
                }
                
                
                });
                
                });
                  
                  $('form').submit(function(){
                  
                  return false;
                  });
                  });
                  
                  
                  function tutupalert() {
                  $("#alert").html("")
                  }
                  
                  function tutupmodal() {
                  $("#modal_edit").modal("hide")
                  }
                  
                  
                  </script>

															
															<script type="text/javascript">
															
															$(".btn-komen").click(function(){
															var komentar = $(this).attr("data-komen");
															var id = $(this).attr("data-id");
															
															$("#kolom_komen").val(komentar);
															$("#id_komen").val(id);
															$("#modal_komen").modal('show');
															
															
															});
															
															
															</script>