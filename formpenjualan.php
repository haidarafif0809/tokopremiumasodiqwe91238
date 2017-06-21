<?php include_once 'session_login.php';
// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';
 
$pilih_akses_tombol = $db->query("SELECT tombol_cash_drawer FROM otoritas_setting WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);


$session_id = session_id();

 ?>

<!-- Modal Untuk Confirm PESAN alert-->
<div id="modal_promo_alert" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
        <div class="modal-body">
            <span id="tampil_alert">
            </span>
        </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="closed_alert_promo" data-dismiss="modal">Closed (Ctrl + G)</button>
    </div>
    </div>
  </div>
</div>
<!--modal end pesan alert-->

<!--MULAI PUNYA PROMO-->
<!-- Modal Untuk PRODuk Promo free -->
<div id="modal_bonus_nya" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h4 class="modal-title"><center><b>SYARAT BONUS PRODUK TELAH TERPENUHI. ANDA BERHAK MENDAPATKAN PRODUK (GRATIS). SILAKAN KLIK PRODUK YANG ANDA INGINKAN.</b></center></h4>      
    </div>
    <div class="modal-body">
      <div class="table-responsive">
        <table id="table_produk_bonus" class="table table-bordered table-sm">
        <thead>
          <th> Kode Produk </th>
          <th> Nama Produk </th>
          <th> Nama Program </th>
          <th> Jml Bonus</th>
        </thead>
        </table>
      </div>
    </div><!-- tag penutup modal body -->
    <div class="modal-footer">
            <button type="submit" class="btn btn-primary" data-dismiss="modal">close</button>       
    </div>
    </div>
  </div>
</div>
<!--end modal PRODUK Promo free-->


<!-- Modal Untuk PRODuk Promo disc -->
<div id="modal_bonus_disc_nya" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h4 class="modal-title"><center><b>SYARAT TELAH TERPENUHI. ANDA BERHAK MEMDAPATKAN PRODUK DENGAN HARGA YANG LEBIH MURAH. SILAKAN KLIK PRODUK YANG ANDA INGINKAN.</b></center></h4>      
    </div>
    <div class="modal-body">
      <div class="table-responsive">
        <table id="table_produk_bonus_disc" class="table table-bordered table-sm">
        <thead>
          <th> Kode Produk </th>
          <th> Nama Produk </th>
          <th> Jml Maks </th>
          <th> Harga </th>
          <th> Harga Normal </th>
          <th> Nama Program </th>
        </thead>
        </table>
      </div>
    </div><!-- tag penutup modal body -->
    <div class="modal-footer">
            <button type="submit" class="btn btn-primary" data-dismiss="modal">close</button>       
    </div>
    </div>
  </div>
</div>
<!--end modal PRODUK Promo disc-->

<!-- Modal pemberitahuan hapus produk promo nya -->
<div id="modal_hapus_bonus_ditbs" class="modal" role="dialog">
  <div class="modal-dialog modal-lg"-->
    <!-- Modal content-->
    <<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
           
    </div>
    <div class="modal-body">
      <h4 class="modal-title"><center><b>SYARAT BELANJA SUDAH TIDAK TERPENUHI. SILAKAN KLIK HAPUS UNTUK MENGHAPUS BARANG :</b></center></h4>
      <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-3">
          <b><input type="text" name="kode_produk_bonus" id="kode_produk_bonus" readonly="" style="height: 50px%; font-size: 50px%;"></b>
        </div>
        <div class="col-sm-3">
          <b><input type="text" name="nama_produk_bonus" id="nama_produk_bonus" readonly="" style="height: 50px%; font-size: 50px%;"></b>
        </div>
        <div class="col-sm-3"></div>
      </div>
    </div><!-- tag penutup modal body -->
    <div class="modal-footer">
            <div class="row">
              <div class="col-sm-6">
                <button type="submit" class="btn btn-danger" id="hapus_bonus_ditbs" data-dismiss="modal">Hapus</button>
              </div>
              <div class="col-sm-6">
                <button type="submit" class="btn btn-primary" data-dismiss="modal">close</button>
              </div>
            </div>       
    </div>
    </div>
  </div>
</div>
<!--end modal nya-->
<!--AKHIR PUNYA PROMO-->

<!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->


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


Number.prototype.format = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};
</script>

<!--untuk membuat agar tampilan form terlihat rapih dalam satu tempat -->
 <div style="padding-left: 5%; padding-right: 5%;">
  <h3> FORM PENJUALAN </h3>
<div class="row">
<div class="col-sm-8">


 <!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="formpenjualan.php" method="post ">  

        <div class="form-group">
        <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo session_id(); ?>" readonly="">
        </div>

<div class="row">
<div class="col-sm-4">
    <label> Kode Pelanggan </label><br>
  <select name="kode_pelanggan" id="kd_pelanggan" class="form-control chosen" required="" autofocus="">
 
  <?php 

    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query = $db->query("SELECT kode_pelanggan,nama_pelanggan,level_harga FROM pelanggan ");

    //untuk menyimpan data sementara yang ada pada $query
    while($data = mysqli_fetch_array($query))
    {




    echo "<option value='".$data['kode_pelanggan'] ."' class='opt-pelanggan-".$data['kode_pelanggan']."' data-level='".$data['level_harga'] ."'>".$data['kode_pelanggan'] ." - ".$data['nama_pelanggan'] ."</option>";

            
    }
    
    
    ?>
    </select>
</div>
    

<div class="col-sm-2">
      <label class="gg" > Gudang </label><br>
        <select style="font-size:13px; height:35px" name="kode_gudang" id="kode_gudang" class="form-control chosen" required="" >
          <?php 
          
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT kode_gudang,nama_gudang FROM gudang");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {

            if ($data['default_set'] == '1') {

                echo "<option selected value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";
              
            }

            else{

                echo "<option value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";

            }
          
          }
          
          
          ?>
      </select>
</div>

<div class="col-sm-2">
    <label class="gg" >Sales</label>
        <select style="font-size:13px; height:35px" name="sales" id="sales" class="form-control chosen" required="">

  <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT id,nama FROM user WHERE status_sales = 'Iya'");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {
    
 

    echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";

    }
    
    
    ?>
    </select>
</div>

<div class="col-sm-2">
    <label> Level Harga </label><br>
        <select style="font-size:13px; height:35px" type="text" name="level_harga" id="level_harga" class="form-control" required="" >
        <option value="harga_1">Level 1</option>
        <option value="harga_2">Level 2</option>
        <option value="harga_3">Level 3</option>
        <option value="harga_4">Level 4</option>
        <option value="harga_5">Level 5</option>
        <option value="harga_6">Level 6</option>
        <option value="harga_7">Level 7</option>
    </select>
</div>




<div class="col-sm-2">
    <label class="gg">PPN</label>
      <select type="hidden" style="font-size:13px; height:35px" name="ppn" id="ppn" class="form-control cho">
          <option >Include</option>  
          <option >Exclude</option>
          <option >Non</option>          
    </select>
</div>

    </div>  <!-- END ROW dari kode pelanggan - ppn -->
</form><!--tag penutup form-->
  

  <form class="form-inline" method="post ">

<button type="button" id="cari_produk_penjualan" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class='fa  fa-search'></i> Cari (F1)  </button> 
<button type="button" id="daftar_parcel" class="btn btn-primary" data-toggle="modal" data-target="#modal_parcel"><i class='fa  fa-search'></i> Cari Parcel (alt+p) </button>
<button type="button" id="daftar_order" class="btn btn-success" data-toggle="modal" data-target="#modal_order"><i class='fa  fa-search'></i> Cari Order (F6) </button>

<?php 
$hud = $db->query("SELECT setting_tampil FROM setting_antrian");
$my = mysqli_fetch_array($hud);

if ($my['setting_tampil'] == 'Tampil')
{
?>



<button class="btn btn-purple" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class='fa fa-list-ol'> </i>
Antrian  </button>




<button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#sss" aria-expanded="false" aria-controls="collapseExample"><i class='fa fa-list-ol'> </i>
Order </button>

</p>  
</form>

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

<div class="collapse" id="collapseExample">
 <table id="tableuser" class="table-border table-sm">
   <thead>
  <th style='background-color: #4CAF50; color:white'>No Faktur </th>   
  <th style='background-color: #4CAF50; color:white'>Kode Pelanggan</th>   
  <th style='background-color: #4CAF50; color:white'>Nama Pelanggan</th>
  <th style='background-color: #4CAF50; color:white'>Subtotal</th>
  <th style='background-color: #4CAF50; color:white' > Bayar</th>
   </thead>
<tbody>

  <?php
                
                //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT p.id,p.no_faktur,p.total,p.kode_pelanggan,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,g.nama_gudang,p.kode_gudang,pl.nama_pelanggan FROM penjualan p INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan WHERE p.status = 'Simpan Sementara' ORDER BY p.id DESC ");
                
                //menyimpan data sementara yang ada pada $perintah
                
                while ($data1 = mysqli_fetch_array($perintah))
                {
                //menampilkan data
                echo "<tr>
                <td style='font-size:15px'>". $data1['no_faktur'] ."</td>
                <td style='font-size:15px'>". $data1['kode_pelanggan'] ."</td>
                <td style='font-size:15px;'>". $data1['nama_pelanggan'] ."</td>
                <td style='font-size:15px'>". $data1['total'] ."</td>
                <td style='font-size:15px'>
                <a href='proses_pesanan_barang.php?no_faktur=".$data1['no_faktur']."&kode_pelanggan=".$data1['kode_pelanggan']."&nama_pelanggan=".$data1['nama_pelanggan']."&nama_gudang=".$data1['nama_gudang']."&kode_gudang=".$data1['kode_gudang']."' class='btn btn-warning' > Rp</a> 
                 </td>
                </tr>";
                }

                ?>


</tbody>
 </table>
</div>
<?php
}
?> 


<!--MODAL OPEN CASH DRAWER -->
<div class="modal fade modal-ext" id="modal_cash_drawer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="w-100"><i class="fa fa-user"></i> LOGIN PAGE</h3>
            </div>
            <!--Body-->
            <div class="modal-body">

            <form role="form" action="proses_open_cash_drawer.php.php" method="post" >
                <div class="md-form">
                    <i class="fa fa-envelope prefix"></i>
                    <input type="text" id="username" name="username" class="form-control">
                    <label for="username">USERNAME</label>
                </div>

                <div class="md-form">
                    <i class="fa fa-lock prefix"></i>
                    <input type="password" id="password" name="password" class="form-control">
                    <label for="password">PASSWORD</label>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary btn-sm" id="btnLogin">Login</button>
                </div>

              </form>      

                <div class="alert-gagal alert-danger" style="display:none">
                  <strong>PERHATIAN!</strong> Username Atau Password Yang Anda Masukan Salah !!
                </div>

            </div>

            <div class="options text-right">
              <p style="color: red; padding-left: 20px"> <i>**Masukan Username dan Password Untuk Membuka Cash Drawer !</i> </p>
            </div>
            <!--Footer-->
            <div class="modal-footer">                
                <button type="button" class="btn btn-warning btn-sm ml-auto" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div> <!-- / MODAL OPEN CASH DRAWER -->


<!--tampilan modal-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- isi modal-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><h3><b>Data Barang</b></h3></center></h4>
      </div>
      <div class="modal-body">
            <div class="table-responsive">
              <table id="tabel_cari" class="table table-bordered table-sm">
                   <thead> <!-- untuk memberikan nama pada kolom tabel -->
                        <th> Kode Barang </th>
                        <th> Nama Barang </th>
                        <th> Harga Jual Level 1</th>
                        <th> Harga Jual Level 2</th>
                        <th> Harga Jual Level 3</th>
                        <th> Harga Jual Level 4 </th>
                        <th> Harga Jual Level 5</th>
                        <th> Harga Jual Level 6</th>
                        <th> Harga Jual Level 7</th>
                        <th> Jumlah Barang </th>
                        <th> Satuan </th>
                        <th> Kategori </th>
                        <th> Suplier </th>
                  </thead> <!-- tag penutup tabel -->
               </table>
            </div>
        <div class="table-resposive">
      <span class="modal_baru"></span>
      </div>
</div> <!-- tag penutup modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
  </div>
  </div>
</div><!-- end of modal data barang  -->


<!--tampilan modal-->
<div id="modal_order" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- isi modal-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Order</h4>
      </div>
      <div class="modal-body">
      <div class="table-resposive">
            <table id="table_order" class="table table-bordered table-sm" align="center">
                <thead>
                <th> No Faktur Order  </th>
                <th >Kode Pelanggan</th>
                <th> Tanggal </th>
                <th> Jam </th>
                <th> Total </th>
                <th> Keterangan </th>
                <th> Petugas Kasir </th>             
                </thead>
        </table>
    </div>
  </div> <!-- tag penutup modal-body-->
      <div class="modal-footer">
        <button type="button" order="" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div><!-- end of modal data barang  -->



<!-- START MODAL PARCEL-->
<div id="modal_parcel" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- isi modal-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Produk Parcel</h4>
      </div>
      <div class="modal-body">
      <div class="table-responsive">
            <table id="table_parcel" align="center" class="table">
                <thead>
                        <th> Kode Parcel </th>
                        <th> Nama Parcel </th>
                        <th> Jumlah Parcel </th>
                        <th> Harga Level 1</th>
                        <th> Harga Level 2</th>
                        <th> Harga Level 3</th>
                        <th> Harga Level 4 </th>
                        <th> Harga Level 5</th>
                        <th> Harga Level 6</th>
                        <th> Harga Level 7</th>
                </thead>
        </table>
    </div>
  </div> <!-- tag penutup modal-body-->
      <div class="modal-footer">
        <button type="button" order="" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div><!-- END MODAL PARCEL  -->



<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Tbs Penjualan</h4>
      </div>
      <div class="modal-body">
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
     <input type="text" id="nama-barang" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" >
     <input type="hidden" id="kode_hapus" class="form-control" >
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span>Batal</button>
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
     <input type="hidden" class="form-control" id="potongan_edit" readonly="">
     <input type="hidden" class="form-control" id="tax_edit" readonly="">
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

<!-- membuat form prosestbspenjual -->

<form id="form_barcode" class="form-inline">
  <br>
    <div class="form-group">
        <input type="text" style="height:15px" name="kode_barcode" id="kode_barcode" class="form-control" autocomplete="off" placeholder="Scan / Ketik Barcode">
    </div>
        
    <button type="submit" id="submit_barcode" class="btn btn-primary" style="font-size:15px" ><i class="fa fa-barcode"></i> Submit Barcode</button>
        
    
        
  </form>

          <div class="alert alert-danger" id="alert_stok" style="display:none">
          <strong>Perhatian!</strong> Persediaan Barang Tidak Cukup!
          </div>

  
<form class="form"  role="form" id="formtambahproduk">

<div class="row">


  <div class="col-sm-3">
   <select style="font-size:15px; height:20px" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
    <option value="">SILAKAN PILIH...</option>
       <?php 

        include 'cache.class.php';
          $c = new Cache();
          $c->setCache('produk');
          $data_c = $c->retrieveAll();

          foreach ($data_c as $key) {
            echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" harga="'.$key['harga_jual'].'" harga_jual_2="'.$key['harga_jual2'].'" harga_jual_3="'.$key['harga_jual3'].'" harga_jual_4="'.$key['harga_jual4'].'" harga_jual_5="'.$key['harga_jual5'].'" harga_jual_6="'.$key['harga_jual6'].'" harga_jual_7="'.$key['harga_jual7'].'" satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'" tipe_barang="'.$key['tipe_barang'].'" id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
          }

          $cache_parcel = new Cache();
          $cache_parcel->setCache('produk_parcel');
          $data_parcel = $cache_parcel->retrieveAll();

          foreach ($data_parcel as $key_parcel) {
            echo '<option id="opt-produk-'.$key_parcel['kode_parcel'].'" value="'.$key_parcel['kode_parcel'].'" data-kode="'.$key_parcel['kode_parcel'].'" nama-barang="'.$key_parcel['nama_parcel'].'" harga="'.$key_parcel['harga_parcel'].'" harga_barang_2="'.$key_parcel['harga_parcel_2'].'" harga_barang_3="'.$key_parcel['harga_parcel_3'].'" harga_barang_4="'.$key_parcel['harga_parcel_4'].'" harga_barang_5="'.$key_parcel['harga_parcel_5'].'" harga_barang_6="'.$key_parcel['harga_parcel_6'].'" harga_barang_7="'.$key_parcel['harga_parcel_7'].'"  ber-stok="Barang" tipe_barang="Barang" id-barang="'.$key_parcel['id'].'" satuan="125"> '. $key_parcel['kode_parcel'].' ( '.$key_parcel['nama_parcel'].' ) </option>';
          }

        ?>
    </select>
  </div>


    <input type="hidden" class="form-control" name="nama_barang" id="nama_barang" autocomplete="off" placeholder="nama" >


  <div class="col-sm-2">
    <input style="height:13px;" type="text" class="form-control" name="jumlah_barang" autocomplete="off" id="jumlah_barang" placeholder="Jumlah" >
  </div>


  <div class="col-sm-2">   
        <select style="font-size:15px; height:35px" type="text" name="satuan_konversi" id="satuan_konversi" class="form-control"  required="">  
          <?php 
          
          
          $query = $db->query("SELECT id, nama  FROM satuan");
          while($data = mysqli_fetch_array($query))
          {          
            echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
          }
                      
          ?>
    </select>
  </div>


  <div class="col-sm-2">
    <input style="height:15px;" type="text" class="form-control" name="potongan" autocomplete="off" id="potongan1" data-toggle="tooltip" data-placement="top" title="Jika Ingin Potongan Dalam Bentuk Persen (%), input : 10%" placeholder="Potongan">
  </div>

  <div class="col-sm-1">
    <input style="height:15px;" type="text" class="form-control" name="tax" autocomplete="off" id="tax1" placeholder="Tax%" >
  </div>

<button type="submit" id="submit_produk" class="btn btn-success" style="font-size:15px" >Submit (F3)</button>

</div>

