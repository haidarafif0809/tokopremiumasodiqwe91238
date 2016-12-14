<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$status = $_GET['status'];

if ($status == 'semua') {
    
    $perintah = $db->query("SELECT p.id,p.no_faktur,p.total,p.kode_pelanggan,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,g.nama_gudang,p.kode_gudang,pl.nama_pelanggan FROM penjualan p INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan ORDER BY p.id DESC");

}

else{
    $perintah = $db->query("SELECT p.id,p.no_faktur,p.total,p.kode_pelanggan,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,g.nama_gudang,p.kode_gudang,pl.nama_pelanggan FROM penjualan p INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan WHERE p.status = '$status' ORDER BY p.id DESC");
}

 ?>




<div class="container"><!--start of container-->



<!--MODAL VOID -->
<div id="modal_void" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Batal / Void</h4>
      </div>
      <div class="modal-body">
  <form role="form" action="proses_login_void.php" method="post" >
   <div class="form-group" id="modal_login">
<h3> Silakan Masuk </h3>
          <input type="text" name="username" placeholder="Username" id="username" autocomplete="off" required class="form-control input-lg" value="" /> <br>
          
          <input type="password" name="password" class="form-control input-lg" id="password" placeholder="Password  " required="" /> <br>

          <button type="submit" id="login" class="btn btn-primary">LogIn</button>
	</div>
</form>


	
	 <form role="form" action="Proses_batal_void.php" method="post" >
	<div class="form-group" id="modal_keterangan" style="display:none">

			<label> Keterangan Batal </label>
			<textarea name="keterangan" id="keterangan" class="form-control"></textarea><br>
			<input type="hidden" name="no_faktur" class="form-control input-lg" id="no_faktur_batal" placeholder="no_faktur  "/>
			
			<button type="submit" id="batal_penjualan" class="btn btn-danger">Batal / Void</button>
    
   </div>
    
   
  </form>

<div class="alert-sukses alert-info" style="display:none">
            <strong>SUKSES!</strong> LogIn Berhasil !.
</div>

<div class="alert-void alert-danger" style="display:none">
                <strong>PERHATIAN!</strong> LogIn Gagal !.
</div>

  
 <div class="alert alert-info" style="display:none">
            <strong>SUKSES!</strong>Pindah Meja Berhasil
 </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal pindah meja -->


<!-- Modal pindah meja -->
<div id="modal_meja_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Pindah Meja</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Nomor / Nama Meja Baru:</label><br>

    	<select type="text" name="kode_meja" id="meja_edit" class="form-control" required="" >
    	<option value="">--SILAHKAN PILIH--</option>
			<?php 
			
			//untuk menampilkan semua data pada tabel pelanggan dalam DB
			$query = $db->query("SELECT kode_meja, nama_meja FROM meja WHERE status_pakai = 'Belum Terpakai'");
			
			//untuk menyimpan data sementara yang ada pada $query
			while($data = mysqli_fetch_array($query))
			{
			
			echo "<option value='".$data['kode_meja'] ."'>".$data['nama_meja'] ."</option>";
			}
			
			
			?>
    	</select>




     <label for="email">Nomor / Nama Meja Lama:</label>
     <input type="text" class="form-control" id="meja_lama" readonly="">
     <input type="hidden" class="form-control" id="no_faktur_meja">
    
   </div>
    <button type="submit" id="submit_meja" class="btn btn-primary">Submit</button>
   
  </form>
  
 <div class="alert alert-info" style="display:none">
            <strong>SUKSES!</strong>Pindah Meja Berhasil
 </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal pindah meja -->

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Penjualan</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label>Kode Pelanggan :</label>
     <input type="text" id="kode_pelanggan" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
     <input type="hidden" id="kode_meja" class="form-control" > 
     <input type="hidden" id="faktur_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" data-id="" class="btn btn-info" id="btn_jadi_hapus">Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
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
        <h4 class="modal-title">Detail Penjualan</h4>
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
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data,<br>
        silahkan hapus terlebih dahulu Transaksi Pembayaran Piutang atau Item Keluar</h6>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<h3>DATA PENJUALAN</h3>
