<?php include 'session_login.php';

    
    //memasukkan file session login, header, navbar, db
    include 'header.php';
    include 'navbar.php';
    include 'db.php';
    include 'sanitasi.php';
    
    $nomor_faktur = $_GET['no_faktur'];
    $suplier = $_GET['suplier'];
    $nama_suplier = $_GET['nama_suplier'];
    $kode_gudang = $_GET['kode_gudang'];
    $nama_gudang = $_GET['nama_gudang'];

    $tbs = $db->query("SELECT tp.id, tp.no_faktur, tp.session_id, tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.satuan, tp.harga, tp.subtotal, tp.potongan, tp.tax, s.nama FROM tbs_pembelian tp INNER JOIN satuan s ON tp.satuan = s.id WHERE tp.no_faktur = '$nomor_faktur'");
    $data_tbs = mysqli_num_rows($tbs);


//menampilkan seluruh data yang ada pada tabel pembelian
    $perintah = $db->query("SELECT tanggal FROM pembelian WHERE no_faktur = '$nomor_faktur'");
    $ambil_tanggal = mysqli_fetch_array($perintah);

    $jumlah_bayar_hutang = $db->query("SELECT SUM(jumlah_bayar) AS jumlah_bayar FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$nomor_faktur'");

    $ambil_jumlah = mysqli_fetch_array($jumlah_bayar_hutang);

    $jumlah_bayar = $ambil_jumlah['jumlah_bayar'];

    $potongan_hutang0 = $db->query("SELECT SUM(potongan) AS potongan FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$nomor_faktur'");
    $ambil_potongan = mysqli_fetch_array($potongan_hutang0);
    $potongan_hutang = $ambil_potongan['potongan'];

    $jumlah_bayar_lama = $jumlah_bayar + $potongan_hutang;

    $data_potongan = $db->query("SELECT total, potongan, tax, ppn FROM pembelian WHERE no_faktur = '$nomor_faktur'");
    $ambil_potongan = mysqli_fetch_array($data_potongan);
    $potongan = $ambil_potongan['potongan'];
    $tax = $ambil_potongan['tax'];
    $ppn = $ambil_potongan['ppn'];
    $total = $ambil_potongan['total'];


    $data_potongan_persen = $db->query("SELECT SUM(subtotal) AS subtotal FROM detail_pembelian WHERE no_faktur = '$nomor_faktur'");
    $ambil_potongan_persen = mysqli_fetch_array($data_potongan_persen);
    $subtotal_persen = $ambil_potongan_persen['subtotal'];

    $potongan_persen = $potongan / $subtotal_persen * 100;
    $hasil_persen = intval($potongan_persen);

    $subtotal_tax = $subtotal_persen - $potongan;
    $hasil_sub = intval($subtotal_tax);

    $potongan_tax = $tax / $hasil_sub * 100;
    $hasil_tax = intval($potongan_tax);

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
    $( ".tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>

    <!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->
    
    
<!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
<div style="padding-left: 5%; padding-right: 2%">

<h3> FORM EDIT PEMBELIAN : <?php echo $nomor_faktur; ?></h3><hr> 

<!--membuat agar tabel berada dalam baris tertentu-->
<div class="row">

<!--membuat tampilan halaman menjadi 8 bagian-->

<div class="col-sm-8">
  


<!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="coba.php" method="post ">

      <div class="row">  
          
          <div class="col-sm-3">
            <label> Suplier (Alt+P) </label><br>
            <select name="suplier" id="nama_suplier" class="form-control chosen" required="" >
            <option value="<?php echo $suplier ?>"><?php echo $nama_suplier ?></option>
            <?php 
              $query = $db->query("SELECT * FROM suplier");
              while($data = mysqli_fetch_array($query))
                {
                echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
                }
            ?>
            </select>          
          </div>
          
          <div class="col-sm-3">
            <label> Gudang </label><br>
            <select name="kode_gudang" id="kode_gudang" class="form-control chosen" required="" >
            <option value="<?php echo $kode_gudang ?>"><?php echo $nama_gudang ?></option>
              <?php 
              $query = $db->query("SELECT * FROM gudang");
              while($data = mysqli_fetch_array($query))
                {
                echo "<option value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";
                }
              ?>
            </select>
          </div>

                <?php if ($data_tbs > 0): ?>

                  <div class="col-sm-3">
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


          <div class="col-sm-3">
            <label> Tanggal </label><br>
            <input type="text" name="tanggal" style="height: 15px" value="<?php echo $ambil_tanggal['tanggal']; ?>" id="tanggal" placeholder="  " value="" class="form-control tanggal" >
          </div> 

      </div>

  


          <input type="hidden" name="no_faktur" id="nomorfaktur" class="form-control" readonly="" value="<?php echo $nomor_faktur; ?>" required="" > 

  </form> <!-- tag penutup form -->

  <br>
  <!--START FORM id="formtambahproduk" -->
  <form class="form-group" role="form" id="formtambahproduk">
        
    <div class="row"><!--ROW id="formtambahproduk" -->

      <!--BUTTON TAMPIL MODAL PRODUK-->
      <button type="button" class="btn btn-info" id="cari_produk_pembelian" accesskey="s" data-toggle="modal" data-target="#myModal"><i class='fa fa-search'> </i> Cari Produk (F1)</button><br>

      <div class="col-sm-3"><br>
        <select style="font-size:15px; height:30px" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
          <option value="">SILAKAN PILIH...</option>
           <?php 
            include 'cache.class.php';
              $c = new Cache();
              $c->setCache('produk');
              $data_c = $c->retrieveAll();

              foreach ($data_c as $key) {
                echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" harga="'.$key['harga_beli'].'"  satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" over_stok="'.$key['over_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'" tipe_barang="'.$key['tipe_barang'].'" id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
              }
            ?>
        </select>
      </div>
        
      
        <input style="height:25px;font-size:15px" type="hidden" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" readonly="">             
      
      <div class="col-sm-1">
        <input  style="height:20px" type="text" class="form-control" accesskey="j" name="jumlah_barang" id="jumlah_barang" autocomplete="off" placeholder="Qty">
      </div>

      <div class="col-sm-2" style="width:90px">          
        <select type="text" name="satuan_konversi" id="satuan_konversi" class="form-control"  required="" style="font-size:13px;">
          <?php 
              $query = $db->query("SELECT id, nama  FROM satuan");
              while($data = mysqli_fetch_array($query))
              {
               echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
              }         
            ?>
        </select>
      </div>

      <div class="col-sm-2" style="width:90px">
        <input  style="height:20px" type="text" id="harga_baru" name="harga_baru" class="form-control" placeholder="Harga">
      </div>

      <div class="col-sm-2" style="width:90px">
        <input  style="height:20px" type="text" class="form-control" name="potongan" autocomplete="off" id="potongan1" data-toggle="tooltip" data-placement="top" title="Jika Ingin Potongan Dalam Bentuk Persen (%), input : 10%" placeholder="Disc." >
      </div>
        
      <div class="col-sm-2" style="width:90px">
        <input  style="height:20px" type="text" class="form-control" name="tax" autocomplete="off" id="tax1" placeholder="Pajak %" >
      </div>

      <div class="col-sm-3">
        <button type="submit" id="submit_produk" class="btn btn-success"><i class='fa fa-plus'></i> Tambah (F3) </button>
        <br><br>
      </div>

<!--BAGIAN HIDDEN --> <!--BAGIAN HIDDEN --> <!--BAGIAN HIDDEN --> <!--BAGIAN HIDDEN --> <!--BAGIAN HIDDEN -->
        <input type="hidden" class="form-control"  name="over_stok" id="over_stok" autocomplete="off" placeholder="Over Stok">
        <input type="hidden" id="harga_produk" name="harga" class="form-control" placeholder="Harga Lama" required="">
        <input type="hidden" id="harga_lama" name="harga_lama" class="form-control" required="">
        <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">
        <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
        <input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" required="">
<!--BAGIAN HIDDEN --> <!--BAGIAN HIDDEN --> <!--BAGIAN HIDDEN --> <!--BAGIAN HIDDEN --> <!--BAGIAN HIDDEN -->

    </div><!--END ROW id="formtambahproduk" -->     

  </form>
<!--END FORM id="formtambahproduk" -->

<!-- MODAL PENCARIAN PRODUK  -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Isi Modal-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Data Barang</h4>
          </div>
          <div class="modal-body">
              <span class="modal_baru">
                <div class="table-resposive">
                  <center>
                    <table id="tabel_cari" class="table table-bordered table-sm">
                          <thead> <!-- untuk memberikan nama pada kolom tabel -->
                          
                              <th> Kode Barang </th>
                              <th> Nama Barang </th>
                              <th> Harga Beli </th>
                              <th> Jumlah Barang </th>
                              <th> Satuan </th>
                              <th> Kategori </th>
                              <th> Suplier </th>
                          
                          </thead> <!-- tag penutup tabel -->
                    </table>
                  </center>
                </div>
              </span>         
          </div>
          <!-- tag pembuka modal footer -->
          <div class="modal-footer">       
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> <!--tag penutup moal footer -->
          </div>
            
      </div>
    </div>
<!-- END MODAL PENCARIAN PRODUK  -->


<!--TABEl TBS PEMBELIAN AJAX -->
    <span id="span_tbs">   
      <div class="table-responsive">
        <table id="tabel_tbs_pembelian" class="table table-bordered table-sm">
          <thead> <!-- untuk memberikan nama pada kolom tabel -->

            <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>
            <th> Harga </th>
            <th> Subtotal </th>
            <th> Potongan </th>
            <th> Tax </th>
            <th> Hapus </th>
                                    
          </thead> <!-- tag penutup tabel -->
        </table>
      </div>
    </span>
<!--TABEl TBS PEMBELIAN AJAX -->
                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom Jumlah Barang jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>    

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Edit Pembelian</h4>
      </div>
      <div class="modal-body">
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
     <input type="text" id="nama-barang" class="form-control" readonly=""> 
     <input type="text" id="kode-barang" class="form-control" readonly=""> 
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
        <h4 class="modal-title">Edit Data Pembelian Barang</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Jumlah Baru:</label>
     <input type="text" class="form-control" autocomplete="off" id="barang_edit"><br>
    <label for="email">Jumlah Lama:</label>
     <input type="text" class="form-control" id="barang_lama" readonly="">
     <input type="hidden" class="form-control" id="harga_edit" readonly="">
     <input type="hidden" class="form-control" id="kode_edit" readonly="">
     <input type="hidden" class="form-control" id="faktur_edit" readonly="">
     <input type="hidden" class="form-control" id="potongan_edit" readonly="">
     <input type="hidden" class="form-control" id="tax_edit" readonly="">
     <input type="hidden" class="form-control" id="id_edit">
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-default">Submit</button>
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
        <h4>Maaf No Transaksi <strong><?php echo $nomor_faktur; ?></strong> tidak dapat dihapus atau di edit, karena telah terdapat Transaksi Penjualan, Pembayaran Hutang atau Retur Pembelian. Dengan daftar sebagai berikut :</h4>
      </div>

      <div class="modal-body">
      <span id="modal-alert">
       </span>


     </div>

      <div class="modal-footer">
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data,<br>
        silahkan hapus terlebih dahulu Transaksi Penjualan atau Pembayaran Hutang atau Retur Pembelian</i></h6>
        <button type="button" class="btn btn-warning btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



</div> <!-- /col-sm-8 -- >


  

  <style type="text/css">
  .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: false;
}
</style>





