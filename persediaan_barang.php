<?php  include 'session_login.php';
    // memasukan file login, header, navbar, dan db.
    
    include 'header.php';
    include 'navbar.php';
    include 'sanitasi.php';
    include 'db.php';

$kategori = $_GET['kategori'];
$tipe = $_GET['tipe'];



if ($tipe == 'barang') {

    if ($kategori == 'semua' AND $tipe = 'barang') {
    
    $perintah = $db->query("SELECT s.nama,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,b.kategori,b.gudang FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.berkaitan_dgn_stok = '$tipe' ORDER BY b.id DESC");
    
    }

    else{
    $perintah = $db->query("SELECT s.nama,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,b.kategori,b.gudang FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.kategori = '$kategori' AND b.berkaitan_dgn_stok = '$tipe' ORDER BY b.id DESC");
    }

    
}

else{


    if ($kategori == 'semua') {
    
    $perintah = $db->query("SELECT s.nama,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,b.kategori,b.gudang FROM barang b INNER JOIN satuan s ON b.satuan = s.id ORDER BY b.id DESC");
    
    }
    
    else{
    $perintah = $db->query("SELECT s.nama,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,b.kategori,b.gudang FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.kategori = '$kategori' ORDER BY b.id DESC");
    }

}


    ?>


<div class="container">
<h3><b>DATA ITEM</b></h3><hr>


<div class="row">
    <div class="col-sm-4">
        
<?php  
include 'db.php';

$pilih_akses_barang_tambah = $db->query("SELECT item_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND item_tambah = '1'");
$barang_tambah = mysqli_num_rows($pilih_akses_barang_tambah);


    if ($barang_tambah > 0){

echo '<br><button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> </i> ITEM </button> <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#my_Modal"><i class="fa fa-upload"> </i> Import Data Excell
</button>    <a href="export_barang.php" style="width: 170px;" type="submit" id="btn-export" class="btn btn-danger"><i class="fa fa-download"> </i> Download Excel</a>';
    }
?>
    </div>

    <div class="col-sm-8">
       

<?php  

        if ($tipe == 'barang') {
        
        echo "<ul class='nav nav-tabs md-pills pills-ins' role='tablist'>
        <li class='nav-item'><a class='nav-link active' href='persediaan_barang.php?kategori=semua&tipe=barang'> Semua Item </a></li>";
        
        }
        
        else{
        echo "<ul class='nav nav-tabs md-pills pills-ins' role='tablist'>
        <li class='nav-item'><a class='nav-link active' href='persediaan_barang.php?kategori=semua&tipe=barang_jasa'> Semua Item </a></li>";        
        }

          include 'db.php';
          $pilih_kategori = $db->query("SELECT * FROM kategori");
          
          while ($cek = mysqli_fetch_array($pilih_kategori)) 
          {
          

        if ($tipe == 'barang') {

          echo "<li class='nav-item'>
          <a class='nav-link active' href='persediaan_barang.php?kategori=". $cek['nama_kategori'] ."&tipe=barang' > ". $cek['nama_kategori'] ." </a>
          </li>";

        }

        else{
            echo "<li class='nav-item'>
          <a class='nav-link active' href='persediaan_barang.php?kategori=". $cek['nama_kategori'] ."&tipe=barang_jasa' > ". $cek['nama_kategori'] ." </a>
          </li>";
        }

         }


          echo "</ul>";

?> 
    </div>
</div>




    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Tambah Barang</h3>
                </div>
                <div class="modal-body">

                    <form enctype="multipart/form-data" role="form" action="prosesbarang.php" method="post">

                        <div class="form-group">
                            <label> Kode Barang </label>
                            <br>
                            <input type="text" placeholder="Kode Barang" name="kode_barang" id="kode_barang" class="form-control" autocomplete="off" required="">
                        </div>



                        <div class="form-group">
                            <label>Nama Barang </label>
                            <br>
                            <input type="text" placeholder="Nama Barang" name="nama_barang" id="nama_barang" class="form-control" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <label> Harga Beli </label>
                            <br>
                            <input type="text" placeholder="Harga Beli" name="harga_beli" id="harga_beli" class="form-control" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <label> Harga Jual Level 1</label>
                            <br>
                            <input type="text" placeholder="Harga Jual Level 1" name="harga_jual" id="harga_jual" class="form-control" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <label> Harga Jual Level 2</label>
                            <br>
                            <input type="text" placeholder="Harga Jual Level 2" name="harga_jual_2" id="harga_jual2" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label> Harga Jual Level 3</label>
                            <br>
                            <input type="text" placeholder="Harga Jual Level 3" name="harga_jual_3" id="harga_jual3" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label> Satuan </label>
                            <br>
                            <select type="text" name="satuan" class="form-control" required="">
                    
                            <?php 
                            
                            // memasukan file db.php
                            include 'db.php';
                            
                            // menampilkan seluruh data yang ada di tabel satuan
                            $query = $db->query("SELECT * FROM satuan ");
                            
                            // menyimpan data sementara yang ada pada $query
                            while($data = mysqli_fetch_array($query))
                            {
                            
                            echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
                            }
                            
                            
                            ?>
                            </select>
                            </div>

 <div class="form-group">
                            <label> Kategori </label>
                            <br>
                            <select type="text" name="kategori" class="form-control" required="">
                            <option value=""> -- SILAHKAN PILIH -- </option>
