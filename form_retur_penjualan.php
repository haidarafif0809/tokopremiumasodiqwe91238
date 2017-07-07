<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT * FROM retur_penjualan");

$query_default_ppn = $db->query("SELECT setting_ppn, nilai_ppn FROM perusahaan");
$data_default_ppn = mysqli_fetch_array($query_default_ppn);
$default_ppn = $data_default_ppn['setting_ppn'];
$nilai_ppn = $data_default_ppn['nilai_ppn'];

$session_id = session_id();


 ?>

<!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
<div style="padding-left: 5%; padding-right: 5%;">


          <h3> <u>FORM RETUR PENJUALAN</u> </h3><br> 





  <!-- membuat form menjadi beberapa bagian -->
  <form enctype="multipart/form-data" role="form" action="form_retur_penjualan.php" method="post ">

					<input type="hidden" name="session_id" id="session_id" class="form-control" readonly="" value="<?php echo $session_id; ?>"  >

	<div class="row">
    <div class="col-sm-2">
          <label> Kode Pelanggan </label> </label><br>
          
          <select data-placeholder="--SILAHKAN PILIH--" name="kode_pelanggan" id="kd_pelanggan" class="form-control chosen">
          
          <?php 
          
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT id, kode_pelanggan, nama_pelanggan FROM pelanggan");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id'] ."' >".$data['kode_pelanggan'] ." - ".$data['nama_pelanggan'] ."</option>";
          
          }
          
          
          ?>
          </select>
    </div>

    <div class="col-sm-2" style="display: none">
          <label> <b> User </b> </label><br>
          <input type="text" name="user" class="form-control" readonly="" style="height: 15px" value="<?php echo $_SESSION['user_name']; ?>" required="">
    </div>

<div class="col-sm-2">
<label class="gg">PPN</label>
<select type="hidden" style="font-size:15px; height:35px" name="ppn" id="ppn" class="form-control chosen">
  <?php if ($default_ppn == 'Include'): ?>    
    <option selected>Include</option>  
    <option>Exclude</option>  
    <option>Non</option>
  <?php endif ?>

  <?php if ($default_ppn == 'Exclude'): ?>
    <option selected>Exclude</option>  
    <option>Non</option>
    <option>Include</option>  
  <?php endif ?>

  <?php if ($default_ppn == 'Non'): ?>
    <option selected>Non</option>
    <option>Include</option>  
    <option>Exclude</option>  
  <?php endif ?>
</select>
</div>
    
    <div class="col-sm-2"> 
             <label> <b> Cara Bayar </b> </label><br>
             <select type="text" name="cara_bayar" id="carabayar1" class="form-control chosen" >
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

  </div>

          </form> <!-- tag penutup form -->


 <!--membuat tampilan halaman menjadi 8 bagian-->
  <div class="col-sm-8">



<!-- membuat tombol agar menampilkan modal -->
<button type="button" class="btn btn-info" id="cari_produk_pembelian" data-toggle="modal" data-target="#myModal"><i class='fa fa-search'> </i> Cari</button>
<br><br>
<!-- Tampilan Modal -->
<div id="myModal" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Isi Modal-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Detail Penjualan</h4>
      </div>
      <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->


<span class="modal_retur_baru">

      <!--perintah agar modal update-->