<form action="proses_bayar_beli.php" id="form_beli" method="POST"><!--tag pembuka form-->
<div class="col-sm-4">

  <div class="card card-block" style="width:80%; ">

      <div class="row">
        <div class="col-sm-6">
          <b><label> Subtotal</label><br>
              <input type="text" name="total" id="total_pembelian1" class="form-control" placeholder="" readonly="" style="font-size: 20px; height: 15px" ></b>        
        </div>
        <div class="col-sm-6">
          
        </div>
      </div>

      <div class="row">
        <div class="col-sm-4">
          <label> Potongan ( Rp ) </label><br>
            <input type="text" name="potongan" id="potongan_pembelian" data-diskon="" style="height:15px;font-size:15px" class="form-control" autocomplete="off" placeholder="">
        </div>
        <div class="col-sm-4">
          <label> Potongan ( % ) </label><br>
            <input type="text" name="potongan_persen" id="potongan_persen" style="height:15px;font-size:15px" class="form-control" autocomplete="off" placeholder="" value="<?php echo $hasil_persen; ?>">
        </div>
        <div class="col-sm-4" style="display: none">          
          <label> Tax ( % )</label><br>
            <input type="text" name="tax" id="tax" class="form-control" style="height:15px;font-size:15px" autocomplete="off" data-pajak="" placeholder="" value="<?php echo $hasil_tax; ?>">
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <label> Tanggal Jatuh Tempo </label><br>
            <input type="text" name="tanggal_jt" id="tanggal_jt" placeholder="" style="height:15px;font-size:15px" value="" class="form-control tanggal" >
        </div>

        <div class="col-sm-6">          
          <label> Cara Bayar (F4) </label><br>
            <b><select type="text" name="cara_bayar" id="carabayar1" class="form-control chosen"  required="" style="font-size: 16px" ></b>
            <b><option value=""> Silahkan Pilih </option></b>
              <?php 

                 $sett_akun = $db->query("SELECT sa.kas, da.nama_daftar_akun FROM setting_akun sa INNER JOIN daftar_akun da ON sa.kas = da.kode_daftar_akun");
                 $data_sett = mysqli_fetch_array($sett_akun);

                         $query = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank'");
                         while($data = mysqli_fetch_array($query))
                         {
                           if ($data_sett['kas'] == $data['kode_daftar_akun']) {
                              echo "<option selected value='".$data['kode_daftar_akun']."'>".$data['nama_daftar_akun'] ."</option>";
                           }
                           else{
                              echo "<option value='".$data['kode_daftar_akun']."'>".$data['nama_daftar_akun'] ."</option>";
                           }
                                                  
                         }

                //Untuk Memutuskan Koneksi Ke Database
                mysqli_close($db);

  
              ?>
          
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <b><label> Total Akhir</label><br>
              <input type="text" name="total" id="total_pembelian" class="form-control" placeholder="" readonly="" style="font-size: 20px; height: 15px" ></b>
          </div>   
          <div class="col-sm-6">
            <b><label> Pembayaran (F7) </label><br>
              <input type="text" name="pembayaran" id="pembayaran_pembelian" autocomplete="off" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"  style="font-size: 20px; height: 15px"></b>
          </div>          
        </div>

        <div class="row">
          <div class="col-sm-6">
            <label> Kembalian </label><br>
              <b><input type="text" name="sisa_pembayaran" id="sisa_pembayaran_pembelian" style="height:15px;font-size:15px" class="form-control" placeholder=" " readonly="" style="font-size: 20px"></b>
          </div>
          <div class="col-sm-6">
            <label> Kredit </label><br>
              <b><input type="text" name="kredit" id="kredit" class="form-control" style="height:15px;font-size:15px" placeholder="" readonly=""></b>
          </div>
        </div>

  </div>