<hr>

<div class="row">

<div class="col-sm-5">

<?php 
include 'db.php';

$pilih_akses_penjualan_tambah = $db->query("SELECT penjualan_tambah FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_tambah = '1'");
$penjualan_tambah = mysqli_num_rows($pilih_akses_penjualan_tambah);


if ($penjualan_tambah > 0){
 echo '<a href="formpenjualan.php" class="btn btn-info" > <i class="fa fa-plus"> </i>  PENJUALAN </a>';
 
}
?>

</div>


<div class="col-sm-7">
	<ul class="nav nav-tabs md-pills pills-ins" role="tablist">
       <?php if ($status == 'semua'): ?>

      <li class="nav-item"><a class="nav-link active" href='penjualan.php?status=semua'> Semua Penjualan </a></li>
        <li class="nav-item"><a class="nav-link" href='penjualan.php?status=Lunas' > Penjualan Lunas </a></li>
        <li class="nav-item"><a class="nav-link" href='penjualan.php?status=Piutang' > Penjualan Piutang </a></li>
       	
       <?php endif ?>

       <?php if ($status == 'Lunas'): ?>

         <li class="nav-item"><a class="nav-link" href='penjualan.php?status=semua'> Semua  Penjualan </a></li>
        <li class="nav-item"><a class="nav-link active" href='penjualan.php?status=Lunas'> Penjualan Lunas </a></li>
        <li class="nav-item"><a class="nav-link" href='penjualan.php?status=Piutang' > Penjualan Piutang </a></li>
       	
       <?php endif ?>

       <?php if ($status == 'Piutang'): ?>

          <li class="nav-item"><a class="nav-link" href='penjualan.php?status=semua'> Semua  Penjualan </a></li>
        <li class="nav-item"><a class="nav-link" href='penjualan.php?status=Lunas'> Penjualan Lunas </a></li>
        <li class="nav-item"><a class="nav-link active" href='penjualan.php?status=Piutang'> Penjualan Piutang </a></li>
       	
       <?php endif ?>


         </ul>
</div>
       
</div>



<style>


