<?php session_start();

include 'db.php';
include 'sanitasi.php';
include 'persediaan.function.php';



    require_once 'cache_folder/cache.class.php';

    // setup 'default' cache
    $c = new Cache();

     // store a string

    $kode_cek = substr(stringdoang($_POST['kode_barang']),0,2);
    $kode_barcode = stringdoang($_POST['kode_barang']);
    $no_faktur_order = stringdoang($_POST['no_faktur_order']);

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
             $kode_barang =  $kode_barcode;
             $jumlah_barang = 1;

        // UNTUK MENGETAHUI JUMLAAH TBS SEBENARNYA
            $jumlah_tbs = 0;

            $query_stok_tbs = $db->query("SELECT jumlah_barang,satuan FROM tbs_pembelian_order WHERE kode_barang = '$kode_barang' AND no_faktur_order = '$no_faktur_order'");
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
                $satuan = stringdoang($result['satuan']);

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
                $satuan = stringdoang($result['satuan']); // satuan dasar
            }
                $harga_tbs = $harga_beli;

            // QUERY UNTUK CEK APAKAH SUDAH ADA APA BELUM DI TBS PENJUALAN
                $query_tbs_pembelian_order = $db->query("SELECT COUNT(kode_barang) AS jumlah_data FROM tbs_pembelian_order WHERE kode_barang = '$kode_barang' AND no_faktur_order = '$no_faktur_order' AND satuan = '$satuan'");
                $data_tbs_pembelian_order = mysqli_fetch_array($query_tbs_pembelian_order);
            // QUERY UNTUK CEK APAKAH SUDAH ADA APA BELUM DI TBS PENJUALAN

                $stok_barang = $ambil_sisa - $jumlah_barang;
            // cari subtotal
                $a = $harga_tbs * $jumlah_barang;

                $jumlah_fee = $jumlah_barang;                  
                $harga_fee = $harga_tbs;
                $harga_konversi = 0;

            // QUERY  UNTUK CEK APAKAH BARCODE YANg DIMASUKAN ADA DIDAFTAR KODE BARANG
                $ambil_row_barang = $db->query("SELECT id FROM barang WHERE kode_barang = '$kode_barang'");
                $cek_row_barang = mysqli_num_rows($ambil_row_barang);

            // DISINI IF UNTUK CEK APAKAH BARCODE YANF DIMASUKAN ADA DIDAFTAR KODE BARANG

                if ($cek_row_barang <= 0){
                    echo 3;
                }
                else {//else kode barang adaa

                        if ($data_tbs_pembelian_order['jumlah_data'] != 0) {// apablla barang ini sudah ada di tbs

                              $query1 = $db->prepare("UPDATE tbs_pembelian_order SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ? WHERE kode_barang = ? AND no_faktur_order = ? AND satuan = ? ");
                              $query1->bind_param("iisss", $jumlah_barang, $a, $kode_barang, $no_faktur_order, $satuan);
                              $query1->execute();

                        }
                        else{

                              $perintah = $db->prepare("INSERT INTO tbs_pembelian_order (no_faktur_order,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal) VALUES (?,?,?,?,?,?,?)");
                              $perintah->bind_param("sssisii", $no_faktur_order, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga_tbs, $a);
                                                 
                              $perintah->execute();
                        }//apablla barang ini sudah ada di tbs
                          
                      //untuk pengambilan data subttotal di form penjualan
                      echo komarupiah($a,2);
                      //untuk pengambilan data subttotal di form penjualan


              }//end else kode barang adaa


}

?>