<!-- BAGIAN FILE HIDDEN --> <!-- BAGIAN FILE HIDDEN --> <!-- BAGIAN FILE HIDDEN --> <!-- BAGIAN FILE HIDDEN -->
          <b><input type="hidden" name="zxzx" id="zxzx" class="form-control" style="height: 50px; width:90%; font-size:25px;"  readonly="" required="" ></b>
          
          <b><input type="hidden" name="jumlah_bayar_lama" id="jumlah_bayar_lama" value="<?php echo $jumlah_bayar_lama; ?>" class="form-control" style="height: 50px; width:90%; font-size:25px;"  readonly=""></b>          
          
          <input type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="">  
          <input type="hidden" name="no_faktur" class="form-control" value="<?php echo $nomor_faktur; ?>" required="" >          
          <input type="hidden" name="suplier" id="supplier" class="form-control" required="" >
          <input type="hidden" name="ppn_input" id="ppn_input" value="<?php echo $ppn; ?>" class="form-control" placeholder="ppn input">  
<!-- BAGIAN FILE HIDDEN --> <!-- BAGIAN FILE HIDDEN --> <!-- BAGIAN FILE HIDDEN --> <!-- BAGIAN FILE HIDDEN -->

<!-- BAGIAN TOMBOL --> <!-- BAGIAN TOMBOL --> <!-- BAGIAN TOMBOL --> <!-- BAGIAN TOMBOL -->
        <button type="submit" id="pembayaran" class="btn btn-info"></i>Bayar (F8)</button>

        <a href="pembelian.php" id="transaksi_baru" style="display: none;" class="btn btn-info"><i class="fa fa-reply"></i> Kembali </a>

        <button type="submit" id="hutang" class="btn btn-warning" data-faktur='<?php echo $nomor_faktur ?>'>Hutang (F9)</button>
        <!--membuaat link pada tombol batal-->
        <button type="button" id="batal" class="btn btn-danger">Batal (F10)</button>

        <a href="cetak_coba_tunai.php" id="cetak_tunai" style="display: none;" class="btn btn-success" target="blank"><i class="fa fa-print"> </i> Cetak Tunai </a>

        <a href="cetak_coba_hutang.php" id="cetak_hutang" style="display: none;" class="btn btn-success" target="blank"> <i class="  fa fa-print"> </i> Cetak Hutang </a>

        <br>
        <div class="alert alert-success" id="alert_berhasil" style="display:none">
        <strong>Success!</strong> Pembayaran Berhasil
        </div>
     
<!-- BAGIAN TOMBOL --> <!-- BAGIAN TOMBOL --> <!-- BAGIAN TOMBOL -->  <!-- BAGIAN TOMBOL --> 


</div><!-- END COL_SM_4-->


</form><!--tag penutup form-->





</div><!-- end of row -->   


<span id="demo"> </span>

</div><!-- end of container -->

<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {
  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  $("#kode_barang").trigger('chosen:updated');
  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("over_stok").value = $(this).attr('over_stok');
  document.getElementById("satuan_produk").value = $(this).attr('satuan');
  document.getElementById("satuan_konversi").value = $(this).attr('satuan');
  document.getElementById("harga_produk").value = $(this).attr('harga');
  document.getElementById("harga_lama").value = $(this).attr('harga');
  document.getElementById("id_produk").value = $(this).attr('id-barang');
  document.getElementById("harga_baru").value = $(this).attr('harga');
  document.getElementById("jumlahbarang").value = $(this).attr('jumlah-barang');


  
  $('#myModal').modal('hide');
  });
   
   
  </script> <!--tag penutup perintah java script-->


   <script>
   //perintah javascript yang diambil dari form tbs pembelian dengan id=form tambah produk
    
  
   $("#submit_produk").click(function(){

    var no_faktur = $("#nomorfaktur").val();
    var suplier = $("#nama_suplier").val();
    var kode_barang = $("#kode_barang").val();
    var nama_barang = $("#nama_barang").val();
    var jumlah_barang = $("#jumlah_barang").val();
    var harga = $("#harga_produk").val();
    var harga_baru = $("#harga_baru").val();
    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
    var jumlahbarang = $("#jumlahbarang").val();
    var satuan = $("#satuan_produk").val();
    var kode_gudang = $("#kode_gudang").val();
    var ppn = $("#ppn").val();
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian").val()))));
    var potongan_persen = $("#potongan_persen").val();
    var tax_faktur = $("#tax").val();
    var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));
    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax1").val()))));
    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val()))));
        if (tax == '') {
      tax = 0;
    };


    if (subtotal == '') 
    {
    subtotal = 0;
    } 
      
        if (potongan == '') 
          {
             potongan = 0;
          }

        else
          {
            var pos = potongan.search("%");
           if (pos > 0) 
            {
               var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
               potongan_persen = potongan_persen.replace("%","");
               potongan = jumlah_barang * harga * potongan_persen / 100 ;
            };
          }


    if (ppn == 'Exclude') {  
         var total1 = parseInt(jumlah_barang,10) * parseInt(harga,10) - parseInt(potongan,10);
         var total_tax_exclude = parseInt(total1,10) * parseInt(tax,10) / 100;
         var total = parseInt(total1,10) + parseInt(Math.round(total_tax_exclude,10));
    }
    else
    {
        var total = parseInt(jumlah_barang,10) * parseInt(harga,10) - parseInt(potongan,10);
    }

    var total_akhir1 = parseInt(subtotal,10) + parseInt(total,10);    


  if (pot_fakt_per == '0%') {
      var potongaaan = pot_fakt_rp;
      var potongaaan = parseInt(potongaaan,10) / parseInt(total_akhir1,10) * 100;
      var pot_pers = parseInt(pot_fakt_rp,10) / parseInt(total_akhir1,10) * 100; 
      var total_akhir = parseInt(total_akhir1,10) - parseInt(pot_fakt_rp,10);
    }

  else if(pot_fakt_rp == 0){
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
          potongaaan = total_akhir1 * potongan_persen / 100;

     var total_akhir = parseInt(total_akhir1,10) - parseInt(Math.round(potongaaan,10));
     var pot_pers = parseInt(potongaaan,10) / parseInt(total_akhir1,10) * 100;
    }
     
  else if(pot_fakt_rp != 0 && pot_fakt_rp != 0){
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
          if(potongan_persen != 0 )
          {
            potongaaan = total_akhir1 * potongan_persen / 100;
          }
          else
          {
            potongaaan = 0;
          }


      var total_akhir = parseInt(total_akhir1,10) - parseInt(Math.round(potongaaan,10));
      var pot_pers = parseInt(potongaaan,10) / parseInt(total_akhir1,10) * 100;
    }


     $("#jumlah_barang").val(''); 
     $("#potongan1").val('');   
     $("#tax1").val('');
     $("#nama_barang").val('');
     $("#kode_barang").val('');
     $("#kode_barang").trigger('chosen:updated');
     $("#harga_produk").val('');
     $("#harga_baru").val('');

  if (kode_barang == ''){
  alert("Kode Barang Harus Diisi");
  }
  else if (jumlah_barang == ''){
  alert("Jumlah Barang Harus Diisi");
  }
  else if (suplier == ''){
  alert("Suplier Harus Dipilih");
  $("#nama_suplier").trigger('chosen:open');
  }
    else if (kode_gudang == ''){
  alert("Kode Gudang Harus Diisi");
  $("#kode_gudang").trigger('chosen:open');
  }
    else if (ppn == ''){
  alert("PPN Harus Diisi");
  $("#ppn").trigger('chosen:open');
  }    else if (tax > 100){
  alert("Tax Tidak Boleh Lebih Dari 100%");
  }


  
  else {


        $("#potongan_pembelian").val(Math.round(potongaaan,10));
        $("#potongan_persen").val(Math.round(pot_pers));
        $("#total_pembelian").val(tandaPemisahTitik(Math.round(total_akhir)));
        $("#total_pembelian1").val(tandaPemisahTitik(total_akhir1));
        $("#submit_produk").hide();

    $.post("proses_tbs_pembelian_edit.php",{no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,harga_baru:harga_baru,potongan:potongan,satuan:satuan,ppn:ppn,tax:tax},function(data){
      
      $("#tbody").prepend(data);
      $("#kode_barang").trigger('chosen:updated');
      $("#ppn").attr("disabled", true);
      $("#nama_barang").val('');
      $("#kode_barang").val('');
      $("#kode_barang").trigger('chosen:updated');
      $("#jumlah_barang").val('');
      $("#tax1").val('');  
      $("#harga_produk").val('');
      $("#harga_baru").val(''); 

    });

    $('#tabel_tbs_pembelian').DataTable().destroy();
    var dataTable = $('#tabel_tbs_pembelian').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax":{
        url :"data_tbs_pembelian_edit.php", // json datasource
        "data": function ( d ) {
          d.no_faktur = $("#nomorfaktur").val();
          // d.custom = $('#myInput').val();
          // etc
        },
         
         type: "post",  // method  , by default get
         error: function(){  // error handling
           $(".employee-grid-error").html("");
           $("#tabel_tbs_pembelian").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
           $("#employee-grid_processing").css("display","none");
           }
      },
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
           $(nRow).attr('class','tr-id-'+aData[11]+'');
         }
    });
}
    
      
  });
              
     $("form").submit(function(){
     return false;
     });


     
      
