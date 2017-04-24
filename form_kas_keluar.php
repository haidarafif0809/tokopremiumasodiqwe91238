<?php include 'session_login.php';

 include 'header.php';
 include 'navbar.php';
 include 'sanitasi.php';
  include 'db.php';
 
      $user = $_SESSION['nama'];

 $query = $db->query("SELECT * FROM kas_keluar");
 
 $session_id = session_id();

 $tbs = $db->query("SELECT tk.dari_akun,tk.ke_akun, da.nama_daftar_akun FROM tbs_kas_keluar tk INNER JOIN daftar_akun da ON tk.dari_akun = da.kode_daftar_akun WHERE tk.session_id = '$session_id' ");

 $data_tbs = mysqli_num_rows($tbs);
 $data_tbs1 = mysqli_fetch_array($tbs);
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
    $( "#tanggal1" ).datepicker({dateFormat: "yy-mm-dd"});
  });
  </script>





<div class="container">

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Kas Masuk</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Dari Akun :</label>
     <input type="text" id="hapus_dari" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
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
        <h4 class="modal-title">Edit Data Kas Keluar</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    
    <label> Jumlah Baru </label><br>
    <input type="text" name="jumlah_baru" id="jumlah_baru" autocomplete="off" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required="">

    <input type="hidden" name="jumlah" id="jumlah_lama" class="form-control" readonly="" required=""> 
          
    <input type="hidden" id="id_edit" class="form-control" > 
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-success">Submit</button>
  </form>
  <span id="alert"> </span>

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

<h3> <u>FORM KAS KELUAR</u> </h3>
<br><br>

<form action="proses_tbs_kas_keluar.php" role="form" method="post" id="formtambahproduk">
<div class="row">

					<div class="form-group col-sm-4">
					<label> Tanggal </label><br>
					<input type="text" name="tanggal" id="tanggal1" placeholder="Tanggal" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" class="form-control" required="" >
					</div>

					<div class="form-group col-sm-4">
          <label> Petugas </label>

          <input type="text" name="petugas" id="petugas" class="form-control" readonly="" value="<?php echo $user; ?>" autocomplete="off" required="" >
          <input type="hidden" name="session_id" id="session_id" class="form-control" readonly="" value="<?php echo $session_id; ?>" required="" >

					</div>

          <div class="form-group col-sm-4">
          <label> Keterangan </label><br>
          <input type="text" name="keterangan" id="keterangan" autocomplete="off" placeholder="Keterangan" class="form-control">
          </div>

         

</div> <!-- tag penutup div row -->



<div class="card card-block">

<div class="row">

<?php if ($data_tbs > 0): ?>
    
          <div class="form-group col-sm-3">
          <label> Dari Akun </label><br>
          <select type="text" name="dari_akun" id="dariakun" class="form-control" disabled="true">
          <option value="<?php echo $data_tbs1['dari_akun']; ?>"><?php echo $data_tbs1['nama_daftar_akun']; ?></option>
          <?php 
             
             
             $query = $db->query("SELECT * FROM daftar_akun WHERE tipe_akun ='Kas & Bank'");
             while($data = mysqli_fetch_array($query))
             {
             
             echo "<option value='".$data['kode_daftar_akun'] ."'>".$data['nama_daftar_akun'] ."</option>";
             }
             
             
             ?>
            </select>
          </div>


<?php else: ?>


          <div class="form-group col-sm-3">
          <label> Dari Akun </label><br>
          <select type="text" name="dari_akun" id="dariakun" class="form-control">
          <option value="">--SILAHKAN PILIH--</option>

             <?php 
             
             
             $query = $db->query("SELECT * FROM daftar_akun WHERE tipe_akun ='Kas & Bank'");
             while($data = mysqli_fetch_array($query))
             {
             
             echo "<option value='".$data['kode_daftar_akun'] ."'>".$data['nama_daftar_akun'] ."</option>";
             }
             
             
             ?>
            </select>
            </div>