<div class="table-responsive">
      <!-- membuat agar ada garis pada tabel, disetiap kolom-->
        <table id="tableuser" class="table table-bordered table-sm">
    <thead> <!-- untuk memberikan nama pada kolom tabel -->
      
      <th> Nomor Faktur </th>
      <th> Kode Barang </th>
      <th> Nama Barang </th>
      <!--
      <th> Jumlah Beli </th>
      -->
      <th> Satuan </th>
      <th> Harga   </th>
      <th> Subtotal </th>
      <th> Potongan </th>
      <th> Tax </th>
      <th> Sisa Barang </th>
      
    </thead> <!-- tag penutup tabel -->
    
    <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
    <?php




    // menampilkan seluruh data yang ada pada tabel barang yang terdapat pada DB
    $perintah = $db->query("SELECT dp.no_faktur, dp.tanggal, dp.kode_barang, dp.nama_barang, dp.jumlah_barang, dp.satuan, dp.harga, dp.subtotal, dp.potongan, dp.tax, dp.status, dp.sisa, p.kode_pelanggan, pl.nama_pelanggan FROM detail_penjualan dp INNER JOIN penjualan p ON dp.no_faktur = p.no_faktur INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan WHERE dp.sisa > '0' ");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr class='pilih' data-kode='". $data1['kode_barang'] ."' nama-barang='". $data1['nama_barang'] ."'
      satuan='". $data1['satuan'] ."' no_faktur='". $data1['no_faktur'] ."' harga='". $data1['harga'] ."' jumlah-barang='". $data1['jumlah_barang'] ."' sisa='". $data1['sisa'] ."' >
      
      <td>". $data1['no_faktur'] ."</td>
      <td>". $data1['kode_pelanggan'] ." - ". $data1['nama_pelanggan'] ."</td>
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>
      <td>". $data1['satuan'] ."</td>
      <td>". rp($data1['harga']) ."</td>
      <td>". rp($data1['subtotal']) ."</td>
      <td>". rp($data1['potongan']) ."</td>
      <td>". rp($data1['tax']) ."</td>
      <td>". $data1['sisa'] ."</td>
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
 <form class="form" action="proses_tbs_retur_penjualan.php" role="form" id="formtambahproduk">
  
<div class="row">

  <div class="form-group col-sm-2">
    <input type="text" class="form-control" name="kode_barang" autocomplete="off" id="kode_barang" placeholder="Kode Produk" style="height: 20px">
    </div>


  <div class="form-group col-sm-2"> <!-- agar tampilan berada pada satu group -->
  <!-- memasukan teks pada kolom kode barang -->
  <input type="text" class="form-control" readonly="" name="nama_barang" id="nama_barang" placeholder="Nama Barang" style="height: 20px">
  </div>
  

  <div class="form-group col-sm-1">
    <input type="text" class="form-control" name="jumlah_retur" id="jumlah_retur" autocomplete="off" placeholder="0"  style="height: 20px">
  </div>
 
 <div class="form-group col-sm-1">
          
          <select name="satuan_konversi" id="satuan_konversi" class="form-control"  >
          
          <?php 
          
          
          $query = $db->query("SELECT id, nama  FROM satuan");
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
          }
                      
          ?>
          
          </select>

        </div>

  
  <div class="form-group col-sm-2">
  <input type="text" id="harga_produk" name="harga" class="form-control" autocomplete="off" value="" placeholder="Harga"style="height: 20px">
  </div>

    <div class="form-group col-sm-1">
  <input type="text" id="potongan1" name="potongan1" class="form-control" autocomplete="off" value="" placeholder="Diskon"style="height: 20px">
  </div>

  <div class="col-sm-1">
    <?php if ($default_ppn == 'Include'): ?>
      <input style="height:15px;" type="text" class="form-control" name="tax" autocomplete="off" id="tax1" value="<?php echo $nilai_ppn ?>" placeholder="Tax%" >
    <?php else: ?>
      <input style="height:15px;" type="text" class="form-control" name="tax" autocomplete="off" id="tax1" placeholder="Tax%" >
    <?php endif ?>      
  </div>

  <div class="form-group col-sm-2">
    <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah Produk</button>
  </div>

</div>
  


    <input type="hidden" class="form-control" name="harga_lama" id="harga_lama">
    <input type="hidden" class="form-control" name="harga_baru" id="harga_baru">
    <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">
    <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
    <input type="hidden" id="satuan_jual" name="satuan" class="form-control" value="" required="">
    <input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" required="">
    
    <input type="hidden" id="harga_pcs" name="harga_pcs" class="form-control" value="" required="">    
    <input type="hidden" id="satuan_pcs" name="satuan_pcs" class="form-control" value="" required="">
    <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo $session_id; ?>">
    <input type="hidden" id="no_faktur2" name="no_faktur_penjualan" class="form-control" = required="">
    <input type="hidden" name="jumlah_beli" class="form-control" value="<?php echo $data1['jumlah_barang']; ?>">
    <input type="hidden" id="sisabarang" name="sisa" class="form-control" value="">
    <br><br>

  
