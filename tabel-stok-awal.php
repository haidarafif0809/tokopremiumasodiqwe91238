<?php session_start();


include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT s.nama AS nama_satuan,sa.id,kode_barang,sa.nama_barang,sa.no_faktur,sa.jumlah_awal,sa.harga,sa.satuan,sa.total,sa.tanggal,sa.jam,sa.user FROM stok_awal sa INNER JOIN satuan s ON sa.satuan = s.id ");




 ?>

<table id="tableuser" class="table table-bordered">
		<thead>
      <th> No Faktur </th>
      <th> Kode Barang </th>
			<th> Nama Barang </th>
			<th> Jumlah </th>
			<th> Satuan </th>
			<th> Harga </th>
			<th> Total </th>
			<th> Tanggal </th>
			<th> Jam </th>
			<th> User </th>

<?php
include 'db.php';

$pilih_akses_persediaan_stok_awal_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Persediaan Stok Awal'");
$persediaan_stok_awal_hapus = mysqli_num_rows($pilih_akses_persediaan_stok_awal_hapus);

    if ($persediaan_stok_awal_hapus > 0) {
    echo "<th> Hapus </th>";
}

?>
			
			
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{
				//menampilkan data
			echo "<tr>
      <td>". $data1['no_faktur'] ."</td>
      <td>". $data1['kode_barang'] ."</td>
			<td>". $data1['nama_barang'] ."</td>
			<td>". $data1['jumlah_awal'] ."</td>
			<td>". $data1['nama_satuan'] ."</td>
			<td>". rp($data1['harga']) ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". tanggal($data1['tanggal']) ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>";

include 'db.php';

$pilih_akses_persediaan_stok_awal_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Persediaan Stok Awal'");
$persediaan_stok_awal_hapus = mysqli_num_rows($pilih_akses_persediaan_stok_awal_hapus);

    if ($persediaan_stok_awal_hapus > 0) {

       $hpp_keluar = $db->query("SELECT * FROM hpp_masuk WHERE no_faktur = 'Stok Awal' AND kode_barang = '$data1[kode_barang]' AND sisa != jumlah_kuantitas");
       $row_hpp = mysqli_num_rows($hpp_keluar);

        if ($row_hpp > 0 ) {
          echo "<td>  <button class='btn btn-danger btn-alert' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-nama-barang='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
        } 

        else {
          echo "<td>  <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-nama-barang='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
        }
        
      }
			

			echo "</tr>";
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
                                  var nama_barang = $(this).attr("data-nama-barang");
                                  var kode_barang = $(this).attr("data-kode-barang");
                                  $("#hapus_barang").val(nama_barang);
                                  $("#kode_hapus").val(kode_barang);
                                  $("#modal_hapus").modal('show');
                                  
                                  
                                  });
                                  
                                  $("#btn_jadi_hapus").click(function(){
                                  
                                  var kode_barang = $("#kode_hapus").val();
                                  $.post("hapus_data_stok_awal.php",{kode_barang:kode_barang},function(data){

                                  if (data != '') {
                                  $("#tabel_baru").load('tabel-stok-awal.php');
                                  $("#modal_hapus").modal('hide');
                                  
                                  
                                  }
                                  });
                                  
                                  
                                  });
                                  });
                                  
                                  //end fungsi hapus data

                             </script>