<?php 

$ambil_kategori = $db->query("SELECT * FROM kategori");

    while($data_kategori = mysqli_fetch_array($ambil_kategori))
    {
    
    echo "<option>".$data_kategori['nama_kategori'] ."</option>";

    }

 ?>
                            </select>
                            </div>

                        <div class="form-group" style="display: none">
                            <label> Gudang </label>
                            <br>
                            <select type="text" name="gudang" class="form-control" >
                            <option value=""> -- SILAHKAN PILIH -- </option>
                    
                            <?php 
                            
                            // memasukan file db.php
                            include 'db.php';
                            
                            // menampilkan seluruh data yang ada di tabel satuan
                            $query = $db->query("SELECT * FROM gudang ");
                            
                            // menyimpan data sementara yang ada pada $query
                            while($data = mysqli_fetch_array($query))
                            {
                            
                            echo "<option value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";
                            }
                            
                            
                            ?>
                            </select>
                            </div>

                            
                            <!-- label STATUS & SUPLIER berada pada satu form group -->
                            <div class="form-group">
                            <label> Status </label>
                            <br>
                            <select type="text" name="status" class="form-control" required="">
                            <option value=""> -- SILAHKAN PILIH -- </option>
                            <option> Aktif </option>
                            <option> Tidak Aktif</option>
                            </select>
                            </div>

                            <div class="form-group">
                            <label> Tipe </label>
                            <br>
                            <select type="text" name="tipe" class="form-control" required="">
                            <option value=""> -- SILAHKAN PILIH -- </option>
                            <option> Barang </option>
                            <option> Jasa </option>
                            </select>
                            </div>

                            <div class="form-group">
                            <label> Suplier </label>
                            <br>
                            <select type="text" name="suplier" class="form-control">                            
                            <?php 
                            include 'db.php';
                            
                            // menampilkan data yang ada pada tabel suplier
                            $query = $db->query("SELECT * FROM suplier ");
                            
                            // menyimpan data sementara yang ada pada $query
                            while($data = mysqli_fetch_array($query))
                            {
                            
                            echo "<option>".$data['nama'] ."</option>";
                            }
                            
                            
                            ?>
                            </select>
                            </div>

                        <div class="form-group">
                            <label> Limit Stok </label>
                            <br>
                            <input type="text" placeholder="Limit Stok" name="limit_stok" id="limit_stok" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label> Over Stok </label>
                            <br>
                            <input type="text" placeholder="Over Stok" name="over_stok" id="over_stok" class="form-control" autocomplete="off">
                        </div>

                            
                            
                            
                            

                       


<!-- membuat tombol submit -->
<button type="submit" name="submit" value="submit" class="btn btn-info">Tambah</button>
</form>
</div>


<!--button penutup-->
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>


</div>

</div>
</div>


<div id="my_Modal" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Import Data Excell</h4>
      </div>

      <div class="modal-body">
   
   
   <form enctype="multipart/form-data" action="proses_import.php?" method="post" >
    <div class="form-group">
        <label> Import Data Excell</label>
        <input type="file" id="file_import" name="import_excell" required=""> 
        <br>
        <br>

        <!-- membuat tombol submit -->
        
         
    </div>
   <button type="submit" name="submit" value="submit" class="btn btn-info">Import</button>
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

    <div class="modal-footer">

    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

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
        <h4 class="modal-title">Konfirmasi Hapus Data Barang</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
        <label> Nama Barang :</label>
        <input type="text" id="data_barang" class="form-control" autocomplete="off" readonly=""> 
        <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
