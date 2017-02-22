<?php include_once 'session_login.php';
 

// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

 
// menampilkan seluruh data yang ada pada tabel penjualan yang terdapt pada DB
 $perintah = $db->query("SELECT * FROM penjualan");


$session_id = session_id();





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

<!--untuk membuat agar tampilan form terlihat rapih dalam satu tempat -->
 <div class="container">

<!--membuat agar tabel berada dalam baris tertentu-->
 <div class="row">


 <!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="formpenjualan.php" method="post ">
        
  <!--membuat teks dengan ukuran h3-->      
  <h3> Tambah Data Penjualan </h3><br>

        <div class="form-group"><br>
        <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo session_id(); ?>" readonly="" >
        </div>

<div class="form-group  col-sm-3">
    <label> Kode Pelanggan </label><br>
  <select name="kode_pelanggan" id="kd_pelanggan" class="form-control chosen" required="" autofocus="">
 
          
  <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query = $db->query("SELECT * FROM pelanggan");

    //untuk menyimpan data sementara yang ada pada $query
    while($data = mysqli_fetch_array($query))
    {
    
    echo "<option value='".$data['kode_pelanggan'] ."' class='opt-pelanggan-".$data['kode_pelanggan']."' data-level='".$data['level_harga'] ."'>".$data['kode_pelanggan'] ." - ".$data['nama_pelanggan'] ."</option>";
    }
    
    
    ?>
    </select>
    </div>
    

<div class="form-group  col-sm-3">
          <label> Gudang </label><br>
          
          <select name="kode_gudang" id="kode_gudang" class="form-control chosen" required="" >
          <?php 
          
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM gudang");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";
          }
          
          
          ?>
          </select>
</div>

<div class="form-group  col-sm-3">
    <label> Level Harga </label><br>
  <select type="text" name="level_harga" id="level_harga" class="form-control" required="" >
  <option>Level 1</option>
  <option>Level 2</option>
  <option>Level 3</option>

    </select>
    </div>


<div class="form-group  col-sm-3">
<label>Sales</label>
<select name="sales" id="sales" class="form-control" required="">

  <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama FROM user WHERE status_sales = 'Iya'");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {
    
    echo "<option value='".$data01['nama'] ."'>".$data01['nama'] ."</option>";
    }
    
    
    ?>

</select>
</div>

  </form><!--tag penutup form-->


<br><br><br><br><br>
<button type="button" id="cari_produk_penjualan" class="btn btn-info " data-toggle="modal" data-target="#myModal"><span class='glyphicon glyphicon-search'> </span> Cari </button>
<br><br>

<!--tampilan modal-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- isi modal-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Barang</h4>
      </div>
      <div class="modal-body">

      <div class="table-resposive">
<span class="modal_baru">
      <!-- membuat agar ada garis pada tabel, disetiap kolom-->
      <table id="tableuser" class="table table-bordered">
        <thead> <!-- untuk memberikan nama pada kolom tabel -->
        
        <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Harga Beli </th>
            <th> Harga Jual Level 1</th>
            <th> Harga Jual Level 2</th>
            <th> Harga Jual Level 3</th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>
            <th> Kategori </th>
            <th> Status </th>
            <th> Suplier </th>
        
        </thead> <!-- tag penutup tabel -->
        
        <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
