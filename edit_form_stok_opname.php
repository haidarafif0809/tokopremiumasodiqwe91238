<?php include 'session_login.php';
//memasukkan file session login, header, navbar, db
    include 'header.php';
    include 'navbar.php';
    include 'db.php';
    include 'sanitasi.php';
                  
    $no_faktur = stringdoang($_GET['no_faktur']);
    $tanggal = stringdoang($_GET['tanggal']);

$perintah3 = $db->query("SELECT keterangan FROM stok_opname WHERE no_faktur = '$no_faktur'");
$data_stok_opname = mysqli_fetch_array($perintah3);


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
                  <h3>EDIT STOK OPNAME</h3> <hr>
               
                                 <div class="card card-block">
                  <div class="form-group">
                  <label>No Faktur</label><br>
                  <input type="text" name="no_faktur" id="nomorfaktur" class="form-control" readonly="" value="<?php echo $no_faktur; ?>" required="" >
                  </div>

                  <div class="form-group">
                  <label>No Faktur</label><br>
                   <input type="text" name="user" class="form-control" id="user" readonly="" value="<?php echo $_SESSION['user_name']; ?>" required="">
                   </div>

                   <div class="form-group">
                   <label>Tanggal</label><br>
                  <input type="text" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo $tanggal; ?>" class="form-control" required="" >
                  </div>

                 <div class="form-group">
                   <label>Keterangan</label><br>
             <textarea name="keterangan" id="keterangan" placeholder="Tanggal" ketrengan class="form-control"   ><?php echo $data_stok_opname['keterangan']; ?> </textarea>
                  </div>
                  </div><!-- div card block-->
                  </form>

                  <!-- membuat teks dengan ukuran h3 -->
         
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
                  <h4 class="modal-title"> Data Barang</h4>
                  </div>
                  <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
                  
                  <!--perintah agar modal update-->
                  <center>
                        <div class="table-responsive">
                              <table id="table_stok_opname" class="table table-bordered ">
                              <thead> <!-- untuk memberikan nama pada kolom tabel -->
                              
                              <th> Kode Barang </th>
                              <th> Nama Barang </th>
                              <th> Satuan </th>
                              <th> Kategori </th>
                              <th> Suplier </th>
                              
                              </thead> <!-- tag penutup tabel -->
                              </table>
                        </div>
                  </center>
                  </div> <!-- tag penutup modal body -->
                  
                  <!-- tag pembuka modal footer -->
                  <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div> <!--tag penutup moal footer -->
                  </div>
                  
                  </div>
                  </div>
                  
                  
                  <form class="form" action="proses_tbs_stok_opname.php" role="form" id="formtambahproduk">
                  
            <div class="row">  
    <div class="col-xs-4">
        <br>
  <div class="form-group">        
    <select style="font-size:15px; height:10px" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
    <option value="">SILAKAN PILIH...</option>
       <?php 

        include 'cache.class.php';
          $c = new Cache();
          $c->setCache('produk');
          $data_c = $c->retrieveAll();

          foreach ($data_c as $key) {
            echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" harga="'.$key['harga_jual'].'" harga_jual_2="'.$key['harga_jual2'].'" harga_jual_3="'.$key['harga_jual3'].'" harga_jual_4="'.$key['harga_jual4'].'" harga_jual_5="'.$key['harga_jual5'].'" harga_jual_6="'.$key['harga_jual6'].'" harga_jual_7="'.$key['harga_jual7'].'" satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'" tipe_barang="'.$key['tipe_barang'].'" id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
          }

        ?>
    </select>
    </div>
    </div>
                  
                  <div class="form-group"> <!-- agar tampilan berada pada satu group -->
                  <!-- memasukan teks pada kolom kode barang -->
                  <input type="hidden" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" readonly="">
                  </div>
                  
                  
  <div class="col-xs-4">               
     <div class="form-group">
      <input type="text"  class="form-control" name="fisik" autocomplete="off" id="jumlah_fisik" placeholder="Jumlah Fisik">
    </div>
