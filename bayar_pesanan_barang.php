<?php include 'session_login.php';


// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


// menampilkan seluruh data yang ada pada tabel penjualan yang terdapt pada DB


$no_faktur = $_GET['no_faktur'];
$kode_pelanggan = $_GET['kode_pelanggan'];
$kode_gudang = $_GET['kode_gudang'];
$nama_gudang = $_GET['nama_gudang'];
$nama_pelanggan = $_GET['nama_pelanggan'];

    $perintah = $db->query("SELECT tanggal, tunai, nilai_kredit, total FROM penjualan WHERE no_faktur = '$no_faktur'");
    $ambil_tanggal = mysqli_fetch_array($perintah);
    $dp = $ambil_tanggal['tunai'];
    $nilai_kredit = $ambil_tanggal['nilai_kredit'];
    $total_akhir = $ambil_tanggal['total'];
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

<!--untuk membuat agar tampilan form terlihat rapih dalam satu tempat -->
 <div class="container">


  <!--membuat teks dengan ukuran h3-->      
  <h3>BAYAR PENJUALAN </h3><br>


<!--membuat agar tabel berada dalam baris tertentu-->
 <div class="row">
<div class="col-sm-8">
  

<!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="formpenjualan.php" method="post ">
        


<div class="form-group col-sm-6">
    <label> Nomor Faktur </label>
    <input type="text" name="no_faktur" id="nomor_faktur_penjualan" class="form-control" readonly="" value="<?php echo $no_faktur; ?>" required="" >
</div>



<div class="form-group  col-sm-6">
      <label> Tanggal </label><br>
      <input type="text" name="tanggal" id="tanggal"  value="<?php echo $ambil_tanggal['tanggal']; ?>" class="form-control tanggal" >
</div>


<div class="form-group col-sm-6">
   <label> Kode Pelanggan </label><br>
  <select type="text" name="kode_pelanggan" id="kd_pelanggan" class="form-control chosen" required="" autofocus="">
  <option value=<?php echo $kode_pelanggan; ?>><?php echo $kode_pelanggan; ?> - <?php echo $nama_pelanggan; ?></option>
          
  <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query = $db->query("SELECT * FROM pelanggan");

    //untuk menyimpan data sementara yang ada pada $query
    while($data = mysqli_fetch_array($query))
    {
    
    echo "<option  value='".$data['kode_pelanggan'] ."' class='opt-pelanggan-".$data['kode_pelanggan']."' data-level='".$data['level_harga'] ."'>".$data['kode_pelanggan'] ." - ".$data['nama_pelanggan'] ."</option>";
    }
    
    
    ?>
  </select>
  </div>

  <div class="form-group  col-sm-6">
          <label> Gudang </label><br>
          
          <select name="kode_gudang" id="kode_gudang" class="form-control chosen" required="" >
          <option value=<?php echo $kode_gudang; ?>><?php echo $nama_gudang; ?></option>
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

<div class="form-group col-sm-3">
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




<div class="form-group  col-sm-3">
          <label>PPN</label>
          <select name="ppn" id="ppn" class="form-control">
            <option value="Include">Include</option>  
            <option value="Exclude">Exclude</option>
            <option value="Non">Non</option>          
          </select>
</div>

<div class="form-group  col-sm-3">
      <label> Cara Bayar </label><br>
      <select type="text" name="cara_bayar" id="carabayar1" class="form-control" required=""  style="font-size: 16px" >
          <option value=""> Silahkan Pilih </option>
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

<input type="hidden" name="ppn_input" id="ppn_input" value="Include" class="form-control" placeholder="ppn input">


<!--
    <label style="display: none"> Kode Meja </label><br>
    <input type="hidden" name="kode_meja" id="kode_meja" class="form-control" readonly="" value="<?php // echo $kode_meja; ?>" required="" >
-->
        

  </form><!--tag penutup form-->


<button type="button" id="cari_produk_penjualan" class="btn btn-info" data-toggle="modal" data-target="#myModal"><span class='glyphicon glyphicon-search'> </span> Cari </button>



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
     <input type="hidden" class="form-control" id="faktur_edit" readonly="">
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
        <h4>Maaf No Transaksi <strong><?php echo $no_faktur
