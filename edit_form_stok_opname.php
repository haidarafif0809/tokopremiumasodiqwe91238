<?php include 'session_login.php';

                  
                  //memasukkan file session login, header, navbar, db
                  include 'header.php';
                  include 'navbar.php';
                  include 'db.php';
                  include 'sanitasi.php';
                  
                  $no_faktur = $_GET['no_faktur'];
                  $tanggal = $_GET['tanggal'];

                  ?>



                  <script>
                  $(function() {
                  $( "#tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
                  });
                  </script>
                  
                  
                  <!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
                  <div class="container">

                  <div id="modal_alert" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h3 style="color:orange" class="modal-title"><span class="glyphicon glyphicon-info-sign">Info</span></h3>
                          
                        </div>

                        <div class="modal-body">
                        <div class="table-responsive">
                        <span id="modal-alert">
                         </span>
                        </div>

                       </div>

                        <div class="modal-footer">
                          <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data, 
                          silahkan hapus terlebih dahulu<br> Transaksi Penjualan.</i></h6>
                          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        </div>
                      </div>

                    </div>
                  </div>
                  
                  <!--membuat agar tabel berada dalam baris tertentu-->
                  <div class="row">
                  
                  
                  <form class="form-inline" enctype="multipart/form-data" role="form" action="form_item_masuk.php" method="post ">
                  
                  <!-- membuat teks dengan ukuran h3 -->
                  <h3>Edit Stok Opname</h3><br> 
               
                  <div class="form-group">
                  <input type="text" name="no_faktur" id="nomorfaktur" class="form-control" readonly="" value="<?php echo $no_faktur; ?>" required="" >
                  </div>

                  <div class="form-group">
                   <input type="text" name="user" class="form-control" id="user" readonly="" value="<?php echo $_SESSION['user_name']; ?>" required="">
                   </div>

                   <div class="form-group">
                  <input type="text" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo $tanggal; ?>" class="form-control" required="" >
                  </div>
                  
                  </form>

                  <!-- membuat teks dengan ukuran h3 -->
                  
                  
                  <br>
                  <br><br>
                  <!-- membuat tombol agar menampilkan modal -->
                  <button type="button" class="btn btn-info" id="cari_produk_pembelian" data-toggle="modal" data-target="#myModal"> <span class='glyphicon glyphicon-search'> </span> Cari</button>
                  <br>
                  <br>
                  <!-- Tampilan Modal -->
                  <div id="myModal" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-lg">
                  
                  <!-- Isi Modal-->
                  <div class="modal-content">
                  <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"> Data Barang</h4>
                  </div>
                  <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
                  
                  <!--perintah agar modal update-->
                  <span class="modal_stok_baru">
                  

                  </span>
                  
                  </div> <!-- tag penutup modal body -->
                  
                  <!-- tag pembuka modal footer -->
                  <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div> <!--tag penutup moal footer -->
                  </div>
                  
                  </div>
                  </div>
                  
                  
                  <form class="form-inline" action="proses_tbs_stok_opname.php" role="form" id="formtambahproduk">
                  
                  <div class="form-group">
                  <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Kode Produk" autocomplete="off">
                  </div>
                  
                  <div class="form-group"> <!-- agar tampilan berada pada satu group -->
                  <!-- memasukan teks pada kolom kode barang -->
                  <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" readonly="">
                  </div>
                  
                  
                  <div class="form-group">
                  <input type="text" onkeydown="return numbersonly(this, event);" class="form-control" name="fisik" autocomplete="off" id="jumlah_fisik" placeholder="Jumlah Fisik">
                  </div>
                  
                  
                  
                  
                  <!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->

                  <input type="hidden" id="satuan" name="satuan" class="form-control" value="" required="">

                  <div class="form-group">
                  <input type="hidden" name="no_faktur" id="nomorfaktur1" class="form-control" value="<?php echo $no_faktur; ?>" required="" >
                  </div>

                  
                  
                  <button type="submit" id="submit_produk" class="btn btn-success"> <span class='glyphicon glyphicon-plus'> </span> Tambah Produk</button>
                  </form>
                  
                  
                  </div><!-- end of row -->

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Tbs Stok Opname</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Barang :</label>
     <input type="text" id="hapus_barang" class="form-control" readonly="">
     <input type="hidden" id="hapus_kode" class="form-control" >
     
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
        <h4 class="modal-title">Edit Data Tbs Stok Awal</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">

          <label> Jumlah Fisik Baru</label> <br>
          <input type="text" name="jumlah_baru" id="jumlah_baru" class="form-control" required="" >

          <input type="hidden" name="fisik" id="jumlah_lama" class="form-control" required="" >
          
          <input type="hidden" name="selisih_fisik" id="selisih_fisik" class="form-control" required="" >

          <input type="hidden" name="selisih_harga" id="selisih_harga" class="form-control" required="" >

          <input type="hidden" name="kode_barang" id="kode_edit" class="form-control" required="" >

          <input type="hidden" name="hpp" id="hpp" >
          
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
                  
                  <th> Nomor Faktur </th>
                  <th> Kode Barang </th>
                  <th> Nama Barang </th>
                  <th> Satuan </th>
                  <th> Stok Komputer </th>
                  <th> Jumlah Fisik </th>
                  <th> Selisih Fisik </th>
                  <th> Hpp </th>
                  <th> Selisih Harga </th>
                  <th> Harga </th>
                  <th> Hapus </th>
                  
                  </thead>
                  
                  <tbody>
                  <?php
                  
                  
                  $perintah = $db->query("SELECT * FROM tbs_stok_opname WHERE no_faktur = '$no_faktur'");
                  
                  //menyimpan data sementara yang ada pada $perintah
                  while ($data1 = mysqli_fetch_array($perintah))
                  {
                  
                  
                  echo "<tr class='tr-id-".$data1['id']."'>
                  
                  <td>". $data1['no_faktur'] ."</td>
                  <td>". $data1['kode_barang'] ."</td>
                  <td>". $data1['nama_barang'] ."</td>
                  <td>". $data1['satuan'] ."</td>
                  <td><span id='text-stok-sekarang-".$data1['id']."'>". rp($data1['stok_sekarang']) ."</span></td>";

     $pilih = $db->query("SELECT no_faktur FROM hpp_masuk WHERE no_faktur = '$data1[no_faktur]' AND kode_barang = '$data1[kode_barang]' AND sisa != jumlah_kuantitas");
        $row_alert = mysqli_num_rows($pilih);

                  if ($row_alert > 0){
                  
                  echo "<td class='btn-alert' data-kode-barang='". $data1['kode_barang'] ."' data-faktur='". $data1['no_faktur'] ."' >". $data1['fisik'] ."  </td>";
                  }
                  
                  else{
                  
                  echo "<td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['fisik'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['fisik']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-faktur='".$data1['no_faktur']."' data-harga='".$data1['harga']."' data-kode='".$data1['kode_barang']."' data-selisih-fisik='".$data1['selisih_fisik']."' data-stok-sekarang='".$data1['stok_sekarang']."'> </td>";
                      }


                  echo "<td><span id='text-selisih-fisik-".$data1['id']."'>". rp($data1['selisih_fisik']) ."</span></td>
                  <td><span id='text-hpp-".$data1['id']."'>". rp($data1['hpp']) ."</span></td>
                  <td><span id='text-selisih-".$data1['id']."'>". rp($data1['selisih_harga']) ."</span></td>
                  <td>". rp($data1['harga']) ."</td>";

             
                  
                  if ($row_alert > 0) {
                  
                  echo "<td> <button class='btn btn-danger btn-alert' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-faktur='". $data1['no_faktur'] ."' data-nama-barang='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> ";
                }
                else{
                  echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-nama-barang='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
                }


                 echo "</tr>";
                  }

                  //Untuk Memutuskan Koneksi Ke Database
                  mysqli_close($db);   
                  ?>
                  </tbody>
                  
                  </table>
                  </div>
                  </span> <!--tag penutup span-->


                  <form action="proses_selesai_stok_opname.php" role="form" id="form_selesai" method="POST">
                   
                  <br>
                  <br>

                  <div class="form-group">
                  <input type="text" class="form-control" name="total_selisih_harga" id="total_selisih_harga" readonly="" placeholder="Total Selisih Harga">
                  </div>


                  <button type="submit" id="selesai" class="btn btn-info"> <span class='glyphicon glyphicon-ok'> </span> Selesai</button>
                  
                  <button type="submit" id="batal" class="btn btn-danger"> <span class='glyphicon glyphicon-remove'> </span> Batal</button>

                  <a class="btn btn-info" href="form_stok_opname.php" id="transaksi_baru" style="display: none"> <span class="glyphicon glyphicon-repeat"></span> Transaksi Baru</a>
                  

                 </form>

                  <div class="alert alert-success" id="alert_berhasil" style="display:none">
                  <strong>Success!</strong> Pembayaran Berhasil
                  </div>
                  
                  <br>
                  <br>
                  <label> User : <?php echo $_SESSION['user_name']; ?> </label> 
                  <!-- readonly = digunakan agar teks atau isi hanya bisa dibaca tapi tidak bisa diubah -->
                  
                  
                  <span id="demo"> </span>
                  
                  </div> <!-- end of container -->
                  
                  
                  
                  <script>
                  // untuk memunculkan data tabel 
                  $(document).ready(function(){
                  $("#tableuser").dataTable();
                  
                  
                  });
                  
                  </script>
                  <!-- untuk memasukan perintah javascript -->
                  <script type="text/javascript">
                  
                  // jika dipilih, nim akan masuk ke input dan modal di tutup
                  $(document).on('click', '.pilih', function (e) {
                    
                   
                  document.getElementById("kode_barang").value = $(this).attr('data-kode');
                  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
                  document.getElementById("satuan").value = $(this).attr('satuan');

                  
                  $('#myModal').modal('hide');
                  $('#jumlah_fisik').focus();
                  });
                  
                  
                  // tabel lookup table_barang
                  $(function () {
                  $("#table_barang").dataTable();
                  });
                  
                  
                  </script> <!--tag penutup perintah java script-->
                  
                  
                  <script>
                  //perintah javascript yang diambil dari form tbs pembelian dengan id=form tambah produk
                  
                  
                  $("#submit_produk").click(function(){
                  
                  var no_faktur = $("#nomorfaktur").val();
                  var kode_barang = $("#kode_barang").val();
                  var nama_barang = $("#nama_barang").val();
                  var fisik = $("#jumlah_fisik").val();
                  var satuan = $("#satuan").val();

                  $("#kode_barang").val('');
                  $("#nama_barang").val('');
                  $("#jumlah_fisik").val('');
                  


                  if (fisik == ""){
                  alert("Jumlah Fisik Harus Diisi");
                  }

                  else if (kode_barang == ""){
                  alert("Kode Barang Harus Diisi");
                  }

                  else if (nama_barang == ""){
                  alert("Nama Barang Harus Diisi");
                  }
                  
                  else
                  {
                  
                  
                 $.post("proses_tbs_stok_opname.php", {no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,satuan:satuan,fisik:fisik}, function(info) {
                  
                  
                  $("#kode_barang").focus();
                  $("#result").load('tabel_stok_opname.php?no_faktur=<?php echo $no_faktur; ?>');
                  $("#kode_barang").val('');
                  $("#nama_barang").val('');
                  $("#jumlah_fisik").val('');

                  });
                  
                  }

                  $("form").submit(function(){
                  return false;
                  });
                  });


                  $("#submit_produk").mouseleave(function(){
                  var no_faktur = $("#nomorfaktur").val();
                  
                  $.post("cek_total_selisih_harga.php",
                  {
                  no_faktur: no_faktur
                  },
                  function(data){
                  $("#total_selisih_harga"). val(data);
                  });
                  
                  
                  });
                                       
                 
                  $("#cari_produk_pembelian").click(function() {
                    
                        
                  //menyembunyikan notif berhasil
                  $("#alert_berhasil").hide();

                  

                  /* Act on the event */
                  
                  $.get('modal_stok_opname_baru.php', function(data) {
                  
                  $(".modal_stok_baru").html(data);
                  
                  
                  });
                  
                  });
                  
                  
                  </script>
                
                <script type="text/javascript">
                  $(document).ready(function(){

                    var no_faktur = $("#nomorfaktur").val();
                    
                    $.post("cek_total_selisih_harga.php",
                    {
                    no_faktur: no_faktur
                    },
                    function(data){
                    $("#total_selisih_harga"). val(data);
                    });


                  $(".container").hover(function(){
                  var no_faktur = $("#nomorfaktur").val();
                  
                  $.post("cek_total_selisih_harga.php",
                  {
                  no_faktur: no_faktur
                  },
                  function(data){
                  $("#total_selisih_harga"). val(data);
                  });
                  
                  
                  });
                  });

                </script>

                <script type="text/javascript">
                  $(document).ready(function(){
                  $("#kode_barang").focus(function(){
                  var no_faktur = $("#nomorfaktur").val();
                  
                  $.post("cek_total_selisih_harga.php",
                  {
                  no_faktur: no_faktur
                  },
                  function(data){
                  $("#total_selisih_harga"). val(data);
                  });
                  
                  
                  });
                  });

                </script>
                  
                  <script>
                  
                  $("#selesai").click(function(){
                  var no_faktur = $("#nomorfaktur").val();
                  var tanggal = $("#tanggal").val();
                  var total_selisih_harga = $("#total_selisih_harga").val();

                  $("#selesai").hide();
                  $("#batal").hide();
                  $("#transaksi_baru").show();
                 
                  
                  $.post("proses_selesai_edit_stok_opname.php",{tanggal:tanggal,no_faktur:no_faktur,total_selisih_harga:total_selisih_harga},function(info) {
                  
                  $("#demo").html(info);
                  $("#result").load('tabel_stok_opname.php?no_faktur=<?php echo $no_faktur; ?>');
                  $("#total_selisih_harga").val('');
                   
  
                  $("#alert_berhasil").show();

                  
                  });
               
                  $("form").submit(function(){
                  return false;
                  });
                  
                  
                  
                  });
                  
                                   
                  
                  </script>

<script type="text/javascript">

                                  
//fungsi hapus data 
    $(".btn-hapus").click(function(){
    var nama_barang = $(this).attr("data-nama-barang");
    var kode_barang = $(this).attr("data-kode-barang");
    var id = $(this).attr("data-id");

    $.post("hapus_tbs_stok_opname.php",{kode_barang:kode_barang},function(data){
    if (data == "sukses") {
    $(".tr-id-"+id).remove();
    $("#modal_hapus").modal('hide');
    
    }

    
    });
    
    });
// end fungsi hapus data

$('form').submit(function(){
 return false;
});
                         
 </script>

       <script type="text/javascript">
  
        $(document).ready(function(){
          $("#kode_barang").blur(function(){

          var no_faktur = $("#nomorfaktur").val();
          var kode_barang = $("#kode_barang").val();
        
        
        $.post('cek_kode_barang_tbs_stok_opname.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
        
        if(data == 1){
        alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
        $("#kode_barang").val('');
        $("#nama_barang").val('');
        }//penutup if
        
        });////penutup function(data)


      $.getJSON('lihat_stok_opname.php',{kode_barang:$(this).val()}, function(json){
      
      if (json == null)
      {
        
        $('#nama_barang').val('');
        $('#satuan').val('');
      }

      else 
      {
        $('#nama_barang').val(json.nama_barang);
        $('#satuan').val(json.satuan);
      }
                                              
        });
        
        });
        });

      
      
