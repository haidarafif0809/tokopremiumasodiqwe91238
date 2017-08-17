<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


$no_faktur = $_GET['no_faktur_retur'];
$nilai_piutang_penj = 0;

$perintah = $db->query("SELECT * FROM retur_penjualan WHERE no_faktur_retur = '$no_faktur'");
$ambil = mysqli_fetch_array($perintah);

  $row_piutang = $db->query("SELECT no_faktur_piutang FROM retur_pembayaran_piutang WHERE no_faktur_retur = '$no_faktur'");
  $data_row_piutang = mysqli_num_rows($row_piutang);

if ($data_row_piutang > 0) {
  
    $faktur_piutang = $db->query("SELECT no_faktur_piutang FROM retur_pembayaran_piutang WHERE no_faktur_retur = '$no_faktur'");
    while ($data_faktur_piutang = mysqli_fetch_array($faktur_piutang)) {
      $piutang_pemb = $db->query("SELECT kredit FROM penjualan WHERE no_faktur = '$data_faktur_piutang[no_faktur_piutang]'");
      $data_piutang = mysqli_fetch_array($piutang_pemb);
      $nilai_piutang = $data_piutang['kredit'];
      
      $nilai_piutang_penj = $nilai_piutang_penj + $nilai_piutang;



      $potongan_piutang = $db->query("SELECT total_bayar, total FROM retur_penjualan WHERE no_faktur_retur = '$no_faktur'");
      $data_potongan_piutang = mysqli_fetch_array($potongan_piutang);
      $nilai_total_bayar = $data_potongan_piutang['total_bayar'];
      $nilai_total = $data_potongan_piutang['total'];
      $nilai_pot_piutang = $nilai_total_bayar - $nilai_total;

    }

    $total_pot_piutang = $nilai_piutang_penj + $nilai_pot_piutang;

}
else{
    $total_pot_piutang = 0;
    $nilai_pot_piutang = 0;
}

    $data_potongan = $db->query("SELECT potongan, tax, ppn FROM retur_penjualan WHERE no_faktur_retur = '$no_faktur'");
    $ambil_potongan = mysqli_fetch_array($data_potongan);
    $potongan = $ambil_potongan['potongan'];
    $tax = $ambil_potongan['tax'];
    $ppn = $ambil_potongan['ppn'];


    $data_potongan_persen = $db->query("SELECT SUM(subtotal) AS subtotal FROM detail_retur_penjualan WHERE no_faktur_retur = '$no_faktur'");
    $ambil_potongan_persen = mysqli_fetch_array($data_potongan_persen);
    $subtotal_persen = $ambil_potongan_persen['subtotal'];

    $potongan_persen = $potongan / $subtotal_persen * 100;
    $hasil_persen = intval($potongan_persen);

    $subtotal_tax = $subtotal_persen - $potongan;
    $hasil_sub = intval($subtotal_tax);

    $potongan_tax = $tax / $hasil_sub * 100;
    $hasil_tax = intval($potongan_tax);

$tbs = $db->query("SELECT no_faktur_retur FROM tbs_retur_penjualan WHERE no_faktur_retur = '$no_faktur'");
$data_tbs = mysqli_num_rows($tbs);
 ?>

      <script>
      $(function() {
      $( ".tgl" ).datepicker({dateFormat: "yy-mm-dd"});
      });
      </script>

<!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
<div style="padding-left: 15%; padding-right: 15%">


<!--membuat agar tabel berada dalam baris tertentu-->
 <div class="row">

 <!--membuat tampilan halaman menjadi 8 bagian-->


  <!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="form_retur_penjualan.php" method="post ">
					
<!-- membuat teks dengan ukuran h3 -->
  <h3> <u> FORM EDIT RETUR PENJUALAN </u> </h3><br>

  <div class="row">
    <div class="col-sm-2">
        <label> Tanggal </label><br>
        <input style="height: 20px" type="text" value="<?php echo $ambil['tanggal']; ?>" name="tanggal" id="tanggal" placeholder="Tanggal"  class="form-control tgl" required="" >
    </div>

    <div class="col-sm-2">
        <label> No Faktur </label><br>
				<input style="height: 20px" type="text" name="no_faktur_retur" id="nomorfaktur" class="form-control" readonly="" value="<?php echo $no_faktur; ?>" required="" >
		</div>

