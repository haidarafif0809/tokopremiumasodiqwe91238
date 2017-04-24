<?php include 'session_login.php';


// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';
include 'bootstrap.php';
$session_id = session_id();



$query = $db->query("SELECT * FROM barang WHERE kategori = 'Makanan' OR kategori = 'Minuman' OR kategori = 'Beef'");

$kode_meja = $_GET['kode_meja'];

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


<h3> Tambah Data Pesanan </h3><br>

<div id="modal_komen" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Permintaan</h4>
      </div>

      <div class="modal-body">
   

   <form>
    <div class="form-group">
    <label> Tambah Permintaan </label>
     <textarea name="komentar" id="kolom_komen" class="form-control" ></textarea>
      <input name="id" id="id_komen" class="form-control" type="hidden">
    </div>
   
   </form>
    
<button type="submit" id="submit_komen" class="btn btn-primary">Add</button>
     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
      </div>
    </div>

  </div>
</div>


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Pesanan</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Pesanan :</label>
     <input type="text" id="data_pesanan" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
     <input type="hidden" id="kode_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus">Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
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
        <h4 class="modal-title">Edit Data Penjualan Barang</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Jumlah Baru:</label>
     <input type="text" class="form-control" autocomplete="off" id="barang_edit"><br>
     <label for="email">Jumlah Lama:</label>
     <input type="text" class="form-control" id="barang_lama" readonly="">
     <input type="hidden" class="form-control" id="harga_edit" readonly="">
     <input type="hidden" class="form-control" id="kode_edit">
     <input type="hidden" class="form-control" id="id_edit">
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-default">Submit</button>
  </form>
  <span id="alert"> </span>
  <div class="alert-edit alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->



<span id="menu_pesanan">
  <div class="row">
    <div class="col-sm-7 col-xs-7">
      <h4> Cari Produk :</h4>
      <div class="input-group">
      <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
      <input type="text" id="cari_pesanan" class="form-control" style="width:30%;" aria-describedby="basic-addon1" autofocus="">
      </div><br>
    <span id="jumlah_pos">
<?php 

