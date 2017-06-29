<?php session_start();
include 'db.php';
include 'sanitasi.php';


$session_id = session_id();


    require_once 'cache_folder/cache.class.php';

    // setup 'default' cache
    $c = new Cache();

     // store a string

        $kode_cek = substr(stringdoang($_POST['kode_barang']),0,2);



    $sales = stringdoang($_POST['sales']);
    $level_harga = stringdoang($_POST['level_harga']);
    $no_faktur = stringdoang($_POST['no_faktur']);



$query_setting_timbangan = $db->query("SELECT kode_flag FROM setting_timbangan");
$data_setting_timbangan = mysqli_fetch_array($query_setting_timbangan);
$setting_flag = $data_setting_timbangan['kode_flag'];


if ($kode_cek == $setting_flag){
    $kode_barang = substr(stringdoang($_POST['kode_barang']),2,5);
    $kilo = substr(stringdoang($_POST['kode_barang']),7,2);
     $gram = substr(stringdoang($_POST['kode_barang']),9,3);
     $jumlah_barang = $kilo.'.'.$gram;
}
else{
  $kode_barang = stringdoang($_POST['kode_barang']);
  $jumlah_barang = 1;
}


    $tipe = $db->query("SELECT berkaitan_dgn_stok FROM barang WHERE kode_barang = '$kode_barang'");
    $data_tipe = mysqli_fetch_array($tipe);
    $ber_stok = $data_tipe['berkaitan_dgn_stok'];

    $select = $db->query("SELECT SUM(sisa) AS jumlah_barang FROM hpp_masuk WHERE kode_barang = '$kode_barang'");
    $ambil_sisa = mysqli_fetch_array($select);

    $query = $db->query("SELECT SUM(jumlah_barang) AS jumlah_barang FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur'");
    $jumlah = mysqli_fetch_array($query);
    $jumlah_tbs = $jumlah['jumlah_barang'];
    
    if ($jumlah_tbs == ""){
    	$jumlah_tbs = 0;
    	}

    $tahun_sekarang = date('Y');
    $bulan_sekarang = date('m');
    $tanggal_sekarang = date('Y-m-d');
    $jam_sekarang = date('H:i:s');


    // generate a new cache file with the name 'newcache'
    $c->setCache('produk');


if($c->isCached($kode_barang)) {
 // get cached data by its key
    $result = $c->retrieve($kode_barang);
    // grab array entry
    $nama_barang = stringdoang($result['nama_barang']);
    $harga_jual1 = angkadoang($result['harga_jual']);
    $harga_jual2 = angkadoang($result['harga_jual2']);
    $harga_jual3 = angkadoang($result['harga_jual3']);
    $harga_jual4 = angkadoang($result['harga_jual4']);
    $harga_jual5 = angkadoang($result['harga_jual5']);
    $harga_jual6 = angkadoang($result['harga_jual6']);
    $harga_jual7 = angkadoang($result['harga_jual7']);
    $satuan = stringdoang($result['satuan']);
}
else {
$query = $db->query("SELECT * FROM barang WHERE kode_barang = '$kode_barang'");
while ($data = $query->fetch_array()) {
 # code...
    // store an array
    $c->store($data['kode_barang'], array(
      'nama_barang' => $data['nama_barang'],
      'harga_beli' => $data['harga_beli'],
      'harga_jual' => $data['harga_jual'],
      'harga_jual2' => $data['harga_jual2'],
      'harga_jual3' => $data['harga_jual3'],
      'harga_jual4' => $data['harga_jual4'],
      'harga_jual5' => $data['harga_jual5'],
      'harga_jual6' => $data['harga_jual6'],
      'harga_jual7' => $data['harga_jual7'],
      'satuan' => $data['satuan'],
      'kategori' => $data['kategori'],
      'gudang' => $data['gudang'],
      'status' => $data['status'],
      'suplier' => $data['suplier'],
      'stok_awal' => $data['stok_awal'],
      'stok_opname' => $data['stok_opname'],
      'foto' => $data['foto'],
      'limit_stok' => $data['limit_stok'],
      'over_stok' => $data['over_stok'],


    ));

}
    $result = $c->retrieve($kode_barang);
        // grab array entry
    $nama_barang = stringdoang($result['nama_barang']);
    $harga_jual1 = angkadoang($result['harga_jual']);
    $harga_jual2 = angkadoang($result['harga_jual2']);
    $harga_jual3 = angkadoang($result['harga_jual3']);
    $harga_jual4 = angkadoang($result['harga_jual4']);
    $harga_jual5 = angkadoang($result['harga_jual5']);
    $harga_jual6 = angkadoang($result['harga_jual6']);
    $harga_jual7 = angkadoang($result['harga_jual7']);
    $jumlah_barang = angkadoang(1);
    
    $satuan = stringdoang($result['satuan']);
}