<!-- PPN -->
    <?php if ($data_tbs > 0): ?>

      <div class="col-sm-2">
        <label>PPN</label>
        <select name="ppn" id="ppn" class="form-control" disabled="true">
        <option value="<?php echo $ppn; ?>"><?php echo $ppn; ?></option> 
        <option value="Include">Include</option>  
        <option value="Exclude">Exclude</option>
        <option value="Non">Non</option>          
        </select>
      </div>

      <?php else: ?>      

      <div class="col-sm-3">
        <label>PPN</label>
        <select name="ppn" id="ppn" class="form-control">
        <option value="<?php echo $ppn; ?>"><?php echo $ppn; ?></option> 
        <option value="Include">Include</option>  
        <option value="Exclude">Exclude</option>
        <option value="Non">Non</option>          
        </select>
      </div>

    <?php endif ?> 

                     

      <!-- END PPN --> 

    <div class="col-sm-3">
        <label> Cara Bayar </label><br>
        <select type="text" name="cara_bayar" id="carabayar1" class="form-control" required=""  >
          <option value=""> --SILAHKAN PILIH-- </option>
              <?php 
              $sett_akun = $db->query("SELECT sa.kas, da.nama_daftar_akun FROM setting_akun sa INNER JOIN daftar_akun da ON sa.kas = da.kode_daftar_akun");
              $data_sett = mysqli_fetch_array($sett_akun);

              echo "<option selected value='".$data_sett['kas']."'>".$data_sett['nama_daftar_akun'] ."</option>";

              $query = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank'");
              while($data = mysqli_fetch_array($query)){
                echo "<option value='".$data['kode_daftar_akun']."'>".$data['nama_daftar_akun'] ."</option>";
              }
              ?>
        </select>
    </div>

  </div>

  <div class="row">
    
    <div class="col-sm-3">
          <label> Kode Pelanggan </label>
          <select data-placeholder="--SILAHKAN PILIH--" name="kode_pelanggan" id="kd_pelanggan" class="form-control chosen" required="" >
          <?php           
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT id, kode_pelanggan, nama_pelanggan FROM pelanggan");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
            if ($ambil['kode_pelanggan'] == $data['id']) {
              echo "<option selected value='".$data['id'] ."'>".$data['kode_pelanggan'] ." - ".$data['nama_pelanggan'] ."</option>";
            }
            else{
              echo "<option value='".$data['id'] ."'>".$data['kode_pelanggan'] ." - ".$data['nama_pelanggan'] ."</option>";
            }       
          }
          
          
          ?>
          </select>
    </div>

    <input type="hidden" class="form-control" name="nilai_pot_piutang" id="nilai_pot_piutang" placeholder="nilai_pot_piutang" value="<?php echo $nilai_pot_piutang; ?>">

<?php if ($data_row_piutang > '0' ): ?>


          <div id="col-faktur-piutang" class="col-sm-3">
          <label> No. Faktur Piutang </label><br>          
          <select data-placeholder="--SILAHKAN PILIH--" name="no_faktur_piutang" id="no_faktur_piutang" multiple="" class="form-control chosen" required="" >
          <?php 
          
          $nilai_piutang_penjualan = 0;
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT no_faktur FROM penjualan WHERE status_jual_awal = 'Kredit'");
          while($data = mysqli_fetch_array($query))
          {
          $ambil_piutang = $db->query("SELECT kredit FROM penjualan WHERE no_faktur = '$data[no_faktur]'");
          $data_piutang = mysqli_fetch_array($ambil_piutang);

          $faktur_piutang_penjualan = $db->query("SELECT no_faktur_piutang, kredit_penjualan_lama FROM retur_pembayaran_piutang WHERE no_faktur_piutang = '$data[no_faktur]' AND no_faktur_retur = '$no_faktur'");
          $data_faktur_piutang_penjualan = mysqli_fetch_array($faktur_piutang_penjualan);
          $nomor_faktur_piutang = $data_faktur_piutang_penjualan['no_faktur_piutang'];

          $total_piutang = $data_piutang['kredit'] + $data_faktur_piutang_penjualan['kredit_penjualan_lama'];
          

          if ($nomor_faktur_piutang == $data['no_faktur']) {
          echo "<option selected='selected' value='".$data['no_faktur'] ."'>".$data['no_faktur'] ." || Rp. ".rp($total_piutang) ."</option>";
          }          
          else{
          echo "<option value='".$data['no_faktur'] ."'>".$data['no_faktur'] ." || Rp. ".rp($total_piutang) ."</option>";
          }
          }          
          
          ?>
          </select>
      </div>

      <div class="col-sm-2"> 
        <input type="checkbox" id="checkbox" checked="" data-toogle="1">
        <label for="checkbox">Potong Piutang</label>
      </div>



<?php else: ?>


          <div id="col-faktur-piutang" class="col-sm-3" style="display: none">
          <label> No. Faktur Piutang </label><br>          
          <select data-placeholder="--SILAHKAN PILIH--" name="no_faktur_piutang" id="no_faktur_piutang" multiple class="form-control chosen" required="" >
          <?php 
          
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT no_faktur FROM penjualan WHERE status_jual_awal = 'Kredit'");
          while($data = mysqli_fetch_array($query))
          {
          $ambil_piutang = $db->query("SELECT kredit FROM penjualan WHERE no_faktur = '$data[no_faktur]'");
          $data_piutang = mysqli_fetch_array($ambil_piutang);

          $faktur_piutang_penjualan = $db->query("SELECT no_faktur_piutang FROM retur_pembayaran_piutang WHERE no_faktur_retur = '$no_faktur'");
          $data_faktur_piutang_penjualan = mysqli_fetch_array($faktur_piutang_penjualan);
          $nomor_faktur_piutang = $data_faktur_piutang_penjualan['no_faktur_piutang'];

          if ($nomor_faktur_piutang == $data['no_faktur']) {
          echo "<option selected value='".$data['no_faktur'] ."'>".$data['no_faktur'] ." || Rp. ".rp($data_piutang['kredit']) ."</option>";
          }     
          else{
          echo "<option value='".$data['no_faktur'] ."'>".$data['no_faktur'] ." || Rp. ".rp($data_piutang['kredit']) ."</option>";
          }
          }          
          
          ?>
          </select>
      </div>
     
     <div class="col-sm-2"> 
        <input type="checkbox" id="checkbox" data-toogle="0">
        <label for="checkbox">Potong Piutang</label>
      </div>

  