</div>   
                  
                  
                  
                  <!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->

                  <input type="hidden" id="satuan" name="satuan" class="form-control" value="" required="">

                  <div class="form-group">
                  <input type="hidden" name="no_faktur" id="nomorfaktur1" class="form-control" value="<?php echo $no_faktur; ?>" required="" >
                  </div>

                  
                 <div class="col-xs-4">

                  <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah Produk</button>
                  </div>
      </div> <!-- end of row -->
                  </form>
                  
                  
                  </div>

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



<div class="row">
  <div class="col-sm-9">
                  <span id="result">  
                  
                  <div class="table-responsive">    
                  <table id="tableuser" class="table table-bordered table-sm">
                  <thead>
                  
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
                  
                  <tbody id="tbody">
                  <?php
                  
                  
                  $perintah = $db->query("SELECT tio.no_faktur,tio.kode_barang,tio.nama_barang,s.nama,tio.id,tio.stok_sekarang,tio.fisik,tio.selisih_fisik,tio.harga,tio.selisih_harga,tio.hpp FROM tbs_stok_opname tio LEFT JOIN satuan s ON tio.satuan = s.id WHERE tio.no_faktur = '$no_faktur' ORDER BY tio.id DESC");
                  
                  //menyimpan data sementara yang ada pada $perintah
                  while ($data1 = mysqli_fetch_array($perintah))
                  {
                  
                  
                  echo "<tr class='tr-id-".$data1['id']."'>
                  
                  <td>". $data1['kode_barang'] ."</td>
                  <td>". $data1['nama_barang'] ."</td>
                  <td>". $data1['nama'] ."</td>
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
                  
                  echo "<td> <button class='btn btn-danger btn-alert btn-sm' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-faktur='". $data1['no_faktur'] ."' data-nama-barang='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> ";
                }
                else{
                  echo "<td> <button class='btn btn-danger btn-hapus btn-sm' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-nama-barang='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
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
                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>

              </div> <!--taag penutup col sm 9-->


              <div class="col-sm-3"> <!--taag penutup col sm 3-->

                  <form action="proses_selesai_stok_opname.php" role="form" id="form_selesai" method="POST">

                  <div class="form-group">

                  <div class="card card-block">
                  <label><h5>Total Selisih</h5></label>
                 <b><input type="text" class="form-control" style="font-size: 25px" name="total_selisih_harga" id="total_selisih_harga" readonly="" placeholder="Total Selisih Harga"></b> 
                  </div>

                  </div>

                  <button type="submit" id="selesai" class="btn btn-info"> <span class='glyphicon glyphicon-ok'> </span> Selesai</button>
                  
                  <a href='batal_stok_opname_edit.php?no_faktur=<?php $no_faktur;?>'  id="batal" class="btn btn-danger"> <span class='glyphicon glyphicon-remove'> </span> Batal</button>

                  <a class="btn btn-info" href="stok_opname.php" id="transaksi_baru" style="display: none"> <span class="glyphicon glyphicon-repeat"></span> Kembali </a>
                  

                 </form>

                  <div class="alert alert-success" id="alert_berhasil" style="display:none">
                  <strong>Success!</strong> Pembayaran Berhasil
                  </div>
   
                  <!-- readonly = digunakan agar teks atau isi hanya bisa dibaca tapi tidak bisa diubah -->

                  <span id="demo"> </span>
                   </div>      <!--tag penutup col sm 3-->         
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
                  $("#kode_barang").trigger('chosen:updated');

                  var kode_barang = $("#kode_barang").val();
                  var no_faktur = $("#nomorfaktur").val();

                  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
                  document.getElementById("satuan").value = $(this).attr('satuan');


        $.post('cek_kode_barang_tbs_stok_opname_edit.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
        
        if(data == 1){
        alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
        $("#kode_barang").val('');
        $("#kode_barang").trigger('chosen:updated');
        $("#nama_barang").val('');
        }//penutup if
        
        });////penutup function(data)

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
                  var fisik = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_fisik").val()))));
                  var satuan = $("#satuan").val();

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
                  $("#tbody").prepend(info);
                  $("#kode_barang").val('');
                  $("#nama_barang").val('');
                  $("#jumlah_fisik").val('');
                  

                  $.post("cek_total_selisih_harga_editso.php",{no_faktur:no_faktur},
                    function(data){
                    $("#total_selisih_harga"). val(tandaPemisahTitik(data));
                    });


                  });
                  
                  }

                  $("form").submit(function(){
                  return false;
                  });

              

   });