<!-- input untuk ngambil id program promo(memilih barang yang ada di program itu yang tampil-->
<input type="hidden" name="id_program" id="id_program">
<!--end input untuk ngambil id program promo(memilih barang yang ada di program itu yang tampil-->

<!--untuk melihat disc di tbs-->
<input type="hidden" class="form-control" name="disc_tbs" autocomplete="off" id="disc_tbs" placeholder="DISKON TBS" >
<input type="hidden" class="form-control" name="subtotal_jual_disc" autocomplete="off" id="subtotal_jual_disc" placeholder="subtotal disc Harga PROMO" >

<!--hidden data produk yang ingin ditambahkan ke tbs -->
<input type="hidden" class="form-control" name="limit_stok" autocomplete="off" id="limit_stok" placeholder="Limit Stok" >
    <input type="hidden" class="form-control" name="ber_stok" id="ber_stok" placeholder="Ber Stok" >
    <input type="hidden" class="form-control"  placeholder="Lama" name="harga_lama" id="harga_lama">
    <input type="hidden" class="form-control"  placeholder="Baru" name="harga_baru" id="harga_baru">
    <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">
    <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="" placeholder="satuan">
    <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" required="" placeholder="harga produk">
    <input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" required="" placeholder="id produk">        
<input type="hidden" id="total_barcode" name="total_barcode" class="form-control" value="" required=""> 
<!--end hidden data produk yang ingin ditambahkan ke tbs -->

</form> <!-- tag penutup form -->
               


<!--Table TBS PENJUALAN -->  
                <span id='tes'></span>            
                
                <div class="table-responsive"> <!--tag untuk membuat garis pada tabel-->  
                <span id="span_tbs">  
                <table id="tabel_tbs_penjualan" class="table table-sm">
                      <thead>
                          <th> Kode  </th>
                          <th style="width:1000%"> Nama </th>
                          <th> Jumlah </th>
                          <th> Satuan </th>
                          <th> Harga </th>
                          <th> Subtotal </th>
                          <th> Potongan </th>
                          <th> Pajak </th>
                          <th> Hapus </th>     
                    </thead>
                <tbody id="tbody">      
                </tbody>
              </table>
            </span>
                </div>
<!--end tABLE tbs Penjualan-->

                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>


<span id="tbs_bonus_penjualan" style="display: none;"><!--start table_tbs_bnus_penjualan-->
<h5><b>Produk Promo</b></h5>
  <div class="table-responsive"> <!--tag untuk membuat garis pada tabel--> 
                <table id="table_tbs_bonus_penjualan" class="table table-sm">
                <thead>
                <th> Kode  </th>
                <th> Nama </th>
                <th> Jumlah </th>
                <th> satuan </th>
                <th> Harga Promo </th>
                <th> Subtotal </th>
                <th> Keterangan </th>
                <th> Hapus </th>
                
                </thead>
                
                </table>
                </div>
</span><!--end span table tbs_bonus_Penjualan-->

<div class="collapse" id="sss">
    <div class="card card-block">

      <div class="row">
          <div class="col-sm-4">
      <span id="select_order">

<select style="font-size:15px; height:35px" name="hapus_order" id="hapus_order" class="form-control gg" required="" >
          <?php 
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT no_faktur_order FROM tbs_penjualan WHERE session_id = '$session_id' AND no_faktur_order != '' ");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
           echo "<option value='".$data['no_faktur_order'] ."'>".$data['no_faktur_order'] ."</option>";
          }
        ?>
  </select>
            <input type="hidden" class="form-control" name="total_perorder" id="total_perorder">
     </span>
</div>

<div class="col-sm-4"> 



     <button type="submit" id="btn-hps-order" class="btn btn-danger" style="font-size:15px" > Hapus </button>

   </div>      
</div>

  <h5><b>Data Order</b></h5> 
    <div class="table-responsive"> <!--tag untuk membuat garis pada tabel-->
            <table id="table_tbs_order" class="table table-sm" align="center">
                <thead>
                      <th style="width:500%"> No Faktur Order  </th>
                      <th> Kode  </th>
                      <th style="width:1000%"> Nama </th>
                      <th> Jumlah </th>
                      <th> Satuan </th>
                      <th> Harga </th>
                      <th> Subtotal </th>
                      <th> Potongan </th>
                      <th> Pajak </th>
                </thead>
            </table>
      </div>  
</div>
</div>


</div> <!-- / END COL SM 6 (1)-->


<div class="col-sm-4">

<form action="proses_bayar_jual.php" id="form_jual" method="POST" >
    
    <style type="text/css">
    .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: false;
    }
    </style>

  <div class="form-group">
    <div class="card card-block">
      

      <div class="row">
        <div class="col-sm-12">
          
           <label style="font-size:15px"> <b> Subtotal </b></label><br>
      <b><input style="height: 25px; width:90%; font-size:20px;" type="text" name="total" id="total2" class="form-control" placeholder="Total" readonly="" ></b>

        </div>

                  <?php
                  $ambil_diskon_tax = $db->query("SELECT diskon_nominal,diskon_persen,tax FROM setting_diskon_tax");
                  $data_diskon = mysqli_fetch_array($ambil_diskon_tax);

                  ?>

         <div class="col-sm-6">

            <select style="display:none;" class="form-control" id="biaya_admin_select" name="biaya_admin_select" >
              <option value="0" selected=""> Silahkan Pilih </option>
                <?php 
                $get_biaya_admin = $db->query("SELECT prosentase,nama FROM biaya_admin");
                while ( $take_admin = mysqli_fetch_array($get_biaya_admin))
                {
                echo "<option value='".$take_admin['persentase']."'>".$take_admin['nama']." ".$take_admin['persentase']."%</option>";
                }
                ?>
          </select>
            
          </div>


      </div>
      
     <div class="row">

           <div class="col-xs-6">          
              <input type="hidden" name="biaya_admin_rupiah" style="height:15px;font-size:15px" id="biaya_adm" class="form-control" placeholder="Biaya Admin Rp" autocomplete="off" >
           </div>

           <div class="col-xs-6">
              <input type="hidden" name="biaya_admin_persen" style="height:15px;font-size:15px" id="biaya_admin_persen" class="form-control" placeholder="Biaya Admin %" autocomplete="off" >
           </div>

      </div> 
          
          <div class="row">

          <div class="col-sm-6">
            <label> Diskon ( Rp )</label><br>
            <input type="text" name="potongan" style="height:15px;font-size:15px" id="potongan_penjualan" value="<?php echo $data_diskon['diskon_nominal']; ?>" class="form-control" placeholder="" autocomplete="off"  >

          </div>

            <div class="col-sm-6">

        <label> Diskon ( % )</label><br>
          <input type="text" name="potongan_persen" style="height:15px;font-size:15px" id="potongan_persen" value="<?php echo $data_diskon['diskon_persen']; ?>" class="form-control" placeholder="" autocomplete="off" >

          <!-- Hidden untuk inputan pajak di form bayar-->
           <input type="text" style="display: none" name="tax" id="tax" value="<?php echo $data_diskon['tax']; ?>" style="height:15px;font-size:15px" class="form-control" autocomplete="off" >

           </div>

          </div>
          

          <div class="row">

           <input type="hidden" name="tax_rp" id="tax_rp" class="form-control"  autocomplete="off" >
           
           <label style="display: none"> Adm Bank  (%)</label>
           <input type="hidden" name="adm_bank" id="adm_bank"  value="" class="form-control" >
           
           <div class="col-sm-6">
             
           <label> Tanggal</label>
           <input type="text" name="tanggal_jt" id="tanggal_jt"  value="" style="height:15px;font-size:15px" placeholder="Tanggal JT" autocomplete="off" class="form-control" >

           </div>


        <div class="col-sm-6">
            <label style="font-size:15px"> <b> Cara Bayar (F4) </b> </label><br>
                  <select type="text" name="cara_bayar" id="carabayar1" class="form-control" required=""  style="font-size: 15px" >
                     <option value=""> Silahkan Pilih </option>
                         <?php 

                         $sett_akun = $db->query("SELECT sa.kas,da.nama_daftar_akun FROM setting_akun sa INNER JOIN daftar_akun da ON sa.kas = da.kode_daftar_akun");
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

    
           
           
      <div class="form-group">
<div class="row">
       
   <div class="col-sm-6">
         <label style="font-size:15px"> <b> Total Akhir </b></label><br>
    <b><input type="text" name="total" id="total1" class="form-control" style="height: 25px; width:90%; font-size:20px;" placeholder="Total" readonly="" ></b>   </div>
 
    <div class="col-sm-6">  
           <label style="font-size:15px">  <b> Pembayaran (F7)</b> </label><br>
           <b><input type="text" name="pembayaran" id="pembayaran_penjualan" autocomplete="off" class="form-control"   style="height: 25px; width:90%; font-size:20px;"  ></b>
       </div>
 </div>
           
           
<div class="row">
    <div class="col-sm-6">   
        <label> Kembalian </label><br>
           <b><input type="text" name="sisa_pembayaran"  id="sisa_pembayaran_penjualan"  style="height:10px;font-size:15px" class="form-control"  readonly="" required=""></b>
    </div>

    <div class="col-sm-6">    
        <label> Kredit </label><br>
          <b><input type="text" name="kredit" id="kredit" class="form-control"  style="height:10px;font-size:15px"  readonly="" required="" ></b>
    </div>
</div> 
          


      <label> Keterangan </label><br>
           <textarea style="height:40px;font-size:15px" type="text" name="keterangan" id="keterangan" class="form-control"> 
           </textarea>
 
          <?php 
          
          if ($_SESSION['otoritas'] == 'Pimpinan') {
          echo '<label style="display:none"> Total Hpp </label><br>
          <input type="hidden" name="total_hpp" id="total_hpp" style="height: 50px; width:90%; font-size:25px;" class="form-control" placeholder="" readonly="" required="">';
          }
          
          
          //Untuk Memutuskan Koneksi Ke Database
          mysqli_close($db);   
          ?>
      </div><!-- END card-block -->
 </div>

          
          
          <input style="height:15px" type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah"> 
          <!-- memasukan teks pada kolom kode pelanggan, dan nomor faktur penjualan namun disembunyikan -->
         <input type="hidden" name="tipe_produk" id="tipe_produk" class="form-control" required="" >   
          <input type="hidden" name="kode_pelanggan" id="k_pelanggan" class="form-control" required="" >
          <input type="hidden" name="ppn_input" id="ppn_input" value="Include" class="form-control" placeholder="ppn input">  
   <div class="row">    
          <button type="submit" id="penjualan" class="btn btn-info" style="font-size:15px">Bayar (F8)</button>
          <button type="submit" id="transaksi_baru" style="display: none" class="btn btn-info" style="font-size:15px;"> Transaksi Baru (Ctrl + M)</button>
          <a class="btn btn-info" href="formpenjualan.php" id="transaksi_baru" style="display: none">  Transaksi Baru </a>
          <button type="submit" id="piutang" class="btn btn-warning" style="font-size:15px">Piutang (F9)</button>
          <a href='cetak_penjualan_piutang.php' id="cetak_piutang" style="display: none;" class="btn btn-success" target="blank">Cetak Piutang  </a> 
          <button type="submit" id="simpan_sementara" class="btn btn-primary" style="font-size:15px">  Simpan (F10)</button>
          <a href='cetak_penjualan_tunai.php' id="cetak_tunai" style="display: none;" class="btn btn-primary" target="blank"> Cetak Tunai  </a>

          <button type="submit" id="cetak_langsung" target="blank" class="btn btn-success" style="font-size:15px"> Bayar / Cetak (Ctrl + K) </button>

      <?php if ($otoritas_tombol['tombol_cash_drawer'] == 1): ?>
        <button type="submit" id="openCashDrawer" target="blank" class="btn btn-purple" style="font-size:15px"> Open Cash Drawer (Alt + O) </button>
      <?php endif ?>
          <a href='cetak_penjualan_tunai_besar.php' id="cetak_tunai_besar" style="display: none;" class="btn btn-warning" target="blank"> Cetak Tunai  Besar </a>
          <br>
  </div> <!--row 3-->
          
          <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Success!</strong> Pembayaran Berhasil
          </div>
     

    </form>


  </div><!-- / END COL SM 6 (2)-->
  </div><!-- end of row -->
</div><!-- end of container -->



<script type="text/javascript">
//untuk jika ke table penjualan awal
 (function(seconds) {
    var refresh,       
        intvrefresh = function() {
            clearInterval(refresh);
            refresh = setTimeout(function() {
               location.href ="penjualan.php?status=semua";
            }, seconds * 1000);
        };

    $(document).on('keypress click', function() { intvrefresh() });
    intvrefresh();

}(300)); // define here seconds
</script>





<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

  $(document).on('click', '#daftar_order', function (e) {

            $('#table_order').DataTable().destroy();

          var dataTable = $('#table_order').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_daftar_order.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_order").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih_order");
              $(nRow).attr('data-order', aData[0]);
              $(nRow).attr('data-total', aData[4]);

          },
        });

        $("#form").submit(function(){
        return false;
        });
        
      });
    });
</script>
<!--/DATA TABLE MENGGUNAKAN AJAX-->


<!--DATA TABLE PRODUK PARCEL MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
  $(document).ready(function() {
    $(document).on('click', '#daftar_parcel', function (e) {
        $('#table_parcel').DataTable().destroy();

          var dataTable = $('#table_parcel').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_daftar_parcel.php", // json datasource           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_parcel").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih-parcel");
              $(nRow).attr('data-kode', aData[0]);
              $(nRow).attr('data-nama', aData[1]);
              $(nRow).attr('data-stok', aData[2]);
              $(nRow).attr('data-harga1', aData[3]);
              $(nRow).attr('data-harga2', aData[4]);
              $(nRow).attr('data-harga3', aData[5]);
              $(nRow).attr('data-harga4', aData[6]);
              $(nRow).attr('data-harga5', aData[7]);
              $(nRow).attr('data-harga6', aData[8]);
              $(nRow).attr('data-harga7', aData[9]);
              $(nRow).attr('data-faktur', aData[10]);
              $(nRow).attr('data-id', aData[11]);

          },
        });

      $("#form").submit(function(){
        return false;
      });
        
    });
  });
</script>
<!--/DATA TABLE PRODUK PARCEL MENGGUNAKAN AJAX-->


<!--MULAI PUNYYA PROMO PENJUALAN-->
<script type="text/javascript">
//AMBIL DAN INPUT KE FORM produk bonus
$(document).ready(function(){
$(document).on('click', '.pilih_bonus', function (e) {
  var kode_barang = $(this).attr('data-kobon');
  var nama_bonus = $(this).attr('data-nabon');
  var jumlah = $(this).attr('data-qty');
  var satuan = $(this).attr('data-satuan');
  var harga_disc = $(this).attr('data-harga');

        $.post("ambil_bonus_free.php",{kode_barang:kode_barang,nama_bonus:nama_bonus,jumlah:jumlah,satuan:satuan,harga_disc:harga_disc},function(data){
          if (data == 1) {
              alert("Maaf Stok Produk Tidak Mencukupi atau Produk Telah Habis. Silakan Pilih Produk Yang Lain. ");
            }
            else{

                $("#modal_bonus_nya").modal('hide');
                $("#tbs_bonus_penjualan").show();

                $('#table_tbs_bonus_penjualan').DataTable().destroy();
                    var dataTable = $('#table_tbs_bonus_penjualan').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "info":     false,
                    "language": { "emptyTable":     "My Custom Message On Empty Table" },
                    "ajax":{
                      url :"datatable_tbs_bonus_penjualan.php", // json datasource
                     
                          type: "post",  // method  , by default get
                      error: function(){  // error handling
                        $(".tbody").html("");
                        $("#table_tbs_bonus_penjualan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                        $("#tableuser_processing").css("display","none");
                        
                      }
                    }   

              });// end ajax bonus
          }
        }); //end ambil_bonus_free
});
});
</script>

<script type="text/javascript">
//AMBIL DAN INPUT KE FORM produk bonus disc
$(document).on('click', '.pilih_bonus_disc', function (e) {
  var kode_barang = $(this).attr('data-kobon');
  var nama_bonus = $(this).attr('data-nabon');
  var satuan = $(this).attr('data-satuan');
  var harga = $(this).attr('data-harga');
  var harga_normal = $(this).attr('data-harga-normal');
  var jumlah = $(this).attr('data-qty-max');;
  var potongan = parseFloat(harga_normal) - parseFloat(harga);
  var  subtotal_disc = parseFloat(jumlah) * parseFloat(potongan);

        $.post("ambil_bonus_disc.php",{kode_barang:kode_barang,nama_bonus:nama_bonus,jumlah:jumlah,harga:harga,satuan:satuan},function(data){

            if (data == 1) {
              alert("Maaf Stok Produk Tidak Mencukupi atau Produk Telah Habis. Silakan Pilih Produk Yang Lain. ");
            }
            else{
                    $("#modal_bonus_disc_nya").modal('hide');
                    $("#tbs_bonus_penjualan").show();

                    //$("#modal_pembonusan_nya").modal('show');
                  $("#potongannyabro").text(subtotal_disc);

                    $('#table_tbs_bonus_penjualan').DataTable().destroy();
                        var dataTable = $('#table_tbs_bonus_penjualan').DataTable( {
                        "processing": true,
                        "serverSide": true,
                        "info":     false,
                        "language": { "emptyTable":     "My Custom Message On Empty Table" },
                        "ajax":{
                          url :"datatable_tbs_bonus_penjualan.php", // json datasource
                         
                              type: "post",  // method  , by default get
                          error: function(){  // error handling
                            $(".tbody").html("");
                            $("#table_tbs_bonus_penjualan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                            $("#tableuser_processing").css("display","none");
                            
                          }
                        }  

                  });// end ajax bonus disc

                        //cek total keseluruhan tbs penjualan
                        $.getJSON("cek_total_seluruh.php",function(data){
                              //cek total keseluruhan bonus disc
                            var total_penj = data.total_penjualan;
                            $.getJSON("cek_total_bonus_promo.php",function(tot){
                            
                            var keterangan = tot.keterangan;
                            if (keterangan == 'Disc Produk') {
                                var qty = tot.qty_disc;
                                if (qty == '') {
                                  qty = 0;
                                }
                                var harga_disc = tot.harga_disc;
                                if(harga_disc == ''){
                                  harga_disc = 0;
                                }
                                var subtotal_bonus = qty * harga_disc;
                            }
                            else{
                                var qty = tot.qty_free;
                                if (qty == '') {
                                  qty = 0;
                                }
                                var subtotal_bonus = 0;
                            }

                            
                            var subtotal_tampil = parseFloat(total_penj) + parseFloat(subtotal_bonus);
                            //jika tbs ada maka
                            if (data != 0) {
                              $("#total2").val(subtotal_tampil.format(2, 3, '.', ','));
                            $("#total1").val(subtotal_tampil.format(2, 3, '.', ','));
                            }
                            else{
                              $("#total2").val('0');
                            $("#total1").val('0');
                            }
                            //jika tbs bonus ada maka 
                            if (tot == 0) {
                              $("#tbs_bonus_penjualan").hide();
                            }
                            else{
                              $("#tbs_bonus_penjualan").show();
                            }
                            // end if (tot == 0)
                          }); // end cek_total_bonus_promo
                        }); // end cek_total_seluruh
                     } 
                }); // end ambil_bonus_disc

   }); // end .pilih_bonus_disc
  </script>

<script type="text/javascript">
  $(document).ready(function(){
    //cek sama tidaknya barang di tbs penjualan dg di tbs bonus
$.getJSON("cek_tbs_penjualan_dan_tbs_bonus.php",function(yae){
      var keterangan = yae.keterangan;
      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2")))));
      var harga_disc = yae.harga_disc;
      if (harga_disc == '') {
        harga_disc = 0;
      }
      var qty = yae.qty_bonus;
      if (qty == '') {
        qty = 0;
      }
      var harga_normal = yae.harga_jual;
      if (harga_normal == '') {
        harga_normal = 0;
      }
      var potongan = harga_normal - harga_disc;
      var subtotal_disc = qty * potongan;
      var subtotal_jual = qty * harga_disc;
      var subtotal_penjualan = subtotal_jual + total; 
      

      if (keterangan == 'Disc Produk') {
      $("#subtotal_jual_disc").val(subtotal_jual);
      //$("#modal_pembonusan_nya").modal('show');
      $("#potongannyabro").text(subtotal_disc);
      $("#total2").val(subtotal_penjualan);
      $("#tbs_bonus_penjualan").show();
      }
      else{
      $("#subtotal_jual_disc").val('0');
      $("#tbs_bonus_penjualan").show();
      }
      
      
});
});
</script>

<script type="text/javascript">
  $(document).ready(function(){
    // show ajax tbs bonus
   $('#table_tbs_bonus_penjualan').DataTable().destroy();
            var dataTable = $('#table_tbs_bonus_penjualan').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"datatable_tbs_bonus_penjualan.php", // json datasource
             
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#table_tbs_bonus_penjualan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
//end show ajax tbs
  });
</script>

<script type="text/javascript">
//edit tbs bonus penjualan                          
    $(document).on('dblclick','.edit-qty-bonus',function(e){

   var id = $(this).attr("data-id");

  $("#text-qty-"+id+"").hide();

  $("#input-qty-"+id+"").attr("type", "text");
});


  $(document).on('blur','.input_qty_bonus',function(e){

      var idnya = $(this).attr("data-id");
      var jumlah_baru = $(this).val();
      var jumlah_lama = $("#text-qty-"+idnya+"").text();
      var kodenya = $(this).attr("data-kode");
      var kode_barang = $(this).attr("data-kode");
      var harga = $(this).attr("data-harga");

              
    $.getJSON("cek_jumlah_maks_produk_promo.php",{kode_barang:kode_barang},function(oke){
     //   
        var qty_max = oke.qty_max;
        if (jumlah_baru > qty_max) {
          alert("Jumlah yang anda masukkan melebihi batas jumlah maksimal.");
          $("#input-qty-"+idnya+"").val(jumlah_lama);
          $("#text-qty-"+idnya+"").text(jumlah_lama);
          $("#text-qty-"+idnya+"").show();
          $("#input-qty-"+idnya+"").attr("type", "hidden");
        }
        else{
          var jumlah = jumlah_baru;

          var subtotal_jual = jumlah * harga;
              $("#text-qty-"+idnya+"").show();
                    $("#text-qty-"+idnya+"").text(jumlah_baru);
                    $("#input-qty-"+idnya+"").attr("type", "hidden")

                  $.post("update_qty_tbs_bonus_penjualan.php",{idnya:idnya, kodenya:kodenya, jumlah:jumlah},function(info){

                    $("#subtotal_jual_disc").val(subtotal_jual);

                    $('#table_tbs_bonus_penjualan').DataTable().destroy();
                  var dataTable = $('#table_tbs_bonus_penjualan').DataTable( {
                  "processing": true,
                  "serverSide": true,
                  "info":     false,
                  "language": { "emptyTable":     "My Custom Message On Empty Table" },
                  "ajax":{
                    url :"datatable_tbs_bonus_penjualan.php", // json datasource
                   
                        type: "post",  // method  , by default get
                    error: function(){  // error handling
                      $(".tbody").html("");
                      $("#table_tbs_bonus_penjualan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                      $("#tableuser_processing").css("display","none");
                      
                    }
                  }   

                });// end ajax bonus

                    //cek total keseluruhan tbs penjualan
                    $.getJSON("cek_total_seluruh.php",function(data){
                          //cek total keseluruhan bonus disc
                        var total_penj = data.total_penjualan;
                        $.getJSON("cek_total_bonus_promo.php",function(tot){
                        
                        var keterangan = tot.keterangan;
                        if (keterangan == 'Disc Produk') {
                            var qty = tot.qty_disc;
                            if (qty == '') {
                              qty = 0;
                            }
                            var harga_disc = tot.harga_disc;
                            if(harga_disc == ''){
                              harga_disc = 0;
                            }
                            var subtotal_bonus = qty * harga_disc;
                        }
                        else{
                            var qty = tot.qty_free;
                            if (qty == '') {
                              qty = 0;
                            }
                            var subtotal_bonus = 0;
                        }

                        
                        var subtotal_tampil = parseFloat(total_penj) + parseFloat(subtotal_bonus);
                        //jika tbs ada maka
                        if (data != 0) {
                          $("#total2").val(subtotal_tampil.format(2, 3, '.', ','));
                        $("#total1").val(subtotal_tampil.format(2, 3, '.', ','));
                        }
                        else{
                          $("#total2").val('0');
                        $("#total1").val('0');
                        }
                        //jika tbs bonus ada maka 
                        if (tot == 0) {
                          $("#tbs_bonus_penjualan").hide();
                        }
                        else{
                          $("#tbs_bonus_penjualan").show();
                        }
                        // end if (tot == 0)
                      }); // end cek_total_bonus_promo
                    }); // end cek_total_seluruh
                });// end update_qty_tbs_bonus_penjualan 
        }

              
      });

              
   });
</script>

<script type="text/javascript">
$(document).ready(function(){
//fungsi hapus data TBS BONUS PENJUALAN
$(document).on('click','.btn-hapus-tbsbonus',function(e){

    
      var idnya = $(this).attr("data-id");
      var kodenya = $(this).attr("data-kode-produk");
      var nama_barang = $(this).attr("data-produk");
      var qty = $(this).attr("data-qty");
      var total_disc_promo = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal_jual_disc").val()))));
      var subtotal_tbs = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
      var total_akhir = parseFloat(subtotal_tbs - total_disc_promo);

// start hapus ajax TBS PENJUALAN
var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus "+nama_barang+""+ "?");
if (pesan_alert == true) {

        $.post("hapus_tbs_bonus_penjualan.php",{idnya:idnya,kodenya:kodenya},function(data){
          
          $('#table_tbs_bonus_penjualan').DataTable().destroy();

                        var dataTable = $('#table_tbs_bonus_penjualan').DataTable( {
                          "processing": true,
                          "serverSide": true,
                          "ajax":{
                            url :"datatable_tbs_bonus_penjualan.php", // json datasource
                           
                             
                              type: "post",  // method  , by default get
                            error: function(){  // error handling
                              $(".employee-grid-error").html("");
                              $("#table_tbs_bonus_penjualan").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                              $("#employee-grid_processing").css("display","none");
                              }
                          },
                             "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                              $(nRow).attr('class','tr-id-'+aData[11]+'');         

                          }
                        });

            //cek total keseluruhan tbs penjualan
    $.getJSON("cek_total_seluruh.php",function(data){
          //cek total keseluruhan bonus disc
        var total_penj = data.total_penjualan;
        $.getJSON("cek_total_bonus_promo.php",function(tot){
        
        var keterangan = tot.keterangan;
        if (keterangan == 'Disc Produk') {
            var qty = tot.qty_disc;
            if (qty == '') {
              qty = 0;
            }
            var harga_disc = tot.harga_disc;
            if(harga_disc == ''){
              harga_disc = 0;
            }
            var subtotal_bonus = qty * harga_disc;
        }
        else{
            var qty = tot.qty_free;
            if (qty == '') {
              qty = 0;
            }
            var subtotal_bonus = 0;
        }

        
        var subtotal_tampil = parseFloat(total_penj) + parseFloat(subtotal_bonus);
        //jika tbs ada maka
        if (data != 0) {
          $("#total2").val(subtotal_tampil.format(2, 3, '.', ','));
        $("#total1").val(subtotal_tampil.format(2, 3, '.', ','));
        }
        else{
          $("#total2").val('0');
        $("#total1").val('0');
        }
        //jika tbs bonus ada maka 
        if (tot == 0) {
          $("#tbs_bonus_penjualan").hide();
        }
        else{
          $("#tbs_bonus_penjualan").show();
        }
        // end if (tot == 0)
      }); // end cek_total_bonus_promo
    }); // end cek_total_seluruh

        });
}
else {
    
    }
//end hapus ajax

});
                  $('form').submit(function(){
              
              return false;
              });


    });
  
//end fungsi hapus data
</script>
<!--AKHIR PUNYYA PROMO PENJUALAN-->

<script>
//untuk form awal langsung ke kode barang focus
$(document).ready(function(){
    $("#kode_barang").focus();

});

</script>


<!--Start Ajax Modal Cari-->
<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
        var dataTable = $('#tabel_cari').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_jual_baru.php", // json datasource
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
              $(nRow).attr('harga', aData[2]);
              $(nRow).attr('harga_level_2', aData[3]);
              $(nRow).attr('harga_level_3', aData[4]);
              $(nRow).attr('harga_level_4', aData[5]);
              $(nRow).attr('harga_level_5', aData[6]);
              $(nRow).attr('harga_level_6', aData[7]);
              $(nRow).attr('harga_level_7', aData[8]);
              $(nRow).attr('jumlah-barang', aData[9]);
              $(nRow).attr('satuan', aData[17]);
              $(nRow).attr('kategori', aData[11]);
              $(nRow).attr('status', aData[16]);
              $(nRow).attr('suplier', aData[12]);
              $(nRow).attr('limit_stok', aData[13]);
              $(nRow).attr('ber-stok', aData[14]);
              $(nRow).attr('tipe_barang', aData[15]);
              $(nRow).attr('id-barang', aData[18]);

          }

        });    
     
  });
 </script>
