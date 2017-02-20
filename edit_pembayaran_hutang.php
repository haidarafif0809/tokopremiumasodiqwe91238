<?php include 'session_login.php';

 include 'header.php';
 include 'navbar.php';
 include 'db.php';
 include 'sanitasi.php';

 $nomor_faktur_pembayaran = $_GET['no_faktur_pembayaran'];
 $nama = $_GET['nama'];
 $cara_bayar = $_GET['cara_bayar'];
 

$query = $db->query("SELECT tanggal,nama_suplier FROM pembayaran_hutang WHERE no_faktur_pembayaran = '$nomor_faktur_pembayaran'");
$ambil_tanggal = mysqli_fetch_array($query);

 

$perintah50 = $db->query("SELECT * FROM tbs_pembayaran_hutang 
                WHERE no_faktur_pembayaran = '$nomor_faktur_pembayaran'");
$data50 = mysqli_fetch_array($perintah50);
$no_faktur_pembelian = $data50['no_faktur_pembelian']; 


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
      $( ".tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
      });
      </script>




 <div class="container">
 
<h3><u>FORM EDIT PEMBAYARAN HUTANG</u> </h3>
<br><br>

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Pembayaran Hutang</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nomor Faktur Pembelian :</label>
     <input type="text" id="no_faktur_pembelian" class="form-control" readonly="">
     <input type="hidden" id="jumlah_hutang" class="form-control" readonly="">
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
        <h4 class="modal-title">Edit Data Pembayaran Hutang</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Jumlah Bayar Baru:</label>
     <input type="text" name="jumlah_baru" class="form-control" autocomplete="off" id="bayar_edit"><br>
    <label for="email">Jumlah Potongan Baru:</label>
     <input type="text" name="potongan_baru" class="form-control" autocomplete="off" id="potongan_edit"><br>

    <label for="email">Jumlah Bayar Lama:</label>
     <input type="text" name="jumlah_lama" class="form-control" id="bayar_lama" readonly="">
    <label for="email">Jumlah Potongan Lama:</label>
     <input type="text" name="potongan_lama" class="form-control" id="potongan_lama" readonly="">
     <input type="hidden" class="form-control" id="id_edit">
     <input type="hidden" class="form-control" id="kredit_edit">
     <input type="hidden" class="form-control" id="no_faktur_pembelian1">
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-default">Submit</button>
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


<form action="proses_tbs_pembayaran_hutang.php" role="form" method="post" id="formtambahproduk">
<div class="row">




          <div class="form-group col-sm-6">
          <label> Nomor Faktur Pembayaran </label><br>
          <input type="text" name="no_faktur_pembayaran" id="no_faktur_pembayaran" class="form-control" readonly="" value="<?php echo $nomor_faktur_pembayaran; ?>" required="" >
          </div>




          <div class="form-group col-sm-6">
          <label> Tanggal </label><br>
          <input type="text" value ="<?php echo $ambil_tanggal['tanggal']; ?>" name="tanggal" id="tanggal" placeholder="Tanggal"  class="form-control tanggal" required="" >
          </div>

          <input type="hidden" class="form-control" id="jumlah1" name="jumlah0" placeholder="jumlah">


          <div class="form-group col-sm-8">
          <label> Suplier </label>
          <br>
          <select type="text" name="suplier" id="nama_suplier" class="form-control chosen" required="">
          <option value="<?php echo $ambil_tanggal['nama_suplier']; ?>"><?php echo $nama; ?></option>
          
          <?php 
          include 'db.php';
          
          // menampilkan data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM suplier ");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
          }
          
          
          ?>
          </select>
          </div>

          <div class="form-group col-sm-4">
          <label> Cara Bayar </label><br>
          <select type="text" name="cara_bayar" id="carabayar1" class="form-control">

             <?php 
             

             $pilih_daftar_akun = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank'");
             while($ambil_daftar_akun = mysqli_fetch_array($pilih_daftar_akun))
             {
             
             if ($cara_bayar == $ambil_daftar_akun['kode_daftar_akun']) {
               
             
             echo "<option value='".$ambil_daftar_akun['kode_daftar_akun']."' selected=''>".$ambil_daftar_akun['nama_daftar_akun'] ."</option>";
             }

             else{

             
             echo "<option value='".$ambil_daftar_akun['kode_daftar_akun']."'>".$ambil_daftar_akun['nama_daftar_akun'] ."</option>";
             }
             
             
             
             
             }
             
             
             ?>
          
          </select>
          </div>



          

