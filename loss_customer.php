<?php include_once 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

/*$tahun = date('Y');
// hitung bulan sebelumnya
$bulan = date('m') - 1;
 if ($bulan == 0)
 {
 	echo $bulan = 12;
 }

$bulan_sekarang = date('m');
$tanggal = date('Y-m-d');
$jam = date('H:i:s');
$tahun_terakhir = substr($tahun, 2);
$waktu = date('Y-m-d H:i:s');


$taked = $db->query("SELECT p.kode_pelanggan,SUM(p.total) AS jumlah,pl.nama_pelanggan FROM penjualan p LEFT JOIN pelanggan pl ON pl.kode_pelanggan = p.kode_pelanggan WHERE MONTH(p.tanggal) = '$bulan' AND MONTH(p.tanggal) != '$bulan_sekarang' GROUP BY p.kode_pelanggan");
while($out_taked = mysqli_fetch_array($taked))
{

}

$tes = $db->query("SELECT * FROM penjualan WHERE MONTH(tanggal) = $bulan GROUP BY kode_pelanggan");
 while($out = mysqli_fetch_array($tes))
 {
  $kode_a = $out['kode_pelanggan'];

	$select = $db->query("SELECT kode_pelanggan FROM penjualan WHERE MONTH(tanggal) = '$bulan_sekarang' AND kode_pelanggan = '$kode_a'");
 	$out1 = mysqli_num_rows($select);
 
	if($out1 == 0)
	{
	   $kode = $kode_a;
	}


}*/


 ?>

<div class="container">
 	
<h4><b>Laporan Loss Customer</b></h4>
<br>

<div class="card card-block">
<span id="perubahan_data">      
<div class="table-responsive">
      <!--tag untuk membuat garis pada tabel-->       
<table id="table_laporan_data" class="table table-bordered table-sm">
    <thead>

		<th style='background-color: #4CAF50; color:white'> Kode Pelanggan </th>
		<th style='background-color: #4CAF50; color:white'> Nama Pelanggan </th>
    <th style='background-color: #4CAF50; color:white'> No Telphone </th>
		<th style='background-color: #4CAF50; color:white'> Total Belanja Bulan Lalu </th>

    </thead>
    

   </table>
  </div>
    <a href='cetak_loss_customer.php' type='submit' target="blank" id="btn-print" class='btn btn-success'><i class="fa fa-print"> Print</i></a>

  <a href='download_loss_customer.php' type='submit' target="blank" id="btn-download" class='btn btn-purple'><i class="fa fa-download"> Download Excel</i></a>
 </span>
</div>

</div>

<!--start ajax datatable-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_laporan_data').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"show_data_laporan_loss_customer.php", // json datasource
            type: "post",  // method  , by default get

            error: function(){  // error handling
              $(".tbody").html("");

             $("#table_laporan_data").append('<tbody class="tbody"><tr><th colspan="3">Tidak Ada Data Yang Ditemukan</th></tr></tbody>');

              $("#table_laporan_data_processing").css("display","none");
              
            }
          }
        } );
      } );
    </script>
<!--end ajax datatable-->



<?php 
include 'footer.php';
 ?>