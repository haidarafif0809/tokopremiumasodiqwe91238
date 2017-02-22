<?php include 'session_login.php';

                  
                  //memasukkan file session login, header, navbar, db
                  include 'header.php';
                  include 'navbar.php';
                  include 'db.php';
                  include 'sanitasi.php';
                  
                  $session_id = session_id();
                  //menampilkan seluruh data yang ada pada tabel pembelian
                  $perintah = $db->query("SELECT * FROM stok_awal");
                  
                  $data1 = mysqli_fetch_array($perintah);
                  
                  $id = $data1['id'];
                  $kode_barang = $data1['kode_barang'];

                  $perintah0 = $db->query("SELECT * FROM tbs_stok_awal");
                  $data10 = mysqli_fetch_array($perintah0);
                  $k_barang = $data10['kode_barang'];
                  ?>
                  
                  
                  <!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
                  <div class="container">
                  
                  <!--membuat agar tabel berada dalam baris tertentu-->
                  <div class="row">
                  
                  
                  
                  <!-- membuat teks dengan ukuran h3 -->
                  <h3> <u>FORM STOK AWAL</u> </h3><br> 
                  


                  
                  <!-- membuat tombol agar menampilkan modal -->
                  <button type="button" class="btn btn-info" id="cari_produk_pembelian" data-toggle="modal" data-target="#myModal"> <i class='fa fa-search'> </i> Cari</button>
                  <br>
                  <br>
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
                  <span class="modal_stok_baru">
                  
                  <!-- membuat agar ada garis pada tabel, disetiap kolom-->
                  </span>
                  
                  </div> <!-- tag penutup modal body -->
                  
                  <!-- tag pembuka modal footer -->
                  <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div> <!--tag penutup moal footer -->
                  </div>
                  
                  </div>
                  </div>
                  
                  
                  <form class="form-inline" action="proses_tbs_stok_awal.php" role="form" id="formtambahproduk">

                  <div class="form-group">
                  <input type="hidden" class="form-control" name="session_id" id="session_id" value="<?php echo $session_id; ?>" placeholder="Kode Produk" autocomplete="off">
                  </div>

                  <div class="form-group">
                  <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Kode Produk" autocomplete="off">
                  </div>
                  
                  <div class="form-group"> <!-- agar tampilan berada pada satu group -->
                  <!-- memasukan teks pada kolom kode barang -->
                  <input type="text" class="form-control" name="nama_barang" readonly="" id="nama_barang" placeholder="Nama Barang">
                  </div>
                  
                  
                  <div class="form-group">
                  <input type="text" class="form-control" name="jumlah_barang" autocomplete="off" onkeydown="return numbersonly(this, event);" id="jumlah_barang" placeholder="Jumlah Awal">
                  </div>

                  <div class="form-group">
                  <input type="text" class="form-control" name="hpp" autocomplete="off" id="hpp" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="HPP">
                  </div>
                  
                  
                  
                  
                  <!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->
                  <input type="hidden" id="satuan" name="satuan" class="form-control" value="" required="">
                  <input type="hidden" id="harga_beli" name="harga_beli" class="form-control" value="" required="">

                  
                  
                  <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah Produk</button>
                  </form>

                  
                  </div><!-- end of row -->

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Tbs Stok Awal</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Barang :</label>
     <input type="text" id="hapus_barang" class="form-control" readonly=""> 
     <input type="hidden" id="kode_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> Batal</button>
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
        <h4 class="modal-title">Edit Data Tbs Stok Awal</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">

          <label> Jumlah Stok Baru </label> <br>
          <input type="text" name="jumlah_baru" id="jumlah_baru" autocomplete="off" class="form-control" required="">

          <input type="hidden" name="jumlah" id="jumlah_lama" class="form-control" readonly="" required=""> 

          <input type="hidden" name="harga" id="edit_harga" >
          
          <input type="hidden" class="form-control" id="id_edit">
          
        
   
   </div>
          <button type="submit" id="submit_edit" class="btn btn-success">Submit</button>


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

                  
                  
                  <br>
                  <br> 
                  <span id="result">  
                  
                  <div class="table-responsive">     
                  <table id="tableuser" class="table table-bordered">
                  <thead>
                  
                  <th> Kode Barang </th>
                  <th> Nama Barang </th>
                  <th> Jumlah  </th>
                  <th> Satuan </th>
                  <th> Harga </th>
                  <th> Total </th>
                  
                  <th> Hapus </th>
                  
                  </thead>
                  
                  <tbody>
                  <?php
                  
                  
                  $perintah = $db->query("SELECT s.nama AS nama_satuan,tsa.id,kode_barang,tsa.nama_barang,tsa.jumlah_awal,tsa.harga,tsa.total FROM tbs_stok_awal tsa INNER JOIN satuan s ON tsa.satuan = s.id");
                  
                  //menyimpan data sementara yang ada pada $perintah
                  while ($data1 = mysqli_fetch_array($perintah))
                  {
                  
                  
                  echo "<tr>
                  
                  <td>". $data1['kode_barang'] ."</td>
                  <td>". $data1['nama_barang'] ."</td>

                  <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_awal'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_awal']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-harga='".$data1['harga']."' data-kode='".$data1['kode_barang']."' > </td>

                  
                  <td>". $data1['nama_satuan'] ."</td>
                  <td>". rp($data1['harga']) ."</td>
                  <td><span id='text-total-".$data1['id']."'>". rp($data1['total']) ."</span></td>

                  
                  
                  <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-nama-barang='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 

                  </tr>";
                  }

                  //Untuk Memutuskan Koneksi Ke Database
                  mysqli_close($db);   

                  ?>
                  </tbody>
                  
                  </table>
                  </div>
                  </span> <!--tag penutup span-->

                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah jika ingin mengedit.</i></h6>

                  <form action="proses_selesai_stok_awal.php" role="form" id="form_selesai" method="POST">
                   
                  <br>
                  <br>

                  <button type="submit" id="selesai" class="btn btn-info"> <i class='fa fa-send'> </i> Selesai</button>
                  
                  <a href='batal_stok_awal.php?kode_barang=<?php echo $k_barang; ?>' id='batal_stok' class='btn btn-danger'><i class='fa fa-trash'></i> Hapus Stok Awal </a>

                  <a class="btn btn-info" href="form_stok_awal.php" id="transaksi_baru" style="display: none"> <i class="fa fa-refresh"></i> Transaksi Baru</a>
                  

                 </form>
                 <span id="alert-alert"> </span>

                  <br>
                  <br>
                  <label> User : <?php echo $_SESSION['user_name']; ?> </label> 
                  <!-- readonly = digunakan agar teks atau isi hanya bisa dibaca tapi tidak bisa diubah -->
                  
                  
                  

                  </div> <!-- end of container -->
                  
                  
                  
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
                  document.getElementById("satuan").value = $(this).attr('satuan');
                  document.getElementById("harga_beli").value = $(this).attr('harga_beli');
                  
                  
                  
                  
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
                  
                  var kode_barang = $("#kode_barang").val();
                  var nama_barang = $("#nama_barang").val();
                  var jumlah_awal = $("#jumlah_barang").val();
                  var satuan = $("#satuan").val();
                  var harga_beli = $("#harga_beli").val();
                  var session_id = $("#session_id").val();
                  var hpp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#hpp").val()))));

                  $("#kode_barang").val('');
                  $("#nama_barang").val('');
                  $("#jumlah_barang").val('');


                  if (jumlah_awal == ""){
                  alert("Jumlah Awal Harus Diisi");
                  }

                  else if (kode_barang == ""){
                  alert("Kode Barang Harus Diisi");
                  }

                  else if (nama_barang == ""){
                  alert("Nama Barang Harus Diisi");
                  }
                  
                  else
                  {
                  
                  $.post("cek_stok_awal.php", {kode_barang:kode_barang},function(data) {

                    if (data == 1) {
                      alert('Barang Sudah Ada di Stok Awal');
                      

                      $("#kode_barang").val('');
                      $("#nama_barang").val('');
                      $("#jumlah_barang").val('');
                      $("#hpp").val('');

                    }

                    else{
                      $.post("proses_tbs_stok_awal.php", {hpp:hpp,session_id:session_id,kode_barang:kode_barang,nama_barang:nama_barang,satuan:satuan,jumlah_awal:jumlah_awal,harga_beli:harga_beli},function(info) {
                      
                      
                      
                      $("#result").load("tabel_stok_awal.php");
                      $("#kode_barang").val('');
                      $("#hpp").val('');
                      $("#nama_barang").val('');
                      $("#jumlah_barang").val('');
                      $("#alert_berhasil").hide();
                    
                    });

                    }

                  });
                  
                  }

                  $("form").submit(function(){
                  return false;
                  });
                  
                  
                  
                  });
                  
                 
                  $("#cari_produk_pembelian").click(function() {
                
                  //menyembunyikan notif berhasil
                  $("#alert_berhasil").hide();
                  /* Act on the event */
                  
                  $.get('modal_stok_awal_baru.php', function(data) {
                  
                  $(".modal_stok_baru").html(data);
                  
                  
                  })
                  
                  });
                  
                  
                  </script>
                  
               
                  
                  <script>
                  
                  $("#selesai").click(function(){


                    $("#selesai").hide();
                    $("#transaksi_baru").show();
                    $("#batal_stok").hide();
                  
                  $.post("proses_selesai_stok_awal.php",{},function(data) {
                
                  $("#alert-alert").html(data);
                  $("#result").load("tabel_stok_awal.php");
                  $("#alert_berhasil").show();
                  $("#alert_gagal").show();
                  
                  });
                  
                  //mengambil no_faktur pembelian agar berurutan
               
                  $("form").submit(function(){
                  return false;
                  });
                  
                  
                  
                  });
                  
                                   
                  
                  </script>

                  <script type="text/javascript">
                               
                                  $(document).ready(function(){
                                  
                                  //fungsi hapus data 
                                   $(document).on('click', '.btn-hapus', function (e) {
                                  var nama_barang = $(this).attr("data-nama-barang");
                                  var kode_barang = $(this).attr("data-kode-barang");
                                  $("#hapus_barang").val(nama_barang);
                                  $("#kode_hapus").val(kode_barang);
                                  $("#modal_hapus").modal('show');
                                  
                                  
                                  });
                                  
                                  $("#btn_jadi_hapus").click(function(){
                                  
                                  var kode_barang = $("#kode_hapus").val();
                                  $.post("hapus_tbs_stok_awal.php",{kode_barang:kode_barang},function(data){

                                  if (data != '') {
                                  $("#result").load('tabel_stok_awal.php');
                                  $("#modal_hapus").modal('hide');
                                  
                                  
                                  }
                                  });                      
                                  });
                                  
                                  
                                  //end fungsi hapus data

                                  
                                  //fungsi edit data 
                                  $(".btn-edit").click(function(){
                                  
                                  $("#modal_edit").modal('show');
                                  var jumlah = $(this).attr("data-jumlah");
                                  var harga = $(this).attr("data-harga"); 
                                  var id  = $(this).attr("data-id");
                                  $("#jumlah_lama").val(jumlah);                                  
                                  $("#edit_hargahidden").val(harga);
                                  $("#id_edit").val(id);
                                  
                                  
                                  });
                                  
                                  $("#submit_edit").click(function(){
                                  
                                  var jumlah_baru = $("#jumlah_baru").val();
                                  var harga = $("#edit_harga").val();
                                  var id = $("#id_edit").val();
                            
                                  
                                  $.post("update_tbs_stok_awal.php", {jumlah_baru:jumlah_baru,harga:harga,id:id}, function(data){

                              
                                  
                                  $("#result").load('tabel_stok_awal.php');
                                  
                                  
                                  $(".modal").modal("hide");
                                   

                                  });

                                  });
                              //end function edit data
                                  
                                  
                                  
                                  
                                  });
                                  
                                  
                                  $('form').submit(function(){
                                  
                                  return false;
                                  });
                         
                                  
                                  
                             

                             </script>
     <script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){

    var session_id = $("#session_id").val();
    var kode_barang = $("#kode_barang").val();
    
    $.post('cek_kode_barang_tbs_stok_awal.php',{kode_barang:kode_barang,session_id:session_id}, function(data){
    
    if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
    }//penutup if
    
    });////penutup function(data)

      $.getJSON('lihat_stok_awal.php',{kode_barang:$(this).val()}, function(json){
      
      if (json == null)
      {
        
        $('#nama_barang').val('');
        $('#harga_beli').val('');
        $('#satuan').val('');
      }

      else 
      {
        $('#nama_barang').val(json.nama_barang);
        $('#harga_beli').val(json.harga_beli);
        $('#satuan').val(json.satuan);
      }
                                              
        });
        
        });
        });

      
      
</script>
            

  <script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var session_id = $("#session_id").val();
    var kode_barang = $("#kode_barang").val();

 $.post('cek_kode_barang_tbs_stok_awal.php',{kode_barang:kode_barang,session_id:session_id}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
   }//penutup if

    });////penutup function(data)

   $("#jumlah_barang").val(data);  
    });//penutup click(function()
  });//penutup ready(function()
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
                                    var harga = $(this).attr("data-harga");
                                    var kode_barang = $(this).attr("data-kode");
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-total-"+id+"").text()))));
                                    var subtotal = harga * jumlah_baru;

                              
                                  $.post("update_tbs_stok_awal.php", {jumlah_baru:jumlah_baru,harga:harga,id:id}, function(info){


                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-total-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");        
                                    
                                    
                                    });
                                    
                           

                                   
                                   $("#kode_barang").focus();

                                 });

                             </script>

                  
<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>