<!--Start Ajax Modal Cari-->


<!--START INPUT DARI MODAL CARI-->
<script type="text/javascript">
//AMBIL DAN INPUT KE FORM DARI CARI BARANG
$(document).on('click', '.pilih', function (e) {

  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  $("#kode_barang").trigger('chosen:updated');

  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("limit_stok").value = $(this).attr('limit_stok');
  document.getElementById("satuan_produk").value = $(this).attr('satuan');
  document.getElementById("ber_stok").value = $(this).attr('ber-stok');
  document.getElementById("harga_lama").value = $(this).attr('harga');
  document.getElementById("harga_baru").value = $(this).attr('harga');
  document.getElementById("satuan_konversi").value = $(this).attr('satuan');
  document.getElementById("id_produk").value = $(this).attr('id-barang');

  var kode_barang = $("#kode_barang").val();

 $.post('cek_kode_barang_tbs_penjualan.php',{kode_barang:kode_barang}, function(data){
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

    $("#kode_barang").val('');
    $("#kode_barang").trigger('chosen:updated');
    $("#kode_barang").trigger('chosen:open');
    $("#nama_barang").val('');
   }//penutup if

    });////penutup function(cek_kode_barang_tbs_penjualan)

var level_harga = $("#level_harga").val();

var harga_level_1 = $(this).attr('harga');
var harga_level_2 = $(this).attr('harga_level_2');  
var harga_level_3 = $(this).attr('harga_level_3');
var harga_level_4 = $(this).attr('harga_level_4');
var harga_level_5 = $(this).attr('harga_level_5');  
var harga_level_6 = $(this).attr('harga_level_6');
var harga_level_7 = $(this).attr('harga_level_7');

if (level_harga == "harga_1") {
  $("#harga_produk").val(harga_level_1);
  $("#harga_lama").val(harga_level_1);
  $("#harga_baru").val(harga_level_1);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_2") {
  $("#harga_produk").val(harga_level_2);
  $("#harga_baru").val(harga_level_2);
  $("#harga_lama").val(harga_level_2);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_3") {
  $("#harga_produk").val(harga_level_3);
  $("#harga_lama").val(harga_level_3);
  $("#harga_baru").val(harga_level_3);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_4") {
  $("#harga_produk").val(harga_level_4);
  $("#harga_lama").val(harga_level_4);
  $("#harga_baru").val(harga_level_4);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_5") {
  $("#harga_produk").val(harga_level_5);
  $("#harga_lama").val(harga_level_5);
  $("#harga_baru").val(harga_level_5);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_6") {
  $("#harga_produk").val(harga_level_6);
  $("#harga_lama").val(harga_level_6);
  $("#harga_baru").val(harga_level_6);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_7") {
  $("#harga_produk").val(harga_level_7);
  $("#harga_lama").val(harga_level_7);
  $("#harga_baru").val(harga_level_7);
  $('#kolom_cek_harga').val('1');
}
  document.getElementById("jumlahbarang").value = $(this).attr('jumlah-barang');


$.post("lihat_promo_alert.php",{id_barang:$(this).attr('id-barang')},function(data){

   
    if (data.promo == null)
    {

    }
    else{
      $("#modal_promo_alert").modal('show');
      $("#tampil_alert").html(data.promo);
    }

});


  $('#myModal').modal('hide'); 
  $("#jumlah_barang").focus();


});

</script>


<!--START INPUT DARI MODAL PARCEL-->
<script type="text/javascript">
//AMBIL DAN INPUT KE FORM DARI CARI PARCEL
$(document).on('click', '.pilih-parcel', function (e) {

  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  $("#kode_barang").trigger('chosen:updated');

  document.getElementById("nama_barang").value = $(this).attr('data-nama');
  document.getElementById("ber_stok").value = "Barang";
  document.getElementById("id_produk").value = $(this).attr('data-id');
  document.getElementById("satuan_konversi").value = "125"
  document.getElementById("satuan_produk").value = "125";

  var kode_barang = $("#kode_barang").val();

 $.post('cek_kode_barang_tbs_penjualan.php',{kode_barang:kode_barang}, function(data){
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

    $("#kode_barang").val('');
    $("#kode_barang").trigger('chosen:updated');
    $("#kode_barang").trigger('chosen:open');
    $("#nama_barang").val('');
   }//penutup if

    });////penutup function(cek_kode_barang_tbs_penjualan)

var level_harga = $("#level_harga").val();

var harga_level_1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr('data-harga1')))));
var harga_level_2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr('data-harga2')))));  
var harga_level_3 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr('data-harga3')))));
var harga_level_4 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr('data-harga4')))));
var harga_level_5 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr('data-harga5')))));  
var harga_level_6 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr('data-harga6')))));
var harga_level_7 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr('data-harga7')))));
console.log(harga_level_1);

if (level_harga == "harga_1") {
  $("#harga_produk").val(harga_level_1);
  $("#harga_lama").val(harga_level_1);
  $("#harga_baru").val(harga_level_1);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_2") {
  $("#harga_produk").val(harga_level_2);
  $("#harga_baru").val(harga_level_2);
  $("#harga_lama").val(harga_level_2);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_3") {
  $("#harga_produk").val(harga_level_3);
  $("#harga_lama").val(harga_level_3);
  $("#harga_baru").val(harga_level_3);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_4") {
  $("#harga_produk").val(harga_level_4);
  $("#harga_lama").val(harga_level_4);
  $("#harga_baru").val(harga_level_4);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_5") {
  $("#harga_produk").val(harga_level_5);
  $("#harga_lama").val(harga_level_5);
  $("#harga_baru").val(harga_level_5);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_6") {
  $("#harga_produk").val(harga_level_6);
  $("#harga_lama").val(harga_level_6);
  $("#harga_baru").val(harga_level_6);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_7") {
  $("#harga_produk").val(harga_level_7);
  $("#harga_lama").val(harga_level_7);
  $("#harga_baru").val(harga_level_7);
  $('#kolom_cek_harga').val('1');
}
document.getElementById("jumlahbarang").value = $(this).attr('data-stok');


  $('#modal_parcel').modal('hide'); 
  $("#jumlah_barang").focus();


});

</script>


<script type="text/javascript">
//HAPUS ORDER
$(document).ready(function(){

 var hapus_order = $("#hapus_order").val();

  $.post("cek_hapus_order.php",
        {hapus_order:hapus_order},function(data){

          $("#total_perorder").val(data);
        });

  //end cek level harga
  $("#hapus_order").change(function(){
  
  var hapus_order = $("#hapus_order").val();


  $.post("cek_hapus_order.php",
        {hapus_order:hapus_order},function(data){

          $("#total_perorder").val(data);
        });
  });
});
//end HAPUS ORDER
</script>



<script type="text/javascript">
$(document).ready(function(){
  //START KETIKA LEVEL HARGA DI UBAH / DI GANTI
  $("#level_harga").change(function(){
  
  var level_harga = $("#level_harga").val();
  var kode_barang = $("#kode_barang").val();
  var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
  var satuan_konversi = $("#satuan_konversi").val();
  var jumlah_barang = $("#jumlah_barang").val();
  var id_produk = $("#id_produk").val();

if (kode_barang != '')
{
  $.post("cek_level_harga_barang.php",
        {level_harga:level_harga, kode_barang:kode_barang,jumlah_barang:jumlah_barang,id_produk:id_produk,satuan_konversi:satuan_konversi},function(data){

          $("#harga_produk").val(data);
          $("#harga_baru").val(data);
        });
}


    });
});
//end CHANGE LEVEL HARGA
</script>



<!-- START cek stok satuan konversi change-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#satuan_konversi").change(function(){
      var jumlah_barang = $("#jumlah_barang").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
      var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
      var id_produk = $("#id_produk").val();
      var prev = $("#satuan_produk").val();
      


      $.post("cek_stok_konversi_penjualan.php", {jumlah_barang:jumlah_barang,satuan_konversi:satuan_konversi,kode_barang:kode_barang,id_produk:id_produk},function(data){

      

          if (data < 0) {
            alert("Jumlah Melebihi Stok");
            $("#jumlah_barang").val('');
          $("#satuan_konversi").val(prev);

          }

      });
    });
  });
</script>
<!-- end cek stok satuan konversi change-->

<!-- cek JUMLAH BARANG keyup-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#jumlah_barang").keyup(function(){
      var jumlah_barang = $("#jumlah_barang").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
      var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
      var id_produk = $("#id_produk").val();
      var prev = $("#satuan_produk").val();

      $.post("cek_stok_konversi_penjualan.php",
        {jumlah_barang:jumlah_barang,satuan_konversi:satuan_konversi,kode_barang:kode_barang,
        id_produk:id_produk},function(data){

          if (data < 0) {
            alert("Jumlah Melebihi Stok");
            $("#jumlah_barang").val('');
          $("#satuan_konversi").val(prev);

          }

      });
    });
  });
</script>
<!--END keyup JUMLAH BARANG-->



<script>
//START UNTUK SATUAN KONVERSI
$(document).ready(function(){
    $("#satuan_konversi").change(function(){

      var prev = $("#satuan_produk").val();
      var harga_lama = $("#harga_lama").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var id_produk = $("#id_produk").val();
      var harga_produk = $("#harga_lama").val();
      var jumlah_barang = $("#jumlah_barang").val();
      var kode_barang = $("#kode_barang").val();
      var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));

      
      $.getJSON("cek_konversi_penjualan.php",{kode_barang:kode_barang,satuan_konversi:satuan_konversi,id_produk:id_produk,harga_produk:harga_produk,jumlah_barang:jumlah_barang},function(info){

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

      });

        
    });

});
</script>




<script type="text/javascript">
  //SELECT CHOSSESN    
$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});    
</script>





 <script type="text/javascript">
   $(document).on('ready', function (e) {                
// START DATATABLE AJAX START TBS PENJUALAN
      $('#tabel_tbs_penjualan').DataTable().destroy();
      $('#table_tbs_order').DataTable().destroy();


            var dataTable = $('#tabel_tbs_penjualan').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"data_tbs_penjualan.php", // json datasource
             
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_penjualan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });

// ambil datatable order yang terbaru
            $('#table_tbs_order').DataTable().destroy();

          var dataTable = $('#table_tbs_order').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_tbs_order.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_tbs_order").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
        });
// ambil datatable order yang terbaru

        
        $("#span_tbs").show()
        $("#btnRujukLab").show()
        $('#pembayaran_penjualan').val('');
        $('#potongan_penjualan').val('');
        $('#potongan_persen').val('');

// END DATATABLE AJAX END DATATABLE AJAX TBS PENJUALAN
});
 </script>




<!--java scrip order all-->
<script type="text/javascript" language="javascript" >
  $(document).on('click', '#btn-hps-order', function (e) {

var no_faktur = $("#hapus_order").val();

$.post("hapus_order_tbs.php",{no_faktur:no_faktur},function(data){

     $("#order_data").html(data);

$.get("ambil_select_order.php",function(info){
  $("#select_order").html(info);
});
    
}); 



// ambil datatable yang terbaru
            $('#table_tbs_order').DataTable().destroy();
          var dataTable = $('#table_tbs_order').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_tbs_order.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_tbs_order").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },      
    });
// ambil datatable yang terbaru


 var total_perorder = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_perorder").val()))));
          if (total_perorder == '') 
          {
          total_perorder = 0;
          }
       
 var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
          if (subtotal == '') 
          {
          subtotal = 0;
          }

var total_akhir1 = parseFloat(subtotal.replace(",",".")) - parseFloat(total_perorder.replace(",","."));

/*var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
    if (biaya_adm == '' || biaya_adm == 0,00)
    {
      biaya_adm = 0;
    }*/

var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
   if (pot_fakt_per == "" || pot_fakt_per == 0,00) {
        pot_fakt_per = 0.00;
      }

var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
 if (pot_fakt_rp == "" || pot_fakt_rp == 0,00 ) {
        pot_fakt_rp = 0.00;
      }


var tax_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
    if (pot_fakt_per == 0) {
      var potongaaan = pot_fakt_rp;

      var pot_fakt_per = parseFloat(potongaaan) / parseFloat(total_akhir1) * 100;


if (pot_fakt_rp == 0.00 )
{
   var total_akhier = parseFloat(total_akhir1);
}
else
{
  var total_akhier = parseFloat(total_akhir1) /*+ parseFloat(biaya_adm.replace(',','.'))*/ - parseFloat(pot_fakt_rp.replace(',','.'));
}

//Hitung pajak
  if (tax_faktur != 0 ) 
        {
        var hasil_tax = parseFloat(total_akhier) * parseFloat(tax_faktur) / 100;

        }
  else
        {
        var hasil_tax = 0;
        }
//end hitung pajak

    var total_akhir = parseFloat(total_akhier) + parseFloat(Math.round(hasil_tax));


    }
    else if(pot_fakt_rp == 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = potongaaan;
       var   potongan_persen = potongan_persen.replace("%","");
     var potongaaan = parseFloat(total_akhir1) * parseFloat(potongan_persen.replace(',','.')) / 100;

  if ( pot_fakt_rp == 0.00 )
{   
    var total_akhier = parseFloat(total_akhir1);
}
else
{
   var total_akhier = parseFloat(total_akhir1) /*+ parseFloat(biaya_adm.replace(',','.'))*/ - parseFloat(potongaaan);
}

//Hitung pajak
        if (tax_faktur != 0) {
        var hasil_tax = parseFloat(total_akhier) * parseFloat(tax_faktur) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }
//end hitung pajak

   var total_akhir = parseFloat(total_akhier) /*+ parseFloat(Math.round(hasil_tax))*/;

    }
     else if(pot_fakt_rp != 0 && pot_fakt_per != 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = potongaaan;
       var   potongan_persen = potongan_persen.replace("%","");
     var potongaaan = parseFloat(total_akhir1) * parseFloat(potongan_persen.replace(",",".")) / 100;

  if ( pot_fakt_rp == 0.00 )
{   
    var total_akhier = parseFloat(total_akhir1);
}
else
{
    var total_akhier = parseFloat(total_akhir1) /*+ parseFloat(biaya_adm.replace(",","."))*/ - parseFloat(potongaaan);
}


//Hitung pajak
   if (tax_faktur != 0) 
      {
        var hasil_tax = parseFloat(total_akhier) * parseFloat(tax_faktur) / 100;
      }
   else
      {
        var hasil_tax = 0;
      }
//end hitung pajak

    var total_akhir = parseFloat(total_akhier) + parseFloat(Math.round(hasil_tax));

    }

    /*var biaya_adm_tampil = parseFloat(biaya_adm.replace(',','.')) / parseFloat(total_akhir1) * 100;*/

      $("#total1").val(total_akhir.format(2, 3, '.', ','));
  if (pot_fakt_rp == 0.00)
      {
        $("#potongan_penjualan").val();
      }
      else
      {    
        $("#potongan_penjualan").val(potongaaan.format(2, 3, '.', ','));
      }

      $("#tax_rp").val(hasil_tax.format(2, 3, '.', ','));
      $("#total2").val(total_akhir1.format(2, 3, '.', ','));

    });