</div> <!-- tag penutup div row -->


<br>
<button type="button" class="btn btn-info" id="cari_produk_pembelian" data-toggle="modal" data-target="#myModal"> <i class='fa fa-search'> </i> Cari</button>
<br><br>
<!-- Tampilan Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Isi Modal-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Pembelian</h4>
      </div>
      <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->

      <!--perintah agar modal update-->
<span class="modal_hutang_baru">

<div class="table-responsive">
      <!-- membuat agar ada garis pada tabel, disetiap kolom-->
        <table id="tableuser" class="table table-bordered">
    <thead> <!-- untuk memberikan nama pada kolom tabel -->
      
      <th> Nomor Faktur </th>
      <th> Suplier </th>
      <th> Total Beli</th>
      <th> Tanggal </th>
      <th> Tanggal Jatuh Tempo </th>
      <th> Jam </th>
      <th> User </th>
      <th> Status </th>
      <th> Potongan </th>
      <th> Tax </th>
      <th> Sisa </th>
      <th> Kredit </th>
      
    </thead> <!-- tag penutup tabel -->
    
    <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
    <?php

    // menampilkan seluruh data yang ada pada tabel barang yang terdapat pada DB
    $perintah = $db->query("SELECT * FROM pembelian");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
       echo "<tr class='pilih' no-faktur='". $data1['no_faktur'] ."' kredit='". $data1['kredit'] ."' total='". $data1['total'] ."' tanggal_jt='". $data1['tanggal_jt'] ."' >
      
      <td>". $data1['no_faktur'] ."</td>
      <td>". $data1['suplier'] ."</td>
      <td>". $data1['total'] ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['tanggal_jt'] ."</td>
      <td>". $data1['jam'] ."</td>
      <td>". $data1['user'] ."</td>
      <td>". $data1['status'] ."</td>
      <td>". $data1['potongan'] ."</td>
      <td>". $data1['tax'] ."</td>
      <td>". $data1['sisa'] ."</td>
      <td>". $data1['kredit'] ."</td>
      </tr>";
      
       }

    ?>
    </tbody> <!--tag penutup tbody-->

  </table> <!-- tag penutup table-->
  </div>
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
 <form class="form-inline" action="proses_bayar_hutang.php" role="form" id="formtambahproduk">
  

   <!-- agar tampilan berada pada satu group -->
  <!-- memasukan teks pada kolom kode barang -->
<br>
<div class="form-group col-sm-3">
  <input type="text" class="form-control" name="no_faktur_pembelian" id="nomorfakturbeli" placeholder="Nomor Faktur Beli" readonly="">
  </div>
  
  <div class="form-group col-sm-3">
    <input type="text" class="form-control" name="kredit" id="kredit" placeholder="Kredit" readonly="">
  </div>


<div class="form-group col-sm-3">
          <input type="text" name="potongan" id="potongan_penjualan" class="form-control" placeholder="Potongan" autocomplete="off">
</div>

  <div class="form-group col-sm-3">
    <input type="text" class="form-control"  onkeydown="return numbersonly(this, event);" name="jumlah_bayar" id="jumlah_bayar" placeholder="Jumlah Bayar" autocomplete="off">
  </div>

<button type="submit" id="submit_tambah" class="btn btn-success"> <span class='glyphicon glyphicon-plus'> </span>Tambah </button>

<div class="form-group">
  <input type="hidden" name="total" id="total" class="form-control" value="" required="">
</div>

<div class="form-group">
  <input type="hidden" name="potongan" id="potongan10" class="form-control" value="" required="">
</div>

<div class="form-group">
  <input type="hidden" name="tanggal_jt" id="tanggal_jt" class="form-control" value="" required="">
