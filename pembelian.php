<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,s.nama,g.nama_gudang, g.kode_gudang FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang ORDER BY p.id DESC");


 ?>



<div class="container"> <!--start of container-->

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
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data,<br>
        silahkan hapus terlebih dahulu Transaksi Pembayaran Hutang atau Retur Pembelian atau Penjualan</i></h6>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Pembelian</h4>
      </div>
      <div class="modal-body">
   <p>Apakah Anda yakin Ingin Menghapus Data Pembelian Dengan Suplier ini ?</p>
   <form >
    <div class="form-group">
    <label>Nama Suplier :</label>
     <input type="text" id="nama_suplier" class="form-control" readonly=""> 
    <label>Nomor Faktur :</label>
     <input type="text" id="faktur_hapus" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control">
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-id="" id="btn_jadi_hapus"> <span class="glyphicon glyphicon-ok-sign"> </span>Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class="glyphicon glyphicon-remove-sign"> </span>Batal</button>
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
        <h4 class="modal-title">Detail Pembelian</h4>
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

<h3>DATA PEMBELIAN</h3>
<hr>


<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
</style>

<?php 
include 'db.php';

$pilih_akses_pembelian_lihat = $db->query("SELECT pembelian_lihat FROM otoritas_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pembelian_lihat = '1'");
$pembelian_lihat = mysqli_num_rows($pilih_akses_pembelian_lihat);


    if ($pembelian_lihat > 0){
// membuat link-->
echo '<a href="formpembelian.php"  class="btn btn-info"> <i class="fa fa-plus"> </i> PEMBELIAN</a>';

}
?>
<br><br>

<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table-baru" > 
<table id="tableuser" class="table table-bordered">
		<thead>
			<th> Detail </th>

<?php 
include 'db.php';

$pilih_akses_pembelian_edit = $db->query("SELECT pembelian_edit FROM otoritas_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pembelian_edit = '1'");
$pembelian_edit = mysqli_num_rows($pilih_akses_pembelian_edit);


    if ($pembelian_edit > 0){
				echo "<th> Edit </th>";

			}
?>

<?php 
include 'db.php';