<?php


        
        $perintah = $db->query("SELECT * FROM barang");
        
        while ($data1 = mysqli_fetch_array($perintah))
        {


       
// mencari jumlah Barang
            $query0 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_pembelian FROM detail_pembelian WHERE kode_barang = '$data1[kode_barang]'");
            $cek0 = mysqli_fetch_array($query0);
            $jumlah_pembelian = $cek0['jumlah_pembelian'];

            $query1 = $db->query("SELECT SUM(jumlah) AS jumlah_item_masuk FROM detail_item_masuk WHERE kode_barang = '$data1[kode_barang]'");
            $cek1 = mysqli_fetch_array($query1);
            $jumlah_item_masuk = $cek1['jumlah_item_masuk'];

            $query2 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_penjualan FROM detail_retur_penjualan WHERE kode_barang = '$data1[kode_barang]'");
            $cek2 = mysqli_fetch_array($query2);
            $jumlah_retur_penjualan = $cek2['jumlah_retur_penjualan'];

            $query20 = $db->query("SELECT SUM(jumlah_awal) AS jumlah_stok_awal FROM stok_awal WHERE kode_barang = '$data1[kode_barang]'");
            $cek20 = mysqli_fetch_array($query20);
            $jumlah_stok_awal = $cek20['jumlah_stok_awal'];

            $query200 = $db->query("SELECT SUM(selisih_fisik) AS jumlah_fisik FROM detail_stok_opname WHERE kode_barang = '$data1[kode_barang]'");
            $cek200 = mysqli_fetch_array($query200);
            $jumlah_fisik = $cek200['jumlah_fisik'];
//total barang 1
            $total_1 = $jumlah_pembelian + $jumlah_item_masuk + $jumlah_retur_penjualan + $jumlah_stok_awal + $jumlah_fisik;


 

            $query3 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_penjualan FROM detail_penjualan WHERE kode_barang = '$data1[kode_barang]'");
            $cek3 = mysqli_fetch_array($query3);
            $jumlah_penjualan = $cek3['jumlah_penjualan'];


            $query4 = $db->query("SELECT SUM(jumlah) AS jumlah_item_keluar FROM detail_item_keluar WHERE kode_barang = '$data1[kode_barang]'");
            $cek4 = mysqli_fetch_array($query4);
            $jumlah_item_keluar = $cek4['jumlah_item_keluar'];

            $query5 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_pembelian FROM detail_retur_pembelian WHERE kode_barang = '$data1[kode_barang]'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_retur_pembelian = $cek5['jumlah_retur_pembelian'];


 



//total barang 2
            $total_2 = $jumlah_penjualan + $jumlah_item_keluar + $jumlah_retur_pembelian;



            $stok_barang = $total_1 - $total_2;

        
        // menampilkan data
        echo "<tr class='pilih' data-kode='". $data1['kode_barang'] ."' nama-barang='". $data1['nama_barang'] ."' limit_stok='". $data1['limit_stok'] ."'
        satuan='". $data1['satuan'] ."' harga='". $data1['harga_jual'] ."' harga_level_2='". $data1['harga_jual2'] ."'  harga_level_3='". $data1['harga_jual3'] ."' jumlah-barang='". $stok_barang ."' ber-stok='". $data1['berkaitan_dgn_stok'] ."'>
        
            <td>". $data1['kode_barang'] ."</td>
            <td>". $data1['nama_barang'] ."</td>
            <td>". rp($data1['harga_beli']) ."</td>
            <td>". rp($data1['harga_jual']) ."</td>
            <td>". rp($data1['harga_jual2']) ."</td>
            <td>". rp($data1['harga_jual3']) ."</td>
            <td>". $stok_barang ."</td>
            <td>". $data1['satuan'] ."</td>
            <td>". $data1['kategori'] ."</td>
            <td>". $data1['status'] ."</td>
            <td>". $data1['suplier'] ."</td>
            </tr>";
      
         }

?>
    
        </tbody> <!--tag penutup tbody-->
        
        </table> <!-- tag penutup table-->
  </span>
</div>
</div> <!-- tag penutup modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal data barang  -->



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
<form class="form-inline"  role="form" id="formtambahproduk">
  
  <div class="form-group">
  <input type="text" class="form-control" name="kode_barang" id="kode_barang" autocomplete="off" accesskey="k" placeholder="Kode Produk">
  </div>

  <div class="form-group">
  <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" readonly="">
  </div>

  <div class="form-group">
    <input type="hidden" class="form-control" name="limit_stok" autocomplete="off" id="limit_stok" placeholder="Limit Stok" >
  </div>
   
  <div class="form-group">
    <input type="number" class="form-control" name="jumlah_barang" autocomplete="off" id="jumlah_barang" placeholder="Jumlah Barang" >
  </div>

   <div class="form-group">
    <input type="text" class="form-control" name="potongan" autocomplete="off" id="potongan1" data-toggle="tooltip" data-placement="top" title="Jika Ingin Potongan Dalam Bentuk Persen (%), input : 10%" placeholder="Potongan" >
  </div>

   <div class="form-group">
    <input type="hidden" class="form-control" name="tax" autocomplete="off" id="tax1" placeholder="Tax" >
  </div>


    <input type="hidden" class="form-control" name="ber_stok" id="ber_stok" placeholder="Ber Stok" >
  
  <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">
  <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
  <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" required="">        
  <button type="submit" id="submit_produk" class="btn btn-success"> <span class='glyphicon glyphicon-plus'> </span> Tambah</button>
