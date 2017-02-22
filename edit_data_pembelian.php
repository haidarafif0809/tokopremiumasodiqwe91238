<?php include 'session_login.php';

    
    //memasukkan file session login, header, navbar, db
    include 'header.php';
    include 'navbar.php';
    include 'db.php';
    include 'sanitasi.php';
    
    //menampilkan seluruh data yang ada pada tabel pembelian
    $perintah = $db->query("SELECT * FROM pembelian");
    
    //menampilkan seluruh data yang ada pada tabel pembelian secara berurutan dari yang terbesar ke yang terkecil berdasarkan id
    $query1 = $db->query("SELECT * FROM pembelian ORDER BY id DESC LIMIT 1");
    
    //menyimpan data sementara yang ada pada $query1
    $data1 = mysqli_fetch_array($query1);
    
    //mengambil dan menyimpan data id ke variabel ($nomor_terakhir)
    $nomor_terakhir = $data1['id'];
    
    //mengambil dan menyimpan data $nomor terakhir + 1 ke $nomor_faktur
    $nomor_faktur = $nomor_terakhir + 1;
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
    $( "#tanggal_jt" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>
    
    
    <!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
    <div class="container">
    
    
    <!--membuat agar tabel berada dalam baris tertentu-->
    <div class="row">

 <!--membuat tampilan halaman menjadi 8 bagian-->


  <!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="formpembelian.php" method="post ">
					
          <!-- membuat teks dengan ukuran h3 -->
          <h3> Tambah Data Pembelian </h3><br> 
          <label> No Faktur </label><br>
          
          <!-- membuat agar teks tidak bisa di ubah, dan hanya bisa dibaca -->
          <input type="text" name="no_faktur" id="nomorfaktur" class="form-control" readonly="" value="BL/<?php echo $nomor_faktur; ?>" required="" >
          
          
          <label> Suplier </label><br>
          
          <select name="suplier" id="nama_suplier" class="form-control" required="" >
          <option value="">Silahkan Pilih</option>
          <?php 
          
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM suplier");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option>".$data['nama'] ."</option>";
          }
          
          
          ?>
          </select>
          
          
          
        

  </form> <!-- tag penutup form -->
        
   
        
        <!-- membuat tombol agar menampilkan modal -->
        <button type="button" class="btn btn-info btn-lg" id="cari_produk_pembelian" data-toggle="modal" data-target="#myModal">Cari</button>
        <br><br>
        <!-- Tampilan Modal -->
        <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
        
        <!-- Isi Modal-->
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Barang</h4>
        </div>
        <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
        
        <!--perintah agar modal update-->
        <span class="modal_baru">
        
        <!-- membuat agar ada garis pada tabel, disetiap kolom-->
        <table id="tableuser" class="table table-bordered">
        <thead> <!-- untuk memberikan nama pada kolom tabel -->
        
        <th> Kode Barang </th>
        <th> Nama Barang </th>
        <th> Harga Beli </th>
        <th> Harga Jual </th>
        <th> Jumlah Barang </th>
        <th> Satuan </th>
        <th> Status </th>
        <th> Suplier </th>
        
        </thead> <!-- tag penutup tabel -->
        
        <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
        <?php
        
        // menampilkan seluruh data yang ada pada tabel barang yang terdapat pada DB
        $perintah = $db->query("SELECT * FROM barang");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr class='pilih' data-kode='". $data1['kode_barang'] ."' nama-barang='". $data1['nama_barang'] ."'
      satuan='". $data1['satuan'] ."' harga='". $data1['harga_beli'] ."'>
      
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>
      <td>". $data1['harga_beli'] ."</td>
      <td>". $data1['harga_jual'] ."</td>
      <td>". $data1['jumlah_barang'] ."</td>
      <td>". $data1['satuan'] ."</td>
      <td>". $data1['status'] ."</td>
      <td>". $data1['suplier'] ."</td>
      </tr>";
      
       }

?>


    </tbody> <!--tag penutup tbody-->

  </table> <!-- tag penutup table-->

</span>
        	