</script>




<script type="text/javascript">
//Untuk pilih order
  $(document).on('click', '.pilih_order', function (e) {


$.post("ambil_order_penjualan.php",{no_faktur_order:$(this).attr('data-order')},function(data){

      $("#modal_order").modal('hide');


// pengambilan select untuk no_faktur order
$.get("ambil_select_order.php",function(data){
  $("#select_order").html(data);
  });
// pengambilan select untuk no_faktur order


});//END AMBIL ORDER PENJUALAN 

/*var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
    if (biaya_adm == ''  || biaya_adm == 0,00 )
    {
      biaya_adm = 0;
    }*/

var total_perorder = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr('data-total')))));
    if (total_perorder == '' ) 
     {
       total_perorder = 0;
    }
      
 var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
    if (subtotal == '') 
     {
      subtotal = 0;
    }

var total_akhir1 = parseFloat(subtotal.replace(",",".")) + parseFloat(total_perorder);


    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
   if (pot_fakt_per == "" || pot_fakt_per == 0,00 ) 
      {
        pot_fakt_per = 0.00;
      }

    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
 if (pot_fakt_rp == ""  || pot_fakt_rp == 0,00 ) 
      {
        pot_fakt_rp = 0.00;
      }

   var tax_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));


    if (pot_fakt_per == 0) 
    {
      var potongaaan = pot_fakt_rp;
      var pot_fakt_per = parseFloat(potongaaan.replace(",",".")) / parseFloat(total_akhir1) * 100;


  if (pot_fakt_rp == 0.00 )
    {   
      var total_akhier = parseFloat(total_akhir1);
    }
else
    {
      var total_akhier = parseFloat(total_akhir1) /*+ parseFloat(biaya_adm.replace(",","."))*/ - parseFloat(pot_fakt_rp.replace(",","."));
    }

 //Hitung pajak
        if (tax_faktur != 0 ) {
        var hasil_tax = parseFloat(total_akhier) * parseFloat(tax_faktur) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }
 //end hitung pajak
    
    var total_akhir = parseFloat(total_akhier) + parseFloat(Math.round(hasil_tax));


  }//END pot_fakt_per == 0

else if(pot_fakt_rp == 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = potongaaan;
       var   potongan_persen = potongan_persen.replace("%","");
     var potongaaan = parseFloat(total_akhir1) * parseFloat(potongan_persen.replace(',','.')) / 100;

  if (pot_fakt_rp == 0.00 )
{  
    var total_akhier = parseFloat(total_akhir1);
}
else
{
     var total_akhier = parseFloat(total_akhir1) /*+ parseFloat(biaya_adm.replace(',','.'))*/ - parseFloat(potongaaan); 
}

//Hitung pajak
        if (tax_faktur != 0) {
        var hasil_tax = parseFloat(total_akhier) * parseFloat(tax_faktur) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }
//end hitung pajak
   
   var total_akhir = parseFloat(total_akhier) + parseFloat(Math.round(hasil_tax));

}//end pot_fakt_rp == 0

else if(pot_fakt_rp != 0 && pot_fakt_per != 0)
  {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = potongaaan;
      var   potongan_persen = potongan_persen.replace("%","");
      var potongaaan = parseFloat(total_akhir1) * parseFloat(potongan_persen.replace(',','.')) / 100;

 if ( pot_fakt_rp == 0.00 )
  {      
    var total_akhier = parseFloat(total_akhir1);
  }
else
  {
    var total_akhier = parseFloat(total_akhir1) /*+ parseFloat(biaya_adm.replace(',','.'))*/ - parseFloat(potongaaan); 
  }

//Hitung pajak
        if (tax_faktur != 0) 
        {
        var hasil_tax = parseFloat(total_akhier) * parseFloat(tax_faktur) / 100;
        }
        else
        {
        var hasil_tax = 0;
        }
//end hitung pajak
    var total_akhir = parseFloat(total_akhier) + parseFloat(Math.round(hasil_tax));


 }//pot_fakt_rp != 0 && pot_fakt_per != 0


// ganti / update data pembayaran 
    /*var biaya_adm_tampil = parseFloat(biaya_adm.replace(',','.')) / parseFloat(total_akhir1) * 100;*/

    $("#total1").val(total_akhir.format(2, 3, '.', ','));
  
  if (pot_fakt_rp == 0.00)
    {
      $("#potongan_penjualan").val();
    }
  else
    {    
      $("#potongan_penjualan").val(potongaaan.format(2, 3, '.', ','));
    }
      $("#tax_rp").val(hasil_tax.format(2, 3, '.', ','));
      $("#total2").val(total_akhir1.format(2, 3, '.', ','));

// ganti / update data pembayaran 
// ambil datatable yang terbaru
            $('#table_tbs_order').DataTable().destroy();
          var dataTable = $('#table_tbs_order').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_tbs_order.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_tbs_order").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },      
    });
// ambil datatable yang terbaru


});
</script>
<!--end javascript order all-->



<script>
//SCRIPT BARCODE INPUT
  $(document).on('click', '#submit_barcode', function (e) {

    var kode_barang = $("#kode_barcode").val();
    var level_harga = $("#level_harga").val();
    var sales = $("#sales").val();


/// JAVASCRIPT BARCODE
$.post("barcode.php",{kode_barang:kode_barang,sales:sales,level_harga:level_harga},function(data){
    if (data == 1)
  {
  alert("Stok Tidak Mencukupi ,Segera Lakukan Pembelian");
  }
  else if (data == 3){
  alert("Kode Barang Yang Anda Masukan Tidak Ada , Silakan Periksa Kembali ");
  $("#kode_barcode").focus();
  }

else
{


/// JAVASCRIPT MUNCULKAN ALERT PROMO (JIKA AADA PROMO DALAM BARANG ITU DARI INPUT BARCODE)
$.getJSON('lihat_nama_barang.php',{kode_barang:kode_barang}, function(json){
  console.log(json.id);

    $.post("lihat_promo_alert.php",{id_barang:json},function(data){

      if (data.promo == null)
      {

      }
      else{
        $("#modal_promo_alert").modal('show');
        $("#tampil_alert").html(data.promo);
      }
    });
});
///END  JAVASCRIPT ALERT PROMO


        $(".tr-kode-"+kode_barang+"").remove();
        $("#ppn").attr("disabled", true);
        $("#nama_barang").val('');
        $("#jumlah_barang").val('');
        $("#potongan1").val('');
        $("#kode_barcode").val('');

//perhitungan form pembayaran (total & subtotal / biaya admin) 

 /*var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
    if (biaya_adm == '')
    {
      biaya_adm = 0;
    }*/

var total_perorder = data;
    if (total_perorder == '') 
     {
       total_perorder = 0;
     }

 var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
    if (subtotal == '') 
     {
       subtotal = 0;
     }

var total_akhir1 = parseFloat(subtotal.replace(',','.')) + parseFloat(total_perorder);


  var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
   if (pot_fakt_per == "" || pot_fakt_per == 0,00 || pot_fakt_rp == 0  ) 
      {
        pot_fakt_per = 0.00;
      }

    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
  if (pot_fakt_rp == "" || pot_fakt_rp == 0,00 || pot_fakt_rp == 0 ) 
      {
        pot_fakt_rp = 0.00;
      }


   var tax_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));


    if (pot_fakt_per == 0) {
      var potongaaan = pot_fakt_rp;

      var pot_fakt_per = parseFloat(potongaaan) / parseFloat(total_akhir1) * 100;



// prhitungan total akhir
if (pot_fakt_rp == 0.00 )
  {      
    var total_akhier = parseFloat(total_akhir1);
  }
else
  {
    var total_akhier = parseFloat(total_akhir1) /*+ parseFloat(biaya_adm.replace(',','.'))*/ - parseFloat(pot_fakt_rp.replace(',','.'));
  }
// prhitungan total akhir


//Hitung pajak
if (tax_faktur != 0 ) 
      {
        var hasil_tax = parseFloat(total_akhier) * parseFloat(tax_faktur) / 100;
      }
 else
    {
        var hasil_tax = 0;
    }
//end hitung pajak
   
    var total_akhir = parseFloat(total_akhier) + parseFloat(Math.round(hasil_tax));


    }
    else if(pot_fakt_rp == 0.00)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = potongaaan;
       var   potongan_persen = potongan_persen.replace("%","");
     var potongaaan = parseFloat(total_akhir1) * parseFloat(potongan_persen.replace(',','.')) / 100;

// prhitungan total akhir
   if (pot_fakt_rp == 0 )
{ 
    var total_akhier = parseFloat(total_akhir1);
}
else
{
   var total_akhier = parseFloat(total_akhir1) /*+ parseFloat(biaya_adm.replace(',','.'))*/ - parseFloat(potongaaan);
}

//Hitung pajak
        if (tax_faktur != 0) {
        var hasil_tax = parseFloat(total_akhier) * parseFloat(tax_faktur) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }
//end hitung pajak
   var total_akhir = parseFloat(total_akhier) + parseFloat(Math.round(hasil_tax));

    }
     else if(pot_fakt_rp != 0.00 && pot_fakt_per != 0.00)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = potongaaan;
      var   potongan_persen = potongan_persen.replace("%","");
      var potongaaan = parseFloat(total_akhir1) * parseFloat(potongan_persen.replace(',','.')) / 100;

   if (pot_fakt_rp == 0 )
    {
      var total_akhier = parseFloat(total_akhir1);
    }
  else
    {
      var total_akhier = parseFloat(total_akhir1) /*+ parseFloat(biaya_adm.replace(',','.'))*/ - parseFloat(potongaaan);
    }

//Hitung pajak
    if (tax_faktur != 0) 
        {
          var hasil_tax = parseFloat(total_akhier) * parseFloat(tax_faktur) / 100;
        }
        else
        {
          var hasil_tax = 0;
        }
//end hitung pajak

    var total_akhir = parseFloat(total_akhier) + parseFloat(Math.round(hasil_tax));

    }


//perhitungan form pembayaran (total & subtotal) 
 /*var biaya_adm_tampil = parseFloat(biaya_adm) / parseFloat(total_akhir1) * 100;*/


// perhitungan rupiah total akhir
    $("#total1").val(total_akhir.format(2, 3, '.', ','));
    $("#total2").val(total_akhir1.format(2, 3, '.', ','));
// perhitungan rupiah total akhir
 if (pot_fakt_rp == 0.00)
      {
        $("#potongan_penjualan").val();
      }
      else
      {
        $("#potongan_penjualan").val(potongaaan.format(2, 3, '.', ','));
      }
      
      $("#tax_rp").val(hasil_tax.format(2, 3, '.', ','));
//perhitungan form pembayaran (total & subtotal / biaya admin) 



// datatable ajax pembaruan
    $('#tabel_tbs_penjualan').DataTable().destroy();
            var dataTable = $('#tabel_tbs_penjualan').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"data_tbs_penjualan.php", // json datasource
             
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_penjualan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
  
}// end else untuk stok tidak mencukupi

});
/// JAVASCRIPT BARCODE






$("#form_barcode").submit(function(){
    return false;
    
    });
});
 </script> 


    <script type="text/javascript">
    $(document).ready(function(){
      
//fungsi hapus data TBS PENJUALAN
$(document).on('click','.btn-hapus-tbs',function(e){

    
      var nama_barang = $(this).attr("data-barang");
      var id = $(this).attr("data-id");
      var kode_barang = $(this).attr("data-kode-barang");
      var subtotal = $(this).attr("data-subtotal");
          if (subtotal == '') {
      subtotal = 0;
    };


    var subtotal_tbs = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
    
  var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
   if (pot_fakt_per == "" || pot_fakt_per == 0,00 || pot_fakt_rp == 0  ) {
        pot_fakt_per = 0.00;
      }

    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
 if (pot_fakt_rp == "" || pot_fakt_rp == 0,00 || pot_fakt_rp == 0 ) {
        pot_fakt_rp = 0.00;
      }


 /*var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
    if (biaya_adm == '')
    {
      biaya_adm = 0;
    }*/

    var total_akhir1 = parseFloat(subtotal_tbs.replace(',','.')) - parseFloat(subtotal.replace(',','.'));

   if (pot_fakt_per == 0.00) {

      var potongaaan = pot_fakt_rp;

      var potongaaan_per = parseFloat(potongaaan,2) / parseFloat(total_akhir1,2) * 100;
      var potongaaan = pot_fakt_rp;
      var hitung_tax = parseFloat(total_akhir1,2) - parseFloat(pot_fakt_rp,2);

      /*var tax_bener = parseFloat(hitung_tax) * parseFloat(tax_faktur) / 100;*/

if ( pot_fakt_rp == 0.00 )
{
  var total_akhir = parseFloat(total_akhir1,2)/* + parseFloat(tax_bener)*/;
}
else
{
  var total_akhir = parseFloat(total_akhir1,2) /*+ parseFloat(biaya_adm.replace(',','.'),2)*/ - parseFloat(pot_fakt_rp.replace(',','.'),2)/* + parseFloat(tax_bener)*/;
}

    }
    else if(pot_fakt_rp == 0.00)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = potongaaan;
          potongan_persen = potongan_persen.replace("%","");

      potongaaan = parseFloat(total_akhir1,2) * parseFloat(potongan_persen.replace(',','.'),2) / 100;
      
      var potongaaan_per = pot_fakt_per;
      var hitung_tax = parseFloat(total_akhir1,2) - parseFloat(potongaaan,2);

      /*var tax_bener = parseFloat(hitung_tax) * parseFloat(tax_faktur) / 100;*/
if (pot_fakt_rp == 0.00 )
{
     var total_akhir = parseFloat(total_akhir1,2) /*+ parseFloat(Math.round(tax_bener))*/;
}
else
{
     var total_akhir = parseFloat(total_akhir1,2) /*+ parseFloat(biaya_adm.replace(',','.'),2)*/ - parseFloat(potongaaan,2) /*+ parseFloat(Math.round(tax_bener))*/;
}
    }
     else if(pot_fakt_rp != 0.00 && pot_fakt_rp != 0.00)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = potongaaan;
          potongan_persen = potongan_persen.replace("%","");
      potongaaan = parseFloat(total_akhir1,2) * parseFloat(potongan_persen.replace(',','.'),2) / 100;
      
      var potongaaan_per = pot_fakt_per;
      var hitung_tax = parseFloat(total_akhir1,2) - parseFloat(potongaaan,2);

      /*var tax_bener = parseFloat(hitung_tax) * parseFloat(tax_faktur) / 100;*/
if ( pot_fakt_rp == 0 )
{
  var total_akhir = parseFloat(total_akhir1,2) /*+ parseFloat(Math.round(tax_bener))*/;
}
else
{
  var total_akhir = parseFloat(total_akhir1,2) /*+ parseFloat(biaya_adm.replace(',','.'),2)*/ - parseFloat(potongaaan,2) /*+ parseFloat(Math.round(tax_bener))*/;
}
    
    }


// start hapus ajax TBS PENJUALAN
var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus "+nama_barang+""+ "?");
if (pesan_alert == true) {


        $("#total2").val(total_akhir1.format(2, 3, '.', ','));  
        $("#total1").val(total_akhir.format(2, 3, '.', ','));

      if ( pot_fakt_rp == 0.00)
      {
        $("#potongan_penjualan").val();
      }
      else
      {
        $("#potongan_penjualan").val(potongaaan.format(2, 3, '.', ','));
      }

        $("#pembayaran_penjualan").val('');
        $("#kredit").val('');
        $("#sisa_pembayaran_penjualan").val('');
        $.post("hapustbs_penjualan.php",{id:id,kode_barang:kode_barang},function(data){
          //cek tbsbonus yang ada, tapi jumlah subtotal tbspenjualan sudah berubah syarat tidak terpenuhi
          $.getJSON("cek_syarat_promo_ditbs.php",{kode_barang:kode_barang},function(syaratbonus){
            /*var nama_produk = syaratbonus.nama_produk;
            var kodenya = syaratbonus.kode_produk;
            var idnya = syaratbonus.id;

            var subtotal_tbspenjualan = parseFloat(syaratbonus.tanggal);
            var idtbsnya = syaratbonus.jam;
            var subtotal = parseFloat(syaratbonus.satuan);
            var syarat_free = parseFloat(syaratbonus.harga_disc);
            var syarat_disc = parseFloat(syaratbonus.kode_pelanggan);
            var keterangan = syaratbonus.keterangan;*/
            //if ((idtbsnya > 0 && subtotal_tbspenjualan > syarat_free  && keterangan != 'Free Produk'  || syaratbonus == 0) || (subtotal_tbspenjualan > syarat_disc && keterangan != 'Disc Produk' || syaratbonus == 0)) {}
          var subtotal_tbs_penjualan = syaratbonus.subtotal_tbs_penjualan
          var syarat_promo_disc_produk = syaratbonus.syarat_promo_disc_produk;
          var subtotal_tbs_penjualan_difree = syaratbonus.subtotal_tbs_penjualan_difree;
          var syarat_promo_free = syaratbonus.syarat_promo_free;
          var total_syarat_disc = syaratbonus.total_syarat_disc;
          var kodenya = syaratbonus.kode_produk;
          var idnya = syaratbonus.id;
          var nama_produk = syaratbonus.nama_produk;

          var total_syarat_free = subtotal_tbs_penjualan_difree - syarat_promo_free;
          var total_syarat_disc = subtotal_tbs_penjualan - syarat_promo_disc_produk;
          
          if ((total_syarat_free <= 0) || (total_syarat_disc <= 0)) {
          }
          else{
            $("#modal_hapus_bonus_ditbs").modal('show');
            $("#kode_produk_bonus").val(kodenya);
            $("#nama_produk_bonus").val(nama_produk);
            
            $("#hapus_bonus_ditbs").click(function(){

              //menghapus jika syarat sudah tidak terpenuhi
                $.post("hapus_tbs_bonus_penjualan.php",{idnya:idnya,kodenya:kodenya},function(hapus){
                  if (hapus == 1) {

                      $('#table_tbs_bonus_penjualan').DataTable().destroy();
                      var dataTable = $('#table_tbs_bonus_penjualan').DataTable( {
                      "processing": true,
                      "serverSide": true,
                      "info":     false,
                      "language": { "emptyTable":     "My Custom Message On Empty Table" },
                      "ajax":{
                        url :"datatable_tbs_bonus_penjualan.php", // json datasource
                       
                            type: "post",  // method  , by default get
                        error: function(){  // error handling
                          $(".tbody").html("");
                          $("#table_tbs_bonus_penjualan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                          $("#tableuser_processing").css("display","none");
                          
                        }
                      }   

                    });// end ajax bonus
                  }
                });// end hapus_tbs_bonus_penjualan

            });// end #hapus_bonus_ditbs
                
          }// end else nya (idtbsnya > 0 && subtotal > syarat_free || subtotal_tbspenjualan > syarat_disc)
        }); // end cek_syarat_promo_ditbs
        
            //cek total keseluruhan tbs penjualan
        $.getJSON("cek_total_seluruh.php",function(data){
              //cek total keseluruhan bonus disc
            var total_penj = data.total_penjualan;
            $.getJSON("cek_total_bonus_promo.php",function(tot){
            
            var keterangan = tot.keterangan;
            if (keterangan == 'Disc Produk') {
                var qty = tot.qty_disc;
                if (qty == '') {
                  qty = 0;
                }
                var harga_disc = tot.harga_disc;
                if(harga_disc == ''){
                  harga_disc = 0;
                }
                var subtotal_bonus = qty * harga_disc;
            }
            else{
                var qty = tot.qty_free;
                if (qty == '') {
                  qty = 0;
                }
                var subtotal_bonus = 0;
            }

            var subtotal_tampil = parseFloat(total_penj) + parseFloat(subtotal_bonus);
            //jika tbs ada maka subtotal (total2 dan total1) muncul
            if (data != 0) {
              $("#total2").val(subtotal_tampil.format(2, 3, '.', ','));
            $("#total1").val(subtotal_tampil.format(2, 3, '.', ','));
            }
            else{
              $("#total2").val('0');
            $("#total1").val('0');
            }
            // end if (data != 0)

            //jika tbs bonus ada maka tbs bonus muncul 
            if (tot == 0) {
              $("#tbs_bonus_penjualan").hide();
            }
            else{
              $("#tbs_bonus_penjualan").show();
            }
            // end if (tot == 0)
          }); // end cek_total_bonus_promo
        }); // end cek_total_seluruh


          $('#tabel_tbs_penjualan').DataTable().destroy();

                        var dataTable = $('#tabel_tbs_penjualan').DataTable( {
                          "processing": true,
                          "serverSide": true,
                          "ajax":{
                            url :"data_tbs_penjualan.php", // json datasource
                           
                             
                              type: "post",  // method  , by default get
                            error: function(){  // error handling
                              $(".employee-grid-error").html("");
                              $("#tabel_tbs_penjualan").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                              $("#employee-grid_processing").css("display","none");
                              }
                          },
                             "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                              $(nRow).attr('class','tr-id-'+aData[11]+'');         

                          }
                        });

            if (total_akhir1 == 0) {
              
            $("#potongan_persen").val('0');
                 $("#ppn").val('Non');
                 $("#ppn").attr('disabled',false);
             $("#tax1").attr("disabled", true);
                 $("#level_harga").attr('disabled',false);

            }
            else{

            $("#potongan_persen").val(potongaaan_per);
            }
            /*
            $("#tax_rp").val(Math.round(tax_bener));*/
            $("#kode_barang").trigger('chosen:open');    


        });
}
else {
    
    }
//end hapus ajax

});


