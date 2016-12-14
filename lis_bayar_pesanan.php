<?php session_start();

    include 'sanitasi.php';
    include 'db.php';








    //mengirim data sesuai dengan variabel denagn metode POST 

    $kode_barang = stringdoang($_POST['kode_barang']);
    $harga = angkadoang($_POST['harga']);
    $jumlah_barang = 1;
    $nama_barang = stringdoang($_POST['nama_barang']);
    $user = $_SESSION['nama'];





  


    $kode_barang = stringdoang($_POST['kode_barang']);
    $jumlah_barang = 1;
        





        $query020 = $db->query("SELECT SUM(jumlah_barang) AS total_barang FROM detail_pembelian WHERE kode_barang = '$kode_barang'");
        $hasil1 = mysqli_fetch_array($query020);
        $jumlah_masuk_pembelian = $hasil1['total_barang'];


        $query303 = $db->query("SELECT SUM(jumlah) AS jumlah_item FROM detail_item_masuk WHERE kode_barang = '$kode_barang'");
        $hasil2 = mysqli_fetch_array($query303);
        $jumlah_detail_masuk_pembelian = $hasil2['jumlah_item'];

        $hasil_masuk = $jumlah_masuk_pembelian + $jumlah_detail_masuk_pembelian;



        $query7 = $db->query("SELECT SUM(subtotal) AS harga_total FROM detail_pembelian WHERE kode_barang = '$kode_barang'");
        $hasil6 = mysqli_fetch_array($query7);
        $harga_total = $hasil6['harga_total'];

        $hpp = $harga_total / $hasil_masuk;


        if ($hasil_masuk != 0 AND $harga_total != 0) 
        {
         
         $total_hpp = $hpp * $jumlah_barang;

        }
        else 
        {
          $total_hpp = 0;
        }


// MENGAMBIL DATA STOK BARANG-->
        $perintah0 = $db->query("SELECT * FROM barang");
        
        

       
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

            $query200 = $db->query("SELECT SUM(selisih_fisik) AS jumlah_fisik FROM detail_stok_opname WHERE kode_barang = '$kode_barang'");
            $cek200 = mysqli_fetch_array($query200);
            $jumlah_fisik = $cek200['jumlah_fisik'];
//total barang 1
            $total_1 = $jumlah_pembelian + $jumlah_item_masuk + $jumlah_retur_penjualan + $jumlah_stok_awal + $jumlah_fisik;


 

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

$stok_barang = $total_1 - $total_2;

// MENGAMBIL DATA STOK BARANG--<


                $no_faktur = stringdoang($_POST['no_faktur']);
   $no_terakhir = $db->query("SELECT no_pesanan FROM penjualan WHERE no_faktur = '$_POST[no_faktur]'");
                $cek10 = mysqli_fetch_array($no_terakhir);
                
                $nomor = $cek10['no_pesanan'];
                $no_pesanan = $nomor + 1;

    $cek = $db->query("SELECT * FROM detail_penjualan WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur' AND no_pesanan = $no_pesanan");

    $tes = mysqli_fetch_array($cek);
    $jumlah = mysqli_num_rows($cek);
    

    $jumlah_pos = $tes['jumlah_barang'];

    if ($jumlah_pos >= $stok_barang) 

    {
      
    }

    else
    {

        if ($jumlah > 0)
            {
                
                $query01 = $db->prepare("UPDATE detail_penjualan SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ? WHERE kode_barang = ? AND no_faktur = ? AND no_pesanan = ?");
                
                $query01->bind_param("iissi",
                $jumlah_barang, $subtotal, $kode_barang, $no_faktur, $no_pesanan);
                
                $no_faktur = stringdoang($_POST['no_faktur']);
                $harga = angkadoang($_POST['harga']);
                $subtotal = $harga * $jumlah_barang;
                $kode_barang = stringdoang($_POST['kode_barang']);    
                $jumlah_barang = 1;
                
                $query01->execute();

            }

        else
            {

                $no_terakhir = $db->query("SELECT no_pesanan FROM penjualan WHERE no_faktur = '$_POST[no_faktur]'");
                $cek10 = mysqli_fetch_array($no_terakhir);
                
                $nomor = $cek10['no_pesanan'];
                $no_pesanan = $nomor + 1;


                $perintah02 = $db->prepare("INSERT INTO detail_penjualan (no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,hpp,no_pesanan) VALUES (?,?,
                ?,?,?,?,?,?,?)");
                
                
                $perintah02->bind_param("sssisiiii",
                $no_faktur, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga, $subtotal, $total_hpp,$no_pesanan);
                
                $no_faktur = stringdoang($_POST['no_faktur']);
                $kode_barang = stringdoang($_POST['kode_barang']);
                $jumlah_barang = 1;
                $nama_barang = stringdoang($_POST['nama_barang']);
                $satuan = stringdoang($_POST['satuan']);
                $harga = angkadoang($_POST['harga']);
                $subtotal = $harga * $jumlah_barang;
                
                
                $perintah02->execute();

            }


    }

    ?>


<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
    <thead>
      <th> Nama Barang </th>
      <th> Jumlah Barang </th>
      <th> Subtotal </th>
      <th> Edit </th>
      <th> Hapus </th>


    </thead>
    <tbody>
    <?php
  $perintah = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
    while ($data1 = mysqli_fetch_array($perintah))
    {
        echo "<tr>
      <td>". $data1['nama_barang'] ."</td>
      <td>". $data1['jumlah_barang'] ."</td>
      <td>". rp($data1['subtotal']) ."</td>
     
     <td> <button class='btn btn-success btn-edit-tbs' data-id='". $data1['id'] ."' data-jumlah-barang='". $data1['jumlah_barang'] ."' data-kode='". $data1['kode_barang'] ."' data-harga='". $data1['harga'] ."'><span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>
     
       <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-pesanan='". $data1['nama_barang'] ."' > Hapus </button> </td> 

      </tr>";
    }
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>
    </div>
    </tbody>
  </table>

