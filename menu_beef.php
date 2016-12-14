<?php include 'session_login.php';

	// memasukan file login, header, navbar, dan db.
    include 'header.php';
    include 'navbar.php';
    include 'sanitasi.php';
    include 'db.php';


    $perintah = $db->query("SELECT * FROM barang WHERE kategori = 'Beef' ORDER BY id DESC");



    ?>


<div class="container">
<h3><b><u> Data Item </u></b></h3> <br>

<ul class="nav nav-tabs">
  <li><a href="barang.php">Semua Item</a></li>
  <li><a href="menu_makanan.php">Menu Makanan</a></li>
  <li><a href="menu_minuman.php">Menu Minuman</a></li>
  <li class="active"><a href="menu_beef.php">Menu Beef</a></li>
  <li><a href="bahan.php">Bahan - Bahan</a></li>
</ul>
<br><br>

<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"> </span> Tambah Item
</button> <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#my_Modal"><span class="glyphicon glyphicon-import"> </span> Import Data Excell
</button>
<br>
<br>


    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Tambah Barang</h3>
                </div>
                <div class="modal-body">

                    <form enctype="multipart/form-data" role="form" action="prosesbarang.php" method="post">

                        <div class="form-group">
                            <label> Kode Barang </label>
                            <br>
                            <input type="text" placeholder="Kode Barang" name="kode_barang" id="kode_barang" class="form-control" autocomplete="off" required="">
                        </div>



                        <div class="form-group">
                            <label>Nama Barang </label>
                            <br>
                            <input type="text" placeholder="Nama Barang" name="nama_barang" id="nama_barang" class="form-control" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <label> Harga Beli </label>
                            <br>
                            <input type="text" placeholder="Harga Beli" name="harga_beli" id="harga_beli" class="form-control" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <label> Harga Jual </label>
                            <br>
                            <input type="text" placeholder="Harga Jual" name="harga_jual" id="harga_jual" class="form-control" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <label> Satuan </label>
                            <br>
                            <select type="text" name="satuan" class="form-control" required="">
					
                            <?php 
                            
                            // memasukan file db.php
                            include 'db.php';
                            
                            // menampilkan seluruh data yang ada di tabel satuan
                            $query = $db->query("SELECT * FROM satuan ");
                            
                            // menyimpan data sementara yang ada pada $query
                            while($data = mysqli_fetch_array($query))
                            {
                            
                            echo "<option>".$data['nama'] ."</option>";
                            }
                            
                            
                            ?>
                            </select>
                            </div>

                            <div class="form-group">
                            <label> Kategori </label>
                            <br>
                            <select type="text" name="kategori" class="form-control" required="">
                            <option value="Minuman"> Minuman </option>
                            </select>
                            </div>

                            
                            <!-- label STATUS & SUPLIER berada pada satu form group -->
                            <div class="form-group">
                            <label> Status </label>
                            <br>
                            <select type="text" name="status" class="form-control" required="">
                            <option value=""> -- SILAHKAN PILIH -- </option>
                            <option> Aktif </option>
                            <option> Tidak Aktif</option>
                            </select>
                            </div>
                            <div class="form-group">
                            <label> Suplier </label>
                            <br>
                            <select type="text" name="suplier" class="form-control">
                            <option>Umum</option>
                            
                            <?php 
                            include 'db.php';
                            
                            // menampilkan data yang ada pada tabel suplier
                            $query = $db->query("SELECT * FROM suplier ");
                            
                            // menyimpan data sementara yang ada pada $query
                            while($data = mysqli_fetch_array($query))
                            {
                            
                            echo "<option>".$data['nama'] ."</option>";
                            }
                            
                            
                            ?>
                            </select>
                            </div>

                            
                            
                            
                            

                       


<!-- membuat tombol submit -->
<button type="submit" name="submit" value="submit" class="btn btn-info">Tambah</button>
</form>
</div>


<!--button penutup-->
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>


</div>

</div>
</div>


