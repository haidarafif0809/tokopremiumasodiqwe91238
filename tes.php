<?php session_start();

    //memasukkan file db.php
    include 'db.php';
    //mengirim data disetiap masing-masing variabel menggunakan metode POST
    $no_faktur = $_POST['no_faktur'];
    $suplier = $_POST['suplier'];
    $total = $_POST['total'];
    $potongan = $_POST['potongan'];
    $tax = $_POST['tax'];
    $sisa_pembayaran =$_POST['sisa_pembayaran'];
    $cara_bayar = $_POST['cara_bayar'];
    $user = $_SESSION['user_name'];
    
    $hutang = $total - $sisa_pembayaran;
        # code...
    //menambah data pada tabel barang sesuai dengan variabel atau database  
            $perintah = "INSERT INTO pembelian (no_faktur, suplier, total, tanggal, jam, user, status, potongan, tax, sisa)
            VALUES ('$no_faktur','$suplier','$total',now(),now(),'$user','
            Hutang','$potongan','$tax','$sisa_pembayaran')";

            $query5 = $db->query("UPDATE pembelian SET sisa =  '$hutang' WHERE no_faktur = '$no_faktur'");
             

    $perintah1 = $db->query("UPDATE kas SET jumlah = jumlah - '$total' WHERE nama = '$cara_bayar'");
    //logika=> jika $perintah benar maka akan menuju ke barang.php, jika salah maka muncul kalimat error			
    
    if ($db->query($query5) == TRUE)
    {
    }
    else
    {
        //menampilkan data
        echo "Error: " . $query5 . "<br>" . $db->error;
    }

    $query = $db->query("SELECT * FROM tbs_pembelian 
	WHERE no_faktur = '$no_faktur'");
    while ($data = mysqli_fetch_array($query))
    {
        # code...
        $query1 = $db->query("UPDATE barang SET jumlah_barang = jumlah_barang +'$data[jumlah_barang]' WHERE kode_barang = '$data[kode_barang]'");


        $query2 = $db->query("INSERT INTO detail_pembelian (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, sisa) 
		VALUES ('$data[no_faktur]','$data[kode_barang]','$data[nama_barang]','$data[jumlah_barang]','$data[satuan]','$data[harga]','$data[subtotal]','$data[potongan]','$data[tax]','$data[jumlah_barang]')");
    }

    $query3 = $db->query("DELETE  FROM tbs_pembelian WHERE no_faktur = $no_faktur");
    echo "Success";

if ($perintah == TRUE)
    {
        header ('location:formpembelian.php');
    }
    else
    {
        echo "Data Tidak Berhasil Di Masukan";
    }

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

    ?>