<?php endif ?>

  </div>

  </form> <!-- tag penutup form -->

				

<div class="col-sm-8">


<!-- membuat tombol agar menampilkan modal -->
<button type="button" class="btn btn-info" id="cari_produk_pembelian" data-toggle="modal" data-target="#myModal"><i class='fa fa-search'> </i> Cari</button>


<!-- Tampilan Modal -->
<div id="myModal" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Isi Modal-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Detail Penjualan</h4>

        
      </div>
      <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
        <div class="table-responsive">
          <table id="tabel_cari" class="table table-bordered table-sm">
            <thead> <!-- untuk memberikan nama pada kolom tabel -->
              <th> Nomor Faktur </th>
              <th> Kode Barang </th>
              <th> Nama Barang </th>
              <th> Satuan </th>
              <th> Harga   </th>
              <th> Potongan </th>
              <th> Tax </th>
              <th> Subtotal </th>
              <th> Sisa Barang </th> 
            </thead> <!-- tag penutup tabel -->
          </table>
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
 <form action="proses_edit_tbs_retur_penjualan.php" role="form" id="formtambahproduk">
  
<div class="row">

  <div class="form-group col-sm-3">
    <input type="text" style="height: 15px" class="form-control" name="kode_barang" autocomplete="off" id="kode_barang" placeholder="Kode Produk">
  </div>


  <div class="form-group col-sm-3"> <!-- agar tampilan berada pada satu group -->
  <!-- memasukan teks pada kolom kode barang -->
  <input type="text" style="height: 15px" class="form-control" readonly="" name="nama_barang" id="nama_barang" placeholder="Nama Barang">
  </div>
  

  <div class="form-group col-sm-2" >
    <input type="text" style="height: 15px" class="form-control" name="jumlah_retur" id="jumlah_retur" autocomplete="off" placeholder="Jumlah Retur" >
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
  <input type="text" style="height: 15px" id="harga_produk" name="harga" class="form-control" autocomplete="off" value="" placeholder="Harga Barang" required="">
  </div>

      <div class="form-group col-sm-3">
  <input type="text" style="height: 15px" id="potongan1" name="potongan1" class="form-control" autocomplete="off" value="" placeholder="Potongan (%)" required="">
  </div>

    <div class="form-group col-sm-2">
  <input type="text" style="height: 15px" id="tax1" style="width: " name="tax1" class="form-control" autocomplete="off" value="" placeholder="Pajak (%)" required="">
  </div>
<div class="col-sm-4">

  <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah Produk</button>
  
</div>

</div>
 
  
  <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">

  <?php if ($data_row_piutang > 0): ?>

      <input type="hidden" value="" name="no_faktur_piutang_hidden" id="no_faktur_piutang_hidden" class="form-control" readonly="">

  <?php else: ?>      

      <input type="hidden" value="" name="no_faktur_piutang_hidden" id="no_faktur_piutang_hidden" class="form-control" readonly="">

  <?php endif ?>

<!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->
  <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
  <input type="hidden" id="harga_lama" name="harga_lama" class="form-control" value="" required="">
  <input type="hidden" id="harga_baru" name="harga_baru" class="form-control" value="" required="">
  <input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" required="">
  <input type="hidden" id="satuan_jual" name="satuan" class="form-control" value="" required="">
    <input type="hidden" id="harga_pcs" name="harga_pcs" class="form-control" value="" required="">  
   <input type="hidden" id="satuan_pcs" name="satuan_pcs" class="form-control" value="" required="">
  <input type="hidden" name="no_faktur_retur" id="noretur_jl" class="form-control" value="<?php echo $no_faktur; ?>" required="" >
  <input type="hidden" id="no_faktur2" name="no_faktur_penjualan" class="form-control" value="" required="">

  <input type="hidden" name="jumlah_beli" class="form-control" value="<?php echo $data1['jumlah_barang']; ?>" required="" >
  <input type="hidden" id="sisabarang" name="sisa" class="form-control" value="" required="" >
  <!-- membuat tombol submit-->




