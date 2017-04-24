<?php include 'session_login.php';

 include 'header.php';
 include 'navbar.php';
 include 'db.php';
 include 'sanitasi.php';

 $nomor_faktur_pembayaran = $_GET['no_faktur_pembayaran'];

$query = $db->query("SELECT tanggal FROM pembayaran_piutang WHERE no_faktur_pembayaran = '$nomor_faktur_pembayaran'");
$ambil_tanggal = mysqli_fetch_array($query);
 
 
$perintah50 = $db->query("SELECT * FROM tbs_pembayaran_piutang 
                WHERE no_faktur_pembayaran = '$nomor_faktur_pembayaran'");
$data50 = mysqli_fetch_array($perintah50);
$no_faktur_penjualan = $data50['no_faktur_penjualan']; 

 ?>
<style type="text/css">
  .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: true;
}
</style>
      
      <script>
      $(function() {
      $( "#tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
      });
      </script>




 <div class="container">
 

<h3><u>FORM EDIT PEMBAYARAN PIUTANG</u> </h3>
<br><br>


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Pembayaran Piutang</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nomor Faktur Penjualan:</label>
     <input type="text" id="no_faktur_penjualan" class="form-control" readonly=""> 
     <input type="hidden" id="jumlah_piutang" class="form-control" readonly="">
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"><span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
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
        <h4 class="modal-title">Edit Data Pembelian Barang</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Jumlah Bayar Baru:</label>
     <input type="text" class="form-control" autocomplete="off" id="bayar_edit"><br>
    <label for="email">Potongan Baru:</label>
     <input type="text" class="form-control" autocomplete="off" id="potongan_edit"><br>

    <label for="email">Jumlah Bayar Lama:</label>
     <input type="text" class="form-control" id="bayar_lama" readonly="">

    <label for="email">Potongan Lama:</label>
     <input type="text" class="form-control" id="potongan_lama" readonly="">
     <input type="hidden" class="form-control" id="id_edit">
     <input type="hidden" class="form-control" id="kredit_edit">
     <input type="hidden" class="form-control" id="no_faktur_penjualan1">
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-primary">Submit</button>
  </form>

  <span id="alert"></span>
  <div class="alert-edit alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->


<form action="proses_tbs_pembayaran_piutang.php" role="form" method="post" id="formtambahproduk">
<div class="row">


          <div class="form-group col-sm-6">
          <label> Nomor Faktur Pembayaran </label><br>
          <input type="text" name="no_faktur_pembayaran" id="no_faktur_pembayaran" class="form-control" readonly="" value="<?php echo $nomor_faktur_pembayaran; ?>" required="" >
          </div>

          <div class="form-group col-sm-6">
          <label> Tanggal </label><br>
          <input type="text" name="tanggal" id="tanggal" placeholder="Tanggal" value ="<?php echo $ambil_tanggal['tanggal']; ?>" class="form-control" required="" >
          </div>


          
          
          
          <div class="form-group col-sm-8">
          <label> Kode Pelanggan </label>
          <br>
          <select type="text" name="kode_pelanggan" id="kd_pelanggan" class="form-control chosen" required="">
                    
          <?php 
          include 'db.php';
          
          // menampilkan data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM pelanggan ");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['kode_pelanggan'] ."' >".$data['kode_pelanggan'] ." - ".$data['nama_pelanggan'] ."</option>";
          }
          
          
          ?>
          </select>
          </div>

<div class="form-group col-sm-4">
          <label> Cara Bayar </label><br>
          <select type="text" name="cara_bayar" id="carabayar1" class="form-control" required="" >
          <option value=""> --SILAHKAN PILIH-- </option>
             <?php 
             
               
             $sett_akun = $db->query("SELECT sa.kas, da.nama_daftar_akun FROM setting_akun sa INNER JOIN daftar_akun da ON sa.kas = da.kode_daftar_akun");
             $data_sett = mysqli_fetch_array($sett_akun);
             
             
             
             echo "<option selected value='".$data_sett['kas']."'>".$data_sett['nama_daftar_akun'] ."</option>";
             
             $query = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank'");
             while($data = mysqli_fetch_array($query))
             {
             
             
             
             
             echo "<option value='".$data['kode_daftar_akun']."'>".$data['nama_daftar_akun'] ."</option>";
             
             
             
             
             }
             
             
             ?>
          
          </select>
          </div>

          <input type="hidden" class="form-control" id="jumlah1" name="jumlah0" placeholder="jumlah">

          

</div> <!-- tag penutup div row -->