<div id="my_Modal" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Import Data Excell</h4>
      </div>

      <div class="modal-body">
   
   
   <form enctype="multipart/form-data" action="proses_import.php?" method="post" >
    <div class="form-group">
        <label> Import Data Excell</label>
        <input type="file" id="file_import" name="import_excell" required=""> 
        <br>
        <br>

        <!-- membuat tombol submit -->
        
         
    </div>
   <button type="submit" name="submit" value="submit" class="btn btn-info">Import</button>
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

    <div class="modal-footer">

    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

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
        <h4 class="modal-title">Konfirmasi Hapus Data Barang</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
        <label> Nama Barang :</label>
        <input type="text" id="data_barang" class="form-control" autocomplete="off" readonly=""> 
        <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->


<!-- membuat table dan garis tabel-->
<div class="table-responsive">
<span id="table_baru">
    <table id="tableuser" class="table table-bordered">

        <!-- membuat nama kolom tabel -->
        <thead>

            <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Harga Beli </th>
            <th> Harga Jual </th>
            <th> Satuan </th>
            <th> Kategori </th>
            <th> Status </th>
            <th> Suplier </th>
            <th> Foto </th>
            
     

			<?php 
					// logika yang digunakan hanya untuk admin
					if ($_SESSION['otoritas'] == 'Pimpinan')
						{


						echo "<th> Hapus </th>
								<th> Edit </th>";

						}
			 ?>
			
		   </thead>

        <tbody>
			
		<?php
	// menyimpan data sementara yang ada di $perintah
    while ($data1 = mysqli_fetch_array($perintah))
    {
        // menampilkan file yang ada di masing-masing data dibawah ini
        echo "<tr>
			<td>". $data1['kode_barang'] ."</td>
			<td>". $data1['nama_barang'] ."</td>
			<td>". rp($data1['harga_beli']) ."</td>
			<td>". rp($data1['harga_jual']) ."</td>



			<td>". $data1['satuan'] ."</td>
            <td>". $data1['kategori'] ."</td>
			<td>". $data1['status'] ."</td>
			<td>". $data1['suplier'] ."</td>";

            if ($data1['foto'] == "" ){


                echo "<td><a href='unggah_foto.php?id=". $data1['id']."' class='btn btn-primary'><span class='glyphicon glyphicon-upload'></span> Unggah Foto</a> </td>";
            }

            else{

                echo "<td><img src='save_picture/". $data1['foto'] ."' height='30px' width='60px' > <br><br> <a href='unggah_foto.php?id=". $data1['id']."' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-upload'></span> Edit Foto</a> </td>";

            }
            
                     

            if ($_SESSION['otoritas'] == 'Pimpinan')        

            {
         
            echo "
			<td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."'  data-nama='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>
            <td> <a href='editbarang.php?id=". $data1['id']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit</a> </td>
            </tr>";

            }
            else{

                echo "<td> </td>";

            }


         
        }
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

    ?>
		</tbody>

	</table>
</span>



 

</div> <!-- penutup table responsive -->

</div><!-- penutup tag div clas="container" -->


<script>
// untuk memunculkan data tabel 
$(document).ready(function() {
        $('#tableuser').DataTable({"ordering":false});
    });

</script>


<script type="text/javascript">

               $(document).ready(function(){
               $("#kode_barang").blur(function(){
               var kode_barang = $("#kode_barang").val();

              $.post('cek_kode_barang.php',{kode_barang:$(this).val()}, function(data){
                
                if(data == 1){

                    alert ("Kode Barang Sudah Ada");
                    $("#kode_barang").val('');
                }
                else {
                    
                }
              });
                
               });
               });

</script>

                             

                             <script type="text/javascript">
                                 
//fungsi hapus data 
                                $(".btn-hapus").click(function(){
                                var nama = $(this).attr("data-nama");
                                var id = $(this).attr("data-id");
                                $("#data_barang").val(nama);
                                $("#id_hapus").val(id);
                                $("#modal_hapus").modal('show');
                                
                                
                                });
                                
                                
                                $("#btn_jadi_hapus").click(function(){
                                
                                var id = $("#id_hapus").val();
                                
                                $.post("hapusbarang.php",{id:id},function(data){
                                if (data != "") {
                                $("#table_baru").load('tabel-barang.php');
                                $("#modal_hapus").modal('hide');
                                
                                }
                                
                                
                                });
                                
                                });
                        // end fungsi hapus data



                             </script>



<?php  include 'footer.php'; ?>