</script>



<script type="text/javascript" language="javascript" >
   $(document).ready(function() {

        var dataTable = $('#tabel_cari').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_beli_coba.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_cari").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('data-kode', aData[0]);
              $(nRow).attr('nama-barang', aData[1]);
              $(nRow).attr('over_stok', aData[7]);
              $(nRow).attr('satuan', aData[7]);
              $(nRow).attr('harga', aData[2]);
              $(nRow).attr('id-barang', aData[8]);
              $(nRow).attr('jumlah-barang', aData[3]);
              $(nRow).attr('kategori', aData[5]);
              $(nRow).attr('suplier', aData[6]);

            }

        });  

     
  });
 
 </script>


 <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#pembayaran").click(function(){

       var no_faktur = $("#nomorfaktur").val();
       var sisa_pembayaran = $("#sisa_pembayaran_pembelian").val();
       var kredit = $("#kredit").val();
       var suplier1 = $("#nama_suplier").val();
       var tanggal_jt = $("#tanggal_jt").val();
       var total = $("#total_pembelian").val();
       var total_1 = $("#total_pembelian1").val();
       var potongan = $("#potongan_pembelian").val();
       var potongan_persen = $("#potongan_persen").val();
       var tax = $("#tax").val();
       var tax1 = $("#tax1").val();
       var cara_bayar = $("#carabayar1").val();
       var jumlah_barang = $("#jumlah_barang").val();
       var pembayaran = $("#pembayaran_pembelian").val();
       var tanggal = $("#tanggal").val();
       var jumlah_bayar_lama = $("#jumlah_bayar_lama").val();
       var ppn = $("#ppn").val();
       var ppn_input = $("#ppn_input").val();
       var sisa = pembayaran - total;
       var sisa_kredit = total - pembayaran;

       var jumlah_kredit_baru = parseInt(kredit,10) - parseInt(jumlah_bayar_lama,10);
       var x = parseInt(jumlah_bayar_lama,10) + parseInt(pembayaran,10);
       $("#zxzx").val(x);


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

 else if (sisa < 0) 
 {

alert("Silakan Bayar Hutang");

 }

 else if (jumlah_bayar_lama == 0)
 {

       $("#pembayaran").hide();
       $("#batal").hide();
       $("#hutang").hide();
       $("#transaksi_baru").show(); 
       $("#alert_berhasil").show();
       $("#cetak_tunai").show();
       
       $.post("proses_bayar_coba.php",{total_1:total_1,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,suplier:suplier1,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,tax1:tax1,cara_bayar:cara_bayar,jumlah_barang:jumlah_barang,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,tanggal:tanggal,total_1:total_1,jumlah_kredit_baru:jumlah_kredit_baru,x:x,ppn:ppn,ppn_input:ppn_input},function(info) {
       
       
       
       
       });


           $('#tabel_tbs_pembelian').DataTable().destroy();
              var dataTable = $('#tabel_tbs_pembelian').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax":{
                  url :"data_tbs_pembelian_edit.php", // json datasource
                  "data": function ( d ) {
                    d.no_faktur = $("#nomorfaktur").val();
                    // d.custom = $('#myInput').val();
                    // etc
                  },
                   
                   type: "post",  // method  , by default get
                   error: function(){  // error handling
                     $(".employee-grid-error").html("");
                     $("#tabel_tbs_pembelian").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
                     $("#employee-grid_processing").css("display","none");
                     }
                },
                  "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                     $(nRow).attr('class','tr-id-'+aData[11]+'');
                   }
              });
 }

else
 {


      if (x > total)
      {
      
      var no_faktur = $(this).attr("data-faktur");
      
      $.post('alert_hutang_pembelian.php',{no_faktur:no_faktur},function(data){
      
      
      $("#modal_alert").modal('show');
      $("#modal-alert").html(data);
      
      });
      
      }

}


 $("form").submit(function(){
    return false;
});

    

  });
            


            
  
        
  </script>

   <script>
       //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
       $("#hutang").click(function(){
       
       var no_faktur = $("#nomorfaktur").val();
       var sisa_pembayaran = $("#sisa_pembayaran_pembelian").val();
       var kredit = $("#kredit").val();
       var suplier = $("#nama_suplier").val();
       var tanggal_jt = $("#tanggal_jt").val();
       var total = $("#total_pembelian").val();
       var potongan = $("#potongan_pembelian").val();
       var potongan_persen = $("#potongan_persen").val();
       var tax = $("#tax").val();
       var cara_bayar = $("#carabayar1").val();
       var jumlah_barang = $("#jumlah_barang").val();
       var pembayaran = $("#pembayaran_pembelian").val();
       var tanggal = $("#tanggal").val();
       var total_1 = $("#total_pembelian1").val();
       var jumlah_bayar_lama = $("#jumlah_bayar_lama").val();
       var tax1 = $("#tax1").val();
       var ppn = $("#ppn").val();
       var ppn_input = $("#ppn_input").val();
       
       var sisa = pembayaran - total;
       var sisa_kredit = total - pembayaran; 

       if (kredit == "") {
        kredit = 0;
       }

       var jumlah_kredit_baru = parseInt(kredit,10) - parseInt(jumlah_bayar_lama,10);
       var x = parseInt(jumlah_bayar_lama,10) + parseInt(pembayaran,10);
       $("#zxzx").val(x);


      if (kredit == "" )
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
       
 else if (jumlah_bayar_lama == 0 || x <= total)
 {


          $("#pembayaran").hide();
          $("#batal").hide();
          $("#hutang").hide();
          $("#transaksi_baru").show();
       
       $.post("proses_bayar_coba.php",{total_1:total_1,tax1:tax1,tanggal:tanggal,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,suplier:suplier,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,jumlah_barang:jumlah_barang,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_1:total_1,jumlah_kredit_baru:jumlah_kredit_baru,x:x,ppn:ppn,ppn_input:ppn_input},function(info) {

       
       $("#alert_berhasil").show();
       $("#result").html(info);
       $("#cetak_hutang").show();
       $("#sisa_pembayaran_pembelian").val('');
       $("#tanggal_jt").val('');
       
       
       
       });
       
                  $('#tabel_tbs_pembelian').DataTable().destroy();
              var dataTable = $('#tabel_tbs_pembelian').DataTable( {
                "processing": true,
                "serverSide": true,
                "ajax":{
                  url :"data_tbs_pembelian_edit.php", // json datasource
                  "data": function ( d ) {
                    d.no_faktur = $("#nomorfaktur").val();
                    // d.custom = $('#myInput').val();
                    // etc
                  },
                   
                   type: "post",  // method  , by default get
                   error: function(){  // error handling
                     $(".employee-grid-error").html("");
                     $("#tabel_tbs_pembelian").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
                     $("#employee-grid_processing").css("display","none");
                     }
                },
                  "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                     $(nRow).attr('class','tr-id-'+aData[11]+'');
                   }
              });
  }

else
 {


      if (x > total)
      {
      
      var no_faktur = $(this).attr("data-faktur");
      
      $.post('alert_hutang_pembelian.php',{no_faktur:no_faktur},function(data){
      
      
      $("#modal_alert").modal('show');
      $("#modal-alert").html(data);
      
      });
      
      }

}
      


 $("form").submit(function(){
       return false;
       });

  });    
  </script>

  <script type="text/javascript">
  $(document).ready(function(){
$("#cari_produk_pembelian").click(function(){
  var no_faktur = $("#nomorfaktur").val();

  $.post("cek_tbs_coba.php",{no_faktur: no_faktur},function(data){
        if (data == 1) {
             $("#ppn").attr("disabled", true);
        }
        else{
             $("#ppn").attr("disabled", false);
        }
    });
  $("#submit_produk").show();
});
});
</script>






