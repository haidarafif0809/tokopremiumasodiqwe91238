<?php session_start();
include 'sanitasi.php';
include 'db.php';

$session_id = session_id();


$no_faktur_order = stringdoang($_POST['no_faktur_order']);
$no_faktur = stringdoang($_POST['no_faktur']);


$perintah3 = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur_order = '$no_faktur_order' ");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur_order = '$no_faktur_order'");
}


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM detail_penjualan_order WHERE no_faktur_order = '$no_faktur_order'");
while ($data = mysqli_fetch_array($perintah)){

if ($data['satuan'] == $data['asal_satuan']) {



$perintah1 = $db->query("INSERT INTO tbs_penjualan (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax,tanggal,jam,no_faktur_order) VALUES ( '$no_faktur', '$data[kode_barang]', '$data[nama_barang]', '$data[jumlah_barang]', '$data[satuan]', '$data[harga]', '$data[subtotal]', '$data[potongan]', '$data[tax]', '$data[tanggal]', '$data[jam]','$no_faktur_order')");

}

else{

$konversi = $db->query("SELECT * FROM satuan_konversi WHERE kode_produk = '$data[kode_barang]' AND id_satuan = '$data[satuan]'");
$data_konversi = mysqli_fetch_array($konversi);

$jumlah_produk = $data['jumlah_barang'] / $data_konversi['konversi'];
$harga = $data['harga'] * $data['jumlah_barang'];


$perintah1 = $db->query("INSERT INTO tbs_penjualan (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax,tanggal,jam,no_faktur_order) VALUES ( '$no_faktur', '$data[kode_barang]', '$data[nama_barang]', '$jumlah_produk', '$data[satuan]', '$harga', '$data[subtotal]', '$data[potongan]', '$data[tax]', '$data[tanggal]', '$data[jam]','$no_faktur_order')");


}


}


$update_status_order = $db->query("UPDATE penjualan_order SET status_order = 'Masuk TBS' WHERE no_faktur_order = '$no_faktur_order' ");

$update_status_order = $db->query("UPDATE tbs_fee_produk SET no_faktur = '$no_faktur' WHERE no_faktur_order = '$no_faktur_order' ");

//Untuk Memutuskan Koneksi Ke Database
 ?>

<table id="tableuser" class="table table-sm">
                <thead>
                <th style="width:500%">No Faktur Order</th>
                <th> Kode  </th>
                <th style="width:1000%"> Nama </th>
                <th> Jumlah </th>
                <th> Satuan </th>
                <th> Harga </th>
                <th> Subtotal </th>
                <th> Potongan </th>
                <th> Pajak </th>
                </thead>
                
                <tbody id="prep">
                <?php
                
                //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT tp.no_faktur_order,tp.id,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama,bb.berkaitan_dgn_stok FROM tbs_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id INNER JOIN barang bb ON tp.kode_barang = bb.kode_barang WHERE tp.no_faktur = 'no_faktur' AND no_faktur_order != '' ORDER BY no_faktur_order ASC ");
                
                //menyimpan data sementara yang ada pada $perintah
                
                while ($data1 = mysqli_fetch_array($perintah))
                {
                //menampilkan data
                echo "<tr class='tr-kode-". $data1['kode_barang'] ." tr-id-". $data1['id'] ."' data-kode-barang='".$data1['kode_barang']."'>
                <td style='font-size:15px'>". $data1['no_faktur_order'] ."</td>
                <td style='font-size:15px'>". $data1['kode_barang'] ."</td>
                <td style='font-size:15px;'>". $data1['nama_barang'] ."</td>
                <td style='font-size:15px' align='right' class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-berstok = '".$data1['berkaitan_dgn_stok']."'  data-harga='".$data1['harga']."' data-satuan='".$data1['satuan']."' > </td>
                <td style='font-size:15px'>". $data1['nama'] ."</td>
                <td style='font-size:15px' align='right'>". rp($data1['harga']) ."</td>
                <td style='font-size:15px' align='right'><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>";

               echo "
                </tr>";


                }

                ?>
                </tbody>
</table>


