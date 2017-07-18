<?php session_start();


include 'db.php';
include 'persediaan.function.php';
include 'sanitasi.php';


 $session_id = session_id();
 $jumlah_baru = angkadoang($_POST['jumlah_baru']);
 $jumlah_lama = angkadoang($_POST['jumlah_lama']);
 $satuan_konversi = angkadoang($_POST['satuan_konversi']);
 $kode_barang = stringdoang($_POST['kode_barang']);
 $jenis_penjualan = stringdoang($_POST['jenis_penjualan']);

 	// untuk mngetahui jumlah barang yang sbenarnya
 	  $query_satuan_konversi = $db->query("SELECT konversi FROM satuan_konversi WHERE kode_produk = '$kode_barang' AND id_satuan = '$satuan_konversi' ");
      $data_satuan_konversi = mysqli_fetch_array($query_satuan_konversi);

        $konversi_satuan = $data_satuan_konversi['konversi'];
        if ($konversi_satuan == '') {
          $konversi_satuan = 1;
        }
      $jumlah_baru_sebenarnya = $jumlah_baru * $konversi_satuan;
      $jumlah_lama_sebenarnya = $jumlah_lama * $konversi_satuan;
	
	// untuk mngetahui jumlah barang yang sbenarnya
	



 // UNTUK MENGETAHUI JUMLAAH TBS SEBENARNYA
    $jumlah_tbs = 0;

    if ($jenis_penjualan == 'Order Penjualan') {
          
          $query_stok_tbs = $db->query("SELECT jumlah_barang,satuan FROM tbs_penjualan_order WHERE kode_barang = '$kode_barang' AND session_id = '$session_id' AND no_faktur_order IS NULL ");

    }
    else{
          $query_stok_tbs = $db->query("SELECT jumlah_barang,satuan FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND session_id = '$session_id' AND no_faktur_order IS NULL ");
    }
    

    while($data_stok_tbs = mysqli_fetch_array($query_stok_tbs)){

      $query_cek_satuan_konversi = $db->query("SELECT konversi FROM satuan_konversi WHERE kode_produk = '$kode_barang' AND id_satuan = '$data_stok_tbs[satuan]' ");
      $data_cek_satuan_konversi = mysqli_fetch_array($query_cek_satuan_konversi);

        $konversi = $data_cek_satuan_konversi['konversi'];
        if ($konversi == '') {
          $konversi = 1;
        }
        $jumlah_tbs_penjualan = $data_stok_tbs['jumlah_barang'] * $konversi;

        $jumlah_tbs = $jumlah_tbs_penjualan + $jumlah_tbs;

    }
  //  UNTUK MENGETAHUI JUMLAAH TBS SEBENARNYA


 $stok = cekStokHpp($kode_barang);
 $hasil1 = $stok - $jumlah_tbs; 
 	 echo $hasilsebenarnya = ($hasil1 + $jumlah_lama_sebenarnya) - $jumlah_baru_sebenarnya;

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>