<br>
<button type="button" class="btn btn-info" id="cari_produk_penjualan" data-toggle="modal" data-target="#myModal"> <i class='fa fa-search'> </i> Cari</button>
<br><br>
<!-- Tampilan Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Isi Modal-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Penjualan</h4>
      </div>
      <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->

      <!--perintah agar modal update-->
<span class="modal_piutang_baru">


</span>
          
      </div> <!-- tag penutup modal body -->

      <!-- tag pembuka modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> <!--tag penutup moal footer -->
    </div>

  </div>
</div>
    

    <!-- membuat form -->
 <form class="form-inline" role="form" id="formtambahproduk">
  

   <!-- agar tampilan berada pada satu group -->
  <!-- memasukan teks pada kolom kode barang -->
<br>
<div class="form-group col-sm-3">
  <input type="text" class="form-control" name="no_faktur_penjualan" id="nomorfakturbeli" placeholder="Nomor Faktur Jual" readonly="">
  </div>
  
  <div class="form-group col-sm-3">
    <input type="text" class="form-control" name="kredit" id="kredit" placeholder="Kredit" readonly="">
  </div>




  <div class="form-group col-sm-3">
          <input type="text" name="potongan" id="potongan_penjualan" class="form-control" placeholder="Potongan" autocomplete="off">
  </div>

  <div class="form-group col-sm-3">
    <input type="text" class="form-control" name="jumlah_bayar" id="jumlah_bayar" placeholder="Jumlah Bayar" autocomplete="off">
  </div>

<button type="submit" id="submit_tambah" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah </button>

<div class="form-group">
  <input type="hidden" name="total" id="total" class="form-control" value="" required="">
</div>

<div class="form-group">
  <input type="hidden" name="tanggal_jt" id="tanggal_jt" class="form-control" value="" required="">
</div>
<input type="hidden" name="status" id="status" class="form-control" value="">


</form>


     <!--Mendefinisikan sebuah bagian dalam dokumen-->  
  <br>   
  <br> 
  
  
  <div class="table-responsive">
<span id="tabel_baru"> 
  <!--tag untuk membuat garis pada tabel-->       
  <table id="tableuser" class="table table-bordered">
    <thead>
      <th> Nomor Faktur Pembayaran </th>
      <th> Nomor Faktur Penjualan</th>
      <th> Tanggal </th>
      <th> Tanggal Jatuh Tempo </th>
      <th> Kredit </th>
      <th> Potongan </th>
      <th> Total</th>
      <th> Jumlah Bayar </th>
      <th> Hapus </th>
      <th> Edit </th>
      
    </thead>
    
    <tbody>
    <?php

    //untuk menampilkan semua data yang ada pada tabel tbs pembelian dalam DB
    $perintah = $db->query("SELECT * FROM tbs_pembayaran_piutang 
                WHERE no_faktur_pembayaran = '$nomor_faktur_pembayaran'");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr>
      <td>". $data1['no_faktur_pembayaran'] ."</td>
      <td>". $data1['no_faktur_penjualan'] ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['tanggal_jt'] ."</td>
      <td>". rp($data1['kredit']) ."</td>
      <td>". rp($data1['potongan']) ."</td>
      <td>". rp($data1['total']) ."</td>
      <td>". rp($data1['jumlah_bayar']) ."</td>
      

      <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-faktur='". $data1['no_faktur_penjualan'] ."' data-piutang='". $data1['kredit'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 

      <td> <button class='btn btn-success btn-edit-tbs' data-id='". $data1['id'] ."' data-kredit='". $data1['kredit'] ."' data-jumlah-bayar='". $data1['jumlah_bayar'] ."' data-no-faktur-penjualan='". $data1['no_faktur_penjualan'] ."' data-potongan='". $data1['potongan'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>
      </tr>";
      
      }

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
    ?>
    </tbody>

  </table>
  </span> <!--tag penutup span-->
  </div>
        

<br>
<div class="total">
<div class="form-group">
          <label> Total Bayar </label><br>
          <input type="text" name="total_bayar" id="totalbayar" placeholder="Total Bayar" class="form-control" readonly="" required="">
          </div>



<div class="form-group">
          <label> Keterangan </label><br>
          <textarea type="text" name="keterangan" id="keterangan" placeholder="Keterangan" class="form-control" > 
          </textarea> 
          <br>



<button type="submit" id="pembayaran" class="btn btn-info"><i class='fa fa-send'></i> Bayar</button>

<a href='batal_piutang.php?no_faktur_penjualan=<?php echo $no_faktur_penjualan; ?>&no_faktur_pembayaran=<?php echo $nomor_faktur_pembayaran; ?>' id='batal_piutang' class='btn btn-danger'><i class='fa fa-close'></i> Batal </a>