</div> <!-- tag penutup modal body -->
        
        <!-- tag pembuka modal footer -->
        <div class="modal-footer">
       
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> <!--tag penutup moal footer -->
        </div>
        
        </div>
        </div>
        
        
        <form class="form-inline" action="prosestbspembelian.php" role="form" id="formtambahproduk">
        
        <div class="form-group">
        <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Kode Produk">
        </div>
        
        <div class="form-group"> <!-- agar tampilan berada pada satu group -->
        <!-- memasukan teks pada kolom kode barang -->
        <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang">
        </div>
        
        
        <div class="form-group">
        <input type="number" class="form-control" name="jumlah_barang" id="jumlah_barang" autocomplete="off" placeholder="Jumlah Barang">
        </div>
        
        <div class="form-group">
        <input type="text" class="form-control" name="potongan" autocomplete="off" id="potongan1" placeholder="Potongan" >
        </div>
        
        <div class="form-group">
        <input type="text" class="form-control" name="tax" autocomplete="off" id="tax1" placeholder="Tax" >
        </div>
        
        <div class="form-group">
        <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">
        </div>
        
        
        <!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->
        <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
        <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" required="">
        <input type="hidden" name="no_faktur" class="form-control" value="BL/<?php echo $nomor_faktur; ?>" required="" >
  
  <!-- membuat tombol submit-->
  <button type="submit" id="submit_produk" class="btn btn-success">Tambah Produk</button>
  </form>
									




  
      <!--Mendefinisikan sebuah bagian dalam dokumen-->  
      <span id="result">	

  <div class="table-responsive"><!--tag untuk membuat garis pada tabel-->    		
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
      <th> Hapus </th>
      <th> Edit </th>
      
    </thead>
    
    <tbody>
    <?php

    //untuk menampilkan semua data yang ada pada tabel tbs pembelian dalam DB
    $perintah = $db->query("SELECT * FROM detail_pembelian 
                WHERE no_faktur = 'BL/$nomor_faktur'");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr>
      <td>". $data1['no_faktur'] ."</td>
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>
      <td>". $data1['jumlah_barang'] ."</td>
      <td>". $data1['satuan'] ."</td>
      <td>". rp($data1['harga']) ."</td>
      <td>". rp($data1['subtotal']) ."</td>
      <td>". rp($data1['potongan']) ."</td>
      <td>". persen($data1['tax']) ."</td>

      <td> <a href='hapustbs_pembelian.php?id=". $data1['id']."&kode_barang=". $data1['kode_barang']."' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span> Hapus </a> </td> 
      <td> <a href='edittbs_pembelian.php?id=". $data1['id']."&harga=". $data1['harga']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit </a> </td>
      </tr>";
      }

      //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
    ?>
    </tbody>

  </table>
  </div>
	</span> <!--tag penutup span-->




<form action="proses_bayar_beli.php" id="form_beli" method="POST"><!--tag pembuka form-->
<style type="text/css">
  .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: false;
}
</style>


          <label> Total </label><br>
          <!--readonly = agar tek yang ada kolom total tidak bisa diubah hanya bisa dibaca-->
          <input type="text" name="total" id="total_pembelian" class="form-control" placeholder="Total" readonly=""  >
          
          <input type="hidden" name="total" id="total_pembelian1" class="form-control" placeholder="Total" readonly=""  >
          
          <label> Cara Bayar </label><br>
          <select type="text" name="cara_bayar" id="carabayar1" class="form-control"  required="" >
          <option> Silahkan Pilih </option>
          <?php 
          
          
          $query = $db->query("SELECT * FROM kas ");
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option>".$data['nama'] ."</option>";
          }
          
          
          ?>
          
          </select>
          
          <label> Potongan ( Rp ) </label><br>
          <input type="text" name="potongan" id="potongan_pembelian" class="form-control" autocomplete="off" placeholder="Potongan Rp">

          <label> Potongan ( % ) </label><br>
          <input type="text" name="potongan_persen" id="potongan_persen" class="form-control" autocomplete="off" placeholder="Potongan %">
          
          <label> Tax </label><br>
          <input type="text" name="tax" id="tax" class="form-control" autocomplete="off" placeholder="Tax" >
          
          <label> Pembayaran </label><br>
          <input type="text" name="pembayaran" id="pembayaran_pembelian" autocomplete="off" class="form-control" placeholder="Pembayaran" required="">
          
          <label> Sisa Pembayaran </label><br>
          <input type="text" name="sisa_pembayaran" id="sisa_pembayaran_pembelian" class="form-control" placeholder="Sisa Pembayaran" readonly="" >

          <label> Tanggal Jatuh Tempo </label><br>
          <input type="text" name="tanggal_jt" id="tanggal_jt" placeholder="Tanggal Jatuh Tempo" value="" class="form-control" >
          <br>
          <br>
          
          <input type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah">  
          
          
          
          
          <!-- memasukan teks pada kolom suplier, dan nomor faktur namun disembunyikan -->
          <input type="hidden" name="no_faktur" class="form-control" value="BL/<?php echo $nomor_faktur; ?>" required="" >
          
          <input type="hidden" name="suplier" id="supplier" class="form-control" required="" >
          
          
          <br>
          
          <!--membuat tombol submit bayar & Hutang-->
          <button type="submit" id="pembayaran" class="btn btn-info">Bayar</button>
          <button type="submit" id="hutang" class="btn btn-warning">Hutang</button>
          
          <!--membuaat link pada tombol batal-->
          <a href='batal_pembelian.php?no_faktur=BL/<?php echo $nomor_faktur;?>' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span> Batal </a>
     

