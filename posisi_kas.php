<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


$query = $db->query("SELECT id, kode_daftar_akun, nama_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank' ");



 ?>


<div class="container">
 <h3><b><u> Posisi Kas </u></b></h3> <br>



<br>
<br>


<!-- Modal edit data -->
<div id="modal_edit-default" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Kas Keluar</h4>
      </div>
      <div class="modal-body">
  <form role="form" action="update_default_kas.php" method="post">
   <div class="form-group">

          <label> Default Kas </label><br>
          <select type="text" name="kas_default" id="kas_default" autocomplete="off" class="form-control" >
          <option value="Ya">Ya</option>
          <option value="">Tidak</option>
          </select> 
     
          
          <input type="hidden" name="kode_daftar_akun" id="kode_daftar_akun" class="form-control">
          <input type="hidden" name="id" id="id_edit_default" class="form-control"> 
    
   </div>
   
   
   <button type="submit" id="submit_edit_default" class="btn btn-success">Submit</button>
  </form>


  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->


<div class="table-responsive"> 
<span id="tabel_baru">
<table id="tableuser" class="table table-bordered">
            <thead>
                  <th> Nama  </th>
                  <th> Jumlah </th>
            </thead>
            
            <tbody>
            <?php

            
                  while ($data = mysqli_fetch_array($query))
            {
                  echo "<tr>
      <td>". $data['nama_daftar_akun'] ."</td>";

            
// MENCARI JUMLAH KAS
            $query0 = $db->query("SELECT SUM(total) AS total_penjualan FROM penjualan WHERE cara_bayar = '$data[kode_daftar_akun]' AND status_jual_awal = 'Tunai'");
            $cek0 = mysqli_fetch_array($query0);
            $total_penjualan = $cek0['total_penjualan'];

            $query0000 = $db->query("SELECT SUM(kredit) AS kredit_penjualan FROM penjualan WHERE cara_bayar = '$data[kode_daftar_akun]'");
            $cek0000 = mysqli_fetch_array($query0000);
            $kredit_penjualan = $cek0000['kredit_penjualan'];

            $query2 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_masuk FROM kas_masuk WHERE ke_akun = '$data[kode_daftar_akun]'");
            $cek2 = mysqli_fetch_array($query2);
            $jumlah_kas_masuk = $cek2['jumlah_kas_masuk'];

            $query20 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_masuk_mutasi FROM kas_mutasi WHERE ke_akun = '$data[kode_daftar_akun]'");
            $cek20 = mysqli_fetch_array($query20);
            $jumlah_kas_masuk_mutasi = $cek20['jumlah_kas_masuk_mutasi'];

            $query200 = $db->query("SELECT SUM(total) AS total_retur_pembelian FROM retur_pembelian WHERE cara_bayar = '$data[kode_daftar_akun]'");
            $cek200 = mysqli_fetch_array($query200);
            $total_retur_pembelian = $cek200['total_retur_pembelian'];

            $piutang = $db->query("SELECT SUM(total) AS total_piutang FROM pembayaran_piutang WHERE dari_kas = '$data[kode_daftar_akun]'");
            $cek_piutang = mysqli_fetch_array($piutang);
            $total_piutang = $cek_piutang['total_piutang'];

            $sum_tunai_penjualan = $db->query("SELECT  SUM(tunai) AS tunai_penjualan FROM penjualan WHERE cara_bayar = '$data[kode_daftar_akun]' AND status_jual_awal = 'Kredit'");
            $data_tunai_penjualan = mysqli_fetch_array($sum_tunai_penjualan);
            $tunai_penjualan = $data_tunai_penjualan['tunai_penjualan'];


//total kas 1

            $kas_1 = $total_penjualan + $jumlah_kas_masuk + $jumlah_kas_masuk_mutasi + $total_retur_pembelian + $total_piutang + $tunai_penjualan;




            $query3 = $db->query("SELECT SUM(total) AS total_pembelian FROM pembelian WHERE cara_bayar = '$data[kode_daftar_akun]' AND status_beli_awal = 'Tunai' ");
            $cek3 = mysqli_fetch_array($query3);
            $total_pembelian = $cek3['total_pembelian'];

            $query0001 = $db->query("SELECT SUM(kredit) AS kredit_pembelian FROM pembelian WHERE cara_bayar = '$data[kode_daftar_akun]'");
            $cek0001 = mysqli_fetch_array($query0001);
            $kredit_pembelian = $cek0001['kredit_pembelian'];


            $query5 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_keluar FROM kas_keluar WHERE dari_akun = '$data[kode_daftar_akun]'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_kas_keluar = $cek5['jumlah_kas_keluar'];

            $query5 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_keluar_mutasi FROM kas_mutasi WHERE dari_akun = '$data[kode_daftar_akun]'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_kas_keluar_mutasi = $cek5['jumlah_kas_keluar_mutasi'];

            $query5 = $db->query("SELECT SUM(total) AS total_retur_penjualan FROM retur_penjualan WHERE cara_bayar = '$data[kode_daftar_akun]'");
            $cek5 = mysqli_fetch_array($query5);
            $total_retur_penjualan = $cek5['total_retur_penjualan'];

            $hutang = $db->query("SELECT SUM(total) AS total_hutang FROM pembayaran_hutang WHERE dari_kas = '$data[kode_daftar_akun]' ");
            $cek_hutang = mysqli_fetch_array($hutang);
            $total_hutang = $cek_hutang['total_hutang'];

            $sum_tunai_pembelian = $db->query("SELECT SUM(tunai) AS tunai_pembelian FROM pembelian WHERE cara_bayar = '$data[kode_daftar_akun]' AND status_beli_awal = 'Kredit'");
            $data_tunai_pembelian = mysqli_fetch_array($sum_tunai_pembelian);
            $tunai_pembelian = $data_tunai_pembelian['tunai_pembelian'];




//total barang 2
            $kas_2 = $total_pembelian + $jumlah_kas_keluar + $jumlah_kas_keluar_mutasi + $total_retur_penjualan + $total_hutang + $tunai_pembelian;







            $jumlah_kas = $kas_1 - $kas_2;

         
            
            echo "<td>". rp($jumlah_kas) ."</td>";
         

      }


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
            ?>
            </tbody>

      </table>
</span>

</div>


<script>

$(document).ready(function(){
    $('#tableuser').DataTable();
});

</script>




<script type="text/javascript">
  
    $(".btn-edit-default").click(function(){
    
    $("#modal_edit-default").modal('show');
    var kode_daftar_akun = $(this).attr("data-kode");
    var id  = $(this).attr("data-id");
    $("#kode_daftar_akun").val(kode_daftar_akun);
    $("#id_edit_default").val(id);
    
    
    });

    $(".btn-edit-default").click(function(){

      var kode_daftar_akun = $("#kode_daftar_akun").val();
      var kas_default = $("#kas_default").val();
      var id = $("#id_edit_default").val();

        $.post("update_default_kas.php",{id:id,kas_default:kas_default,kode_daftar_akun:kode_daftar_akun},function(data){
        
        
        });
      });

</script>



<?php include 'footer.php'; ?>