</div>
</form> <!-- tag penutup form --><br><br>




  

                <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
   <span id='tes'></span>            
                
                <div class="table-responsive"> <!--tag untuk membuat garis pada tabel-->  
                <span id="table-baru">  
                <table id="tableuser" class="table table-bordered">
                <thead>
                <th> Kode Barang </th>
                <th> Nama Barang </th>
                <th> Jumlah Barang </th>
                <th> Satuan </th>
                <th> Harga </th>
                <th> Subtotal </th>
                <th> Potongan </th>
                
                <th> Hapus </th>
                
                </thead>
                
                <tbody id="tbody">
                <?php
                
                //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT * FROM tbs_penjualan
                WHERE session_id = '$session_id'");
                
                //menyimpan data sementara yang ada pada $perintah
                
                while ($data1 = mysqli_fetch_array($perintah))
                {
                //menampilkan data
                echo "<tr class='tr-kode-". $data1['kode_barang'] ." tr-id-". $data1['id'] ."' data-kode-barang='".$data1['kode_barang']."'>
                <td>". $data1['kode_barang'] ."</td>
                <td>". $data1['nama_barang'] ."</td>
                <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' > </td>
                <td>". $data1['satuan'] ."</td>
                <td>". rp($data1['harga']) ."</td>
                <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
                <td><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</td>";

               echo "<td> <button class='btn btn-danger btn-hapus-tbs' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 

                </tr>";


                }

                ?>
                </tbody>
                
                </table>
                </span>
                </div>
                




    <form action="proses_bayar_jual.php" id="form_jual" method="POST" >
    
    <style type="text/css">
    .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: false;
    }
    </style>

          <br>

<div class="form-group col-sm-4 col-xs-4">
      <label> Subtotal </label><br>
      <input type="text" name="total" id="total2" class="form-control" placeholder="Total" readonly="" >
      <label> Cara Bayar </label><br>
          <select type="text" name="cara_bayar" id="carabayar1" class="form-control" required=""  style="font-size: 16px" >
          <option value=""> Silahkan Pilih </option>
          <?php 
          
          
          $query = $db->query("SELECT * FROM kas ");
          while($data = mysqli_fetch_array($query))
          {
           if ($data['status'] == 'Ya') {
             

            echo "<option selected>".$data['nama'] ."</option>";

           }
            else{

              echo "<option>".$data['nama'] ."</option>";
            }     
          

            
          
          }
          
          
          ?>
          
          </select>

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
          
          <label> Diskon ( Rp )</label><br>
          <input type="text" name="potongan" id="potongan_penjualan" value="<?php echo intval($diskon); ?>" class="form-control" placeholder="" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">

          <label> Diskon ( % )</label><br>
          <input type="text" name="potongan_persen" id="potongan_persen" value="<?php echo intval($diskon_p); ?>" class="form-control" placeholder="" autocomplete="off" >
          

          <?php  }
            else{
            $diskon = $data_diskon['diskon_persen'];
            
            $diskon_n = $total_bener /  100 * $diskon;
            
            
            
            ?>


          <label> Diskon ( Rp )</label><br>
          <input type="text" name="potongan" id="potongan_penjualan" value="<?php echo intval($diskon_n); ?>" class="form-control" placeholder="" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" >

          <label> Diskon ( % )</label><br>
          <input type="text" name="potongan_persen" id="potongan_persen" value="<?php echo intval($diskon); ?>" class="form-control" placeholder="" autocomplete="off" >
         
<?php
          }


           ?>

           <label> Pajak </label><br>
          <input type="text" name="tax" id="tax" value="<?php echo $data_diskon['tax']; ?>" class="form-control"  autocomplete="off" >

          <input type="hidden" name="tax_rp" id="tax_rp" class="form-control"  autocomplete="off" >

           <label style="display: none"> Adm Bank  (%)</label>
          <input type="hidden" name="adm_bank" id="adm_bank"  value="" class="form-control" >
          
          <label> Tanggal Jatuh Tempo </label><br>
          <input type="text" name="tanggal_jt" id="tanggal_jt"  value="" class="form-control" >
          
          <label> Keterangan </label><br>
          <textarea type="text" name="keterangan" id="keterangan" class="form-control"> 
          </textarea>
          </div>


          <div class="form-group col-sm-4 col-xs-4">
          <label style="font-size:15px"> Total </label><br>
          <b><input type="text" name="total" id="total1" class="form-control" style="height: 50px; width:90%; font-size:25px;" placeholder="Total" readonly="" ></b>

          <label> Pembayaran </label><br>
          <b><input type="text" name="pembayaran" id="pembayaran_penjualan" style="height: 50px; width:90%; font-size:25px;" autocomplete="off" class="form-control"   style="font-size: 20px"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"></b>


          <label> Kembalian </label><br>
          <b><input type="text" name="sisa_pembayaran" id="sisa_pembayaran_penjualan" style="height: 50px; width:90%; font-size:25px;" class="form-control"  readonly="" required=""  style="font-size: 20px" ></b>
          


         
          <label> Kredit </label><br>
          <b><input type="text" name="kredit" id="kredit" class="form-control" style="height: 50px; width:90%; font-size:25px;"  readonly="" required="" ></b>

<?php 

if ($_SESSION['otoritas'] == 'Pimpinan') {
 echo '<label style="display:none"> Total Hpp </label><br>
          <input type="hidden" name="total_hpp" id="total_hpp" style="height: 50px; width:90%; font-size:25px;" class="form-control" placeholder="" readonly="" required="">';
}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>