; ?></strong> tidak dapat dihapus atau di edit, karena telah terdapat Transaksi Pembayaran Piutang atau Retur Penjualan. Dengan daftar sebagai berikut :</h4>
      </div>

      <div class="modal-body">
      <span id="modal-alert">
       </span>


     </div>

      <div class="modal-footer">
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data,<br>
        silahkan hapus terlebih dahulu Transaksi Pembayaran Piutang atau Retur Penjualan</i></h6>
        <button type="button" class="btn btn-warning btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- membuat form prosestbspenjual -->
<form class="form" action="proses_tambah_edit_penjualan.php" role="form" id="formtambahproduk">
<div class="row 1">
  <div class="col-sm-3">
    <div class="form-group">
    <input type="text" class="form-control" name="kode_barang" id="kode_barang" autocomplete="off" accesskey="k" placeholder="Kode Produk">
    </div>
  </div>

  <div class="col-sm-4">
      <div class="form-group">
          <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" readonly="">
      </div>
  </div>

  <div class="col-sm-3">
      <div class="form-group">
    <input type="number" class="form-control" name="jumlah_barang" autocomplete="off" id="jumlah_barang" placeholder="Jumlah Barang" >
      </div>
  </div>

  <div class="col-sm-2">
    <select type="text" name="satuan_konversi" id="satuan_konversi" class="form-control"  required="" style="height:50px;font-size:15px; width: 100px" >
          
          <?php 
          
          
          $query = $db->query("SELECT id, nama  FROM satuan");
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
          }
                      
          ?>
          
        </select>
  </div>

</div><!--end div class="row 1"-->

<div class="row">


   <div class="form-group col-sm-3">
    <input type="text" class="form-control" name="potongan" autocomplete="off" id="potongan1" placeholder="Potongan" >
  </div>


      <div class="form-group col-sm-3">
      <input type="text" class="form-control" name="tax" autocomplete="off" id="tax1"  placeholder="Pajak (%)" >
      </div>



  <input type="hidden" class="form-control" name="jumlah_barang_tbs" id="jumlah_barang_tbs">


<input type="hidden" class="form-control" name="limit_stok" id="limit_stok">

  <input type="hidden" placeholder="Stok" class="form-control" name="jumlahbarang" id="jumlahbarang">

  <input type="hidden" class="form-control" name="ber_stok" id="ber_stok" placeholder="Ber Stok" >

  <input type="hidden" class="form-control" name="harga_lama" id="harga_lama">

  <input type="hidden" class="form-control" name="harga_baru" id="harga_baru">


  <input type="hidden" id="harga_produk" placeholder="Harga / Level" name="harga" class="form-control" value="" required="">

  <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">

  <input type="hidden" id="id_produk" name="id_produk" placeholder="id_produk" class="form-control" value="" required="">  

  <input type="hidden" name="no_faktur" id="no_faktur0" class="form-control" value="<?php echo $no_faktur; ?>" required="" >

  <br>
  <div class="form-group col-sm-4">        
  <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah Produk</button>
</div>



</div><!--end div row potngan,tax,tombol submit Tambah--> 

