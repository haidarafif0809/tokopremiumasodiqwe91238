<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

//menampilkan seluruh data yang ada pada tabel pembelian
$perintah = $db->query("SELECT * FROM retur_pembelian");

$session_id = session_id();


 ?>

<!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
<div class="container">

          <h3> <u>FORM RETUR PEMBELIAN</u> </h3><br> 
<!--membuat agar tabel berada dalam baris tertentu-->


  <!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="form_retur_pembelian.php" method="post ">
					
          <!-- membuat teks dengan ukuran h3 -->
    <div class="row">
      <div class="col-sm-2">
          <label> Suplier </label><br>
          
          <select data-placeholder="--SILAHKAN PILIH--" name="suplier" id="nama_suplier" class="form-control chosen" required="" >
          
          
          <?php 
          
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM suplier");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
          }
          
          
          ?>
          </select>
      </div>


      <div class="col-sm-2">
          
          <label> User </label><br>
          <!-- readonly = digunakan agar teks atau isi hanya bisa dibaca tapi tidak bisa diubah -->
          <input type="text" name="user" class="form-control" readonly="" style="height: 20px" value="<?php echo $_SESSION['user_name']; ?>" required="">

      </div>


      <div class="col-sm-2">
            <label>PPN</label>
            <select name="ppn" id="ppn" class="form-control">
            <option value="Include">Include</option>  
            <option value="Exclude">Exclude</option>
            <option value="Non">Non</option>          
            </select>
      </div>

      <div class="col-sm-2">
           <label> Cara Bayar </label><br>
           <select type="text" name="cara_bayar" id="carabayar1" class="form-control" >
           
           <?php 
           
           
           $query = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank' ");
           while($data = mysqli_fetch_array($query))
           {
           
           echo "<option value='".$data['kode_daftar_akun']."'>".$data['nama_daftar_akun'] ."</option>";
           }
           
            
           ?>
           
           </select>
      </div>

    </div>

          <!-- membuat agar teks tidak bisa di ubah, dan hanya bisa dibaca -->
					<input type="hidden" name="session_id" id="session_id" class="form-control" readonly="" value="<?php echo $session_id; ?>" required="" >
				

          </form> <!-- tag penutup form -->

				
  
 <div class="row">

 <!--membuat tampilan halaman menjadi 8 bagian-->
  <div class="col-sm-8">

<!-- membuat tombol agar menampilkan modal -->
<button type="button" class="btn btn-info" id="cari_produk_pembelian" data-toggle="modal" data-target="#myModal"><i class='fa fa-search'> </i> Cari</button>
<br><br>
<!-- Tampilan Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Isi Modal-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Detail Pembelian</h4>
      </div>
      <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->


<span class="modal_retur_baru">
</span>
  
</div>


      <!-- tag pembuka modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> <!--tag penutup moal footer -->
    </div>

  </div>
</div>


<!-- membuat form -->
 <form class="form" action="proses_tbs_retur_pembelian.php" role="form" id="formtambahproduk">
  
<div class="row">
  <div class="form-group col-sm-3">
    <input type="text" class="form-control" name="kode_barang" autocomplete="off" id="kode_barang" placeholder="Kode Produk">
    </div>


  <div class="form-group col-sm-3"> <!-- agar tampilan berada pada satu group col-sm-3 -->
  <!-- memasukan teks pada kolom kode barang -->
  <input type="text" class="form-control" name="nama_barang" readonly="" id="nama_barang" placeholder="Nama Barang">
  </div>
  

  <div class="form-group col-sm-2">
    <input type="text" class="form-control" name="jumlah_retur" autocomplete="off" id="jumlah_retur" placeholder="Jumlah Retur">
  </div>

<div class="form-group col-sm-3">
          
          <select name="satuan_konversi" id="satuan_konversi" class="form-control"  required=""  >
          
          <?php 
          
          
          $query = $db->query("SELECT id, nama  FROM satuan");
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
          }
                      
          ?>
          
          </select>

        </div>

</div>
    

<div class="row">
  <div class="form-group col-sm-3">
    <input type="text" class="form-control" name="potongan1" data-toggle="tooltip" data-placement="top" id="potongan1" placeholder="Potongan (Rp)" autocomplete="off">
  </div>

  <div class="form-group col-sm-3">
    <input type="text" class="form-control" name="potongan2" data-toggle="tooltip" data-placement="top" id="potongan2" placeholder="Potongan (%)" autocomplete="off">
  </div>

  <div class="form-group col-sm-2">
    <input type="text" class="form-control" name="tax1"  id="tax1" placeholder="Pajak (%)" autocomplete="off">
  </div>


  <div class="form-group col-sm-4">

  <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah Produk</button>
  </div>