while ($data=mysqli_fetch_array($query)) 
  {

// mencari jumlah Barang
            $query0 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_pembelian FROM detail_pembelian WHERE kode_barang = '$data[kode_barang]'");
            $cek0 = mysqli_fetch_array($query0);
            $jumlah_pembelian = $cek0['jumlah_pembelian'];

            $query1 = $db->query("SELECT SUM(jumlah) AS jumlah_item_masuk FROM detail_item_masuk WHERE kode_barang = '$data[kode_barang]'");
            $cek1 = mysqli_fetch_array($query1);
            $jumlah_item_masuk = $cek1['jumlah_item_masuk'];

            $query2 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_penjualan FROM detail_retur_penjualan WHERE kode_barang = '$data[kode_barang]'");
            $cek2 = mysqli_fetch_array($query2);
            $jumlah_retur_penjualan = $cek2['jumlah_retur_penjualan'];

            $query20 = $db->query("SELECT SUM(jumlah_awal) AS jumlah_stok_awal FROM stok_awal WHERE kode_barang = '$data[kode_barang]'");
            $cek20 = mysqli_fetch_array($query20);
            $jumlah_stok_awal = $cek20['jumlah_stok_awal'];

            $query200 = $db->query("SELECT SUM(selisih_fisik) AS jumlah_fisik FROM detail_stok_opname WHERE kode_barang = '$data[kode_barang]'");
            $cek200 = mysqli_fetch_array($query200);
            $jumlah_fisik = $cek200['jumlah_fisik'];
//total barang 1
            $total_1 = $jumlah_pembelian + $jumlah_item_masuk + $jumlah_retur_penjualan + $jumlah_stok_awal + $jumlah_fisik;


 

            $query3 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_penjualan FROM detail_penjualan WHERE kode_barang = '$data[kode_barang]'");
            $cek3 = mysqli_fetch_array($query3);
            $jumlah_penjualan = $cek3['jumlah_penjualan'];


            $query4 = $db->query("SELECT SUM(jumlah) AS jumlah_item_keluar FROM detail_item_keluar WHERE kode_barang = '$data[kode_barang]'");
            $cek4 = mysqli_fetch_array($query4);
            $jumlah_item_keluar = $cek4['jumlah_item_keluar'];

            $query5 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_pembelian FROM detail_retur_pembelian WHERE kode_barang = '$data[kode_barang]'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_retur_pembelian = $cek5['jumlah_retur_pembelian'];


 



//total barang 2
            $total_2 = $jumlah_penjualan + $jumlah_item_keluar + $jumlah_retur_pembelian;

            $stok_barang = $total_1 - $total_2;
            
if ($stok_barang > 0) 
    {
  
      echo '<div class="img" data-kode="'. $data['kode_barang'] .'" nama-barang="'. $data['nama_barang'] .'" harga="'. $data['harga_jual'] .'" foto="'. $data['foto'] .'" satuan="'. $data['satuan'] .'">
      
      <span style="cursor:pointer">

      <img src="save_picture/'. $data['foto'] .'" height="150px" width="190px">
      
      </span>
      
      
      <div class="desc">'.$data['nama_barang'].'</div>
      </div>';
    }
      
  } 



 ?>
 </span>
  </div><!--end col-sm-9-->


  <div class="col-sm-5 col-xs-5" id="sm_3"> 

    <br><br><label> Daftar Pesanan : </label>   

    
    <div class="table-responsive">
      <span id="result">    
        <table id="tableuser" class="table table-bordered" style="width:100%">
        

        <thead>


          <th> Nama Barang </th>
          <th> Jumlah Barang </th>
          <th> Subtotal </th>
          <th> Permintaan </th>
          <th> Edit Permintaan </th>
          <th> Edit </th>
          <th> Hapus </th>

        </thead>
        <tbody>
        <?php
        
        // menampilkan seluruh data yang ada pada tabel barang
        $perintah = "SELECT * FROM tbs_penjualan WHERE session_id = '$session_id'";
        $perintah1 = $db->query($perintah);
        
        // menyimpoan data sementara yang ada pada $perintah1
        while ($data1 = mysqli_fetch_array($perintah1))
        {
        // menampilkan data
            echo "<tr>
            <td>". $data1['nama_barang'] ."</td>
            <td>". $data1['jumlah_barang'] ."</td>
            <td>". $data1['subtotal'] ."</td>";

           if ($data1['komentar'] == '') {
             echo "<td> <button class='btn btn-primary btn-komen' data-id='".$data1['id']."' data-komen='".$data1['komentar']."'><span class='glyphicon glyphicon-pencil'> </span> Add Comment </button> </td>";
           }

             else {

             echo "<td>". $data1['komentar'] ."</td>";
           }

           if ($data1['komentar'] != '') {
              echo "<td> <button class='btn btn-primary btn-komen' data-id='".$data1['id']."' data-komen='".$data1['komentar']."'><span class='glyphicon glyphicon-edit'> </span> Edit Comment </button> </td>";

           }
           else{
            echo "<td> </td>";
           }

            

           echo "<td> <button class='btn btn-success btn-edit-tbs' data-id='". $data1['id'] ."' data-jumlah-barang='". $data1['jumlah_barang'] ."' data-kode='". $data1['kode_barang'] ."' data-harga='". $data1['harga'] ."'><span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>

            <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-pesanan='". $data1['nama_barang'] ."' kode-data='". $data1['kode_barang'] ."'> Hapus </button> </td> 
        </tr>";
        
        }
        
        ?>

        </tbody>
        </table>
        </span>
    </div>

    <form class="form-inline" action="proses_simpan_sementara.php" role="form" id="formtambahproduk">


          <div class="form-group">
          <label> Kode Pelanggan </label><br>
          <select type="text" data-placeholder="Umum" name="kode_pelanggan" id="kd_pelanggan" class="form-control chosen"  required="" >
          <option value="Umum">Umum</option>
          
          <?php 
          
          //untuk menampilkan semua data pada tabel pelanggan dalam DB
          $query = $db->query("SELECT * FROM pelanggan");
          
          //untuk menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option>".$data['kode_pelanggan'] ." - ".$data['nama_pelanggan'] ."</option>";
          }
          
          
          ?>
          </select>
          </div>

        

        <div class="form-group"><br>
        <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo session_id(); ?>" readonly="" >
        </div>
        

        <div class="form-group">
        <label> Kode Meja </label><br>
        <input type="text" name="kode_meja" id="kode_meja" value="<?php echo $kode_meja; ?>" class="form-control" placeholder="Total" readonly="" >
        </div>

        <div class="form-group">
        <label> Total </label><br>
        <input type="text" name="total" id="total" class="form-control" placeholder="Total" readonly="" >
        </div>

        <div class="form-group">
        <input type="hidden" name="no_pesanan" id="no_pesanan" class="form-control" placeholder="no_pesanan" readonly="" >
        </div>
        

        <div class="form-group">