</form> <!-- tag penutup form --><br><br>




  

                <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
               
                
                <div class="table-responsive"> <!--tag untuk membuat garis pada tabel-->  
                <span id="table-baru">  
                <table id="tableuser" class="table table-bordered">
                <thead>
                <th> Kode Barang </th>
                <th> Nama Barang </th>
                <th> Jumlah Barang </th>
                <th> Satuan </th>
                <th> Harga </th>
                <th> Potongan </th>
                <th> Pajak </th>
                <th> Subtotal </th>
                <th> Hapus </th>
                
                </thead>
                
                <tbody id="tbody">
                <?php
                
                //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT tp.id,tp.no_faktur,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama FROM tbs_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id WHERE tp.no_faktur = '$no_faktur'");
                
                //menyimpan data sementara yang ada pada $perintah
                
                while ($data1 = mysqli_fetch_array($perintah))
                {
                //menampilkan data
                echo "<tr class='tr-id-". $data1['id'] ." tr-kode-". $data1['kode_barang'] ."'>
                <td>". $data1['kode_barang'] ."</td>
                <td>". $data1['nama_barang'] ."</td>";

$pilih = $db->query("SELECT no_faktur_penjualan FROM detail_retur_penjualan WHERE no_faktur_penjualan = '$data1[no_faktur]' AND kode_barang = '$data1[kode_barang]'");
$row_retur = mysqli_num_rows($pilih);

$pilih = $db->query("SELECT no_faktur_penjualan FROM detail_pembayaran_piutang WHERE no_faktur_penjualan = '$data1[no_faktur]'");
$row_piutang = mysqli_num_rows($pilih);

if ($row_retur > 0 || $row_piutang > 0) {

                echo"<td class='edit-jumlah-alert' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-satuan='".$data1['satuan']."' data-harga='".$data1['harga']."' > </td>";  

}
else {

  echo"<td class='edit-jumlah' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-satuan='".$data1['satuan']."' data-harga='".$data1['harga']."' > </td>";  

}

                echo"<td>". $data1['nama'] ."</td>
                <td>". rp($data1['harga']) ."</td>
                <td><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
                <td><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>
                <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>";




if ($row_retur > 0 || $row_piutang > 0) {

      echo "<td> <button class='btn btn-danger btn-alert-hapus' data-id='".$data1['id']."' data-subtotal='".$data1['subtotal']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."'><span class='glyphicon glyphicon-trash'></span> Hapus </button></td>";

} 

else{
      echo "<td> <button class='btn btn-danger btn-hapus-tbs' data-id='". $data1['id'] ."' data-subtotal='".$data1['subtotal']."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}

               

                
                echo"</tr>";


                }

                ?>
                </tbody>
                
                </table>
                </span>
                </div>


</div>



<div class="col-sm-4">
 


 <form action="proses_bayar_edit_jual.php" id="form_jual" method="POST" >
    
    <style type="text/css">
    .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: false;
    }
    </style>

          <br>


         <label> Subtotal </label><br>
         <input type="text" name="total" id="total2" class="form-control" placeholder="Total" readonly="" >

<div class="row">
  
          <?php
          $total_tbs = $db->query("SELECT SUM(subtotal) as s_total FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
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
          <div class="col-sm-6">
            <label> Diskon ( Rp )</label><br>
            <input type="text" name="potongan" id="potongan_penjualan" value="<?php echo intval($diskon); ?>" class="form-control" placeholder="" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">

          </div>

          <div class="col-sm-6">
            
          <label> Diskon ( % )</label><br>
          <input type="text" name="potongan_persen" id="potongan_persen" value="<?php echo intval($diskon_p); ?>" class="form-control" placeholder="" autocomplete="off" >

          </div>
          

          

          <?php  }
          else{
            $diskon = $data_diskon['diskon_persen'];

           $diskon_n = $total_bener /  100 * $diskon;



?>
          <div class="col-sm-6">

          <label> Diskon ( Rp )</label><br>
          <input type="text" name="potongan" id="potongan_penjualan" value="<?php echo intval($diskon_n); ?>" class="form-control" placeholder="" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" >
          </div>

          <div class="col-sm-6">
          <label> Diskon ( % )</label><br>
          <input type="text" name="potongan_persen" id="potongan_persen" value="<?php echo intval($diskon); ?>" class="form-control" placeholder="" autocomplete="off" >
         </div>
<?php
          }


           ?>

</div>
          



         
          
<div class="row">
  
          <div class="form-group col-sm-6">
           <label> Pajak </label><br>
          <input type="text" name="tax" id="tax" value="<?php echo $data_diskon['tax']; ?>" style="height:15px;font-size:15px" class="form-control"  autocomplete="off" >
          </div>

          <div class="form-group col-sm-6">
          <label> Tanggal Jatuh Tempo </label><br>
          <input type="text" name="tanggal_jt" id="tanggal_jt" style="height:15px;font-size:15px"  value="" class="form-control tanggal" >
          </div>

</div>

          <input type="hidden" name="tax_rp" id="tax_rp" class="form-control"  autocomplete="off" >

           <label style="display: none"> Adm Bank  (%)</label>
          <input type="hidden" name="adm_bank" id="adm_bank"  value="" class="form-control" >
          
          

          
          <label style="font-size:15px"> Total Akhir</label><br>
          <b><input type="text" name="total" id="total1" class="form-control" value="<?php echo rp($total_akhir); ?>" style="height: 50px; width:90%; font-size:25px;" placeholder="Total" readonly="" ></b>