</script>
                
                <script type="text/javascript">
                  $(document).ready(function(){

                    var no_faktur = $("#nomorfaktur").val();
                    
                    $.post("cek_total_selisih_harga_editso.php",
                    {
                    no_faktur: no_faktur
                    },
                    function(data){
                    data = data.replace(/\s+/g, '');
                    $("#total_selisih_harga"). val(tandaPemisahTitik(data));
                    });


                  $(".container").hover(function(){
                  var no_faktur = $("#nomorfaktur").val();
                  
                  $.post("cek_total_selisih_harga_editso.php",
                  {
                  no_faktur: no_faktur
                  },
                  function(data){
                  data = data.replace(/\s+/g, '');
                  $("#total_selisih_harga"). val(tandaPemisahTitik(data));
                  });
                  
                  
                  });
                  });

                </script>

          <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});  
      
      </script>
     



<script type="text/javascript">
  
  $(document).ready(function(){
  $("#kode_barang").change(function(){

    var kode_barang = $(this).val();
    var nama_barang = $('#opt-produk-'+kode_barang).attr("nama-barang");
    var satuan = $('#opt-produk-'+kode_barang).attr("satuan");
    var no_faktur = $("#nomorfaktur").val();

        $.post('cek_kode_barang_tbs_stok_opname_edit.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
        
        if(data == 1){
        alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
        $("#kode_barang").val('');
        $("#kode_barang").trigger('chosen:updated');
        $("#nama_barang").val('');
        }//penutup if
        
        });////penutup function(data)

        $('#nama_barang').val(nama_barang);
        $('#satuan').val(satuan);
       });////penutup function(data)
   });////penutup function(data)
    </script>




                <script type="text/javascript">
                  $(document).ready(function(){
                  $("#kode_barang").focus(function(){
                  var no_faktur = $("#nomorfaktur").val();
                  
                  $.post("cek_total_selisih_harga_editso.php",
                  {
                  no_faktur: no_faktur
                  },
                  function(data){
                  data = data.replace(/\s+/g, '');
                  $("#total_selisih_harga"). val(tandaPemisahTitik(data));
                  });
                  
                  
                  });
                  });

                </script>
                  
                  <script>
                  
                  $("#selesai").click(function(){
                  var no_faktur = $("#nomorfaktur").val();
                  var tanggal = $("#tanggal").val();
                  var keterangan = $("#keterangan").val();
                  var total_selisih_harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_selisih_harga").val()))));


                  $("#selesai").hide();
                  $("#batal").hide();
                  $("#transaksi_baru").show();
                 
                  
                  $.post("proses_selesai_edit_stok_opname.php",{tanggal:tanggal,no_faktur:no_faktur,total_selisih_harga:total_selisih_harga,keterangan:keterangan},function(info) {
                  
                  $("#result").hide();
                  $("#tbody").val('');
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

<!--       <script type="text/javascript">
  
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

      
      
</script>-->

<script type="text/javascript">
  $(document).ready(function(){
    $("#table_stok_opname").DataTable().destroy();
          var dataTable = $('#table_stok_opname').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_stok_opname_baru.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_stok_opname").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('data-kode', aData[0]);
              $(nRow).attr('nama-barang', aData[1]);
              $(nRow).attr('satuan', aData[6]);
              $(nRow).attr('harga_beli', aData[5]);



          }

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