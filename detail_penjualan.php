<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 $no_faktur = $_GET['no_faktur'];

 $query = $db->query ("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'" );

 ?>


<div class="container">
<h3> Detail Penjualan </h3>
<br>
<br>


        
<table id="tableuser" class="table table-bordered">
		<thead>
			<th> Nomor Faktur </th>
			<th> Kode Barang </th>
			<th> Nama Barang </th>
			<th> Jumlah Barang </th>
			<th> Satuan </th>
			<th> Harga </th>
			<th> Subtotal </th>
			<th> Potongan </th>
			<th> Tax </th>
      <?php 
             if ($_SESSION['otoritas'] == 'Pimpinan')
             {
             
             
             echo "<th> Hpp </th>";
             }
      ?>

			<th> Sisa Barang </th>
			
			
			<th> Hapus </th>
			
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($query))
			{
				//menampilkan data
			echo "<tr>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['kode_barang'] ."</td>
			<td>". $data1['nama_barang'] ."</td>
			<td>". $data1['jumlah_barang'] ."</td>
			<td>". $data1['satuan'] ."</td>
			<td>". rp($data1['harga']) ."</td>
			<td>". rp($data1['subtotal']) ."</td>
			<td>". rp($data1['potongan']) ."</td>
			<td>". rp($data1['tax']) ."</td>";

        if ($_SESSION['otoritas'] == 'Pimpinan'){

                echo "<td>". rp($data1['hpp']) ."</td>";
        }

      			
			echo "<td>". $data1['sisa'] ."</td>



			
			<td> <a href='hapus_detail_penjulan.php?id=". $data1['id']."' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span> Hapus </a> </td> 
			
			</tr>";
			}

			//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
		?>
		</tbody>

	</table>


</div><!--end of container-->

<script>

// untk menampilkan datatable atau filter seacrh
$(document).ready(function(){
    $('#tableuser').DataTable();
});

</script>

<?php 
include 'footer.php';
 ?>