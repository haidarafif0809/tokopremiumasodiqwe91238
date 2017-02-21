<?php session_start();


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

<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->

<table id="tableuser" class="table table-bordered">
		<thead>

		
			
<?php 
include 'db.php';

$pilih_akses_penjualan_edit = $db->query("SELECT penjualan_edit FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_edit = '1'");
$penjualan_edit = mysqli_num_rows($pilih_akses_penjualan_edit);


    if ($penjualan_edit > 0){
				echo "<th> Edit </th>";
			}
				
?>



<?php 
include 'db.php';

$pilih_akses_penjualan_hapus = $db->query("SELECT penjualan_hapus FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_hapus = '1'");
$penjualan_hapus = mysqli_num_rows($pilih_akses_penjualan_hapus);


    if ($penjualan_hapus > 0){

			echo "<th> Hapus </th>";

		}
?>
			<th> Cetak  Tunai </th>
			<th> Cetak Piutang </th>
			<th> Detail </th>
			<th> Nomor Faktur </th>
			<th> Gudang </th>
			<th> Bayar </th>
			<th> Kode Pelanggan</th>
			<th> Total </th>
			<th> Tanggal </th>
			<th> Tanggal Jt </th>
			<th> Jam </th>
			<th> Petugas Kasir </th>
			<th> Sales </th>
			<th> Status </th>
			<th> Potongan </th>
			<th> Tax </th>
			<th> Kembalian </th>
			<th> Kredit </th>
			
			

			
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

			echo "<tr class='tr-id-".$data1['id']."'> <td> <a href='proses_edit_penjualan.php?no_faktur=". $data1['no_faktur']."&kode_pelanggan=". $data1['kode_pelanggan']."&nama_gudang=".$data1['nama_gudang']."&kode_gudang=".$data1['kode_gudang']."' class='btn btn-success'><i class='fa fa-edit'>Edit</i></a> </td>";	


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

			echo "<td> <button class='btn btn-danger btn-alert' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."'><i class='fa fa-trash-o'>Hapus</i></button></td>";

} 

else {

			echo "<td> <button class='btn btn-danger btn-hapus' data-id='".$data1['id']."' data-pelanggan='".$data1['nama_pelanggan']."' data-faktur='".$data1['no_faktur']."' kode_meja='".$data1['kode_meja']."'><i class='fa fa-trash-o'>Hapus</i></button></td>";
}




		}




if ($data1['status'] == 'Lunas') {

	echo'<td>
				<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="width:150px"><i class="fa fa-print">Cetak Penjualan</i> <span class="caret"></span></button>
				
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
	echo "<td> <a href='cetak_lap_penjualan_piutang.php?no_faktur=".$data1['no_faktur']."' id='cetak_piutang' class='btn btn-warning' target='blank'><i class='fa fa-print'>Cetak Piutang</i></a> </td>";
}

else{

	echo "<td>  </td>";
	
}

			echo "<td> <button class='btn btn-info detail' no_faktur='". $data1['no_faktur'] ."' ><i class='fa fa-list-ol'>Detail</i></button> </td>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['nama_gudang'] ."</td>";
			

if ($data1['status'] == 'Simpan Sementara') {
	echo "<td> <a href='proses_pesanan_barang.php?no_faktur=".$data1['no_faktur']."&kode_pelanggan=".$data1['kode_pelanggan']."&nama_pelanggan=".$data1['nama_pelanggan']."&nama_gudang=".$data1['nama_gudang']."&kode_gudang=".$data1['kode_gudang']."' class='btn btn-primary'><i class='fa fa-dollar'>Bayar</i></a> </td>";
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
</div>

<button type="submit" id="submit_close" class="glyphicon glyphicon-remove btn btn-danger" style="display:none"></button> 
		<span id="demo"> </span>
		

<!--menampilkan detail penjualan-->
		<script>
		
		$(document).ready(function(){
		$('.table').DataTable(
			{"ordering": false});
		});
		</script>

		 <script>
   //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
  $("#submit_produk").click(function(){

    var jumlah_barang = $("#jumlah_barang").val();
    var jumlahbarang = $("#jumlahbarang").val();
    var kode_pelanggan = $("#kd_pelanggan").val();
    

if (jumlah_barang == ""){
  alert("Jumlah Barang Harus Diisi");
}
else if (kode_pelanggan == ""){
alert("Kode Pelanggan Harus Dipilih");
  }

else{
	
 $.post($("#formtambahproduk").attr("action"), $("#formtambahproduk :input").serializeArray(), function(info) {


     $("#table-baru").html(info);
     $("#table-baru").load("tabel_penjualan.php");
     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');
     
     });
}
      $("#formtambahproduk").submit(function(){
    return false;

});
      
  });

$("#submit_produk").mouseleave(function(){

            var kode_pelanggan = $("#kd_pelanggan").val();

            
            if (kode_pelanggan != ""){
            $("#kd_pelanggan").attr("disabled", true);
            }
            
            
            var no_faktur = $("#nomor_faktur_penjualan").val();
            
            $.post("cek_total_penjualan.php",
            {
            no_faktur: no_faktur
            },
            function(data){
            $("#total_penjualan"). val(data);
            $("#total_penjualan1"). val(data);
            });


            
            $.post("cek_total_hpp.php",
            {
            no_faktur: no_faktur
            },
            function(data){
            $("#total_hpp"). val(data);
            });
            
            });


//menampilkan no urut faktur setelah tombol click di pilih
      $("#cari_produk_penjualan").click(function() {
      
      
      
      
      
      $.get('no_faktur_jl.php', function(data) {
      /*optional stuff to do after getScript */ 
      $("#nomor_faktur_penjualan").val(data);
      });
      //menyembunyikan notif berhasil
      $("#alert_berhasil").hide();
      
      var kode_pelanggan = $("#kd_pelanggan").val();
      //coding update jumlah barang baru "rabu,(9-3-2016)"
      $.post('modal_jual_baru.php',{kode_pelanggan:kode_pelanggan},function(data) {
      
      $(".modal_baru").html(data);
      
      
      });
      /* Act on the event */
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
			
//fungsi hapus data 
		$(document).on('click', '.btn-hapus', function (e) {
		var kode_pelanggan = $(this).attr("data-pelanggan");
		var id = $(this).attr("data-id");
		var no_faktur = $(this).attr("data-faktur");
		$("#kode_pelanggan").val(kode_pelanggan);
		$("#id_hapus").val(id);
		$("#faktur_hapus").val(no_faktur);
		$("#modal_hapus").modal('show');
		
		
		});
		
		$("#btn_jadi_hapus").click(function(){
		
		var id = $("#id_hapus").val();
		var no_faktur = $("#faktur_hapus").val();
		$.post("hapus_data_penjualan.php",{id:id,no_faktur:no_faktur},function(data){
		if (data == 'sukses') {
		$("#table-baru").load('tabel-penjualan.php');
		$("#modal_hapus").modal('hide');
		
		}
		
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
