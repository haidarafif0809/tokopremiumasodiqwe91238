<?php session_start();
    include 'sanitasi.php';
    include 'db.php';


$session_id = session_id();

    $perintah = $db->query("SELECT * FROM barang ORDER BY id DESC");



    ?>

      <table id="tableuser" class="table table-bordered">

        <!-- membuat nama kolom tabel -->
        <thead>

            <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Harga Beli </th>
            <th> Harga Jual Level 1</th>
            <th> Harga Jual Level 2</th>
            <th> Harga Jual Level 3</th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>
            <th> Kategori </th>
            <!--
            <th> Gudang </th>
            -->
            <th> Status </th>
            <th> Tipe </th>
            <th> Suplier </th>
            <th> Foto </th>
            <th>Limit Stok</th>
            <th>Over Stok</th>
            
     
<?php  
include 'db.php';

$pilih_akses_barang_hapus = $db->query("SELECT item_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND item_hapus = '1'");
$barang_hapus = mysqli_num_rows($pilih_akses_barang_hapus);


    if ($barang_hapus > 0){

            echo "<th> Hapus </th>";
        }
    ?>

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
    // menyimpan data sementara yang ada di $perintah
    while ($data1 = mysqli_fetch_array($perintah))
    {


        $select_gudang = $db->query("SELECT nama_gudang FROM gudang WHERE kode_gudang = '$data1[gudang]'");
        $ambil_gudang = mysqli_fetch_array($select_gudang);
        // menampilkan file yang ada di masing-masing data dibawah ini
        echo "<tr>
            <td>". $data1['kode_barang'] ."</td>
            <td>". $data1['nama_barang'] ."</td>
            <td class='edit-beli' data-id='".$data1['id']."'><span id='text-beli-".$data1['id']."'>". rp($data1['harga_beli']) ."</span> <input type='hidden' id='input-beli-".$data1['id']."' value='".$data1['harga_beli']."' class='input_beli' data-id='".$data1['id']."' autofocus=''> </td>


            <td class='edit-jual' data-id='".$data1['id']."'><span id='text-jual-".$data1['id']."'>". rp($data1['harga_jual']) ."</span> <input type='hidden' id='input-jual-".$data1['id']."' value='".$data1['harga_jual']."' class='input_jual' data-id='".$data1['id']."' autofocus=''></td>

                                            <td class='edit-jual-2' data-id-2='".$data1['id']."'><span id='text-jual-2-".$data1['id']."'>". rp($data1['harga_jual2']) ."</span> <input type='hidden' id='input-jual-2-".$data1['id']."' value='".$data1['harga_jual2']."' class='input_jual_2' data-id-2='".$data1['id']."' autofocus=''></td>

                                            <td class='edit-jual-3' data-id-3='".$data1['id']."'><span id='text-jual-3-".$data1['id']."'>". rp($data1['harga_jual3']) ."</span> <input type='hidden' id='input-jual-3-".$data1['id']."' value='".$data1['harga_jual3']."' class='input_jual_3' data-id-3='".$data1['id']."' autofocus=''></td>";

       
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


    $perintah100 = $db->query("SELECT * FROM penjualan WHERE status != 'Batal'");



//total barang 2
            $total_2 = $jumlah_penjualan + $jumlah_item_keluar + $jumlah_retur_pembelian;



            $stok_barang = $total_1 - $total_2;



if ($data1['berkaitan_dgn_stok'] == 'Jasa') {

    echo "<td>0</td>";
}
else {
    echo "<td>". $stok_barang ."</td>";
}

// SATUAN
            echo "<td class='edit-satuan' data-id='".$data1['id']."'><span id='text-satuan-".$data1['id']."'>". $data1['satuan'] ."</span> <select style='display:none' id='select-satuan-".$data1['id']."' value='".$data1['id']."' class='select-satuan' data-id='".$data1['id']."' autofocus=''>";


echo '<option value="'. $data1['satuan'] .'"> '. $data1['satuan'] .'</option>';

     $query2 = $db->query("SELECT * FROM satuan");

    while($data2 = mysqli_fetch_array($query2))
    {
    
   echo ' <option value="'.$data2['id'] .'">'.$data2["nama"] .'</option>';
    }


          echo  '</select>
            </td>';



//KATEGORI
        echo "<td class='edit-kategori' data-id='".$data1['id']."'><span id='text-kategori-".$data1['id']."'>". $data1['kategori'] ."</span> <select style='display:none' id='select-kategori-".$data1['id']."' value='".$data1['kategori']."' class='select-kategori' data-id='".$data1['id']."' autofocus=''>";


echo '<option value="'. $data1['kategori'] .'"> '. $data1['kategori'] .'</option>';

     $query2 = $db->query("SELECT * FROM kategori");

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


// STATUS

        echo "<td class='edit-status' data-id='".$data1['id']."'><span id='text-status-".$data1['id']."'>". $data1['status'] ."</span> 
        <select style='display:none' id='select-status-".$data1['id']."' value='".$data1['status']."' class='select-status' data-id='".$data1['id']."' autofocus=''>";


echo '<option value="'. $data1['status'] .'"> '. $data1['status'] .'</option>
            <option> Aktif </option>
            <option>Tidak Aktif </option>';

          echo  '</select>
            </td>';


// Berkaitan Dengan STOK

        echo "<td class='edit-berstok' data-id='".$data1['id']."'><span id='text-berstok-".$data1['id']."'>". $data1['berkaitan_dgn_stok'] ."</span> <select style='display:none' id='select-berstok-".$data1['id']."' value='".$data1['berkaitan_dgn_stok']."' class='select-berstok' data-id='".$data1['id']."' autofocus=''>";


echo '<option value="'. $data1['berkaitan_dgn_stok'] .'"> '. $data1['berkaitan_dgn_stok'] .'</option>
            <option> Barang </option>
            <option> Jasa </option>';

          echo  '</select>
            </td>';


// SUPLIER

        echo "<td class='edit-suplier' data-id='".$data1['id']."'><span id='text-suplier-".$data1['id']."'>". $data1['suplier'] ."</span> <select style='display:none' id='select-suplier-".$data1['id']."' value='".$data1['suplier']."' class='select-suplier' data-id='".$data1['id']."' autofocus=''>";


echo '<option value="'. $data1['suplier'] .'"> '. $data1['suplier'] .'</option>';

     $query2 = $db->query("SELECT * FROM suplier");

    while($data2 = mysqli_fetch_array($query2))
    {
    
   echo ' <option>'.$data2["nama"] .'</option>';
    }

          echo  '</select>
            </td>';



            if ($data1['foto'] == "" ){


                echo "<td><a href='unggah_foto.php?id=". $data1['id']."' class='btn btn-primary'><span class='glyphicon glyphicon-upload'></span> Unggah Foto</a> </td>";
            }

            else{

                echo "<td><img src='save_picture/". $data1['foto'] ."' height='30px' width='60px' > <br><br> <a href='unggah_foto.php?id=". $data1['id']."' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-upload'></span> Edit Foto</a> </td>";

            }
            echo "<td class='edit-limit' data-id='".$data1['id']."'><span id='text-limit-".$data1['id']."'>". $data1['limit_stok'] ."</span> <input type='hidden' id='input-limit-".$data1['id']."' value='".$data1['limit_stok']."' class='input_limit' data-id='".$data1['id']."' autofocus=''></td>

            <td class='edit-over' data-id='".$data1['id']."'><span id='text-over-".$data1['id']."'>". $data1['over_stok'] ."</span> <input type='hidden' id='input-over-".$data1['id']."' value='".$data1['over_stok']."' class='input_over' data-id='".$data1['id']."' autofocus=''></td>";


include 'db.php';

$pilih_akses_barang_hapus = $db->query("SELECT item_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND item_hapus = '1'");
$barang_hapus = mysqli_num_rows($pilih_akses_barang_hapus);


    if ($barang_hapus > 0 AND $stok_barang == '0')        

            {
         
            echo "
            <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."'  data-nama='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
        }



include 'db.php';

$pilih_akses_barang_edit = $db->query("SELECT item_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND item_edit = '1'");
$barang_edit = mysqli_num_rows($pilih_akses_barang_edit);


    if ($barang_edit > 0) {

           if ($stok_barang == '0') 

             {
            echo "<td> <a href='editbarang.php?id=". $data1['id']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit</a> </td>
            </tr>";
            
            }
            
        else{

                echo "<td> </td>";

            }

    }


include 'db.php';

$pilih_akses_barang_edit = $db->query("SELECT item_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND item_edit = '1'");
$barang_edit = mysqli_num_rows($pilih_akses_barang_edit);


    if ($barang_edit > 0 AND $stok_barang != '0')
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

        <script>
        // untuk memunculkan data tabel 
        $(document).ready(function() {
        $('#tableuser').DataTable({"ordering":false});
        });
        
        </script>

                     <script type="text/javascript">
                                 
                        //fungsi hapus data 
                                $(".btn-hapus").click(function(){
                                var nama = $(this).attr("data-nama");
                                var id = $(this).attr("data-id");
                                $("#data_barang").val(nama);
                                $("#id_hapus").val(id);
                                $("#modal_hapus").modal('show');
                                
                                
                                });
                                
                                
                                $("#btn_jadi_hapus").click(function(){
                                
                                var id = $("#id_hapus").val();
                                
                                $.post("hapusbarang.php",{id:id},function(data){
                                if (data != "") {
                                $("#table_baru").load('tabel-barang.php');
                                $("#modal_hapus").modal('hide');
                                
                                }
                                
                                
                                });
                                
                                });
                        // end fungsi hapus data


                             </script>


                            <script type="text/javascript">
                                 
                                 $(".edit-beli").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-beli-"+id+"").hide();

                                    $("#input-beli-"+id+"").attr("type", "text");

                                 });

                                 $(".input_beli").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var input_beli = $(this).val();


                                    $.post("update_barang.php",{id:id, input_beli:input_beli,jenis_edit:"harga_beli"},function(data){

                                    $("#text-beli-"+id+"").show();
                                    $("#text-beli-"+id+"").text(input_beli);

                                    $("#input-beli-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>



                             <script type="text/javascript">
                                 
                                 $(".edit-jual").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-jual-"+id+"").hide();

                                    $("#input-jual-"+id+"").attr("type", "text");

                                 });

                                 $(".input_jual").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var input_jual = $(this).val();


                                    $.post("update_barang.php",{id:id, input_jual:input_jual,jenis_edit:"harga_jual"},function(data){

                                    $("#text-jual-"+id+"").show();
                                    $("#text-jual-"+id+"").text(input_jual);

                                    $("#input-jual-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>


                              <script type="text/javascript">
                                 
                                 $(".edit-kategori").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-kategori-"+id+"").hide();

                                    $("#select-kategori-"+id+"").show();

                                 });

                                 $(".select-kategori").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var select_kategori = $(this).val();


                                    $.post("update_barang.php",{id:id, select_kategori:select_kategori,jenis_select:"kategori"},function(data){

                                    $("#text-kategori-"+id+"").show();
                                    $("#text-kategori-"+id+"").text(select_kategori);

                                    $("#select-kategori-"+id+"").hide();           

                                    });
                                 });

                             </script>



                             <script type="text/javascript">
                                 
                                 $(".edit-satuan").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-satuan-"+id+"").hide();

                                    $("#select-satuan-"+id+"").show();

                                 });

                                 $(".select-satuan").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var select_satuan = $(this).val();


                                    $.post("update_barang.php",{id:id, select_satuan:select_satuan,jenis_select:"satuan"},function(data){

                                    $("#text-satuan-"+id+"").show();
                                    $("#text-satuan-"+id+"").text(select_satuan);

                                    $("#select-satuan-"+id+"").hide();           

                                    });
                                 });

                             </script>

                             <script type="text/javascript">
                                 
                                 $(".edit-berstok").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-berstok-"+id+"").hide();

                                    $("#select-berstok-"+id+"").show();

                                 });

                                 $(".select-berstok").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var select_berstok = $(this).val();


                                    $.post("update_barang.php",{id:id, select_berstok:select_berstok,jenis_select:"_berkaitan_dgn_stok"},function(data){

                                    $("#text-berstok-"+id+"").show();
                                    $("#text-berstok-"+id+"").text(select_berstok);

                                    $("#select-berstok-"+id+"").hide();           

                                    });
                                 });

                             </script>



                             <script type="text/javascript">
                                 
                                 $(".edit-status").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-status-"+id+"").hide();

                                    $("#select-status-"+id+"").show();

                                 });

                                 $(".select-status").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var select_status = $(this).val();


                                    $.post("update_barang.php",{id:id, select_status:select_status,jenis_select:"status"},function(data){

                                    $("#text-status-"+id+"").show();
                                    $("#text-status-"+id+"").text(select_status);

                                    $("#select-status-"+id+"").hide();           

                                    });
                                 });

                             </script>



                              <script type="text/javascript">
                                 
                                 $(".edit-suplier").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-suplier-"+id+"").hide();

                                    $("#select-suplier-"+id+"").show();

                                 });

                                 $(".select-suplier").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var select_suplier = $(this).val();


                                    $.post("update_barang.php",{id:id, select_suplier:select_suplier,jenis_select:"suplier"},function(data){

                                    $("#text-suplier-"+id+"").show();
                                    $("#text-suplier-"+id+"").text(select_suplier);

                                    $("#select-suplier-"+id+"").hide();           

                                    });
                                 });

                             </script>