<div class="row">
  <div class="col-sm-6">

          <label> Pembayaran </label><br>
          <b><input type="text" name="pembayaran" id="pembayaran_penjualan" style="height: 30px; width:90%; font-size:25px;" autocomplete="off" class="form-control" value="<?php echo rp($dp); ?>" style="font-size: 20px"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"></b>
    
  </div>
  <div class="col-sm-6">

          <label> Pembayaran Awal </label><br>
          <input type="text" name="pembayaran" id="pembayaran_awal" style="height: 30px; width:90%;" autocomplete="off" class="form-control" readonly="" value="<?php echo rp($dp); ?>">

    
  </div>
</div>


<div class="row">
          
          <div class="col-sm-6">
          <label> Kembalian </label><br>
          <b><input type="text" name="sisa_pembayaran" id="sisa_pembayaran_penjualan" style="height:15px;font-size:15px" class="form-control"  readonly="" required=""  style="font-size: 20px" ></b>
          </div>
          
          <div class="col-sm-6">
          <label> Kredit </label><br>
          <b><input type="text" name="kredit" id="kredit" value="<?php echo rp($nilai_kredit); ?>" class="form-control" style="height:15px;font-size:15px"  readonly="" required="" ></b>
          </div>
</div>
          
          


         
          

          <label> Keterangan </label><br>
          <textarea type="text" name="keterangan" id="keterangan" class="form-control"> 
          </textarea>

          <b><input type="hidden" name="zxzx" id="zxzx" class="form-control" style="height: 50px; width:90%; font-size:25px;"  readonly="" required="" ></b>


          <b><input type="hidden" name="jumlah_bayar_lama" id="jumlah_bayar_lama" value="" class="form-control" style="height: 50px; width:90%; font-size:25px;"  readonly=""></b>

<?php 

if ($_SESSION['otoritas'] == 'Pimpinan') {
 echo '<label style="display:none"> Total Hpp </label><br>
          <input type="hidden" name="total_hpp" id="total_hpp" style="height: 50px; width:90%; font-size:25px;" class="form-control" placeholder="" readonly="" required="">';
}

         mysqli_close($db); 


 ?>

          <input type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah">   <br> 
          
          
          <!-- memasukan teks pada kolom kode pelanggan, dan nomor faktur penjualan namun disembunyikan -->
          <input type="hidden" name="no_faktur" id="nofaktur" class="form-control" value="<?php echo $no_faktur
; ?>" required="" >
          
          <input type="hidden" name="kode_pelanggan" id="k_pelanggan" class="form-control" required="" >

<div class="row">

  <div class="col-sm-3">
    <button type="submit" id="penjualan" class="btn btn-info" data-faktur='<?php echo $no_faktur
 ?>'>Bayar</button>

    
  </div>
  <div class="col-sm-3">
  <button type="submit" id="piutang" class="btn btn-warning" data-faktur='<?php echo $no_faktur; ?>'>Piutang</button>

  
  </div>

</div>

          
<div class="row">
    <div class="col-sm-3">
    <a href="penjualan.php?status=semua" id="transaksi_baru" class="btn btn-primary"  style="display: none;">Transaksi Baru</a>
    </div>
    
    <div class="col-sm-3">
    <a href='cetak_penjualan_tunai.php?no_faktur=<?php echo $no_faktur; ?>' id="cetak_tunai"  style="display: none;" class="btn btn-success" target="blank">Cetak Tunai </a>
    </div>

    <div class="col-sm-3">
    <a href='cetak_penjualan_tunai_besar.php?no_faktur=<?php echo $no_faktur; ?>' id="cetak_tunai_besar" style="display: none;"  class="btn btn-info" target="blank">Cetak Tunai Besar</a>
    </div>
    
    <div class="col-sm-3">
    <a href='cetak_penjualan_piutang.php?no_faktur=<?php echo $no_faktur ?>' id="cetak_piutang"  style="display: none;" class="btn btn-warning" target="blank"> <span class="  glyphicon glyphicon-print"> </span> Cetak Piutang </a>
    </div>

</div>
          

   
          
           

         

          

</div>

          
          

<!--
          <a href='batal_penjualan.php?no_faktur=<?php echo $no_faktur
;?>' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span> Batal </a>
          -->
 
    </form>




</div>
 
                

</div><!-- end of row -->   
          
          <br>
          <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Success!</strong> Pembayaran Berhasil
          </div>

    

    </div><!-- end of container -->


