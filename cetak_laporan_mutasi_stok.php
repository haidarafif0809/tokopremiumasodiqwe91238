<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);



$barang = $db->query("SELECT nama_barang, kode_barang, satuan FROM barang");


    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

 ?>




<style type="text/css">
/*unTUK mengatur ukuran font*/
   .satu {
   font-size: 15px;
   font: verdana;
   }
</style>

<style type="text/css">
  th,td{
    padding: 1px;
  }


.table1, .th, .td {
    border: 1px solid black;
    font-size: 15px;
    font: verdana;
}


</style>


<div class="container">

     <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h4> <b> LAPORAN MUTASI STOK  </b></h4>
                 <hr>
                 <h5> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h5> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-4">
         <br><br>                 
<table>
  <tbody>

      <tr><td  width="20%">PERIODE</td> <td> &nbsp;:&nbsp; </td> <td> <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?></td>
      </tr>
            
  </tbody>
</table>           
                 
        </div><!--penutup colsm4-->


        
    </div><!--penutup row1-->






 <table id="tableuser" class="table1">
         <thead>
			
			<th class="table1" style="text-align: center; width: 5%"> Kode Item </th>
			<th class="table1" style="text-align: center; width: 5%"> Nama Item </th>
			<th class="table1" style="text-align: center; width: 5%"> Satuan </th>
			<th class="table1" style="text-align: center; width: 5%"> Awal </th>
			<th class="table1" style="text-align: center; width: 5%"> Nilai Awal </th>
			<th class="table1" style="text-align: center; width: 5%"> Masuk </th>
			<th class="table1" style="text-align: center; width: 5%"> Nilai Masuk </th>
			<th class="table1" style="text-align: center; width: 5%"> Keluar </th>
			<th class="table1" style="text-align: center; width: 5%"> Nilai Keluar </th>
			<th class="table1" style="text-align: center; width: 5%"> Akhir </th>
			<th class="table1" style="text-align: center; width: 5%"> Nilai Akhir </th>
			
		</thead>
		
		<tbody>
		<?php

			$total_awal = 0;
			$total_nilai_awal = 0;
			$total_masuk = 0;
			$total_nilai_masuk = 0;
			$total_keluar = 0;
			$total_nilai_keluar = 0;
			$total_akhir = 0;
			$total_nilai_akhir = 0;
			//menyimpan data sementara yang ada pada $perintah
			while ($data_barang = mysqli_fetch_array($barang))

			{

			$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE kode_barang = '$data_barang[kode_barang]' AND tanggal <'$dari_tanggal'");
			$cek_awal_masuk = mysqli_fetch_array($hpp_masuk);

			$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE kode_barang = '$data_barang[kode_barang]' AND tanggal <'$dari_tanggal'");
			$cek_awal_keluar = mysqli_fetch_array($hpp_keluar);

			$awal = $cek_awal_masuk['jumlah_kuantitas'] - $cek_awal_keluar['jumlah_kuantitas'];
			$nilai_awal = $cek_awal_masuk['total_hpp'] - $cek_awal_keluar['total_hpp'];

			$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE kode_barang = '$data_barang[kode_barang]' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
			$cek_hpp_masuk = mysqli_fetch_array($hpp_masuk);

			$masuk = $cek_hpp_masuk['jumlah_kuantitas'];
			$nilai_masuk = $cek_hpp_masuk['total_hpp'];

			$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE kode_barang = '$data_barang[kode_barang]' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
			$cek_hpp_keluar = mysqli_fetch_array($hpp_keluar);

			$keluar = $cek_hpp_keluar['jumlah_kuantitas'];
			$nilai_keluar = $cek_hpp_keluar['total_hpp'];

			$akhir = $masuk - $keluar;
			$nilai_akhir = $nilai_masuk - $nilai_keluar;


			$total_awal = $total_awal + $awal;
			$total_nilai_awal = $total_nilai_awal + $nilai_awal;

			$total_masuk = $total_masuk + $masuk;
			$total_nilai_masuk = $total_nilai_masuk + $nilai_masuk;

			$total_keluar = $total_keluar + $keluar;
			$total_nilai_keluar = $total_nilai_keluar + $nilai_keluar;

			$total_akhir = $total_akhir + $akhir;
			$total_nilai_akhir = $total_nilai_akhir + $nilai_akhir;
			

		//menampilkan data
			echo "<tr>
			<td class='table1' style='text-align: left'>". $data_barang['kode_barang'] ."</td>
			<td class='table1' style='text-align: left'>". $data_barang['nama_barang'] ."</td>
			<td class='table1' style='text-align: center'>". $data_barang['satuan'] ."</td>
			<td class='table1' style='text-align: right'>".rp($awal)."</td>
			<td class='table1' style='text-align: right'>".rp($nilai_awal)."</td>
			<td class='table1' style='text-align: right'>".rp($masuk)."</td>
			<td class='table1' style='text-align: right'>".rp($nilai_masuk)."</td>
			<td class='table1' style='text-align: right'>".rp($keluar)."</td>
			<td class='table1' style='text-align: right'>".rp($nilai_keluar)."</td>
			<td class='table1' style='text-align: right'>".rp($akhir)."</td>
			<td class='table1' style='text-align: right'>".rp($nilai_akhir)."</td>
			</tr>";
			}

			echo "<tr style='background-color: grey; color:white'>
			<td class='table1' style='text-align: left'> </td>
			<td class='table1' style='text-align: left'> </td>
			<td class='table1' style='text-align: center'>Total :</td>
			<td class='table1' style='text-align: right'>".rp($total_awal)."</td>
			<td class='table1' style='text-align: right'>".rp($total_nilai_awal)."</td>
			<td class='table1' style='text-align: right'>".rp($total_masuk)."</td>
			<td class='table1' style='text-align: right'>".rp($total_nilai_masuk)."</td>
			<td class='table1' style='text-align: right'>".rp($total_keluar)."</td>
			<td class='table1' style='text-align: right'>".rp($total_nilai_keluar)."</td>
			<td class='table1' style='text-align: right'>".rp($total_akhir)."</td>
			<td class='table1' style='text-align: right'>".rp($total_nilai_akhir)."</td>
			</tr>";



			//Untuk Memutuskan Koneksi Ke Database
			mysqli_close($db);   

		?>
		</tbody>

	</table>
	<hr>


</div> <!--/container-->


 <script>
$(document).ready(function(){
  window.print();
});
</script>



<?php include 'footer.php'; ?>