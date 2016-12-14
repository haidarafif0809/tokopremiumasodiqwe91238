<?php 
    // memasukan file yang ada pada db.php
include 'sanitasi.php';
include 'db.php';
    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
    $no_faktur = $_POST['no_faktur'];
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $satuan = $_POST['satuan'];
    $jumlah_fisik = $_POST['fisik'];
    

        $query9 = $db->prepare("UPDATE barang SET stok_opname = 'ya' WHERE kode_barang = ?");

        $query9->bind_param("s", $kode_barang);

        $query9->execute();


        $query1 = $db->query("SELECT SUM(jumlah_barang) AS masuk FROM detail_pembelian WHERE kode_barang = '$kode_barang'");
        $hasil1 = mysqli_fetch_array($query1);
        $jumlah_masuk_pembelian = $hasil1['masuk'];


        $query3 = $db->query("SELECT SUM(jumlah) AS masuk FROM detail_item_masuk WHERE kode_barang = '$kode_barang'");
        $hasil2 = mysqli_fetch_array($query3);
        $jumlah_masuk_item_masuk = $hasil2['masuk'];



        $hasil_masuk = $jumlah_masuk_pembelian + $jumlah_masuk_item_masuk;



        $query4 = $db->query("SELECT SUM(jumlah_barang) AS keluar FROM detail_penjualan WHERE kode_barang = '$kode_barang'");
        $hasil3 = mysqli_fetch_array($query4);
        $jumlah_keluar_penjualan = $hasil3['keluar'];


        $query5 = $db->query("SELECT SUM(jumlah) AS keluar FROM detail_item_keluar WHERE kode_barang = '$kode_barang'");
        $hasil4 = mysqli_fetch_array($query5);
        $jumlah_keluar_item_keluar = $hasil4['keluar'];

        $hasil_keluar = $jumlah_keluar_penjualan + $jumlah_keluar_item_keluar;



        $query6 = $db->query("SELECT * FROM barang WHERE kode_barang = '$kode_barang'");

        // mencari jumlah Barang
            $query0 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_pembelian FROM detail_pembelian WHERE kode_barang = '$kode_barang'");
            $cek0 = mysqli_fetch_array($query0);
            $jumlah_pembelian = $cek0['jumlah_pembelian'];

            $query1 = $db->query("SELECT SUM(jumlah) AS jumlah_item_masuk FROM detail_item_masuk WHERE kode_barang = '$kode_barang'");
            $cek1 = mysqli_fetch_array($query1);
            $jumlah_item_masuk = $cek1['jumlah_item_masuk'];

            $query2 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_penjualan FROM detail_retur_penjualan WHERE kode_barang = '$kode_barang'");
            $cek2 = mysqli_fetch_array($query2);
            $jumlah_retur_penjualan = $cek2['jumlah_retur_penjualan'];

            $query20 = $db->query("SELECT SUM(jumlah_awal) AS jumlah_stok_awal FROM stok_awal WHERE kode_barang = '$kode_barang'");
            $cek20 = mysqli_fetch_array($query20);
            $jumlah_stok_awal = $cek20['jumlah_stok_awal'];

            $query200 = $db->query("SELECT SUM(fisik) AS jumlah_fisik FROM detail_stok_opname WHERE kode_barang = '$kode_barang'");
            $cek200 = mysqli_fetch_array($query200);
            $j_fisik = $cek200['jumlah_fisik'];
//total barang 1
            $total_1 = $jumlah_pembelian + $jumlah_item_masuk + $jumlah_retur_penjualan + $jumlah_stok_awal + $j_fisik;


 

            $query3 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_penjualan FROM detail_penjualan WHERE kode_barang = '$kode_barang'");
            $cek3 = mysqli_fetch_array($query3);
            $jumlah_penjualan = $cek3['jumlah_penjualan'];


            $query4 = $db->query("SELECT SUM(jumlah) AS jumlah_item_keluar FROM detail_item_keluar WHERE kode_barang = '$kode_barang'");
            $cek4 = mysqli_fetch_array($query4);
            $jumlah_item_keluar = $cek4['jumlah_item_keluar'];

            $query5 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_pembelian FROM detail_retur_pembelian WHERE kode_barang = '$kode_barang'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_retur_pembelian = $cek5['jumlah_retur_pembelian'];