</form>
									

      

  <div class="table-responsive"><!--tag untuk membuat garis pada tabel-->   
  <span id="result">      
  <table id="table" class="table table-bordered table-sm">
    <thead>
      <th> Faktur Penjualan </th>
      <th> Nama Barang</th>
      <th> Kode Barang </th>
      <th> Jumlah Jual </th>
      <th> Satuan Jual</th>
      <th> Jumlah Retur </th>
      <th> Satuan Retur</th>
      <th> Harga </th>
      <th> Potongan </th>
      <th> Pajak </th>
      <th> Subtotal </th>
      <th> Hapus </th>
      
      
    </thead>
    
    <tbody id="tbody">
     <?php

    //untuk menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
    $perintah = $db->query("SELECT tp.id, tp.no_faktur_penjualan, tp.nama_barang, tp.kode_barang, tp.jumlah_beli, tp.jumlah_retur, tp.satuan, tp.harga, tp.harga, tp.potongan, tp.tax, tp.subtotal, s.nama AS satuan_retur,ss.nama AS satuan_jual FROM tbs_retur_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id INNER JOIN satuan ss ON tp.satuan_jual = ss.id  WHERE tp.session_id = '$session_id'");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr class='tr-id-".$data1['id']."'>
      <td>". $data1['no_faktur_penjualan'] ."</td>
      <td>". $data1['nama_barang'] ."</td>
      <td>". $data1['kode_barang'] ."</td>
      <td>". rp($data1['jumlah_beli']) ."</td>
      <td>". $data1['satuan_jual'] ."</td>

      <td class='edit-jumlah' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur_penjualan']."' data-kode='".$data1['kode_barang']."'> <span id='text-jumlah-".$data1['id']."'> ".koma($data1['jumlah_retur'],2)." </span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".koma($data1['jumlah_retur'],2)."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-faktur='".$data1['no_faktur_penjualan']."' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' data-satuan='".$data1['satuan']."'> </td>


      <td>". $data1['satuan_retur'] ."</td>
      <td>". rp($data1['harga']) ."</td>
      <td><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
      <td><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>
      <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>


      <td> <button class='btn btn-danger btn-hapus-tbs' id='btn-hapus-".$data1['id']."' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-faktur='". $data1['no_faktur_penjualan'] ."' data-subtotal='". $data1['subtotal'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 



      </tr>";
      }

   //Untuk Memutuskan Koneksi Ke Database
             mysqli_close($db);
    ?>
    </tbody>

  </table>
</span> <!--tag penutup span-->
  </div>


	</div><!-- end of col sm 8 --> <!--tag penutup col sm 8-->

<div class="col-sm-4"> <!--tag pembuka col sm 4-->

<div class="card card-block">

  <form action="proses_bayar_retur_jual.php" id="form_beli" method="POST"><!--tag pembuka form-->
      
      <label> <b> Subtotal</b> </label><br>
      <input type="text" name="total" id="total_retur_pembelian1" class="form-control" placeholder="Total" readonly="" style="height: 25px; font-size: 25px" >

      <div class="row">
        <div class="col-sm-6">
            <label> <b> Potongan (Rp) </b> </label><br>
            <input type="text" name="potongan" id="potongan_pembelian" class="form-control" data-diskon="" placeholder="Potongan" autocomplete="off"style="height: 25px" >
        </div>
        <div class="col-sm-6">
            <label> <b> Potongan (%) </b> </label><br>
            <input type="text" name="potongan_persen" id="potongan_persen" class="form-control" data-diskon="" placeholder="Potongan" autocomplete="off"style="height: 25px" >
        </div>
        <div class="col-sm-4" style="display: none">
            <label> <b> Tax (%)</b> </label><br>
            <input type="text" name="tax" id="tax" class="form-control" placeholder="Tax" data-pajak="" autocomplete="off"style="height: 25px" >
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
            <label> <b> Total Akhir</b> </label><br>
            <input type="text" name="total" id="total_retur_pembelian" class="form-control" placeholder="Total" readonly="" style="font-size: 25px">
        </div>
        <div class="col-sm-6">
            <label> <b> Pembayaran </b> </label><br>
            <input type="text" name="pembayaran" id="pembayaran_pembelian" autocomplete="off" class="form-control" placeholder="Pembayaran" style="font-size: 25px" style="height: 25px" >
        </div>
      </div>

      <label> <b> Kembalian </b> </label><br>
      <input type="text" name="sisa" id="sisa_pembayaran_pembelian" class="form-control" placeholder="Sisa Pembayaran" readonly="" style="height: 25px" >

      <input type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah"><br> 

      <input type="hidden" name="ppn_input" id="ppn_input" value="Include" class="form-control" placeholder="ppn input">