tr:nth-child(even){background-color: #f2f2f2}


</style>
<br>



<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table-baru">
<table id="tableuser" class="table table-bordered">
		<thead>

		
			
<?php 
include 'db.php';

$pilih_akses_penjualan_edit = $db->query("SELECT penjualan_edit FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_edit = '1'");
$penjualan_edit = mysqli_num_rows($pilih_akses_penjualan_edit);


    if ($penjualan_edit > 0){
				echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
			}
				
?>



<?php 
include 'db.php';

$pilih_akses_penjualan_hapus = $db->query("SELECT penjualan_hapus FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_hapus = '1'");
$penjualan_hapus = mysqli_num_rows($pilih_akses_penjualan_hapus);


    if ($penjualan_hapus > 0){

			echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";

		}
?>
			<th style='background-color: #4CAF50; color:white'> Cetak  Tunai </th>
			<th style='background-color: #4CAF50; color:white'> Cetak Piutang </th>
			<th style='background-color: #4CAF50; color:white'> Detail </th>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Gudang </th>
			<th style='background-color: #4CAF50; color:white'> Bayar </th>
			<th style='background-color: #4CAF50; color:white'> Kode Pelanggan</th>
			<th style='background-color: #4CAF50; color:white'> Total </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal Jt </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> Petugas Kasir </th>
			<th style='background-color: #4CAF50; color:white'> Sales </th>
			<th style='background-color: #4CAF50; color:white'> Status </th>
			<th style='background-color: #4CAF50; color:white'> Potongan </th>
			<th style='background-color: #4CAF50; color:white'> Tax </th>
			<th style='background-color: #4CAF50; color:white'> Kembalian </th>
			<th style='background-color: #4CAF50; color:white'> Kredit </th>
			
			

			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))

			{



include 'db.php';

$pilih_akses_penjualan_edit = $db->query("SELECT penjualan_edit FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_edit = '1'");
$penjualan_edit = mysqli_num_rows($pilih_akses_penjualan_edit);


    if ($penjualan_edit > 0){

			echo "<tr class='tr-id-".$data1['id']."'> <td> <a href='proses_edit_penjualan.php?no_faktur=". $data1['no_faktur']."&kode_pelanggan=". $data1['kode_pelanggan']."&nama_gudang=".$data1['nama_gudang']."&kode_gudang=".$data1['kode_gudang']."' class='btn btn-success'>Edit</a> </td>";	


		}


include 'db.php';

$pilih_akses_penjualan_hapus = $db->query("SELECT penjualan_hapus FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_hapus = '1'");
$penjualan_hapus = mysqli_num_rows($pilih_akses_penjualan_hapus);


	if ($penjualan_hapus > 0){

$pilih = $db->query("SELECT no_faktur_penjualan FROM detail_retur_penjualan WHERE no_faktur_penjualan = '$data1[no_faktur]'");
$row_retur = mysqli_num_rows($pilih);

$pilih = $db->query("SELECT no_faktur_penjualan FROM detail_pembayaran_piutang WHERE no_faktur_penjualan = '$data1[no_faktur]'");
$row_piutang = mysqli_num_rows($pilih);

if ($row_retur > 0 || $row_piutang > 0) {

			echo "<td> <button class='btn btn-danger btn-alert' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."'>Hapus</button></td>";

} 

else {

			echo "<td> <button class='btn btn-danger btn-hapus' data-id='".$data1['id']."' data-pelanggan='".$data1['nama_pelanggan']."' data-faktur='".$data1['no_faktur']."' kode_meja='".$data1['kode_meja']."'>Hapus</button></td>";
}




		}




if ($data1['status'] == 'Lunas') {

	echo'<td>

				<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="width:150px"> Cetak Penjualan <span class="caret"></span></button>
				
				<ul class="dropdown-menu">
				<li><a href="cetak_lap_penjualan_tunai.php?no_faktur='.$data1["no_faktur"].'" target="blank"> Cetak Penjualan </a></li> 
				<li><a href="cetak_lap_penjualan_tunai_besar.php?no_faktur='.$data1["no_faktur"].'" target="blank"> Cetak Penjualan Besar </a></li>
				</ul>
				</div>
		 </td>';
}

else{

	echo "<td> </td>";
}



if ($data1['status'] == 'Piutang') {
	echo "<td> <a href='cetak_lap_penjualan_piutang.php?no_faktur=".$data1['no_faktur']."' id='cetak_piutang' class='btn btn-warning' target='blank'>Cetak Piutang</a> </td>";
}

else{

	echo "<td>  </td>";
	
}

			echo "<td> <button class='btn btn-info detail' no_faktur='". $data1['no_faktur'] ."' >Detail</button> </td>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['nama_gudang'] ."</td>";
			

if ($data1['status'] == 'Simpan Sementara') {
	echo "<td> <a href='proses_pesanan_barang.php?no_faktur=".$data1['no_faktur']."&kode_pelanggan=".$data1['kode_pelanggan']."&nama_pelanggan=".$data1['nama_pelanggan']."&nama_gudang=".$data1['nama_gudang']."&kode_gudang=".$data1['kode_gudang']."' class='btn btn-primary'>Bayar</a> </td>";
}

else{

	echo "<td>  </td>";
	
}
			echo "<td>". $data1['kode_pelanggan'] ." - ". $data1['nama_pelanggan'] ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['tanggal_jt'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>
			<td>". $data1['sales'] ."</td>
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
		
		$.post('proses_detail_penjualan.php',{no_faktur:no_faktur},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});
		
		</script>


		<script type="text/javascript">
			$(document).ready(function(){
//fungsi hapus data

		$(document).on('click', '.btn-hapus', function (e) {
		var kode_pelanggan = $(this).attr("data-pelanggan");
		var id = $(this).attr("data-id");
		var no_faktur = $(this).attr("data-faktur");
		var kode_meja = $(this).attr("kode_meja");
		$("#kode_pelanggan").val(kode_pelanggan);
		$("#faktur_hapus").val(no_faktur);
		$("#kode_meja").val(kode_meja);
		$("#modal_hapus").modal('show');
		$("#btn_jadi_hapus").attr("data-id", id);
		
		
		});
		
		$("#btn_jadi_hapus").click(function(){
		
		
		var id = $(this).attr("data-id");
		var no_faktur = $("#faktur_hapus").val();
		var kode_meja = $("#kode_meja").val();
		
		
		$(".tr-id-"+id).remove();
		$("#modal_hapus").modal('hide');
		$.post("hapus_data_penjualan.php",{id:id,no_faktur:no_faktur,kode_meja:kode_meja},function(data){

		
		});
		
		
		});




						$('form').submit(function(){
						
						return false;
						});
});

		</script>

		<script type="text/javascript">
		
		$(".pindah_meja").click(function(){
		var no_faktur = $(this).attr('no_faktur');
		var kode_meja = $(this).attr('kode_meja');
		$("#no_faktur_meja").val(no_faktur);
		$("#meja_lama").val(kode_meja);
		$("#modal_meja_edit").modal('show');
		});

		$("#submit_meja").click(function(){
		var no_faktur = $("#no_faktur_meja").val();
		var kode_meja = $("#meja_lama").val();
		var meja_baru = $("#meja_edit").val();
		
		$.post('proses_pindah_meja.php',{no_faktur:no_faktur,kode_meja:kode_meja,meja_baru:meja_baru},function(info) {
		
		$(".alert").show();
		$("#table-baru").html(info);
		$("#table-baru").load('tabel-penjualan.php');
		setTimeout(tutupmodal, 2000);
        setTimeout(tutupalert, 2000);
		
		
		});
		
		});
		
				$('form').submit(function(){
				
				return false;
				});


     function tutupmodal() {
     $("#modal_meja_edit").modal("hide")
     }
     function tutupalert() {
     $(".alert").hide("fast")
     }
		</script>




		<script type="text/javascript">
			
		$(".void").click(function(){

		var no_faktur = $(this).attr('no_faktur');

		$("#no_faktur_batal").val(no_faktur);
		$("#modal_void").modal('show');

		});

$("#login").click(function(){

		var username = $("#username").val();
		var password = $("#password").val();

		$.post('proses_login_void.php',{username:username,password:password},function(data){

	if (data == "sukses") {

		
		$("#modal_void").modal('show');
		$("#modal_login").hide('fast');
		$("#modal_keterangan").show('fast');
		$(".alert-sukses").show();
		$(".alert-void").hide();
		setTimeout(tutupalert, 2000);

		}
		else{

		$("#modal_login").hide('fast');

			$(".alert-void").show();
			setTimeout(tutupalert, 2000);

			$("#username").val('');
			$("#password").val('');
		$("#modal_login").show('fast');
		}

		





});

		

});


     function tutupmodal() {
     $("#modal_void").modal("hide")
     }
     function tutupalert() {
     $(".alert-sukses").hide("fast")
     $(".alert-void").hide("fast")
     }

		</script>

		<script type="text/javascript">



			$("#batal_penjualan").click(function(){

				var keterangan = $("#keterangan").val();
				var no_faktur = $("#no_faktur_batal").val();
				

				$.post('proses_batal_void.php',{keterangan:keterangan, no_faktur:no_faktur},function(data){

				$("#table-baru").load('tabel-penjualan.php');
				$("#keterangan").val('');
				$("#modal_void").modal('hide');

			});
			});
		</script>


<script type="text/javascript">
	
		$(document).on('click', '.btn-alert', function (e) {
		var no_faktur = $(this).attr("data-faktur");

		$.post('modal_retur_piutang.php',{no_faktur:no_faktur},function(data){


		$("#modal_alert").modal('show');
		$("#modal-alert").html(data);

		});

		
		});

</script>

<!--/Pagination teal-->

<?php 
include 'footer.php';
 ?>