</div>
<input type="hidden" name="status" id="status" class="form-control" value="">


</form>



     <!--Mendefinisikan sebuah bagian dalam dokumen-->  
  <br>   
  <br> 
  <span id="result"> 

  <div class="table-responsive">

  <!--tag untuk membuat garis pada tabel-->       
  <table id="tableuser" class="table table-bordered">
    <thead>
      <th> Nomor Faktur Pembayaran </th>
      <th> Nomor Faktur Pembelian </th>
      <th> Tanggal </th>
      <th> Tanggal JT </th>
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
    $perintah = $db->query("SELECT * FROM tbs_pembayaran_hutang 
                WHERE no_faktur_pembayaran = '$nomor_faktur_pembayaran'");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

     
        // menampilkan data
      echo "<tr>
      <td>". $data1['no_faktur_pembayaran'] ."</td>
      <td>". $data1['no_faktur_pembelian'] ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['tanggal_jt'] ."</td>
      <td>". rp($data1['kredit']) ."</td>
      <td>". rp($data1['potongan']) ."</td>
      <td>". rp($data1['total']) ."</td>
      <td>". rp($data1['jumlah_bayar']) ."</td>
      

      <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-no-faktur-pembelian='". $data1['no_faktur_pembelian'] ."' data-hutang='". $data1['kredit'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 

      <td> <button class='btn btn-success btn-edit-tbs' data-id='". $data1['id'] ."' data-jumlah-bayar='". $data1['jumlah_bayar'] ."' data-no-faktur-pembelian='". $data1['no_faktur_pembelian'] ."' data-potongan='". $data1['potongan'] ."' data-kredit='". $data1['kredit'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>
      </tr>";
      }

      //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);  

    ?>
    </tbody>

  </table>
  </div>
        </span> <!--tag penutup span-->

<br>
<div class="total">
<div class="form-group">
          <label> Total Bayar </label><br>
          <input type="text" name="total_bayar" id="totalbayar" placeholder="Total Bayar" class="form-control" readonly="" required="">
          </div>



<div class="form-group">
          <label> Keterangan </label><br>
          <textarea name="keterangan" id="keterangan" class="form-control" ></textarea>  
          <br>



<button type="submit" id="pembayaran" class="btn btn-info"><i class="fa fa-send"></i> Bayar</button>
<a href="form_pembayaran_hutang.php" class="btn btn-primary" style="display: none" id="transaksi_baru"><i class="fa fa-refresh"></i> Transaksi Baru</a>

