<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


$no_faktur = $_GET['no_faktur'];
//menampilkan seluruh data yang ada pada tabel pembelian
$perintah = $db->query("SELECT * FROM item_keluar WHERE no_faktur = '$no_faktur'");
$ambil = mysqli_fetch_array($perintah);   




 ?>


      <script>
      $(function() {
      $( ".tgl" ).datepicker({dateFormat: "yy-mm-dd"});
      });
      </script>



<!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
<div class="container">


<!--membuat agar tabel berada dalam baris tertentu-->
   <div class="row">
 <!--membuat tampilan halaman menjadi 8 bagian-->
         

  <!-- membuat form menjadi beberpa bagian -->
         
          
          <!-- membuat teks dengan ukuran h3 -->
          <h3> EDIT DATA ITEM KELUAR </h3><hr>

<div class="col-sm-8">


<!-- membuat tombol agar menampilkan modal -->
<button type="button" class="btn btn-info" id="cari_item_keluar1" data-toggle="modal" data-target="#myModal"> <span class='glyphicon glyphicon-search'> </span> Cari</button>
<br><br>
<!-- Tampilan Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Isi Modal-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Barang</h4>
      </div>
      <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->

   <div class="table-responsive">
   <center>                   
       <table id="table_item_keluar" class="table table-bordered table-sm">
          <thead> <!-- untuk memberikan nama pada kolom tabel -->
                          <th> Kode Barang </th>
                          <th> Nama Barang </th>
                          <th> Jumlah Barang </th>
                          <th> Kategori </th>
                          <th> Suplier </th>
                          <th> Satuan </th>
                          <th> Harga Beli</th>
              </thead> <!-- tag penutup tabel -->
            </table>
  </center>           
      </div> 
          
      </div> <!-- tag penutup modal body -->


      <!-- tag pembuka modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> <!--tag penutup moal footer -->
    </div>

  </div>
</div>


<!-- membuat form -->
 <form class="form-inline" action="proses_edit_tbs_item_keluar.php" role="form" id="formtambahproduk">
  

  <!-- agar tampilan berada pada satu group -->
  <!-- memasukan teks pada kolom kode barang -->
  <div class="form-group"> 
    <input type="text" class="form-control" name="kode_barang" id="kode_barang" autocomplete="off" placeholder="Ketikkan Kode Produk">
  </div>

<div class="form-group">
  <input type="hidden" class="form-control" name="nama_barang" id="nama_barang" readonly="" placeholder="Nama Barang">
  </div>


  <div class="form-group">
    <input type="text" class="form-control" name="jumlah_barang" id="jumlah_barang" autocomplete="off" placeholder="Jumlah Barang" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
  </div>

  
 <input type="hidden" id="jml_barang" name="jml_barang" class="form-control">
<!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->
  <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
  <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" required="">
  <input type="hidden" name="no_faktur" id="nomorfaktur1" class="form-control" value="<?php echo $no_faktur; ?>" required="" >
  
  <!-- membuat tombol submit-->
  <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah Produk</button>
</form>
 

       <span id="result">  

        <div class="table-responsive">
      <!--tag untuk membuat garis pada tabel-->     
  <table id="tableuser" class="table table-bordered table-sm">
    <thead>
      <th> Nomor Faktur </th>
      <th> Kode Barang </th>
      <th> Nama Barang </th>
      <th> Jumlah </th>
      <th> Satuan </th>
      <th> Hapus </th>
      
    </thead>
    
    <tbody>
    <?php

    //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
     $perintah = $db->query("SELECT tik.id,tik.no_faktur,tik.kode_barang,tik.nama_barang,tik.jumlah,tik.harga,tik.subtotal,s.nama FROM tbs_item_keluar tik LEFT JOIN satuan s ON tik.satuan = s.id WHERE tik.no_faktur = '$no_faktur'");

      //menyimpan data sementara yang ada pada $perintah

      while ($data1 = mysqli_fetch_array($perintah))
      {
        //menampilkan data
      echo "<tr class='tr-id-".$data1['id']."'>
     <td>". $data1['no_faktur'] ."</td>
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>


      <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah']."' class='input_jumlah' data-subtotal='".$data1['subtotal']."' data-id='".$data1['id']."' autofocus='' data-harga='".$data1['harga']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."' > </td>

      <td>". $data1['nama'] ."</td>
      <td> <button class='btn btn-danger btn-hapus' id='btn-hapus-".$data1['id']."' data-id='". $data1['id'] ."' data-subtotal='".$data1['subtotal']."' data-nama-barang='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 

      </tr>";
      }

      //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
    ?>
    </tbody>

  </table>
  </div>