$('form').submit(function(){
              return false;
});


}); 
//end fungsi hapus data
</script>


   <script>
   //SCRIPT START PROSES SUBMIT PRODUK
  $(document).on('click', '#submit_produk', function (e) {

    var no_faktur = $("#nomor_faktur_penjualan").val();
    var kode_pelanggan = $("#kd_pelanggan").val();
    var kode_barang = $("#kode_barang").val();
    var nama_barang = $("#nama_barang").val();
    var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
    var level_harga = $("#level_harga").val();
  var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_produk").val()))));
   if (harga == ''){
      harga = 0;
    }
  
  var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
   if (potongan == '')
    {
      potongan = 0;
    }
    else{
          var pos = potongan.search("%");
           if (pos > 0) 
            {
              var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));

               potongan_persen = potongan_persen.replace("%","");
                if(potongan_persen > 100){
                  alert("Potongan Tidak Boleh Lebih 100%");
                  $("#potongan1").val(0);
                  $("#potongan1").focus();
                }
               potongan = parseFloat(gantiTitik(jumlah_barang)) * parseFloat(harga) * potongan_persen / 100 ;
            };
    }

  var nilai_disc_persen = parseFloat(potongan);


  var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax1").val()))));
  if (tax == '')
    {
      tax = 0;
    }
    var jumlahbarang = $("#jumlahbarang").val();
    var satuan = $("#satuan_konversi").val();
    var sales = $("#sales").val();
    var a = $(".tr-kode-"+kode_barang+"").attr("data-kode-barang");    
    var ber_stok = $("#ber_stok").val();
    var ppn = $("#ppn").val();
    var stok = parseFloat(jumlahbarang.replace(',','.'),2) - parseFloat(jumlah_barang.replace(',','.'),2);


   var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
          if (subtotal == '') 
          {
          subtotal = 0;
          }

   var tax_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));

    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
  if (pot_fakt_per == "" || pot_fakt_per == 0,00 || pot_fakt_rp == 0  ) 
      {
        pot_fakt_per = 0.00;
      }

    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
 if (pot_fakt_rp == "" || pot_fakt_rp == 0,00 || pot_fakt_rp == 0 ) 
      {
        pot_fakt_rp = 0.00;
      }

  //PPN
  if (ppn == 'Exclude') 
    {
  
         var total1 = parseFloat(jumlah_barang.replace(',','.'),2) * parseFloat(harga.replace(',','.'),2) - parseFloat(nilai_disc_persen.replace(',','.'),2);

         var total_tax_exclude = parseFloat(total1.replace(',','.'),2) * parseFloat(tax.replace(',','.'),2) / 100;

         
          var total = parseFloat(total1.replace(',','.'),2) + parseFloat(total_tax_exclude.replace(',','.'),2);

    }
    else
    {
        var total = parseFloat(jumlah_barang.replace(',','.'),2) * parseFloat(harga,2) - parseFloat(nilai_disc_persen,2);
    }
  //PPN
   

    var total_akhir1 = parseFloat(subtotal.replace(',','.'),2) + parseFloat(total,2);

 if (pot_fakt_per == 0.00) 
    {

      var potongaaan = pot_fakt_rp;

      var pot_fakt_per = parseFloat(potongaaan,2) / parseFloat(total_akhir1,2) * 100;



//mendapatkan total akhir
      if (pot_fakt_rp == 0.00) 
      {
          var total_akhier = parseFloat(total_akhir1,2);
      }
      else
      {
          var total_akhier = parseFloat(total_akhir1,2) /*+ parseFloat(biaya_adm.replace(',','.'),2)*/ - parseFloat(pot_fakt_rp.replace(',','.'),2);
      }
//mendapatkan total akhir


//Hitung pajak
    if (tax_faktur != 0 ) 
        {
          var hasil_tax = parseFloat(total_akhier.replace(',','.')) * parseFloat(tax_faktur.replace(',','.')) / 100;
        }
    else
        {
           var hasil_tax = 0;
        }
//end hitung pajak
    
    var total_akhir = parseFloat(total_akhier,2) + parseFloat(hasil_tax,2);


    }//end  if (pot_fakt_per == 0.00) 

else if(pot_fakt_rp == 0.00)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = potongaaan;
      var   potongan_persen = potongan_persen.replace("%","");
      var potongaaan = parseFloat(total_akhir1.replace(',','.'),2) * parseFloat(potongan_persen.replace(',','.'),2) / 100;

      if ( pot_fakt_rp == 0.00) 
      {
          var total_akhier = parseFloat(total_akhir1.replace(',','.'),2);
      }
      else
      {
          var total_akhier = parseFloat(total_akhir1.replace(',','.'),2) /*+ parseFloat(biaya_adm.replace(',','.'),2)*/ - parseFloat(potongaaan,2);
      }

//Hitung pajak
  if (tax_faktur != 0) 
    {
        var hasil_tax = parseFloat(total_akhier.replace(',','.'),2) * parseFloat(tax_faktur.replace(',','.'),2) / 100;
    }
 else
     {
        var hasil_tax = 0;
     }
//end hitung pajak
  
   var total_akhir = parseFloat(total_akhier,2) + parseFloat(hasil_tax,2);

    }// else if(pot_fakt_rp == 0.00)


else if(pot_fakt_rp != 0 && pot_fakt_per != 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = potongaaan;
      var   potongan_persen = potongan_persen.replace("%","");
      var potongaaan = parseFloat(total_akhir1,2) * parseFloat(potongan_persen.replace(',','.'),2) / 100;

           if (pot_fakt_rp == 0.00) 
        {
          var total_akhier = parseFloat(total_akhir1,2);
        }
        else
        {
          var total_akhier = parseFloat(total_akhir1,2) /*+ parseFloat(biaya_adm.replace(',','.'),2)*/ - parseFloat(potongaaan,2);
        }

         //Hitung pajak
        if (tax_faktur != 0) {
        var hasil_tax = parseFloat(total_akhier.replace(',','.'),2) * parseFloat(tax_faktur.replace(',','.'),2) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }
    //end hitung pajak

    var total_akhir = parseFloat(total_akhier,2) + parseFloat(hasil_tax,2);

    }//end else if(pot_fakt_rp != 0 && pot_fakt_per != 0)

    
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');


  if (a > 0)
  {
  alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
  }

  else if (jumlah_barang == '')
    {
      alert("Jumlah Barang Harus Diisi");
       $("#jumlah_barang").focus();
    }
 
  else if (kode_pelanggan == '')
  {
    alert("Kode Pelanggan Harus Dipilih");
         $("#kd_pelanggan").focus();
  }
   else if (harga == '')
   {
    alert("Harga Dengan Level Harga ini 0, Silahkan Edit Harga Produk !!");
  }
  else if (ber_stok == 'Jasa' )
  {

      $("#kode_barang").focus();

 //pengambilan data form pembayaran
      $("#total1").val(total_akhir.format(2, 3, '.', ','));
      $("#total2").val(total_akhir1.format(2, 3, '.', ','));
 if (pot_fakt_rp == 0.00)
      {
        $("#potongan_penjualan").val();
      }
      else
      {
        $("#potongan_penjualan").val(potongaaan.format(2, 3, '.', ','));
      }
      $("#tax_rp").val(hasil_tax.format(2, 3, '.', ','));
 //pengambilan data form pembayaran



// POST KE PROSES TBSNYA JIKA JASA
 $.post("prosestbspenjualan.php",{ppn:ppn,no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,satuan:satuan,sales:sales},function(data){
     
      // cek ada tidaknya promo hariini
        $.post("cek_program_promo.php",{kode_barang:kode_barang},function(program){
        if (program != 1) {
          
        }
        else{
          //mengambil id program
          $.getJSON("cek_id_program_promo.php",function(oke){
            
          $("#disc_tbs").val(oke.potongan_tbs_penjualan);
          var jenisbonus = oke.jenis_bonus;
          
          if (jenisbonus == 'Free Produk') {
            $("#id_program").val(oke.id_program);
            //cek produk promo free produk
            $.post("cek_promo_produk.php",{kode_barang:kode_barang},function(joya){
            if (joya != 1) {
              
            }
            else{
                //$("#modal_promo_produk").modal('show');
                $("#modal_bonus_nya").modal('show');

                $('#table_produk_bonus').DataTable().destroy();

              var dataTable = $('#table_produk_bonus').DataTable( {
              "processing": true,
              "serverSide": true,
              
              "ajax":{
                url :"datatable_produk_bonus_free.php", // json datasource
               "data": function ( d ) {
                          d.id_programnya = $("#id_program").val();
                          // d.custom = $('#myInput').val();
                          // etc
                            },
                type: "post",  // method  , by default get
                error: function(){  // error handling
                  $(".employee-grid-error").html("");
                  $("#table_produk_bonus").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                  $("#employee-grid_processing").css("display","none");
                }
            },
                
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                  $(nRow).attr('class', "pilih_bonus");
                  $(nRow).attr('data-kobon', aData[0]);
                  $(nRow).attr('data-nabon', aData[1]);
                  $(nRow).attr('data-program', aData[2]);
                  $(nRow).attr('data-qty', aData[3]);
                  $(nRow).attr('data-satuan', aData[4]);
                  $(nRow).attr('data-harga', aData[5]);
                  $(nRow).attr('data-id', aData[6]);

              },
            });

            $("#form").submit(function(){
            return false;
            });
            }
            });// end cek produk promo free produk

          }
          
          if (jenisbonus == 'Disc Produk'){
            $("#id_program").val(oke.id_program);
            //cek produk promo disc produk
            $.post("cek_promo_produk_disc.php",{kode_barang:kode_barang},function(joyan){
            if (joyan != 1) {
              
            }
            else{
                ////$("#modal_promo_produk_disc").modal('show');
                $("#modal_bonus_disc_nya").modal('show');
                $('#table_produk_bonus_disc').DataTable().destroy();
                  var dataTable = $('#table_produk_bonus_disc').DataTable( {
                  "processing": true,
                  "serverSide": true,
                  
                  "ajax":{
                    url :"datatable_produk_bonus_disc.php", // json datasource
                   "data": function ( d ) {
                              d.id_programnya = $("#id_program").val();
                              // d.custom = $('#myInput').val();
                              // etc
                                },
                    type: "post",  // method  , by default get
                    error: function(){  // error handling
                      $(".employee-grid-error").html("");
                      $("#table_produk_bonus_disc").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                      $("#employee-grid_processing").css("display","none");
                    }
                },
                    
                    "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                      $(nRow).attr('class', "pilih_bonus_disc");
                      $(nRow).attr('data-kobon', aData[0]);
                      $(nRow).attr('data-nabon', aData[1]);
                      $(nRow).attr('data-qty-max', aData[2]);
                      $(nRow).attr('data-harga', aData[3]);
                      $(nRow).attr('data-harga-normal', aData[4]);
                      $(nRow).attr('data-program', aData[5]);
                      $(nRow).attr('data-satuan', aData[6]);
                      $(nRow).attr('data-id', aData[7]);

                  },
                });
            }
            });// end cek produk promo disc produk
          }
        });// end cek_program_promo
        }
      });// end cek_id_program_promo

        // show ajax tbs
       $('#tabel_tbs_penjualan').DataTable().destroy();
                var dataTable = $('#tabel_tbs_penjualan').DataTable( {
                "processing": true,
                "serverSide": true,
                "info":     false,
                "language": { "emptyTable":     "My Custom Message On Empty Table" },
                "ajax":{
                  url :"data_tbs_penjualan.php", // json datasource
                 
                      type: "post",  // method  , by default get
                  error: function(){  // error handling
                    $(".tbody").html("");
                    $("#tabel_tbs_penjualan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                    $("#tableuser_processing").css("display","none");
                    
                  }
                }   

          });
    //end show ajax tbs

     $("#ppn").attr("disabled", true);
     $("#level_harga").attr("disabled", true);
     $("#kd_pelanggan").attr("disabled", true);
     $("#tbody").prepend(data);
     $("#kode_barang").val('');
     $("#kode_barang").trigger('chosen:updated');
     $("#kode_barang").trigger('chosen:open');
     $("#nama_barang").val('');
     $("#harga_produk").val('');
     $("#ber_stok").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');

     });

} //end  else if (ber_stok == 'Jasa' )


  else if (stok < 0) 
  {
    alert ("Jumlah Melebihi Stok Barang !");
  }

  else{

//pengambilan data untuk form pembayaran
 if ( pot_fakt_rp == 0.00)
      {
        $("#potongan_penjualan").val();
      }
      else
      {
        $("#potongan_penjualan").val(potongaaan.format(2, 3, '.', ','));
      }
      $("#total1").val(total_akhir.format(2, 3, '.', ','));
      $("#total2").val(total_akhir1.format(2, 3, '.', ','));
      $("#tax_rp").val(hasil_tax.format(2, 3, '.', ','));
      $("#kode_barang").focus();
//pengambilan data untuk form pembayaran



// POST KE TBS ALL PRODUK
    $.post("prosestbspenjualan.php",{ppn:ppn,no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,satuan:satuan,sales:sales},function(data){
     
     // cek ada tidaknya promo hariini
    $.post("cek_program_promo.php",{kode_barang:kode_barang},function(program){
    if (program != 1) {
      
    }
    else{
      //mengambil id program
      $.getJSON("cek_id_program_promo.php",function(oke){
        
     $("#disc_tbs").val(oke.potongan_tbs_penjualan);
      var jenisbonus = oke.jenis_bonus;
          
      if (jenisbonus == 'Free Produk') {
            $("#id_program").val(oke.id_program);
            //cek produk promo free produk
            $.post("cek_promo_produk.php",{kode_barang:kode_barang},function(joya){
            if (joya != 1) {
              
            }
            else{
                    //$("#modal_promo_produk").modal('show');
                    $("#modal_bonus_nya").modal('show');

                    $('#table_produk_bonus').DataTable().destroy();

                  var dataTable = $('#table_produk_bonus').DataTable( {
                  "processing": true,
                  "serverSide": true,
                  
                  "ajax":{
                    url :"datatable_produk_bonus_free.php", // json datasource
                   "data": function ( d ) {
                              d.id_programnya = $("#id_program").val();
                              // d.custom = $('#myInput').val();
                              // etc
                                },
                    type: "post",  // method  , by default get
                    error: function(){  // error handling
                      $(".employee-grid-error").html("");
                      $("#table_produk_bonus").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                      $("#employee-grid_processing").css("display","none");
                    }
                },
                    
                    "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                      $(nRow).attr('class', "pilih_bonus");
                      $(nRow).attr('data-kobon', aData[0]);
                      $(nRow).attr('data-nabon', aData[1]);
                      $(nRow).attr('data-program', aData[2]);
                      $(nRow).attr('data-qty', aData[3]);
                      $(nRow).attr('data-satuan', aData[4]);
                      $(nRow).attr('data-harga', aData[5]);
                      $(nRow).attr('data-id', aData[6]);

                  },
                });

                $("#form").submit(function(){
                return false;
                });
            } // end else nya cek_promo_produk
            });// end cek produk promo free produk

      }

      if (jenisbonus == 'Disc Produk') {
                $("#id_program").val(oke.id_program);
                //cek produk promo disc produk
                $.post("cek_promo_produk_disc.php",{kode_barang:kode_barang},function(joyan){
                if (joyan != 1) {
                  
                }
                else{
                    //$("#modal_promo_produk_disc").modal('show');
                    $("#modal_bonus_disc_nya").modal('show');
                    $('#table_produk_bonus_disc').DataTable().destroy();
                      var dataTable = $('#table_produk_bonus_disc').DataTable( {
                      "processing": true,
                      "serverSide": true,
                      
                      "ajax":{
                        url :"datatable_produk_bonus_disc.php", // json datasource
                       "data": function ( d ) {
                                  d.id_programnya = $("#id_program").val();
                                  // d.custom = $('#myInput').val();
                                  // etc
                                    },
                        type: "post",  // method  , by default get
                        error: function(){  // error handling
                          $(".employee-grid-error").html("");
                          $("#table_produk_bonus_disc").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                          $("#employee-grid_processing").css("display","none");
                        }
                    },
                        
                        "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                          $(nRow).attr('class', "pilih_bonus_disc");
                          $(nRow).attr('data-kobon', aData[0]);
                          $(nRow).attr('data-nabon', aData[1]);
                          $(nRow).attr('data-qty-max', aData[2]);
                          $(nRow).attr('data-harga', aData[3]);
                          $(nRow).attr('data-harga-normal', aData[4]);
                          $(nRow).attr('data-program', aData[5]);
                          $(nRow).attr('data-satuan', aData[6]);
                          $(nRow).attr('data-id', aData[7]);

                      },
                    });// end $('#table_produk_bonus_disc').DataTable

                } // end else nya cek_promo_produk_disc
                });// end cek produk promo disc produk
      }// end if (jenisbonus == 'Disc Produk')
     });// end cek_id_program_promo
    } // end else nya cek_program_promo
  });// end cek_program_promo

     $("#level_harga").attr("disabled", true);
      $("#ppn").attr("disabled", true);
      $("#kd_pelanggan").attr("disabled", true);
      $("#tbody").prepend(data);    
      $("#kode_barang").trigger("chosen:open");
      $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#harga_produk").val('');
     $("#ber_stok").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');



     });// POST KE TBS ALL PRODUK


    // show ajax tbs
   $('#tabel_tbs_penjualan').DataTable().destroy();
            var dataTable = $('#tabel_tbs_penjualan').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"data_tbs_penjualan.php", // json datasource
             
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_penjualan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
//end show ajax tbs

}//end ber_stok != jasa )


});

$("#formtambahproduk").submit(function(){
    return false;  
    });
</script>



<script>
//SKRIPT UNTUK START CLICK BAYAR PENJUALAN
$("#penjualan").click(function(){

        var session_id = $("#session_id").val();
        var no_faktur = $("#nomor_faktur_penjualan").val();
        var sisa_pembayaran =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#sisa_pembayaran_penjualan").val()))));
        var kredit =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#kredit").val())))); 
        var kode_pelanggan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#kd_pelanggan").val()))));
        var tanggal_jt = $("#tanggal_jt").val();
        var total =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total1").val())))); 
        var total2 =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val())))) ; 
        var potongan =   bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
        var biaya_adm =   bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
        var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
        var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));
        var cara_bayar = $("#carabayar1").val();
        var pembayaran =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_produk").val()))));
        var kode_gudang = $("#kode_gudang").val();
        var sales = $("#sales").val();
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();   
        var ppn_input = $("#ppn_input").val();
        var ppn = $("#ppn").val();
        var sisa = parseFloat(pembayaran) - parseFloat(total);
        var sisa_kredit = parseFloat(total) - parseFloat(pembayaran);