<script type="text/javascript">
// untuk memunculkan data cek total pembelian
$(document).ready(function(){

        var no_faktur = $("#nomorfaktur").val();  
        var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));   
        var tax = $("#tax").val();
        if (tax == "") {
          tax = 0;
        }        


$.post("cek_total_coba.php",{no_faktur: no_faktur},function(data){
      data = data.replace(/\s+/g, '');
      var diskon_faktur =  parseInt(data,10) * parseInt(potongan_persen,10) / 100;
      var sub_total = parseInt(data,10) - parseInt(Math.round(diskon_faktur,10));
      var t_tax =  parseInt(sub_total,10) * parseInt(tax,10) / 100;
      var total_akhirr = parseInt(sub_total,10) + parseInt(Math.round(t_tax,10));

        $("#total_pembelian1"). val(tandaPemisahTitik(data));
        $("#total_pembelian"). val(tandaPemisahTitik(total_akhirr));
        $("#potongan_pembelian"). val(tandaPemisahTitik(Math.round(diskon_faktur)));

    });

});


</script>




<script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var no_faktur = $("#nomorfaktur").val();
    var kode_barang = $("#kode_barang").val();
 $.post('cek_kode_barang_edit_tbs_pembelian.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").chosen("destroy");
          $("#kode_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
   }//penutup if

    });

    });//penutup click(function()
  });//penutup ready(function()
</script>

<script>

// untuk memunculkan sisa pembayaran secara otomatis
  $(document).ready(function(){
    $("#pembayaran_pembelian").keyup(function(){
      var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_pembelian").val()))));
      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian").val()))));
      var sisa = pembayaran - total;
      var sisa_kredit = total - pembayaran;

      if (sisa < 0  )
      {

       $("#kredit").val(sisa_kredit);
       $("#sisa_pembayaran_pembelian").val('0');
       $("#tanggal_jt").attr("disabled", false);
      }

else  
      {
       
       
        $("#sisa_pembayaran_pembelian").val(sisa);
        $("#kredit").val('0');
        $("#tanggal_jt").attr("disabled", true);
       } 
      
      
    });


  });
</script>
<!--
<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").keyup(function(){

          var kode_barang = $(this).val();
          var no_faktur = $("#nomorfaktur").val();
          
          $.post("cek_barang_pembelian.php",
          {
          kode_barang: kode_barang
          },
          function(data){
          $("#jumlahbarang").val(data);
          });
          
          $.post('cek_kode_barang_edit_tbs_pembelian.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
          
          if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          }//penutup if
          
          });////penutup function(data)


      $.getJSON('lihat_nama_barang_pembelian.php',{kode_barang:$(this).val()}, function(json){
      
      if (json == null)
      {
        
        $('#nama_barang').val('');
        $('#over_stok').val('');
        $('#harga_produk').val('');
        $('#satuan_produk').val('');
        $('#harga_baru').val('');
      }

      else 
      {
        $('#nama_barang').val(json.nama_barang);
        $('#over_stok').val(json.over_stok);
        $('#harga_produk').val(json.harga_beli);
        $('#satuan_produk').val(json.satuan);
        $('#harga_baru').val(json.harga_beli);
      }
                                              
        });
        
        });
        });

      
      
</script>

-->


<script type="text/javascript">
  
  $(document).ready(function(){
  $("#kode_barang").change(function(){

    var kode_barang = $(this).val();
    var no_faktur = $("#nomorfaktur").val();
    var nama_barang = $('#opt-produk-'+kode_barang).attr("nama-barang");
    var harga_jual = $('#opt-produk-'+kode_barang).attr("harga");
    var jumlah_barang = $('#opt-produk-'+kode_barang).attr("jumlah-barang");
    var satuan = $('#opt-produk-'+kode_barang).attr("satuan");
    var kategori = $('#opt-produk-'+kode_barang).attr("kategori");
    var status = $('#opt-produk-'+kode_barang).attr("status");
    var suplier = $('#opt-produk-'+kode_barang).attr("suplier");
    var limit_stok = $('#opt-produk-'+kode_barang).attr("limit_stok");
    var over_stok = $('#opt-produk-'+kode_barang).attr("over_stok");
    var harga_lama = $('#opt-produk-'+kode_barang).attr("harga");
    var harga_produk = $('#opt-produk-'+kode_barang).attr("harga");
    var harga_baru = $('#opt-produk-'+kode_barang).attr("harga");
    var ber_stok = $('#opt-produk-'+kode_barang).attr("ber-stok");
    var tipe_barang = $('#opt-produk-'+kode_barang).attr("tipe_barang");
    var id_barang = $('#opt-produk-'+kode_barang).attr("id-barang");
    var level_harga = $("#level_harga").val();
    var no_reg = $("#no_reg").val();


    $("#kode_barang").val(kode_barang);
    $("#nama_barang").val(nama_barang);
    $("#jumlah_barang").val(jumlah_barang);
    $("#satuan_produk").val(satuan);
    $("#harga_lama").val(harga_lama);
    $("#harga_produk").val(harga_produk);
    $("#harga_baru").val(harga_baru);
    $("#satuan_konversi").val(satuan);
    $("#over_stok").val(over_stok);
    $("#limit_stok").val(limit_stok);
    $("#ber_stok").val(ber_stok);
    $("#id_produk").val(id_barang);

if (ber_stok == 'Barang') {

    $.post('ambil_jumlah_produk.php',{kode_barang:kode_barang}, function(data){
      if (data == "") {
        data = 0;
      }
      $("#jumlahbarang").val(data);
      $('#kolom_cek_harga').val('1');
    });

}


$.post('cek_kode_barang_tbs_pembelian_edit.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
          
  if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

          $("#kode_barang").chosen("destroy");
          $("#kode_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
   }//penutup if     



  });

  $("#submit_produk").show('');
  });

  });

