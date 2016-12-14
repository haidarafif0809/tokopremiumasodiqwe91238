<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT p.id,p.no_faktur_pembayaran,p.keterangan,p.total,p.nama_suplier,p.tanggal,p.tanggal_edit,p.jam,p.user_buat,p.user_edit,p.dari_kas,s.nama,da.nama_daftar_akun FROM pembayaran_hutang p INNER JOIN suplier s ON p.nama_suplier = s.id INNER JOIN daftar_akun da ON p.dari_kas = da.kode_daftar_akun ORDER BY p.id DESC");



 ?>

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

<div class="container"> <!--start of container-->

<h3><b>DATA PEMBAYARAN HUTANG</b></h3><hr>

<!--membuat link-->

<?php
include 'db.php';

$pilih_akses_pembayaran_hutang = $db->query("SELECT * FROM otoritas_pembayaran WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$pembayaran_hutang = mysqli_fetch_array($pilih_akses_pembayaran_hutang);

if ($pembayaran_hutang['pembayaran_hutang_tambah'] > 0) {

echo '<a href="form_pembayaran_hutang.php"  class="btn btn-info" > <i class="fa fa-plus"> </i> PEMBAYARAN HUTANG</a>';
}
?>
<br><br>

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Pembayaran Hutang</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Suplier :</label>
     <input type="text" id="suplier" class="form-control" readonly="">
     <label> Nomor Faktur :</label>
     <input type="text" id="no_faktur_hapus" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" data-id="" class="btn btn-info" id="btn_jadi_hapus"><span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<div id="modal_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Pembayaran Hutang </h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detail"> </span>
      </div>

     </div>

      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-close"> Close</i></button>
      </div>
    </div>

  </div>
</div>


<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table_baru">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color:white"> Detail </th>

<?php

if ($pembayaran_hutang['pembayaran_hutang_edit'] > 0) {
    	echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
}
?>

<?php

if ($pembayaran_hutang['pembayaran_hutang_hapus'] > 0) {

    	echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
}
?>
			
			
			<th style="background-color: #4CAF50; color:white"> Cetak </th>
			<th style="background-color: #4CAF50; color:white"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color:white"> Tanggal </th>
			<th style="background-color: #4CAF50; color:white"> Jam </th>
			<th style="background-color: #4CAF50; color:white"> Nama Suplier </th>
			<th style="background-color: #4CAF50; color:white"> Keterangan </th>
			<th style="background-color: #4CAF50; color:white"> Total </th>
			<th style="background-color: #4CAF50; color:white"> User Buat </th>
			<th style="background-color: #4CAF50; color:white"> User Edit </th>
			<th style="background-color: #4CAF50; color:white"> Tanggal Edit </th>
			<th style="background-color: #4CAF50; color:white"> Dari Kas </th>
			
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{
				//menampilkan data
			echo "<tr class='tr-id-".$data1['id']."'>

			<td> <button class=' btn btn-info detail' no_faktur_pembayaran='". $data1['no_faktur_pembayaran'] ."'> Detail  </button> </td>";




if ($pembayaran_hutang['pembayaran_hutang_edit'] > 0) {

		echo "<td> <a href='proses_edit_pembayaran_hutang.php?no_faktur_pembayaran=". $data1['no_faktur_pembayaran']."&nama=". $data1['nama']."&cara_bayar=". $data1['dari_kas']."' class='btn btn-success'> Edit  </a> </td>";

	}



if ($pembayaran_hutang['pembayaran_hutang_hapus'] > 0) {

			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-suplier='". $data1['nama'] ."' data-no_faktur_pembayaran='". $data1['no_faktur_pembayaran'] ."'> Hapus  </button> </td>";
			} 

			echo "<td> <a href='cetak_lap_pembayaran_hutang.php?no_faktur_pembayaran=".$data1['no_faktur_pembayaran']."&nama_suplier=".$data1['nama']."' class='btn btn-primary' target='blank'>Cetak Hutang  </a> </td>
			<td>". $data1['no_faktur_pembayaran'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['nama'] ."</td>
			<td>". $data1['keterangan'] ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". $data1['user_buat'] ."</td>
			<td>". $data1['user_edit'] ."</td>
			<td>". $data1['tanggal_edit'] ."</td>
			<td>". $data1['nama_daftar_akun'] ."</td>
			
			</tr>";
			}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
			
		?>
		</tbody>

	</table>
</span>
</div>

		<br>
		<button type="submit" id="submit_close" class="glyphicon glyphicon-remove btn btn-danger" style="display:none"></button> 
		<span id="demo"> </span>
</div><!--end of container-->

<script>
		
		// untk menampilkan datatable atau filter seacrh
		$(document).ready(function(){
		$('#tableuser').DataTable({"ordering":false});
		});

		
		$(".detail").click(function(){
		var no_faktur_pembayaran = $(this).attr('no_faktur_pembayaran');
		
		
		$("#modal_detail").modal('show');
		
		$.post('proses_detail_pembayaran_hutang.php',{no_faktur_pembayaran:no_faktur_pembayaran},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});
		
		</script>

 <script type="text/javascript">
			
//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var suplier = $(this).attr("data-suplier");
		var no_faktur_pembayaran = $(this).attr("data-no_faktur_pembayaran");
		var id = $(this).attr("data-id");
		$("#suplier").val(suplier);
		$("#no_faktur_hapus").val(no_faktur_pembayaran);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		$("#btn_jadi_hapus").attr("data-id", id);
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var id = $(this).attr("data-id");
		var no_faktur_pembayaran = $("#no_faktur_hapus").val();

		$.post("hapus_data_pembayaran_hutang.php",{id:id,no_faktur_pembayaran:no_faktur_pembayaran},function(data){
		if (data != "") {
		
		$("#modal_hapus").modal('hide');
		$(".tr-id-"+id).remove();
		
		}

		
		});
		
		
		});




		</script>


<?php 
include 'footer.php';
 ?>