</form>


  <div class="table-responsive">
    <table id="tabel_retur_jual" class="table table-bordered table-sm">
      <thead> <!-- untuk memberikan nama pada kolom tabel -->

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

      </thead> <!-- tag penutup tabel -->
    </table>
  </div>

	</div><!-- end of col sm 8 --> <!--tag penutup col sm 8-->

  <div class="col-sm-4"> <!--tag pembuka col sm 4-->

    <div class="card card-block">

    <form action="proses_bayar_edit_retur_jual.php" id="form_beli" method="POST"><!--tag pembuka form-->      

        <div class="row">
          <div class="col-sm-4">
              <label><b> Subtotal</b></label>
              <input style="height: 20px" type="text" name="total1" id="total_retur_pembelian1" class="form-control" placeholder="Subtotal" readonly=""  >
          </div>

          <div class="col-sm-4">
              <label><b> Potongan (Rp) </b></label>
              <input style="height: 20px" type="text" name="potongan" id="potongan_pembelian" value="<?php echo $potongan; ?>" class="form-control" placeholder="Potongan" autocomplete="off">
          </div>


          <div class="col-sm-4">
              <label><b> Potongan (%) </b></label>
              <input style="height: 20px" type="text" name="potongan_persen" id="potongan_persen" value="<?php echo $hasil_persen; ?>" class="form-control" placeholder="Potongan" autocomplete="off">
          </div>


        </div>
                   
        <div class="row">

          <div class="col-sm-3" style="display: none">
              <label><b> Tax </b></label><br>
              <input style="height: 20px" type="text" name="tax" id="tax" class="form-control" value="<?php echo $hasil_tax; ?>" placeholder="Tax" autocomplete="off">
          </div>

            <div class="col-sm-6">
              <label><b> Potong Piutang </b></label><br>
              <input style="height: 20px" type="text" name="potong_piutang" id="potong_piutang" class="form-control" value="<?php echo rp($total_pot_piutang); ?>" placeholder="Nilai Piutang" readonly="">
          </div>


          <div class="col-sm-6">
              <label><b> Total Akhir </b></label><br>
              <b> <input style="height: 20px; font-size: 25px;" type="text" name="total" id="total_retur_pembelian" class="form-control" placeholder="Total Akhir" readonly="" > </b>
        </div>

          <div class="col-sm-12">
              <label><b> KAS </b></label><br>
              <input style="height: 20px; font-size: 20px;" type="text" name="pembayaran" id="pembayaran_pembelian" autocomplete="off" class="form-control" placeholder="KAS" >
          </div>

          <div class="col-sm-12" style="display: none">
          <label> <b>Kembalian</b>  </label><br>
              <input style="height: 20px" type="text" name="sisa" id="sisa_pembayaran_pembelian" class="form-control" placeholder="Sisa Pembayaran" readonly="" >
          </div>
        </div>

      <input type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah"><br> 

      <input type="hidden" name="ppn_input" id="ppn_input" value="<?php echo $ppn; ?>" class="form-control" placeholder="ppn input">  
      <input type="hidden" name="no_faktur_retur" id="nofaktur_jl" class="form-control" value="<?php echo $no_faktur; ?>" required="" >
      <input type="hidden" name="kode_pelanggan" id="kd_pelanggan1" class="form-control" required="" >
      <input type="hidden" name="tanggal" id="tanggal_hidden" class="form-control tgl" value="<?php echo $ambil['tanggal']; ?>" >

      <!--membuat tombol submit bayar & piutang-->
			<button type="submit" id="pembayaran" class="btn btn-info"> <i class='fa fa-send'> </i> Bayar </button>      
      <a class="btn btn-info" href="retur_penjualan.php" id="transaksi_baru" style="display: none"> <i class="fa fa-refresh"></i> Transaksi Baru</a>
      <a href='batal_retur_penjualan.php?no_faktur_retur=<?php echo $no_faktur;?>' id='batal_transaksi' class='btn btn-danger'><i class='fa fa-close'> </i> Batal </a>
      <a href='cetak_retur_penjualan.php' id="cetak_retur" style="display: none;" class="btn btn-success" target="blank"><span class="fa fa-print"> </span> Cetak Retur Penjualan </a>
     
</form><!--tag penutup form-->

    <div class="alert alert-success" id="alert_berhasil" style="display:none">
      <strong>Success!</strong> Pembayaran Berhasil
    </div>
        
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
        <h4 class="modal-title">Konfirmasi Hapus</h4>
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
<div id="modal_edit" class="modal fade" role="dialog">
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


<div id="modal_alert" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 style="color:orange" class="modal-title"><span class="glyphicon glyphicon-info-sign">Info!</span></h3>
        <h4>Maaf No Transaksi <strong><?php echo $no_faktur; ?></strong> tidak dapat dihapus atau di edit, karena telah terdapat Transaksi dibawah ini. Dengan daftar sebagai berikut :</h4>
      </div>

      <div class="modal-body">
      <span id="modal-alert">
       </span>


     </div>

      <div class="modal-footer">
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data,<br>
        silahkan hapus terlebih dahulu Transaksi diatas</i></h6>
        <button type="button" class="btn btn-warning btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<span id="demo"> </span>

</div><!-- end of container -->

