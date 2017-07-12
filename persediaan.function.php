<?php 


function cekStokHpp($kode_barang)
{

  include 'db.php';

  $query_hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_masuk WHERE kode_barang = '$kode_barang'");

  $query_hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_keluar WHERE kode_barang = '$kode_barang'");


 $data_hpp_masuk = mysqli_fetch_array($query_hpp_masuk);

 $data_hpp_keluar = mysqli_fetch_array($query_hpp_keluar);

 $stok = $data_hpp_masuk['jumlah'] - $data_hpp_keluar['jumlah'];

 return $stok;


}


function cekStokHppProduk($kode_barang, $no_faktur)
{

  include 'db.php';

  $query_hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur'");

  $query_hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND no_faktur_hpp_masuk = '$no_faktur'");


 $data_hpp_masuk = mysqli_fetch_array($query_hpp_masuk);

 $data_hpp_keluar = mysqli_fetch_array($query_hpp_keluar);

 $stok = $data_hpp_masuk['jumlah'] - $data_hpp_keluar['jumlah'];

 return $stok;


}



function hitungMargin($harga_beli,$harga_jual,$tipe_barang){

    if ($tipe_barang == 'Jasa')
        {
            $margin = 0;
        } 

        else
        {

        $harga_beli = $harga_beli;
        $harga_jual = $harga_jual;

          if ($harga_jual == '') {
              $margin = 0;
          }
          else{
            $selisih_harga_jual_beli = $harga_jual - $harga_beli;
         

            if ($selisih_harga_jual_beli == 0 OR $harga_jual == 0) {
              $margin = 0;
            }
            else{

            //Gross Profit Margin itu rumusnya (harga jual-harga beli)/Harga jual x 100
            $margin =  ($selisih_harga_jual_beli / $harga_jual) * 100;

            $margin = round($margin,2);

            }
           
          }

        }

        return $margin;
}

function hitungNilaiHpp($kode_barang){

  include 'db.php';
         $hpp_masuk = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE kode_barang = '$kode_barang'");
         $cek_awal_masuk = mysqli_fetch_array($hpp_masuk);
            
         $hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE kode_barang = '$kode_barang'");
         $cek_awal_keluar = mysqli_fetch_array($hpp_keluar);


         $total_hpp = $cek_awal_masuk['total_hpp'] - $cek_awal_keluar['total_hpp'];

         return $total_hpp;

}

function hitungHppProduk($kode_barang){

  include 'db.php';
         $hpp_masuk = $db->query("SELECT SUM(total_nilai) AS total_hpp, SUM(jumlah_kuantitas) AS total_kuantitas FROM hpp_masuk WHERE kode_barang = '$kode_barang'");
         $cek_awal_masuk = mysqli_fetch_array($hpp_masuk);
            
         $hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total_hpp, SUM(jumlah_kuantitas) AS total_kuantitas FROM hpp_keluar WHERE kode_barang = '$kode_barang'");
         $cek_awal_keluar = mysqli_fetch_array($hpp_keluar);


         $total_hpp = $cek_awal_masuk['total_hpp'] - $cek_awal_keluar['total_hpp'];
         $total_kuantitas = $cek_awal_masuk['total_kuantitas'] - $cek_awal_keluar['total_kuantitas'];

         $hpp = $total_hpp / $total_kuantitas;

         return $hpp;

}




 ?>