</form><!--tag penutup form-->
<div class="alert alert-success" id="alert_berhasil" style="display:none">
<strong>Success!</strong> Pembayaran Berhasil
</div>

</div><!-- end of row -->     

<br>
<br>
<label> User : <?php echo $_SESSION['user_name']; ?> </label> 
          <!-- readonly = digunakan agar teks atau isi hanya bisa dibaca tapi tidak bisa diubah -->
  

<span id="demo"> </span>

</div><!-- end of container -->


    
<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $(".table").DataTable();


});
  
</script>
<!-- untuk memasukan perintah javascript -->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {
  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("satuan_produk").value = $(this).attr('satuan');
  document.getElementById("harga_produk").value = $(this).attr('harga');
  document.getElementById("jumlahbarang").value = $(this).attr('jumlah-barang');

  
  $('#myModal').modal('hide');
  });
   

// tabel lookup table_barang
  $(function () {
  $("#table_barang").dataTable();
  });

   
  </script> <!--tag penutup perintah java script-->


   <script>
   //perintah javascript yang diambil dari form tbs pembelian dengan id=form tambah produk
    
  
   $("#submit_produk").click(function(){

    var jumlah_barang = $("#jumlah_barang").val();
    var jumlahbarang = $("#jumlahbarang").val();
    var suplier = $("#nama_suplier").val();
    



if (jumlah_barang == ""){
  alert("Jumlah Barang Harus Diisi");
}
else if (suplier == ""){
alert("Suplier Harus Dipilih");
  }

else
{


    $.post($("#formtambahproduk").attr("action"), $("#formtambahproduk :input").serializeArray(), function(info) {


       $("#result").html(info);
       $("#kode_barang").val('');
       $("#nama_barang").val('');
       $("#jumlah_barang").val('');
       $("#potongan1").val('');
       $("#tax1").val('');
       
       
   });
 
}
      $("#formtambahproduk").submit(function(){
    return false;
});
    
    

  });

            $("#submit_produk").mouseleave(function(){

            var suplier = $("#nama_suplier").val();
            
            if (suplier != ""){
            $("#nama_suplier").attr("disabled", true);
            }
            
            
            var no_faktur = $("#nomorfaktur").val();
            
            $.post("cek_total_pembelian.php",
            {
            no_faktur: no_faktur
            },
            function(data){
            $("#total_pembelian"). val(data);
            $("#total_pembelian1"). val(data);
            });
            
            
            });


     $("#cari_produk_pembelian").click(function() {

     $.get('no_faktur_bl.php', function(data) {
     /*optional stuff to do after getScript */ 
     $("#nomorfaktur").val(data);
     });
     //menyembunyikan notif berhasil
     $("#alert_berhasil").hide();
     /* Act on the event */

     var suplier = $("#nama_suplier").val();
     
     $.post("modal_beli_baru.php",{suplier:suplier},function(data) {
     
     $(".modal_baru").html(data);
     
     
     });
     
     });

     
      
</script>

 <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#pembayaran").click(function(){

       var no_faktur = $("#nomorfaktur").val();
       var sisa_pembayaran = $("#sisa_pembayaran_pembelian").val();
       var suplier1 = $("#nama_suplier").val();
       var tanggal_jt = $("#tanggal_jt").val();
       var total = $("#total_pembelian").val();
       var potongan = $("#potongan_pembelian").val();
       var potongan_persen = $("#potongan_persen").val();
       var tax = $("#tax").val();
       var cara_bayar = $("#carabayar1").val();
       var pembayaran = $("#pembayaran_pembelian").val();
      
       var sisa = total - pembayaran;


 if (sisa_pembayaran < 0)
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }


 else if (suplier1 == "") 
 {

alert("Suplier Harus Di Isi");

 }