</div>



          
          
          <input type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah">   <br> 
          
          
          <!-- memasukan teks pada kolom kode pelanggan, dan nomor faktur penjualan namun disembunyikan -->

          
          <input type="hidden" name="kode_pelanggan" id="k_pelanggan" class="form-control" required="" >
          
          <br>
          <br>
          <br>
         

          
          <div class="col-sm-12 col-xs-12"><br>
          <button type="submit" id="penjualan" class="btn btn-info">Bayar</button>
          <a class="btn btn-primary" href="formpenjualan.php" id="transaksi_baru" style="display: none"> Transaksi Baru</a>
          <button type="submit" id="simpan_sementara" class="btn btn-primary"> Simpan </button>
          <button type="submit" id="piutang" class="btn btn-warning">Piutang</button>
          <a href='batal_penjualan.php?session_id=<?php echo $session_id;?>' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span> Batal </a>
 
          <a href='cetak_penjualan_tunai.php' id="cetak_tunai" style="display: none;" class="btn btn-success" target="blank"><span class="glyphicon glyphicon-print"> </span> Cetak Tunai </a>

          <a href='cetak_penjualan_tunai_besar.php' id="cetak_tunai_besar" style="display: none;" class="btn btn-primary" target="blank"><span class="glyphicon glyphicon-print"> </span> Cetak Tunai Besar </a>

          <a href='cetak_penjualan_piutang.php' id="cetak_piutang" style="display: none;" class="btn btn-success" target="blank"> <span class="  glyphicon glyphicon-print"> </span> Cetak Piutang </a>
          </div>

    </form>
</div><!-- end of row -->   
          
          <br>
          <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Success!</strong> Pembayaran Berhasil
          </div>
          
                                                                                                                                                     
          
          <br>
          <br>
          <div class="col-sm-4 col-xs-2">
          <label> User :  <?php echo $_SESSION['user_name']; ?> </label><br>
          </div>
    

    </div><!-- end of container -->


    
<script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $("#kode_barang").focus();

});

</script>

<!--untuk memasukkan perintah java script-->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {
  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("limit_stok").value = $(this).attr('limit_stok');
  document.getElementById("satuan_produk").value = $(this).attr('satuan');
  document.getElementById("ber_stok").value = $(this).attr('ber-stok');

  var level_harga = $("#level_harga").val();

var harga_level_1 = $(this).attr('harga');
var harga_level_2 = $(this).attr('harga_level_2');  
var harga_level_3 = $(this).attr('harga_level_3');

if (level_harga == "Level 1") {
  $("#harga_produk").val(harga_level_1);
}

else if (level_harga == "Level 2") {
  $("#harga_produk").val(harga_level_2);
}

else if (level_harga == "Level 3") {
  $("#harga_produk").val(harga_level_3);
}

  document.getElementById("jumlahbarang").value = $(this).attr('jumlah-barang');


  $('#myModal').modal('hide');
  $("#jumlah_barang").focus();

  });
   



  </script>




      <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
      
      </script>

      