</script>

<script>
/* Membuat Tombol Shortcut */

function myFunction(event) {
    var x = event.which || event.keyCode;

    if(x == 112){


     $("#myModal").modal();

    }

   else if(x == 113){


     $("#selesai").focus();

    }
  }
</script>
                  
  <script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var no_faktur = $("#nomorfaktur").val();
    var kode_barang = $("#kode_barang").val();

 $.post('cek_kode_barang_tbs_stok_opname.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
  
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

                                    var stok_sekarang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-stok-sekarang-"+id+"").text()))));
                                    var hpp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-hpp-"+id+"").text()))));

                                    var selisih_fisik = parseInt(jumlah_baru,10) - parseInt(stok_sekarang,10);
                                    var selisih_harga = parseInt(selisih_fisik,10) * parseInt(hpp,10);


                              
                                  $.post("update_tbs_stok_opname.php", {jumlah_baru:jumlah_baru,id:id,kode_barang:kode_barang,selisih_harga:selisih_harga,selisih_fisik:selisih_fisik}, function(info){


                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-selisih-"+id+"").text(tandaPemisahTitik(selisih_harga));
                                    $("#text-selisih-fisik-"+id+"").text(tandaPemisahTitik(selisih_fisik));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");
                                    $("#kode_barang").focus();
       
                                    
                                    
                                    });

                                 });

                             </script>


<script type="text/javascript">
  
    $(document).on('click', '.btn-alert', function (e) {
    var no_faktur = $(this).attr("data-faktur");
    var kode_barang = $(this).attr("data-kode-barang");

    $.post('modal_alert_hapus_data_edit_stok_opname.php',{no_faktur:no_faktur,kode_barang:kode_barang},function(data){


    $("#modal_alert").modal('show');
    $("#modal-alert").html(data);

    });

    
    });

</script>

                             
                  
<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>