<?php endif ?>   

					<div class="form-group col-sm-3">
					<label> Ke Akun </label><br>
					<select type="text" name="ke_akun" id="keakun" class="form-control" >
					<option value="">--SILAHKAN PILIH--</option>

					 <?php 

    
    $query = $db->query("SELECT * FROM daftar_akun ");
    while($data = mysqli_fetch_array($query))
    {
    
    echo "<option value='".$data['kode_daftar_akun']."'>".$data['nama_daftar_akun'] ."</option>";
    }
    
    
    ?>
   					</select>
					</div>

					<div class="form-group col-sm-3">
					<label> Jumlah </label><br>
					<input class="form-control" type="text" name="jumlah" id="jumlah" autocomplete="off" placeholder="Jumlah" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"   >
					</div>



					
					<div class="form-group col-sm-3">
					<label><br><br><br></label>
					<button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah </button>
					</div>
					
					
</div> <!-- tag penutup div row-->
  </div>
</form>

<form action="proses_kas_keluar.php" id="form_submit" method="POST"><!--tag pembuka form-->
<style type="text/css">
	.disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: false;
}
</style>

      
  <!--membuat tombol submit bayar & Hutang-->
   
     <a class="btn btn-info" href="form_kas_keluar.php" id="transaksi_baru" style="display: none"> <i class="fa fa-refresh"></i> Transaksi Baru</a>

          </form><!--tag penutup form-->
  <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
  <div class="alert alert-success" id="alert_berhasil" style="display:none">
  <strong>Success!</strong> Data Kas Keluar Berhasil
</div>

      <span id="result">  
      
<div class="table-responsive">
      <!--tag untuk membuat garis pada tabel-->     
  <table id="tableuser" class="table table-bordered">
    <thead>
      <th> Dari Akun </th>
      <th> Ke Akun </th>
      <th> Jumlah </th>
      <th> Tanggal </th>
      <th> Jam </th>
      <th> Keterangan </th>
      <th> User </th>
      <th> Hapus </th>
      
    </thead>
    
    <tbody>
    <?php

    //menampilkan semua data yang ada pada tabel tbs kas keluar dalam DB

    $perintah = $db->query("SELECT km.id, km.session_id, km.no_faktur, km.keterangan, km.ke_akun, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM tbs_kas_keluar km INNER JOIN daftar_akun da ON km.ke_akun = da.kode_daftar_akun WHERE session_id = '$session_id'");

      //menyimpan data sementara yang ada pada $perintah

      while ($data1 = mysqli_fetch_array($perintah))
      {

        $perintah1 = $db->query("SELECT km.id, km.session_id, km.no_faktur, km.keterangan, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM tbs_kas_keluar km INNER JOIN daftar_akun da ON km.dari_akun = da.kode_daftar_akun WHERE km.dari_akun = '$data1[dari_akun]'");
        $data10 = mysqli_fetch_array($perintah1);

        //menampilkan data
      echo "<tr class='tr-id-".$data1['id']."'>
      <td>". $data10['nama_daftar_akun'] ."</td>
      <td data-dari-akun ='".$data1['nama_daftar_akun']."'>". $data1['nama_daftar_akun'] ."</td>

      <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". rp($data1['jumlah']) ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah']."' class='input-jumlah' data-id='".$data1['id']."' autofocus='' data-jumlah='".$data1['jumlah']."'> </td>

      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['jam'] ."</td>
      <td>". $data1['keterangan'] ."</td>
      <td>". $data1['user'] ."</td>

      <td> <button class='btn btn-danger btn-hapus-tbs' id='btn-hapus-".$data1['id']."' data-id='". $data1['id'] ."' data-jumlah='". $data1['jumlah'] ."' data-dari='". $data1['dari_akun'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>  </td> 
      
      </tr>";
      }

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 

    ?>
    </tbody>

  </table>
  </div>
        </span>
<br><br>
 <div class="form-group col-sm-3" id="col_sm_6">
          <label> <b>Jumlah Total </b></label><br>
          <input style="height: 25px; width:90%; font-size:20px;" type="text" name="jumlah" id="jumlahtotal" readonly="" placeholder="Jumlah Total" class="form-control">
          </div>
<br>  
             <button type="submit" id="submit_kas_keluar" class="btn btn-info"> <i class='fa fa-send'> </i> Submit </a> </button>