<?php
          $total_tbs = $db->query("SELECT SUM(subtotal) as s_total FROM tbs_penjualan WHERE session_id = '$session_id'");
          $ambil_total = mysqli_fetch_array($total_tbs);
          $total_bener = $ambil_total['s_total'];




          $ambil_diskon_tax = $db->query("SELECT * FROM setting_diskon_tax");
          $data_diskon = mysqli_fetch_array($ambil_diskon_tax);

        if ($data_diskon['diskon_nominal'] != 0 AND $data_diskon['diskon_persen'] == 0) {

             $diskon = $data_diskon['diskon_nominal'];

           
             if ($total_bener == 0) {
              $diskon_p = 0;
              }
              else{
                  $diskon_p = $diskon * 100 / $total_bener;

              }
  

            ?>
          
          
          <input type="hidden" name="potongan" id="potongan_penjualan" value="<?php echo intval($diskon); ?>" class="form-control" placeholder="" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"><br>
           <input type="hidden" name="potongan" id="potongan_penjualan2" value="<?php echo intval($diskon); ?>" class="form-control" placeholder="" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"><br>

          <input type="hidden" name="potongan_persen" id="potongan_persen" value="<?php echo intval($diskon_p); ?>" class="form-control" placeholder="" autocomplete="off" ><br>
         

          <?php  }
          else{
            $diskon = $data_diskon['diskon_persen'];

            $diskon_n = $total_bener /  100 * $diskon;



?>


          <input type="hidden" name="potongan" id="potongan_penjualan" value="<?php echo intval($diskon_n); ?>" class="form-control" placeholder="" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" ><br>

          <input type="hidden" name="potongan_persen" id="potongan_persen" value="<?php echo intval($diskon); ?>" class="form-control" placeholder="" autocomplete="off" ><br>
         
<?php
          }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
           ?>

          <input type="hidden" name="tax" id="tax" class="form-control" value="<?php echo $data_diskon['tax']; ?>" placeholder="" autocomplete="off"><br>

          <input type="hidden" name="tax" id="tax_rp" class="form-control" value="" placeholder="" autocomplete="off">
          </div>
        
        <br> <br>
        <button id="submit_produk" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"> </span> Simpan</button>
        <button type="submit" id="batal" class="btn btn-danger">Batal</button>

        <a href='cetak_pesanan_makanan.php' id="cetak_makanan" style="display: none;" class="btn btn-primary" target="blank"><span class="glyphicon glyphicon-print"> </span> Cetak Makanan </a>

        <a href='cetak_pesanan_minuman.php' id="cetak_minuman" style="display: none;" class="btn btn-primary" target="blank"> <span class="  glyphicon glyphicon-print"> </span> Cetak Minuman </a>

        <a href='cetak_pesanan_beef.php' id="cetak_beef" style="display: none;" class="btn btn-primary" target="blank"> <span class="  glyphicon glyphicon-print"> </span> Cetak Beef </a>

        <a href='cetak_pesanan.php' id="cetak_pelanggan" style="display: none;" class="btn btn-primary" target="blank"> <span class="  glyphicon glyphicon-print"> </span> Cetak Pesanan </a>
                  <br>
          <br>
          <label> User :  <?php echo $_SESSION['user_name']; ?> </label><br>

          <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Success!</strong> Pemesanan Berhasil
          </div>
</form> 
        
    </div><!--col-sm 3-->
    </div><!-- row-->
  </span>

    