if ($level_harga == 'harga_1'){
  $harga = $harga_jual1;
}
else if ($level_harga == 'harga_2'){
  $harga = $harga_jual2;
}
else if ($level_harga == 'harga_3'){
  $harga = $harga_jual3;
}
else if ($level_harga == 'harga_4'){
  $harga = $harga_jual4;
}
else if ($level_harga == 'harga_5'){
  $harga = $harga_jual5;
}
else if ($level_harga == 'harga_6'){
  $harga = $harga_jual6;
}
else if ($level_harga == 'harga_7'){
  $harga = $harga_jual7;
}

$stok_barang = $ambil_sisa['jumlah_barang'] - $jumlah_barang;


    $ambil_row_barang = $db->query("SELECT id FROM barang WHERE kode_barang = '$kode_barang'");
    $cek_row_barang = mysqli_num_rows($ambil_row_barang);

if ($ber_stok == 'Barang' OR $ber_stok == 'barang'){
    
    if ($stok_barang <= 0 ){
      echo 1;
    }

    else{
        if ($cek_row_barang == 0){
        echo 3;
        }

        else{

        $subtotal = $harga * $jumlah_barang;
          // display the cached array

        $query_fee_produk = $db->query("SELECT jumlah_prosentase,jumlah_uang FROM fee_produk WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
        $data_fee_produk = mysqli_fetch_array($query_fee_produk);
        $prosentase = $data_fee_produk['jumlah_prosentase'];
        $nominal = $data_fee_produk['jumlah_uang'];

        //query untuk mengambil jumlah row tbs penjualan (insert / update ) dan ambil jumlah produk untuk dijumlah dengan jumlah yang masuk dari form ke proses ini 
        $query_tbs_penjualan = $db->query("SELECT jumlah_barang FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND kode_barang = '$kode_barang'");
        $jumlah_data_tbs_penjualan = mysqli_num_rows($query_tbs_penjualan);
        $data_tbs_penjualan = mysqli_fetch_array($query_tbs_penjualan);
        $jumlah_tbs_penjualan = $data_tbs_penjualan['jumlah_barang'];
        $jumlah_total = $jumlah_barang + $jumlah_tbs_penjualan;
        //query untuk mengambil jumlah row tbs penjualan (insert / update ) dan ambil jumlah produk untuk dijumlah dengan jumlah yang masuk dari form ke proses ini 

                  if ($prosentase != 0){

                              $subtotal_prosentase = $harga * $jumlah_total;
                              $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

                              $komisi = $fee_prosentase_produk;

                              if ($jumlah_data_tbs_penjualan > 0) {
                              $query_update_tbs_fee_produk = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi' WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
                              }
                              else
                              {

                                $subtotal_prosentase = $harga * $jumlah_barang;
          
                                $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

                                $query_insert_tbs_fee_produk = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$sales', '$no_faktur', '$kode_barang',
                                    '$nama_barang', '$fee_prosentase_produk', '$tanggal_sekarang', '$jam_sekarang')");

                             }


                  }
                  elseif ($nominal != 0){


                              $fee_nominal_produk = $nominal * $jumlah_total;
                              $komisi = $fee_nominal_produk;

                              if ($cek011 > 0){

                                    $query911 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi' WHERE nama_petugas = '$user' AND kode_produk = '$kode_barang'");
                                  }

                              else{

                                    $fee_nominal_produk = $nominal * $jumlah_barang;
                                    $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$user', '$no_faktur', '$kode_barang', '$nama_barang', '$fee_nominal_produk', '$tanggal_sekarang', '$jam_sekarang')");
                                  }

                  }



    
                          if ($jumlah_data_tbs_penjualan > 0){
                            # code...
                          $query1 = $db->prepare("UPDATE tbs_penjualan SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ?, potongan = ? WHERE kode_barang = ? AND no_faktur = ?");

                          $query1->bind_param("sssss",
                          $jumlah_barang,$subtotal, $potongan_tampil, $kode_barang, $no_faktur);
                          $query1->execute();

                          }
                          else{
                              $perintah = $db->prepare("INSERT INTO tbs_penjualan (no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,tanggal,jam) VALUES (?,?,?,?,?,?,?,?,?)");
                              $perintah->bind_param("sssssssss",
                              $no_faktur, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga, $subtotal,$tanggal_sekarang,$jam_sekarang);
                              $perintah->execute();
                          }

                  echo komarupiah($subtotal,2);

            }//end else kode barang adaa

        } // END ELSE dari IF ($stok_barang < 0)

} // END berkaitan dgn stok == Barang