</div>
  


  <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">

<!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->
  <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
  <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" required="">
  <input type="hidden" class="form-control" name="harga_lama" id="harga_lama">
  <input type="hidden" class="form-control" name="harga_baru" id="harga_baru">
  <input type="hidden" id="satuan_beli" name="satuan" class="form-control" value="" required="">
  <input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" required="">
  <input type="hidden" id="harga_pcs" name="harga_pcs" class="form-control" value="" required=""> 
  <input type="hidden" id="satuan_pcs" name="satuan_pcs" class="form-control" value="" required="">

  <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo $session_id; ?>" required="" >
  <input type="hidden" id="no_faktur2" name="no_faktur_pembelian" class="form-control" value="" required="">
  <input type="hidden" id="sisabarang" name="sisa" class="form-control" value="" required="">
  <!-- membuat tombol submit-->
</form>




  <div class="table-responsive"><!--tag untuk membuat garis pada tabel-->  
        <span id="result">       
  <table id="tabel" class="table table-bordered">
    <thead>
      <th> Nomor Faktur Pembelian</th>
      <th> Kode Barang </th>
      <th> Nama Barang </th>
      <th> Jumlah Barang </th>
      <th> Jumlah Retur </th>
      <th> Satuan Retur </th>
      <th> Harga </th>
      <th> Potongan </th>
      <th> Pajak </th>
      <th> Subtotal </th>
      <th> Hapus </th>
      
      
    </thead>
    
    <tbody id="tbody">
     <?php

    //untuk menampilkan semua data yang ada pada tabel tbs pembelian dalam DB
    $perintah = $db->query("SELECT ss.nama AS satuan_retur, s.nama AS satuan_beli, tp.id,tp.no_faktur_pembelian,tp.kode_barang,tp.nama_barang,tp.jumlah_beli,tp.jumlah_retur,tp.harga,tp.potongan,tp.tax,tp.subtotal,tp.satuan FROM tbs_retur_pembelian tp INNER JOIN satuan s ON tp.satuan_beli = s.id INNER JOIN satuan ss ON tp.satuan = ss.id WHERE tp.session_id = '$session_id'");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr class='tr-id-".$data1['id']."'>
      <td>". $data1['no_faktur_pembelian'] ."</td>
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>
      <td>". rp($data1['jumlah_beli']) ." ".$data1['satuan_beli']."</td>


      <td class='edit-jumlah' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur_pembelian']."' data-kode='".$data1['kode_barang']."'> <span id='text-jumlah-".$data1['id']."'> ".$data1['jumlah_retur']." </span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_retur']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-faktur='".$data1['no_faktur_pembelian']."' data-kode='".$data1['kode_barang']."' data-satuan='".$data1['satuan']."' data-harga='".$data1['harga']."'onkeydown='return numbersonly(this, event);'> </td>

      <td>". $data1['satuan_retur'] ."</td>
      <td>". rp($data1['harga']) ."</td>
      <td><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
      <td><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>
      <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>


      <td><button class='btn btn-danger btn-hapus-tbs' id='btn-hapus-".$data1['id']."' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-faktur='". $data1['no_faktur_pembelian'] ."' data-subtotal='". $data1['subtotal'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>

      </tr>";
      }

//Untuk Memutuskan Koneksi Ke Database
           mysqli_close($db);  

      
    ?>
    </tbody>

  </table>
  </span> <!--tag penutup span-->
  </div>

                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah retur jika ingin mengedit.</i></h6>					

	</div><!-- end of col sm 8 --> <!--tag penutup col sm 8-->

  <div class="col-sm-4"> <!--tag pembuka col sm 4-->

  <form action="proses_bayar_retur_beli.php" id="form_beli" method="POST"><!--tag pembuka form-->

<div class="row">
  <div class="col-sm-12">
      <label><b> Subtotal </b></label><br>
      <b> <input style="height: 20px;" type="text" name="total" id="total_retur_pembelian1" class="form-control" placeholder="Total" readonly="" > </b>
  </div>

  <div class="col-sm-12">
			<label><b> Total Akhir </b></label><br>
      <!--readonly = agar tek yang ada kolom total tidak bisa diubah hanya bisa dibaca-->
			<b> <input style="height: 20px; font-size: 25px;" type="text" name="total" id="total_retur_pembelian" class="form-control" placeholder="Total" readonly="" > </b>