</div>

     
  
  </form>
  </span>


                                                                                                                                                          
          
 


        <script type="text/javascript">
        
        // jika dipilih, nim akan masuk ke input dan modal di tutup
        $(document).on('click', '.img', function (e) {
        
        var kode_barang = $(this).attr('data-kode');
        var harga = $(this).attr('harga');
        var nama_barang = $(this).attr('nama-barang');
        var satuan = $(this).attr('satuan');
        var session_id = $("#session_id").val();
        var no_pesanan = $("#no_pesanan").val();
        
        $.post('lis_pesanan.php',{kode_barang:kode_barang,satuan:satuan,harga:harga,nama_barang:nama_barang,session_id:session_id,no_pesanan:no_pesanan},function(data) {
        
        $("#result").html(data);
        $("#result").load('tabel-pesanan.php');
        
        });
        

        
        });
        
        
        $("form").submit(function(){
        return false;
        });


        
        // tabel lookup table_barang
        $(function () {
        $(".table").dataTable();
        });
        
        $(document).ready(function() {
          
        
        $(".img").mouseleave(function(){
        
        var kode_pelanggan = $("#kd_pelanggan").val();
        
        
        if (kode_pelanggan != ""){
        $("#kd_pelanggan").attr("disabled", true);
        }
        
        var session_id = $("#session_id").val();
        

        $.post("cek_total_penjualan_pesanan_meja.php",{session_id:session_id},function(data){
        $("#total"). val(data);
        });
        
        $.post("cek_total_hpp.php",{session_id:session_id},function(data){
        $("#total_hpp"). val(data);
        });
        
        });
        
        });
        
        
        </script>

        
        <script type="text/javascript">
        $(document).ready(function() {
                
        
        
        $("#submit_produk").click(function(){
        var session_id = $("#session_id").val();
        var kode_meja = $("#kode_meja").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total").val() ))));
        var kode_pelanggan = $("#kd_pelanggan").val();

        var tax =  $("#tax_rp").val() ;
        var potongan =  $("#potongan_penjualan").val() ;

        if (total <= 0 || kode_meja == "") {
          alert("Anda Belum Melakukan Pemesanan");
        }

        else{

        $.post("proses_simpan_sementara.php", {session_id: session_id,kode_meja:kode_meja,total:total,kode_pelanggan:kode_pelanggan,tax:tax,potongan:potongan}, function(data){

        $("#total").val('');
        $("#kode_meja").val('');
        $("#result").html(data);
        $("#cetak_makanan").show();
        $("#cetak_minuman").show();
        $("#cetak_beef").show();
        $("#cetak_pelanggan").show();
        $("#alert_berhasil").show();
        });
          
        }
        

        });
        
        $("#formtambahproduk").submit(function(){
        return false;
        });
      
      });
        </script>


        
        <script type="text/javascript">
        
        $("#kembali").click(function(){
        
        $("#menu_bayar").hide('fast');
        $("#menu_pesanan").show('fast');
        $("#alert_berhasil").hide();

        $("#cetak_makanan").hide('');
        $("#cetak_minuman").hide('');
        $("#cetak_beef").hide('');
        
        });
        
        </script>
        
        

          <script>
          
          $(document).ready(function(){ 
          
          //button batal agar tidak ada loading
          $("#batal").click(function(){
          var session_id = $("#session_id").val();
          
          $.post("batal_pos.php",{session_id:session_id},function(info) {
          
          $("#result").html(info);
          $("#menu_pesanan").show('fast');  
          
          
          });
          });
          });
          
          </script>
        
        
        <script>
        $(document).ready(function(){
        //id kode pelanggan dari kode_pelanggan
        $("#kd_pelanggan").change(function(){
        var kode_pelanggan = $("#kd_pelanggan").val();
        
        //id yang di hidden
        $("#k_pelanggan").val(kode_pelanggan);
        
        });
        });
        </script>

                             
                             <script type="text/javascript">
                             
                $(document).ready(function(){

          //fungsi hapus data 
                $(".btn-hapus").click(function(){
                var nama_barang = $(this).attr("data-pesanan");
                var id = $(this).attr("data-id");
                var kode_barang = $(this).attr("kode-data");
                $("#data_pesanan").val(nama_barang);
                $("#id_hapus").val(id);
                $("#kode_hapus").val(kode_barang);
                $("#modal_hapus").modal('show');
                
                
                });
                
                
                $("#btn_jadi_hapus").click(function(){
                
                var id = $("#id_hapus").val();
                var kode_barang = $("#kode_hapus").val();
                $.post("hapus_pos_penjualan.php",{id:id,kode_barang:kode_barang},function(data){
                if (data != "") {
                $("#result").load('tabel-pesanan.php');
                $("#modal_hapus").modal('hide');
                
                }
                
                
                });
                
                });
          // end fungsi hapus data
          //fungsi edit data 
          $(".btn-edit-tbs").click(function(){
          
          $("#modal_edit").modal('show');
          var jumlah_barang = $(this).attr("data-jumlah-barang");
          var harga = $(this).attr("data-harga");
          var id  = $(this).attr("data-id");
          var kode_barang = $(this).attr("data-kode");
          $("#harga_edit").val(harga);
          $("#barang_lama").val(jumlah_barang);
          $("#id_edit").val(id);
          $("#kode_edit").val(kode_barang);
          
          
          });
          
          $("#submit_edit").click(function(){
          var jumlah_barang = $("#barang_lama").val();
          var jumlah_baru = $("#barang_edit").val();
          var harga = $("#harga_edit").val();
          var id = $("#id_edit").val();
          var kode_barang = $("#kode_edit").val();
          var session_id = $("#nofaktur").val();
          
          $.post("update_tbs_pos.php",{id:id,jumlah_barang:jumlah_barang,jumlah_baru:jumlah_baru,harga:harga,kode_barang:kode_barang,session_id:session_id},function(data){
          
          $("#alert").html(data);
          $("#result").load('tabel-pesanan.php');
          
          setTimeout(tutupmodal, 2000);
          setTimeout(tutupalert, 2000);
          
          
          });


          });

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
                               
                                               $(".btn-komen").click(function(){
                                               var komentar = $(this).attr("data-komen");
                                               var id = $(this).attr("data-id");

                                               $("#kolom_komen").val(komentar);
                                               $("#id_komen").val(id);
                                               $("#modal_komen").modal('show');
                                               
                                               
                                               });
                                                         
                                                         $("#submit_komen").click(function(){
                                                         var komentar = $("#kolom_komen").val();
                                                         var id = $("#id_komen").val();                                                         
                                                         $.post("proses_permintaan.php",{id:id,komentar:komentar},function(data){
                                                         
                                                         
                                                         $("#result").load('tabel-pesanan.php');
                                                         $("#modal_komen").modal('hide');
                                                         
                                                         });
                                                         
                                                         
                                                         });

                             </script>

        <script type="text/javascript">
        
        $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
        
        </script>

                  <script type="text/javascript">
                  $(document).ready(function(){
                  $("#cari_pesanan").keyup(function(){
                  var nama_barang = $(this).val();
                  
                  $.post("cari_pesanan.php",{nama_barang:nama_barang},function(info){

                    $("#jumlah_pos").html(info);

                  });
                  
                  
                  });
                  });

                             </script>

                             <script type="text/javascript">
                          $("#sm_3").hover(function(){
                          
                          var session_id = $("#session_id").val();
                          

                          
                          $.post("cek_total_penjualan_pesanan_meja.php",
                          {
                          session_id: session_id
                          },
                          function(data){
                          $("#total"). val(data);
                          });

        var tax_persen = $("#tax").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total").val() ))));
        var diskon = $("#potongan_persen").val();
        var diskon_penjualan = $("#potongan_penjualan2").val();
        var diskon_n = ((total /  100 )  *  diskon);
        var tax_rp = ((total * tax_persen) / 100);
        
        if (diskon_penjualan > 0) {

          $("#potongan_penjualan").val(parseInt(diskon_penjualan));

        }
        else{

          $("#potongan_penjualan").val(parseInt(diskon_n));
          
        }
        
        $("#tax_rp").val(parseInt(tax_rp));

                        });
                          </script>


<script type="text/javascript">
  
          $(document).ready(function() {
                
        $("#submit_produk").click(function(){
        var session_id = $("#session_id").val();
        var potongan_rp = $("#potongan_penjualan").val();
        var tax = $("#tax").val();
        
        $.post("cek_diskon_rupiah.php", {session_id: session_id, potongan:potongan_rp, tax:tax}, function(data){
        $("#total1"). val(data);
        $("#total"). val(data);

</script>

        
        <!-- memasukan file footer.php -->
        <?php
        
        include 'footer.php'; 
        
        ?>