<script type="text/javascript">
  
  $(document).ready(function() {
      


      $("#submit_produk").click(function(){
          
          var kode_barang = $("#kode_barang").val();
          
          $.post("cek_kode_barang_tbs_penjualan.php",{kode_barang:kode_barang},function(data){
          
              if (data == '1') {
          
                alert("Anda Tidak Bisa Menambahkan Nama Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
          
              }
          
          });
          
      });

  });

</script>




   <script>
   //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
  $("#submit_produk").click(function(){

    var no_faktur = $("#nomor_faktur_penjualan").val();
    var kode_pelanggan = $("#kd_pelanggan").val();
    var kode_barang = $("#kode_barang").val();
    var nama_barang = $("#nama_barang").val();
    var jumlah_barang = $("#jumlah_barang").val();
    var harga = $("#harga_produk").val();
    var harga_baru = $("harga_baru").val();
    var potongan = $("#potongan1").val();
    var tax = $("#tax1").val();
    var jumlahbarang = $("#jumlahbarang").val();
    var satuan = $("#satuan_produk").val();
    var sales = $("#sales").val();
    var a = $(".tr-kode-"+kode_barang+"").attr("data-kode-barang");    
    var ber_stok = $("#ber_stok").val();
    var stok = jumlahbarang - jumlah_barang;
    
     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');
     
  if (a > 0){
  alert("Anda Tidak Bisa Menambahkan Nama Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
  }
  else if (jumlah_barang == ''){
  alert("Jumlah Barang Harus Diisi");
  }
  else if (kode_pelanggan == ''){
  alert("Kode Pelanggan Harus Dipilih");
  }
  else if (ber_stok == 'Jasa' ){

        $.post("prosestbspenjualan.php",{no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,harga_baru:harga_baru,potongan:potongan,tax:tax,satuan:satuan,sales:sales},function(data){
     
     $("#kode_barang").focus();
     $("#tbody").prepend(data);
     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');
     $("#pembayaran_penjualan").val('');
     
     });


  
  } 
  else if (stok < 0) {

    alert ("Jumlah Melebihi Stok Barang !")
  }


  
  else{

    $.post("prosestbspenjualan.php",{no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,harga_baru:harga_baru,potongan:potongan,tax:tax,satuan:satuan,sales:sales},function(data){
     
     $("#kode_barang").focus();
     $("#tbody").prepend(data);
     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');
     $("#pembayaran_penjualan").val('');
     
     });
}
    

        var session_id = $("#session_id").val();
        
        $.post("cek_total_seluruh.php",
        {
        session_id: session_id
        },
        function(data){
        $("#total2").val(data);

        });

        
      var potongan_rp = $("#potongan_penjualan").val();
      var tax = $("#tax").val();
      var adm_bank = $("#adm_bank").val();
      var potongan_penjualan = $("#potongan_penjualan").val();
      var potongan_persen = $("#potongan_persen").val();
        
        $.post("cek_total_seluruh.php",
        {
        session_id: session_id
        },
        function(data){
        $("#total2"). val(data);
        var t_akhir = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(data ))));


        if (potongan_penjualan == "" || potongan_penjualan == 0){

          var nominal = t_akhir / 100 * potongan_persen; 
          $("#potongan_penjualan").val(tandaPemisahTitik(nominal));

          var t_tax = t_akhir * tax / 100;
          var total = t_akhir - nominal + t_tax;

          $("#total1").val(tandaPemisahTitik(total));



        }

        else if(potongan_persen == "" || potongan_persen == 0)
        {
          var persen = potongan_penjualan * 100 / t_akhir; 
          $("#potongan_persen").val(parseInt(persen));


        }

        else{

        }
        
        });
      
  });

    $("#formtambahproduk").submit(function(){
    return false;
    
    });



$("#submit_produk").mouseleave(function(){

        var session_id = $("#session_id").val();
        
        $.post("cek_total_seluruh.php",
        {
        session_id: session_id
        },
        function(data){
        $("#total2").val(data);

        $("#total").val(data);
        });



            var kode_pelanggan = $("#kd_pelanggan").val();

            
            if (kode_pelanggan != ""){
            $("#kd_pelanggan").attr("disabled", true);
            }

            
            });


//menampilkan no urut faktur setelah tombol click di pilih
      $("#cari_produk_penjualan").click(function() {

      
      $.get('no_faktur_jl.php', function(data) {
      /*optional stuff to do after getScript */ 
      $("#nomor_faktur_penjualan").val(data);
      });
      //menyembunyikan notif berhasil
      $("#alert_berhasil").hide();
      
      var kode_pelanggan = $("#kd_pelanggan").val();
      //coding update jumlah barang baru "rabu,(9-3-2016)"
      $.post('modal_jual_baru.php',{kode_pelanggan:kode_pelanggan},function(data) {
      
      $(".modal_baru").html(data);
      $("#cetak_tunai").hide('');
      $("#cetak_tunai_besar").hide('');
      $("#cetak_piutang").hide('');
      });
      /* Act on the event */
      });

   </script>



<script type="text/javascript">




//menampilkan no urut faktur setelah tombol click di pilih
      $("#cari_produk_penjualan").click(function() {

      
      $.get('no_faktur_jl.php', function(data) {
      /*optional stuff to do after getScript */ 
      $("#nomor_faktur_penjualan").val(data);
      });
      //menyembunyikan notif berhasil
      $("#alert_berhasil").hide();
      
      var kode_pelanggan = $("#kd_pelanggan").val();
      //coding update jumlah barang baru "rabu,(9-3-2016)"
      $.post('modal_jual_baru.php',{kode_pelanggan:kode_pelanggan},function(data) {
      
      $(".modal_baru").html(data);
      $("#cetak_tunai").hide('');
      $("#cetak_tunai_besar").hide('');
      $("#cetak_piutang").hide('');
      });
      /* Act on the event */
      });

   </script>