</div>
</div>
           
<div class="row">
  <div class="col-sm-4">
      <label><b> Potongan (Rp) </b></label><br>
      <input style="height: 20px" type="text" name="potongan" id="potongan_pembelian" class="form-control" data-diskon="" placeholder="Potongan" autocomplete="off">
  </div>


  <div class="col-sm-4">
      <label><b> Potongan (%) </b></label><br>
      <input style="height: 20px" type="text" name="potongan_persen" id="potongan_persen" class="form-control" data-diskon="" placeholder="Potongan" autocomplete="off">
  </div>


  <div class="col-sm-4">
      <label><b> Tax (%) </b></label><br>
      <input style="height: 20px" type="text" name="tax" id="tax" class="form-control" placeholder="Tax" data-pajak="" autocomplete="off">
  </div>

  <div class="col-sm-12">
      <label><b> Pembayaran </b></label><br>
      <input style="height: 20px; font-size: 20px;" type="text" name="pembayaran" id="pembayaran_pembelian" autocomplete="off" class="form-control" placeholder="Pembayaran" >
  </div>
</div>
          

      

      <label> <b>Kembalian</b>  </label><br>
      <input style="height: 20px" type="text" name="sisa" id="sisa_pembayaran_pembelian" class="form-control" placeholder="Sisa Pembayaran" readonly="" >
      
      <input type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah"><br>

      <input type="hidden" name="ppn_input" id="ppn_input" value="Include" class="form-control" placeholder="ppn input">  
      
      

      


<!-- memasukan teks pada kolom suplier, dan nomor faktur namun disembunyikan -->
      <input type="hidden" name="session_id" class="form-control" value="<?php echo $session_id; ?>" required="" >

      <input type="hidden" name="nama_suplier" id="supplier" class="form-control" required="" >
  
  


      <!--membuat tombol submit bayar & Hutang-->
			<button type="submit" id="pembayaran" class="btn btn-info"><i class='fa fa-send'> </i>  Bayar </button>
      
      <a class="btn btn-info" href="form_retur_pembelian.php" id="transaksi_baru" style="display: none"> <i class="fa fa-refresh"></i> Transaksi Baru</a>


      <!--membuaat link pada tombol batal-->
      <a href='batal_retur_pembelian.php?session_id=<?php echo $session_id;?>' id="batal" class='btn btn-danger'><i class='fa fa-close'></i> Batal </a>

      <a href='cetak_retur_pembelian.php' id="cetak_retur" style="display: none;" class="btn btn-success" target="blank"><i class="fa fa-print"> </i> Cetak Retur Penjualan </a>
     

					</form><!--tag penutup form-->
<div class="alert alert-success" id="alert_berhasil" style="display:none">
  <strong>Success!</strong> Pembayaran Berhasil
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
        <h4 class="modal-title">Konfirmasi Hapus Tbs Retur Penjualan</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nomor Faktur :</label>
          <input type="text" id="hapus_faktur" class="form-control" readonly="">
    <label> Kode Barang :</label>   
          <input type="text" id="hapus_kode" class="form-control" readonly="">           


     <input type="hidden" id="id_hapus" class="form-control" > 
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
        <h4 class="modal-title">Edit Data Retur Pembelian</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Jumlah Baru:</label>
     <input type="text" class="form-control" autocomplete="off" id="barang_edit"><br>
    <label for="email">Jumlah Lama:</label>
     <input type="text" class="form-control" id="barang_lama" readonly="">
     <input type="hidden" class="form-control" id="harga_edit" readonly="">
     <input type="hidden" class="form-control" id="id_edit">
     <input type="hidden" class="form-control" id="kode_edit">
    
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


<span id="demo"> </span>

</div><!-- end of container -->


    
<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('#tableuser').DataTable();


});
  
</script>