<script type="text/javascript" language="javascript" >
   $(document).ready(function() {

        var dataTable = $('#tabel_cari').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_edit_retur_jual_baru.php", // json datasource
            "data": function ( d ) {
                d.kode_pelanggan = $("#kd_pelanggan").val();
                d.no_faktur_retur = $("#nomorfaktur").val();
                // d.custom = $('#myInput').val();
                // etc
            },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_cari").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");

            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('data-kode', aData[1]);
              $(nRow).attr('nama-barang', aData[2]);
              $(nRow).attr('satuan', aData[11]);
              $(nRow).attr('no_faktur', aData[0]);
              $(nRow).attr('harga', aData[4]);
              $(nRow).attr('jumlah-barang', aData[12]);
              $(nRow).attr('id_produk', aData[13]);
              $(nRow).attr('asal_satuan', aData[10]);
              $(nRow).attr('harga_pcs', aData[9]);
              $(nRow).attr('sisa', aData[14]);

            }

        });


  $('#pembayaran_pembelian').focus();

  });

 </script>
<script type="text/javascript">
  $(document).ready(function() {
    var dataTable = $('#tabel_retur_jual').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax":{
        url :"data_edit_tbs_retur_jual.php", // json datasource
        "data": function ( d ) {
          d.no_faktur_retur = $("#nomorfaktur").val();
          // d.custom = $('#myInput').val();
          // etc
        },

         type: "post",  // method  , by default get
         error: function(){  // error handling
           $(".employee-grid-error").html("");
           $("#tabel_retur_jual").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
           $("#employee-grid_processing").css("display","none");
           }
      },
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
           $(nRow).attr('class','tr-id-'+aData[12]+'');
         }
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
  document.getElementById("harga_lama").value = $(this).attr('harga');
  document.getElementById("harga_baru").value = $(this).attr('harga');
  document.getElementById("satuan_konversi").value = $(this).attr('satuan');
  document.getElementById("id_produk").value = $(this).attr('id_produk');
  document.getElementById("satuan_pcs").value = $(this).attr('asal_satuan');
  document.getElementById("harga_pcs").value = $(this).attr('harga_pcs');
  document.getElementById("satuan_jual").value = $(this).attr('satuan');
  
  $('#myModal').modal('hide');  
  $('#jumlah_retur').focus();
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
    var kode_barang = $("#kode_barang").val();
    var no_faktur = $("#no_faktur2").val();
    var tax1 = $("#tax1").val();
    var ppn = $("#ppn").val();
    var satuan_jual = $("#satuan_jual").val();
    var no_faktur_retur = $("#nomorfaktur").val();

    var jumlah_retur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_retur").val()))));
    var jumlahbarang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlahbarang").val()))));
    var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_produk").val()))));
    var potongan1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
    var potong_piutang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potong_piutang").val()))));
    var sub_total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian1").val()))));
    var potongan_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));    
    var pajak_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));

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

        var subtotal = parseInt(jumlah_retur, 10) *  parseInt(harga, 10) - parseInt(potongan1, 10);
        var sub_total_akhir = parseInt(sub_total,10) + parseInt(subtotal,10);
        var diskon_per_faktur = parseInt(potongan_faktur, 10) *  parseInt(sub_total_akhir, 10) / 100;
        var sub_setelah_potong_diskon =  parseInt(sub_total_akhir, 10) - parseInt(diskon_per_faktur, 10);
        var pajak_per_faktur = parseInt(pajak_faktur, 10) *  parseInt(sub_setelah_potong_diskon, 10) / 100;
        var total_akhir = parseInt(sub_setelah_potong_diskon,10) + parseInt(pajak_per_faktur,10);
        var data_total_if =  parseInt(total_akhir,10) - parseInt(potong_piutang,10);

        if (data_total_if > 0) {
          var jumlah_kas_masuk = parseInt(total_akhir,10) - parseInt(potong_piutang,10);
        }
        else{
          var jumlah_kas_masuk = 0;
        }

  
  if (jumlah_retur == ""){
    alert("Jumlah Barang Harus Diisi");
    $("#jumlah_retur").focus();
  }
  else if (kode_pelanggan == ""){
    alert("Kode Pelanggan Harus Dipilih");
  }
  else  {

    $("#total_retur_pembelian").val(tandaPemisahTitik(total_akhir));
    $("#total_retur_pembelian1").val(tandaPemisahTitik(sub_total_akhir));
    $("#potongan_pembelian").val(tandaPemisahTitik(diskon_per_faktur));
    $("#pembayaran_pembelian").val(tandaPemisahTitik(jumlah_kas_masuk));

    $.post("proses_edit_tbs_retur_penjualan.php",{no_faktur_retur:no_faktur_retur,no_faktur_penjualan:no_faktur,kode_barang:kode_barang,jumlah_retur:jumlah_retur,satuan_produk:satuan_produk,nama_barang:nama_barang,harga:harga,potongan1:potongan1,tax1:tax1,satuan_jual:satuan_jual},function(info) {


     $("#kode_barang").focus();
     $("#ppn").attr("disabled", true);
     $("#tbody").prepend(info);
     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_retur").val('');
     $("#no_faktur2").val('');
     $("#harga_produk").val('');

     var tabel_retur_jual = $('#tabel_retur_jual').DataTable();
         tabel_retur_jual.draw();
       
   });
 
}


  });

      $("#formtambahproduk").submit(function(){
    return false;
});

      
  </script>



 <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#pembayaran").click(function(){


  var no_faktur_retur = $("#nomorfaktur").val();
  var tanggal = $("#tanggal").val();
  var sisa = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#sisa_pembayaran_pembelian").val()))));
  var kode_pelanggan = $("#kd_pelanggan").val();
  var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian").val()))));
  var carabayar = $("#carabayar1").val();
  var potongan = $("#potongan_pembelian").val();
  var tax = $("#tax").val();
  var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_pembelian").val()))));
  var total1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian1").val()))));
  var ppn_input = $("#ppn_input").val();
  var no_faktur_piutang = $("#no_faktur_piutang"). val();
  var no_faktur_piutang_hidden = $("#no_faktur_piutang_hidden"). val();
  var potong_piutang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potong_piutang").val()))));

  if (potong_piutang == '') {
    potong_piutang = 0;
  };
  if (pembayaran == '') {
    pembayaran = 0;
  };