<a href='cetak_pembayaran_hutang.php' id="cetak_hutang" style="display: none;" class="btn btn-success" target="blank"><i class="fa fa-print"> </i> Cetak Pembayaran Hutang </a>



          
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
//untuk menampilkan data tabel
$(document).ready(function(){
    $('.table').dataTable();
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
      var suplier = $("#nama_suplier").val();
      var no_faktur_pembelian= $("#nomorfakturbeli").val();
      var total = $("#totalbayar").val();
      var total_bayar1 = $("#totalbayar1").val();
      var tanggal_jt = $("#tanggal_jt").val();
      var no_faktur_pembayaran = $("#no_faktur_pembayaran").val();
      var tanggal = $("#tanggal").val();
      var cara_bayar = $("#carabayar1").val();
      var total1 = $("#total").val();
      var jumlah1 = $("#jumlah1").val();
      var potongan = $("#potongan_penjualan").val();
      var total_kredit = kredit - potongan;

      var hasil = jumlah_bayar - kredit;
      var jumlahku = jumlah1 - jumlah_bayar;
      $("#totalbayar").val(jumlah_bayar);
      $("#total").val(total_kredit);

      if (hasil > 0 )
      {

      alert("Jumlah Bayar Anda Melebihi Sisa");
      
      }
      
      else if (jumlah_bayar == ""){
      alert("Jumlah Bayar Harus Diisi");
      }
      else if (suplier == ""){
      alert("Suplier Harus Dipilih");
      }
      else if (cara_bayar == ""){
      alert("Cara Bayar Harus Dipilih");
      }
      else if (jumlahku < 0){
      alert("Jumlah Kas Tidak Mencukupi");
      }
      else
      {


    $.post("proses_tbs_edit_pembayaran_hutang.php", {no_faktur_pembayaran:no_faktur_pembayaran,no_faktur_pembelian:no_faktur_pembelian,tanggal:tanggal,tanggal_jt:tanggal_jt,total:total_kredit,jumlah_bayar:jumlah_bayar,kredit:kredit,suplier:suplier,potongan:potongan},function(info) {


    $("#result").load('tabel-tbs-edit-pembayaran-hutang.php?no_faktur_pembayaran=<?php echo $nomor_faktur_pembayaran; ?>');
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

            var suplier = $("#nama_suplier").val();
            
            if (suplier != ""){
            $("#nama_suplier").attr("disabled", true);
            }
                     
            
            });

  
  $("#cari_produk_pembelian").click(function() {
     
    //modal baru

     var suplier = $("#nama_suplier").val();
     var no_faktur_pembayaran = $("#no_faktur_pembayaran").val();

     $.post("modal_edit_hutang_baru.php", {suplier:suplier,no_faktur_pembayaran:no_faktur_pembayaran}, function(info) {

      $(".modal_hutang_baru").html(info);
      
      
      });

      
//menyembunyikan notif berhasil
     $("#alert_berhasil").hide();
    /* Act on the event */




 
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
   var no_faktur_pembelian = $("#nomorfakturbeli").val();
   var cara_bayar = $("#carabayar1").val();
   var suplier = $("#nama_suplier").val();
   var keterangan = $("#keterangan").val();
   var total = $("#total").val();
   var user_buat = $("#user_buat").val();
   var dari_kas = $("#dari_kas").val();
   var kredit = $("#kredit").val();
   var status = $("#status").val();
   var total_bayar = $("#totalbayar").val();
   var total_bayar1 = $("#totalbayar1").val();
   var tanggal = $("#tanggal").val();
   var jumlah = $("#jumlah_bayar").val();
   var jumlah_kas = $("#jumlah1").val();
   var kredit = jumlah_kas - jumlah;
   var carabayar1 = $("#carabayar1").val();
   


if (cara_bayar == "")
  {
  
  alert("Cara Bayar Harus Di Isi");
  
  }
  
  else if (suplier == "")
  {
  alert("Suplier Harus Di Isi");
  }
   else if (kredit < 0 || carabayar1 == "") 
          
  {
          
   alert("Jumlah Kas Tidak Mencukupi Atau Kolom Cara Bayar Masih Kosong");
          
  }



else

 {



$("#transaksi_baru").show();
  $("#pembayaran").hide();

 $.post("proses_bayar_edit_hutang.php", {tanggal:tanggal,no_faktur_pembayaran:no_faktur_pembayaran,no_faktur_pembelian:no_faktur_pembelian,cara_bayar:cara_bayar,suplier:suplier,keterangan:keterangan,total:total,user_buat:user_buat,dari_kas:dari_kas,kredit:kredit,status:status,total_bayar:total_bayar},function(info) {


$("#demo").html(info);

    $("#alert_berhasil").show();
    $("#result").load('tabel-tbs-edit-pembayaran-hutang.php?no_faktur_pembayaran=<?php echo $nomor_faktur_pembayaran; ?>');
    $("#cetak_hutang").show();
     $("#nama_suplier").val('');
     $("#carabayar1").val('');
     $("#totalbayar").val('');
     $("#keterangan").val('');
    
  
    
       
   });



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

$.post("cek_total_edit_pembayaran_hutang.php",
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
$.post("cek_total_edit_pembayaran_hutang.php",
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

$.post("cek_total_edit_pembayaran_hutang.php",
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
$.post("cek_total_edit_pembayaran_hutang.php",
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

  var suplier = $("#nama_suplier").val();
     var no_faktur_pembayaran = $("#no_faktur_pembayaran").val();

     $.post("modal_edit_hutang_baru.php", {suplier:suplier,no_faktur_pembayaran:no_faktur_pembayaran}, function(info) {

      $(".modal_hutang_baru").html(info);
      
      
      });
      
    $("#nama_suplier").change(function(){
      var suplier = $("#nama_suplier").val();
      $.post("modal_edit_hutang_baru.php", {suplier:suplier}, function(info) {

      $(".modal_hutang_baru").html(info);
      
      
      });
        
    });
});
</script>

<script type="text/javascript">
  $(document).ready(function(){
        var cara_bayar = $("#carabayar1").val();

      //metode POST untuk mengirim dari file cek_jumlah_kas.php ke dalam variabel "dari akun"
      $.post('cek_jumlah_kas1.php', {cara_bayar : cara_bayar}, function(data) {
        /*optional stuff to do after success */

      $("#jumlah1").val(data);
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

<script>

// untuk memunculkan jumlah kas secara otomatis
  $(document).ready(function(){
    $("#jumlah_bayar").keyup(function(){
      var jumlah_bayar = $("#jumlah_bayar").val();
      var jumlah_kas = $("#jumlah1").val();
      var kredit = jumlah_kas - jumlah_bayar;
      var carabayar1 = $("#carabayar1").val();

      if (kredit < 0 || carabayar1 == "") 

      {
          $("#submit_tambah").hide();

        alert("Jumlah Kas Tidak Mencukupi Atau Kolom Cara Bayar Masih Kosong");

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
    var no_faktur_pembelian = $(this).attr("data-no-faktur-pembelian");
    var kredit = $(this).attr("data-hutang");
    var id = $(this).attr("data-id");


    $("#no_faktur_pembelian").val(no_faktur_pembelian);
    $("#jumlah_hutang").val(kredit);
    $("#id_hapus").val(id);
    $("#modal_hapus").modal('show');
    
    
    });
    
    
    $("#btn_jadi_hapus").click(function(){
    
    var id = $("#id_hapus").val();
    var no_faktur_pembelian = $("#no_faktur_pembelian").val();
    var kredit = $("#jumlah_hutang").val();
    $.post("hapus_tbs_edit_pembayaran_hutang.php",{id:id, no_faktur_pembelian:no_faktur_pembelian, kredit:kredit},function(data){
    if (data != "") {
    $("#result").load('tabel-tbs-edit-pembayaran-hutang.php?no_faktur_pembayaran=<?php echo $nomor_faktur_pembayaran; ?>');
    $("#totalbayar").val('');
    $("#modal_hapus").modal('hide');
    
    }
    
    
    });
    
    
    });

    //fungsi edit data 
        $(".btn-edit-tbs").click(function(){
        
        $("#modal_edit").modal('show');
        var jumlah_lama = $(this).attr("data-jumlah-bayar");
        var id  = $(this).attr("data-id");
        var nofaktur1  = $(this).attr("data-no-faktur-pembelian");
        var kredit  = $(this).attr("data-kredit");
        var potongan_lama = $(this).attr("data-potongan");
        $("#potongan_lama").val(potongan_lama);
        $("#kredit_edit").val(kredit);
        $("#bayar_lama").val(jumlah_lama);
        $("#id_edit").val(id);
        $("#no_faktur_pembelian1").val(nofaktur1);

        
        
        });
        
        $("#submit_edit").click(function(){
        var jumlah_lama = $("#bayar_lama").val();
        var jumlah_baru = $("#bayar_edit").val();
        var potongan_lama = $("#potongan_lama").val();
        var potongan_baru = $("#potongan_edit").val();
        var kredit = $("#kredit_edit").val();
        var id = $("#id_edit").val();
        var nofaktur1 = $("#no_faktur_pembelian1").val();

        $.post("update_tbs_edit_pembayaran_hutang.php",{id:id,jumlah_bayar:jumlah_lama,jumlah_baru:jumlah_baru,no_faktur_pembelian:nofaktur1,kredit:kredit,potongan:potongan_lama,potongan_baru:potongan_baru},function(data){

        
        $("#alert").html(data);
        $("#result").load('tabel-tbs-edit-pembayaran-hutang.php?no_faktur_pembayaran=<?php echo $nomor_faktur_pembayaran; ?>');
        
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

    <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
      
      </script>




<?php 
include 'footer.php';
 ?>