<!-- cek stok satuan konversi change-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#satuan_konversi").change(function(){
      var jumlah_retur = $("#jumlah_retur").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
      var id_produk = $("#id_produk").val();
      var prev = $("#satuan_produk").val();
      var no_faktur = $("#no_faktur2").val();
      var harga_lama = $("#harga_lama").val();

      $.post("cek_stok_konversi_retur_pembelian.php",
        {jumlah_retur:jumlah_retur,satuan_konversi:satuan_konversi,kode_barang:kode_barang,
        id_produk:id_produk,no_faktur:no_faktur},function(data){

          if (data < 0) {
          alert("Jumlah Melebihi Transaksi Pembelian");
          $("#jumlah_retur").val('');
          $("#satuan_konversi").val(prev);
          $("#harga_produk").val(harga_lama);
          $("#harga_baru").val(harga_lama);
          }

      });
    });
  });
</script>
<!-- end cek stok satuan konversi change-->

<!-- cek stok satuan konversi keyup-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#jumlah_retur").keyup(function(){
      var jumlah_retur = $("#jumlah_retur").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
      var id_produk = $("#id_produk").val();
      var prev = $("#satuan_produk").val();
      var no_faktur = $("#no_faktur2").val();
      var harga_lama = $("#harga_lama").val();

      $.post("cek_stok_konversi_retur_pembelian.php",
        {jumlah_retur:jumlah_retur,satuan_konversi:satuan_konversi,kode_barang:kode_barang,
        id_produk:id_produk,no_faktur:no_faktur},function(data){

          if (data < 0) {
            alert("Jumlah Melebihi Transaksi Pembelian");
            $("#jumlah_retur").val('');
          $("#satuan_konversi").val(prev);
          $("#harga_produk").val(harga_lama);
          $("#harga_baru").val(harga_lama);
          }

      });
    });
  });
</script>
<!-- cek stok satuan konversi keyup-->



<script>
$(document).ready(function(){
    $("#satuan_konversi").change(function(){

      var prev = $("#satuan_produk").val();
      var harga_lama = $("#harga_lama").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var id_produk = $("#id_produk").val();
      var harga_produk = $("#harga_lama").val();
      var jumlah_retur = $("#jumlah_retur").val();
      var kode_barang = $("#kode_barang").val();
      var satuan_pcs = $("#satuan_pcs").val();
      var harga_pcs = $("#harga_pcs").val();


      $.getJSON("cek_konversi_retur_pembelian.php",{kode_barang:kode_barang,satuan_konversi:satuan_konversi, id_produk:id_produk,harga_produk:harga_produk,jumlah_retur:jumlah_retur,harga_pcs:harga_pcs},function(info){

        if (satuan_konversi == satuan_pcs) {
          $("#harga_produk").val(harga_pcs);
          $("#harga_baru").val(harga_pcs);

        }
        else
        {
          if (satuan_konversi == prev) {
          
              $("#harga_produk").val(harga_lama);
              $("#harga_baru").val(harga_lama);


            }

            else if (info.jumlah_total == 0) {
             
              alert('Satuan Yang Anda Pilih Tidak Tersedia Untuk Produk Ini !');
              $("#satuan_konversi").val(prev);
              $("#harga_produk").val(harga_lama);
              $("#harga_baru").val(harga_lama);
         
            }

            else{
              $("#harga_produk").val(info.harga_pokok);
              $("#harga_baru").val(info.harga_pokok);
            }
        }
          

      });

        
    });

});
</script>