else if (pembayaran == "") 
 {

alert("Pembayaran Harus Di Isi");

 }

 else

 {

 $.post("proses_bayar_beli.php",{no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,suplier:suplier1,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa},function(info) {

$("#demo").html(info);

    $("#alert_berhasil").show();
     $("#total_pembelian").val('');
     $("#pembayaran_pembelian").val('');
     $("#sisa_pembayaran_pembelian").val('');
     $("#potongan_pembelian").val('');
     $("#potongan_persen").val('');
     $("#nama_suplier").val('');
    
       
   });

// #result didapat dari tag span id=result
$("#result").load("tabel_pembelian.php");
//mengambil no_faktur pembelian agar berurutan


 }


 $("form").submit(function(){
    return false;
});

    

  });
            
             $("#pembayaran").mouseleave(function(){

          $.get('no_faktur_bl.php', function(data) {
   /*optional stuff to do after getScript */ 

$("#nomorfaktur").val(data);
 });
          var suplier = $("#nama_suplier").val();
          if (suplier == ""){
            $("#nama_suplier").attr("disabled", false);
          }
        
 });
            
  
      
  </script>

   <script>
       //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
       $("#hutang").click(function(){
       
       var no_faktur = $("#nomorfaktur").val();
       var sisa_pembayaran = $("#sisa_pembayaran_pembelian").val();
       var suplier = $("#nama_suplier").val();
       var tanggal_jt = $("#tanggal_jt").val();
       var total = $("#total_pembelian").val();
       var potongan = $("#potongan_pembelian").val();
       var potongan_persen = $("#potongan_persen").val();
       var tax = $("#tax").val();
       var cara_bayar = $("#carabayar1").val();
       var pembayaran = $("#pembayaran_pembelian").val();
       
       var sisa = total - pembayaran; 


       
      if (sisa_pembayaran == "" )
      {

        alert ("Jumlah Pembayaran Tidak Mencukupi");
      }

       else if (suplier == "") 
       {
       
       alert("Suplier Harus Di Isi");
       
       }
       else if (tanggal_jt == "")
       {

        alert ("Tanggal Jatuh Tempo Harus Di Isi");

       }
       
       else
       {
       
       $.post("proses_bayar_beli.php",{no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,suplier:suplier,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa},function(info) {

       $("#demo").html(info);
       
       $("#alert_berhasil").show();
       $("#total_pembelian").val('');
       $("#pembayaran_pembelian").val('');
       $("#sisa_pembayaran_pembelian").val('');
       $("#potongan_pembelian").val('');
       $("#potongan_persen").val('');
       $("#tanggal_jt").val('');
       
       
       
       });
        // #result didapat dari tag span id=result
       $("#result").load("tabel_pembelian.php");
       
       }  
       //mengambil no_faktur pembelian agar berurutan

       });
 $("form").submit(function(){
       return false;
       });

      
  </script>





<script type="text/javascript">

// perintah javascript yang diambil dari form tbs pembelian dengan id=total_pembelian
$("#kode_barang").focus(function(){

$.post("cek_total_pembelian.php",
    {
        no_faktur: "BL/<?php echo $nomor_faktur; ?>"
    },
    function(data){
        $("#total_pembelian"). val(data);
    });




});


// untuk memunculkan data cek total pembelian
$(document).ready(function(){
$.post("cek_total_pembelian.php",
    {
        no_faktur: "BL/<?php echo $nomor_faktur; ?>"
    },
    function(data){
        $("#total_pembelian"). val(data);
        $("#total_pembelian1"). val(data);
    });

});


</script>

<script type="text/javascript">




// untuk memunculkan data cek total pembelian
$(document).ready(function(){
$.post("cek_total_pembelian.php",
    {
        no_faktur: "BL/<?php echo $nomor_faktur; ?>"
    },
    function(data){
        $("#total_pembelian"). val(data);
    });

});


</script>

<script>

// untuk memunculkan sisa pembayaran secara otomatis
  $(document).ready(function(){
    $("#pembayaran_pembelian").blur(function(){
      var pembayaran = $("#pembayaran_pembelian").val();
      var total = $("#total_pembelian").val();
      var sisa = pembayaran - total;

      $("#sisa_pembayaran_pembelian").val(sisa);
    });
  });
</script>




<!--membuat menampilkan no faktur dan suplier pada tax-->
<script>