console.log(no_faktur_piutang);
 if (total == "") {
  alert("Jumlah Total Kosong! Anda Belum Melakukan Pemesan");
 }
 else if ( kode_pelanggan == "") {
    alert("Kode Pelanggan Harus Di Isi");
 }
 else if (pembayaran == 0 && potong_piutang == 0) {
  alert("Pembayaran / Kas Tidak Boleh Koosong");

 }
 else{

  $("#transaksi_baru").show();
  $("#pembayaran").hide();
  $("#batal_transaksi").hide();
  $("#batal").hide();

 $.post("proses_bayar_edit_retur_jual.php",{no_faktur_retur:no_faktur_retur,sisa:sisa,kode_pelanggan:kode_pelanggan,total:total,cara_bayar:carabayar,potongan:potongan,tax:tax,pembayaran:pembayaran,total1:total1,ppn_input:ppn_input,tanggal:tanggal,no_faktur_piutang:no_faktur_piutang, no_faktur_piutang_hidden:no_faktur_piutang_hidden, potong_piutang:potong_piutang},function(info) {

     $("#alert_berhasil").show();
     $("#cetak_retur").show();    
     $("#total_retur_pembelian").val('');
     $("#pembayaran_pembelian").val('');
     $("#sisa_pembayaran_pembelian").val('');
     $("#potongan_pembelian").val('');
     $("#tax").val('');
     $("#total_retur_pembelian1"). val('');  

    var tabel_retur_jual = $('#tabel_retur_jual').DataTable();
         tabel_retur_jual.draw();
    
       
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
    $("#pembayaran_pembelian").focus(function(){
      var total_retur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian1").val()))));
      var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val()))));
      var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));

      var diskon_lama = $("#potongan_pembelian").attr('data-diskon');
      $("#potongan_pembelian").attr('data-diskon', potongan);

      if (diskon_lama == "") {

        diskon_lama = 0;
      }

      if (potongan == "") {
        potongan = 0;
      }

      var hasil = parseInt(total_retur,10) - parseInt(potongan,10);

      $("#total_retur_pembelian").val(hasil);


      
      });
    });


</script>

<script type="text/javascript">
      
      $(document).ready(function(){


    $("#pembayaran_pembelian").focus(function(){

              var potongan = $("#potongan_pembelian").val();
              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();
              var total = $("#total_retur_pembelian1").val();
              var t_total = total - potongan;

              if (tax == "") {
                tax = 0;
              }
              else if (cara_bayar == "") {
                alert ("Kolom Cara Bayar Masih Kosong");
                 $("#tax").val('');
                 $("#potongan_pembelian").val('');
              }
              
              var t_tax = ((parseInt(t_total,10) * parseInt(tax,10)) / 100);
              var total_akhir = parseInt(t_total,10) + parseInt(t_tax,10);
              
              
              $("#total_retur_pembelian").val(parseInt(total_akhir));

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');

              }

      });
    });
      
</script>


<script type="text/javascript">