</script>


<script>

//untuk menampilkan sisa penjualan secara otomatis
  $(document).ready(function(){

  $("#jumlah_barang").keyup(function(){

    var jumlah_barang = $("#jumlah_barang").val();
    if (jumlah_barang == "") {
      jumlah_barang = 0;
    }
    var jumlahbarang =$("#jumlahbarang").val();
     var over_stok = $("#over_stok").val();
    var stok = parseInt(jumlah_barang) + parseInt(jumlahbarang);


if( over_stok < stok ){

      alert ("Persediaan Barang Ini Sudah Melebihi Batas Stok!");
      
    }


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


            
            var suplier = $("#nama_suplier").val();
            
            if (suplier != ""){
            $("#nama_suplier").attr("disabled", true);
            }
            
            
            });
        
    });
</script>

<script type="text/javascript">
  $(document).ready(function(){
      var cara_bayar = $("#carabayar1").val();
      //metode POST untuk mengirim dari file cek_jumlah_kas.php ke dalam variabel "dari akun"
      $.post('cek_jumlah_kas1.php', {cara_bayar : cara_bayar}, function(data) {
        /*optional stuff to do after success */

      $("#jumlah1").val(data);
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
  $("#potongan_persen").keyup(function(){

      var potongan_persen = $("#potongan_persen").val();

            if (potongan_persen > 100){
              alert("Potongan Tidak Boleh Lebih Dari 100%");              
              $("#potongan_pembelian").val(0);
              $("#potongan_persen").val(0);
              $("#potongan_pembelian").attr("disabled", false);
              $("#potongan_persen").attr("disabled", false);
             }
  });
</script>

      <script>
      

      $(document).ready(function(){
      $("#potongan_persen").keyup(function(){
      var potongan_persen = $("#potongan_persen").val();

      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));
      var pembayaran = $("#pembayaran_pembelian").val();
      var tax = $("#tax").val();

      if (tax == "") {
        tax = 0;
      }
      if (potongan_persen == "") {
        potongan_pembelian = 0;
        potongan_persen =0
      }
      var potongan_rp =  parseInt(total,10) * parseInt(potongan_persen,10) / 100;
      var sisa_potongan = total - potongan_rp;
      var kredit = parseInt(sisa_potongan, 10) - parseInt(pembayaran,10);
      var kembalian = parseInt(pembayaran,10) - parseInt(sisa_potongan, 10);
      var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
      var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(t_tax,10);
             
      if (kembalian == 0) {
      $("#kredit").val(kredit);
      $("#sisa_pembayaran_pembelian").val('0');
      }
      if (kredit == 0) {
      $("#kredit").val('0');
      $("#sisa_pembayaran_pembelian").val(kembalian);
      }

             

             if (potongan_rp != ""){
             $("#potongan_pembelian").attr("disabled", true);
             }

             else{
              $("#potongan_pembelian").attr("disabled", false);
             }
             
      $("#total_pembelian").val(Math.round(hasil_akhir));
      $("#potongan_pembelian").val(Math.round(potongan_rp));

      });
      });

      $(document).ready(function(){
        $("#potongan_pembelian").keyup(function(){
          var potongan_pembelian = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val()))));
          var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));
          var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_pembelian").val()))));
          var tax = $("#tax").val();

            if (tax == "") {
              tax = 0;
            }

          var potongan_persen = ((potongan_pembelian / total) * 100);

          if (potongan_persen > 100){
              alert("Potongan Tidak Boleh Lebih Dari 100%");
              potongan_pembelian = 0;
              potongan_persen = 0;
              $("#potongan_pembelian").attr("disabled", false);
              $("#potongan_persen").attr("disabled", false);
              $("#potongan_pembelian").val('');

             }

          var sisa_potongan = total - potongan_pembelian;
          var kredit = parseInt(sisa_potongan, 10) - parseInt(pembayaran,10);
          var kembalian = parseInt(pembayaran,10) - parseInt(sisa_potongan, 10);
          var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
          var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(t_tax,10);


          
            if (kembalian == 0) {
            $("#kredit").val(kredit);
            $("#sisa_pembayaran_pembelian").val('0');
            }
            else if (kredit == 0) {
            $("#kredit").val('0');
            $("#sisa_pembayaran_pembelian").val(kembalian);
            }
      
             if (potongan_persen != ""){
             $("#potongan_persen").attr("disabled", true);
             }

             else{
              $("#potongan_persen").attr("disabled", false);
             }

      $("#total_pembelian").val(Math.round(hasil_akhir));
      $("#potongan_persen").val(Math.round(potongan_persen));

            
        });
      });

</script>

<script type="text/javascript">
      
      $(document).ready(function(){


      $("#tax").keyup(function(){

              var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val()))));
              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();
              var pembayaran = $("#pembayaran_pembelian").val();
              var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));
              var t_total = total - potongan;

              if (tax == "") {
                tax = 0;
              }
              
              var t_tax = ((parseInt(t_total,10) * parseInt(tax,10)) / 100);
              var total_akhir = parseInt(t_total,10) + parseInt(t_tax,10);
              var kredit = parseInt(total_akhir, 10) - parseInt(pembayaran, 10);
              var kembalian = parseInt(pembayaran, 10) - parseInt(total_akhir, 10);
              
              
              if (kembalian < 0) {
              $("#kredit").val(kredit);
              $("#sisa_pembayaran_pembelian").val('0');
              }
              if (kredit < 0) {
              $("#kredit").val('0');
              $("#sisa_pembayaran_pembelian").val(kembalian);
              }


              
              $("#total_pembelian").val(parseInt(total_akhir));

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');

              }


      });
    });
      
</script>

    <script type="text/javascript">
      $(document).ready(function(){
      $("#pembayaran_pembelian").focus(function(){

              var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val()))));
              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();
              var pembayaran = $("#pembayaran_pembelian").val();
              var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));
              var t_total = total - potongan;

              if (tax == "") {
                tax = 0;
              }
              else if (pembayaran == "") {
                pembayaran = 0;
              }
              else if (cara_bayar == "") {
                alert ("Kolom Cara Bayar Masih Kosong");
                 $("#tax").val('');
                 $("#potongan_pembelian").val('');
                 $("#potongan_persen").val('');
              }

              var t_tax = ((parseInt(t_total,10) * parseInt(tax,10)) / 100);
              var total_akhir = parseInt(t_total,10) + parseInt(t_tax,10);
              var kredit = parseInt(total_akhir, 10) - parseInt(pembayaran, 10);
              var kembalian = parseInt(pembayaran, 10) - parseInt(total_akhir, 10);
              
              
              if (kembalian < 0) {
              $("#kredit").val(kredit);
              $("#sisa_pembayaran_pembelian").val('0');
              }
              if (kredit < 0) {
              $("#kredit").val('0');
              $("#sisa_pembayaran_pembelian").val(kembalian);
              }
              
              
              $("#total_pembelian").val(tandaPemisahTitik(parseInt(total_akhir)));

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');

              }

      });
    });
      
</script>