$pilih_akses_pembelian_hapus = $db->query("SELECT pembelian_hapus FROM otoritas_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pembelian_hapus = '1'");
$pembelian_hapus = mysqli_num_rows($pilih_akses_pembelian_hapus);


    if ($pembelian_hapus > 0){
				echo "<th> Hapus </th>";
	}
	?>
			
			<th> Cetak Tunai </th>
			<th> Cetak Hutang </th>
			<th> Nomor Faktur </th>
			<th> Gudang </th>
			<th> Suplier </th>
			<th> Total </th>
			<th> Tanggal </th>
			<th> Tanggal Jatuh Tempo </th>
			<th> Jam </th>
			<th> User </th>
			<th> Status </th>
			<th> Potongan </th>
			<th> Tax </th>
			<th> Kembalian</th>
			<th> Kredit </th>
			
			
			
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan  sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{

				//menampilkan data
			echo "<tr class='tr-id-".$data1['id']."'>
			<td> <button class='btn btn-info detail' no_faktur='". $data1['no_faktur'] ."'> <span class='glyphicon glyphicon-th-list'></span> Detail </button> </td>";

		

include 'db.php';

$pilih_akses_pembelian_edit = $db->query("SELECT pembelian_edit FROM otoritas_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pembelian_edit = '1'");
$pembelian_edit = mysqli_num_rows($pilih_akses_pembelian_edit);


    if ($pembelian_edit > 0){
				echo "<td> <a href='proses_edit_pembelian.php?no_faktur=". $data1['no_faktur']."&suplier=". $data1['suplier']."&nama_gudang=".$data1['nama_gudang']."&kode_gudang=".$data1['kode_gudang']."&nama_suplier=".$data1['nama']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a> </td>"; 
}


include 'db.php';

$pilih_akses_pembelian_hapus = $db->query("SELECT pembelian_hapus FROM otoritas_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pembelian_hapus = '1'");
$pembelian_hapus = mysqli_num_rows($pilih_akses_pembelian_hapus);


    if ($pembelian_hapus > 0){

 $retur = $db->query ("SELECT no_faktur_pembelian FROM detail_retur_pembelian WHERE no_faktur_pembelian = '$data1[no_faktur]'");
 $row_retur = mysqli_num_rows($retur);

 $hpp_masuk_penjualan = $db->query ("SELECT no_faktur FROM hpp_masuk WHERE no_faktur = '$data1[no_faktur]' AND sisa != jumlah_kuantitas");
 $row_masuk = mysqli_num_rows($hpp_masuk_penjualan);

 $hutang = $db->query ("SELECT no_faktur_pembelian FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$data1[no_faktur]'");
 $row_hutang = mysqli_num_rows($hutang);
		
		if ($row_retur > 0 || $row_masuk > 0 || $row_hutang > 0) {

			echo "<td> <button class='btn btn-danger btn-alert' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."'><span class='glyphicon glyphicon-trash'></span> Hapus  </button> </td>"; 

		}
		else{

			echo "<td> <button class='btn btn-danger btn-hapus' data-id='".$data1['id']."' data-suplier='".$data1['nama']."' data-faktur='".$data1['no_faktur']."'><span class='glyphicon glyphicon-trash'></span> Hapus  </button> </td>"; 

		} 
			
			}

			

			if ($data1['status'] == 'Lunas') {

			echo "<td> <a href='cetak_lap_pembelian_tunai.php?no_faktur=".$data1['no_faktur']."&suplier=".$data1['nama']."' id='cetak_tunai' class='btn btn-primary' target='blank'><span class='glyphicon glyphicon-print' > </span> Cetak Tunai </a> </td>";
}

else{

	echo "<td> </td>";
	
}

			
if ($data1['status'] == 'Hutang'){
	echo "<td> <a href='cetak_lap_pembelian_hutang.php?no_faktur=".$data1['no_faktur']."&suplier=".$data1['nama']."' id='cetak_piutang' class='btn btn-primary' target='blank'><span class='glyphicon glyphicon-print' > </span> Cetak Hutang </a> </td>";
}

else {

	echo "<td> </td>";
}
			echo "<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['nama_gudang'] ."</td>
			<td>". $data1['nama'] ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['tanggal_jt'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>
			<td>". $data1['status'] ."</td>
			<td>". rp($data1['potongan']) ."</td>
			<td>". rp($data1['tax']) ."</td>
			<td>". rp($data1['sisa']) ."</td>
			<td>". rp($data1['kredit']) ."</td>
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
		$('#tableuser').DataTable(
			{"ordering": false});
		});
		</script>

		<script type="text/javascript">
		
		$(".detail").click(function(){
		var no_faktur = $(this).attr('no_faktur');
		
		
		$("#modal_detail").modal('show');
		
		$.post('proses_detail_pembelian.php',{no_faktur:no_faktur},function(info) {
		$("#modal-detail").html(info);
		
		
		});
		
		});
		
		</script>
		
		
		


		<script type="text/javascript">
						$(document).ready(function(){
						//fungsi hapus data 
						$(document).on('click', '.btn-hapus', function (e) {
						var suplier = $(this).attr("data-suplier");
						var no_faktur = $(this).attr("data-faktur");
						var id = $(this).attr("data-id");

						$("#nama_suplier").val(suplier);
						$("#faktur_hapus").val(no_faktur);
						$("#id_hapus").val(id);
						$("#modal_hapus").modal('show');
						$("#btn_jadi_hapus").attr("data-id", id);

						});
						
						$("#btn_jadi_hapus").click(function(){
						
						var id = $(this).attr("data-id");
						var no_faktur = $("#faktur_hapus").val();

						$.post("hapus_data_pembelian.php", {id:id, no_faktur:no_faktur}, function(data){
						if (data == 'sukses') {
						
						$("#modal_hapus").modal("hide");
						$(".tr-id-"+id).remove();
						
						}
						
						});
						
						
						});
						
						$('form').submit(function(){
						
						return false;
						});
						});

		</script>


<script type="text/javascript">
	$(document).on('click', '.btn-alert', function (e) {
			var no_faktur = $(this).attr("data-faktur");
						
			$.post('modal_alert_hapus_data_pembelian.php',{no_faktur:no_faktur},function(data){


			$("#modal_alert").modal('show');
			$("#modal-alert").html(data);

			});
	});
</script>

		



<?php 
include 'footer.php';
 ?>