// untuk memunculkan data cek total pembelian
$(document).ready(function(){
  var pajak_faktur = $("#tax").val()
  var diskon_faktur = $("#potongan_pembelian").val()
  var potong_piutang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potong_piutang").val()))));


  if (pajak_faktur == "") {
    pajak_faktur = 0;
  }
  if (diskon_faktur == "") {
    diskon_faktur = 0;
  }
  if (potong_piutang == "") {
    potong_piutang = 0;
  }

$.post("cek_total_edit_retur_penjualan.php", {no_faktur_retur: "<?php echo $no_faktur; ?>"},function(data){

  
  var total_selah_dipotong = ( parseInt(data,10) - parseInt(diskon_faktur,10) );
  var pajak_rupiah = ( parseInt(total_selah_dipotong,10) * parseInt(pajak_faktur,10) ) / 100;
  var total_retur = ( parseInt(data,10) - parseInt(diskon_faktur,10) ) + parseInt(Math.round(pajak_rupiah,10));
  var info_data = parseInt(total_retur,10) - parseInt(potong_piutang,10);

  if (info_data > 0) {
    jumlah_kas_masuk = parseInt(total_retur,10) - parseInt(potong_piutang,10);
  }
  else{
    jumlah_kas_masuk = 0;
  }

  if (total_retur == "") {
    total_retur = 0;
  }
    
        $("#total_retur_pembelian").val(tandaPemisahTitik(total_retur));
        $('#total_retur_pembelian1').val(data);
        $("#pembayaran_pembelian").val(tandaPemisahTitik(jumlah_kas_masuk));

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
             
             var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(t_tax,10);

        
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
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(t_tax,10);
        
        if (potongan_persen > 100) {
          alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
        }

        
        
        $("#total_retur_pembelian").val(tandaPemisahTitik(parseInt(hasil_akhir)));
        $("#potongan_pembelian").val(tandaPemisahTitik(parseInt(potongan_rupiah)));

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
  $(document).ready(function(){
    $(document).on('click','.btn-hapus-tbs',function(e){

    var kode_barang = $(this).attr("data-kode-barang");
    var no_faktur = $(this).attr("data-faktur");
    var id = $(this).attr("data-id");
    var subtotal_tbs = $(this).attr("data-subtotal");
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian1").val()))));
    var potong_piutang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potong_piutang").val()))));
    var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));

      if (total == '') {
          total = 0;
        };
    
      var subtotal_akhir = parseFloat(total,10) - parseFloat(subtotal_tbs,10);

      var nilai_diskon = parseInt(subtotal_akhir,10) * parseInt(potongan_persen,10) / 100;

      var total_akhir = parseInt(subtotal_akhir,10) - parseInt(nilai_diskon,10);

      var data_total_if =  parseInt(total_akhir,10) - parseInt(potong_piutang,10);

      if (data_total_if > 0) {
        var jumlah_kas_masuk = parseInt(total_akhir,10) - parseInt(potong_piutang,10);
      }
      else{
        var jumlah_kas_masuk = 0;
      }

      $("#total_retur_pembelian").val(tandaPemisahTitik(total_akhir));
      $("#total_retur_pembelian1").val(tandaPemisahTitik(subtotal_akhir));
      $("#potongan_pembelian").val(tandaPemisahTitik(nilai_diskon));
      $("#pembayaran_pembelian").val(tandaPemisahTitik(jumlah_kas_masuk));

      $.post("hapus_tbs_retur_penjualan.php",{id:id,kode_barang:kode_barang,no_faktur:no_faktur},function(data){
          if (data != "") {
            $(".tr-id-"+id).remove();          
          }

          var tabel_retur_jual = $('#tabel_retur_jual').DataTable();
              tabel_retur_jual.draw();

      });
    
    
    });
  });
</script>

<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){


    var no_faktur_retur = $("#nomorfaktur").val();
    var kode_barang = $("#kode_barang").val();
    var no_faktur_penjualan = $("#no_faktur2").val();

    $.post('cek_kode_barang_edit_tbs_retur_penjualan.php',{kode_barang:kode_barang,no_faktur_retur:no_faktur_retur,no_faktur_penjualan:no_faktur_penjualan}, function(data){
    
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

<script>

$(document).ready(function(){
    $(".container").hover(function(){

      var tanggal = $("#tanggal").val();

      $("#tanggal_hidden").val(tanggal);

    });
});

</script> 

  <script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var no_faktur_retur = $("#nomorfaktur").val();
    var kode_barang = $("#kode_barang").val();
    var no_faktur_penjualan = $("#no_faktur2").val();

 $.post('cek_kode_barang_edit_tbs_retur_penjualan.php',{kode_barang:kode_barang,no_faktur_retur:no_faktur_retur,no_faktur_penjualan:no_faktur_penjualan}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
    $("#harga_produk").val('');
   }//penutup if

    });////penutup function(data)

   $("#jumlah_barang").val(data);  
    });//penutup click(function()
  });//penutup ready(function()
</script>

<script type="text/javascript">
    $(document).ready(function(){

    var ppn_input = $("#ppn_input").val();

  if (ppn_input == "Include"){

      $("#tax").attr("disabled", true);
      $("#tax1").attr("disabled", false);
  }

  else if (ppn_input == "Exclude") {
    $("#tax1").attr("disabled", true);
      $("#tax").attr("disabled", false);
  }
  else{

    $("#tax1").attr("disabled", true);
      $("#tax").attr("disabled", true);
  }

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
                                 
                                $(document).on("dblclick", ".edit-jumlah", function(){

                                      var id = $(this).attr("data-id");


                                        $("#text-jumlah-"+id+"").hide();                                        
                                        $("#input-jumlah-"+id+"").attr("type", "text");
                               
                                      });
                                     

                                 $(".input_jumlah").blur(function(){
                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();
                                    var kode_barang = $(this).attr("data-kode");
                                    var no_faktur = $(this).attr("data-faktur");
                                    var no_faktur_jual = $(this).attr("data-faktur-jual");
                                    var harga = $(this).attr("data-harga");
                                    var jumlah_retur = $("#text-jumlah-"+id+"").text();

                                    if (jumlah_baru == "") {
                                      jumlah_baru = 0;
                                    }
                                    var satuan = $(this).attr("data-satuan");

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

                                    $.post("cek_edit_stok_pesanan_barang_retur_penjualan.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru, no_faktur_jual:no_faktur_jual,satuan:satuan,no_faktur:no_faktur},function(data){

                                       if (data < 0) {

                                       alert ("Jumlah Yang Di Masukan Melebihi Transaksi Penjualan !");

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
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#text-tax-"+id+"").text(jumlah_tax);
                                    $("#total_retur_pembelian").val(tandaPemisahTitik(subtotal_penjualan)); 
                                    $("#total_retur_pembelian1").val(tandaPemisahTitik(subtotal_penjualan)); 



                                    });

                                   }

                                 });

                                    var tabel_retur_jual = $('#tabel_retur_jual').DataTable();
                                        tabel_retur_jual.draw();

                                  }
       
                                    $("#kode_barang").focus();

                                 });

                             </script>


