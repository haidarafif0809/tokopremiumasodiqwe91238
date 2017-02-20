<?php include 'session_login.php';


// memasukan file session login,  header, navbar, db.php,
include 'db.php';
include 'sanitasi.php';


$no_faktur = $_GET['no_faktur'];

 $query = $db->query("SELECT * FROM barang WHERE kategori = 'Makanan' OR kategori = 'Minuman'");

 ?>


<table id="tableuser" class="table table-bordered" style="width:100%">
				

				<thead>


					<th> Nama Barang </th>
					<th> Jumlah Barang </th>
					<th> Subtotal </th>
					<th> Nomor Pesanan</th>
					<th> Permintaan </th>
					<th> Edit Permintaan </th>
					<th> Edit </th>
					<th> Hapus </th>

				</thead>
				<tbody>
				<?php
				
				// menampilkan seluruh data yang ada pada tabel barang
				$perintah = "SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur' ORDER BY id DESC";
				$perintah1 = $db->query($perintah);
				
				// menyimpoan data sementara yang ada pada $perintah1
				while ($data1 = mysqli_fetch_array($perintah1))
				{
				// menampilkan data
						echo "<tr>
						<td>". $data1['nama_barang'] ."</td>
						<td>". $data1['jumlah_barang'] ."</td>
						<td>". $data1['subtotal'] ."</td>

						<td>". $data1['no_pesanan'] ."</td>";

					if ($data1['komentar'] == '') {
             echo "<td> <button class='btn btn-primary btn-komen' data-id='".$data1['id']."' data-komen='".$data1['komentar']."'><span class='glyphicon glyphicon-pencil'> </span> Add Comment </button> </td>";
           }

             else {

             echo "<td>". $data1['komentar'] ."</td>";
           }

           if ($data1['komentar'] != '') {
              echo "<td> <button class='btn btn-primary btn-komen' data-id='".$data1['id']."' data-komen='".$data1['komentar']."'><span class='glyphicon glyphicon-edit'> </span> Edit Comment </button> </td>";

           }
           else{
            echo "<td> </td>";
           }

				echo "<td> <button class='btn btn-success btn-edit-tbs' data-id='". $data1['id'] ."' data-jumlah-barang='". $data1['jumlah_barang'] ."' data-kode='". $data1['kode_barang'] ."' data-harga='". $data1['harga'] ."'  kode-pesanan='". $data1['no_pesanan'] ."'><span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>

						<td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-pesanan='". $data1['nama_barang'] ."' kode-data='". $data1['kode_barang'] ."' kode-pesanan='". $data1['no_pesanan'] ."'> Hapus </button> </td> 
				</tr>";
				
				}

					//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
				
				?>

				</tbody>
				</table>


		<script>
		
		$(document).ready(function(){
		$('.table').DataTable();
		});
		</script>

	 <script type="text/javascript">
                             
								$(document).ready(function(){

					//fungsi hapus data 
                $(".btn-hapus").click(function(){
                var nama_barang = $(this).attr("data-pesanan");
                var id = $(this).attr("data-id");
                var kode_barang = $(this).attr("kode-data");
                var no_pesanan = $(this).attr("kode-pesanan");

                $("#data_pesanan").val(nama_barang);
                $("#kode_pesanan_hapus").val(no_pesanan);
                $("#id_hapus").val(id);
                $("#kode_hapus").val(kode_barang);
                $("#modal_hapus").modal('show');
                
                
                });
								// end fungsi hapus data
								
								//fungsi edit data 
          $(".btn-edit-tbs").click(function(){
          
          $("#modal_edit").modal('show');
          var jumlah_barang = $(this).attr("data-jumlah-barang");
          var harga = $(this).attr("data-harga");
          var id  = $(this).attr("data-id");
          var kode_barang = $(this).attr("data-kode");
          var no_pesanan = $(this).attr("kode-pesanan");
          $("#harga_edit").val(harga);
          $("#no_pesanan_edit").val(no_pesanan);
          $("#barang_lama").val(jumlah_barang);
          $("#id_edit").val(id);
          $("#kode_edit").val(kode_barang);
          
          
          });

								});

                             </script>


                             <script type="text/javascript">
                                                         
                                                         $(".btn-komen").click(function(){
                                                         var komentar = $(this).attr("data-komen");
                                                         var id = $(this).attr("data-id");
                                                         
                                                         $("#kolom_komen").val(komentar);
                                                         $("#id_komen").val(id);
                                                         $("#modal_komen").modal('show');
                                                         
                                                         
                                                         });

                             </script>