</div> <!-- tag penutup div container -->


<script>

// untk menampilkan datatable atau filter seacrh
$(document).ready(function(){
    $("#tableuser").DataTable();
});

</script>


<script>
   //perintah javascript yang diambil dari form tbs pembelian dengan id=form tambah produk

  
   $("#submit_produk").click(function(){

   	
    var session_id = $("#session_id").val();
   	var keterangan = $("#keterangan").val();
   	var dari_akun = $("#dariakun").val();
   	var ke_akun = $("#keakun").val();
    var jumlah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah").val()))));
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlahtotal").val()))));
   	var tanggal = $("#tanggal1").val();


        if (total == '') 
        {
          total = 0;
        }
        else if(jumlah == '')
        {
          jumlah = 0;
        };
        var subtotal = parseInt(total,10) + parseInt(jumlah,10);


     $("#keakun").val('');
     $("#jumlah").val('');
     $("#keterangan").val('');

if (ke_akun == "") {

alert('Data Ke Akun Harus Di Isi');

}
else if (dari_akun == "") {

alert('Data Dari Akun Harus Di Isi');

}

else if (jumlah == "")
{

	alert('Data Jumlah Harus Di Isi');
}
else {


  $("#jumlahtotal").val(tandaPemisahTitik(subtotal))

	$.post("proses_tbs_kas_keluar.php", {session_id:session_id,keterangan:keterangan,dari_akun:dari_akun,ke_akun:ke_akun,jumlah:jumlah,tanggal:tanggal}, function(info) {

      
     $("#result").html(info);
     $("#result").load("tabel_kas_keluar.php");
     $("#keakun").val('');
     $("#jumlah").val('');
     $("#keterangan").val('');
     $("#result").load('tabel_kas_keluar.php');
       
   });
}


      $("#formtambahproduk").submit(function(){
      return false;
      });
      
var dari_akun = $("#dariakun").val();

if (dari_akun != ""){
$("#dariakun").attr("disabled", true);
}


  });

</script>

<script type="text/javascript">
  
  $(document).ready(function(){

  $("#keakun").change(function(){

          var keakun = $("#keakun").val();
          var session_id = $("#session_id").val();
          var dariakun = $("#dariakun").val();
          
          $.post("cek_tbs_kas_keluar.php",{session_id:session_id,keakun:keakun, dariakun:dariakun},function(data){
          if (data == "ya") {
          
            alert("Akun Sudah Ada, Silakan Pilih Akun lain!");
            $("#keakun").val('');
          }
          else{
          
          }

});

        });
});

</script>

<script>

$(document).ready(function(){
  var session_id = $("#session_id").val();
$.post("cek_jumlah_kas_keluar.php",
    {
        session_id: session_id
    },
    function(data){
        $("#jumlahtotal").val(data);
    });

});


</script>


<script>
 

  
   $("#submit_kas_keluar").click(function(){


    var session_id = $("#session_id").val();
   	var no_faktur = $("#nomorfaktur1").val();
   	var keterangan = $("#keterangan").val();
   	var dari_akun = $("#dariakun").val();
    var jumlah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlahtotal").val()))));
   	var tanggal = $("#tanggal1").val();
    


         $("#dariakun").val('');
         $("#keakun").val('');
         $("#jumlah").val('');
         $("#keterangan").val('');
         $("#jumlahtotal").val('');


    if (jumlah == "") {

      alert("Tidak Ada Kas Yang Di Keluarkan");

    }
    else if(dari_akun == ""){

      alert("Dari Akun Harus Diisi");
    }

    else
      {
        $("#transaksi_baru").show();
        $("#submit_kas_keluar").hide();

         $.post("proses_kas_keluar.php", {session_id:session_id,no_faktur:no_faktur,dari_akun:dari_akun,jumlah:jumlah,tanggal:tanggal}, function(info) {
         
         $("#alert_berhasil").show();
         $("#result").html(info);
         $("#dariakun").val('');
         $("#keakun").val('');
         $("#jumlah").val('');
         $("#keterangan").val('');
         $("#jumlahtotal").val('');
        });
         $("#form_submit").submit(function(){
         return false;
         });

    }      



  
 });

     
   $("#submit_kas_keluar").mouseleave(function(){

          $.get('no_faktur_KK.php', function(data) {
   /*optional stuff to do after getScript */ 

$("#nomorfaktur1").val(data);
 });
          var dari_akun = $("#dariakun").val();
          if (dari_akun == ""){
          	$("#dariakun").attr("disabled", false);

          }

         
 });
  
