<?php session_start();

    // memasukan file login, header, navbar, dan db.
    include 'session_login.php';
    include 'sanitasi.php';
    include 'db.php';
$session_id = session_id();

    $perintah = $db->query("SELECT * FROM meja ORDER BY id DESC");



    ?>

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

	<script>
// untuk memunculkan data tabel 
$(document).ready(function() {
        $('.table').DataTable({'ordering':false});
    });

</script>
 								<script type="text/javascript">
                                 
                                $(".btn-hapus").click(function(){
                                var nama = $(this).attr("data-nama");
                                var id = $(this).attr("data-id");
                                $("#data_meja").val(nama);
                                $("#id_hapus").val(id);
                                $("#modal_hapus").modal('show');
                                
                                
                                });
                                $(".btn-edit").click(function(){
                                
                                $("#modal_edit").modal('show');
                                var nama = $(this).attr("data-meja"); 
                                var id  = $(this).attr("data-id");
                                $("#nama_edit").val(nama);
                                $("#id_edit").val(id);
                                
                                
                                });

                                </script>