//total barang 2
            $total_2 = $jumlah_penjualan + $jumlah_item_keluar + $jumlah_retur_pembelian;

            
            
            $jumlah_stok_komputer = $total_1 - $total_2;
            
            
            
            $selisih_fisik = $jumlah_fisik - $jumlah_stok_komputer;

    if ($selisih_fisik < 0) {

       // HARGA DARI HPP MASUK

       $pilih_hpp = $db->query("SELECT harga_unit FROM hpp_masuk WHERE kode_barang = '$kode_barang' ORDER BY id DESC LIMIT 1");
       $ambil_hpp = mysqli_fetch_array($pilih_hpp);
       $jumlah_hpp = $ambil_hpp['harga_unit'];


       // SAMPAI SINI

    } 

    else {

              // HARGA DARI DETAIL PEMBELIAN ATAU BARANG
        
        $select2 = $db->query("SELECT harga FROM detail_pembelian WHERE kode_barang = '$kode_barang' ORDER BY id DESC LIMIT 1");
        $num_rows = mysqli_num_rows($select2);
        $fetc_array = mysqli_fetch_array($select2);
        
        $select3 = $db->query("SELECT harga_beli FROM barang WHERE kode_barang = '$kode_barang' ORDER BY id DESC LIMIT 1");
        $ambil_barang = mysqli_fetch_array($select3);
        
        if ($num_rows == 0) {
        
        $jumlah_hpp = $ambil_barang['harga_beli'];
        
        } 
        
        else {
        
        $jumlah_hpp = $fetc_array['harga'];
        
        }
        
        // SAMPAI SINI


    }
    

        
     $selisih_harga = $jumlah_hpp * $selisih_fisik;      
        
        
        
        $cek = $db->query("SELECT * FROM stok_awal WHERE kode_barang = '$kode_barang' ");
        $data = mysqli_fetch_array($cek);
        $stok_awal = $data['jumlah_awal'];
        
        
        $query = "INSERT INTO tbs_stok_opname (no_faktur, kode_barang, nama_barang, satuan, awal, masuk, keluar, stok_sekarang, fisik, selisih_fisik, selisih_harga, harga, hpp) 
        VALUES ('$no_faktur', '$kode_barang','$nama_barang','$satuan','$stok_awal','$hasil_masuk','$hasil_keluar','$jumlah_stok_komputer','$jumlah_fisik','$selisih_fisik','$selisih_harga','$jumlah_hpp','$jumlah_hpp')";
      

        
        if ($db->query($query) === TRUE)
        {

        }
        else
        {
            echo "Error: " . $query . "<br>" . $db->error;
        }
  
    ?>
<!-- membuat agar ada garis pada tabel, disetiap kolom -->
                  <table id="tableuser" class="table table-bordered">
                  <thead>
                  
                  <th> Nomor Faktur </th>
                  <th> Kode Barang </th>
                  <th> Nama Barang </th>
                  <th> Satuan </th>
                  <th> Stok Komputer </th>
                  <th> Jumlah Fisik </th>
                  <th> Selisih Fisik </th>
                  <th> Hpp </th>
                  <th> Selisih Harga </th>
                  <th> Harga </th>
                  <th> Hapus </th>
                  
                  </thead>
                  
                  <tbody>
                  <?php
                  
                  
      $perintah = $db->query("SELECT * FROM tbs_stok_opname");
                  
                  //menyimpan data sementara yang ada pada $perintah
                  while ($data1 = mysqli_fetch_array($perintah))
                  {
                  
                  
                  echo "<tr>
                  
                  <td>". $data1['no_faktur'] ."</td>
                  <td>". $data1['kode_barang'] ."</td>
                  <td>". $data1['nama_barang'] ."</td>
                  <td>". $data1['satuan'] ."</td>
                  <td><span id='text-stok-sekarang-".$data1['id']."'>". rp($data1['stok_sekarang']) ."</span></td>

                  <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['fisik'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['fisik']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-faktur='".$data1['no_faktur']."' data-harga='".$data1['harga']."' data-kode='".$data1['kode_barang']."' data-selisih-fisik='".$data1['selisih_fisik']."' data-stok-sekarang='".$data1['stok_sekarang']."'> </td>

                  <td><span id='text-selisih-fisik-".$data1['id']."'>". rp($data1['selisih_fisik']) ."</span></td>
                  <td><span id='text-hpp-".$data1['id']."'>". rp($data1['hpp']) ."</span></td>
                  <td><span id='text-selisih-".$data1['id']."'>". rp($data1['selisih_harga']) ."</span></td>
                  <td>". rp($data1['harga']) ."</td>
                  
                  <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-nama-barang='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 


                  </tr>";
                  }

                  //Untuk Memutuskan Koneksi Ke Database
                  mysqli_close($db);   
                  ?>
                  </tbody>
                  
                  </table>