</span>


  </div><!-- end of col sm 8 --> <!--tag penutup col sm 8-->

 <div class="col-sm-4" id="col_sm_4">. <!--tag pembuka col sm 4-->

<div class="card card-block">

       <form enctype="multipart/form-data" role="form" action="form_item_keluar.php" method="post ">
          <div class="row">
            <div class="col-sm-6">
              <label> Tanggal </label><br>
                <input type="text" value="<?php echo $ambil['tanggal']; ?>" name="tanggal" id="tanggal" placeholder="Tanggal"  class="form-control tgl" required="" >
            </div>
                
              

            <div class="col-sm-6">
              <label> No Faktur </label><br>

                <!-- membuat agar teks tidak bisa di ubah, dan hanya bisa dibaca -->
                <input type="text" name="no_faktur" id="nomorfaktur" class="form-control" readonly="" value="<?php echo $no_faktur; ?>" required="" >
            </div>
            </div>
      </form> 

  <form action="proses_edit_bayar_item_keluar.php" id="form_item_keluar" method="POST"><!--tag pembuka form-->

      <b><input type="hidden" name="total" id="total_item_keluar" class="form-control" placeholder="Total" readonly="" style="height: 25px; width:90%; font-size:20px;" ></b>

      <label>Keterangan </label><br>
      <textarea name="keterangan" id="keterangan" class="form-control" ></textarea>

      <br>

<input type="hidden" name="no_faktur" id="nomorfaktur" class="form-control" value="<?php echo $no_faktur; ?>">
  <input type="hidden" name="tanggal" id="tanggal_hidden" class="form-control tgl" value="<?php echo $ambil['tanggal']; ?>" >

  <!--membuat tombol submit bayar & Hutang-->

  <a class="btn btn-primary" href="item_keluar.php" id="transaksi_baru" style="display: none"> Kembali</a>

      <button type="submit" id="pembayaran_item_keluar" class="btn btn-info"><i class='fa fa-send'> </i> Selesai </a> </button>
      

      <!--membuaat link pada tombol batal-->
      <a href='batal_item_keluar.php?no_faktur=<?php echo $no_faktur;?>' id='batal' class='btn btn-danger'><i class='fa fa-remove'></i> Batal </a>
     

</form><!--tag penutup form-->

</div>

<div class="alert alert-success" id="alert_berhasil" style="display:none">
  <strong>Success!</strong> Data Item Keluar Berhasil
</div>
  </div><!-- end of col sm 4 -->
</div><!-- end of row -->
     
<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Item Hapus</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Barang :</label>
     <input type="text" id="hapus_nama" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
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
        <h4 class="modal-title">Edit Data Item Keluar</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
                  <label> Jumlah Barang Baru </label> <br>
                  <input type="text" name="jumlah_baru" id="edit_jumlah" class="form-control" autocomplete="off" required="" >

                  <label> Jumlah Barang Lama </label> <br>
                  <input type="text" name="jumlah_lama" id="edit_jumlah_lama" class="form-control" readonly="">

                  <input type="hidden" name="kode_barang" id="kode_edit">
                  <input type="hidden" name="harga" id="edit_harga">

                  <input type="hidden" class="form-control" id="id_edit">
                              
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-success">Submit</button>
  </form>

  <span id="alert"></span>
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


      <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  



      <span id="demo"> </span>

</div><!-- end of container -->