<!--untuk memasukkan perintah java script-->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {
  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("limit_stok").value = $(this).attr('limit_stok');
  document.getElementById("satuan_produk").value = $(this).attr('satuan');
  document.getElementById("ber_stok").value = $(this).attr('ber-stok');
  document.getElementById("harga_lama").value = $(this).attr('harga');
  document.getElementById("harga_baru").value = $(this).attr('harga');
  document.getElementById("satuan_konversi").value = $(this).attr('satuan');
  document.getElementById("id_produk").value = $(this).attr('id-barang');


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


            var no_faktur = $("#nomor_faktur_penjualan").val();
            var kode_barang = $(this).attr('data-kode');
            
            $.post("cek_jumlah_tbs.php",
            {
            no_faktur:no_faktur,kode_barang:kode_barang
            },
            function(data){
            $("#jumlah_barang_tbs").val(data);
            });

  $('#myModal').modal('hide');
  $("#kode_barang").focus();
  $("#jumlah_barang").focus();
  });
   

  </script>

<script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $("#kode_barang").focus();

});

</script>

<!-- cek stok satuan konversi keyup-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#jumlah_barang").keyup(function(){
      var jumlah_barang = $("#jumlah_barang").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
      var id_produk = $("#id_produk").val();
      var no_faktur = $("#no_faktur0").val();
      var prev = $("#satuan_produk").val();

      $.post("cek_stok_konversi_edit_penjualan.php",
        {jumlah_barang:jumlah_barang,satuan_konversi:satuan_konversi,kode_barang:kode_barang,id_produk:id_produk,no_faktur:no_faktur},function(data){

          if (data < 0) {
            alert("Jumlah Melebihi Stok");
            $("#jumlah_barang").val('');
          $("#satuan_konversi").val(prev);
          }

      });
    });
  });
</script>
<!-- cek stok satuan konversi keyup-->