<!-- untuk memasukan perintah javascript -->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {
  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("satuan_produk").value = $(this).attr('satuan');
  document.getElementById("no_faktur2").value = $(this).attr('no_faktur');
  document.getElementById("harga_produk").value = $(this).attr('harga');
  document.getElementById("jumlahbarang").value = $(this).attr('jumlah-barang');
  document.getElementById("sisabarang").value = $(this).attr('sisa');
  document.getElementById("satuan_konversi").value = $(this).attr('satuan');
  document.getElementById("harga_lama").value = $(this).attr('harga');
  document.getElementById("harga_baru").value = $(this).attr('harga');
  document.getElementById("id_produk").value = $(this).attr('id_produk');
  document.getElementById("satuan_pcs").value = $(this).attr('satuan_pcs');
  document.getElementById("harga_pcs").value = $(this).attr('harga_pcs');
  document.getElementById("satuan_beli").value = $(this).attr('satuan_beli');

  
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


    var sisabarang = $("#sisabarang").val();
    var suplier = $("#nama_suplier").val();
    var kode_barang = $("#kode_barang").val();
    var nama_barang = $("#nama_barang").val();
    var satuan_produk = $("#satuan_konversi").val();
    var no_faktur2 = $("#no_faktur2").val();
    var ppn = $("#ppn"). val();
    var tax1 = $("#tax1").val();
    var satuan_beli = $("#satuan_beli").val();

    var jumlah_retur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_retur").val()))));
    var jumlah_beli = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlahbarang").val()))));
    var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_produk").val()))));
    var potongan1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
    var potongan2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan2").val()))));

    var sisa = sisabarang - jumlah_retur;

          if (potongan1 == '') 
          {
             potongan1 = 0;
          }

   

        else
          {
            var pos = potongan1.search("%");
           if (pos > 0) 
            {
               var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
               potongan_persen = potongan_persen.replace("%","");
               potongan1 = jumlah_retur * harga * potongan_persen / 100 ;
            };
          }


          var subtotal = parseInt(jumlah_retur, 10) *  parseInt(harga, 10) - parseInt(potongan1, 10);
          
          
          var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian").val()))));
          if (total == '') 
          {
          total = 0;
          };

    var total_akhir = parseInt(total,10) + parseInt(subtotal,10);


     $("#jumlah_retur").val('');
     $("#no_faktur2").val('');

 if (jumlah_retur == ""){
  alert("Jumlah Barang Harus Diisi");
  $("#jumlah_retur").focus();
  }

  else if (suplier == ""){
  alert("Suplier Harus Dipilih");
  }
  
  else
  {


    $("#total_retur_pembelian").val(tandaPemisahTitik(total_akhir));
    $("#total_retur_pembelian1").val(tandaPemisahTitik(total_akhir));
      $("#kode_barang").focus();

    $.post("proses_tbs_retur_pembelian.php",{kode_barang:kode_barang,jumlah_retur:jumlah_retur,satuan_produk:satuan_produk,nama_barang:nama_barang,no_faktur_pembelian:no_faktur2,harga:harga,potongan1:potongan1,tax1:tax1,satuan_beli:satuan_beli},function(info) {


      $("#tbody").prepend(info);
      $("#ppn").attr("disabled", true);
      $("#kode_barang").val('');
      $("#nama_barang").val('');
      $("#jumlah_retur").val('');
      $("#no_faktur2").val('');
      $("#potongan1").val('');
      $("#tax1").val('');
      $("#potongan2").val('');


       
   });
 
  }
      $("#formtambahproduk").submit(function(){
      return false;
      });
      


  });
  
     $("#cari_produk_pembelian").click(function() {
     
     //menyembunyikan notif berhasil
     $("#alert_berhasil").hide();

     var suplier = $("#nama_suplier").val();
     
     $.post("modal_retur_beli_baru.php", {suplier:suplier}, function(info) {
     
     
     $(".modal_retur_baru").html(info);
     
     
     });
     
     });
  

      
  </script>




 <script type="text/javascript">
  $(document).ready(function(){
$("#cari_produk_pembelian").click(function(){
  var session_id = $("#session_id").val();

  $.post("cek_tbs_retur_pembelian.php",{session_id: "<?php echo $session_id; ?>"},function(data){
        if (data != "1") {


             $("#ppn").attr("disabled", false);

        }
    });

});
});
</script>




 <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#pembayaran").click(function(){


  var sisa = $("#sisa_pembayaran_pembelian").val();
  var suplier = $("#nama_suplier").val();
  var total = $("#total_retur_pembelian").val();
  var carabayar = $("#carabayar1").val();
  var potongan_pembelian = $("#potongan_pembelian").val();
  var tax = $("#tax").val();
  var pembayaran_pembelian = $("#pembayaran_pembelian").val();
  var session_id = $("#session_id").val();
  var supplier = $("#supplier").val();
  var ppn_input = $("#ppn_input"). val();
  var total1 = $("#total_retur_pembelian1"). val();
  var satuan_dasar = $("#satuan_pcs"). val();





 if (sisa < 0 )
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }

 else if (total == "")
 {

  alert("Jumlah Total Kosong! Anda Belum Melakukan Pemesan");

 }

 else if (sisa == "")
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }



 else if (suplier == "") 
 {

alert("Suplier Harus Di Isi");

 }


 else

 {

  $("#transaksi_baru").show();
  $("#pembayaran").hide();
  $("#batal").hide();


$.post("proses_bayar_retur_beli.php",{session_id:session_id,sisa:sisa,nama_suplier:suplier,total:total,cara_bayar:carabayar,potongan:potongan_pembelian,tax:tax,pembayaran:pembayaran_pembelian,total1:total1,ppn_input:ppn_input,satuan_dasar:satuan_dasar},function(info) {

     $("#alert_berhasil").show();
     $("#result").html(info);
     $("#cetak_retur").show(); 
     $("#pembayaran_pembelian").val('');
     $("#sisa_pembayaran_pembelian").val('');
     $("#potongan_pembelian").val('');
     $("#tax").val('');
     $("#total_retur_pembelian1").val('');
    
       
   });

 }

 $("#form_beli").submit(function(){
    return false;
});



  });

                 $("#pembayaran").mouseleave(function(){
               
               $.get('no_faktur_rb.php', function(data) {
               /*optional stuff to do after getScript */ 
               
               $("#nofaktur_rb").val(data);
               
               });
               });

  
  
  
      
  </script>


