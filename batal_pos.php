<?php 
    // memasukan file db.php
    include 'db.php';
    // mengirim data(file) no_faktur, menggunakan metode GET 
    $session_id = $_POST['session_id'];
    // menghapus data pada tabel tbs_pembelian berdasarkan no_faktur 
    $query = $db->query("DELETE FROM tbs_penjualan WHERE session_id = '$session_id'");
    // logika $query => jika $query benar maka akan menuju ke formpemebelain.php
    // dan jika salah maka akan menampilkan kalimat failed
    
    

    ?>

<!--tabel untuk menghapus jika menggunakan button id di form-->
<table id="tableuser" class="table table-bordered">
                

                <thead>


                    <th> Nama Barang </th>
                    <th> Jumlah Barang </th>
                    <th> Subtotal </th>
                    <th> Hapus </th>

                </thead>
                <tbody>
                <?php
                
                // menampilkan seluruh data yang ada pada tabel barang
                $perintah = "SELECT * FROM tbs_penjualan WHERE session_id = '$session_id'";
                $perintah1 = $db->query($perintah);
                
                // menyimpoan data sementara yang ada pada $perintah1
                while ($data1 = mysqli_fetch_array($perintah1))
                {
                // menampilkan data
                        echo "<tr>
                        <td>". $data1['nama_barang'] ."</td>
                        <td>". $data1['jumlah_barang'] ."</td>
                        <td>". $data1['subtotal'] ."</td>
                        <td> <a href='hapus_pos_penjualan.php?id=". $data1['id']."' class='btn btn-danger hapus'><span class='glyphicon glyphicon-trash'></span> Hapus </a> </td> 
                </tr>";
                
                }
                
                //Untuk Memutuskan Koneksi Ke Database
                
                mysqli_close($db);
        
                ?>

                </tbody>
                </table>
