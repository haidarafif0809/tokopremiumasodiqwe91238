<?php session_start();
include 'db.php';
include 'sanitasi.php';
include 'persediaan.function.php';


$session_id = session_id();


    require_once 'cache_folder/cache.class.php';

    // setup 'default' cache
    $c = new Cache();

     // store a string

        $kode_cek = substr(stringdoang($_POST['kode_barang']),0,2);



    $sales = stringdoang($_POST['sales']);
    $level_harga = stringdoang($_POST['level_harga']);
    $no_faktur = stringdoang($_POST['no_faktur']);
    $kode_barcode = stringdoang($_POST['kode_barang']);


        // QUERY CEK BARCODE DI SATUAN KONVERSI
                                    
        $query_satuan_konversi = $db->query("SELECT COUNT(*) AS jumlah_data,kode_barcode,kode_produk,konversi , id_satuan,harga_jual_konversi FROM satuan_konversi WHERE kode_barcode = '$kode_barcode'  AND kode_barcode != '' ");
        $data_satuan_konversi = mysqli_fetch_array($query_satuan_konversi);     

        // QUERY CEK BARCODE DI SATUAN KONVERSI
        
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
                     // IF CEK BARCODE DI SATUAN KONVERSI
                          if ($data_satuan_konversi['jumlah_data'] > 0) {//    if ($data_satuan_konversi['jumlah_data'] > 0) {
                            
                            $kode_barang = $data_satuan_konversi['kode_produk'];
                            $jumlah_barang = 1;

                                                
                          }else{
                              
                              $kode_barang =  $kode_barcode;
                              $jumlah_barang = 1;

                          }

                    // IF CEK BARCODE DI SATUAN KONVERSI       
        }



// UNTUK MENGETAHUI JUMLAAH TBS SEBENARNYA
    $jumlah_tbs = 0;

    $query_stok_tbs = $db->query("SELECT jumlah_barang,satuan FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur'");
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

    $tahun_sekarang = date('Y');
    $bulan_sekarang = date('m');
    $tanggal_sekarang = date('Y-m-d');
    $jam_sekarang = date('H:i:s');

    $tipe = $db->query("SELECT berkaitan_dgn_stok FROM barang WHERE kode_barang = '$kode_barang'");
    $data_tipe = mysqli_fetch_array($tipe);
    $ber_stok = $data_tipe['berkaitan_dgn_stok'];

    $query_detail = $db->query("SELECT SUM(jumlah_barang) AS jumlah_barang FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND kode_barang = '$kode_barang'");
    $data_detail = mysqli_fetch_array($query_detail);

    $ambil_sisa = (cekStokHpp($kode_barang)  + $data_detail['jumlah_barang']) - $jumlah_tbs;

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
   
            // IF CEK BARCODE DI SATUAN KONVERSI

            if ($data_satuan_konversi['jumlah_data'] > 0) {

                $satuan = $data_satuan_konversi['id_satuan']; // satuan dari satuan konversi
                }else{

                  $satuan = stringdoang($result['satuan']); // satuan dasar
                }

            // IF CEK BARCODE DI SATUAN KONVERSI
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
    
   
            // IF CEK BARCODE DI SATUAN KONVERSI

            if ($data_satuan_konversi['jumlah_data'] > 0) {

                $satuan = $data_satuan_konversi['id_satuan']; // satuan dari satuan konversi
                }else{

                  $satuan = stringdoang($result['satuan']); // satuan dasar
                }

            // IF CEK BARCODE DI SATUAN KONVERSI
}