<!-- memasukan teks pada kolom suplier, dan nomor faktur namun disembunyikan -->
      <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo $session_id; ?>">

      <input type="hidden" name="kode_pelanggan" id="kd_pelanggan1" class="form-control">
  
  

		

      <!--membuat tombol submit bayar & Hutang-->
			<button type="submit" id="pembayaran" class="btn btn-info"> <i class='fa fa-send'> </i> Bayar </button>
      
      <a class="btn btn-info" href="form_retur_penjualan.php" id="transaksi_baru" style="display: none"> <i class="fa fa-refresh"></i> Transaksi Baru</a>

      <!--membuaat link pada tombol batal-->
      <a href='batal_retur_penjualan.php?session_id=<?php echo $session_id;?>' id="batal" class='btn btn-danger'><i class='fa fa-close'> </i> Batal </a>

      <a href='cetak_retur_penjualan.php' id="cetak_retur" style="display: none;" class="btn btn-success" target="blank"><i class="fa fa-print"> </i> Cetak Retur Penjualan </a>

  
  </form><!--tag penutup form-->

</div>

<div class="alert alert-success" id="alert_berhasil" style="display:none">
  <strong>Success!</strong> Pembayaran Berhasil
</div>
  </div><!-- end of col sm 4 -->
</div><!-- end of row -->


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal" role="dialog">
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
    <label> Kode Barang :</label>
     <input type="text" id="hapus_kode" class="form-control" readonly=""> 
     <input type="hidden" id="hapus_faktur" class="form-control" readonly=""> 
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
<div id="modal_edit" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Retur Penjualan</h4>
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

     <input type="hidden" class="form-control" id="jumlah_edit">
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
  document.getElementById("harga_lama").value = $(this).attr('harga');
  document.getElementById("harga_baru").value = $(this).attr('harga');
  document.getElementById("satuan_konversi").value = $(this).attr('satuan');
  document.getElementById("id_produk").value = $(this).attr('id_produk');
  document.getElementById("satuan_pcs").value = $(this).attr('asal_satuan');
  document.getElementById("harga_pcs").value = $(this).attr('harga_pcs');
  document.getElementById("satuan_jual").value = $(this).attr('satuan');

  $('#myModal').modal('hide');
  });
   

// tabel lookup table_barang
  $(function () {
  $("#table_barang").dataTable();
  });

   
  </script> <!--tag penutup perintah java script-->


   <script>
   //perintah javascript yang diambil dari form tbs penjualan dengan id=form tambah produk

  
   $("#submit_produk").click(function(){

    var sisabarang = $("#sisabarang").val();
    var kode_pelanggan = $("#kd_pelanggan").val();
    var nama_barang = $("#nama_barang").val();
    var satuan_produk = $("#satuan_konversi").val();
    var session_id = $("#session_id").val();
    var kode_barang = $("#kode_barang").val();
    var no_faktur = $("#no_faktur2").val();
    var tax1 = $("#tax1").val();
    var ppn = $("#ppn").val();
    var satuan_jual = $("#satuan_jual").val();

    var jumlah_retur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_retur").val()))));
    var jumlahbarang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlahbarang").val()))));
    var harga = $("#harga_produk").val();
    var potongan1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));


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

          var subtotal = parseFloat(jumlah_retur, 10) *  parseFloat(harga, 10) - parseFloat(potongan1, 10);
          
          
          var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian").val()))));
          if (total == '') 
          {
          total = 0;
          };

    var total_akhir = parseFloat(total,10) + parseFloat(subtotal,10);


  