<!-- start tax di tbs -->
<script type="text/javascript">
    $(document).ready(function(){
$("#tax1").keyup(function(){
        var tax = $("#tax1").val();
if (tax > 100)
{
  alert("Pajak Tidak Lebih Dari 100%");
  $("#tax1").val('');
}


});
});
</script>
<!-- ending tax di tbs -->


<!-- start potongan di tbs -->
<script type="text/javascript">
    $(document).ready(function(){
$("#potongan2").keyup(function(){
        var potongan2 = $("#potongan2").val();

if (potongan2 > 100)
{
  alert("Potongan Tidak Lebih Dari 100%");
  $("#potongan2").val('');
}


});
});
</script>


  <script type="text/javascript">
  
  // untuk memunculkan sisa pembayaran secara otomatis
  $(document).ready(function(){
$("#potongan1").keyup(function(){

        var potongan_tbs =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan1").val() ))));
        var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_produk").val()))));
        var jumlah_retur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_retur").val()))));

        var total = parseInt(harga, 10) * parseInt(jumlah_retur, 10);

        var potongan_tbs_persen = ((potongan_tbs / total) * 100);

        if (potongan_tbs != ""){
             $("#potongan1").attr("readonly", false);
              $("#potongan2").attr("readonly", true);

             }

        else{
              $("#potongan1").attr("readonly", false);
             $("#potongan2").attr("readonly", false);
             }




        $("#potongan2").val(parseInt(potongan_tbs_persen));

      });
    });


</script>

  <script type="text/javascript">
  
  // untuk memunculkan sisa pembayaran secara otomatis
  $(document).ready(function(){
$("#potongan2").keyup(function(){

        var potongan_tbs_persen =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan2").val() ))));
        var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_produk").val()))));
        var jumlah_retur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_retur").val()))));

        var total = parseInt(harga, 10) * parseInt(jumlah_retur, 10);

        var potongan_tbs = ((potongan_tbs_persen * total) / 100);

        if (potongan_tbs_persen != ""){
             $("#potongan2").attr("readonly", false);
              $("#potongan1").attr("readonly", true);

             }

        else{
              $("#potongan2").attr("readonly", false);
             $("#potongan1").attr("readonly", false);
             }

        $("#potongan1").val(parseInt(potongan_tbs));

      });
    });


</script>

<!-- ending potongan di tbs -->





  <script type="text/javascript">
  
  // untuk memunculkan sisa pembayaran secara otomatis
  $(document).ready(function(){
$("#potongan_pembelian").keyup(function(){

        var potongan_pembelian =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_pembelian").val() ))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian1").val()))));
        var potongan_persen = ((potongan_pembelian / total) * 100);
        var tax = $("#tax").val();

        if (tax == "") {
        tax = 0;
        }

        if (potongan_pembelian != ""){
             $("#potongan_pembelian").attr("readonly", false);
              $("#potongan_persen").attr("readonly", true);

             }

        else{
              $("#potongan_persen").attr("readonly", true);
             $("#potongan_pembelian").attr("readonly", false);
             }

             
             var sisa_potongan = total - potongan_pembelian;
             
             var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(Math.round(t_tax,10));

        
        $("#total_retur_pembelian").val(tandaPemisahTitik(parseInt(hasil_akhir)));
        $("#potongan_persen").val(parseInt(potongan_persen));

      });
    });


</script>