<!-- cek stok satuan konversi change-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#satuan_konversi").change(function(){
      var jumlah_barang = $("#jumlah_barang").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
      var no_faktur = $("#no_faktur0").val();
      var id_produk = $("#id_produk").val();
      var prev = $("#satuan_produk").val();

      $.post("cek_stok_konversi_edit_penjualan.php",
        {jumlah_barang:jumlah_barang,satuan_konversi:satuan_konversi,kode_barang:kode_barang,id_produk:id_produk,no_faktur:no_faktur},function(data){

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


<script>
$(document).ready(function(){
    $("#satuan_konversi").change(function(){

      var prev = $("#satuan_produk").val();
      var harga_lama = $("#harga_lama").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var id_produk = $("#id_produk").val();
      var harga_produk = $("#harga_lama").val();
      var jumlah_barang = $("#jumlah_barang").val();
      var kode_barang = $("#kode_barang").val();
      

      $.getJSON("cek_konversi_penjualan.php",{kode_barang:kode_barang,satuan_konversi:satuan_konversi, id_produk:id_produk,harga_produk:harga_produk,jumlah_barang:jumlah_barang},function(info){

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

    $("#kd_pelanggan").change(function(){
      var kode_pelanggan = $("#kd_pelanggan").val();

      var level_harga = $(".opt-pelanggan-"+kode_pelanggan+"").attr("data-level");

    $("#level_harga").val(level_harga);

      });
          
        </script>




   <script>
   //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
  $("#submit_produk").click(function(){

    var no_faktur = $("#nomor_faktur_penjualan"
).val();
    var kode_pelanggan = $("#kd_pelanggan").val();
    var kode_barang = $("#kode_barang").val();
    var nama_barang = $("#nama_barang").val();
    var jumlah_barang = $("#jumlah_barang").val();
    var harga = $("#harga_produk").val();
    var harga_baru = $("harga_baru").val();
    var potongan = $("#potongan1").val();
    var tax = $("#tax1").val();
    var jumlahbarang = $("#jumlahbarang").val();
    var satuan = $("#satuan_konversi").val();
    var sales = $("#sales").val();
    var ber_stok = $("#ber_stok").val();
    var stok = jumlahbarang - jumlah_barang;
    
     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');

  if (jumlah_barang == ''){
  alert("Jumlah Barang Harus Diisi");
  }
  else if (kode_pelanggan == ''){
  alert("Kode Pelanggan Harus Dipilih");
  }
  else if (ber_stok == 'Jasa' ){

        $.post("proses_tambah_pesanan_barang.php",{no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,harga_baru:harga_baru,potongan:potongan,tax:tax,satuan:satuan,sales:sales},function(data){
     
     $("#kode_barang").focus();
      $("#ppn").attr("disabled", true);
     $("#tbody").prepend(data);
     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');
     $("#pembayaran_penjualan").val('');
     
     });


  
  }
  else if (stok < 0 ){
  alert("Jumlah Barang Melebihi Stok");
  }
  
  else{

    $(".tr-kode-"+kode_barang+"").remove();

    $.post("proses_tambah_pesanan_barang.php",{no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,harga_baru:harga_baru,potongan:potongan,tax:tax,satuan:satuan,sales:sales,ber_stok:ber_stok},function(data){
     
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
    

        var no_faktur_id = $("#nomor_faktur_penjualan"
).val();
        
        $.post("cek_total_bayar_pesanan_barang.php",
        {
        no_faktur: no_faktur
        },
        function(data){
        $("#total2").val(data);

        });

        
      var potongan_rp = $("#potongan_penjualan").val();
      var tax = $("#tax").val();
      var adm_bank = $("#adm_bank").val();
      var potongan_penjualan = $("#potongan_penjualan").val();
      var potongan_persen = $("#potongan_persen").val();
        
        $.post("cek_total_bayar_pesanan_barang.php",
        {
        no_faktur: no_faktur
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

        var no_faktur = $("#nomor_faktur_penjualan"
).val();
        
        $.post("cek_total_bayar_pesanan_barang.php",
        {
        no_faktur: no_faktur
        },
        function(data){
        $("#total2").val(data);

        });



            var kode_pelanggan = $("#kd_pelanggan").val();

            
            if (kode_pelanggan != ""){
            $("#kd_pelanggan").attr("disabled", true);
            }

            
            });



   </script>

 <script type="text/javascript">
  $(document).ready(function(){
$("#cari_produk_penjualan").click(function(){
  var no_faktur = $("#nomor_faktur_penjualan"
).val();

  $.post("cek_tbs_penjualan_pesanan.php",{no_faktur: "<?php echo $no_faktur; ?>"},function(data){
        if (data != "1") {


             $("#ppn").attr("disabled", false);

        }
    });

});
});
</script>



<script type="text/javascript">


//menampilkan no urut faktur setelah tombol click di pilih
      $("#cari_produk_penjualan").click(function() {

      
   
      //menyembunyikan notif berhasil
      $("#alert_berhasil").hide();
      
      var no_faktur = $("#no_faktur0").val();
      //coding update jumlah barang baru "rabu,(9-3-2016)"
      $.post('modal_edit_penjualan.php',{no_faktur:no_faktur},function(data) {
      
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
        var sales = $("#sales").val();
        var tanggal = $("#tanggal").val();
        var kode_gudang = $("#kode_gudang").val();
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


$("#transaksi_baru").show();
$("#cetak_tunai").show();
$("#cetak_tunai_besar").show();
$("#penjualan").hide();
$("#piutang").hide();


 $.post("proses_bayar_pesanan_barang.php",{kode_gudang:kode_gudang,tanggal:tanggal,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,harga:harga,sales:sales,keterangan:keterangan,ber_stok:ber_stok,total2:total2,ppn_input:ppn_input},function(info) {

$("#demo").html(info);
     
     $("#alert_berhasil").show();
     $("#table-baru").html(info);
     $("#table-baru").html(info);
     $("#total_penjualan").val('');
     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');
     $("#kd_pelanggan").val('');
    
       
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
        
        var no_faktur       = $("#nomor_faktur_penjualan").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit          = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var kode_pelanggan  = $("#kd_pelanggan").val();
        var tanggal_jt      = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan        =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var tax             = $("#tax_rp").val();
        var cara_bayar      = $("#carabayar1").val();
        var pembayaran      = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var total_hpp       = $("#total_hpp").val();
        var sales           = $("#sales").val();
        var tanggal         = $("#tanggal").val();
        var kode_gudang     = $("#kode_gudang").val();
        var keterangan      = $("#keterangan").val();
        var ber_stok        = $("#ber_stok").val();
        var total           = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var ppn_input       = $("#ppn_input").val();
        
        var sisa            =  pembayaran - total; 

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

        $("#penjualan").hide();
        $("#transaksi_baru").show();
       $("#cetak_piutang").show();
       
       $.post("proses_bayar_pesanan_barang.php",{kode_gudang:kode_gudang,tanggal:tanggal,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,total2:total2,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,sales:sales,keterangan:keterangan, ber_stok:ber_stok,ppn_input:ppn_input},function(info) {

       $("#demo").html(info);
       

       $("#table-baru").load("tabel_pesanan_barang.php?no_faktur=<?php echo $no_faktur; ?>");
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

<script type="text/javascript">
  
   $(document).ready(function(){

      var kode_pelanggan = $("#kd_pelanggan").val();

      var level_harga = $(".opt-pelanggan-"+kode_pelanggan+"").attr("data-level");

      if(kode_pelanggan == 'Umum'){


        $("#level_harga").val('Level 1');
      }
else {
$("#level_harga").val(level_harga);

}
    

      });


</script>
 

<!--menampilkan perintah javascript-->
<script type="text/javascript">

        $(document).ready(function(){
        
        $("#kode_barang").focus(function(){

         $(document).ready(function(){
          var no_faktur = $("#nomor_faktur_penjualan").val();
        
        $.post("cek_total_bayar_pesanan_barang.php",
        {
        no_faktur:no_faktur
        },
        function(data){
        $("#total2").val(data);

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
              
              var t_tax = ((parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) * parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(tax,10)))))) / 100);

              var total_akhir = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) + Math.round(parseInt(t_tax,10));
              
              
              $("#total1").val(tandaPemisahTitik(total_akhir));

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');

              }
        

        $("#tax_rp").val(parseInt(t_tax));


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
    var stok = jumlahbarang - jumlah_barang;
    

    if (stok < 0){

      alert ("Jumlah Melebihi Stok!");
      $("#jumlah_barang").val('');
    }

    else if( limit_stok > stok  ){

      alert ("Persediaan Barang Ini Sudah Mencapai Batas Limit Stok, Segera Lakukan Pembelian !");
    }
  });
})

</script>



  <script type="text/javascript">
  $(document).ready(function() {

        var no_faktur = $("#nomor_faktur_penjualan"
).val();
        
        $.post("cek_total_bayar_pesanan_barang.php",
        {
        no_faktur: no_faktur
        },
        function(data){
        $("#total2").val(data);

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
        $(document).ready(function(){
        
        $("#potongan_persen").keyup(function(){

        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val()))));
        var total1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val()))));
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val()))));
        var potongan_penjualan = ((total * potongan_persen) / 100);
        var tax = $("#tax").val();

        if (tax == "") {
        tax = 0;
      }

      
        var sisa_potongan = total - potongan_penjualan;
             
             var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(t_tax,10);
             var kredit = parseInt(hasil_akhir,10) - parseInt(pembayaran,10);
        
        if (potongan_persen > 100) {
          alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
        }

        
        
        $("#total1").val(tandaPemisahTitik(parseInt(hasil_akhir)));
        $("#potongan_penjualan").val(tandaPemisahTitik(parseInt(potongan_penjualan)));
        $("#kredit").val(tandaPemisahTitik(kredit));

      });

        $("#potongan_penjualan").keyup(function(){

        var potongan_penjualan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val()))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
       var total1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val()))));
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val()))));
        var potongan_persen = ((potongan_penjualan / total) * 100);
        var tax = $("#tax").val();

        if (tax == "") {
        tax = 0;
      }



        var sisa_potongan = total - potongan_penjualan;
        
             var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(t_tax,10);
             
        var kredit = parseInt(hasil_akhir,10) - parseInt(pembayaran,10);
        
        $("#total1").val(tandaPemisahTitik(parseInt(hasil_akhir)));
        $("#potongan_persen").val(parseInt(potongan_persen));
        $("#kredit").val(tandaPemisahTitik(kredit));

      });
        
        $("#tax").keyup(function(){

        var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val()))))
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


             var kredit = parseInt(total,10) - parseInt(pembayaran,10);
              
              var t_tax = ((parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) * parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(tax,10)))))) / 100);

              var total_akhir = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) + Math.round(parseInt(t_tax,10));
              
              
              $("#total1").val(tandaPemisahTitik(total_akhir));
              $("#kredit").val(tandaPemisahTitik(kredit));

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');

              }
        

        $("#tax_rp").val(parseInt(t_tax));


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
              
              var t_tax = ((parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) * parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(tax,10)))))) / 100);

              var total_akhir = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) + Math.round(parseInt(t_tax,10));
              
              
              $("#total1").val(tandaPemisahTitik(total_akhir));

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');

              }
        

        $("#tax_rp").val(parseInt(t_tax));


        });
        });
        
        </script>




      <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
      
      </script>




    <script type="text/javascript">
    $(document).ready(function(){
      
//fungsi hapus data 
    $(".btn-hapus-tbs").click(function(){
    var nama_barang = $(this).attr("data-barang");
    var id = $(this).attr("data-id");
    var kode_barang = $(this).attr("data-kode-barang");

        $.post("hapus_pesanan_barang.php",{id:id,kode_barang:kode_barang},function(data){
    if (data == 'sukses') {


    $(".tr-id-"+id+"").remove();
    $("#pembayaran_penjualan").val('');
    $("#kode_barang").focus();
    
    }
    });

    });
    

//end function edit data

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
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){

          var no_faktur = $("#nomor_faktur_penjualan").val();
          var kode_barang = $(this).val();

          var level_harga = $("#level_harga").val();

            $.post("cek_jumlah_tbs.php",
            {
            no_faktur:no_faktur,kode_barang:kode_barang
            },
            function(data){
            $("#jumlah_barang_tbs").val(data);
            });


          
          $.post("cek_barang_penjualan.php",
          {
          kode_barang: kode_barang
          },
          function(data){
          $("#jumlahbarang").val(data);
          });

          $.post('cek_kode_barang_edit_tbs_penjualan.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
          
          if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain");
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          $("#kode_barang").focus();
          }//penutup if
          
          });////penutup function(data)

      $.getJSON('lihat_nama_barang.php',{kode_barang:$(this).val()}, function(json){
      
      if (json == null)
      {
        
        $('#nama_barang').val('');
        $('#harga_produk').val('');
        $('#limit_stok').val('');
        $('#satuan_produk').val('');
       

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
          var no_faktur = $("#nomor_faktur_penjualan"
).val();
        
        $.post("cek_total_bayar_pesanan_barang.php",
        {
        no_faktur: no_faktur
        },
        function(data){
        $("#total2").val(data);


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
                                    var jumlah_lama = $("#text-jumlah-"+id+"").text();

                                    if (jumlah_lama == "") {
                                      jumlah_lama = 0;
                                    }

                                    var satuan_konversi = $(this).attr("data-satuan");
                                     var no_faktur = $("#no_faktur0").val();
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
                                   
                                    var subtotal = harga * jumlah_baru - potongan;

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

                                    subtotal_penjualan = subtotal_penjualan - subtotal_lama + subtotal;

                                    var tax_tbs = tax / subtotal_lama * 100;
                                    var jumlah_tax = tax_tbs * subtotal / 100;

                                    if (jumlah_baru == 0) {
                                      alert ("Jumlah Retur Tidak Boleh 0!");

                                      $("#input-jumlah-"+id+"").val(jumlah_lama);
                                       $("#text-jumlah-"+id+"").text(jumlah_lama);
                                       $("#text-jumlah-"+id+"").show();
                                       $("#input-jumlah-"+id+"").attr("type", "hidden");
                                    }

                                    else{

                                      $.post("cek_stok_edit_penjualan.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru,satuan_konversi:satuan_konversi,no_faktur:no_faktur},function(data){
                                       if (data < 0) {

                                       alert ("Jumlah Yang Di Masukan Melebihi Stok !");

                                       $("#input-jumlah-"+id+"").val(jumlah_lama);
                                       $("#text-jumlah-"+id+"").text(jumlah_lama);
                                       $("#text-jumlah-"+id+"").show();
                                       $("#input-jumlah-"+id+"").attr("type", "hidden");

                                     }

                                      else{

                                     $.post("update_pesanan_barang.php",{jumlah_lama:jumlah_lama,jumlah_tax:jumlah_tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang, potongan:potongan,harga:harga,subtotal:subtotal},function(info){


                                    
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#text-tax-"+id+"").text(jumlah_tax);
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total2").val(tandaPemisahTitik(subtotal_penjualan));         

                                    });

                                   }

                                 });

                                    }

                                  


       
                                    $("#kode_barang").focus();

                                 });

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
//berfunsi untuk mencekal username ganda
$(document).on('click', '.pilih', function (e) {
    var no_faktur = $("#nomor_faktur_penjualan").val();
    var kode_barang = $("#kode_barang").val();
 $.post('cek_kode_barang_edit_tbs_penjualan.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
   }//penutup if


    });////penutup function(data)
    });//penutup click(function()
</script>


<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>