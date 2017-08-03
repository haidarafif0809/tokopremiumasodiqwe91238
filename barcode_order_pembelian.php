<?php session_start();
$session_id = session_id();
include 'db.php';
include 'sanitasi.php';
include 'persediaan.function.php';



    require_once 'cache_folder/cache.class.php';

    // setup 'default' cache
    $c = new Cache();

     // store a string

    $kode_cek = substr(stringdoang($_POST['kode_barang']),0,2);
    $kode_barcode = stringdoang($_POST['kode_barang']);

        // QUERY CEK BARCODE DI SATUAN KONVERSI
                                    
        $query_satuan_konversi = $db->query("SELECT COUNT(*) AS jumlah_data,kode_barcode,kode_produk,konversi , id_satuan, harga_pokok FROM satuan_konversi WHERE kode_barcode = '$kode_barcode' AND kode_barcode != '' ");
        $data_satuan_konversi = mysqli_fetch_array($query_satuan_konversi);     

        // QUERY CEK BARCODE DI SATUAN KONVERSI

        $lihat_setting = $db->query("SELECT kode_flag FROM setting_timbangan");
        $kel_setting = mysqli_fetch_array($lihat_setting);
        $setting_flag = $kel_setting['kode_flag'];


        if ($kode_cek == $setting_flag)
        {
             $kode_barang = substr(stringdoang($_POST['kode_barang']),2,5);
             $kilo = substr(stringdoang($_POST['kode_barang']),7,2);
             $gram = substr(stringdoang($_POST['kode_barang']),9,3);
             $jumlah_barang = $kilo.'.'.$gram;
        }
        else
        {
          // IF CEK BARCODE DI SATUAN KONVERSI
                  if ($data_satuan_konversi['jumlah_data'] > 0) { //    if ($data_satuan_konversi['jumlah_data'] > 0) {                    
                      $kode_barang = $data_satuan_konversi['kode_produk'];
                      $jumlah_barang = 1;                                        
                  }
                  else{
                                     // QUERY CEK BARCODE DI MASTER DATA PRODUK
                                            
                  $querybarang = $db->query("SELECT COUNT(*) AS jumlah_data,kode_barcode,kode_barang FROM barang WHERE kode_barcode = '$kode_barcode' AND kode_barcode != '' ");
                  $databarang = mysqli_fetch_array($querybarang);     

                  // QUERY CEK BARCODE DI MASTER DATA PRODUK

                                  // IF CEK BARCODE DI BARCODE
                       if ($databarang['jumlah_data'] > 0) {
                       
                      $kode_barang =  $databarang['kode_barang'];
                      $jumlah_barang = 1;

                      }else{

                        $kode_barang =  $kode_barcode;
                        $jumlah_barang = 1;
                      }
                      
                  }
          // IF CEK BARCODE DI SATUAN KONVERSI

        // UNTUK MENGETAHUI JUMLAAH TBS SEBENARNYA
            $jumlah_tbs = 0;

            $query_stok_tbs = $db->query("SELECT jumlah_barang,satuan FROM tbs_pembelian_order WHERE kode_barang = '$kode_barang' AND session_id = '$session_id'");
            while($data_stok_tbs = mysqli_fetch_array($query_stok_tbs)){

                $jumlah_tbs_pembelian_order = $data_stok_tbs['jumlah_barang'];
                $jumlah_tbs = $jumlah_tbs_pembelian_order + $jumlah_tbs;

            }

        // UNTUK MENGETAHUI JUMLAAH TBS SEBENARNYA
            $tipe = $db->query("SELECT berkaitan_dgn_stok FROM barang WHERE kode_barang = '$kode_barang'");
            $data_tipe = mysqli_fetch_array($tipe);
            $ber_stok = $data_tipe['berkaitan_dgn_stok'];

            $ambil_sisa = cekStokHpp($kode_barang) - $jumlah_tbs;
         
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
                $harga_beli = angkadoang($result['harga_beli']);

            // IF CEK BARCODE DI SATUAN KONVERSI
              if ($data_satuan_konversi['jumlah_data'] > 0) {
                  $satuan = $data_satuan_konversi['id_satuan']; // satuan dari satuan konversi
                }
              else{
                  $satuan = stringdoang($result['satuan']); // satuan dasar
                }
            // IF CEK BARCODE DI SATUAN KONVERSI

            }
            else {
            $query = $db->query("SELECT * FROM barang WHERE kode_barang = '$kode_barang'");
              while ($data = $query->fetch_array()) {
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
                $harga_beli = angkadoang($result['harga_beli']);
                $jumlah_barang = angkadoang(1);

            // IF CEK BARCODE DI SATUAN KONVERSI
              if ($data_satuan_konversi['jumlah_data'] > 0) {
                  $satuan = $data_satuan_konversi['id_satuan']; // satuan dari satuan konversi
                }
              else{
                  $satuan = stringdoang($result['satuan']); // satuan dasar
                }
            // IF CEK BARCODE DI SATUAN KONVERSI

            }


            // QUERY UNTUK CEK APAKAH SUDAH ADA APA BELUM DI TBS PENJUALAN
                $query_tbs_pembelian_order = $db->query("SELECT COUNT(kode_barang) AS jumlah_data FROM tbs_pembelian_order WHERE kode_barang = '$kode_barang' AND session_id = '$session_id' AND satuan = '$satuan'");
                $data_tbs_pembelian_order = mysqli_fetch_array($query_tbs_pembelian_order);
            // QUERY UNTUK CEK APAKAH SUDAH ADA APA BELUM DI TBS PENJUALAN

                if ($data_satuan_konversi['jumlah_data'] > 0) {

                  if ($data_satuan_konversi['harga_pokok'] == 0) {
                      $harga_tbs = $harga_beli;
                      $a = $harga_tbs * $data_satuan_konversi['konversi'];
                    }
                    else{
                      $harga_tbs = $data_satuan_konversi['harga_pokok'];
                      $a = $data_satuan_konversi['harga_pokok'];
                    }

                }
                else{
                    $harga_tbs = $harga_beli;
                    $a = $harga_tbs * $jumlah_barang;
                }

            // QUERY  UNTUK CEK APAKAH BARCODE YANg DIMASUKAN ADA DIDAFTAR KODE BARANG
                $ambil_row_barang = $db->query("SELECT id FROM barang WHERE kode_barang = '$kode_barang'");
                $cek_row_barang = mysqli_num_rows($ambil_row_barang);

            // DISINI IF UNTUK CEK APAKAH BARCODE YANF DIMASUKAN ADA DIDAFTAR KODE BARANG

                if ($cek_row_barang <= 0){
                    echo 3;
                }
                else {//else kode barang adaa

                        if ($data_tbs_pembelian_order['jumlah_data'] != 0) {// apablla barang ini sudah ada di tbs

                              $query1 = $db->prepare("UPDATE tbs_pembelian_order SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ? WHERE kode_barang = ? AND session_id = ? AND satuan = ? ");
                              $query1->bind_param("iisss", $jumlah_barang, $a, $kode_barang, $session_id, $satuan);
                              $query1->execute();

                        }
                        else{

                              $perintah = $db->prepare("INSERT INTO tbs_pembelian_order (session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal) VALUES (?,?,?,?,?,?,?)");
                              $perintah->bind_param("sssisii", $session_id, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga_tbs, $a);
                                                 
                              $perintah->execute();
                        }//apablla barang ini sudah ada di tbs
                          
                      //untuk pengambilan data subttotal di form penjualan
                      echo komarupiah($a,2);
                      //untuk pengambilan data subttotal di form penjualan


              }//end else kode barang adaa


}

?>