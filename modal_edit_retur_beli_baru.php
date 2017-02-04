<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$nama_suplier = $_POST['nama_suplier'];
$no_faktur_retur = $_POST['no_faktur_retur'];

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

  0=>'kode_barang', 
  1=>'nama_barang',
  2=>'satuan',
  3=>'no_faktur',
  4=>'jumlah_barang',
  5=>'id_produk', 
  6=>'asal_satuan',
  7=>'harga',
  8=>'nama',
  9=>'subtotal',
  10=>'potongan', 
  11=>'tax',
  12=>'sisa',
  13=>'id'


);

// getting total number records without any search
$sql = "SELECT b.id AS id_produk, b.satuan AS satuan_dasar, dp.no_faktur, dp.tanggal, dp.kode_barang, dp.nama_barang, dp.jumlah_barang, dp.satuan AS satuan_beli, dp.harga, dp.subtotal, dp.potongan, dp.tax, dp.status, dp.sisa, sp.id, dp.asal_satuan, dp.satuan, b.satuan AS satuan_barang , ss.nama AS satuan_real , st.nama AS satuan_asli ";
$sql.=" FROM detail_pembelian dp LEFT JOIN pembelian p ON dp.no_faktur = p.no_faktur LEFT JOIN suplier sp ON p.suplier = sp.id LEFT JOIN barang b ON dp.kode_barang = b.kode_barang LEFT JOIN satuan ss ON dp.satuan = ss.id LEFT JOIN satuan st ON b.satuan = st.id ";
$sql.=" WHERE p.suplier = '$nama_suplier' GROUP BY dp.no_faktur, dp.kode_barang";
$sql.=" ";

$query = mysqli_query($conn, $sql) or die("Salahnya Ada Disini 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql = "SELECT b.id AS id_produk, b.satuan AS satuan_dasar, dp.no_faktur, dp.tanggal, dp.kode_barang, dp.nama_barang, dp.jumlah_barang, dp.satuan AS satuan_beli, dp.harga, dp.subtotal, dp.potongan, dp.tax, dp.status, dp.sisa, sp.id, dp.asal_satuan, dp.satuan, b.satuan AS satuan_barang , ss.nama AS satuan_real , st.nama AS satuan_asli ";
$sql.=" FROM detail_pembelian dp LEFT JOIN pembelian p ON dp.no_faktur = p.no_faktur LEFT JOIN suplier sp ON p.suplier = sp.id LEFT JOIN barang b ON dp.kode_barang = b.kode_barang LEFT JOIN satuan ss ON dp.satuan = ss.id LEFT JOIN satuan st ON b.satuan = st.id ";
$sql.=" WHERE p.suplier = '$nama_suplier' ";

  $sql.=" AND ( dp.kode_barang LIKE '".$requestData['search']['value']."%' ";  
  $sql.=" OR dp.nama_barang LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR p.suplier LIKE '".$requestData['search']['value']."%')";

}

