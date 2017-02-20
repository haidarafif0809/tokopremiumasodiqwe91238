<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT p.nama_pelanggan,rp.id,rp.kode_pelanggan,rp.no_faktur_retur,rp.kode_pelanggan,rp.total,rp.potongan,rp.tax,rp.tanggal,rp.jam,rp.user_buat,rp.user_edit,rp.tanggal_edit,rp.tunai,rp.sisa FROM retur_penjualan rp INNER JOIN pelanggan p ON rp.kode_pelanggan = p.kode_pelanggan ");

?>



<div class="container"> <!--start of container-->

<h3><b> DATA RETUR PENJUALAN </b></h3><hr>

<!--membuat link-->

<?php
include 'db.php';

$pilih_akses_retur_penjualan = $db->query("SELECT * FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$retur_penjualan = mysqli_fetch_array($pilih_akses_retur_penjualan);

if ($retur_penjualan['retur_penjualan_tambah'] > 0) {

echo '<a href="form_retur_penjualan.php"  class="btn btn-info"><i class="fa fa-plus"></i> RETUR PENJUALAN</a>';

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
        <h4 class="modal-title">Konfirmasi Hapus Data Retur Pembelian</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Kode Pelanggan :</label>
     <input type="text" id="data_pelanggan" class="form-control" readonly=""> 
    <label> No faktur :</label>
     <input type="text" id="hapus_faktur" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" data-id="" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
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
        <h4 class="modal-title">Detail Retur Penjualan </h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detail"> </span>
      </div>

     </div>

      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="modal_alert" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 style="color:orange" class="modal-title"><span class="glyphicon glyphicon-info-sign">Info</span></h3>
        
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-alert">
       </span>
      </div>

     </div>

      <div class="modal-footer">
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data, 
        silahkan hapus terlebih dahulu<br> Transaksi yang diatas.</i></h6>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<style>


tr:nth-child(even){background-color: #f2f2f2}

</style>

<div class="table-responsive">
<span id="tabel_baru">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Detail </th>

<?php
if ($retur_penjualan['retur_penjualan_edit'] > 0) {
    	echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
   }
?>

<?php
if ($retur_penjualan['retur_penjualan_hapus'] > 0) {
    	echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
   }
?>
			
			
			<th style='background-color: #4CAF50; color:white'> Cetak </th>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur Retur </th>
			<th style='background-color: #4CAF50; color:white'> Kode Pelanggan </th>
			<th style='background-color: #4CAF50; color:white'> Total </th>
			<th style='background-color: #4CAF50; color:white'> Potongan </th>
			<th style='background-color: #4CAF50; color:white'> Tax </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> User Buat </th>
			<th style='background-color: #4CAF50; color:white'> User Edit </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal Edit</th>
			<th style='background-color: #4CAF50; color:white'> Tunai </th>
			<th style='background-color: #4CAF50; color:white'> Kembalian </th>

		</thead>

		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{
				//menampilkan data
			echo "<tr class='tr-id-".$data1['id']."'>

			<td> <button class='btn btn-info detail' no_faktur_retur='". $data1['no_faktur_retur'] ."' ><span class='glyphicon glyphicon-th-list'></span> Detail </button> </td>";

if ($retur_penjualan['retur_penjualan_edit'] > 0) {

			echo "<td> <a href='proses_edit_retur_penjualan.php?no_faktur_retur=". $data1['no_faktur_retur']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a> </td>";
		}


if ($retur_penjualan['retur_penjualan_hapus'] > 0) {

$pilih = $db->query("SELECT no_faktur FROM hpp_masuk WHERE no_faktur = '$data1[no_faktur_retur]' AND sisa != jumlah_kuantitas");
$row_alert = mysqli_num_rows($pilih);

	if ($row_alert > 0) {
		

		echo "<td> <button class='btn btn-danger btn-alert' data-id='". $data1['id'] ."' data-faktur='". $data1['no_faktur_retur'] ."' data-pelanggan='". $data1['kode_pelanggan'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>  </td>";
	} 

	else {

		echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-faktur='". $data1['no_faktur_retur'] ."' data-pelanggan='". $data1['kode_pelanggan'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>  </td>";
	}


			
}
			
			echo "<td> <a href='cetak_lap_retur_penjualan.php?no_faktur_retur=".$data1['no_faktur_retur']."' class='btn btn-primary' target='blank'><span class='glyphicon glyphicon-print'> </span> Cetak Retur</a> </td>

			<td>". $data1['no_faktur_retur'] ."</td>
			<td>". $data1['kode_pelanggan'] ." ". $data1['nama_pelanggan'] ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". rp($data1['potongan']) ."</td>
			<td>". rp($data1['tax']) ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user_buat'] ."</td>
			<td>". $data1['user_edit'] ."</td>
			<td>". $data1['tanggal_edit'] ."</td>
			<td>". rp($data1['tunai']) ."</td>
			<td>". rp($data1['sisa']) ."</td>
			
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
		

		<!--menampilkan detail penjualan-->
		<script>
		
		$(document).ready(function(){
		$('#tableuser').DataTable();
		});
		
		
		$(".detail").click(function(){
		var no_faktur_retur = $(this).attr('no_faktur_retur');
		
		
		$("#modal_detail").modal('show');
		
		$.post('detail_retur_penjualan.php',{no_faktur_retur:no_faktur_retur},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});
		
		</script>

				<script type="text/javascript">
				
				//fungsi hapus data 
				$(".btn-hapus").click(function(){
				var kode_pelanggan = $(this).attr("data-pelanggan");
				var no_faktur_retur = $(this).attr("data-faktur");
				var id = $(this).attr("data-id");
				$("#data_pelanggan").val(kode_pelanggan);
				$("#hapus_faktur").val(no_faktur_retur);
				$("#id_hapus").val(id);
				$("#modal_hapus").modal('show');
				$("#btn_jadi_hapus").attr("data-id", id);
				
				
				});
				
				$("#btn_jadi_hapus").click(function(){
				
				
				var id = $(this).attr("data-id");
				var no_faktur_retur =$("#hapus_faktur").val();

				$.post("hapus_data_retur_penjualan.php",{id:id, no_faktur_retur:no_faktur_retur},function(data){
				if (data != "") {
				
				$("#modal_hapus").modal('hide');
				$(".tr-id-"+id).remove();
				
				}
				
				});
				
				
				});
				
				
				</script>


<script type="text/javascript">
	
		$(document).on('click', '.btn-alert', function (e) {
		var no_faktur = $(this).attr("data-faktur");

		$.post('modal_alert_hapus_data_retur_penjualan.php',{no_faktur:no_faktur},function(data){


		$("#modal_alert").modal('show');
		$("#modal-alert").html(data);

		});

		
		});

</script>


<?php 
include 'footer.php';
 ?>