<a href="form_pembayaran_piutang.php" class="btn btn-primary" id="transaksi_baru" style="display: none"><i class="fa fa-refresh"></i>Transaksi Baru</a>

<a href='cetak_pembayaran_piutang.php' id="cetak_piutang" style="display: none;" class="btn btn-success" target="blank"><i class="fa fa-print"> </i> Cetak Pembayaran Piutang </a>
          
<br>
<div class="alert alert-success" id="alert_berhasil" style="display:none">
  <strong>Success!</strong> Pembayaran Berhasil
</div>

<br>
<br><br>

<label> User : <?php echo $_SESSION['user_name']; ?> </label> 
          <!-- readonly = digunakan agar teks atau isi hanya bisa dibaca tapi tidak bisa diubah -->
  </div>

<span id="demo"> </span>
</div>
</div><!-- end of container -->


    
<script>
// untuk memunculkan data tabel 
    $(document).ready(function(){
    $('.table').DataTable({"ordering": false});    
    
    });
  
</script>
<!-- untuk memasukan perintah javascript -->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {
  document.getElementById("nomorfakturbeli").value = $(this).attr('no-faktur');
  document.getElementById("kredit").value = $(this).attr('kredit');
  document.getElementById("total").value = $(this).attr('total');
  document.getElementById("tanggal_jt").value = $(this).attr('tanggal_jt');
  
  $('#myModal').modal('hide');
  });
   

   
  </script> <!--tag penutup perintah java script-->

<script>
   //perintah javascript yang diambil dari form tbs pembelian dengan id=form tambah produk

  
$("#submit_tambah").click(function(){
      
      var jumlah_bayar = $("#jumlah_bayar").val();
      var kredit = $("#kredit").val();
      var kode_pelanggan = $("#kd_pelanggan").val();
      var no_faktur_penjualan = $("#nomorfakturbeli").val();
      var total = $("#total").val();
      var tanggal_jt = $("#tanggal_jt").val();
      var no_faktur_pembayaran = $("#no_faktur_pembayaran").val();
      var tanggal = $("#tanggal").val();
      var cara_bayar = $("#carabayar1").val();
      var potongan = $("#potongan_penjualan").val();

      var total_kredit = kredit - potongan;

      var hasil = jumlah_bayar - kredit;
      
      $("#totalbayar").val(jumlah_bayar);
      $("#total").val(total_kredit);
      
      if (hasil > 0 )
      {

      alert("Jumlah Bayar Anda Melebihi Sisa");
      
      }
      
      else if (jumlah_bayar == ""){
      alert("Jumlah Bayar Harus Diisi");
      }
      else if (kode_pelanggan == ""){
      alert("Kode Pelanggan Harus Dipilih");
      }
      else if (cara_bayar == ""){
      alert("Cara Bayar Harus Dipilih");
      }
      
      else
      {


    $.post("proses_edit_tbs_pembayaran_piutang.php", {no_faktur_pembayaran:no_faktur_pembayaran,no_faktur_penjualan:no_faktur_penjualan,tanggal:tanggal,tanggal_jt:tanggal_jt,total:total_kredit,potongan:potongan,jumlah_bayar:jumlah_bayar,kredit:kredit,kode_pelanggan:kode_pelanggan},function(info) {


     $("#tabel_baru").html(info);
     $("#tabel_baru").load("tabel-edit-tbs-pembayaran-piutang.php?no_faktur_pembayaran=<?php echo $nomor_faktur_pembayaran; ?>");
     $("#nomorfakturbeli").val('');
     $("#kredit").val('');
     $("#jumlah_bayar").val('');
     $("#potongan_penjualan").val('');
     


       
   });
 
}
      $("form").submit(function(){
    return false;
});
  


  });


 $("#submit_tambah").click(function(){

            var kode_pelanggan = $("#kd_pelanggan").val();
            
            if (kode_pelanggan != ""){
            $("#kd_pelanggan").attr("disabled", true);
            }
                     
            
            });

  
  $("#cari_produk_penjualan").click(function() {

     $.get('no_faktur_pp.php', function(data) {
   /*optional stuff to do after getScript */ 
$("#nomorfaktur_pembayaran").val(data);
 });
    //modal baru



      $.get('no_faktur_retur_jl.php', function(data) {
   /*optional stuff to do after getScript */ 
$("#nomorfakturbeli").val(data);
 });
//menyembunyikan notif berhasil
     $("#alert_berhasil").hide();
    /* Act on the event */


      var kode_pelanggan = $("#kd_pelanggan").val();
      
      $.post("modal_piutang_baru.php", {kode_pelanggan:kode_pelanggan}, function(info) {

      $(".modal_piutang_baru").html(info);
      
      
      });
      });
      
      
      </script>


  <script type="text/javascript">
   $(document).ready(function(){
      $("#jumlah_bayar").keyup(function(){
      var kredit = $("#kredit").val();
      var jumlah_bayar = $("#jumlah_bayar").val();
      var hasil = jumlah_bayar - kredit;

      $("#totalbayar").val(jumlah_bayar);
      
      if (hasil > 0 )
      {
      alert("Jumlah Bayar Anda Melebihi Sisa");
      
      }
      
      });
   });

  </script>



 <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#pembayaran").click(function(){

   var no_faktur_pembayaran = $("#no_faktur_pembayaran").val();
   var no_faktur_penjualan = $("#nomorfakturbeli").val();
   var cara_bayar = $("#carabayar1").val();
   var kode_pelanggan = $("#kd_pelanggan").val();
   var keterangan = $("#keterangan").val();
   var total = $("#total").val();
   var user_buat = $("#user_buat").val();
   var dari_kas = $("#dari_kas").val();
   var kredit = $("#kredit").val();
   var status = $("#status").val();
   var total_bayar = $("#totalbayar").val();
   var tanggal = $("#tanggal").val();

   


