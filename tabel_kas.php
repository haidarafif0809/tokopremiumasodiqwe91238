<?php session_start();


include 'sanitasi.php';
include 'db.php';


$query = $db->query("SELECT * FROM kas");



 ?>
<table id="tableuser" class="table table-bordered">
        <thead>
            <th> Nama  </th>
            <th> Jumlah </th>
      <th> Default </th>

<?php
include 'db.php';

$pilih_akses_kas_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Kas'");
$kas_hapus = mysqli_num_rows($pilih_akses_kas_hapus);

    if ($kas_hapus > 0) {
      echo "<th> Hapus </th>";
}
?>

<?php
include 'db.php';

$pilih_akses_kas_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Kas'");
$kas_edit = mysqli_num_rows($pilih_akses_kas_edit);

    if ($kas_edit > 0) {
      echo "<th> Edit </th>";
}
?>          

            
            
        </thead>
        
        <tbody>
        <?php

        
            while ($data = mysqli_fetch_array($query))
        {
            echo "<tr>
            <td>". $data['nama'] ."</td>";

            
// MENCARI JUMLAH KAS
            $query0 = $db->query("SELECT SUM(total) AS total_penjualan FROM penjualan WHERE cara_bayar = '$data[nama]'");
            $cek0 = mysqli_fetch_array($query0);
            $total_penjualan = $cek0['total_penjualan'];

            $query0000 = $db->query("SELECT SUM(kredit) AS kredit_penjualan FROM penjualan WHERE cara_bayar = '$data[nama]'");
            $cek0000 = mysqli_fetch_array($query0000);
            $kredit_penjualan = $cek0000['kredit_penjualan'];

            $query2 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_masuk FROM kas_masuk WHERE ke_akun = '$data[nama]'");
            $cek2 = mysqli_fetch_array($query2);
            $jumlah_kas_masuk = $cek2['jumlah_kas_masuk'];

            $query20 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_masuk_mutasi FROM kas_mutasi WHERE ke_akun = '$data[nama]'");
            $cek20 = mysqli_fetch_array($query20);
            $jumlah_kas_masuk_mutasi = $cek20['jumlah_kas_masuk_mutasi'];

            $query200 = $db->query("SELECT SUM(total) AS total_retur_pembelian FROM retur_pembelian WHERE cara_bayar = '$data[nama]'");
            $cek200 = mysqli_fetch_array($query200);
            $total_retur_pembelian = $cek200['total_retur_pembelian'];

//total kas 1

            $kas_1 = $total_penjualan - $kredit_penjualan + $jumlah_kas_masuk + $jumlah_kas_masuk_mutasi + $total_retur_pembelian;




            $query3 = $db->query("SELECT SUM(total) AS total_pembelian FROM pembelian WHERE cara_bayar = '$data[nama]'");
            $cek3 = mysqli_fetch_array($query3);
            $total_pembelian = $cek3['total_pembelian'];

            $query0001 = $db->query("SELECT SUM(kredit) AS kredit_pembelian FROM pembelian WHERE cara_bayar = '$data[nama]'");
            $cek0001 = mysqli_fetch_array($query0001);
            $kredit_pembelian = $cek0001['kredit_pembelian'];


            $query5 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_keluar FROM kas_keluar WHERE dari_akun = '$data[nama]'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_kas_keluar = $cek5['jumlah_kas_keluar'];

            $query5 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_keluar_mutasi FROM kas_mutasi WHERE dari_akun = '$data[nama]'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_kas_keluar_mutasi = $cek5['jumlah_kas_keluar_mutasi'];

            $query5 = $db->query("SELECT SUM(total) AS total_retur_penjualan FROM retur_penjualan WHERE cara_bayar = '$data[nama]'");
            $cek5 = mysqli_fetch_array($query5);
            $total_retur_penjualan = $cek5['total_retur_penjualan'];



//total barang 2
            $kas_2 = $total_pembelian - $kredit_pembelian + $jumlah_kas_keluar + $jumlah_kas_keluar_mutasi + $total_retur_penjualan;







            $jumlah_kas = $kas_1 - $kas_2;



            echo "<td>". rp($jumlah_kas) ."</td>";

      if ($data['status'] == "Ya") {
        
        echo "<td> <span class='glyphicon glyphicon-ok'> </span> </td>";
      }
      else{
         echo "<td> <span class='glyphicon glyphicon-remove'> </span> </td>";
      }
            




if ($jumlah_kas == '0')       

{

  include 'db.php';
  
  $pilih_akses_kas_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Kas'");
  $kas_hapus = mysqli_num_rows($pilih_akses_kas_hapus);

    if ($kas_hapus > 0) {
         
            echo "
            <td> <button class='btn btn-danger btn-hapus' data-id='".$data['id']."' data-nama='". $data['nama'] ."'> <span class='glyphicon glyphicon-trash'></span> Hapus</button> </td>";
    }

    include 'db.php';
    
    $pilih_akses_kas_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Kas'");
    $kas_edit = mysqli_num_rows($pilih_akses_kas_edit);

    if ($kas_edit > 0) {

            echo "<td> <button class='btn btn-info btn-edit' data-id='".$data['id']."' data-nama='". $data['nama'] ."' data-status='". $data['status'] ."'> <span class='glyphicon glyphicon-edit'></span> Edit</button> </td>
            </tr>";
          }

}

 else if($jumlah_kas != '0'){

      include 'db.php';
      
      $pilih_akses_kas_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Kas'");
      $kas_edit = mysqli_num_rows($pilih_akses_kas_edit);

    if ($kas_edit > 0) {

   echo "<td> </td>
         <td> <button class='btn btn-info btn-edit-default' data-id='".$data['id']."' data-status='". $data['status'] ."'> <span class='glyphicon glyphicon-edit'></span> Edit</button> </td>";

            }
          }


        }

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

        ?>
        </tbody>

    </table>

    <script>

$(document).ready(function(){
    $('#tableuser').DataTable();
});

</script>

<script type="text/javascript">
      
//fungsi hapus data 
    $(document).on('click', '.btn-hapus', function() {
    var nama = $(this).attr("data-nama");
    var id = $(this).attr("data-id");
    $("#hapus_nama").val(nama);
    $("#id_hapus").val(id);
    $("#modal_hapus").modal('show');
    
    
    });
    //fungsi edit data 
    $(document).on('click', '.btn-edit', function() {
    
    $("#modal_edit").modal('show');
    var nama = $(this).attr("data-nama");
    var id  = $(this).attr("data-id");
    $("#nama_edit").val(nama);
    $("#id_edit").val(id);
    
    
    });
</script>

<script type="text/javascript">
  
      $(document).on('click', '.btn-edit-default', function() {
    
    $("#modal_edit-default").modal('show');
    var status = $(this).attr("data-status");
    var id  = $(this).attr("data-id");
    $("#status_edit_defalut").val(status);
    $("#id_edit_default").val(id);
    
    
    });

</script>