<script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#penjualan").click(function(){

        var session_id = $("#session_id").val();
        var no_faktur = $("#nomor_faktur_penjualan").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var kode_pelanggan = $("#kd_pelanggan").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
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
        
        
        var sisa = pembayaran - total;
        
        var sisa_kredit = total - pembayaran;


     $("#total1").val('');
     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');

     $("#kd_pelanggan").val('');

 
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
  $("#transaksi_baru").show();

 $.post("proses_bayar_jual.php",{total2:total2,session_id:session_id,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,harga:harga,sales:sales,kode_gudang:kode_gudang,keterangan:keterangan,ber_stok:ber_stok},function(info) {


     var no_faktur = info;
     $("#cetak_tunai").attr('href', 'cetak_penjualan_tunai.php?no_faktur='+no_faktur+'');
     $("#cetak_tunai_besar").attr('href', 'cetak_penjualan_tunai_besar.php?no_faktur='+no_faktur+'');
     $("#table-baru").html(info);
     $("#alert_berhasil").show();
     $("#total_penjualan").val('');
     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');
     $("#cetak_tunai").show();
     $("#cetak_tunai_besar").show('');
    
       
   });


 }

 $("form").submit(function(){
    return false;
 
});

});

               $("#penjualan").mouseleave(function(){
               
               $.get('no_faktur_jl.php', function(data) {
               /*optional stuff to do after getScript */ 
               
               $("#nomor_faktur_penjualan").val(data);
               $("#no_faktur0").val(data);
               
               });
               var kode_pelanggan = $("#kd_pelanggan").val();
               if (kode_pelanggan == ""){
               $("#kd_pelanggan").attr("disabled", false);
               }
               
               });
      
  </script>
  
     <script>
       //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
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
        var potongan_persen = $("#potongan_persen").val();
        var tax = $("#tax_rp").val();
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var total_hpp = $("#total_hpp").val();
        var kode_gudang = $("#kode_gudang").val();
        var sales = $("#sales").val();
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();
       
       var sisa =  pembayaran - total; 

       var sisa_kredit = total - pembayaran;

      $("#total1").val('');
       $("#pembayaran_penjualan").val('');
       $("#sisa_pembayaran_penjualan").val('');
       $("#kredit").val('');
       $("#tanggal_jt").val('');
       
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
         
         }
         else if ( total == "") 
         {
         
         alert("Anda Belum Melakukan Pesanan");
         
         }
         
       else
       {
       
       $.post("proses_bayar_jual.php",{total2:total2,session_id:session_id,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,sales:sales,kode_gudang:kode_gudang,keterangan:keterangan,ber_stok:ber_stok},function(info) {

            var no_faktur = info;
            $("#cetak_piutang").attr('href', 'cetak_penjualan_piutang.php?no_faktur='+no_faktur+'');
            $("#table-baru").html(info);
            $("#table-baru").load('tabel_penjualan.php');
            $("#alert_berhasil").show();
            $("#total_penjualan").val('');
            $("#pembayaran_penjualan").val('');
            $("#sisa_pembayaran_penjualan").val('');
            $("#kredit").val('');
            $("#potongan_penjualan").val('');
            $("#potongan_persen").val('');
            $("#tanggal_jt").val('');
            $("#cetak_piutang").show();
            $("#tax").val('');
            
       
       
       });

       
       }  
       //mengambil no_faktur pembelian agar berurutan

       });
 $("form").submit(function(){
       return false;
       });

              $("#piutang").mouseleave(function(){
               
               $.get('no_faktur_jl.php', function(data) {
               /*optional stuff to do after getScript */ 
               
               $("#nomor_faktur_penjualan").val(data);
               $("#no_faktur0").val(data);
               
               });
               var kode_pelanggan = $("#kd_pelanggan").val();
               if (kode_pelanggan == ""){
               $("#kd_pelanggan").attr("disabled", false);
               }
               
               });
  </script>   

 

<!--menampilkan perintah javascript-->
<script type="text/javascript">

        $(document).ready(function(){
        
        $("#kode_barang").focus(function(){

         $(document).ready(function(){
          var session_id = $("#session_id").val();
        
        $.post("cek_total_seluruh.php",
        {
        session_id: session_id
        },
        function(data){
        $("#total2").val(data);

        $("#total").val(data);
        });

      });

        
        var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val() ))));
        var tax = $("#tax").val();
        
        if (tax > 100 ) {
          alert ("Tax Tidak Boleh Lebih Dari 100%");

          $("#tax").val('');
          $("#carabayar1").val('');
        }
        else{
          $.post("cek_tax.php", {potongan:potongan,potongan_persen:potongan_persen,total:total,tax:tax}, function(data) {
        
        $("#total1").val(tandaPemisahTitik(parseInt(data)));

        
        
        });
        }
        

      var tax_persen = $("#tax").val();
      var tax_rp = ((total * tax_persen) / 100);
        

        $("#tax_rp").val(parseInt(tax_rp));
      


        });
        });
        
        </script>