if (jumlah_retur == ""){
  alert("Jumlah Barang Harus Diisi");
  }
  else if (kode_pelanggan == ""){
  alert("Kode Pelanggan Harus Dipilih");
  }
  else
  {


    $("#total_retur_pembelian").val(tandaPemisahTitik(total_akhir));
    $("#total_retur_pembelian1").val(tandaPemisahTitik(total_akhir));
     

    $.post("proses_tbs_retur_penjualan.php",{session_id:session_id,no_faktur_penjualan:no_faktur,kode_barang:kode_barang,jumlah_retur:jumlah_retur,satuan_produk:satuan_produk,nama_barang:nama_barang,harga:harga,potongan1:potongan1,tax1:tax1,satuan_jual:satuan_jual},function(info) {


     $("#ppn").attr("disabled", true).trigger("chosen:updated");
     $("#tbody").prepend(info);
     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_retur").val('');
     $("#no_faktur2").val('');
     $("#harga_produk").val('');
     $("#kode_barang").focus();


       
   });
 
}


  });

      $("#formtambahproduk").submit(function(){
    return false;
});
  


  
      $("#cari_produk_pembelian").click(function() {
      $.get('no_faktur_rj.php', function(data) {
      /*optional stuff to do after getScript */ 
      $("#nomorfaktur").val(data);
      $("#cetak_retur").hide(''); 
      });
      //modal baru
      

      //menyembunyikan notif berhasil
      $("#alert_berhasil").hide();
      /* Act on the event */
      
var kode_pelanggan = $("#kd_pelanggan").val();

 $.post("modal_retur_jual_baru.php", {kode_pelanggan:kode_pelanggan}, function(info) {


$(".modal_retur_baru").html(info);
      
      
      });

  });
  
      
  </script>




 <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#pembayaran").click(function(){


  var sisa = $("#sisa_pembayaran_pembelian").val();
  var kode_pelanggan = $("#kd_pelanggan").val();
  var total = $("#total_retur_pembelian").val();
  var carabayar = $("#carabayar1").val();
  var potongan_pembelian = $("#potongan_pembelian").val();
  var tax = $("#tax").val();
  var pembayaran_pembelian = $("#pembayaran_pembelian").val();
  var session_id = $("#session_id").val();
  var total1 = $("#total_retur_pembelian1").val();
  var ppn_input = $("#ppn_input").val();
  var jumlah_kas = $("#jumlah1").val();

      if (sisa < 0) 

      {
        alert("Jumlah Kas Tidak Mencukupi Atau Kolom Cara Bayar Masih Kosong");
      }

  else if (total == "")
 {

  alert("Jumlah Total Kosong! Anda Belum Melakukan Pemesan");

 }

 else if (sisa == "")
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }


 else if ( kode_pelanggan == "") 
 {

alert("Kode Pelanggan Harus Di Isi");

 }


 else if (jumlah_retur == "0")
 {

  alert("jumlah Retur Harus Di Isi");

 }


 else

 {

  $("#transaksi_baru").show();
  $("#pembayaran").hide();
  $("#batal").hide();

 $.post("proses_bayar_retur_jual.php",{session_id:session_id,sisa:sisa,kode_pelanggan:kode_pelanggan,total:total,cara_bayar:carabayar,potongan:potongan_pembelian,tax:tax,pembayaran:pembayaran_pembelian,total1:total1,ppn_input:ppn_input},function(info) {

     $("#demo").html(info);
     $("#result").html(info);
     $("#alert_berhasil").show();
     $("#cetak_retur").show();    
     $("#total_retur_pembelian").val('');
     $("#pembayaran_pembelian").val('');
     $("#sisa_pembayaran_pembelian").val('');
     $("#potongan_pembelian").val('');
     $("#tax").val('');
     $("#total_retur_pembelian1"). val('');
  
    
       
   });

 }

 $("form").submit(function(){
    return false;
});



  });


                $("#pembayaran").mouseleave(function(){
               
               $.get('no_faktur_rj.php', function(data) {
               /*optional stuff to do after getScript */ 
               
               $("#noretur_jl").val(data);
               
               });
               });
  
  
      
  </script>

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
             
             var t_tax = ((parseFloat(sisa_potongan,10) * parseFloat(tax,10)) / 100);
             var hasil_akhir = parseFloat(sisa_potongan, 10) + parseFloat(t_tax,10);

        
        $("#total_retur_pembelian").val(tandaPemisahTitik(parseFloat(hasil_akhir)));
        $("#potongan_persen").val(parseFloat(potongan_persen));

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
             var t_tax = ((parseFloat(sisa_potongan,10) * parseFloat(tax,10)) / 100);
             var hasil_akhir = parseFloat(sisa_potongan, 10) + parseFloat(t_tax,10);
        
        if (potongan_persen > 100) {
          alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
        }

        
        
        $("#total_retur_pembelian").val(tandaPemisahTitik(parseFloat(hasil_akhir)));
        $("#potongan_pembelian").val(tandaPemisahTitik(parseFloat(potongan_rupiah)));

      });

  });