<script type="text/javascript">
      $(document).ready(function(){
      $("#tanggal_jt").blur(function(){

              var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val()))));
              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();
              var pembayaran = $("#pembayaran_pembelian").val();
              var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));
              var t_total = total - potongan;

              if (tax == "") {
                tax = 0;
              }
              else if (pembayaran == "") {
                pembayaran = 0;
              }
              else if (cara_bayar == "") {
                alert ("Kolom Cara Bayar Masih Kosong");
                 $("#tax").val('');
                 $("#potongan_pembelian").val('');
                 $("#potongan_persen").val('');
              }

              var t_tax = ((parseInt(t_total,10) * parseInt(tax,10)) / 100);
              var total_akhir = parseInt(t_total,10) + parseInt(t_tax,10);
              var kredit = parseInt(total_akhir, 10) - parseInt(pembayaran, 10);
              var kembalian = parseInt(pembayaran, 10) - parseInt(total_akhir, 10);
              
              
              if (kembalian < 0) {
              $("#kredit").val(kredit);
              $("#sisa_pembayaran_pembelian").val('0');
              }
              if (kredit < 0) {
              $("#kredit").val('0');
              $("#sisa_pembayaran_pembelian").val(kembalian);
              }
              
              
              $("#total_pembelian").val(tandaPemisahTitik(parseInt(total_akhir)));

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');

              }

      });
    });
      
</script>



      <script type="text/javascript">
        
        $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 

      </script>


<script type="text/javascript">
 
$(".btn-alert-hapus").click(function(){
     var no_faktur = $(this).attr("data-faktur");
    var kode_barang = $(this).attr("data-kode");

    $.post('alert_edit_pembelian.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){
    
 
    $("#modal_alert").modal('show');
    $("#modal-alert").html(data); 

});

  });
</script>

<script type="text/javascript">
    $(document).ready(function(){
      
//fungsi hapus data
$(document).on('click', '.btn-hapus-tbs', function (e) {
    var subtotal_tbs = $(this).attr("data-subtotal");
    var nama_barang = $(this).attr("data-barang");
    var kode_barang = $(this).attr("data-kode-barang");
    var id = $(this).attr("data-id");
    var subtotal_tbs = $(this).attr("data-subtotal");
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));
    var potongan_persen = $("#potongan_persen").val();
    var tax = $("#tax").val();

      if (total == '') 
        {
          total = 0;
        };

      if (potongan_persen == '') 
        {
          potongan_persen = 0;
        };

      if (tax == '') 
        {
          tax = 0;
        };
    var total_akhir = parseInt(total,10) - parseInt(subtotal_tbs,10);
    var diskon_faktur = parseInt(total_akhir,10) * parseInt(potongan_persen,10) / 100;
    var sub_krg_diskon = parseInt(total_akhir,10) - parseInt(diskon_faktur,10);
    var tax_faktur = parseInt(sub_krg_diskon,10) * parseInt(tax,10) / 100;
    var total_bener = parseInt(sub_krg_diskon,10) + parseInt(tax_faktur,10);

  var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus '"+nama_barang+"' "+ "?");
  if (pesan_alert == true) {


      $("#total_pembelian").val(tandaPemisahTitik(total_bener));
      $("#total_pembelian1").val(tandaPemisahTitik(total_akhir));
      $("#potongan_pembelian").val(tandaPemisahTitik(diskon_faktur));
      $(".tr-id-"+id+"").remove();
      
      $.post("hapus_coba.php",{id:id},function(data){

      });

      $('#tabel_tbs_pembelian').DataTable().destroy();
        var no_faktur = $("#nomorfaktur").val();
        var dataTable = $('#tabel_tbs_pembelian').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"data_tbs_pembelian_edit.php", // json datasource
            "data": function ( d ) {
              d.no_faktur = $("#nomorfaktur").val();
              // d.custom = $('#myInput').val();
              // etc
            },
             
             type: "post",  // method  , by default get
             error: function(){  // error handling
               $(".employee-grid-error").html("");
               $("#tabel_tbs_pembelian").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
               $("#employee-grid_processing").css("display","none");
               }
          },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
               $(nRow).attr('class','tr-id-'+aData[11]+'');
             }
        });
      
      }
  else {
      
      }   

      $.post("cek_tbs_coba.php",{no_faktur: no_faktur},function(data){
        if (data == "1") {
             $("#ppn").attr("disabled", true);
        }
        else{
             $("#ppn").attr("disabled", false);
        }
    });
    
    });

//end fungsi hapus data



              $('form').submit(function(){
              
              return false;
              });
        });


    
     
     function tutupmodal() {
     $(".modal").modal("hide")
     }
     function tutupalert() {
     $(".alert").hide("fast")
     }

</script>


<script type="text/javascript">
//fungsi edit data 
$(document).ready(function(){
        $(".btn-edit-tbs").click(function(){
        
        $("#modal_edit").modal('show');
        var jumlah_barang = $(this).attr("data-jumlah-barang");
        var harga = $(this).attr("data-harga");
        var no_faktur = $(this).attr("data-faktur");
        var kode_barang = $(this).attr("data-kode");
        var potongan  = $(this).attr("data-potongan");
        var tax  = $(this).attr("data-tax");
        var id  = $(this).attr("data-id");
        $("#harga_edit").val(harga);
        $("#barang_lama").val(jumlah_barang);
        $("#faktur_edit").val(no_faktur);
        $("#kode_edit").val(kode_barang);
        $("#id_edit").val(id);
        $("#potongan_edit").val(potongan);
        $("#tax_edit").val(tax);
        
        
        });
        
        $("#submit_edit").click(function(){
        var jumlah_barang = $("#barang_lama").val();
        var jumlah_baru = $("#barang_edit").val();
        var harga = $("#harga_edit").val();
        var potongan = $("#potongan_edit").val();
        var tax = $("#tax_edit").val();
        var kode_barang = $("#kode_edit").val();
        var id = $("#id_edit").val();

        $.post("update_coba.php",{id:id,jumlah_barang:jumlah_barang,jumlah_baru:jumlah_baru,harga:harga,potongan:potongan,tax:tax,kode_barang:kode_barang},function(data){

          $("#kode_barang").focus();
        $("#alert").html(data);
        $("#result").load('tabel-coba.php?no_faktur=<?php echo $nomor_faktur; ?>');
        setTimeout(tutupmodal, 2000);
        setTimeout(tutupalert, 2000);
      
        });
        });
//end function edit data

              $('form').submit(function(){
              
              return false;
              });
});

     function tutupmodal() {
     $(".modal").modal("hide")
     }
     function tutupalert() {
     $(".alert").hide("fast")
     }


</script>

<script type="text/javascript">
  $(document).on('click', '.tidak_punya_otoritas', function (e) {
    var nama_barang = $(this).attr('data-nama');
    alert("Anda Tidak Punya Otoritas Untuk Edit Jumlah Produk '"+nama_barang+"'!!");
  });
</script>