<script type="text/javascript">
        $(document).ready(function(){
        
        $("#pembayaran_penjualan").focus(function(){

        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() ))));
        var potongan_penjualan = ((total * potongan_persen) / 100);
        var sisa_potongan = total - potongan_penjualan;
        
        if (potongan_persen > 100) {
          alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
        }

        
        
        $("#total1").val(tandaPemisahTitik(parseInt(sisa_potongan)));
        $("#potongan_penjualan").val(tandaPemisahTitik(parseInt(potongan_penjualan)));

        var potongan_penjualan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
        var potongan_persen = ((potongan_penjualan / total) * 100);
        var sisa_potongan = total - potongan_penjualan;
        

        
        $("#total1").val(tandaPemisahTitik(parseInt(sisa_potongan)));
        $("#potongan_persen").val(parseInt(potongan_persen));
        
        var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val() ))));
        var tax = $("#tax").val();
        
        if (tax > 100 ) {
          alert ("Tax Tidak Boleh Lebih Dari 100%");

          $("#tax").val('');
          $("#carabayar1").val('');
        }
        else{
          $.post("cek_tax.php", {potongan:potongan,potongan_persen:potongan_persen,total:total,tax:tax}, function(data) {
        
        $("#total1").val(tandaPemisahTitik(parseInt(data)));


        
        
        });
        }


      var tax_persen = $("#tax").val();
        var tax_rp = ((total * tax_persen) / 100);
        

        $("#tax_rp").val(parseInt(tax_rp));
      


        });
        });
        
        </script>


<script>

//untuk menampilkan sisa penjualan secara otomatis
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
  $(document).ready(function() {

        var session_id = $("#session_id").val();
        
        $.post("cek_total_seluruh.php",
        {
        session_id: session_id
        },
        function(data){
        $("#total2").val(data);

        $("#total").val(data);
        });
                
        
        
       $("#submit_produk").click(function(){

        var session_id = $("#session_id").val();
        var potongan_rp = $("#potongan_penjualan").val();
        var tax = $("#tax").val();
        var adm_bank = $("#adm_bank").val();
        var potongan_penjualan = $("#potongan_penjualan").val();
        var potongan_persen = $("#potongan_persen").val();
        
        $.post("cek_total_seluruh.php",
        {
        session_id: session_id
        },
        function(data){
        $("#total2"). val(data);
        var t_akhir = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(data ))));


        if (potongan_penjualan == "" || potongan_penjualan == 0){

          var nominal = t_akhir / 100 * potongan_persen; 
          $("#potongan_penjualan").val(tandaPemisahTitik(nominal));

          var t_tax = t_akhir * tax / 100;
          var total = t_akhir - nominal + t_tax;

          $("#total1").val(tandaPemisahTitik(total));



        }

        else if(potongan_persen == "" || potongan_persen == 0)
        {
          var persen = potongan_penjualan * 100 / t_akhir; 
          $("#potongan_persen").val(parseInt(persen));


        }

        else{

        }
        
        });


          $("#kode_barang").focus();

  });


        
        
        $.post("cek_total_hpp.php",
        {
        session_id: session_id
        },
        function(data){
        $("#total_hpp"). val(data);
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

  var session_id = $("#session_id").val();

            $.post("cek_total_hpp.php",
            {
            session_id: session_id
            },
            function(data){
            $("#total_hpp"). val(data);
            });
        
    });
});
</script>

        <script>
        
        //untuk menampilkan sisa penjualan secara otomatis
        $(document).ready(function(){
        $("#pembayaran_penjualan").keyup(function(){
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var total =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() ))));
        var sisa = pembayaran - total;
        var sisa_kredit = total - pembayaran; 
        
        if (sisa < 0 )
        {
        $("#kredit").val( tandaPemisahTitik(sisa_kredit));
        $("#sisa_pembayaran_penjualan").val('0');
        $("#tanggal_jt").attr("disabled", false);
        
        }
        
        else  
        {
        
        
        
        $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
        $("#kredit").val('0');
        $("#tanggal_jt").attr("disabled", true);
        
        } 
        
        
        });
        
        
        });
        </script>

<script type="text/javascript">
  $("#potongan_persen").keyup(function(){

      var potongan_persen = $("#potongan_persen").val();

            if (potongan_persen > 100){
              alert("Potongan Tidak Boleh Lebih Dari 100%")
             }
  });


          $(document).ready(function(){
        $("#potongan_penjualan").keyup(function(){
        var potongan_penjualan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
        var potongan_persen = ((potongan_penjualan / total) * 100);
        var sisa_potongan = total - potongan_penjualan;

        
        $("#total1").val(tandaPemisahTitik(parseInt(sisa_potongan)));
        $("#potongan_persen").val(parseInt(potongan_persen));
        });
        });