<script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $('.table').DataTable();
});

</script>

<script>
$(function() {
    $( "#kode_barang" ).autocomplete({
        source: 'kode_barang_autocomplete.php'
    });
});
</script>

<!--untuk memasukkan perintah java script-->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {
  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("satuan_produk").value = $(this).attr('satuan');
  document.getElementById("harga_produk").value = $(this).attr('harga');
  document.getElementById("jml_barang").value = $(this).attr('jumlah-barang');


  $('#myModal').modal('hide');
  });
   

// tabel lookup table_barang
  $(function () {
  $("#table_barang").dataTable();
  });



  </script>


   <script>
   //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
  $("#submit_produk").click(function(){

    var kode_barang = $("#kode_barang").val();
    var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
    var nama_barang = $("#nama_barang").val();
    var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
    var jml_barang = $("#jml_barang").val();
    var satuan = $("#satuan_produk").val();
    var harga = $("#harga_produk").val();
    var no_faktur = $("#nomorfaktur").val();
    var stok = jml_barang - jumlah_barang;

    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_keluar").val()))));

                                          
    if (total == '') 
    {
    total = 0;
    }                                         
                                          
                                          
                                          
    var sub_tbs = parseInt(harga,10) * parseInt(jumlah_barang,10);
                                          
    var subtotal = parseInt(total,10) + parseInt(sub_tbs,10);
                                          
                                          

     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');               
                                    
      if (jumlah_barang == ""){
      alert("Jumlah Barang Harus Diisi");
      }
      else if (kode_barang == ""){
      alert("Kode Harus Diisi");
      }
      else if ( stok < 0){
      
      alert ("Jumlah Melebihi Stok!");
      
      }
      
      else
      {

        $("#total_item_keluar").val(tandaPemisahTitik(subtotal));
                                    
 $.post("proses_edit_tbs_item_keluar.php",{no_faktur:no_faktur,kode_barang:kode_barang,jumlah_barang:jumlah_barang,satuan:satuan,nama_barang:nama_barang,harga:harga},function(info) {


     $("#result").html(info);
     $("#result").load("tabel_edit_item_keluar.php?no_faktur=<?php echo $no_faktur; ?>");
     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');
       
       });


      }  

      $("form").submit(function(){
      return false;
      });  


  });

//menampilkan no urut faktur setelah tombol click di pilih
   $("#cari_item_keluar1").click(function() {
     $.get('no_faktur_IK.php', function(data) {
   /*optional stuff to do after getScript */ 


 });
//menyembunyikan notif berhasil
     $("#alert_berhasil").hide();
    /* Act on the event */


  });

   </script>

   <script type="text/javascript">
     $(document).ready(function(){
        $("#table_item_keluar").DataTable().destroy();
          var dataTable = $('#table_item_keluar').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_edit_item_keluar_baru.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_item_keluar").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('data-kode', aData[0]+"("+aData[1]+")");
              $(nRow).attr('nama-barang', aData[1]);
              $(nRow).attr('satuan', aData[7]);
              $(nRow).attr('harga', aData[6]);


          }

        });  
        });
   </script>


<script>


   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#pembayaran_item_keluar").click(function(){


var total = $("#total_item_masuk").val();

if (total == ""){
alert("Tidak Ada Total Item Masuk");
}
else
{
  $("#batal").hide();
  $("#pembayaran_item_keluar").hide();
  $("#transaksi_baru").show();
                                    
 $.post($("#form_item_keluar").attr("action"), $("#form_item_keluar :input").serializeArray(), function(info) {
$("#demo").html(info);

    $("#alert_berhasil").show();
    $("#result").html("");
     $("#total_item_keluar").val('');
     $("#pembayaran_item_keluar").val('');
     
  
    
       
   });
}

 $("#form_item_keluar").submit(function(){
    return false;
});
 });


  
      
</script>