else{

        if ($cek_row_barang == 0){
            echo 3;
        }

        else
        {
        $sutotal = $harga * $jumlah_barang;
        // display the cached array
        
        $query_fee_produk = $db->query("SELECT jumlah_prosentase,jumlah_uang FROM fee_produk WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
        $data_fee_produk = mysqli_fetch_array($query_fee_produk);
        $prosentase = $data_fee_produk['jumlah_prosentase'];
        $nominal = $data_fee_produk['jumlah_uang'];

        //query untuk mengambil jumlah row tbs penjualan (insert / update ) dan ambil jumlah produk untuk dijumlah dengan jumlah yang masuk dari form ke proses ini 
        $query_tbs_penjualan = $db->query("SELECT jumlah_barang FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND kode_barang = '$kode_barang'");
        $jumlah_data_tbs_penjualan = mysqli_num_rows($query_tbs_penjualan);
        $data_tbs_penjualan = mysqli_fetch_array($query_tbs_penjualan);
        $jumlah_tbs_penjualan = $data_tbs_penjualan['jumlah_barang'];
        $jumlah_total = $jumlah_barang + $jumlah_tbs_penjualan;
        //query untuk mengambil jumlah row tbs penjualan (insert / update ) dan ambil jumlah produk untuk dijumlah dengan jumlah yang masuk dari form ke proses ini 

                if ($prosentase != 0){//insert data ke tbs fee produk menggunakan prosentase
      

                                $subtotal_prosentase = $harga * $jumlah_total;
          
                                $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

                                $komisi = $fee_prosentase_produk;

                                      if ($jumlah_data_tbs_penjualan > 0){
                                        $query91 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi' WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
                                       }

                                      else
                                      {
                                      $subtotal_prosentase = $harga * $jumlah_barang;
                                      $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

                                      $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$sales', '$no_faktur', '$kode_barang',
                                        '$nama_barang', '$fee_prosentase_produk', '$tanggal_sekarang', '$jam_sekarang')");
                                      }


                }

                elseif ($nominal != 0) {//insert data ke tbs fee produk menggunakan nominal


                              $fee_nominal_produk = $nominal * $jumlah_total;
                              $komisi = $fee_nominal_produk;

                            if ($jumlah_data_tbs_penjualan > 0){

                            $query911 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi' WHERE nama_petugas = '$user' AND kode_produk = '$kode_barang'");
                            }

                          else{

                              $fee_nominal_produk = $nominal * $jumlah_barang;
                              $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$user', '$no_faktur', '$kode_barang', '$nama_barang', '$fee_nominal_produk', '$tanggal_sekarang', '$jam_sekarang')");
                            }

                }


    
                    if ($jumlah_data_tbs_penjualan > 0){//update data ke tbs fee penjualan  (jasa)
                        # code...
                        $query1 = $db->prepare("UPDATE tbs_penjualan SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ?, potongan = ? WHERE kode_barang = ? AND no_faktur = ?");

                          $query1->bind_param("sssss",
                            $jumlah_barang,$subtotal, $potongan_tampil, $kode_barang, $no_faktur);


                        $query1->execute();

                    }
                    else
                    {//insert data ke tbs fee penjualan (jasa)
                            $perintah = $db->prepare("INSERT INTO tbs_penjualan (no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,tanggal,jam) VALUES (?,?,?,?,?,?,?,?,?)");
                            $perintah->bind_param("sssssssss",
                            $no_faktur, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga, $subtotal,$tanggal_sekarang,$jam_sekarang);
                            $perintah->execute();

                    }
  
            echo komarupiah($subtotal,2);

        }// end if ($cek_row_barang == 0){

}// END berkaitan dgn stok == Jasa




    ?>


