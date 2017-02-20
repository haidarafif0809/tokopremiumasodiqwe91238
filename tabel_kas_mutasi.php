<?php session_start();


include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$session_id = session_id();

$perintah = $db->query("SELECT km.id, km.no_faktur, km.keterangan, km.ke_akun, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM kas_mutasi km INNER JOIN daftar_akun da ON km.ke_akun = da.kode_daftar_akun");
 
 

//ambil 2 angka terakhir dari tahun sekarang 
$tahun = $db->query("SELECT YEAR(NOW()) as tahun");
$v_tahun = mysqli_fetch_array($tahun);
 $tahun_terakhir = substr($v_tahun['tahun'], 2);
//ambil bulan sekarang
$bulan = $db->query("SELECT MONTH(NOW()) as bulan");
$v_bulan = mysqli_fetch_array($bulan);
$v_bulan['bulan'];


//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($v_bulan['bulan']);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$v_bulan['bulan'];
 }
 else
 {
  $data_bulan_terakhir = $v_bulan['bulan'];

 }
//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM kas_mutasi ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM kas_mutasi ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $v_bulan['bulan']) {
  # code...
$no_faktur = "1/KMT/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur = $nomor."/KMT/".$data_bulan_terakhir."/".$tahun_terakhir;


 }


 ?>

<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Keterangan </th>
			<th style='background-color: #4CAF50; color:white'> Dari Akun </th>
			<th style='background-color: #4CAF50; color:white'> Ke Akun </th>
			<th style='background-color: #4CAF50; color:white'> Jumlah </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> User </th>	

<?php
if ($kas_mutasi['kas_mutasi_hapus'] > 0) {

			echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
}
?>

<?php
if ($kas_mutasi['kas_mutasi_edit'] > 0) {

			echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
}
?>		
			
			
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{


$perintah10 = $db->query("SELECT km.id, km.no_faktur, km.keterangan, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM kas_mutasi km INNER JOIN daftar_akun da ON km.dari_akun = da.kode_daftar_akun WHERE km.dari_akun = '$data1[dari_akun]'");
$data = mysqli_fetch_array($perintah10);
$dari_akun = $data['nama_daftar_akun'];
				//menampilkan data
			echo 
			"<tr class='tr-id-".$data1['id']."'>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['keterangan'] ."</td>
			<td>". $dari_akun ."</td>
			<td>". $data1['nama_daftar_akun'] ."</td>
			<td>". rp($data1['jumlah']) ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>";
			
if ($kas_mutasi['kas_mutasi_hapus'] > 0) {

		
			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-faktur='". $data1['no_faktur'] ."'> <span class='glyphicon glyphicon-trash'></span> Hapus </button> </td>";
		}


if ($kas_mutasi['kas_mutasi_edit'] > 0) {

			echo "<td> <button class='btn btn-info btn-edit' data-jumlah='". $data1['jumlah'] ."' data-ket='". $data1['keterangan'] ."' data-id='". $data1['id'] ."' data-dari-akun='". $data1['dari_akun'] ."' data-ke-akun='". $data1['ke_akun'] ."' data-jumlah='". $data1['jumlah'] ."' data-tanggal='". $data1['tanggal'] ."' data-faktur='". $data1['no_faktur'] ."'> <span class='glyphicon glyphicon-edit'></span> Edit </button> </td>
			</tr>";
			}
		}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>
		</tbody>

	</table>

	<script>

// untk menampilkan datatable atau filter seacrh
$(document).ready(function(){
    $('#tableuser').DataTable();
});

</script>


<script type="text/javascript">
$(document).ready(function(){
			
//fungsi hapus data 
		$(".btn-hapus").click(function(){
		
		var id = $(this).attr("data-id");
		var no_faktur = $(this).attr("data-faktur");

		$("#hapus_no_faktur").val(no_faktur);
		$("#modal_hapus").modal('show');
		$("#btn_jadi_hapus").attr("data-id", id);
		
		
		});
		
		$("#btn_jadi_hapus").click(function(){
		
		
		var id = $(this).attr("data-id");
		var no_faktur = $("#hapus_no_faktur").val();

		$.post("hapus_kas_mutasi.php",{id:id, no_faktur:no_faktur},function(data){
		if (data != "") {

		
		$("#tabel_baru").html(data);
		$("#modal_hapus").modal('hide');
		$(".tr-id-"+id).remove();
		
		}
		
		});
		});


//fungsi edit data 
		$(".btn-edit").click(function(){
		
		$("#modal_edit").modal('show');
		var nama = $(this).attr("data-satuan"); 
		var keterangan = $(this).attr("data-ket");
		var tanggal = $(this).attr("data-tanggal");
		var jumlah = $(this).attr("data-jumlah"); 
		var ke_akun = $(this).attr("data-ke-akun"); 
		var dari_akun = $(this).attr("data-dari-akun"); 
		var id  = $(this).attr("data-id");
		var no_faktur  = $(this).attr("data-faktur");
		$("#nama_edit").val(nama);
		$("#tanggal_edit").val(tanggal);
		$("#edit_jumlah_lama").val(jumlah);
		$("#edit_keterangan").val(keterangan);
		$("#edit_ke_akun").val(ke_akun);
		$("#edit_dari_akun").val(dari_akun);
		$("#id_edit").val(id);
		$("#faktur_edit").val(no_faktur);
		
		
		});
		
		$("#submit_edit").click(function(){

		var jumlah_baru = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#edit_jumlah").val()))));
		var tanggal = $("#tanggal_edit").val();
		var jumlah = $("#edit_jumlah_lama").val();
		var ke_akun = $("#edit_ke_akun").val();
		var dari_akun = $("#edit_dari_akun").val();
		var keterangan = $("#edit_keterangan").val();
		var id = $("#id_edit").val();
		var no_faktur = $("#faktur_edit").val();

		$.post("update_kas_mutasi.php",{no_faktur:no_faktur,tanggal:tanggal,jumlah_baru:jumlah_baru,jumlah:jumlah,ke_akun:ke_akun,dari_akun:dari_akun,keterangan:keterangan,id:id},function(data){

		
		if (data == "sukses") {

		$(".alert").show('fast');
		$("#tabel_baru").load('tabel_kas_mutasi.php');
		setTimeout(tutupalert, 2000);
		$(".modal").modal("hide");
		
		}
		});

		});
		


//end function edit data


		$('form').submit(function(){
		
		return false;
		});
		
		});
		
		
		
		
		function tutupalert() {
		$(".alert").hide("fast");

		}
		

</script>

<?php 
include 'footer.php';
 ?>