if (cara_bayar == "")
  {
  
  alert("Cara Bayar Harus Di Isi");
  
  }
  
  else if (kode_pelanggan == "")
  {
  alert("Kode Pelangan Harus Di Isi");
  }




else

 {
  $("#transaksi_baru").show();
  $("#batal_piutang").hide();
  $("#pembayaran").hide();
  

 $.post("proses_bayar_edit_piutang.php", {tanggal:tanggal,no_faktur_pembayaran:no_faktur_pembayaran,no_faktur_penjualan:no_faktur_penjualan,cara_bayar:cara_bayar,kode_pelanggan:kode_pelanggan,keterangan:keterangan,total:total,user_buat:user_buat,dari_kas:dari_kas,kredit:kredit,status:status,total_bayar:total_bayar},function(info) {



    $("#alert_berhasil").show();
    $("#tabel_baru").load("tabel-edit-tbs-pembayaran-piutang.php?no_faktur_pembayaran=<?php echo $nomor_faktur_pembayaran; ?>");
    $("#cetak_piutang").show();
     $("#nama_suplier").val('');
     $("#carabayar1").val('');
     $("#totalbayar").val('');
     $("#keterangan").val('');
    
  
    
       
   });

$("#tabel_baru").load("tabel-edit-tbs-pembayaran-piutang.php?no_faktur_pembayaran=<?php echo $nomor_faktur_pembayaran; ?>");
//mengambil no_faktur pembelian agar berurutan


 }

 $("form").submit(function(){
    return false;
});


  });
     
  </script>





<script type="text/javascript">
$(document).ready(function(){
// perintah javascript yang diambil dari form tbs pembelian dengan id=pembayaran_pembelian
$("#submit_tambah").mouseleave(function(){

$.post("cek_total_edit_pembayaran_piutang.php",
    {
        no_faktur_pembayaran: "<?php echo $nomor_faktur_pembayaran; ?>"
    },
    function(data){
        $("#totalbayar"). val(data);
    });
      

});
});

// untuk memunculkan data cek total pembelian
$(document).ready(function(){
$.post("cek_total_edit_pembayaran_piutang.php",
    {
        no_faktur_pembayaran: "<?php echo $nomor_faktur_pembayaran; ?>"
    },
    function(data){
        $("#totalbayar"). val(data);
    });

});


</script>

<script type="text/javascript">
$(document).ready(function(){
// perintah javascript yang diambil dari form tbs pembelian dengan id=pembayaran_pembelian
$(".total").hover(function(){

$.post("cek_total_edit_pembayaran_piutang.php",
    {
        no_faktur_pembayaran: "<?php echo $nomor_faktur_pembayaran; ?>"
    },
    function(data){
        $("#totalbayar"). val(data);
    });
      

});
});

// untuk memunculkan data cek total pembelian
$(document).ready(function(){
$.post("cek_total_edit_pembayaran_piutang.php",
    {
        no_faktur_pembayaran: "<?php echo $nomor_faktur_pembayaran; ?>"
    },
    function(data){
        $("#totalbayar"). val(data);
    });

});


</script>


<!--membuat menampilkan no faktur dan suplier pada tax-->
<script>

