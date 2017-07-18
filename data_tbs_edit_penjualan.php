<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';

/* Database connection end */

$no_faktur = stringdoang($_POST['no_faktur']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kode_barang', 
    1=>'nama_barang',
    2=>'jumlah_barang',
    3=>'satuan',
    4=>'harga',
    5=>'subtotal',
    6=>'potongan',
    7=>'tax',
    8=>'id'   

);

// getting total number records without any search
$sql =" SELECT tp.no_faktur,tp.jam,tp.id,tp.tipe_barang,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama";
$sql.=" FROM tbs_penjualan tp LEFT JOIN satuan s ON tp.satuan = s.id";
$sql.=" WHERE tp.no_faktur = '$no_faktur' AND (tp.no_faktur_order = '' OR tp.no_faktur_order IS NULL)  ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT tp.no_faktur,tp.jam,tp.id,tp.tipe_barang,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama";
$sql.=" FROM tbs_penjualan tp LEFT JOIN satuan s ON tp.satuan = s.id";
$sql.=" WHERE tp.no_faktur = '$no_faktur' AND (tp.no_faktur_order = '' OR tp.no_faktur_order IS NULL) ";

    $sql.=" AND (tp.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR tp.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY tp.kode_barang ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

        if ($row['nama'] != 'KG')
        {
          $jumlah_ganti = hapus_koma($row["jumlah_barang"]);
        }
        else 
        {
          $jumlah_ganti = koma($row["jumlah_barang"],3);
        }



      $nestedData[] = $row["kode_barang"];
      $nestedData[] = $row["nama_barang"];

      $nestedData[] = "<p style='font-size:15px' align='right' class='edit-jumlah-jual' data-id='".$row['id']."' data-kode-barang-input='".$row['kode_barang']."'> <span id='text-jumlah-".$row['id']."'>".$jumlah_ganti."</span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".koma($row['jumlah_barang'],3)."' class='input_jumlah_jual' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_barang']."' data-harga='".koma($row['harga'],2)."' data-tipe='".$row['tipe_barang']."' data-satuan='".$row['satuan']."'  data-nama_satuan='".$row['nama']."' data-nama-barang='".$row['nama_barang']."'> </p>";

      $nestedData[] = $row["nama"];

      $nestedData[] = "<p  align='right'>".koma($row["harga"],2)."</p>";
  
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-potongan-".$row['id']."'> ".koma($row["potongan"],2)." </span> </p>";
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-tax-".$row['id']."'> ".koma($row["tax"],2)." </span> </p>";

    $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-subtotal-".$row['id']."'> ".koma($row["subtotal"],2)." </span> </p>";

      $nestedData[] = "<button class='btn btn-danger btn-sm btn-hapus-tbs' id='hapus-tbs-". $row['id'] ."' data-id='". $row['id'] ."' data-faktur='". $row['no_faktur'] ."' data-kode-barang='". $row['kode_barang'] ."' data-barang='". $row['nama_barang'] ."' data-subtotal='". $row['subtotal'] ."'>Hapus</button>";




      $nestedData[] = $row["id"];

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