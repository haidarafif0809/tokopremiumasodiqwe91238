<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$session_id = session_id();

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'no_faktur_order', 
    1=>'kode_barang',
    2=>'nama_barang',
    3=>'jumlah_barang',
    4=>'satuan',
    5=>'harga',
    6=>'subtotal',
    7=>'potongan',
    8=>'pajak', 
    9=>'id' 

);

// getting total number records without any search
$sql =" SELECT tp.no_faktur_order,tp.id,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama ";
$sql.=" FROM tbs_penjualan tp LEFT JOIN satuan s ON tp.satuan = s.id LEFT JOIN barang bb ON tp.kode_barang = bb.kode_barang ";
$sql.=" WHERE tp.session_id = '$session_id' AND (tp.no_faktur_order IS NOT NULL) ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT tp.no_faktur_order,tp.id,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama";
$sql.=" FROM tbs_penjualan tp LEFT JOIN satuan s ON tp.satuan = s.id ";
$sql.=" WHERE tp.session_id = '$session_id' AND  (tp.no_faktur_order IS NOT NULL)  ";

    $sql.=" AND ( tp.no_faktur_order LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR tp.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR tp.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY tp.no_faktur_order ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

      $nestedData[] = $row["no_faktur_order"];
      $nestedData[] = $row["kode_barang"];
      $nestedData[] = $row["nama_barang"];

      $nestedData[] = "<p style='font-size:15px' align='right' class='edit-jumlah' data-id='".$row['id']."'><span id='text-jumlah-".$row['id']."'>". $row['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".$row['jumlah_barang']."' class='input_jumlah' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_barang']."'  data-harga='".$row['harga']."' data-satuan='".$row['satuan']."' > </p>";

      $nestedData[] = $row["nama"];


      $nestedData[] = "<p  align='right'>".koma($row["harga"],2)."</p>";
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-subtotal-".$row['id']."'> ".koma($row["subtotal"],2)." </span> </p>";
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-potongan-".$row['id']."'> ".koma($row["potongan"],2)." </span> </p>";
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-tax-".$row['id']."'> ".koma($row["tax"],2)." </span> </p>";

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