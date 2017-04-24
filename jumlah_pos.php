<?php 

// memasukan file session login,  header, navbar, db.php,

include 'db.php';




 $query = $db->query("SELECT * FROM barang");

 ?>

<?php 

while ($data=mysqli_fetch_array($query)) 
      {

// mencari jumlah Barang
            $query0 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_pembelian FROM detail_pembelian WHERE kode_barang = '$data[kode_barang]'");
            $cek0 = mysqli_fetch_array($query0);
            $jumlah_pembelian = $cek0['jumlah_pembelian'];

            $query1 = $db->query("SELECT SUM(jumlah) AS jumlah_item_masuk FROM detail_item_masuk WHERE kode_barang = '$data[kode_barang]'");
            $cek1 = mysqli_fetch_array($query1);
            $jumlah_item_masuk = $cek1['jumlah_item_masuk'];

            $query2 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_penjualan FROM detail_retur_penjualan WHERE kode_barang = '$data[kode_barang]'");
            $cek2 = mysqli_fetch_array($query2);
            $jumlah_retur_penjualan = $cek2['jumlah_retur_penjualan'];

            $query20 = $db->query("SELECT SUM(jumlah_awal) AS jumlah_stok_awal FROM stok_awal WHERE kode_barang = '$data[kode_barang]'");
            $cek20 = mysqli_fetch_array($query20);
            $jumlah_stok_awal = $cek20['jumlah_stok_awal'];

            $query200 = $db->query("SELECT SUM(selisih_fisik) AS jumlah_fisik FROM detail_stok_opname WHERE kode_barang = '$data[kode_barang]'");
            $cek200 = mysqli_fetch_array($query200);
            $jumlah_fisik = $cek200['jumlah_fisik'];
//total barang 1
            $total_1 = $jumlah_pembelian + $jumlah_item_masuk + $jumlah_retur_penjualan + $jumlah_stok_awal + $jumlah_fisik;


 

            $query3 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_penjualan FROM detail_penjualan WHERE kode_barang = '$data[kode_barang]'");
            $cek3 = mysqli_fetch_array($query3);
            $jumlah_penjualan = $cek3['jumlah_penjualan'];


            $query4 = $db->query("SELECT SUM(jumlah) AS jumlah_item_keluar FROM detail_item_keluar WHERE kode_barang = '$data[kode_barang]'");
            $cek4 = mysqli_fetch_array($query4);
            $jumlah_item_keluar = $cek4['jumlah_item_keluar'];

            $query5 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_pembelian FROM detail_retur_pembelian WHERE kode_barang = '$data[kode_barang]'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_retur_pembelian = $cek5['jumlah_retur_pembelian'];


 



//total barang 2
            $total_2 = $jumlah_penjualan + $jumlah_item_keluar + $jumlah_retur_pembelian;



            echo $stok_barang = $total_1 - $total_2;



      echo '<div class="img" data-kode="'. $data['kode_barang'] .'"  nama-barang="'. $data['nama_barang'] .'" harga="'. $data['harga_jual'] .'" foto="'. $data['foto'] .'" satuan="'. $data['satuan'] .'" ber_stok="'. $data['berkaitan_dgn_stok'] .'">
    
      <span style="cursor:pointer">';

if ($data['foto'] == "") {
 
 echo '<img src="save_picture/box.jpg " height="100px" width="100px" data-toggle="tooltip" data-placement="top" title="'. $data['nama_barang'] .'" class="test">';

}

else{

  echo '<img src="save_picture/'. $data['foto'] .'" height="100px" width="100px" data-toggle="tooltip" data-placement="top"  title="'. $data['nama_barang'] .'" class="test">';

}
      

    echo '</span>
      
      
      
      </div>';

      

}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>

                        <script type="text/javascript">
                        $(document).ready(function() {
                              
                        
                        $(".img").mouseleave(function(){
                        
                        var kode_pelanggan = $("#kd_pelanggan").val();
                        
                        
                        if (kode_pelanggan != ""){
                        $("#kd_pelanggan").attr("disabled", true);
                        }
                        
                        var no_faktur = $("#nomor_faktur_penjualan").val();
                        
                        $.post("cek_total_penjualan.php",
                        {
                        no_faktur: no_faktur
                        },
                        function(data){
                        $("#total"). val(data);
                        $("#total1"). val(data);
                        $("#total2"). val(data);
                        });
                        
                        $.post("cek_total_hpp.php",
                        {
                        no_faktur: no_faktur
                        },
                        function(data){
                        $("#total_hpp"). val(data);
                        });
                        
                        });
                        
                        });
                        
                        
                        </script>