</script>

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
              
              var t_tax = ((parseFloat(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) * parseFloat(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(tax,10)))))) / 100);

              var total_akhir = parseFloat(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) + Math.round(parseFloat(t_tax,10));
              
              
              $("#total_retur_pembelian").val(tandaPemisahTitik(total_akhir));

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');

              }



        });
        });
      
</script>


<script type="text/javascript">


// untuk memunculkan data cek total penjualan
$(document).ready(function(){

    var session_id = $("#session_id").val();
    
$.post("cek_total_retur_penjualan.php", {session_id: session_id},function(data){

        if (data == "") {
          var subtotal = 0.00;
        }
        else{
          var subtotal = parseFloat(data);
        }

        
        console.log(subtotal);
        console.log(data)
        

        $("#total_retur_pembelian"). val(subtotal);
        $("#total_retur_pembelian1"). val(subtotal);
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
    $("#kd_pelanggan").change(function(){
      var kode_pelanggan = $("#kd_pelanggan").val();
      $("#kd_pelanggan1").val(kode_pelanggan);
        
    });
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

      $.post("cek_stok_konversi_retur_penjualan.php",
        {jumlah_retur:jumlah_retur,satuan_konversi:satuan_konversi,kode_barang:kode_barang,
        id_produk:id_produk,no_faktur:no_faktur},function(data){

          if (data < 0) {
            alert("Jumlah Melebihi Transaksi Penjualan");
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

      $.post("cek_stok_konversi_retur_penjualan.php",
        {jumlah_retur:jumlah_retur,satuan_konversi:satuan_konversi,kode_barang:kode_barang,
        id_produk:id_produk,no_faktur:no_faktur},function(data){

          if (data < 0) {
            alert("Jumlah Melebihi Transaksi Penjualan");
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


      $.getJSON("cek_konversi_retur_penjualan.php",{kode_barang:kode_barang,satuan_konversi:satuan_konversi, id_produk:id_produk,harga_produk:harga_produk,jumlah_retur:jumlah_retur,harga_pcs:harga_pcs},function(info){

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
 $(document).ready(function(){


// untuk memunculkan jumlah kas secara otomatis
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

<script type="text/javascript">
  
$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  

</script>

  <script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var session_id = $("#session_id").val();
    var kode_barang = $("#kode_barang").val();
    var no_faktur2 = $("#no_faktur2").val();

 $.post('cek_kode_barang_tbs_retur_penjualan.php',{kode_barang:kode_barang,session_id:session_id,no_faktur2:no_faktur2}, function(data){
  
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
      
//fungsi hapus data 

$(document).on('click','.btn-hapus-tbs',function(e){
    var kode_barang = $(this).attr("data-kode-barang");
    var no_faktur = $(this).attr("data-faktur");
    var id = $(this).attr("data-id");

    var subtotal_tbs = $(this).attr("data-subtotal");
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian1").val()))));

    if (total == '') 
        {
          total = 0;
        };
      var total_akhir = parseFloat(total,10) - parseFloat(subtotal_tbs,10);

      $("#total_retur_pembelian").val(tandaPemisahTitik(total_akhir));
      $("#total_retur_pembelian1").val(tandaPemisahTitik(total_akhir));

      $.post("hapus_tbs_retur_penjualan.php",{id:id,kode_barang:kode_barang,no_faktur:no_faktur},function(data){
          if (data != "") {
            $(".tr-id-"+id).remove();          
          }


          $.post("cek_tbs_retur_penjualan.php",{session_id: "<?php echo $session_id; ?>"},function(data){
              if (data == 0) {
                   $("#ppn").attr("disabled", false).trigger("chosen:updated");
              }
          });

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


//end fungsi hapus data
</script>

<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){

        var session_id = $("#session_id").val();
        var kode_barang = $("#kode_barang").val();
        var no_faktur2 = $("#no_faktur2").val();
        
        $.post('cek_kode_barang_tbs_retur_penjualan.php',{kode_barang:kode_barang,session_id:session_id,no_faktur2:no_faktur2}, function(data){
        
        if(data == 1){
        alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
        $("#kode_barang").val('');
        $("#nama_barang").val('');
        }//penutup if
        
        });////penutup function(data)

      $.getJSON('lihat_retur_penjualan.php',{kode_barang:$(this).val()}, function(json){
      
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
        $('#no_faktur2').val(json.no_faktur);
        $('#sisabarang').val(json.sisa);
      }
                                              
        });
        
        });
        });

      
      
</script>



<script type="text/javascript">
  $(document).ready(function(){

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
</script>

<script type="text/javascript">
  $(document).ready(function(){

    $("#ppn").change(function(){
      var ppn = $("#ppn").val();
      $("#ppn_input").val(ppn);

      if (ppn == "Include"){
          $("#tax").attr("disabled", true);
          $("#tax1").attr("disabled", false);
          $("#tax").val("");
          $("#tax1").val("<?php echo $nilai_ppn ?>");
      }
      else if (ppn == "Exclude") {
          $("#tax").attr("disabled", true);
          $("#tax1").attr("disabled", false);
          $("#tax").val("");
          $("#tax1").val("<?php echo $nilai_ppn ?>");
      }
      else{
        $("#tax1").attr("disabled", true);
        $("#tax").attr("disabled", true);
        $("#tax1").val("");
        $("#tax").val("");
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
                                    var kode_barang = $(this).attr("data-kode");
                                    var no_faktur = $(this).attr("data-faktur");
                                    var harga = $(this).attr("data-harga");
                                    var satuan = $(this).attr("data-satuan");
                                    var jumlah_retur = $("#text-jumlah-"+id+"").text();

                                    if (jumlah_baru == "") {
                                      jumlah_baru = 0;
                                    }


                                    
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                   
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));

                                    var subtotal = parseFloat(harga,10) * parseFloat(jumlah_baru,10) - parseFloat(potongan,10);
                                    
                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian").val()))));
                                    
                                    subtotal_penjualan = parseFloat(subtotal_penjualan,10) - parseFloat(subtotal_lama,10) + parseFloat(subtotal,10);

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

                                      $.post("cek_stok_pesanan_barang_retur_penjualan.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru, no_faktur:no_faktur,satuan:satuan},function(data){
                                       
                                       
                                       if (data == "ya") {
                                       
                                       alert ("Jumlah Yang Di Masukan Melebihi Stok !");
                                       
                                       
                                       $("#input-jumlah-"+id+"").val(jumlah_retur);
                                       $("#text-jumlah-"+id+"").text(jumlah_retur);
                                       $("#text-jumlah-"+id+"").show();
                                       $("#input-jumlah-"+id+"").attr("type", "hidden");
                                       
                                       }
                                       
                                       else{
                                       
                                       $.post("update_pesanan_barang_retur_penjualan.php",{harga:harga,jumlah_retur:jumlah_retur,jumlah_tax:jumlah_tax,potongan:potongan,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,subtotal:subtotal},function(info){
                                       
                                       
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
                                    }

                                       


       
                                    $("#kode_barang").focus();

                                 });

                             </script>



<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>