<script type="text/javascript">
  
  $(document).ready(function(){
        
        $("#potongan_persen").keyup(function(){

        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total_retur_pembelian1").val() ))));
        var potongan_rupiah = ((total * potongan_persen) / 100);
        var tax = $("#tax").val();

        if (tax == "") {
        tax = 0;
        }

        if (potongan_persen != ""){
              $("#potongan_persen").attr("readonly", false);
              $("#potongan_pembelian").attr("readonly", true);
             }

        else{
              $("#potongan_pembelian").attr("readonly", true);
              $("#potongan_persen").attr("readonly", false);
             }

      
             var sisa_potongan = total - potongan_rupiah;             
             var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(Math.round(t_tax,10));
        
        if (potongan_persen > 100) {
          alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
        }

        
        
        $("#total_retur_pembelian").val(tandaPemisahTitik(parseInt(hasil_akhir)));
        $("#potongan_pembelian").val(tandaPemisahTitik(parseInt(potongan_rupiah)));

      });

  });

</script>


<!-- start tax per faktur -->
<script type="text/javascript">
      
      $(document).ready(function(){


      $("#tax").keyup(function(){

        var potongan_rupiah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian1").val() ))));
       
              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();
              var t_total = total - potongan_rupiah;

              if (tax == "") {
                tax = 0;
              }
              else if (cara_bayar == "") {
                alert ("Kolom Cara Bayar Masih Kosong");
                 $("#tax").val('');
                 $("#potongan_pembelian").val('');
                 $("#potongan_persen").val('');
              }
              
              var t_tax = ((parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) * parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(tax,10)))))) / 100);

              var total_akhir = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) + Math.round(parseInt(t_tax,10));
              
          

              $("#total_retur_pembelian").val(tandaPemisahTitik(total_akhir));

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');

              }



        });
        });
      
</script>
<!-- ENDING tax per faktur -->


<script type="text/javascript">

$(document).ready(function(){

  var session_id = $("#session_id").val();

$.post("cek_total_retur_pembelian.php",
    {
        session_id: session_id
    },
    function(data){
        $("#total_retur_pembelian"). val(data);
            $("#total_retur_pembelian1"). val(data);
    });

});


</script>



<script>

// untuk memunculkan sisa pembayaran secara otomatis
  $(document).ready(function(){
    $("#pembayaran_pembelian").keyup(function(){
      var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_pembelian").val()))));
      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian").val()))));
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

        var cara_bayar = $("#carabayar1").val();

      //metode POST untuk mengirim dari file cek_jumlah_kas.php ke dalam variabel "dari akun"
      $.post('cek_jumlah_kas1.php', {cara_bayar : cara_bayar}, function(data) {
        /*optional stuff to do after success */

      $("#jumlah1").val(data);
      });

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

      if ( carabayar1 == "") 

      {
          $("#submit").hide();
        alert("Kolom Cara Bayar Masih Kosong");
        $("#pembayaran_pembelian").val('');

      }
      else {
        $("#submit").show();
      }


    });

  });
</script>


<script type="text/javascript">
  
$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  

</script>
                              

