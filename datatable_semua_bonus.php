<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$kode_barang = $_POST['kode_barang'];
$subtotal = $_POST['subtotal'];
$subtotal = hapus_koma_dua($subtotal);
$subtotal = angkadoang($subtotal);

$session_id = session_id();
$tanggal_sekarang = date('Y-m-d');


?>

<div class="container">             
<div class="table-responsive"> 
<table id="table" class="table table-hover table-sm">
    <thead>

    <th> Kode Produk </th>
    <th> Nama Produk </th>
    <th> Nama Program </th>
    <th> Jumlah  </th>
    <th> Satuan  </th>
    <th> Harga </th>
    <th> Harga Awal </th>
    <th> Jenis Bonus </th>
                    
            
    </thead>
                    
    <tbody>
    

    <?php
                    
$select_program_free = $db->query("SELECT id,jenis_bonus,syarat_belanja FROM program_promo WHERE batas_akhir >= '$tanggal_sekarang' AND jenis_bonus = 'Free Produk' ");
while ($data_program_free = mysqli_fetch_array($select_program_free)){

    $program = $data_program_free['id'];
    $jenis_bonus = $data_program_free['jenis_bonus'];
    $syarat_belanja = $data_program_free['syarat_belanja'];

   $select_produk_promo = $db->query("SELECT b.kode_barang AS kode_barang_promo FROM produk_promo pro LEFT JOIN barang b ON pro.nama_produk = b.id WHERE nama_program = '$program'");
    while($data_produk_promo = mysqli_fetch_array($select_produk_promo)){
        $kode_barang_promo = $data_produk_promo['kode_barang_promo'];

    $query_tbs_penjualan = $db->query("SELECT SUM(subtotal) AS subtotal FROM tbs_penjualan WHERE kode_barang = '$kode_barang_promo' AND session_id = '$session_id'");
    $data_query_tbs = mysqli_fetch_array($query_tbs_penjualan);

    if($data_query_tbs['subtotal'] >= $syarat_belanja){

  $query_bonus_free = $db->query("SELECT b.id,b.harga_jual,b.nama_barang,st.nama as satuan_barang,st.id AS id_satuan, b.kode_barang,pp.nama_produk,pp.nama_program,pp.satuan,pp.qty, pp.id,p.nama_program as program FROM promo_free_produk pp LEFT JOIN barang b ON pp.nama_produk = b.id LEFT JOIN program_promo p ON pp.nama_program = p.id LEFT JOIN satuan st ON pp.satuan = st.id WHERE pp.nama_program = '$program' AND pp.qty != '0'");

while($data = mysqli_fetch_array($query_bonus_free)){
//menampilkan data
$harganya = 0;      
echo "<tr class='bonus_free' data-kode='". $data['kode_barang'] ."' data-barang='". $data['nama_barang'] ."' data-program='". $data['program'] ."' data-qty='". $data['qty'] ."' data-harga-bonus='". $harganya ."' data-satuan='". $data['id_satuan'] ."' data-harga-jual='". $data['harga_jual'] ."'>


                    <td>". $data['kode_barang'] ."</td>
                    <td>". $data['nama_barang'] ."</td>
                    <td>". $data['program'] ."</td>
                    <td>". $data['qty'] ."</td>
                    <td>". $data['satuan_barang'] ."</td>";
                    $harga_bonus= 'Gratis';
                    echo"
                    <td>". $harga_bonus ."</td>
                    <td>". rp($data['harga_jual']) ."</td>
                    <td>". $jenis_bonus ."</td>

    </tr>";
            }
        }
    }
}




// DISKON PRODUK
$select_program_diskon = $db->query("SELECT id,jenis_bonus,syarat_belanja,nama_program FROM program_promo WHERE batas_akhir >= '$tanggal_sekarang' AND jenis_bonus = 'Disc Produk' ");
while ($data_program_diskon = mysqli_fetch_array($select_program_diskon)){
    $program = $data_program_diskon['id'];
    $jenis_bonus = $data_program_diskon['jenis_bonus'];
    $syarat_belanja = $data_program_diskon['syarat_belanja'];
    $nama_program = $data_program_diskon['nama_program'];
    
    if($subtotal >= $syarat_belanja){
 //<td class='table1' >-</td>
$query_bonus_diskon = $db->query("SELECT b.id AS id_barang, b.nama_barang,st.nama AS satuan_barang, st.id AS id_satuan, b.harga_jual, b.kode_barang, pp.nama_produk, pp.nama_program, pp.satuan, pp.id, pp.harga_disc, pp.qty_max FROM promo_disc_produk pp LEFT JOIN barang b ON pp.nama_produk = b.id LEFT JOIN satuan st ON pp.satuan = st.id WHERE pp.nama_program = '$program' AND pp.qty_max != '0'");
while ($data_diskon = mysqli_fetch_array($query_bonus_diskon)){

echo "<tr class='bonus_diskon' data-kode='". $data_diskon['kode_barang'] ."' data-barang='". $data_diskon['nama_barang'] ."' data-program='". $nama_program ."' data-qty='". $data_diskon['qty_max'] ."' data-harga-diskon='". $data_diskon['harga_disc'] ."' data-satuan='". $data_diskon['id_satuan'] ."' data-harga-jual='". $data_diskon['harga_jual'] ."'>    
                
            <td>". $data_diskon['kode_barang'] ."</td>
            <td>". $data_diskon['nama_barang'] ."</td>
            <td>". $nama_program ."</td>
            <td>". $data_diskon['qty_max'] ."</td>
            <td>". $data_diskon['satuan_barang'] ."</td>
            <td>". $data_diskon['harga_disc'] ."</td>
            <td>". $data_diskon['harga_jual'] ."</td>
            <td>". $jenis_bonus ."</td>

            
      </tr>";

                    
            }
        }      
    }


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
</tbody>
                    
</table>
</div>
</div>

                    <script>
        
        $(document).ready(function(){
        $('#table').DataTable(
            {"ordering": false});
        });
        </script>