</style>
          <ul class="nav nav-tabs md-pills pills-ins" role="tablist">
          <?php if ($tipe == 'barang'): ?>

          <li class="nav-item"><a class="nav-link active" href='persediaan_barang.php?kategori=semua&tipe=barang'> Umum </a></li>
          <li class="nav-item"><a class="nav-link" href='persediaan_barang2.php?kategori=semua&tipe=barang' > Lain - lain </a></li>
          <li class="nav-item"><a class="nav-link" href='menu_filter_stok_produk.php?kategori=semua&tipe=barang'> Filter Stok Produk </a></li>

          <?php else: ?>


          <li class="nav-item"><a class="nav-link active" href='persediaan_barang.php?kategori=semua&tipe=barang_jasa'> Umum </a></li>
          <li class="nav-item"><a class="nav-link" href='persediaan_barang2.php?kategori=semua&tipe=barang_jasa' > Lain - lain </a></li>
          <li class="nav-item"><a class="nav-link" href='menu_filter_stok_produk.php?kategori=semua&tipe=barang_jasa' > Filter Stok Produk </a></li>
              
          <?php endif ?>
          
          
          
          </ul>
<!-- membuat table dan garis tabel-->
<div class="table-responsive">
          
<span id="table_baru">
    <table id="tableuser" class="table table-bordered">

        <!-- membuat nama kolom tabel -->
        <thead>

            <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Harga Beli </th>
            <th> Margin </th>
            <th> Harga Jual Level 1</th>
            <th> Harga Jual Level 2</th>
            <th> Harga Jual Level 3</th>
            <th> HPP</th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>

            <th> Kategori </th>
            <!--
            <th> Gudang </th>
            -->
            <th> Hapus </th>

<?php  
include 'db.php';

$pilih_akses_barang_edit = $db->query("SELECT item_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND item_edit = '1'");
$barang_edit = mysqli_num_rows($pilih_akses_barang_edit);


    if ($barang_edit > 0){
                            echo    "<th> Edit </th>";

                        }
             ?>
            
           </thead>

        <tbody>
            
        <?php
    