<script type="text/javascript">
  
                                      $(".edit-jumlah-alert").dblclick(function(){

                                      var no_faktur = $(this).attr("data-faktur");
                                      var kode_barang = $(this).attr("data-kode");
                                      
                                      $.post('alert_edit_retur_penjualan.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){
                                      
                                        $("#modal_alert").modal('show');
                                        $("#modal-alert").html(data);
              
                                      });
                                    });
</script>


<script type="text/javascript">
 
$(".btn-alert-hapus").click(function(){
     var no_faktur = $(this).attr("data-faktur");
    var kode_barang = $(this).attr("data-kode");

    $.post('alert_edit_retur_penjualan.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){
    
 
    $("#modal_alert").modal('show');
    $("#modal-alert").html(data); 

});

  });
</script>

<script type="text/javascript">
  
  // untuk memunculkan sisa pembayaran secara otomatis
  $(document).ready(function(){
$("#pembayaran_pembelian").focus(function(){

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
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(t_tax,10);

        
        $("#total_retur_pembelian").val(tandaPemisahTitik(parseInt(hasil_akhir)));
        $("#potongan_persen").val(parseInt(potongan_persen));



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
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(t_tax,10);
        
        if (potongan_persen > 100) {
          alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
        }

        
        
        $("#total_retur_pembelian").val(tandaPemisahTitik(parseInt(hasil_akhir)));
        $("#potongan_pembelian").val(tandaPemisahTitik(parseInt(potongan_rupiah)));


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

 <!-- Potongan piutang Faktur -->
 <script type="text/javascript">
$(function() {
    $('#checkbox').click(function() {
      var data_toogle = $(this).attr("data-toogle");
      var no_faktur_piutang = $("#no_faktur_piutang").val();
      var total = $("#total_retur_pembelian").val();
      $("#kode_barang").val(data_toogle); 

      if (data_toogle == "1") {

            $("#pembayaran_pembelian").attr("readonly", false); 
            $("#no_faktur_piutang").chosen("destroy");
            $('#col-faktur-piutang').hide();
            $("#no_faktur_piutang").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
            $(this).attr("data-toogle", 0);  
            $("#no_faktur_piutang").val("");  
            $("#no_faktur_piutang_hidden").val("");
            $("#potong_piutang").val("0"); 
            $("#pembayaran_pembelian").val(total); 
    
      }
      else{

          $("#pembayaran_pembelian").attr("readonly", true);  
          $("#no_faktur_piutang").chosen("destroy");
          $('#col-faktur-piutang').show();
          $("#no_faktur_piutang").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
          $(this).attr("data-toogle", 1);
          $("#no_faktur_piutang").val("");  
          $("#no_faktur_piutang_hidden").val(""); 
          $("#potong_piutang").val("0");
          $("#pembayaran_pembelian").val(total);

      }

    });
});
</script>

<script>

$(document).ready(function(){
    $("#no_faktur_piutang").change(function(){
      var no_faktur_piutang = $("#no_faktur_piutang").val();
      $("#no_faktur_piutang_hidden").val(no_faktur_piutang);
        
    });
});

</script>


<script>

$(document).ready(function(){
    $("#no_faktur_piutang").change(function(){
      var no_faktur_piutang = $("#no_faktur_piutang").val();
      var total_retur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian").val()))));
      var nilai_pot_piutang = $("#nilai_pot_piutang").val();
      if (total_retur == "") {
        total_retur = 0;
      }
      if (nilai_pot_piutang == "" || no_faktur_piutang == null) {
        nilai_pot_piutang = 0;
      }

        $.post("nilai_piutang_penjualan.php",{no_faktur_piutang: no_faktur_piutang},function(data){

          var info_data = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(data))));

          if (no_faktur_piutang == "") {
            var nilai_potong_piutang = 0;  
          }        
          else{
            var nilai_potong_piutang = parseInt(nilai_pot_piutang,10) + parseInt(info_data,10);  
          }

          var data_kas = parseInt(total_retur,10) - parseInt(nilai_potong_piutang,10);
          if (data_kas > 0) {
            kas = parseInt(total_retur,10) - parseInt(nilai_potong_piutang,10);
          }
          else{
            kas = 0;
          }


        $("#potong_piutang").val(tandaPemisahTitik(nilai_potong_piutang));
        $("#pembayaran_pembelian").val(tandaPemisahTitik(kas));
        $("#no_faktur_piutang_hidden").val(no_faktur_piutang);


        });

        
    });
});
</script>

<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>