$(document).ready(function(){
    $("#kd_pelanggan").change(function(){
      var suplier = $("#kd_pelanggan").val();
      $("#kode_pelanggan").val(suplier);
        
    });
});
</script>

<script>

// BELUM KELAR !!!!!!
$(document).ready(function(){
    $("#carabayar1").change(function(){
      var cara_bayar = $("#carabayar1").val();

      //metode POST untuk mengirim dari file cek_jumlah_kas.php ke dalam variabel "dari akun"
      $.post('cek_jumlah_kas1.php', {cara_bayar : cara_bayar}, function(data) {
        /*optional stuff to do after success */

      $("#jumlah1").val(data);
      });
        
    });
});
</script>




<script type="text/javascript">
  
$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});

</script>

                            
<script>

// untuk memunculkan jumlah kas secara otomatis
  $(document).ready(function(){
    $("#jumlah_bayar").keyup(function(){
      var jumlah_bayar = $("#jumlah_bayar").val();
      var jumlah_kas = $("#jumlah1").val();
      var kredit = jumlah_kas - jumlah_bayar;
      var carabayar1 = $("#carabayar1").val();

      if ( carabayar1 == "") 

      {
          $("#submit_tambah").hide();

        alert("Kolom Cara Bayar Masih Kosong");

      }
      else {
        $("#submit_tambah").show();
      }


    });

  });
</script>

<script type="text/javascript">
                               
//fungsi hapus data 
    $(".btn-hapus").click(function(){
    var no_faktur_penjualan = $(this).attr("data-faktur");
    var kredit = $(this).attr("data-piutang");
    var id = $(this).attr("data-id");
    $("#no_faktur_penjualan").val(no_faktur_penjualan);
    $("#jumlah_piutang").val(kredit);
    $("#id_hapus").val(id);
    $("#modal_hapus").modal('show');
    
    
    });
    
    
    $("#btn_jadi_hapus").click(function(){
    
    var id = $("#id_hapus").val();
    var no_faktur_penjualan = $("#no_faktur_penjualan").val();
    var kredit = $("#jumlah_piutang").val();
    $.post("hapus_tbs_pembayaran_piutang.php",{id:id, no_faktur_penjualan:no_faktur_penjualan, kredit:kredit},function(data){
    
    $("#tabel_baru").load('tabel-edit-tbs-pembayaran-piutang.php?no_faktur_pembayaran=<?php echo $nomor_faktur_pembayaran; ?>');
    $("#totalbayar").val('');
    $("#modal_hapus").modal('hide');
     $("#hapus_edit").html('');
    
    
    
    });
    
    
    });
    
  
 //fungsi edit data 
        $(".btn-edit-tbs").click(function(){
        
        $("#modal_edit").modal('show');
        var jumlah_lama = $(this).attr("data-jumlah-bayar");
        var potongan_lama = $(this).attr("data-potongan");
        var id  = $(this).attr("data-id");
        var nofaktur1  = $(this).attr("data-no-faktur-penjualan");

        var kredit  = $(this).attr("data-kredit");
        $("#bayar_lama").val(jumlah_lama);
        $("#potongan_lama").val(potongan_lama);
        $("#id_edit").val(id);
        $("#kredit_edit").val(kredit);
        $("#no_faktur_penjualan1").val(nofaktur1);

        
        
        });
        
        $("#submit_edit").click(function(){
        var jumlah_lama = $("#bayar_lama").val();
        var jumlah_baru = $("#bayar_edit").val();
        var potongan_lama = $("#potongan_lama").val();
        var potongan_baru = $("#potongan_edit").val();
        var kredit = $("#kredit_edit").val();

        var id = $("#id_edit").val();
        var nofaktur1 = $("#no_faktur_penjualan1").val();

        $.post("update_tbs_edit_pembayaran_piutang.php",{id:id,kredit:kredit,jumlah_bayar:jumlah_lama,jumlah_baru:jumlah_baru,potongan:potongan_lama,potongan_baru:potongan_baru,no_faktur_penjualan:nofaktur1},function(data){

        
        $("#alert").html(data);
        $("#tabel_baru").load('tabel-edit-tbs-pembayaran-piutang.php?no_faktur_pembayaran=<?php echo $nomor_faktur_pembayaran; ?>');
        setTimeout(tutupmodal, 2000);
        setTimeout(tutupalert, 2000);
        
      
        });
        });
//end function edit data

              $('form').submit(function(){
              
              return false;
              });
        


    function tutupalert() {
    $("#alert").html("")
    }

    function tutupmodal() {
    $("#modal_edit").modal("hide")
    }
</script>
                             
<?php 
include 'footer.php';
 ?>