$total_akhir_hpp = 0;
    // menyimpan data sementara yang ada di $perintah
    while ($data1 = mysqli_fetch_array($perintah))
    {

$a = $data1['harga_beli'];
$b = $data1['harga_jual'];
if($data1['harga_jual']== '0'){
 $f = 0; 
}
else{
//Gross Profit Margin itu rumusnya (harga jual-harga beli)/Harga jual x 100%
$c = $data1['harga_jual'] - $data1['harga_beli'];
$d = $c;
$e =  ($d / $b) * 100;
$f = round($e, 2);
}




        $select_gudang = $db->query("SELECT nama_gudang FROM gudang WHERE kode_gudang = '$data1[gudang]'");
        $ambil_gudang = mysqli_fetch_array($select_gudang);

        $select1 = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_masuk FROM hpp_masuk WHERE kode_barang = '$data1[kode_barang]'");
        $masuk = mysqli_fetch_array($select1);

        $select2 = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_keluar FROM hpp_keluar WHERE kode_barang = '$data1[kode_barang]'");
        $keluar = mysqli_fetch_array($select2);

        $jumlah_barang = $masuk['jumlah_masuk'] - $keluar['jumlah_keluar'];



            $hpp_masuk = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE kode_barang = '$data1[kode_barang]'");
            $cek_awal_masuk = mysqli_fetch_array($hpp_masuk);
            
            $hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE kode_barang = '$data1[kode_barang]'");
            $cek_awal_keluar = mysqli_fetch_array($hpp_keluar);

            $total_hpp = $cek_awal_masuk['total_hpp'] - $cek_awal_keluar['total_hpp'];

$total_akhir_hpp = $total_akhir_hpp + $total_hpp;

        echo "<tr class='tr-id-".$data1['id']."' data-kode='".$data1['kode_barang']."'>
            <td>". $data1['kode_barang'] ."</td>
            <td>". $data1['nama_barang'] ."</td>
            <td class='edit-beli' data-id='".$data1['id']."'><span id='text-beli-".$data1['id']."'>". rp($data1['harga_beli']) ."</span> 
            <input type='hidden' id='input-beli-".$data1['id']."' value='".$data1['harga_beli']."' class='input_beli' 
            data-id='".$data1['id']."' data-kode='".$data1['kode_barang']."' autofocus=''> </td>

            <td>".persen($f)."</td>
            <td class='edit-jual' data-id='".$data1['id']."'><span id='text-jual-".$data1['id']."'>". rp($data1['harga_jual']) ."</span> 
            <input type='hidden' id='input-jual-".$data1['id']."' value='".$data1['harga_jual']."' class='input_jual' data-id='".$data1['id']."' 
            data-kode='".$data1['kode_barang']."' autofocus=''></td>

            <td class='edit-jual-2' data-id-2='".$data1['id']."'><span id='text-jual-2-".$data1['id']."'>". rp($data1['harga_jual2']) ."</span> 
            <input type='hidden' id='input-jual-2-".$data1['id']."' value='".$data1['harga_jual2']."' class='input_jual_2' data-id-2='".$data1['id']."' 
            data-kode='".$data1['kode_barang']."' autofocus=''></td>

            <td class='edit-jual-3' data-id-3='".$data1['id']."'><span id='text-jual-3-".$data1['id']."'>". rp($data1['harga_jual3']) ."</span> 
            <input type='hidden' id='input-jual-3-".$data1['id']."' value='".$data1['harga_jual3']."' class='input_jual_3' data-id-3='".$data1['id']."'
            data-kode='".$data1['kode_barang']."'  autofocus=''></td>";

            echo "<td>". $total_hpp ."</td>";

            
if ($data1['berkaitan_dgn_stok'] == 'Jasa') {

    echo "<td>0</td>";
}
else {
    echo "<td>". $jumlah_barang ."</td>";
}

// SATUAN
            echo "<td class='edit-satuan' data-id='".$data1['id']."'><span id='text-satuan-".$data1['id']."'>". $data1['nama'] ."</span> 
            <select style='display:none' id='select-satuan-".$data1['id']."' value='".$data1['id']."' class='select-satuan' data-id='".$data1['id']."' 
            data-kode='".$data1['kode_barang']."' autofocus=''>";


echo '<option value="'. $data1['satuan'] .'"> '. $data1['nama'] .'</option>';

     $query2 = $db->query("SELECT id, nama FROM satuan");

    while($data2 = mysqli_fetch_array($query2))
    {
    
   echo ' <option id="nama-satuan-'.$data2['id'].'" data-nama="'.$data2['nama'].'" value="'.$data2['id'] .'">'.$data2["nama"] .'</option>';
    }


          echo  '</select>
            </td>';


//KATEGORI
        echo "<td class='edit-kategori' data-id='".$data1['id']."'><span id='text-kategori-".$data1['id']."'>". $data1['kategori'] ."</span> 
        <select style='display:none' id='select-kategori-".$data1['id']."' value='".$data1['kategori']."' class='select-kategori' 
        data-kode='".$data1['kode_barang']."' data-id='".$data1['id']."' autofocus=''>";


echo '<option value="'. $data1['kategori'] .'"> '. $data1['kategori'] .'</option>';

     $query2 = $db->query("SELECT nama_kategori FROM kategori");

    while($data2 = mysqli_fetch_array($query2))
    {
    
   echo ' <option>'.$data2["nama_kategori"] .'</option>';
    }


          echo  '</select>
            </td>';


            //GUDANG
            /*
        echo "<td class='edit-gudang' data-id='".$data1['id']."'><span id='text-gudang-".$data1['id']."'>". $ambil_gudang['nama_gudang'] ."</span> <select style='display:none' id='select-gudang-".$data1['id']."' data-nama='".$ambil_gudang['nama_gudang']."' value='".$data1['gudang']."' class='select-gudang' data-id='".$data1['id']."' autofocus=''>";


echo '<option value="'. $data1['gudang'] .'"> '. $ambil_gudang['nama_gudang'] .'</option>';

     $query2 = $db->query("SELECT * FROM gudang");

    while($data2 = mysqli_fetch_array($query2))
    {
    
   echo ' <option value="'.$data2["kode_gudang"] .'">'.$data2["nama_gudang"] .'</option>';
    }


          echo  '</select>
            </td>';
            */





include 'db.php';

$pilih_akses_barang_hapus = $db->query("SELECT item_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND item_hapus = '1'");
$barang_hapus = mysqli_num_rows($pilih_akses_barang_hapus);


    if ($barang_hapus > 0 AND ($jumlah_barang == '0' OR $jumlah_barang == ''))      

            {
         
            echo "
            <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."'  data-nama='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
            }
        else
        {
            echo "<td>Tidak Bisa dihapus</td>";
        }


include 'db.php';

$pilih_akses_barang_edit = $db->query("SELECT item_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND item_edit = '1'");
$barang_edit = mysqli_num_rows($pilih_akses_barang_edit);


    if ($barang_edit > 0) {

           if ($jumlah_barang == '0') 

             {
            echo "<td> <a href='editbarang.php?id=". $data1['id']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit</a> </td>
            </tr>";
            
            }

    }


include 'db.php';

$pilih_akses_barang_edit = $db->query("SELECT item_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND item_edit = '1'");
$barang_edit = mysqli_num_rows($pilih_akses_barang_edit);


    if ($barang_edit > 0 AND $jumlah_barang != '0')
            {

            echo "<td> <a href='editbarang.php?id=". $data1['id']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit</a> </td>";
            }

            "</tr>";
         
        }

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
    ?>
        </tbody>

    </table>
        <h6 style="text-align: left ; color: red"><i> * Jika barang sudah terjadi transaksi maka barang tersebut tidak dapat dihapus.</i></h6>