if (sisa_pembayaran < 0){
  alert("Jumlah Pembayaran Tidak Mencukupi");
}
else if (kode_pelanggan == "") {
  alert("Kode Pelanggan Harus Di Isi");
}
else if (pembayaran == "") {
  alert("Pembayaran Harus Di Isi");
}
else if (kode_gudang == ""){
  alert(" Kode Gudang Harus Diisi ");
}
else if ( sisa < 0) {
  alert("Silakan Bayar Piutang");
}
else if (total ==  0 || total == "") {
  alert("Anda Belum Melakukan Pemesanan");
}
else{

  $("#penjualan").hide();
  $("#cetak_langsung").hide();
  $("#simpan_sementara").hide();
  $("#batal_penjualan").hide();
  $("#piutang").hide();
  $("#transaksi_baru").show();

// CEK DULU SUBTOTAL SESUAI TIDAK DENGAN TOTAL AKHIR
 $.post("cek_subtotal_penjualan.php",{total2:total2,session_id:session_id},function(data) {

  if (data == "1") {

      alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar!");       
        window.location.href="formpenjualan.php";

  }
  else{

  //JIKA SESUAI SUB DAN TOTAL AKHIR POST KE PROSES
  $.post("proses_bayar_jual.php",{biaya_adm:biaya_adm,total2:total2,session_id:session_id,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,harga:harga,sales:sales,kode_gudang:kode_gudang,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input},function(info) {

    //info = info.replace(/\s+/g, '');

     var no_faktur = info;

     $("#cetak_tunai").attr('href', 'cetak_penjualan_tunai.php?no_faktur='+no_faktur);
     $("#cetak_tunai_besar").attr('href', 'cetak_penjualan_tunai_besar.php?no_faktur='+no_faktur);
     $("#alert_berhasil").show();
     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');
     $("#cetak_tunai").show();
     $("#cetak_tunai_besar").show('');
     $("#span_tbs").hide();
     $("#sss").collapse('hide');
     $("#kd_pelanggan").val('');
     $("#kd_pelanggan").trigger("chosen:open");
     $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});
     $("#total1").val('');
     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');

       
   });//JIKA SESUAI SUB DAN TOTAL AKHIR POST KE PROSES

        
  }

 });// end CEK DULU SUBTOTAL SESUAI TIDAK DENGAN TOTAL AKHIR


 }

 $("form").submit(function(){
    return false;
 
});

});
// end SKRIPT UNTUK START CLICK BAYAR PENJUALAN
  </script>


<script>
   //SCRIPT UNTUK CETAK LANGSUNGNYA
  $("#cetak_langsung").click(function(){

        var session_id = $("#session_id").val();
        var no_faktur = $("#nomor_faktur_penjualan").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var kode_pelanggan = $("#kd_pelanggan").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var biaya_adm =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#biaya_adm").val() ))));

        var potongan_persen = $("#potongan_persen").val();
        var tax = $("#tax_rp").val();
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var total_hpp = $("#total_hpp").val();
        var harga = $("#harga_produk").val();
        var kode_gudang = $("#kode_gudang").val();
        var sales = $("#sales").val();
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();   
        var ppn_input = $("#ppn_input").val();
        var ppn = $("#ppn").val();
        
        
        var sisa = pembayaran - total;
        
        var sisa_kredit = total - pembayaran;


     $("#total1").val('');
     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');


 
 if (sisa_pembayaran < 0)
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }


 else if (kode_pelanggan == "") 
 {

alert("Kode Pelanggan Harus Di Isi");

 }
else if (pembayaran == "") 
 {

alert("Pembayaran Harus Di Isi");

 }

   else if (kode_gudang == "")
 {

alert(" Kode Gudang Harus Diisi ");

 }
 
 else if ( sisa < 0) 
 {

alert("Silakan Bayar Piutang");

 }
                else if (total ==  0 || total == "") 
        {
        
        alert("Anda Belum Melakukan Pemesanan");
        
        }

 else

 {

  $("#penjualan").hide();
  $("#simpan_sementara").hide();
  $("#cetak_langsung").hide();
  $("#batal_penjualan").hide();
  $("#piutang").hide();
  $("#transaksi_baru").show();

 $.post("cek_subtotal_penjualan.php",{total2:total2,session_id:session_id},function(data) {

  if (data == "1") {

   alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar!");       
        window.location.href="formpenjualan.php";
  

  }
  else{
    
// POST KE BAYAR LANGSUNG CETAK
   $.post("proses_bayar_tunai_cetak_langsung.php",{biaya_adm:biaya_adm,total2:total2,session_id:session_id,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,harga:harga,sales:sales,kode_gudang:kode_gudang,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input},function(info) {
  
     var no_fak= info;
     $("#alert_berhasil").show();
     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');
     $("#span_tbs").hide();
      $("#kd_pelanggan").val('');
      $("#kd_pelanggan").trigger("chosen:open");
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
     $("#sss").collapse('hide');


    var win = window.open('cetak_penjualan_tunai.php?no_faktur='+no_fak+'');
     if (win) { 
    
    win.focus(); 
  } else { 
    
    alert('Mohon Izinkan PopUps Pada Website Ini !'); }    
    
       
   });
  }

 });



 }

 $("form").submit(function(){
    return false;
 
});

});

               $("#penjualan").mouseleave(function(){
               
            
               var kode_pelanggan = $("#kd_pelanggan").val();
               if (kode_pelanggan == ""){
               $("#kd_pelanggan").attr("disabled", false);
               }
               
               });
      
  </script>

  
     <script>
       //SCRIPT START UNTUK PIUTANG
       $("#piutang").click(function(){
       
        var session_id = $("#session_id").val();
        var no_faktur = $("#nomor_faktur_penjualan").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var kode_pelanggan = $("#kd_pelanggan").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
                var biaya_adm =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#biaya_adm").val() ))));

        var potongan_persen = $("#potongan_persen").val();
        var tax = $("#tax_rp").val();
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var total_hpp = $("#total_hpp").val();
        var kode_gudang = $("#kode_gudang").val();
        var sales = $("#sales").val();
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();
        var ppn_input = $("#ppn_input").val();
       
       var sisa =  pembayaran - total; 

       var sisa_kredit = total - pembayaran;

    
       
      if (sisa_pembayaran == "" )
      {

        alert ("Jumlah Pembayaran Tidak Mencukupi");
      }

       else if (kode_pelanggan == "") 
       {
       
       alert("Kode Pelanggan Harus Di Isi");
       
       }
       else if (tanggal_jt == "")
       {

        alert ("Tanggal Jatuh Tempo Harus Di Isi");
        $("#tanggal_jt").focus();
         
       }
         else if ( total == "") 
         {
         
         alert("Anda Belum Melakukan Pesanan");
         
         }
         
       else
       {


        $("#piutang").hide();
        $("#cetak_langsung").hide();
        $("#simpan_sementara").hide();
        $("#batal_penjualan").hide();
        $("#penjualan").hide();
        $("#transaksi_baru").show();

        // POST KE PROSESNYA PIUTANGNYA
       $.post("proses_bayar_jual.php",{biaya_adm:biaya_adm,total2:total2,session_id:session_id,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,sales:sales,kode_gudang:kode_gudang,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input},function(info) {

            var no_faktur = info;
            $("#cetak_piutang").attr('href', 'cetak_penjualan_piutang.php?no_faktur='+no_faktur+'');
            $("#alert_berhasil").show();
            $("#pembayaran_penjualan").val('');
            $("#sisa_pembayaran_penjualan").val('');
            $("#kredit").val('');
            $("#potongan_penjualan").val('');
            $("#potongan_persen").val('');
            $("#tanggal_jt").val('');
            $("#cetak_piutang").show();
            $("#tax").val('');

          $("#kd_pelanggan").val('');
          $("#kd_pelanggan").trigger("chosen:open");
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"}); 
             

                 $("#span_tbs").hide();
     $("#sss").collapse('hide');


       
       });

       
       }  
       //mengambil no_faktur pembelian agar berurutan

       });
 $("form").submit(function(){
       return false;
       });

              $("#piutang").mouseleave(function(){
               
            
               var kode_pelanggan = $("#kd_pelanggan").val();
               if (kode_pelanggan == ""){
               $("#kd_pelanggan").attr("disabled", false);
               }
               
               });
  </script>   



<script type="text/javascript">
//SCRIPT UNTUK CARI PRODUK JIKA TIDAK = 1 MAKA PPN LANGSUNG CLOSED
$(document).ready(function(){
$("#cari_produk_penjualan").click(function(){
  var session_id = $("#session_id").val();

  $.post("cek_tbs_penjualan.php",{session_id: "<?php echo $session_id; ?>"},function(data){
        if (data != "1") {


             $("#ppn").attr("disabled", false);

        }
    });

});
});
</script>


<script>
//JUMLAH BARANG CEK STOK DARI KODE BARANG YANG DI PILIH
  $(document).ready(function(){

  $("#jumlah_barang").keyup(function(){
     var jumlah_barang = $("#jumlah_barang").val();
     var jumlahbarang = $("#jumlahbarang").val();
     var limit_stok = $("#limit_stok").val();
     var ber_stok = $("#ber_stok").val();
     var stok = jumlahbarang - jumlah_barang;

if (stok < 0 )

  {

       if (ber_stok == 'Jasa') {
       
       }
       
       else{
       alert ("Jumlah Melebihi Stok!");
       $("#jumlah_barang").val('');
       }


    }

    else if( limit_stok > stok  ){

      alert ("Persediaan Barang Ini Sudah Mencapai Batas Limit Stok, Segera Lakukan Pembelian !");
    }
  });
})

</script>



<script type="text/javascript">
$(document).ready(function(){
// Key up untuk potongan persen
$("#potongan_persen").keyup(function(){

        var potongan_persen = $("#potongan_persen").val();

       if (potongan_persen == "") {
        potongan_persen = 0;
      }
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
        var potongan_penjualan = ((parseFloat(total.replace(',','.')) * parseFloat(potongan_persen)) / 100);
        var tax = $("#tax").val();

        /*var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
        if (biaya_adm == '')
        {
          biaya_adm = 0.00;
        }*/

      var ambil_semula = parseFloat(total.replace(',','.')) /*+ parseFloat(biaya_adm.replace(',','.'));parseFloat(tax_rp)*/
        var sisa_potongan = parseFloat(total.replace(',','.')) - parseFloat(potongan_penjualan);


             /*var t_tax = ((parseFloat(sisa_potongan.replace(',','.')) * parseFloat(tax.replace(',','.'))) / 100);*/
             var hasil_akhir = parseFloat(sisa_potongan) /*+ parseFloat(biaya_adm.replace(',','.'));parseFloat(tax_rp)*/


         $("#total1").val(hasil_akhir.format(2, 3, '.', ','));
        $("#potongan_penjualan").val(potongan_penjualan.format(2, 3, '.', ','));
        
        if (potongan_persen > 100.00) {

          alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
          $("#potongan_persen").val('');
          $("#potongan_penjualan").val('');
          $("#total1").val(ambil_semula.format(2, 3, '.', ','));
        }

      });


// Key Up untuk Potongan Rupiah
$("#potongan_penjualan").keyup(function(){

    var potongan_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
    var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));

  if (potongan_penjualan == "") 
      {
        potongan_penjualan = 0,00;
      }


    if (potongan_penjualan == 0,00 || potongan_penjualan == "" )
    {
          var potongan_persen = 0.00;
    }
    else
    {
         var potongan_persen = ((parseFloat(potongan_penjualan.replace(',','.')) / parseFloat(total.replace(',','.'))) * 100);
    }

/*var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
        if (biaya_adm == '')
        {
          biaya_adm = 0;
        }*/


   if(potongan_persen > 100.00)
      {
        alert("Potongan Tidak Dapat Lebih dari 100% !!");
         $("#potongan_persen").val('');
        $("#potongan_penjualan").val('');
      
        /* var tax = $("#tax").val();

        if (tax == "")
        {
          tax = 0;
        }
        var t_tax = ((parseFloat(total.replace(',','.')) * parseFloat(tax.replace(',','.'))) / 100);*/
      
           var hasil_akhir = parseFloat(total.replace(',','.'));
      

        $("#total1").val(hasil_akhir.format(2, 3, '.', ','));

      }
      else
      {


      
      $("#potongan_persen").val(potongan_persen.format(2, 3, '.', ','));

 if (potongan_penjualan == 0,00 || potongan_penjualan == "" )
      {
        var sisa_potongan = parseFloat(total.replace(',','.'));
       }
       else
      {
        var sisa_potongan = parseFloat(total.replace(',','.')) - parseFloat(potongan_penjualan.replace(',','.'));
      } 
             /* if (tax == 0)
              {
               var t_tax = 0;
              }
              
              var t_tax = ((parseFloat(sisa_potongan) * parseFloat(tax)) / 100);*/


             var hasil_akhir = parseFloat(sisa_potongan) /*+ parseFloat(biaya_adm.replace(',','.')); + parseFloat(t_tax,10);*/
        }
        
        $("#total1").val(hasil_akhir.format(2, 3, '.', ','));
        

      });
     });   
//TUTUP TIDAK MEMAKAI tax atau pajak DI PEMBAYARAN
/*$("#tax").keyup(function(){

        var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val() ))));
      if (potongan == "") {
        potongan = 0;
      }

        var potongan_persen = $("#potongan_persen").val();
               if (potongan_persen == "") {
        potongan_persen = 0;
      }
        
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val() ))));
       
              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();

              var t_total = total - potongan;

              if (tax == "") {
                tax = 0;
              }
              else if (cara_bayar == "") {
                alert ("Kolom Cara Bayar Masih Kosong");
                 $("#tax").val('');
                 $("#potongan_penjualan").val('');
                 $("#potongan_persen").val('');
              }

                else if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');
                 $("#tax_rp").val('');
                 $("#total1").val(tandaPemisahTitik(t_total));


              }
              
              else {


              var t_tax = ((parseFloat(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) * parseFloat(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(tax,10)))))) / 100);

              var total_akhir = parseFloat(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) + Math.round(parseFloat(t_tax,10));
              
              
            $("#tax_rp").val(parseFloat(t_tax));
            $("#total1").val(tandaPemisahTitik(total_akhir));
   }


        });*/

        </script>



<script type="text/javascript">
 /* $(document).ready(function(){
    
  //START KEYUP BIAYA ADMIN RUPIAH

    $("#biaya_adm").keyup(function(){
      var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
      if (biaya_adm == '') {
        biaya_adm = 0,00;
      }
      var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
      if (subtotal == '') {
        subtotal = 0,00;
      }
      var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
      if (potongan == '') {
        potongan = 0,00;
      }

      var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
      if (pembayaran == '') {
        pembayaran = 0,00;
      }  
      /*    
      var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
      if (tax == '') {
        tax = 0;
      }

       if (potongan == 0,00 || potongan == '')
            {
                   var t_total = parseFloat(subtotal.replace(',','.'));
            }
            else
            {
                var t_total = parseFloat(subtotal.replace(',','.')) - parseFloat(potongan.replace(',','.'));
            }

if (biaya_adm == 0,00 || biaya_adm == '')
{
      var biaya_admin_persen = 0.00;

}
else
{
      var biaya_admin_persen = parseFloat(biaya_adm.replace(',','.')) / parseFloat(subtotal.replace(',','.')) * 100;
 }    
      var t_tax = parseFloat(t_total) * parseFloat(tax) / 100;
      var total_akhir1 = parseFloat(t_total) + Math.round(parseFloat(t_tax));
    

if (biaya_adm == 0,00 || biaya_adm == '')
{
      var total_akhir = parseFloat(t_total);
}
else
{
        var total_akhir = parseFloat(t_total) + parseFloat(biaya_adm.replace(',','.'));
}


      $("#total1").val(total_akhir.format(2, 3, '.', ','));
      $("#biaya_admin_persen").val(biaya_admin_persen.format(2, 3, '.', ','));

      if (biaya_admin_persen > 100.00) {

            if (potongan == 0,00 || potongan == '')
            {
              var total_akhir = parseFloat(subtotal.replace(',','.'));
            }
            else
            {
              var total_akhir = parseFloat(subtotal.replace(',','.')) - parseFloat(potongan.replace(',','.'));
            }
            alert ("Biaya Amin %, Tidak Boleh Lebih Dari 100%");
            $("#biaya_admin_persen").val('');
            $("#biaya_admin_select").val('0');            
            $("#biaya_admin_select").trigger('chosen:updated');
            $("#biaya_adm").val('');
            $("#biaya_adm").val('');
            $("#total1").val(total_akhir.format(2, 3, '.', ','));
          }
          
        else 
          {
          }

    });

  //END KEYUP BIAYA ADMIN RUPIAH

  //START KEYUP BIAYA ADMIN PERSEN

    $("#biaya_admin_persen").keyup(function(){
      var biaya_admin_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_persen").val()))));
      if (biaya_admin_persen == '') {
        biaya_admin_persen = 0;
      }
      var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
      if (subtotal == '') {
        subtotal = 0,00;
      }
      var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
      if (potongan == '') {
        potongan = 0,00;
      }
      var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
      if (pembayaran == '') {
        pembayaran = 0,00;
      }  


           if (potongan == 0,00 || potongan == '')
            {
                var t_total = parseFloat(subtotal.replace(',','.'));
            }
            else
            {
                var t_total = parseFloat(subtotal.replace(',','.'),2) - parseFloat(potongan.replace(',','.'),2);
            }

      var t_total = parseFloat(subtotal.replace(',','.'),2) - parseFloat(potongan,2);
      var biaya_admin_rupiah = parseFloat(biaya_admin_persen,2) * parseFloat(subtotal.replace(',','.'),2) / 100;
 

      var total_akhir = parseFloat(t_total,2) + parseFloat(biaya_admin_rupiah,2);

      $("#total1").val(total_akhir.format(2, 3, '.', ','));
      $("#biaya_adm").val(biaya_admin_rupiah.format(2, 3, '.', ','));

      if (biaya_admin_persen > 100.00) {
            

            if (potongan == 0,00 || potongan == '' )
            {
              var total_akhir = parseFloat(subtotal.replace(',','.'));
            }
            else
            {
              var total_akhir = parseFloat(subtotal.replace(',','.')) - parseFloat(potongan.replace(',','.'));
            }
            alert ("Biaya Amin %, Tidak Boleh Lebih Dari 100%");
            $("#biaya_admin_persen").val('');
            $("#biaya_admin_select").val('0');            
            $("#biaya_admin_select").trigger('chosen:updated');
            $("#biaya_adm").val('');
            $("#total1").val(total_akhir.format(2, 3, '.', ','));
          }
          
        else
          {
          }

    });

  //END KEYUP BIAYA ADMIN PERSEN
  });
  

$(document).ready(function(){
  //Hitung Biaya Admin

  $("#biaya_admin_select").change(function(){
  
  var biaya_admin = $("#biaya_admin_select").val();  
  var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
  var total1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total1").val()))));
  var diskon = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
      if(diskon == '')
      {
      diskon = 0,00
      }


  var data_admin = biaya_admin;

  if (biaya_admin == 0) {

    if (diskon == 0,00 || diskon == '' )
      {
         var hasilnya = parseFloat(total2.replace(',','.'));
      }
      else
      {
         var hasilnya = parseFloat(total2.replace(',','.')) - parseFloat(diskon.replace(',','.'));
      }

      $("#total1").val(hasilnya.format(2, 3, '.', ','));
      $("#biaya_adm").val(0);

      data_admin = data_admin.replace(',','.');

      $("#biaya_admin_persen").val(data_admin);

  }
  else if (biaya_admin > 0) {

      var hitung_biaya = parseFloat(total2.replace(',','.')) * parseFloat(data_admin) / 100;
       if (total2 == "" || total2 == 0) {
       hitung_biaya = 0;
       }


            $("#biaya_adm").val(hitung_biaya);

      var biaya_admin = $("#biaya_adm").val();   


if (diskon == 0,00 || diskon == '' )
      {
      var hasilnya = parseFloat(total2.replace(',','.')) + parseFloat(biaya_admin.replace(',','.'));
      }
      else
      {
      var hasilnya = parseFloat(total2.replace(',','.')) + parseFloat(biaya_admin.replace(',','.')) - parseFloat(diskon.replace(',','.'));
      }

        if (total2 == "" || total2 == 0) {
        hasilnya = 0;
        }


   data_admin = data_admin.replace(',','.');

      $("#total1").val(hasilnya.format(2, 3, '.', ','));
      $("#biaya_adm").val(hitung_biaya.format(2, 3, '.', ','));
      $("#biaya_admin_persen").val(data_admin);
      


  }
      
    });
});
//end Hitu8ng Biaya Admin*/
</script>





        <script>
        //SCRIPT KEYUP JUMLAH BAYARNYA
        $(document).ready(function(){
        $("#pembayaran_penjualan").keyup(function(){
        var pembayaran =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        var total =   bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total1").val()))));
        var sisa = parseFloat(pembayaran.replace(',','.')) - parseFloat(total.replace(',','.'));
        var sisa_kredit = parseFloat(total.replace(',','.')) - parseFloat(pembayaran.replace(',','.')); 


        if (sisa < 0 )
        {
        $("#kredit").val(sisa_kredit.format(2, 3, '.', ','));
        $("#sisa_pembayaran_penjualan").val('0');
        $("#tanggal_jt").attr("disabled", false);
        
        }
        
        else  
        {
        $("#sisa_pembayaran_penjualan").val(sisa.format(2, 3, '.', ','));
        $("#kredit").val('0');
        $("#tanggal_jt").attr("disabled", true);
        
        } 
        
        
        });
        
        
        });
        </script>





