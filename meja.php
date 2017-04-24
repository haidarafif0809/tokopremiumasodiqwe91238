<?php include 'session_login.php';

	// memasukan file login, header, navbar, dan db.
    include 'header.php';
    include 'navbar.php';
    include 'sanitasi.php';
    include 'db.php';


    $perintah = $db->query("SELECT * FROM meja ORDER BY id DESC");



    ?>


<div class="container">
<h3><b><u> Data Meja </u></b></h3> <br>

<?php
include 'db.php';

$pilih_akses_meja = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Tambah' AND akses = 'Meja'");
$meja = mysqli_num_rows($pilih_akses_meja);

    if ($meja > 0) {

echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"> </span> Tambah Meja </button>';
}
?>

<br>
<br>


    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Tambah Meja</h3>
                </div>
                <div class="modal-body">

                    <form enctype="multipart/form-data" role="form" action="proses_meja.php" method="post">

                        <div class="form-group">
                            <label> Kode Meja </label>
                            <br>
                            <input type="text" placeholder="Kode Meja" name="kode_meja" id="kode_meja" class="form-control" autocomplete="off" required="">
                        </div>



                        <div class="form-group">
                            <label>Nama Meja </label>
                            <br>
                            <input type="text" placeholder="Nama Meja" name="nama_meja" id="nama_meja" class="form-control" autocomplete="off" required="">
                        </div>
                       


<!-- membuat tombol submit -->
<button type="submit" name="submit" id="submit_tambah" value="submit" class="btn btn-info">Tambah</button>
</form>
</div>


<!--button penutup-->
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
        <h4 class="modal-title">Konfirmasi Hapus Data Meja</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
        <label> Nama Meja :</label>
        <input type="text" id="data_meja" class="form-control" autocomplete="off" readonly=""> 
        <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->


<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Meja</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Nama Meja :</label>
     <input type="text" class="form-control" id="nama_edit" autocomplete="off">
     <input type="hidden" class="form-control" id="id_edit">
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-default">Submit</button>
  </form>

 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->


<!-- membuat table dan garis tabel-->
<div class="table-responsive">
<span id="table_baru">
    <table id="tableuser" class="table table-bordered">

        <!-- membuat nama kolom tabel -->
        <thead>

            <th> Kode meja </th>
            <th> Nama meja </th>
            <th> Status </th>

<?php
include 'db.php';

$pilih_akses_meja_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Meja'");
$meja_hapus = mysqli_num_rows($pilih_akses_meja_hapus);

    if ($meja_hapus > 0) {
           echo "<th> Hapus </th>";
         }
      ?>


<?php
include 'db.php';

$pilih_akses_meja_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Meja'");
$meja_edit = mysqli_num_rows($pilih_akses_meja_edit);

    if ($meja_edit > 0) {
           echo "<th> Edit </th>";
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
			<td>". $data1['kode_meja'] ."</td>
			<td>". $data1['nama_meja'] ."</td>
			<td>". $data1['status_pakai'] ."</td>";

include 'db.php';

$pilih_akses_meja_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Meja'");
$meja_hapus = mysqli_num_rows($pilih_akses_meja_hapus);

    if ($meja_hapus > 0) {
           echo " <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."'  data-nama='". $data1['nama_meja'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}

include 'db.php';

$pilih_akses_meja_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Meja'");
$meja_edit = mysqli_num_rows($pilih_akses_meja_edit);

    if ($meja_edit > 0) {

           echo " <td><button class='btn btn-success btn-edit' data-meja='". $data1['nama_meja'] ."' data-id='". $data1['id'] ."' > <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>

            </tr>";
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
        $('.table').DataTable({
          'ordering':false
        });
    });

</script>


<script type="text/javascript">

               $(document).ready(function(){
               $("#kode_meja").blur(function(){
               var kode_meja = $("#kode_meja").val();

              $.post('cek_kode_meja.php',{kode_meja:$(this).val()}, function(data){
                
                if(data == 1){

                    alert ("Kode Meja Sudah Ada");
                    $("#kode_meja").val('');
                }
                else {
                    
                }
              });
                
               });
               });

</script>

                             

                             <script type="text/javascript">


                                 $("#submit_tambah").click(function(){
                                 var kode_meja = $("#kode_meja").val();
                                 var nama_meja = $("#nama_meja").val();
                                 
                                 if (kode_meja == "") {
                                  alert("Kode Meja Harus Diisi");
                                 }

                                 else if(nama_meja == ""){
                                  alert("Nama Meja Harus Diisi");
                                 }

                                 else{
                                  $.post('proses_meja.php',{kode_meja:kode_meja,nama_meja:nama_meja},function(data){
                                 
                                 if (data != '') {
                                 $("#kode_meja").val('');
                                 $("#nama_meja").val('');

                                 $("#table_baru").load('tabel-meja.php');
                                 $(".modal").modal("hide");
                                 }
                                 
                                 
                                 });
                                 }
                                 
                         
                                 });
                                 
                                 //fungsi hapus data 
                                $(".btn-hapus").click(function(){
                                var nama = $(this).attr("data-nama");
                                var id = $(this).attr("data-id");
                                $("#data_meja").val(nama);
                                $("#id_hapus").val(id);
                                $("#modal_hapus").modal('show');
                                
                                
                                });
                                
                                
                                $("#btn_jadi_hapus").click(function(){
                                
                                var id = $("#id_hapus").val();
                                
                                $.post("hapusmeja.php",{id:id},function(data){
                                if (data != "") {
                                $("#table_baru").load('tabel-meja.php');
                                $("#modal_hapus").modal('hide');
                                
                                }
                                
                                
                                });
                                
                                });
                                // end fungsi hapus data
                                
                                //fungsi edit data 
                                $(".btn-edit").click(function(){
                                
                                $("#modal_edit").modal('show');
                                var nama = $(this).attr("data-meja"); 
                                var id  = $(this).attr("data-id");
                                $("#nama_edit").val(nama);
                                $("#id_edit").val(id);
                                
                                
                                });
                                
                                $("#submit_edit").click(function(){
                                var nama = $("#nama_edit").val();
                                var id = $("#id_edit").val();
                                
                                $.post("proseseditmeja.php",{id:id,nama_meja:nama},function(data){
                                if (data != "") {
                                $("#table_baru").load('tabel-meja.php');
                                $("#modal_edit").modal('hide');
                                
                                }
                                });
                                });
                                
                                        $('form').submit(function(){
                                        
                                        return false;
                                        });
                                        
                                //end function edit data

                             </script>



<?php  include 'footer.php'; ?>