</span>

</div> <!-- penutup table responsive -->

<h3 style="color:red">TOTAL HPP : <?php echo rp($total_akhir_hpp); ?></h3>

</div><!-- penutup tag div clas="container" -->


<script>
// untuk memunculkan data tabel 
$(document).ready(function() {
        $('#tableuser').DataTable({"ordering":false});
    });

</script>


<script type="text/javascript">

               $(document).ready(function(){
               $("#kode_barang").blur(function(){
               var kode_barang = $("#kode_barang").val();

              $.post('cek_kode_barang.php',{kode_barang:$(this).val()}, function(data){
                
                if(data == 1){

                    alert ("Kode Barang Sudah Ada");
                    $("#kode_barang").val('');
                }
                else {
                    
                }
              });
                
               });
               });

</script>

                             

                             <script type="text/javascript">
                                 
//fungsi hapus data 
                                $(document).on('click','.btn-hapus',function(e){

                                var nama = $(this).attr("data-nama");
                                var id = $(this).attr("data-id");
                                $("#data_barang").val(nama);
                                $("#id_hapus").val(id);
                                $("#modal_hapus").modal('show');
                                
                                
                                });
                                
                                
                                $(document).on('click','#btn_jadi_hapus',function(e){
                                var id = $("#id_hapus").val();
                                var kode_barang = $(".tr-id-"+id).attr("data-kode");

                                $("#modal_hapus").modal('hide');
                                $(".tr-id-"+id).remove();
                                $.post("hapusbarang.php",{id:id,kode_barang:kode_barang},function(data){
                                                            
                                });
                                
                                });
                        // end fungsi hapus data



                             </script>







                             <script type="text/javascript">
                                 
                                $(document).on('dblclick','.edit-beli',function(e){

                                    var id = $(this).attr("data-id");

                                    $("#text-beli-"+id+"").hide();

                                    $("#input-beli-"+id+"").attr("type", "text");

                                 });

                                $(document).on('blur','.input_beli',function(e){

                                    var id = $(this).attr("data-id");

                                    var input_beli = $(this).val();

                                    var kode_barang = $("#input-beli-"+id).attr("data-kode");


                                    $.post("update_barang.php",{id:id, input_beli:input_beli,kode_barang:kode_barang,jenis_edit:"harga_beli"},function(data){

                                    $("#text-beli-"+id+"").show();
                                    $("#text-beli-"+id+"").text(input_beli);

                                    $("#input-beli-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>



                             <script type="text/javascript">
                                 
                                $(document).on('dblclick','.edit-jual',function(e){

                                    var id = $(this).attr("data-id");

                                    $("#text-jual-"+id+"").hide();

                                    $("#input-jual-"+id+"").attr("type", "text");

                                 });

                                $(document).on('blur','.input_jual',function(e){

                                    var id = $(this).attr("data-id");

                                    var input_jual = $(this).val();

                                    var kode_barang = $("#input-jual-"+id).attr("data-kode");


                                    $.post("update_barang.php",{id:id, input_jual:input_jual,kode_barang:kode_barang,jenis_edit:"harga_jual"},function(data){

                                    $("#text-jual-"+id+"").show();
                                    $("#text-jual-"+id+"").text(input_jual);

                                    $("#input-jual-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>

                             <script type="text/javascript">
                                 
                                $(document).on('dblclick','.edit-jual-2',function(e){

                                    var id = $(this).attr("data-id-2");

                                    $("#text-jual-2-"+id+"").hide();

                                    $("#input-jual-2-"+id+"").attr("type", "text");

                                 });

                                $(document).on('blur','.input_jual_2',function(e){

                                    var id = $(this).attr("data-id-2");

                                    var input_jual_2 = $(this).val();

                                    var kode_barang = $("#input-jual-2-"+id).attr("data-kode");


                                    $.post("update_barang.php",{id:id, input_jual_2:input_jual_2,kode_barang:kode_barang,jenis_edit:"harga_jual_2"},function(data){

                                    $("#text-jual-2-"+id+"").show();
                                    $("#text-jual-2-"+id+"").text(input_jual_2);

                                    $("#input-jual-2-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>

                            <script type="text/javascript">
                                 
                                $(document).on('dblclick','.edit-jual-3',function(e){

                                    var id = $(this).attr("data-id-3");

                                    $("#text-jual-3-"+id+"").hide();

                                    $("#input-jual-3-"+id+"").attr("type", "text");

                                 });

                                $(document).on('blur','.input_jual_3',function(e){

                                    var id = $(this).attr("data-id-3");

                                    var input_jual_3 = $(this).val();

                                    var kode_barang = $("#input-jual-3-"+id).attr("data-kode");


                                    $.post("update_barang.php",{id:id, input_jual_3:input_jual_3,kode_barang:kode_barang,jenis_edit:"harga_jual_3"},function(data){

                                    $("#text-jual-3-"+id+"").show();
                                    $("#text-jual-3-"+id+"").text(input_jual_3);

                                    $("#input-jual-3-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>


                              <script type="text/javascript">
                                 
                                $(document).on('dblclick','.edit-kategori',function(e){


                                    var id = $(this).attr("data-id");

                                    $("#text-kategori-"+id+"").hide();

                                    $("#select-kategori-"+id+"").show();

                                 });

                                $(document).on('blur','.select-kategori',function(e){

                                    var id = $(this).attr("data-id");

                                    var select_kategori = $(this).val();

                                    var kode_barang = $("#select-kategori-"+id).attr("data-kode");


                                    $.post("update_barang.php",{id:id, select_kategori:select_kategori,kode_barang:kode_barang,jenis_edit:"kategori"},function(data){

                                    $("#text-kategori-"+id+"").show();
                                    $("#text-kategori-"+id+"").text(select_kategori);

                                    $("#select-kategori-"+id+"").hide();           

                                    });
                                 });

                             </script>


                              <script type="text/javascript">
                                 
                                $(document).on('dblclick','.edit-gudang',function(e){

                                    var id = $(this).attr("data-id");

                                    $("#text-gudang-"+id+"").hide();

                                    $("#select-gudang-"+id+"").show();

                                 });

                                $(document).on('blur','.select-gudang',function(e){

                                    var id = $(this).attr("data-id");

                                    var select_gudang = $(this).val();

                                    var kode_barang = $("#select-gudang-"+id).attr("data-kode");

                                    $.post("update_barang.php",{id:id, select_gudang:select_gudang,kode_barang:kode_barang,jenis_edit:"gudang"},function(data){

                                    $("#text-gudang-"+id+"").show();
                                    $("#text-gudang-"+id+"").text(select_gudang);

                                    $("#select-gudang-"+id+"").hide();           

                                    });
                                 });

                             </script>



                             <script type="text/javascript">
                                 
                                $(document).on('dblclick','.edit-satuan',function(e){

                                    var id = $(this).attr("data-id");

                                    $("#text-satuan-"+id+"").hide();

                                    $("#select-satuan-"+id+"").show();

                                 });

                                $(document).on('blur','.select-satuan',function(e){

                                    var id = $(this).attr("data-id");

                                    var select_satuan = $(this).val();
                                    var kode_barang = $("#select-satuan-"+id).attr("data-kode");

                                    var nama_satuan = $("#nama-satuan-"+select_satuan).attr("data-nama");


                                    $.post("update_barang.php",{id:id, select_satuan:select_satuan,kode_barang:kode_barang,jenis_edit:"satuan"},function(data){

                                    $("#text-satuan-"+id+"").show();
                                    $("#text-satuan-"+id+"").text(nama_satuan);


                                    $("#select-satuan-"+id+"").hide();           

                                    });
                                 });

                             </script>



                             <script type="text/javascript">
                                 
                                $(document).on('dblclick','.edit-status',function(e){

                                    var id = $(this).attr("data-id");

                                    $("#text-status-"+id+"").hide();

                                    $("#select-status-"+id+"").show();

                                 });

                                $(document).on('blur','.select-status',function(e){

                                    var id = $(this).attr("data-id");

                                    var select_status = $(this).val();

                                    var kode_barang = $("#select-status-"+id).attr("data-kode");


                                    $.post("update_barang.php",{id:id, select_status:select_status,kode_barang:kode_barang,jenis_edit:"status"},function(data){

                                    $("#text-status-"+id+"").show();
                                    $("#text-status-"+id+"").text(select_status);

                                    $("#select-status-"+id+"").hide();           

                                    });
                                 });

                             </script>


                             <script type="text/javascript">
                                 
                                $(document).on('dblclick','.edit-berstok',function(e){

                                    var id = $(this).attr("data-id");

                                    $("#text-berstok-"+id+"").hide();

                                    $("#select-berstok-"+id+"").show();

                                 });

                                $(document).on('blur','.select-berstok',function(e){

                                    var id = $(this).attr("data-id");

                                    var select_berstok = $(this).val();
                                    var kode_barang = $("#select-berstok-"+id).attr("data-kode");


                                    $.post("update_barang.php",{id:id, select_berstok:select_berstok,kode_barang:kode_barang,jenis_edit:"berkaitan_dgn_stok"},function(data){

                                    $("#text-berstok-"+id+"").show();
                                    $("#text-berstok-"+id+"").text(select_berstok);

                                    $("#select-berstok-"+id+"").hide();           

                                    });
                                 });

                             </script>



                              <script type="text/javascript">
                                 
                                $(document).on('dblclick','.edit-suplier',function(e){

                                    var id = $(this).attr("data-id");

                                    $("#text-suplier-"+id+"").hide();

                                    $("#select-suplier-"+id+"").show();

                                 });

                                $(document).on('blur','.select-suplier',function(e){

                                    var id = $(this).attr("data-id");

                                    var select_suplier = $(this).val();

                                    var kode_barang = $("#select-suplier-"+id).attr("data-kode");

                                    $.post("update_barang.php",{id:id, select_suplier:select_suplier,kode_barang:kode_barang,jenis_edit:"suplier"},function(data){

                                    $("#text-suplier-"+id+"").show();
                                    $("#text-suplier-"+id+"").text(select_suplier);

                                    $("#select-suplier-"+id+"").hide();           

                                    });
                                 });

                             </script>


                             <script type="text/javascript">
                                 
                                $(document).on('dblclick','.edit-limit',function(e){

                                    var id = $(this).attr("data-id");

                                    $("#text-limit-"+id+"").hide();

                                    $("#input-limit-"+id+"").attr("type", "text");

                                 });

                                $(document).on('blur','.input_limit',function(e){

                                    var id = $(this).attr("data-id");

                                    var input_limit = $(this).val();

                                    var kode_barang = $("#input-limit-"+id).attr("data-kode");

                                    $.post("update_barang.php",{id:id, input_limit:input_limit,kode_barang:kode_barang,jenis_edit:"limit_stok"},function(data){

                                    $("#text-limit-"+id+"").show();
                                    $("#text-limit-"+id+"").text(input_limit);

                                    $("#input-limit-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>

                             <script type="text/javascript">
                                 
                                $(document).on('dblclick','.edit-over',function(e){

                                    var id = $(this).attr("data-id");

                                    $("#text-over-"+id+"").hide();

                                    $("#input-over-"+id+"").attr("type", "text");

                                 });

                                $(document).on('blur','.input_over',function(e){

                                    var id = $(this).attr("data-id");

                                    var input_over = $(this).val();

                                    var kode_barang = $("#input-over-"+id+"").attr("data-kode");

                                    $.post("update_barang.php",{id:id, input_over:input_over,kode_barang:kode_barang,jenis_edit:"over_stok"},function(data){

                                    $("#text-over-"+id+"").show();
                                    $("#text-over-"+id+"").text(input_over);

                                    $("#input-over-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>

<?php  include 'footer.php'; ?>