<!-- 
<script>
$(function() {
    $( "#kode_barang" ).autocomplete({
        source: 'kode_barang_autocomplete.php'
    });
});
</script>
-->


<!--
<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){

          var kode_barang = $(this).val();
          var level_harga = $("#level_harga").val();
          var session_id = $("#session_id").val();
          var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
          
          if (kode_barang != '')
          {

       
       
          $.post("cek_barang_penjualan.php",{kode_barang: kode_barang}, function(data){
          $("#jumlahbarang").val(data);
          });

          $.post('cek_kode_barang_tbs_penjualan.php',{kode_barang:kode_barang,session_id:session_id}, function(data){
          
          if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

          $("#kode_barang").val('');
          $("#nama_barang").val('');
          }//penutup if
          
          });////penutup function(data)

      $.getJSON('lihat_nama_barang.php',{kode_barang:kode_barang}, function(json){
      
      if (json == null)
      {
        
        $('#nama_barang').val('');
        $('#limit_stok').val('');
        $('#harga_produk').val('');
        $('#harga_lama').val('');
        $('#harga_baru').val('');
        $('#satuan_produk').val('');
        $('#satuan_konversi').val('');
        $('#id_produk').val('');
        $('#ber_stok').val('');

      }

      else 
      {
        if (level_harga == "Level 1") {

        $('#harga_produk').val(json.harga_jual);
        $('#harga_baru').val(json.harga_jual);
        $('#harga_lama').val(json.harga_jual);
        }
        else if (level_harga == "Level 2") {

        $('#harga_produk').val(json.harga_jual2);
        $('#harga_baru').val(json.harga_jual2);
        $('#harga_lama').val(json.harga_jual2);
        }
        else if (level_harga == "Level 3") {

        $('#harga_produk').val(json.harga_jual3);
        $('#harga_baru').val(json.harga_jual3);
        $('#harga_lama').val(json.harga_jual3);
        }

        $('#nama_barang').val(json.nama_barang);
        $('#limit_stok').val(json.limit_stok);
        $('#satuan_produk').val(json.satuan);
        $('#satuan_konversi').val(json.satuan);
        $('#id_produk').val(json.id);
        $('#ber_stok').val(json.berkaitan_dgn_stok);

$.post("lihat_promo_alert.php",{id:json.id},function(data){

    if (data == '')
    {

    }
    else{
      $("#modal_promo_alert").modal('show');
      $("#tampil_alert").html(data);
    }

});

      }
                                              
        });
        
}

        });
        });

      
      
</script>
-->



<script>
/* Membuat Tombol Shortcut */

function myFunction(event) {
    var x = event.which || event.keyCode;

    if(x == 112){


     $("#myModal").modal();

    }

    else if(x == 113){


     $("#pembayaran_penjualan").focus();

    }

   else if(x == 115){


     $("#penjualan").focus();

    }
  }
</script>

<script type="text/javascript">
$(document).ready(function(){
  //cek total keseluruhan tbs penjualan
    $.getJSON("cek_total_seluruh.php",function(data){
          //cek total keseluruhan bonus disc
        var total_penj = data.total_penjualan;
        $.getJSON("cek_total_bonus_promo.php",function(tot){
        
        var keterangan = tot.keterangan;
        if (keterangan == 'Disc Produk') {
            var qty = tot.qty_disc;
            if (qty == '') {
              qty = 0;
            }
            var harga_disc = tot.harga_disc;
            if(harga_disc == ''){
              harga_disc = 0;
            }
            var subtotal_bonus = qty * harga_disc;
        }
        else{
            var qty = tot.qty_free;
            if (qty == '') {
              qty = 0;
            }
            var subtotal_bonus = 0;
        }

        var subtotal_tampil = parseFloat(total_penj) + parseFloat(subtotal_bonus);
        //jika tbs ada maka subtotal (total2 dan total1) muncul
        if (data != 0) {
          $("#total2").val(subtotal_tampil.format(2, 3, '.', ','));
        $("#total1").val(subtotal_tampil.format(2, 3, '.', ','));
        }
        else{
          $("#total2").val('0');
        $("#total1").val('0');
        }
        // end if (data != 0)

        //jika tbs bonus ada maka tbs bonus muncul 
        if (tot == 0) {
          $("#tbs_bonus_penjualan").hide();
        }
        else{
          $("#tbs_bonus_penjualan").show();
        }
        // end if (tot == 0)
      }); // end cek_total_bonus_promo
    }); // end cek_total_seluruh
});
</script>


     <script>
       //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
       $("#simpan_sementara").click(function(){
       
        var session_id = $("#session_id").val();
        var no_faktur = $("#nomor_faktur_penjualan").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var kode_pelanggan = $("#kd_pelanggan").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
       var biaya_adm =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#biaya_adm").val() ))));

        var potongan_persen = $("#potongan_persen").val();
        var tax = $("#tax_rp").val();
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var total_hpp = $("#total_hpp").val();
        var kode_gudang = $("#kode_gudang").val();
        var sales = $("#sales").val();
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();
        var ppn_input = $("#ppn_input").val();
       
       var sisa =  pembayaran - total; 

       var sisa_kredit = total - pembayaran;


       
  if (kode_pelanggan == "") 
       {
       
       alert("Kode Pelanggan Harus Di Isi");
       
       }

         else if ( total == "") 
         {
         
         alert("Anda Belum Melakukan Pesanan");
         
         }
         
       else
       {

        $("#pembayaran_penjualan").val('');
       $("#sisa_pembayaran_penjualan").val('');
       $("#kredit").val('');
        $("#piutang").hide();
        $("#batal_penjualan").hide();
        $("#penjualan").hide();
        $("#transaksi_baru").show();
        $("#total1").val('');

       $.post("proses_simpan_barang.php",{biaya_adm:biaya_adm,total2:total2,session_id:session_id,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,sales:sales,kode_gudang:kode_gudang,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input},function(info) {

        
            $("#table-baru").html(info);
            $("#alert_berhasil").show();
            $("#pembayaran_penjualan").val('');
            $("#sisa_pembayaran_penjualan").val('');
            $("#kredit").val('');
            $("#potongan_penjualan").val('');
            $("#potongan_persen").val('');
            $("#tanggal_jt").val('');
            $("#tax").val('');
            $("#kd_pelanggan").val('');
            $("#kd_pelanggan").trigger("chosen:open");
            $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"}); 
            $("#span_tbs").hide();
       
       
       });

       
       }  
       //mengambil no_faktur pembelian agar berurutan

       });
 $("form").submit(function(){
       return false;
       });

              $("#simpan_sementara").mouseleave(function(){
               
            
               var kode_pelanggan = $("#kd_pelanggan").val();
               if (kode_pelanggan == ""){
               $("#kd_pelanggan").attr("disabled", false);
               }
               
               });
  </script>    



        <script type="text/javascript">

$(document).ready(function(){

    $("#kd_pelanggan").change(function(){
        var kode_pelanggan = $("#kd_pelanggan").val();
        
        var level_harga = $(".opt-pelanggan-"+kode_pelanggan+"").attr("data-level");
        
        
        
        if(kode_pelanggan == 'Umum')
        {
           $("#level_harga").val('Level 1');
        }
        else 
        {
           $("#level_harga").val(level_harga);
        
        }
        
        
    });
});

          
        </script>

<script type="text/javascript">

  $(document).ready(function(){
    $(document).on('click','.edit-jumlah-jual',function(e){
      var kode_barang = $(this).attr("data-kode-barang-input");
      var tipe_produk = $('#opt-produk-'+kode_barang).attr("tipe_barang");
      
      $("#tipe_produk").val(tipe_produk);
    });
  });

</script>
                            <script type="text/javascript">
                                 
                                  $(document).on('dblclick','.edit-jumlah-jual',function(e){

                                    var id = $(this).attr("data-id");

                                    $("#text-jumlah-"+id+"").hide();

                                    $("#input-jumlah-"+id+"").attr("type", "text");

                                 });


                                     $(document).on('blur','.input_jumlah_jual',function(e){

                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).val()))));
                                   

                                    var kode_barang = $(this).attr("data-kode");
                                    var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-harga")))));
                                    var jumlah_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-jumlah-"+id+"").text()))));

                                    var satuan_konversi = $(this).attr("data-satuan");
                                    var ber_stok = $(this).attr("data-berstok");

                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));
                                    var tax_tbs = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
                                    var tax_fak = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));

                                    if (tax_fak == '')
                                    {
                                      tax_fak = 0;
                                    }

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
                                    var ppn = $("#ppn").val();
    //////////////////////PPN
              if (ppn == 'Exclude') {

                    var subtotal1 = parseFloat(harga.replace(',','.'),2) * parseFloat(jumlah_baru.replace(',','.'),2) - parseFloat(potongan.replace(',','.'),2);

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

                                    var subtotal_ex = parseFloat(subtotal_lama.replace(',','.'),2) - parseFloat(tax.replace(',','.'),2);

                                    var cari_tax = (parseFloat(tax.replace(',','.'),2) * 100) / parseFloat(subtotal_ex,2);


                                    var cari_tax1 = parseFloat(subtotal1,2) * parseFloat(cari_tax,2) / 100;

                                    var jumlah_tax = cari_tax1;

                                    var subtotal = parseFloat(subtotal1,2) + parseFloat(jumlah_tax,2);

                                     var subtotal_penjualan = parseFloat(subtotal_penjualan.replace(',','.'),2) - parseFloat(subtotal_lama.replace(',','.'),2) + subtotal;
                                    }
                                    else
                                    {

                                   var subtotal1 = parseFloat(harga.replace(',','.'),2) * parseFloat(jumlah_baru.replace(',','.'),2) - parseFloat(potongan.replace(',','.'),2);

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

                                      var cari_tax = parseFloat(subtotal_lama.replace(',','.'),2) - parseFloat(tax.replace(',','.'),2);
                                    var cari_tax1 = parseFloat(subtotal_lama.replace(',','.'),2) / parseFloat(cari_tax,2);

                                    var tax_ex = cari_tax1;

                                    var subtotal = subtotal1;
                                    var tax_ex1 = parseFloat(subtotal,2) / parseFloat(tax_ex,2);
                                    var tax_ex2 = parseFloat(subtotal,2) - parseFloat(tax_ex1,2);
                                    var jumlah_tax = tax_ex2;
                                    

                                    var subtotal_penjualan = parseFloat(subtotal_penjualan,2) - parseFloat(subtotal_lama.replace(',','.'),2) + parseFloat(subtotal,2);

                                    }
    ////////////////////////PPN
                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

                                    /*var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
                                    if(biaya_adm == '' || biaya_adm == 0,00)
                                    {
                                      biaya_adm = 0,00;
                                    }*/
                                   

                                subtotal_penjualan = parseFloat(subtotal_penjualan.replace(',','.'),2) - parseFloat(subtotal_lama.replace(',','.'),2) + parseFloat(subtotal,2);



                                     var potongan_persen = $("#potongan_persen").val();
                                      if (potongan_persen == '' || potongan_persen == 0,00)
                                    {
                                      potongan_persen = 0;
                                    }

                                    if (potongan_persen == 0)
                                    {
                                      potongaaan = 0,00;
                                    }
                                    else
                                    {
                                      potongaaan = parseFloat(subtotal_penjualan,2) * parseFloat(potongan_persen.replace(',','.'),2) / 100;
                                    }

                                    $("#potongan_penjualan").val(potongaaan.format(2, 3, '.', ','));
                                    
                                  
                                    var sub_total = parseFloat(subtotal_penjualan,2) - parseFloat(potongaaan,2);

                                    var tax_fakt = parseFloat(tax_fak.replace(',','.'),2) * parseFloat(sub_total,2) / 100;

                                    var pajak_faktur = tax_fakt;

                                    if (potongaaan == 0,00 )
                                    {
                                     var sub_akhir = (parseFloat(subtotal_penjualan,2));
                                    }
                                    else
                                    {
                                    var sub_akhir = parseFloat(subtotal_penjualan,2)  - parseFloat(potongaaan,2);
                                    }

  
                                    var jumlah_kirim = jumlah_baru.replace(',','.');
                                    var harga_kirim = harga.replace(',','.');


                          if (ber_stok == 'Jasa'){

                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_kirim);
                                    $("#btn-hapus-"+id+"").attr('data-subtotal', subtotal.format(2, 3, '.', ','));
                                    $("#text-subtotal-"+id+"").text(subtotal.format(2, 3, '.', ','));
                                    $("#text-tax-"+id+"").text(jumlah_tax.format(2, 3, '.', ','));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total2").val(subtotal_penjualan.format(2, 3, '.', ','));       
                                    $("#total1").val(sub_akhir.format(2, 3, '.', ','));
                                    $("#tax_rp").val(pajak_faktur.format(2, 3, '.', ',')); 

                      $.post("update_pesanan_barang.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(info){

                          //cek tbsbonus yang ada, tapi jumlah subtotal tbspenjualan sudah berubah syarat tidak terpenuhi
                          $.getJSON("cek_syarat_promo_ditbs.php",{kode_barang:kode_barang},function(syaratbonus){
                            /*var nama_produk = syaratbonus.nama_produk;
                            var kodenya = syaratbonus.kode_produk;
                            var idnya = syaratbonus.id;
                           
                          var subtotal_tbspenjualan = parseFloat(syaratbonus.tanggal);
                          var idtbsnya = parseFloat(syaratbonus.jam);
                          var subtotal = parseFloat(syaratbonus.satuan);
                          var syarat_free = parseFloat(syaratbonus.harga_disc);
                          var syarat_disc = parseFloat(syaratbonus.kode_pelanggan);
                          var keterangan = parseFloat(syaratbonus.keterangan);*/
                         
                             var subtotal_tbs_penjualan = syaratbonus.subtotal_tbs_penjualan
                            var syarat_promo_disc_produk = syaratbonus.syarat_promo_disc_produk;
                            var subtotal_tbs_penjualan_difree = syaratbonus.subtotal_tbs_penjualan_difree;
                            var syarat_promo_free = syaratbonus.syarat_promo_free;
                            var total_syarat_disc = syaratbonus.total_syarat_disc;
                            var kodenya = syaratbonus.kode_produk;
                            var idnya = syaratbonus.id;
                            var nama_produk = syaratbonus.nama_produk;

                            var total_syarat_free = subtotal_tbs_penjualan_difree - syarat_promo_free;
                            var total_syarat_disc = subtotal_tbs_penjualan - syarat_promo_disc_produk;
                            
                            if ((total_syarat_free <= 0) || (total_syarat_disc <= 0)) {
                            }
                            else{
                              
                                $("#modal_hapus_bonus_ditbs").modal('show');
                                $("#kode_produk_bonus").val(kodenya);
                                $("#nama_produk_bonus").val(nama_produk);
                                
                                $("#hapus_bonus_ditbs").click(function(){

                                  //menghapus jika syarat sudah tidak terpenuhi
                                    $.post("hapus_tbs_bonus_penjualan.php",{idnya:idnya,kodenya:kodenya},function(hapus){
                                      if (hapus == 1) {

                                          $('#table_tbs_bonus_penjualan').DataTable().destroy();
                                          var dataTable = $('#table_tbs_bonus_penjualan').DataTable( {
                                          "processing": true,
                                          "serverSide": true,
                                          "info":     false,
                                          "language": { "emptyTable":     "My Custom Message On Empty Table" },
                                          "ajax":{
                                            url :"datatable_tbs_bonus_penjualan.php", // json datasource
                                           
                                                type: "post",  // method  , by default get
                                            error: function(){  // error handling
                                              $(".tbody").html("");
                                              $("#table_tbs_bonus_penjualan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                                              $("#tableuser_processing").css("display","none");
                                              
                                            }
                                          }   

                                        });// end ajax bonus
                                      }
                                    });// end hapus_tbs_bonus_penjualan

                                });// end #modal_hapus_bonus_ditbs
                          }// end else nya  (idtbsnya > 0 && subtotal > syarat_free || subtotal_tbspenjualan > syarat_disc)
                        }); // end cek_syarat_promo_ditbs

                            // cek ada tidaknya promo hariini
                            $.post("cek_program_promo.php",{kode_barang:kode_barang},function(program){
                            if (program != 1) {
                              
                            }
                            else{
                              //mengambil id program
                              $.getJSON("cek_id_program_promo.php",function(oke){
                                
                              $("#disc_tbs").val(oke.potongan_tbs_penjualan);
                              var jenisbonus = oke.jenis_bonus;
          
                              if (jenisbonus == 'Free Produk') {
                                $("#id_program").val(oke.id_program);
                                //cek produk promo free produk
                                $.post("cek_promo_produk.php",{kode_barang:kode_barang},function(joya){
                                if (joya != 1) {
                                  
                                }
                                else{
                                    //$("#modal_promo_produk").modal('show');
                                    $("#modal_bonus_nya").modal('show');

                                    $('#table_produk_bonus').DataTable().destroy();

                                  var dataTable = $('#table_produk_bonus').DataTable( {
                                  "processing": true,
                                  "serverSide": true,
                                  
                                  "ajax":{
                                    url :"datatable_produk_bonus_free.php", // json datasource
                                   "data": function ( d ) {
                                              d.id_programnya = $("#id_program").val();
                                              // d.custom = $('#myInput').val();
                                              // etc
                                                },
                                    type: "post",  // method  , by default get
                                    error: function(){  // error handling
                                      $(".employee-grid-error").html("");
                                      $("#table_produk_bonus").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                      $("#employee-grid_processing").css("display","none");
                                    }
                                },
                                    
                                    "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                                      $(nRow).attr('class', "pilih_bonus");
                                      $(nRow).attr('data-kobon', aData[0]);
                                      $(nRow).attr('data-nabon', aData[1]);
                                      $(nRow).attr('data-program', aData[2]);
                                      $(nRow).attr('data-qty', aData[3]);
                                      $(nRow).attr('data-satuan', aData[4]);
                                      $(nRow).attr('data-harga', aData[5]);
                                      $(nRow).attr('data-id', aData[6]);

                                  },
                                });

                                $("#form").submit(function(){
                                return false;
                                });
                                }
                                });// end cek produk promo free produk

                              }

                              if (jenisbonus == 'Disc Produk'){
                                $("#id_program").val(oke.id_program);
                                //cek produk promo disc produk
                                $.post("cek_promo_produk_disc.php",{kode_barang:kode_barang},function(joyan){
                                if (joyan != 1) {
                                  
                                }
                                else{
                                    ////$("#modal_promo_produk_disc").modal('show');
                                    $("#modal_bonus_disc_nya").modal('show');
                                    $('#table_produk_bonus_disc').DataTable().destroy();
                                      var dataTable = $('#table_produk_bonus_disc').DataTable( {
                                      "processing": true,
                                      "serverSide": true,
                                      
                                      "ajax":{
                                        url :"datatable_produk_bonus_disc.php", // json datasource
                                       "data": function ( d ) {
                                                  d.id_programnya = $("#id_program").val();
                                                  // d.custom = $('#myInput').val();
                                                  // etc
                                                    },
                                        type: "post",  // method  , by default get
                                        error: function(){  // error handling
                                          $(".employee-grid-error").html("");
                                          $("#table_produk_bonus_disc").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                          $("#employee-grid_processing").css("display","none");
                                        }
                                    },
                                        
                                        "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                                          $(nRow).attr('class', "pilih_bonus_disc");
                                          $(nRow).attr('data-kobon', aData[0]);
                                          $(nRow).attr('data-nabon', aData[1]);
                                          $(nRow).attr('data-qty-max', aData[2]);
                                          $(nRow).attr('data-harga', aData[3]);
                                          $(nRow).attr('data-harga-normal', aData[4]);
                                          $(nRow).attr('data-program', aData[5]);
                                          $(nRow).attr('data-satuan', aData[6]);
                                          $(nRow).attr('data-id', aData[7]);

                                      },
                                    });
                                }
                                });// end cek produk promo disc produk
                              }
                            });// end cek_program_promo
                            }
                          });// end cek_id_program_promo

                        });   // end update_pesanan_barang.php     
                            }

                          else{

                              $.post("cek_stok_pesanan_barang.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru,satuan_konversi:satuan_konversi},function(data){
                                       if (data < 0) {

                                       alert ("Jumlah Yang Di Masukan Melebihi Stok !");

                                    $("#input-jumlah-"+id+"").val(jumlah_lama.format(2, 3, '.', ','));
                                    $("#text-jumlah-"+id+"").text(jumlah_lama.format(2, 3, '.', ','));
                                    $("#text-jumlah-"+id+"").show();
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");
                                    
                                     }

                                      else{



                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text('');
                                    $("#text-jumlah-"+id+"").text(jumlah_kirim);
                                    $("#btn-hapus-"+id+"").attr('data-subtotal', subtotal.format(2, 3, '.', ','));
                                    $("#text-subtotal-"+id+"").text(subtotal.format(2, 3, '.', ','));
                                    $("#text-tax-"+id+"").text(jumlah_tax.format(2, 3, '.', ','));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total2").val(subtotal_penjualan.format(2, 3, '.', ','));       
                                    $("#total1").val(sub_akhir.format(2, 3, '.', ','));    
                                    $("#tax_rp").val(pajak_faktur.format(2, 3, '.', ','));  

                                     $.post("update_pesanan_barang.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_kirim,kode_barang:kode_barang,potongan:potongan,harga:harga_kirim,jumlah_tax:jumlah_tax,subtotal:subtotal},function(info){

                                              //cek tbsbonus yang ada, tapi jumlah subtotal tbspenjualan sudah berubah syarat tidak terpenuhi
                                              $.getJSON("cek_syarat_promo_ditbs.php",{kode_barang:kode_barang},function(syaratbonus){
                                                /*var nama_produk = syaratbonus.nama_produk;
                                                var kodenya = syaratbonus.kode_produk;
                                                var idnya = syaratbonus.id;
                                               
                                              var subtotal_tbspenjualan = parseFloat(syaratbonus.tanggal);
                                              var idtbsnya = parseFloat(syaratbonus.jam);
                                              var subtotal = parseFloat(syaratbonus.satuan);
                                              var syarat_free = parseFloat(syaratbonus.harga_disc);
                                              var syarat_disc = parseFloat(syaratbonus.kode_pelanggan);
                                              var keterangan = parseFloat(syaratbonus.keterangan);*/
                                             
                                                 var subtotal_tbs_penjualan = syaratbonus.subtotal_tbs_penjualan
                                                  var syarat_promo_disc_produk = syaratbonus.syarat_promo_disc_produk;
                                                  var subtotal_tbs_penjualan_difree = syaratbonus.subtotal_tbs_penjualan_difree;
                                                  var syarat_promo_free = syaratbonus.syarat_promo_free;
                                                 var total_syarat_disc = syaratbonus.total_syarat_disc;
                                                 var kodenya = syaratbonus.kode_produk;
                                                 var idnya = syaratbonus.id;
                                                 var nama_produk = syaratbonus.nama_produk;

                                                 var total_syarat_free = subtotal_tbs_penjualan_difree - syarat_promo_free;
                                                  var total_syarat_disc = subtotal_tbs_penjualan - syarat_promo_disc_produk;
                                                
                                                if ((total_syarat_free <= 0) || (total_syarat_disc <= 0)) {
                                                }
                                                else{
                                                  
                                                    $("#modal_hapus_bonus_ditbs").modal('show');
                                                    $("#kode_produk_bonus").val(kodenya);
                                                    $("#nama_produk_bonus").val(nama_produk);
                                                    
                                                    $("#hapus_bonus_ditbs").click(function(){

                                                      //menghapus jika syarat sudah tidak terpenuhi
                                                        $.post("hapus_tbs_bonus_penjualan.php",{idnya:idnya,kodenya:kodenya},function(hapus){
                                                          if (hapus == 1) {

                                                              $('#table_tbs_bonus_penjualan').DataTable().destroy();
                                                              var dataTable = $('#table_tbs_bonus_penjualan').DataTable( {
                                                              "processing": true,
                                                              "serverSide": true,
                                                              "info":     false,
                                                              "language": { "emptyTable":     "My Custom Message On Empty Table" },
                                                              "ajax":{
                                                                url :"datatable_tbs_bonus_penjualan.php", // json datasource
                                                               
                                                                    type: "post",  // method  , by default get
                                                                error: function(){  // error handling
                                                                  $(".tbody").html("");
                                                                  $("#table_tbs_bonus_penjualan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                                                                  $("#tableuser_processing").css("display","none");
                                                                  
                                                                }
                                                              }   

                                                            });// end ajax bonus
                                                          }
                                                        });// end hapus_tbs_bonus_penjualan

                                                    });// end #modal_hapus_bonus_ditbs
                                              }// end else nya  (idtbsnya > 0 && subtotal > syarat_free || subtotal_tbspenjualan > syarat_disc)
                                            }); // end cek_syarat_promo_ditbs

                                                // cek ada tidaknya promo hariini
                                                $.post("cek_program_promo.php",{kode_barang:kode_barang},function(program){
                                                if (program != 1) {
                                                  
                                                }
                                                else{
                                                  //mengambil id program
                                                  $.getJSON("cek_id_program_promo.php",function(oke){
                                                    
                                                  $("#disc_tbs").val(oke.potongan_tbs_penjualan);
                                                  var jenisbonus = oke.jenis_bonus;
          
                                                  if (jenisbonus == 'Free Produk') {
                                                    $("#id_program").val(oke.id_program);
                                                    //cek produk promo free produk
                                                    $.post("cek_promo_produk.php",{kode_barang:kode_barang},function(joya){
                                                    if (joya != 1) {
                                                      
                                                    }
                                                    else{
                                                        //$("#modal_promo_produk").modal('show');
                                                        $("#modal_bonus_nya").modal('show');

                                                        $('#table_produk_bonus').DataTable().destroy();

                                                      var dataTable = $('#table_produk_bonus').DataTable( {
                                                      "processing": true,
                                                      "serverSide": true,
                                                      
                                                      "ajax":{
                                                        url :"datatable_produk_bonus_free.php", // json datasource
                                                       "data": function ( d ) {
                                                                  d.id_programnya = $("#id_program").val();
                                                                  // d.custom = $('#myInput').val();
                                                                  // etc
                                                                    },
                                                        type: "post",  // method  , by default get
                                                        error: function(){  // error handling
                                                          $(".employee-grid-error").html("");
                                                          $("#table_produk_bonus").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                                          $("#employee-grid_processing").css("display","none");
                                                        }
                                                    },
                                                        
                                                        "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                                                          $(nRow).attr('class', "pilih_bonus");
                                                          $(nRow).attr('data-kobon', aData[0]);
                                                          $(nRow).attr('data-nabon', aData[1]);
                                                          $(nRow).attr('data-program', aData[2]);
                                                          $(nRow).attr('data-qty', aData[3]);
                                                          $(nRow).attr('data-satuan', aData[4]);
                                                          $(nRow).attr('data-harga', aData[5]);
                                                          $(nRow).attr('data-id', aData[6]);

                                                      },
                                                    });

                                                    $("#form").submit(function(){
                                                    return false;
                                                    });
                                                    }
                                                    });// end cek produk promo free produk

                                                  }
                                                  
                                                   if (jenisbonus == 'Disc Produk'){
                                                    $("#id_program").val(oke.id_program);
                                                    //cek produk promo disc produk
                                                    $.post("cek_promo_produk_disc.php",{kode_barang:kode_barang},function(joyan){
                                                    if (joyan != 1) {
                                                      
                                                    }
                                                    else{
                                                        ////$("#modal_promo_produk_disc").modal('show');
                                                        $("#modal_bonus_disc_nya").modal('show');
                                                        $('#table_produk_bonus_disc').DataTable().destroy();
                                                          var dataTable = $('#table_produk_bonus_disc').DataTable( {
                                                          "processing": true,
                                                          "serverSide": true,
                                                          
                                                          "ajax":{
                                                            url :"datatable_produk_bonus_disc.php", // json datasource
                                                           "data": function ( d ) {
                                                                      d.id_programnya = $("#id_program").val();
                                                                      // d.custom = $('#myInput').val();
                                                                      // etc
                                                                        },
                                                            type: "post",  // method  , by default get
                                                            error: function(){  // error handling
                                                              $(".employee-grid-error").html("");
                                                              $("#table_produk_bonus_disc").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                                              $("#employee-grid_processing").css("display","none");
                                                            }
                                                        },
                                                            
                                                            "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                                                              $(nRow).attr('class', "pilih_bonus_disc");
                                                              $(nRow).attr('data-kobon', aData[0]);
                                                              $(nRow).attr('data-nabon', aData[1]);
                                                              $(nRow).attr('data-qty-max', aData[2]);
                                                              $(nRow).attr('data-harga', aData[3]);
                                                              $(nRow).attr('data-harga-normal', aData[4]);
                                                              $(nRow).attr('data-program', aData[5]);
                                                              $(nRow).attr('data-satuan', aData[6]);
                                                              $(nRow).attr('data-id', aData[7]);

                                                          },
                                                        });
                                                    }
                                                    });// end cek produk promo disc produk
                                                  }
                                                });// end cek_program_promo
                                                }
                                              });// end cek_id_program_promo
                                    
                                         


                                    }); // end update_pesanan_barang.php

                                   }



                                 });

                            }
       
                                    $("#kode_barang").focus();
                                    

                                 });

                             </script>