$query=mysqli_query($conn, $sql) or die("Salahnya Ada Disini 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
    
$sql.=" ORDER BY dp.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("Salahnya Ada Disini 3");


$data = array();


while( $row=mysqli_fetch_array($query) ) {


//harga tabel penjualan
$harga_beli = $row['harga'];
//no faktur jual
$no_faktur_beli = $row['no_faktur'];
// kode barang
$kode_barang = $row['kode_barang'];




$sum_sisa = $db->query("SELECT IFNULL(SUM(sisa),0) AS jumlah_sisa_produk FROM hpp_masuk WHERE sisa > 0 AND kode_barang = '$row[kode_barang]' AND (jenis_transaksi = 'Pembelian' OR jenis_transaksi = 'Retur Penjualan') ");
$data_sum_sisa = mysqli_fetch_array($sum_sisa);

$jum_retur_detail = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_detail FROM detail_retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur' AND kode_barang = '$kode_barang'");
$data_jum_retur_detail = mysqli_fetch_array($jum_retur_detail);

$jum_retur_tbs = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_tbs FROM tbs_retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur' AND kode_barang = '$kode_barang'");
$data_jum_retur_tbs = mysqli_fetch_array($jum_retur_tbs);

$tbs_retur = $db->query("SELECT * FROM tbs_retur_pembelian WHERE  no_faktur_retur = '$no_faktur_retur' AND kode_barang = '$kode_barang' ");
$data_tbs_retur = mysqli_num_rows($tbs_retur);

if ($data_tbs_retur > 0) {
  $total_sisa_produk = ( $data_sum_sisa['jumlah_sisa_produk'] + $data_jum_retur_detail['jumlah_retur_detail'] ) - $data_jum_retur_tbs['jumlah_retur_tbs'];
}

else{
  $total_sisa_produk = $data_sum_sisa['jumlah_sisa_produk'] + $data_jum_retur_detail['jumlah_retur_detail'];
}




// sisa barang hpp keluar
$select_sisa = $db->query("SELECT SUM(sisa) AS sisa FROM hpp_masuk WHERE no_faktur = '$row[no_faktur]' AND kode_barang = '$kode_barang' ");
$data1 = mysqli_fetch_array($select_sisa);
$sisa_barang_hpp = $data1['sisa'];

// jumlah retur tbs retur
$select_jumlah_tbs = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_tbs, satuan FROM tbs_retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur' AND no_faktur_pembelian = '$no_faktur_beli' AND kode_barang = '$kode_barang'  ");
$data2 = mysqli_fetch_array($select_jumlah_tbs);
$jumlah_retur_tbs = $data2['jumlah_retur_tbs'];


// jumlah retur detail retur
$select_jumlah_detail = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_detail FROM detail_retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur' AND no_faktur_pembelian = '$no_faktur_beli' AND kode_barang = '$kode_barang'  ");
$data3 = mysqli_fetch_array($select_jumlah_detail);
$jumlah_retur_detail = $data3['jumlah_retur_detail'];

// konversi dari satuan konversi
$select_konversi = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$row[satuan_beli]'");
$data4 = mysqli_fetch_array($select_konversi);
$jumlah_konversi = $data4['konversi'];



// jika jumlah retur tbs != 0
if ($jumlah_retur_tbs != '') {
 
        //jumlah tbs sebenarnya
        if ($data2['satuan'] == $row['satuan_barang']) {

          $jumlah_tbs = $jumlah_retur_tbs;
        }
        else{
          $jumlah_tbs = $jumlah_retur_tbs * $jumlah_konversi;
        } 

} // END if ($jumlah_retur_tbs != '')
else
{
  $jumlah_tbs = 0;
}

//sisa barang sebenarnya
$sisa_barang_sebenarnya = ($sisa_barang_hpp + $jumlah_retur_detail) - $jumlah_tbs;
// data konfersi kosong run under
if ($jumlah_konversi == '')
      {

          $penentu_satuan = 1;
          $jumlah_tampil = $row['jumlah_barang'];
      }
      else
      {
          $penentu_satuan = $sisa_barang_sebenarnya % $jumlah_konversi;
          $jumlah_tampil = $row['jumlah_barang'] /  $jumlah_konversi; 
      }
//sisa barang yang tampil pada modal
if ($row['satuan_barang'] == $row['satuan_beli']) {
        $sisa_barang_tampil = $sisa_barang_sebenarnya;
        $satuan_tampil = $row['satuan_beli'];
        $harga_tampil = $row['harga'];


}

else{
        
        if ($penentu_satuan == 0) {
           $harga_tampil = $row['harga'] * $jumlah_konversi;
           $sisa_barang_tampil = $sisa_barang_sebenarnya / $jumlah_konversi;
           $satuan_tampil = $row['satuan_beli'];

        }//end if ($penentu_satuan == 0)
        else
        {
          $sisa_barang_tampil = $sisa_barang_sebenarnya;
          $satuan_tampil = $row['satuan_barang'];
          $harga_tampil = $row['harga'];

        }

}// end else

  $nestedData=array(); 




  $nestedData[] = $row["kode_barang"];
  $nestedData[] = $row["nama_barang"];

  $nestedData[] = "$jumlah_tampil";

  $nestedData[] = $row["satuan_real"];
  
  $nestedData[] = rp("$harga_tampil");

  $nestedData[] = rp($row["subtotal"]);
  $nestedData[] = rp($row["potongan"]);
  $nestedData[] = rp($row["tax"]);

  $nestedData[] = $total_sisa_produk ." ".$row["satuan_asli"];

  $nestedData[] = $row["harga"];
  $nestedData[] = $row["asal_satuan"];
  $nestedData[] = $row["id_produk"];
  $nestedData[] = $row["satuan"];
  $nestedData[] = $total_sisa_produk;  
  $nestedData[] = $row["no_faktur"];
  $nestedData[] = $row["satuan_dasar"];
  $nestedData[] = $row["harga"];

  
  $data[] = $nestedData;
    
}


$json_data = array(
      "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal"    => intval( $totalData ),  // total number of records
      "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data"            => $data   // total data array
      );

echo json_encode($json_data);  // send data as json format

 ?>