</script>

<script>
	
$("#keakun").focus(function(){

$("#alert_berhasil").hide();

});

</script>




<script>
$(document).ready(function(){
    $("#keakun").change(function(){
      var dari_akun = $("#dariakun").val();
      var ke_akun = $("#keakun").val();

if (ke_akun == dari_akun)
{

alert("Nama Akun Tidak Boleh Sama");
    $("#keakun").val('');  
}
        
    });
});
</script>

<script>
$(document).ready(function(){
    $("#dariakun").change(function(){
      var dari_akun = $("#dariakun").val();
      var ke_akun = $("#keakun").val();

if (ke_akun == dari_akun)
{

alert("Nama Akun Tidak Boleh Sama");
    $("#dariakun").val('');  
}
        
    });
});
</script>


                             


                              <script type="text/javascript">
                               
                                  $(document).ready(function(){
                                  
                                  //fungsi hapus data 
                                  $(".btn-hapus-tbs").click(function(){
                                  var id = $(this).attr("data-id");
                                  var jumlah = $(this).attr("data-jumlah");
                                  var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlahtotal").val()))));
                                 

                                  
                                  if (total == '') 
                                  {
                                  total = 0;
                                  }
                                  else if(jumlah == '')
                                  {
                                  jumlah = 0;
                                  };
                                  var subtotal = parseInt(total,10) - parseInt(jumlah,10);
                                  
                                  
                                  if (subtotal == 0) 
                                  {
                                  subtotal = 0;
                                  $("#dariakun").attr("disabled", false);
                                  }



                                  $("#jumlahtotal").val(tandaPemisahTitik(subtotal))


                                  $.post("hapus_tbs_kas_keluar.php",{id:id},function(data){

                                  if (data != '') {
                                  $(".tr-id-"+id+"").remove();
                                  }


         
                                  });
                                  
                                  });
                                  
                                  
                                  //end fungsi hapus data

                                  
                                  $('form').submit(function(){
                                  
                                  return false;
                                  });
                                  });
                                  
                                  
                                  function tutupalert() {
                                  $("#alert").html("")
                                  }
                                  
                                  function tutupmodal() {
                                  $("#modal_edit").modal("hide")
                                  }
                                  
                                  </script>
                                    
                                    
                                    <script type="text/javascript">
                                    
                                    $(".edit-jumlah").dblclick(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    
                                    var input_jumlah = $("#text-jumlah-"+id+"").text();
                                    
                                    $("#text-jumlah-"+id+"").hide();
                                    
                                    $("#input-jumlah-"+id+"").attr("type", "text");
                                    
                                    });
                                    
                                    $(".input-jumlah").blur(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    var input_jumlah = $(this).val();
                                    
                                    var jumlah_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-jumlah")))));
                                    var total_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlahtotal").val()))));
                                    
                                    
                                    
                                    if (total_lama == '') 
                                    {
                                    total_lama = 0;
                                    }
                                    
                                    var subtotal = parseInt(total_lama,10) - parseInt(jumlah_lama,10) + parseInt(input_jumlah,10);
                                    
                                    
                                    
                                    $.post("update_tbs_kas_keluar.php",{id:id, input_jumlah:input_jumlah,jenis_edit:"jumlah"},function(data){
                                    
                                  $("#input-jumlah-"+id).attr("data-jumlah", input_jumlah);
                                    $("#btn-hapus-"+id).attr("data-jumlah", input_jumlah);
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(tandaPemisahTitik(input_jumlah));

                                    $("#jumlahtotal").val(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");           
                                    
                                    });
                                    
                                    
                                    
                                    });
                                    
                                    </script>


<?php include 'footer.php'; ?>