<script type="text/javascript">
    $(document).ready(function(){
      
//fungsi hapus data 
$(document).on('click','.btn-hapus-tbs',function(e){
    var no_faktur_pembelian = $(this).attr("data-faktur");
    var kode_barang = $(this).attr("data-kode-barang");
    var id = $(this).attr("data-id");
    var subtotal_tbs = $(this).attr("data-subtotal");
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian1").val()))));

    if (total == '') 
        {
          total = 0;
        };
      var total_akhir = parseInt(total,10) - parseInt(subtotal_tbs,10);

      $("#total_retur_pembelian").val(tandaPemisahTitik(total_akhir));
      $("#total_retur_pembelian1").val(tandaPemisahTitik(total_akhir));



    $.post("hapus_tbs_retur_pembelian.php",{id:id,kode_barang:kode_barang,no_faktur_pembelian:no_faktur_pembelian},function(data){

    $("#kode_barang").focus();
    $(".tr-id-"+id+"").remove();
    

    
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


//end fungsi hapus data
</script>

       <script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){
          var kode_barang = $("#kode_barang").val();
          $("#jumlah_barang").val(kode_barang);
          var session_id = $("#session_id").val();
          var no_faktur_pembelian = $("#no_faktur2").val();
            
            $.post('cek_kode_barang_tbs_retur_pembelian.php',{kode_barang:kode_barang,session_id:session_id,no_faktur_pembelian:no_faktur_pembelian}, function(data){
            
            if(data == 1){
            alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
            $("#kode_barang").val('');
            $("#nama_barang").val('');
            }//penutup if
            
            });////penutup function(data)


      $.getJSON('lihat_retur_pembelian.php',{kode_barang:kode_barang}, function(json){
      
      if (json == null)
      {
        
                $('#nama_barang').val('');
                $('#jumlahbarang').val('');
                $('#satuan_produk').val('');
                $('#harga_produk').val('');
                $('#no_faktur2').val('');
                $('#sisabarang').val('');
      }





      else 
      {
        $('#nama_barang').val(json.nama_barang);
        $('#jumlahbarang').val(json.jumlah_barang);
        $('#satuan_produk').val(json.satuan);
        $('#harga_produk').val(json.harga);
        $('#no_faktur2').val(json.no_fakturhidden);
        $('#sisabarang').val(json.sisa);
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
    var no_faktur_pembelian = $("#no_faktur2").val();

 $.post('cek_kode_barang_tbs_retur_pembelian.php',{kode_barang:kode_barang,session_id:session_id,no_faktur_pembelian:no_faktur_pembelian}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
   }//penutup if

    });////penutup function(data)


    });//penutup click(function()
  });//penutup ready(function()
</script>

<script type="text/javascript">
    $(document).ready(function(){

      $("#tax").attr("disabled", true);


    $("#ppn").change(function(){

    var ppn = $("#ppn").val();
    $("#ppn_input").val(ppn);

  if (ppn == "Include"){

      $("#tax").attr("disabled", true);
      $("#tax1").attr("disabled", false);
  }

  else if (ppn == "Exclude") {
    $("#tax1").attr("disabled", true);
      $("#tax").attr("disabled", false);
  }
  else{

    $("#tax1").attr("disabled", true);
      $("#tax").attr("disabled", true);
  }


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
                                    if (jumlah_baru == '')
                                    {
                                      jumlah_baru = 0;
                                    }
                                    var kode_barang = $(this).attr("data-kode");
                                    var no_faktur = $(this).attr("data-faktur");
                                    var harga = $(this).attr("data-harga");
                                    var satuan = $(this).attr("data-satuan");

                                    var jumlah_retur = $("#text-jumlah-"+id+"").text();

                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                   
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));

                                    var subtotal = parseInt(harga,10) * parseInt(jumlah_baru,10) - parseInt(potongan,10);
                                    
                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian").val()))));
                                    
                                    subtotal_penjualan = parseInt(subtotal_penjualan,10) - parseInt(subtotal_lama,10) + parseInt(subtotal,10);

                                    var tax_tbs = tax / subtotal_lama * 100;
                                    var jumlah_tax = tax_tbs * subtotal / 100;

                                      if (jumlah_baru == 0) {

                                      alert ("Jumlah Retur Tidak Boleh 0!");

                                      $("#input-jumlah-"+id+"").val(jumlah_retur);
                                       $("#text-jumlah-"+id+"").text(jumlah_retur);
                                       $("#text-jumlah-"+id+"").show();
                                       $("#input-jumlah-"+id+"").attr("type", "hidden");
                                    }

                                    else{

                                    $.post("cek_stok_pesanan_barang_retur_pembelian.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru, no_faktur:no_faktur,satuan:satuan},function(data){

                                      if (data < 0) {

                                       alert ("Jumlah Yang Di Masukan Melebihi Stok !");
                                        $("#input-jumlah-"+id+"").val(jumlah_retur);
                                       $("#text-jumlah-"+id+"").show();
                                        $("#input-jumlah-"+id+"").attr("type", "hidden");
                                     }


                                      else if (jumlah_baru == '0') {

                                       alert ("Jumlah Yang Di Masukan Tidak Boleh (0/Kosong) ");
                                        $("#input-jumlah-"+id+"").val(jumlah_retur);
                                       $("#text-jumlah-"+id+"").show();
                                        $("#input-jumlah-"+id+"").attr("type", "hidden");
                                     }

                                      else {

                                     $.post("update_pesanan_barang_retur_pembelian.php",{harga:harga,jumlah_retur:jumlah_retur,jumlah_tax:jumlah_tax,potongan:potongan,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,subtotal:subtotal},function(info){

                            
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#btn-hapus-"+id).attr("data-subtotal", subtotal);
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#text-tax-"+id+"").text(jumlah_tax);
                                    $("#total_retur_pembelian").val(tandaPemisahTitik(subtotal_penjualan)); 
                                    $("#total_retur_pembelian1").val(tandaPemisahTitik(subtotal_penjualan));         

                                    });

                                   }

                                 });

                                  }// else
       
                                    $("#kode_barang").focus();

                                 });

                             </script>

<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>