<script type="text/javascript">
      $(document).ready(function(){
      
      
      //fungsi hapus data 
      $(document).on('click', '.btn-hapus', function (e) {

      var nama_barang = $(this).attr("data-nama-barang");
      var id = $(this).attr("data-id");
    

      $.post("hapus_tbs_item_keluar.php",{id:id},function(data){
      if (data == "sukses") {

      $(".tr-id-"+id).remove();
    }

      });
      });


        $('form').submit(function(){
        
        return false;
        });
  });



</script> 

   <script type="text/javascript">
     
   $("#jumlah_barang").keyup(function(){
      var jumlah_barang = $("#jumlah_barang").val();
      var jml_barang = $("#jml_barang").val();
      var sisa_barang = parseInt(jml_barang,10) - parseInt(jumlah_barang,10);

      if (sisa_barang < 0){
        alert ("Jumlah Melebihi Stok!");
        $("#jumlah_barang").val('');
        $("#jumlah_barang").focus();

      }


  });

   </script>

<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){

          var kode_barang = $('#kode_barang').val();
          var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
          var no_faktur = $("#nomorfaktur").val();

          $.post("cek_barang_item_masuk.php",{kode_barang:kode_barang},function(data){
          $("#jml_barang"). val(data);
          });
          
          
          $.post('cek_kode_barang_edit_tbs_item_keluar.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
          
          if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          }//penutup if
          
          });////penutup function(data)


      $.getJSON('lihat_item_keluar.php',{kode_barang:kode_barang}, function(json){
      
      if (json == null)
      {
        
        $('#nama_barang').val('');
        $('#satuan_produk').val('');
        $('#harga_produk').val('');
      }

      else 
      {
        $('#nama_barang').val(json.nama_barang);
        $('#satuan_produk').val(json.satuan);
        $('#harga_produk').val(json.harga_jual);
      }
                                              
        });
        
        });
        });

      
      
</script>

<script>

$(document).ready(function(){
    $(".container").hover(function(){

      var tanggal = $("#tanggal").val();

      $("#tanggal_hidden").val(tanggal);

    });
});

</script> 

    <script type="text/javascript">
       
       $(".edit-jumlah").dblclick(function(){

          var id = $(this).attr("data-id");

          $("#text-jumlah-"+id+"").hide();

          $("#input-jumlah-"+id+"").attr("type", "text");

       });


       $(".input_jumlah").blur(function(){

          var id = $(this).attr("data-id");
          var jumlah_baru = $(this).val();
          console.log(id);
          if (jumlah_baru == "") {
            jumlah_baru = 0;
          }

          var harga = $(this).attr("data-harga");
          var kode_barang = $(this).attr("data-kode"); 
          var jumlah_lama = $("#text-jumlah-"+id+"").text();
        
        if (jumlah_baru == 0) {
             alert("Jumlah barang tidak boleh nol atau kosong");
             
             $("#input-jumlah-"+id+"").val(jumlah_lama);
             $("#text-jumlah-"+id+"").text(jumlah_lama);
             $("#text-jumlah-"+id+"").show();
             $("#input-jumlah-"+id+"").attr("type", "hidden");
        }
        else{
           $.post("cek_stok_barang.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru},function(data){

             if (data < 0) {

             alert ("Jumlah Yang Di Masukan Melebihi Stok !");

             $("#input-jumlah-"+id).val($("#text-jumlah-"+id).text());
            

           }

           else{

         
            $.post("update_jumlah_barang_tbs_item_keluar.php",{id:id,jumlah_baru:jumlah_baru,subtotal:0},function(info){

            $("#text-jumlah-"+id+"").show();
            $("#text-jumlah-"+id+"").text(jumlah_baru);
            $("#input-jumlah-"+id+"").attr("type", "hidden");       
            
            
            });
          
           }

         });
        }

         

         
         $("#kode_barang").focus();

       });

   </script>

                             
  <script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var no_faktur = $("#nomorfaktur").val();
    var kode_barang = $("#kode_barang").val();

 $.post('cek_kode_barang_edit_tbs_item_keluar.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
   }//penutup if

    });////penutup function(data)

    });//penutup click(function()
  });//penutup ready(function()
</script>   


<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>