if ($level_harga == 'harga_1'){
  $harga_tbs = $harga_jual1;
}
else if ($level_harga == 'harga_2'){
  $harga_tbs = $harga_jual2;
}
else if ($level_harga == 'harga_3'){
  $harga_tbs = $harga_jual3;
}
else if ($level_harga == 'harga_4'){
  $harga_tbs = $harga_jual4;
}
else if ($level_harga == 'harga_5'){
  $harga_tbs = $harga_jual5;
}
else if ($level_harga == 'harga_6'){
  $harga_tbs = $harga_jual6;
}
else if ($level_harga == 'harga_7'){
  $harga_tbs = $harga_jual7;
}


       
            // qUERY UNTUK CEK APAKAH SUDAH ADA APA BELUM DI TBS PENJUALAN  
            $query_tbs_penjualan = $db->query("SELECT COUNT(kode_barang) AS jumlah_data FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur' AND satuan = '$satuan'");
            $data_tbs_penjualan = mysqli_fetch_array($query_tbs_penjualan);
            // qUERY UNTUK CEK APAKAH SUDAH ADA APA BELUM DI TBS PENJUALAN           

            ##
            // IF CEK BARCODE DI SATUAN KONVERSI

            if ($data_satuan_konversi['jumlah_data'] > 0) {

                  $stok_barang = $ambil_sisa - $data_satuan_konversi['konversi'];

                  // cari subtotal , langsung dikalikan dengan nilai konversinya
                  
                  $harga_fee = $harga_tbs;

                 if ($data_satuan_konversi['harga_jual_konversi'] == 0) {   

                    $harga_konversi = $harga_tbs * $data_satuan_konversi['konversi'];
                    $subtotal = $harga_tbs * $data_satuan_konversi['konversi'];
                  }else{

                    $harga_konversi = $data_satuan_konversi['harga_jual_konversi'];
                    $subtotal = $data_satuan_konversi['harga_jual_konversi'];
                  }



                  // cari subtotal
                  $jumlah_fee = $data_satuan_konversi['konversi'];

                }else{

                  $stok_barang = $ambil_sisa - $jumlah_barang;
                  // cari subtotal
                  $subtotal = $harga_tbs * $jumlah_barang;
                  // cari subtotal
                  
                  $jumlah_fee = $jumlah_barang;                  
                  $harga_fee = $harga_tbs;
                  $harga_konversi = 0;
                }

            // IF CEK BARCODE DI SATUAN KONVERSI


    $ambil_row_barang = $db->query("SELECT id FROM barang WHERE kode_barang = '$kode_barang'");
    $cek_row_barang = mysqli_num_rows($ambil_row_barang);

        $query_fee_produk = $db->query("SELECT jumlah_prosentase,jumlah_uang FROM fee_produk WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
        $data_fee_produk = mysqli_fetch_array($query_fee_produk);
        $prosentase = $data_fee_produk['jumlah_prosentase'];
        $nominal = $data_fee_produk['jumlah_uang'];

if ($ber_stok == 'Barang' OR $ber_stok == 'barang'){
    
    if ($stok_barang < 0 ){
      echo 1;
    }

    else{
        if ($cek_row_barang == 0){
        echo 3;
        }

        else{

                  if ($prosentase != 0){

                              $jumlahFeemasuk = $jumlah_fee + $jumlah_tbs;
                              $subtotal_prosentase = $harga_fee * $jumlahFeemasuk;
                              $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

                              $komisi = $fee_prosentase_produk;

                             if ($jumlah_tbs != 0) {// apablla barang ini sudah ada di tbs
                              $query_update_tbs_fee_produk = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi' WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
                              }
                              else
                              {

                                $subtotal_prosentase = $harga_fee * $jumlah_fee;                                
                                  $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

                                $query_insert_tbs_fee_produk = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$sales', '$no_faktur', '$kode_barang',
                                    '$nama_barang', '$fee_prosentase_produk', '$tanggal_sekarang', '$jam_sekarang')");

                             }


                  }
                  elseif ($nominal != 0){


                                    $jumlahFeemasuk = $jumlah_fee + $jumlah_tbs;

                                    $fee_nominal_produk = $nominal * $jumlahFeemasuk;

                             if ($jumlah_tbs != 0) {// apablla barang ini sudah ada di tbs

                                    $query911 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$fee_nominal_produk' WHERE nama_petugas = '$user' AND kode_produk = '$kode_barang'");
                                  }

                              else{

                                 $fee_nominal_produk = $nominal * $jumlah_fee;
                                    $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$user', '$no_faktur', '$kode_barang', '$nama_barang', '$fee_nominal_produk', '$tanggal_sekarang', '$jam_sekarang')");
                                  }

                  }



    
                          if ($data_tbs_penjualan['jumlah_data'] != 0) {// apablla barang ini sudah ada di tbs
                            # code...
                          $query1 = $db->prepare("UPDATE tbs_penjualan SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ?, potongan = ? WHERE kode_barang = ? AND no_faktur = ?  AND satuan = ?");

                          $query1->bind_param("sssssi",
                          $jumlah_barang,$subtotal, $potongan_tampil, $kode_barang, $no_faktur,$satuan);
                          $query1->execute();

                          }
                          else{
                              $perintah = $db->prepare("INSERT INTO tbs_penjualan (no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,tanggal,jam, tipe_barang,harga_konversi) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                              $perintah->bind_param("ssssssssssi",
                              $no_faktur, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga_tbs, $subtotal,$tanggal_sekarang,$jam_sekarang,$ber_stok,$harga_konversi);
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

                  if ($prosentase != 0){

                              $jumlahFeemasuk = $jumlah_fee + $jumlah_tbs;
                              $subtotal_prosentase = $harga_fee * $jumlahFeemasuk;
                              $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

                              $komisi = $fee_prosentase_produk;

                             if ($jumlah_tbs != 0) {// apablla barang ini sudah ada di tbs
                              $query_update_tbs_fee_produk = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi' WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
                              }
                              else
                              {

                                $subtotal_prosentase = $harga_fee * $jumlah_fee;                                
                                  $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

                                $query_insert_tbs_fee_produk = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$sales', '$no_faktur', '$kode_barang',
                                    '$nama_barang', '$fee_prosentase_produk', '$tanggal_sekarang', '$jam_sekarang')");

                             }


                  }
                  elseif ($nominal != 0){


                                    $jumlahFeemasuk = $jumlah_fee + $jumlah_tbs;

                                    $fee_nominal_produk = $nominal * $jumlahFeemasuk;

                               if ($jumlah_tbs != 0) {// apablla barang ini sudah ada di tbs

                                      $query911 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$fee_nominal_produk' WHERE nama_petugas = '$user' AND kode_produk = '$kode_barang'");
                                    }

                                else{

                                   $fee_nominal_produk = $nominal * $jumlah_fee;
                                      $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$user', '$no_faktur', '$kode_barang', '$nama_barang', '$fee_nominal_produk', '$tanggal_sekarang', '$jam_sekarang')");
                                    }

                  }



    
                    if ($data_tbs_penjualan['jumlah_data'] != 0) {// apablla barang ini sudah ada di tbs
                        # code...
                        $query1 = $db->prepare("UPDATE tbs_penjualan SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ?, potongan = ? WHERE kode_barang = ? AND no_faktur = ?  AND satuan = ?");

                          $query1->bind_param("sssssi",
                            $jumlah_barang,$subtotal, $potongan_tampil, $kode_barang, $no_faktur,$satuan);


                        $query1->execute();

                    }
                    else
                    {//insert data ke tbs fee penjualan (jasa)
                            $perintah = $db->prepare("INSERT INTO tbs_penjualan (no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,tanggal,jam,tipe_barang,harga_konversi) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                            $perintah->bind_param("ssssssssssi",
                            $no_faktur, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga, $subtotal,$tanggal_sekarang,$jam_sekarang,$ber_stok,$harga_konversi);
                            $perintah->execute();

                    }
  
            echo komarupiah($subtotal,2);

        }// end if ($cek_row_barang == 0){

}// END berkaitan dgn stok == Jasa




    ?>