$(document).ready(function(){
    $("#nama_suplier").change(function(){
      var suplier = $("#nama_suplier").val();
      $("#supplier").val(suplier);
        
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
    $("#pembayaran_pembelian").keyup(function(){
      var jumlah = $("#pembayaran_pembelian").val();
      var jumlah_kas = $("#jumlah1").val();
      var sisa = jumlah_kas - jumlah;
      var carabayar1 = $("#carabayar1").val();

 $.post('sanitasi_angka.php', {angka:jumlah}, function(data) {
  $('#pembayaran_pembelian').val(data);




 });
 });

$("#pembayaran_pembelian").keyup(function(){
      var jumlah = $("#pembayaran_pembelian").val();
      var jumlah_kas = $("#jumlah1").val();
      var sisa = jumlah_kas - jumlah;
      var carabayar1 = $("#carabayar1").val();

       if (sisa < 0 || carabayar1 == "") 

      {
          $("#submit").hide();
        alert("Jumlah Kas Tidak Mencukupi Atau Kolom Cara Bayar Masih Kosong");

      }
      else {
        $("#submit").show();
      }
});

  });
</script>

      <script>
      

      $(document).ready(function(){
      $("#potongan_persen").keyup(function(){
      var potongan_persen = $("#potongan_persen").val();
      var total = $("#total_pembelian1").val();
      var potongan_rp = ((total * potongan_persen) / 100);
      var sisa_potongan = total - potongan_rp;
             
             if (potongan_rp != ""){
             $("#potongan_pembelian").attr("disabled", true);
             }
             
      $("#total_pembelian").val(sisa_potongan);
      $("#potongan_pembelian").val(potongan_rp);

      });
      });

      $(document).ready(function(){
      $("#potongan_pembelian").keyup(function(){
      var potongan_pembelian = $("#potongan_pembelian").val();
      var total = $("#total_pembelian1").val();
      var potongan_persen = ((potongan_pembelian / total) * 100);
      var sisa_potongan = total - potongan_persen;
      
             if (potongan_persen != ""){
             $("#potongan_persen").attr("disabled", true);
             }

      $("#total_penjualan").val(sisa_potongan);
      $("#potongan_persen").val(potongan_persen);
      });
      });
 

      </script>
      
      
      
      <script type="text/javascript">
      $(document).ready(function(){
      $("#tax").blur(function(){

      var potongan = $("#potongan_pembelian").val();
      var tax = $("#tax").val();
      var total = $("#total_pembelian1").val();
      var pajak_tax = ((total * tax) / 100);
      var sisa_potongan = total + pajak_tax;


      $("#total_pembelian").val(sisa_potongan);
      

      
      $.post("cek_tax.php", {potongan:potongan,total:total,tax:tax}, function(data) {
      
      $('#total_pembelian').val(data);
      
      
      });
      });
      });
      
      </script>

                             <script type="text/javascript">
                             $(document).ready(function(){
                             $("#jumlah_barang").keyup(function(){
                             var jumlah = $("#jumlah_barang").val();
                             
                             $.post('sanitasi_angka.php', {angka:jumlah}, function(data) {
                             $('#jumlah_barang').val(data);
                             
                             
                             });
                             });
                             });
                             </script>
                             
                             <script type="text/javascript">
                             $(document).ready(function(){
                             $("#potongan_pembelian").keyup(function(){
                             var jumlah = $("#potongan_pembelian").val();
                             
                             $.post('sanitasi_angka.php', {angka:jumlah}, function(data) {
                             $('#potongan_pembelian').val(data);
                             
                             
                             });
                             });
                             });
                             
                             </script>

                             <script type="text/javascript">
                             $(document).ready(function(){
                             $("#tax").keyup(function(){
                             var jumlah = $("#tax").val();
                             
                             $.post('sanitasi_angka.php', {angka:jumlah}, function(data) {
                             $('#tax').val(data);
                             
                             
                             });
                             });
                             });
                             
                             </script>

                             <script type="text/javascript">
                             $(document).ready(function(){
                             $("#kode_barang").keyup(function(){
                             var jumlah = $("#kode_barang").val();
                             
                             $.post('sanitasi_string.php', {string:jumlah}, function(data) {
                             $('#kode_barang').val(data);
                             
                             
                             });
                             });
                             });
                             
                             </script>


                             <script type="text/javascript">
                             $(document).ready(function(){
                             $("#nama_suplier").keyup(function(){
                             var jumlah = $("#nama_suplier").val();
                             
                             $.post('sanitasi_string.php', {string:jumlah}, function(data) {
                             $('#nama_suplier').val(data);
                             
                             
                             });
                             });
                             });
                             
                             </script>

                             </script>


                             <script type="text/javascript">
                             $(document).ready(function(){
                             $("#nama_barang").keyup(function(){
                             var nama_barang = $("#nama_barang").val();
                             
                             $.post('sanitasi_string.php', {string:nama_barang}, function(data) {
                             $('#nama_barang').val(data);
                             
                             
                             });
                             });
                             });
                             
                             </script>

<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>

