<?php include 'session_login.php';

include 'db.php';
include 'sanitasi.php';

$nomor = stringdoang($_GET['nomor']);

$select = $db->query("SELECT * FROM data_perubahan_masal WHERE nomor = '$nomor'");
$out = mysqli_fetch_array($select);


$perintah = $db->query("SELECT * FROM barang WHERE kategori = '$out[kategori]'");
      //menyimpan data sementara yang ada pada $perintah
while ($data = mysqli_fetch_array($perintah))
{
            
// start ambil hpp per barang
   $take_hpp = $db->query("SELECT total_nilai FROM hpp_masuk WHERE kode_barang = '$data[kode_barang]' ORDER BY tanggal DESC LIMIT 1");
            while ($out_hpp = mysqli_fetch_array($take_hpp))
      {   

// start tampilan harga lama (harga sebelumnya)
      if ($out['perubahan_harga'] == 'Level 1')
      {
            $harga_lama = $data['harga_jual'];
      }
        else if ($out['perubahan_harga'] == 'Level 2')
      {
            $harga_lama = $data['harga_jual2'];
      }

        else if ($out['perubahan_harga'] == 'Level 3')
      {
            $harga_lama = $data['harga_jual3'];
      }
        else if ($out['perubahan_harga'] == 'Level 4')
      {
            $harga_lama = $data['harga_jual4'];
      }
        else if ($out['perubahan_harga'] == 'Level 5')
      {
            $harga_lama = $data['harga_jual5'];
      }
        else if ($out['perubahan_harga'] == 'Level 6')
      {
            $harga_lama = $data['harga_jual6'];
      }
        else
      {
            $harga_lama = $data['harga_jual7'];
      }
// end tampilan harga lama (harga sebelumnya)



// MULAI HARGA BARU

// JIKA HARGA NAIK     
if($out['pola_perubahan'] == 'Naik')
{
      // start untuk acuan harga HPP
      if ($out['acuan_harga'] == 'HPP')
      {
                  if( $out['nilai'] == 'Persentase')
                  {
                        $hitung_1 = $out_hpp['total_nilai'] * $out['jumlah_nilai'] / 100;
                        $hasil = $out_hpp['total_nilai'] + round($hitung_1);
                  

                  }
                  else
                  {
                        $hitung_1 = $out_hpp['total_nilai'] + $out['jumlah_nilai'];
                        $hasil = round($hitung_1);
                  
                  }

      }
      // end acuan harga HPP

// Start Level satu
      else if ($out['acuan_harga'] == 'Level 1')
      {
            

                  if( $out['nilai'] == 'Persentase')
                  {
                        $hitung_1 = $data['harga_jual'] * $out['jumlah_nilai'] / 100;
                        $hasil = $data['harga_jual'] + round($hitung_1);
                  

                  }
                  else
                  {
                        $hitung_1 = $data['harga_jual'] + $out['jumlah_nilai'];
                        $hasil = round($hitung_1);
                  
                  }

          
     
      } // END Level satu

      // start level 2
      else if ($out['acuan_harga'] == 'Level 2')
      {

           

                  if( $out['nilai'] == 'Persentase')
                  {
                        $hitung_1 = $data['harga_jual2'] * $out['jumlah_nilai'] / 100;
                        $hasil = $data['harga_jual2'] + round($hitung_1);
                  

                  }
                  else
                  {
                        $hitung_1 = $data['harga_jual2'] + $out['jumlah_nilai'];
                        $hasil = round($hitung_1);
                  
                  }

           

      }// eND level 2

      // START LEVEL 3
      else if ($out['acuan_harga'] == 'Level 3')
      {


            
                  if( $out['nilai'] == 'Persentase')
                  {
                        $hitung_1 = $data['harga_jual3'] * $out['jumlah_nilai'] / 100;
                        $hasil = $data['harga_jual3'] + round($hitung_1);
                  

                  }
                  else
                  {
                        $hitung_1 = $data['harga_jual3'] + $out['jumlah_nilai'];
                        $hasil = round($hitung_1);
                  
                  }

           

      } // END LEVEL 3

      // start level 4
      else if ($out['acuan_harga'] == 'Level 4')
      {


          

                  if( $out['nilai'] == 'Persentase')
                  {
                        $hitung_1 = $data['harga_jual4'] * $out['jumlah_nilai'] / 100;
                        $hasil = $data['harga_jual4'] + round($hitung_1);
                  

                  }
                  else
                  {
                        $hitung_1 = $data['harga_jual4'] + $out['jumlah_nilai'];
                        $hasil = round($hitung_1);
                  
                  }

           

      } // end level 4

      // START LEVEL 5
      else if ($out['acuan_harga'] == 'Level 5')
      {

           

                  if( $out['nilai'] == 'Persentase')
                  {
                        $hitung_1 = $data['harga_jual5'] * $out['jumlah_nilai'] / 100;
                        $hasil= $data['harga_jual5'] + round($hitung_1);
                  

                  }
                  else
                  {
                        $hitung_1 = $data['harga_jual5'] + $out['jumlah_nilai'];
                        $hasil= round($hitung_1);
                  
                  }

          

      } // END LEVEL 5

       // start level 6
      else if ($out['acuan_harga'] == 'Level 6')
      {

            
                  if( $out['nilai'] == 'Persentase')
                  {
                        $hitung_1 = $data['harga_jual6'] * $out['jumlah_nilai'] / 100;
                        $hasil= $data['harga_jual6'] + round($hitung_1);
                  echo "  <td>". rp(round($hasil)) ."</td>";

                  }
                  else
                  {
                        $hitung_1 = $data['harga_jual6'] + $out['jumlah_nilai'];
                        $hasil= round($hitung_1);
                  
                  }

           

      }// end level 6

      // START LEVEL 7
      else
      {

           

                  if( $out['nilai'] == 'Persentase')
                  {
                        $hitung_1 = $data['harga_jual7'] * $out['jumlah_nilai'] / 100;
                        $hasil= $data['harga_jual7'] + round($hitung_1);
                  

                  }
                  else
                  {
                        $hitung_1 = $data['harga_jual7'] + $out['jumlah_nilai'];
                        $hasil= round($hitung_1);
                  
                  }

           
      } // END LEVEL 7

}

else // ELSE JIKA HARGA TURUN
{
      // start untuk acuan harga HPP
      if ($out['acuan_harga'] == 'HPP')
      {

           
                  if( $out['nilai'] == 'Persentase')
                  {
                        $hitung_1 = $out_hpp['total_nilai'] * $out['jumlah_nilai'] / 100;
                        $hasil = $out_hpp['total_nilai'] - round($hitung_1);
                  
                  }
                  else
                  {
                        $hitung_1 = $out_hpp['total_nilai'] - $out['jumlah_nilai'];
                        $hasil = round($hitung_1);
                  
                  }

            

      }
      // end acuan harga HPP

// Start Level satu
      else if ($out['acuan_harga'] == 'Level 1')
      {
           
                  if( $out['nilai'] == 'Persentase')
                  {
                        $hitung_1 = $data['harga_jual'] * $out['jumlah_nilai'] / 100;
                        $hasil = $data['harga_jual'] - round($hitung_1);
                  

                  }
                  else
                  {
                        $hitung_1 = $data['harga_jual'] - $out['jumlah_nilai'];
                        $hasil = round($hitung_1);
                  

                  }

            
     
      } // END Level satu

      // start level 2
      else if ($out['acuan_harga'] == 'Level 2')
      {

          
                  if( $out['nilai'] == 'Persentase')
                  {
                        $hitung_1 = $data['harga_jual2'] * $out['jumlah_nilai'] / 100;
                        $hasil = $data['harga_jual2'] - round($hitung_1);
                  

                  }
                  else
                  {
                        $hitung_1 = $data['harga_jual2'] - $out['jumlah_nilai'];
                        $hasil = round($hitung_1);
                  

                  }

            

      }// eND level 2

      // START LEVEL 3
      else if ($out['acuan_harga'] == 'Level 3')
      {


                  if( $out['nilai'] == 'Persentase')
                  {
                        $hitung_1 = $data['harga_jual3'] * $out['jumlah_nilai'] / 100;
                        $hasil = $data['harga_jual3'] - round($hitung_1);
                  

                  }
                  else
                  {
                        $hitung_1 = $data['harga_jual3'] - $out['jumlah_nilai'];
                        $hasil = round($hitung_1);
                  

                  }

            

      } // END LEVEL 3

      // start level 4
      else if ($out['acuan_harga'] == 'Level 4')
      {


            
                  if( $out['nilai'] == 'Persentase')
                  {
                        $hitung_1 = $data['harga_jual4'] * $out['jumlah_nilai'] / 100;
                        $hasil = $data['harga_jual4'] - round($hitung_1);
                  

                  }
                  else
                  {
                        $hitung_1 = $data['harga_jual4'] - $out['jumlah_nilai'];
                        $hasil = round($hitung_1);
                  

                  }

            

      } // end level 4

      // START LEVEL 5
      else if ($out['acuan_harga'] == 'Level 5')
      {

           
                  if( $out['nilai'] == 'Persentase')
                  {
                        $hitung_1 = $data['harga_jual5'] * $out['jumlah_nilai'] / 100;
                        $hasil= $data['harga_jual5'] - round($hitung_1);
                  

                  }
                  else
                  {
                        $hitung_1 = $data['harga_jual5'] - $out['jumlah_nilai'];
                        $hasil= round($hitung_1);
                  

                  }

            

      } // END LEVEL 5

       // start level 6
      else if ($out['acuan_harga'] == 'Level 6')
      {

                  if( $out['nilai'] == 'Persentase')
                  {
                        $hitung_1 = $data['harga_jual6'] * $out['jumlah_nilai'] / 100;
                        $hasil= $data['harga_jual6'] - round($hitung_1);
                  

                  }
                  else
                  {
                        $hitung_1 = $data['harga_jual6'] - $out['jumlah_nilai'];
                        $hasil= round($hitung_1);
                  

                  }

            

      }// end level 6

      // START LEVEL 7
      else
      {

           
                  if( $out['nilai'] == 'Persentase')
                  {
                        $hitung_1 = $data['harga_jual7'] * $out['jumlah_nilai'] / 100;
                        $hasil= $data['harga_jual7'] - round($hitung_1);
                  

                  }
                  else
                  {
                        $hitung_1 = $data['harga_jual7'] - $out['jumlah_nilai'];
                        $hasil= round($hitung_1);
                  

                  }

            
      } // END LEVEL 7
}
   
// AKHIR HARGA BARU

$angka_akhir = substr($hasil, -2);

if($angka_akhir >= 80)
{
      $cek_one = $hasil - $angka_akhir;
      $pembulatan = $cek_one + 100;

}
else if ($angka_akhir >= 60 AND $angka_akhir <= 79)
{
      $cek_one = $hasil - $angka_akhir;
      $pembulatan = $cek_one + 75;
}
else if ($angka_akhir >= 31 AND $angka_akhir <= 59)
{
      $cek_one = $hasil - $angka_akhir;
      $pembulatan = $cek_one + 50;
}
else if ($angka_akhir >= 20 AND $angka_akhir <= 30)
{
      $cek_one = $hasil - $angka_akhir;
      $pembulatan = $cek_one + 25;
}
else if ($angka_akhir >= 0 AND $angka_akhir <= 19)
{
      $cek_one = $hasil - $angka_akhir;
      $pembulatan = $cek_one;
}
else
{

}

      $insert = $db->query("INSERT INTO tbs_perubahan_harga_masal (nomor,kode_barang,
            nama_barang,kategori,hpp,harga_lama,harga_baru,pembulatan) VALUES ('$nomor',
            '$data[kode_barang]', '$data[nama_barang]', '$data[kategori]', 
            '$out_hpp[total_nilai]', '$harga_lama', '$hasil', '$pembulatan')");
     

          

      }
}

       header ('location:data_perubahan_masal.php?nomor='.$nomor.'');

?>