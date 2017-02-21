<?php session_start();
 
    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';

    $session_id = session_id();


    $kode_barang = stringdoang($_POST['kode_barang']);   
    

    //menampilkan data yang ada pada tbs penjualan berdasarkan kode barang
    $cek = $db->query("SELECT * FROM tbs_item_masuk WHERE kode_barang = '$kode_barang' AND session_id = '$session_id'");
    //menyimpan data sementara berupa baris dari variabel cek
    $jumlah1 = mysqli_num_rows($cek);
    
    if ($jumlah1 > 0)
    {
        # code...
        $query1 = $db->prepare("UPDATE tbs_item_masuk SET jumlah = jumlah + ?,
             subtotal = subtotal + ? WHERE kode_barang = ? 
             AND session_id = ?");
             
             $query1->bind_param("iiss",
              $jumlah, $subtotal, $kode_barang, $session_id);
             
             $kode_barang = stringdoang($_POST['kode_barang']);
             $jumlah = angkadoang($_POST['jumlah_barang']);
             $subtotal = $harga * $jumlah;

        $query1->execute();

    }
    else
    {


$hpp_item_masuk = angkadoang($_POST['hpp_item_masuk']);

      if ($hpp_item_masuk == "") {


        $perintah = $db->prepare("INSERT INTO tbs_item_masuk (session_id,kode_barang,nama_barang,jumlah,satuan,harga,subtotal) VALUES (?,?,?,?,?,?,?)");

        $perintah->bind_param("sssisii",
          $session_id, $kode_barang, $nama_barang, $jumlah, $satuan, $harga, $subtotal);
        
        $nama_barang = stringdoang($_POST['nama_barang']);
        $satuan = stringdoang($_POST['satuan']);
        $harga = angkadoang($_POST['harga']);
        $jumlah = angkadoang($_POST['jumlah_barang']);
        $kode_barang = stringdoang($_POST['kode_barang']);
        $subtotal = $harga * $jumlah;


        
        $perintah->execute();

           if (!$perintah) {
            die('Query Error : '.$db->errno.
            ' - '.$db->error);
            }
            else {
            
            }


      }

      else{

        $perintah = $db->prepare("INSERT INTO tbs_item_masuk (session_id,kode_barang,nama_barang,jumlah,satuan,harga,subtotal) VALUES (?,?,?,?,?,?,?)");

        $perintah->bind_param("sssisii",
          $session_id, $kode_barang, $nama_barang, $jumlah, $satuan, $hpp_item_masuk, $subtotal);
        
        $nama_barang = stringdoang($_POST['nama_barang']);
        $satuan = stringdoang($_POST['satuan']);
        $jumlah = angkadoang($_POST['jumlah_barang']);
        $hpp_item_masuk = angkadoang($_POST['hpp_item_masuk']);
        $kode_barang = stringdoang($_POST['kode_barang']);
        $subtotal = $hpp_item_masuk * $jumlah;


        
        $perintah->execute();

           if (!$perintah) {
            die('Query Error : '.$db->errno.
            ' - '.$db->error);
            }
            else {
            
            }

      }


    }

    ?>
