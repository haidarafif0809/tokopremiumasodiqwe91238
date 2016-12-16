<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';


$query = $db->query("SELECT pa.status,pa.id_promo_alert,b.nama_barang,pa.pesan_alert,pa.id_produk FROM promo_alert pa INNER JOIN barang b ON pa.id_produk = b.id ");

 ?>



<!-- Modal Untuk Confirm PESAN alert-->
<div id="detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">

    <h3><center><b>Pesan Alert Promo</b></center></h3>
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">
      <span id="tampil_layanan">
      </span>
    </div>
    <div class="modal-footer">
        
        <button type="button" class="btn btn-danger" data-dismiss="modal">Closed</button>
    </div>
    </div>
  </div>
</div>
<!--modal end pesan alert-->

<div class="container">
<h3><b>DATA PROMO ALERT</b></h3> <hr>
<!-- Trigger the modal with a button -->





  <button id="coba" type="submit" class="btn btn-primary" data-toggle="collapse"  data-target="#demo"  accesskey="r" ><i class='fa fa-plus'> </i>&nbsp;Tambah</button>


<br>
<br>


<div id="demo" class="collapse">
<form role="form" method="POST" action="proses_pormo_alert.php">
		<div class="form-group">
					
					<label> Nama Produk </label><br>
					<input name="kode_barang" id="kode_barang" class="form-control ss"  placeholder="Ketik Nama Produk (Promo)" autocomplete="off" required="" >
<br>					

					<input type="hidden" name="id_produk" id="id_produk">

					<label> Pesan Alert </label><br>
					<textarea name="pesan_alert" id="pesan_alert" style="height:250px" class="form-control"  placeholder="Pesan Alert Promo" required=""></textarea>  <br>

					<label> Status </label><br>
					<select name="status" id="status" class="form-control ss" autocomplete="off" required="" >
					<option value="1">Aktif</option>
					<option value="2">Tidak Aktif</option>
					</select><br>					


					<button type="submit" id="submit_tambah" class="btn btn-success">Submit</button>

		</div>
</form>

				
					<div class="alert alert-success" style="display:none">
					<strong>Berhasil!</strong> Data berhasil Di Tambah
					</div>
</div>




<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Promo</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
		<input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->




<style>

tr:nth-child(even){background-color: #f2f2f2}


</style>


<div class="table-responsive">
<span id="table_baru">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color: white'> Nama Produk</th>
			<th style='background-color: #4CAF50; color: white'> Pesan Alert</th>
			<th style='background-color: #4CAF50; color: white'> Status</th>
			<th style='background-color: #4CAF50; color: white'> Hapus </th>
			<th style='background-color: #4CAF50; color: white'> Edit </th>	
		</thead>
		
		<tbody id="tbody">
		<?php

		
			while ($data = mysqli_fetch_array($query))
			{
			echo "<tr class='tr-id-". $data['id_promo_alert'] ."'>
			
			<td>". $data['nama_barang'] ."</td>
			<td><button class='btn btn-success detaili' data-id='".$data['id_promo_alert']."'><span class='fa fa-list'></span> Lihat Pesan </button></td>
			";
			if ($data['status'] == "1")
			{
			echo "<td>Aktif</td>";
			}
			else
			{
			echo "<td>Tidak Aktif</td>";
			};
		
		echo "<td><button class='btn btn-danger btn-hapus' data-id='". $data['id_promo_alert'] ."'> <span class='fa fa-trash'></span> Hapus </button></td>
			<td><a href='edit_promo_alert.php?id=". $data['id_promo_alert']."' class='btn btn-warning'><span class='fa fa-edit'></span> Edit </a> </td>
			</tr>";
			}

			//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>
		</tbody>

	</table>
</span>
</div>


<!--   script untuk detail layanan -->
<script type="text/javascript">

//            jika dipilih, nim akan masuk ke input dan modal di tutup
            $(document).on('click', '.detaili', function (e) {
              
               
                var id = $(this).attr('data-id');
               
                $.post("detail_pesan_alert.php",{id:id},function(data){
                    $("#tampil_layanan").html(data);
               $("#detail").modal('show');
          
                });

               
            });
      

//            tabel lookup mahasiswa
            
          
</script>
<!--  end script untuk akhir detail layanan  -->


<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>



<script>
$(function() {
    $( "#kode_barang" ).autocomplete({
        source: 'kodebarang_promo_autocomplete.php'
    });
});
</script>


<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){

          var kode_barang = $(this).val();
          var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
          
          if (kode_barang != '')
          {

      $.getJSON('lihat_nama_barang.php',{kode_barang:kode_barang}, function(json){
      
      if (json == null)
      {
        
        $('#id_produk').val('');
       
      }

      else 
      {
        $('#id_produk').val(json.id);
        
      }
                                              
        });   
}

        });
        });     
</script>



        <script type="text/javascript">
//fungsi hapus data 
								$(".btn-hapus").click(function(){

								var id = $(this).attr("data-id");
								$("#id_hapus").val(id);
								$("#modal_hapus").modal('show');
								
								
								});
								
								
								$("#btn_jadi_hapus").click(function(){
								
								var id = $("#id_hapus").val();
								
								$.post("hapuspromoalert.php",{id:id},function(data){
								if (data == "sukses") {
								$(".tr-id-"+id+"").remove();
								$("#modal_hapus").modal('hide');
							
								}
								
								
								});
								
								});
					// end fungsi hapus data
</script>


<script type="text/javascript">
$(function () {
 $("#pesan_alert").wysihtml5();

});
</script>


<?php
 include 'footer.php'; ?>
