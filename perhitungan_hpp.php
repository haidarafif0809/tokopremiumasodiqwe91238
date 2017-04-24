<?php include 'session_login.php';


    include 'header.php';
    include 'navbar.php';
    include 'db.php';
    include 'sanitasi.php';

    $pilih = $db->query("SELECT kode_barang FROM barang");
    while ($ambil_dr_barang = mysqli_fetch_array($pilih)) 
    {
    	// STOK AWAL

    	$pilih_sa = $db->query("SELECT jumlah_awal,harga,total,tanggal,jam FROM stok_awal WHERE kode_barang = '$ambil_dr_barang[kode_barang]'");
    	while ($ambil_dr_stok_awal = mysqli_fetch_array($pilih_sa))
    	{

    		$pilih2 = $db->query("SELECT tipe FROM hpp WHERE kode_produk = '$ambil_dr_barang[kode_barang]' AND tipe = 'Stok Awal'");
    		$jumlah_baris = mysqli_num_rows($pilih2);

    		if ($jumlah_baris == 0) 
    		{
    			$saldo_akhir = $ambil_dr_stok_awal['jumlah_awal'] * $ambil_dr_stok_awal['harga'];

    			$insert = "INSERT INTO hpp (tipe,kode_produk,jumlah_kuantitas,harga_satuan,jumlah_nilai,tanggal,waktu,kuantitas_akhir,saldo_akhir) VALUES ('Stok Awal', '$ambil_dr_barang[kode_barang]', '$ambil_dr_stok_awal[jumlah_awal]', '$ambil_dr_stok_awal[harga]','$ambil_dr_stok_awal[total]', '$ambil_dr_stok_awal[tanggal]', '$ambil_dr_stok_awal[tanggal] $ambil_dr_stok_awal[jam]' ,'$ambil_dr_stok_awal[jumlah_awal]', '$saldo_akhir')";

				if ($db->query($insert) === TRUE) {
				} else {
				echo "Error: " . $insert . "<br>" . $db->error;

				}
    		}



    	} 



    	// PEMBELIAN

    	$pilih_dpem = $db->query("SELECT dp.no_faktur,dp.kode_barang,dp.jumlah_barang,dp.tanggal,dp.harga,dp.subtotal,p.jam FROM detail_pembelian dp INNER JOIN pembelian p ON dp.no_faktur = p.no_faktur WHERE dp.kode_barang = '$ambil_dr_barang[kode_barang]'");
    	while ($ambil_dr_detail_pembelian = mysqli_fetch_array($pilih_dpem))
    	{

    		$pilih2 = $db->query("SELECT tipe FROM hpp WHERE kode_produk = '$ambil_dr_barang[kode_barang]' AND tipe = 'Pembelian' AND no_faktur = '$ambil_dr_detail_pembelian[no_faktur]'");
    		$jumlah_baris = mysqli_num_rows($pilih2);

    		if ($jumlah_baris == 0) 
    		{
    			$saldo_akhir = $ambil_dr_detail_pembelian['jumlah_barang'] * $ambil_dr_detail_pembelian['harga'];

    			$insert = "INSERT INTO hpp (no_faktur,tipe,kode_produk,jumlah_kuantitas,harga_satuan,jumlah_nilai,tanggal,waktu,kuantitas_akhir,saldo_akhir) VALUES ('$ambil_dr_detail_pembelian[no_faktur]', 'Pembelian', '$ambil_dr_barang[kode_barang]', '$ambil_dr_detail_pembelian[jumlah_barang]', '$ambil_dr_detail_pembelian[harga]','$ambil_dr_detail_pembelian[subtotal]', '$ambil_dr_detail_pembelian[tanggal]', '$ambil_dr_detail_pembelian[tanggal] $ambil_dr_detail_pembelian[jam]' ,'$ambil_dr_detail_pembelian[jumlah_barang]', '$saldo_akhir')";

				if ($db->query($insert) === TRUE) {
				} else {
				echo "Error: " . $insert . "<br>" . $db->error;
				
				}
    		}



    	} 


    	// ITEM MASUK

    	$pilih_dim = $db->query("SELECT di.no_faktur,di.kode_barang,di.jumlah,di.tanggal,di.harga,di.subtotal,i.jam FROM detail_item_masuk di INNER JOIN item_masuk i ON di.no_faktur = i.no_faktur WHERE di.kode_barang = '$ambil_dr_barang[kode_barang]'");
    	while ($ambil_dr_detail_item_masuk = mysqli_fetch_array($pilih_dim))
    	{

    		$pilih3 = $db->query("SELECT tipe FROM hpp WHERE kode_produk = '$ambil_dr_barang[kode_barang]' AND tipe = 'Item Masuk' AND no_faktur = '$ambil_dr_detail_item_masuk[no_faktur]'");
    		$jumlah_baris = mysqli_num_rows($pilih3);

    		if ($jumlah_baris == 0) 
    		{
    			$saldo_akhir = $ambil_dr_detail_item_masuk['jumlah'] * $ambil_dr_detail_item_masuk['harga'];

    			$insert = "INSERT INTO hpp (no_faktur,tipe,kode_produk,jumlah_kuantitas,harga_satuan,jumlah_nilai,tanggal,waktu,kuantitas_akhir,saldo_akhir) VALUES ('$ambil_dr_detail_item_masuk[no_faktur]', 'Item Masuk', '$ambil_dr_barang[kode_barang]', '$ambil_dr_detail_item_masuk[jumlah]', '$ambil_dr_detail_item_masuk[harga]','$ambil_dr_detail_item_masuk[subtotal]', '$ambil_dr_detail_item_masuk[tanggal]', '$ambil_dr_detail_item_masuk[tanggal] $ambil_dr_detail_item_masuk[jam]' ,'$ambil_dr_detail_item_masuk[jumlah]', '$saldo_akhir')";

				if ($db->query($insert) === TRUE) {
				} else {
				echo "Error: " . $insert . "<br>" . $db->error;
				
				}
    		}



    	} 


    	
    	// RETUR PEMBELIAN

    	$pilih_drpem = $db->query("SELECT drp.no_faktur_retur,drp.kode_barang,drp.jumlah_retur,drp.tanggal,drp.harga,drp.subtotal,rp.jam FROM detail_retur_pembelian drp INNER JOIN retur_pembelian rp ON drp.no_faktur_retur = rp.no_faktur_retur WHERE drp.kode_barang = '$ambil_dr_barang[kode_barang]'");
    	while ($ambil_dr_detail_retur_pembelian = mysqli_fetch_array($pilih_drpem))
    	{

    		$pilih4 = $db->query("SELECT tipe FROM hpp WHERE kode_produk = '$ambil_dr_barang[kode_barang]' AND tipe = 'Retur Pembelian' AND no_faktur = '$ambil_dr_detail_retur_pembelian[no_faktur_retur]'");
    		$jumlah_baris = mysqli_num_rows($pilih4);

    		if ($jumlah_baris == 0) 
    		{
    			$saldo_akhir = $ambil_dr_detail_retur_pembelian['jumlah_retur'] * $ambil_dr_detail_retur_pembelian['harga'];

    			$insert = "INSERT INTO hpp (no_faktur,tipe,kode_produk,jumlah_kuantitas,harga_satuan,jumlah_nilai,tanggal,waktu,kuantitas_akhir,saldo_akhir) VALUES ('$ambil_dr_detail_retur_pembelian[no_faktur_retur]', 'Retur Pembelian', '$ambil_dr_barang[kode_barang]', '$ambil_dr_detail_retur_pembelian[jumlah_retur]', '$ambil_dr_detail_retur_pembelian[harga]','$ambil_dr_detail_retur_pembelian[subtotal]', '$ambil_dr_detail_retur_pembelian[tanggal]', '$ambil_dr_detail_retur_pembelian[tanggal] $ambil_dr_detail_retur_pembelian[jam]' ,'$ambil_dr_detail_retur_pembelian[jumlah_retur]', '$saldo_akhir')";

				if ($db->query($insert) === TRUE) {
				} else {
				echo "Error: " . $insert . "<br>" . $db->error;
				
				}
    		}



    	} 



        // RETUR PENJUALAN

        $pilih_drpen = $db->query("SELECT drp.no_faktur_retur,drp.kode_barang,drp.jumlah_retur,drp.tanggal,drp.harga,drp.subtotal,rp.jam FROM detail_retur_penjualan drp INNER JOIN retur_penjualan rp ON drp.no_faktur_retur = rp.no_faktur_retur WHERE drp.kode_barang = '$ambil_dr_barang[kode_barang]'");
        while ($ambil_dr_detail_retur_penjualan = mysqli_fetch_array($pilih_drpen))
        {

            $pilih5 = $db->query("SELECT tipe FROM hpp WHERE kode_produk = '$ambil_dr_barang[kode_barang]' AND tipe = 'Retur Penjualan' AND no_faktur = '$ambil_dr_detail_retur_penjualan[no_faktur_retur]'");
            $jumlah_baris = mysqli_num_rows($pilih5);

            if ($jumlah_baris == 0) 
            {
                $saldo_akhir = $ambil_dr_detail_retur_penjualan['jumlah_retur'] * $ambil_dr_detail_retur_penjualan['harga'];

                $insert = "INSERT INTO hpp (no_faktur,tipe,kode_produk,jumlah_kuantitas,harga_satuan,jumlah_nilai,tanggal,waktu,kuantitas_akhir,saldo_akhir) VALUES ('$ambil_dr_detail_retur_penjualan[no_faktur_retur]', 'Retur Penjualan', '$ambil_dr_barang[kode_barang]', '$ambil_dr_detail_retur_penjualan[jumlah_retur]', '$ambil_dr_detail_retur_penjualan[harga]','$ambil_dr_detail_retur_penjualan[subtotal]', '$ambil_dr_detail_retur_penjualan[tanggal]', '$ambil_dr_detail_retur_penjualan[tanggal] $ambil_dr_detail_retur_penjualan[jam]' ,'$ambil_dr_detail_retur_penjualan[jumlah_retur]', '$saldo_akhir')";

                if ($db->query($insert) === TRUE) {
                } else {
                echo "Error: " . $insert . "<br>" . $db->error;
                
                }
            }



        }


        // PENJUALAN

        $pilih_dpen = $db->query("SELECT dp.no_faktur,dp.kode_barang,dp.jumlah_barang,dp.tanggal,p.jam FROM detail_penjualan dp INNER JOIN penjualan p ON dp.no_faktur = p.no_faktur WHERE dp.kode_barang = '$ambil_dr_barang[kode_barang]' ORDER BY p.tanggal,p.jam ASC ");

            $saldo_awal = 0;
            $saldo_pembelian = 0;
            $kuantitas_saldo_awal = 0;
            $kuantitas_pembelian = 0;
            $hpp = 0;

        while ($ambil_dr_detail_penjualan = mysqli_fetch_array($pilih_dpen))
        {
            $pilih_hpp = $db->query("SELECT tipe,jumlah_kuantitas,jumlah_nilai,harga_satuan,no_faktur FROM hpp WHERE kode_produk = '$ambil_dr_barang[kode_barang]' AND tanggal <= '$ambil_dr_detail_penjualan[tanggal]' AND '$ambil_dr_detail_penjualan[jam]' ORDER BY waktu ASC ");

        

            while ($ambil_dr_hpp = mysqli_fetch_array($pilih_hpp)) 
            {
                if ($ambil_dr_hpp['tipe'] == 'Stok Awal') 
                {
                    $saldo_awal = $saldo_awal + $ambil_dr_hpp['jumlah_nilai'];
                    $kuantitas_saldo_awal = $saldo_awal + $ambil_dr_hpp['jumlah_kuantitas'];
                    
                }
               elseif ($ambil_dr_hpp['tipe'] == 'Pembelian') 
                {
                    $saldo_awal = $saldo_awal + $ambil_dr_hpp['jumlah_nilai'];
                    $kuantitas_saldo_awal = $saldo_awal + $ambil_dr_hpp['jumlah_kuantitas'];
             
                }

                elseif ($ambil_dr_hpp['tipe'] == 'Penjualan') 
                {   
                    $hpp = $saldo_awal / $kuantitas_saldo_awal;
                    $jumlah_nilai = $hpp * $ambil_dr_detail_penjualan['jumlah_barang'];
                    $saldo_awal = $saldo_awal - $jumlah_nilai;
                    $kuantitas_saldo_awal = $saldo_awal - $ambil_dr_hpp['jumlah_kuantitas'];

                    
                }

                if ($ambil_dr_hpp['no_faktur'] != $ambil_dr_detail_penjualan['no_faktur']){

                $insert = "INSERT INTO hpp (no_faktur,tipe,kode_produk,jumlah_kuantitas,harga_satuan,jumlah_nilai,tanggal,waktu,kuantitas_akhir,saldo_akhir) VALUES ('$ambil_dr_detail_penjualan[no_faktur]', 'Penjualan', '$ambil_dr_barang[kode_barang]', '$ambil_dr_detail_penjualan[jumlah_barang]', '$hpp','$jumlah_nilai', '$ambil_dr_detail_penjualan[tanggal]', '$ambil_dr_detail_penjualan[tanggal] $ambil_dr_detail_penjualan[jam]' ,'$kuantitas_saldo_awal', '$saldo_awal')";

                if ($db->query($insert) === TRUE) {
                } else {
                echo "Error: " . $insert . "<br>" . $db->error;
                
                }

                }

                else{

                }


                
            }





        }  



    }
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>