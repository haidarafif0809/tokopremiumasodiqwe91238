<?php 

    include 'db.php';
    include 'sanitasi.php';
    
 $nomor_faktur = $_GET['no_faktur'];
// menampilkan seluruh data yang ada pada tabel penjualan yang terdapt pada DB
 $perintah = $db->query("SELECT * FROM penjualan");
 $data100 = mysqli_fetch_array($perintah);

//ambil 2 angka terakhir dari tahun sekarang 
$tahun = $db->query("SELECT YEAR(NOW()) as tahun");
$v_tahun = mysqli_fetch_array($tahun);
 $tahun_terakhir = substr($v_tahun['tahun'], 2);
//ambil bulan sekarang
$bulan = $db->query("SELECT MONTH(NOW()) as bulan");
$v_bulan = mysqli_fetch_array($bulan);
$v_bulan['bulan'];


//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($v_bulan['bulan']);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$v_bulan['bulan'];
 }
 else
 {
  $data_bulan_terakhir = $v_bulan['bulan'];

 }
//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $v_bulan['bulan']) {
  # code...
$no_faktur = "1/JL/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur = $nomor."/JL/".$data_bulan_terakhir."/".$tahun_terakhir;


 }
    ?>

    <table id="tableuser" class="table table-bordered">
                <thead>
                <th> Nomor Faktur </th>
                <th> Kode Barang </th>
                <th> Nama Barang </th>
                <th> Jumlah Barang </th>
                <th> Satuan </th>
                <th> Harga </th>
                <th> Subtotal </th>
                <th> Potongan </th>
                <th> Tax </th>
      <?php 
             if ($_SESSION['otoritas'] == 'Pimpinan')
             {
             
             
             echo "<th> Hpp </th>";
             }
      ?>
                
                <th> Hapus </th>
                <th> Edit </th>
                
                </thead>
                
                <tbody>
                <?php
                
                //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT * FROM detail_penjualan 
                WHERE no_faktur = '$nomor_faktur'");
                
                //menyimpan data sementara yang ada pada $perintah
                
                while ($data1 = mysqli_fetch_array($perintah))
                {
                //menampilkan data
                echo "<tr>
                <td>". $data1['no_faktur'] ."</td>
                <td>". $data1['kode_barang'] ."</td>
                <td>". $data1['nama_barang'] ."</td>
                <td>". $data1['jumlah_barang'] ."</td>
                <td>". $data1['satuan'] ."</td>
                <td>". rp($data1['harga']) ."</td>
                <td>". rp($data1['subtotal']) ."</td>
                <td>". rp($data1['potongan']) ."</td>
                <td>". rp($data1['tax']) ."</td>";

        if ($_SESSION['otoritas'] == 'Pimpinan'){

                echo "<td>". rp($data1['hpp']) ."</td>";
        }

               echo "<td> <button class='btn btn-danger btn-hapus-tbs' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 
                
                <td> <button class='btn btn-success btn-edit-tbs' data-id='". $data1['id'] ."' data-jumlah-barang='". $data1['jumlah_barang'] ."' data-kode='". $data1['kode_barang'] ."' data-harga='". $data1['harga'] ."'><span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>
                </tr>";


                }

                    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

                ?>
                </tbody>
                
                </table>


        <script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $("#kd_pelanggan").focus();
    $('.table').DataTable();
});

</script>


 <script type="text/javascript">
    $(document).ready(function(){
      
//fungsi hapus data 
    $(".btn-hapus-tbs").click(function(){
    var nama_barang = $(this).attr("data-barang");
    var id = $(this).attr("data-id");
    $("#nama-barang").val(nama_barang);
    $("#id_hapus").val(id);
    $("#modal_hapus").modal('show');
    
    
    });
    


//end fungsi hapus data


//fungsi edit data 
        $(".btn-edit-tbs").click(function(){
        
        $("#modal_edit").modal('show');
        var jumlah_barang = $(this).attr("data-jumlah-barang");
        var harga = $(this).attr("data-harga");
        var id  = $(this).attr("data-id");
        $("#harga_edit").val(harga);
        $("#barang_lama").val(jumlah_barang);
        $("#id_edit").val(id);
        
        
        });
        

//end function edit data

              $('form').submit(function(){
              
              return false;
              });
        });

    </script>