<script type="text/javascript">
    $(document).ready(function(){


      /*$("#tax").attr("disabled", true);*/

    // cek ppn exclude 
    var session_id = $("#session_id").val();
    $.get("cek_ppn_ex_jual.php",{session_id:session_id},function(data){
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
<!--PPN LAMA<script type="text/javascript">
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
    $("#tax1").attr("disabled", false);
      $("#tax").attr("disabled", false);
  }
  else{

    $("#tax1").attr("disabled", true);
      $("#tax").attr("disabled", true);
  }


  });
  });
</script>PPN LAMA-->

<script type="text/javascript">
$(document).ready(function(){
  $("#batal_penjualan").click(function(){
    var session_id = $("#session_id").val()
        window.location.href="batal_penjualan.php?session_id="+session_id+"";

  })
  });
</script>

<!-- SHORTCUT -->

<script> 
    shortcut.add("f2", function() {
        // Do something

        $("#kode_barang").focus();

    });

    
    shortcut.add("f1", function() {
        // Do something

        $("#cari_produk_penjualan").click();

    }); 

    shortcut.add("f6", function() {
        // Do something

        $("#daftar_order").click();

    }); 
    
    shortcut.add("f3", function() {
        // Do something

        $("#submit_produk").click();

    }); 

    
    shortcut.add("f4", function() {
        // Do something

        $("#carabayar1").focus();

    }); 

    
    shortcut.add("f7", function() {
        // Do something

        $("#pembayaran_penjualan").focus();

    }); 

    
    shortcut.add("f8", function() {
        // Do something

        $("#penjualan").click();

    }); 

    
    shortcut.add("f9", function() {
        // Do something

        $("#piutang").click();

    }); 

    
    shortcut.add("f10", function() {
        // Do something

        $("#simpan_sementara").click();

    }); 

        shortcut.add("ctrl+g", function() {
        // Do something

        $("#closed_alert_promo").click();

    });

  shortcut.add("alt+p", function() {
        // Do something

        $("#daftar_parcel").click();

    });


        shortcut.add("ctrl+m", function() {
        // Do something

        $("#transaksi_baru").click();

    }); 
    
    shortcut.add("ctrl+b", function() {
        // Do something

    var session_id = $("#session_id").val()

        window.location.href="batal_penjualan.php?session_id="+session_id+"";


    }); 

     shortcut.add("ctrl+k", function() {
        // Do something

        $("#cetak_langsung").click();


    }); 

     shortcut.add("alt+o", function() {
        // Do something

        $("#openCashDrawer").click();


    }); 
</script>

<!-- SHORTCUT -->


<script type="text/javascript">
// START script untuk pilih kode barang menggunakan chosen     
  $(document).ready(function(){
  $("#kode_barang").change(function(){

    var kode_barang = $(this).val();
    var nama_barang = $('#opt-produk-'+kode_barang).attr("nama-barang");
    var harga_jual = $('#opt-produk-'+kode_barang).attr("harga");
    var harga_jual2 = $('#opt-produk-'+kode_barang).attr('harga_jual_2');  
    var harga_jual3 = $('#opt-produk-'+kode_barang).attr('harga_jual_3');
    var harga_jual4 = $('#opt-produk-'+kode_barang).attr('harga_jual_4');
    var harga_jual5 = $('#opt-produk-'+kode_barang).attr('harga_jual_5');  
    var harga_jual6 = $('#opt-produk-'+kode_barang).attr('harga_jual_6');
    var harga_jual7 = $('#opt-produk-'+kode_barang).attr('harga_jual_7');
    var jumlah_barang = $('#opt-produk-'+kode_barang).attr("jumlah-barang");
    var satuan = $('#opt-produk-'+kode_barang).attr("satuan");
    var kategori = $('#opt-produk-'+kode_barang).attr("kategori");
    var status = $('#opt-produk-'+kode_barang).attr("status");
    var suplier = $('#opt-produk-'+kode_barang).attr("suplier");
    var limit_stok = $('#opt-produk-'+kode_barang).attr("limit_stok");
    var ber_stok = $('#opt-produk-'+kode_barang).attr("ber-stok");
    var tipe_produk = $('#opt-produk-'+kode_barang).attr("tipe_barang");
    var id_barang = $('#opt-produk-'+kode_barang).attr("id-barang");
    var level_harga = $("#level_harga").val();

$.post("lihat_promo_alert.php",{id_barang:id_barang},function(data){

    if (data.promo == null)
    {

    }
    else{
      $("#modal_promo_alert").modal('show');
      $("#tampil_alert").html(data.promo);
    }

    console.log(data.promo);

});


   if (level_harga == "harga_1") {

        $('#harga_produk').val(harga_jual);
        $('#harga_baru').val(harga_jual);
        $('#harga_lama').val(harga_jual);
        $('#kolom_cek_harga').val('1');
        }
    else if (level_harga == "harga_2") {

        $('#harga_produk').val(harga_jual2);
        $('#harga_baru').val(harga_jual2);
        $('#harga_lama').val(harga_jual2);
        $('#kolom_cek_harga').val('1');
        }
    else if (level_harga == "harga_3") {

        $('#harga_produk').val(harga_jual3);
        $('#harga_baru').val(harga_jual3);
        $('#harga_lama').val(harga_jual3);
        $('#kolom_cek_harga').val('1');
        }
    else if (level_harga == "harga_4") {

        $('#harga_produk').val(harga_jual4);
        $('#harga_baru').val(harga_jual4);
        $('#harga_lama').val(harga_jual4);
        $('#kolom_cek_harga').val('1');
        }
    else if (level_harga == "harga_5") {

        $('#harga_produk').val(harga_jual5);
        $('#harga_baru').val(harga_jual5);
        $('#harga_lama').val(harga_jual5);
        $('#kolom_cek_harga').val('1');
        }
    else if (level_harga == "harga_6") {

        $('#harga_produk').val(harga_jual6);
        $('#harga_baru').val(harga_jual6);
        $('#harga_lama').val(harga_jual6);
        $('#kolom_cek_harga').val('1');
        }
    else if (level_harga == "harga_7") {

        $('#harga_produk').val(harga_jual7);
        $('#harga_baru').val(harga_jual7);
        $('#harga_lama').val(harga_jual7);
        $('#kolom_cek_harga').val('1');
        }



    $("#tipe_produk").val(tipe_produk);
    $("#kode_barang").val(kode_barang);
    $("#nama_barang").val(nama_barang);
    $("#jumlah_barang").val(jumlah_barang);
    $("#satuan_produk").val(satuan);
    $("#satuan_konversi").val(satuan);
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


$.post('cek_kode_barang_tbs_penjualan.php',{kode_barang:kode_barang}, function(data){
          
  if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

          $("#kode_barang").chosen("destroy");
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
   }//penutup if     



  });

    

  });
  }); 
  // end script untuk pilih kode barang menggunakan chosen   
</script>

<script>
//Choosen Open select
$(document).ready(function(){
    $("#kode_barang").trigger('chosen:open');

});
</script>



<!--START TWO (2) SCRIPT UNTUK ALERT STAY/LEAVE PAGE-->
<script type="text/javascript">
  $(window).bind('beforeunload', function(){
  return 'Apakah Yakin Ingin Meninggalkan Halaman Ini ? Karena Akan Membutuhkan Beberapa Waktu Untuk Membuka Kembali Halaman Ini!';
});
</script>

<script type="text/javascript">
  $(document).ready(function(){

function getUrl(sParam) {
      var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');

    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return decodeURIComponent(sParameterName[1]);
        }
    }
}
});
</script>
<!--ENDING TWO (2) SCRIPT UNTUK ALERT STAY/LEAVE PAGE-->




<script type="text/javascript">
//Transaksi Baru untuk table modal cari produk di perbarui dan juga tbsnya di kosongin

  $(document).ready(function(){
    $(document).on('click','#transaksi_baru',function(e){

// pengambilan select untuk no_faktur order
$.get("ambil_select_order.php",function(data){
  $("#select_order").html(data);
  });
// pengambilan select untuk no_faktur order



// Table TBS KOSONG
$('#tabel_tbs_penjualan').DataTable().destroy();
      var dataTable = $('#tabel_tbs_penjualan').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"data_tbs_penjualan.php", // json datasource
             
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_penjualan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
// tbs penjualan kossong


// ambil datatable tbs order yang terbaru
      $('#table_tbs_order').DataTable().destroy();
          var dataTable = $('#table_tbs_order').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_tbs_order.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_tbs_order").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },      
    });
// ambil datatable tbs order yang terbaru


// Table Modal Cari Produk Di Perbarui
       $('#tabel_cari').DataTable().destroy();
        var dataTable = $('#tabel_cari').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_jual_baru.php", // json datasource
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
              $(nRow).attr('harga', aData[2]);
              $(nRow).attr('harga_level_2', aData[3]);
              $(nRow).attr('harga_level_3', aData[4]);
              $(nRow).attr('harga_level_4', aData[5]);
              $(nRow).attr('harga_level_5', aData[6]);
              $(nRow).attr('harga_level_6', aData[7]);
              $(nRow).attr('harga_level_7', aData[8]);
              $(nRow).attr('jumlah-barang', aData[9]);
              $(nRow).attr('satuan', aData[17]);
              $(nRow).attr('kategori', aData[11]);
              $(nRow).attr('status', aData[16]);
              $(nRow).attr('suplier', aData[12]);
              $(nRow).attr('limit_stok', aData[13]);
              $(nRow).attr('ber-stok', aData[14]);
              $(nRow).attr('tipe_barang', aData[15]);
              $(nRow).attr('id-barang', aData[18]);

          }

        }); 


            $("#pembayaran_penjualan").val('');
            $("#sisa_pembayaran_penjualan").val('');
            $("#kredit").val('');
            $("#potongan_penjualan").val('');
            $("#potongan_persen").val('');
            $("#tanggal_jt").val('');
            $("#total2").val('');
            $("#total1").val('');
            $("#biaya_admin_select").val('0');
            $("#biaya_admin_select").trigger("chosen:updated");
            $("#biaya_admin_persen").val(''); 
            $("#kode_barang").val('');
            $("#kd_pelanggan").val('');
            $("#kd_pelanggan").trigger("chosen:open");
            $("#biaya_adm").val('');
            $("#level_harga").val('harga_1');
            $("#keterangan").val('');
            $("#penjualan").show();
            $("#cetak_langsung").hide();
            $("#simpan_sementara").show();
            $("#piutang").show();
            $("#batal_penjualan").show(); 
            $("#transaksi_baru").hide();
            $("#alert_berhasil").hide();
            $("#alert_simpan_berhasil").hide();
            $("#cetak_tunai").hide();
            $("#cetak_tunai_besar").hide();
            $("#cetak_piutang").hide();
            $("#cetak_tunai_kategori").hide(); 
            $('#span_tbs').show();

            
     $("#level_harga").attr("disabled", false);
      $("#ppn").attr("disabled", false);
           $("#kd_pelanggan").attr("disabled", false);

            var url = window.location.href;
             url = getPathFromUrl(url);
            history.pushState('', 'Toko',  url);

            function getPathFromUrl(url) {
              return url.split("?")[0];
            }




       });
    
  });

</script>


<script type="text/javascript">
     function tutupmodal() {
      $("#modal_cash_drawer").modal("hide")
     }
     function tutupalert() {
      $(".alert-gagal").hide("fast")
     }  
</script>


<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click','#openCashDrawer',function(){
      $("#modal_cash_drawer").modal('show');
    });

    $("#btnLogin").click(function(){
      var username = $("#username").val();
      var password = $("#password").val();

      $.post('proses_open_cash_drawer.php',{username:username,password:password},function(data){

        if (data != 0) {

          var win = window.open('open_cash_drawer.php');
           if (win) {    
            win.focus(); 
           }
           else {    
            alert('Mohon Izinkan PopUps Pada Website Ini !');
            }


          setTimeout(tutupmodal, 2000);

        }
        else{
        
          $(".alert-gagal").show();
          setTimeout(tutupalert, 2000);
          $("#username").val('');
          $("#password").val('');
        }
    });

   });

});

</script>

<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>