</script>




        <script type="text/javascript">
        $(document).ready(function(){
        
        $("#tax").blur(function(){
        
        var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val() ))));
        var tax = $("#tax").val();
        
        if (tax > 100 ) {
          alert ("Tax Tidak Boleh Lebih Dari 100%");

          $("#tax").val('');
          $("#carabayar1").val('');
        }
        else{
          $.post("cek_tax.php", {potongan:potongan,potongan_persen:potongan_persen,total:total,tax:tax}, function(data) {
        
        $("#total1").val(tandaPemisahTitik(parseInt(data)));

        
        
        });
        }
        

        });
        });
        
      </script>







    <script type="text/javascript">
    $(document).ready(function(){
      
//fungsi hapus data 
    $(".btn-hapus-tbs").click(function(){

    
    var nama_barang = $(this).attr("data-barang");
    var id = $(this).attr("data-id");
    var kode_barang = $(this).attr("data-kode-barang");


    $.post("hapustbs_penjualan.php",{id:id,kode_barang:kode_barang},function(data){
    if (data == 'sukses') {


    $(".tr-id-"+id+"").remove();
    $("#pembayaran_penjualan").val('');
    $("#kode_barang").focus();
    
    }
    });

});
                  $('form').submit(function(){
              
              return false;
              });


    });
  
//end fungsi hapus data
</script>


<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").keyup(function(){

          var kode_barang = $(this).val();
          var level_harga = $("#level_harga").val();
          
          $.post("cek_barang_penjualan.php",{kode_barang: kode_barang}, function(data){
          $("#jumlahbarang").val(data);
          });

      $.getJSON('lihat_nama_barang.php',{kode_barang:$(this).val()}, function(json){
      
      if (json == null)
      {
        
        $('#nama_barang').val('');
        $('#limit_stok').val('');
        $('#harga_produk').val('');
        $('#satuan_produk').val('');
        $('#ber_stok').val('');

      }

      else 
      {
        if (level_harga == "Level 1") {

        $('#harga_produk').val(json.harga_jual);
        }
        else if (level_harga == "Level 2") {

        $('#harga_produk').val(json.harga_jual2);
        }
        else if (level_harga == "Level 3") {

        $('#harga_produk').val(json.harga_jual3);
        }

        $('#nama_barang').val(json.nama_barang);
        $('#limit_stok').val(json.limit_stok);
        $('#satuan_produk').val(json.satuan);
        $('#ber_stok').val(json.berkaitan_dgn_stok);
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


     $("#pembayaran_penjualan").focus();

    }

   else if(x == 115){


     $("#penjualan").focus();

    }
  }
</script>

<script type="text/javascript">
          $(document).ready(function(){
          var session_id = $("#session_id").val();
        
        $.post("cek_total_seluruh.php",
        {
        session_id: session_id
        },
        function(data){
        $("#total2").val(data);

        $("#total").val(data);
        });

      });


</script>



        <script type="text/javascript">
        $(document).ready(function() {
                
        
        
        $("#simpan_sementara").click(function(){
        var session_id = $("#session_id").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() ))));
        var kode_pelanggan = $("#kd_pelanggan").val();
        var sales = $("#sales").val();
        var kode_gudang = $("#kode_gudang").val();

        var potongan =  $("#potongan1").val() ;

        $("#potongan_penjualan").val('');

        if (total <= 0 ) {
          alert("Anda Belum Melakukan Pemesanan");
        }

        else{

          
        $("#transaksi_baru").show();

        $.post("proses_simpan_barang.php", {kode_gudang:kode_gudang,session_id: session_id,total:total,kode_pelanggan:kode_pelanggan,potongan:potongan,sales:sales}, function(data){

        $("#potongan_penjualan").val('');
        $("#table-baru").load('tabel_penjualan.php');
        $("#alert_berhasil").show();
        $("#penjualan").hide();
        $("#piutang").hide();
        $("#simpan_sementara").hide();
        });
          
        }
        

        });
        
        $("#formtambahproduk").submit(function(){
        return false;
        });
      
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
                                 
                                 $(".edit-jumlah").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-jumlah-"+id+"").hide();

                                    $("#input-jumlah-"+id+"").attr("type", "text");

                                 });


                                 $(".input_jumlah").blur(function(){

                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();
                                    var kode_barang = $(this).attr("data-kode");
                                    var harga = $(this).attr("data-harga");
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    
                                   
                                    var subtotal = harga * jumlah_baru - potongan;

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

                                    subtotal_penjualan = subtotal_penjualan - subtotal_lama + subtotal;



                                    $.post("cek_stok_pesanan_barang.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru},function(data){

                                       if (data == "ya") {

                                       alert ("Jumlah Yang Di Masukan Melebihi Stok !");

                                       $(this).val($(".text-jumlah-"+id+"").text());

                                     }

                                      else{

                                     $.post("update_pesanan_barang.php",{id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang, potongan:potongan},function(info){

                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total2").val(tandaPemisahTitik(subtotal_penjualan));         

                                    });

                                   }

                                 });


       
                                    $("#kode_barang").focus();

                                 });

                             </script>

<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>