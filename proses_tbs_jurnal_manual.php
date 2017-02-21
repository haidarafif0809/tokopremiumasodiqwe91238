<?php session_start();
 
    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';

    $session_id = session_id();


    $kode_akun = stringdoang($_POST['kode_akun']);   
    

    //menampilkan data yang ada pada tbs penjualan berdasarkan kode barang
    $cek = $db->query("SELECT * FROM tbs_jurnal WHERE kode_akun_jurnal = '$kode_akun' AND session_id = '$session_id'");
    //menyimpan data sementara berupa baris dari variabel cek
    $jumlah1 = mysqli_num_rows($cek);
    
    if ($jumlah1 > 0)
    {

        $query1 = $db->prepare("UPDATE tbs_jurnal SET kredit = kredit + ?, debit = debit + ? WHERE kode_akun_jurnal = ? 
             AND session_id = ?");
             
             $query1->bind_param("iiss",
              $kredit, $debit, $kode_akun, $session_id);
             
             $kode_akun = stringdoang($_POST['kode_akun']);
             $kredit = angkadoang($_POST['kredit']);
             $debit = angkadoang($_POST['debit']);

        $query1->execute();

    }
    else
    {




        $perintah = $db->prepare("INSERT INTO tbs_jurnal (session_id,kode_akun_jurnal,nama_akun_jurnal,debit,kredit,keterangan) VALUES (?,?,?,?,?,?)");

        $perintah->bind_param("sssiis",
          $session_id, $kode_akun, $nama_akun, $debit, $kredit, $keterangan);
        
        $kode_akun = stringdoang($_POST['kode_akun']);
        $nama_akun = stringdoang($_POST['nama_akun']);
        $debit = angkadoang($_POST['debit']);
        $kredit = angkadoang($_POST['kredit']);
        $keterangan = stringdoang($_POST['keterangan']);


        
        $perintah->execute();

           if (!$perintah) {
            die('Query Error : '.$db->errno.
            ' - '.$db->error);
            }
            else {
            
            }



    }

    mysqli_close($db);   

    ?>