<script type="text/javascript">
                  
  $(document).on('dblclick','.edit-jumlah',function(){
      var id = $(this).attr("data-id");
      $("#text-jumlah-"+id+"").hide();
      $("#input-jumlah-"+id+"").attr("type", "text");
  });

  $(document).on('blur','.input_jumlah',function(){

      var id = $(this).attr("data-id");
      var jumlah_baru = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).val()))));
      var kode_barang = $(this).attr("data-kode");
      var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-harga")))));
      var jumlah_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-jumlah-"+id+"").text()))));
      var no_faktur = $("#nomorfaktur").val();
      var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));
      var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
      var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
      if (tax == "") {
        tax = 0;
      }

      var potongan_persen = $("#potongan_persen").val();
       if (potongan_persen == '')
        {
          potongan_persen = 0;
        }

      var ppn = $("#ppn").val();
           
      var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
      
      var subtotal_tbs = parseInt(harga,10) * parseInt(jumlah_lama,10) - parseInt(potongan,10);
      var subtotal = parseInt(harga,10) * parseInt(jumlah_baru,10) - parseInt(potongan,10);
      
      var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));
           
      var tax_tbs = tax / subtotal_tbs * 100;
      var jumlah_tax = tax_tbs * subtotal / 100;
      if (ppn == 'Exclude') {
        var sub_tampil = parseInt(subtotal,10) + parseInt(Math.round(jumlah_tax,10));
        var subtotal_penjualan = parseInt(subtotal_penjualan,10) - parseInt(subtotal_lama,10) + parseInt(sub_tampil,10);
        var diskon_faktur = parseInt(subtotal_penjualan,10) * parseInt(potongan_persen) / 100;
        var sub_akhir = parseInt(subtotal_penjualan,10) - parseInt(Math.round(diskon_faktur,10));
      }
      else{
        var sub_tampil = parseInt(subtotal,10);
        var subtotal_penjualan = parseInt(subtotal_penjualan,10) - parseInt(subtotal_lama,10) + parseInt(sub_tampil,10);
        var diskon_faktur = parseInt(subtotal_penjualan,10) * parseInt(potongan_persen) / 100;
        var sub_akhir = parseInt(subtotal_penjualan,10) - parseInt(Math.round(diskon_faktur,10));
      }


      if (jumlah_baru == 0) {
                alert("Jumlah Barang Tidak Boleh Nol (0) atau Kosong");

                $("#input-jumlah-"+id+"").val(jumlah_lama);
                $("#text-jumlah-"+id+"").text(jumlah_lama);
                $("#text-jumlah-"+id+"").show();
                $("#input-jumlah-"+id+"").attr("type", "hidden");
      }
      else{

                $("#text-jumlah-"+id+"").show();
                $("#text-jumlah-"+id+"").text(jumlah_baru);
                $("#text-subtotal-"+id+"").text(tandaPemisahTitik(sub_tampil));
                $("#hapus-tbs-"+id+"").attr('data-subtotal', sub_tampil);
                $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                $("#total_pembelian").val(tandaPemisahTitik(sub_akhir));   
                $("#total_pembelian1").val(tandaPemisahTitik(subtotal_penjualan));
                $("#potongan_pembelian").val(Math.round(diskon_faktur));


              $.post("update_pesanan_barang_beli.php",{harga:harga,jumlah_lama:jumlah_lama,jumlah_tax:jumlah_tax,potongan:potongan,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,sub_tampil:sub_tampil},function(){

              });
      }

        $("#pembayaran_pembelian").val("");

  });

</script>


<script type="text/javascript">
  
      $(".edit-jumlah-alert").dblclick(function(){

      var no_faktur = $(this).attr("data-faktur");
      var kode_barang = $(this).attr("data-kode");
      
      $.post('alert_edit_pembelian.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){

      $("#modal_alert").modal('show');
      $("#modal-alert").html(data);


});
});
</script>




<script type="text/javascript">
    $(document).ready(function(){


      /*$("#tax").attr("disabled", true);*/

    // cek ppn exclude 
    var no_faktur = $("#nomorfaktur").val();
    $.get("cek_ppn_ex_edit.php",{no_faktur:no_faktur},function(data){
      if (data == 1) {
          $("#ppn").val('Exclude');
     $("#ppn").attr("disabled", true);
     $("#tax1").attr("disabled", false);
      }
      else if(data == 2){

      $("#ppn").val('Include');
     $("#ppn").attr("disabled", true);
       $("#tax1").attr("disabled", false);
      }
      else
      {

     $("#ppn").val('Non');
     $("#tax1").attr("disabled", true);

      }

    });


    $("#ppn").change(function(){

    var ppn = $("#ppn").val();
    $("#ppn_input").val(ppn);

  if (ppn == "Include"){

      $("#tax1").attr("disabled", false);

  }

  else if (ppn == "Exclude") {
    $("#tax1").attr("disabled", false);
  }
  else{

    $("#tax1").attr("disabled", true);
  }


  });
  });
</script>




<script>

$(document).ready(function(){
    $("#satuan_konversi").change(function(){

      var prev = $("#satuan_produk").val();
      var harga_lama = $("#harga_lama").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var id_produk = $("#id_produk").val();
      

      $.getJSON("cek_satuan_konversi.php",{satuan_konversi:satuan_konversi, id_produk:id_produk},function(info){
        
        if (satuan_konversi == prev) {
        

          $("#harga_produk").val(harga_lama);
          $("#harga_baru").val(harga_lama);

        }

        else if (info.jumlah_total == 0) {
          alert('Satuan Yang Anda Pilih Tidak Tersedia Untuk Produk Ini !');
          $("#satuan_konversi").val(prev);
          $("#harga_produk").val('');
          $("#harga_baru").val('');

        }

        else{
          $("#harga_produk").val(info.harga_pokok);
          $("#harga_baru").val(info.harga_pokok);
        }

      });
        
    });

});
</script>


<script type="text/javascript">
$(document).ready(function(){
  $("#batal").click(function(){
    var no_faktur = $("#no_faktur").val();

    var pesan_alert = confirm("Apakah Anda Yakin Ingin Membatalkan Pembelian "+no_faktur+" ?");
    if (pesan_alert == true) {
        
        $.get("batal_pembelian_edit.php",{no_faktur:no_faktur},function(data){

          $('#tabel_tbs_pembelian').DataTable().destroy();
            var dataTable = $('#tabel_tbs_pembelian').DataTable({
              "processing": true,
              "serverSide": true,
              "ajax":{
                url :"data_tbs_pembelian_edit.php", // json datasource
                "data": function ( d ) {
                  d.no_faktur = $("#no_faktur").val();
                  // d.custom = $('#myInput').val();
                  // etc
                },
                 
                 type: "post",  // method  , by default get
                 error: function(){  // error handling
                   $(".employee-grid-error").html("");
                   $("#tabel_tbs_pembelian").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
                   $("#employee-grid_processing").css("display","none");
                   }
              },
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                   $(nRow).attr('class','tr-id-'+aData[11]+'');
                 }
            });

        });
    } 

    else {
    
    }

  });
  });
</script>


<!-- SHORTCUT -->

<script> 
    shortcut.add("f1", function() {
        // Do something

        $("#cari_produk_pembelian").click();

    });
    shortcut.add("f2", function() {
        // Do something

        $("#kode_barang").trigger('chosen:open');

    });
    shortcut.add("f3", function() {
        // Do something

        $("#submit_produk").click();

    });
    shortcut.add("f4", function() {
        // Do something

        $("#carabayar1").trigger('chosen:open');

    });
    shortcut.add("f7", function() {
        // Do something

        $("#pembayaran_pembelian").focus();

    });
    shortcut.add("f8", function() {
        // Do something

        $("#pembayaran").click();

    });
    shortcut.add("f9", function() {
        // Do something

        $("#hutang").click();

    });
    shortcut.add("f10", function() {
        // Do something

        $("#batal").click();

    });
    shortcut.add("alt+p", function() {
        // Do something
        $("#nama_suplier").trigger('chosen:open');

    });
</script>


<script>
  $(document).ready(function(){
      $("#kode_barang").trigger('chosen:open');
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {

    var no_faktur = $("#nomorfaktur").val();
    var dataTable = $('#tabel_tbs_pembelian').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax":{
        url :"data_tbs_pembelian_edit.php", // json datasource
        "data": function ( d ) {
          d.no_faktur = $("#nomorfaktur").val();
          // d.custom = $('#myInput').val();
          // etc
        },
         
         type: "post",  // method  , by default get
         error: function(){  // error handling
           $(".employee-grid-error").html("");
           $("#tabel_tbs_pembelian").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
           $("#employee-grid_processing").css("display","none");
           }
      },
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
           $(nRow).attr('class','tr-id-'+aData[11]+'');
         }
    });
  });
</script>


<!-- SHORTCUT -->




<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>

