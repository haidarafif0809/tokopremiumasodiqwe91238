<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$no_faktur_pembayaran = stringdoang($_POST['no_faktur_pembayaran']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'no_faktur_pembayaran', 
    1=>'no_faktur_penjualan',
    2=>'tanggal',
    3=>'tanggal_jt',
    4=>'kredit',
    5=>'potongan',
    6=>'total',
    7=>'jumlah_bayar'

);

// getting total number records without any search
$sql =" SELECT *";
$sql.=" FROM tbs_pembayaran_piutang ";
$sql.=" WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'  ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT * ";
$sql.=" FROM tbs_pembayaran_piutang  ";
$sql.=" WHERE no_faktur_pembayaran = '$no_faktur_pembayaran' ";

    $sql.=" AND ( no_faktur_pembayaran LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR no_faktur_penjualan LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR jumlah_bayar LIKE '".$requestData['search']['value']."%' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY no_faktur_pembayaran ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 



      $nestedData[] = $row["no_faktur_pembayaran"];
      $nestedData[] = $row["no_faktur_penjualan"];
      $nestedData[] = $row["tanggal"];
      $nestedData[] = $row["tanggal_jt"];
      $nestedData[] = "<p  align='right'>".rp($row["kredit"])."</p>";
      $nestedData[] = "<p style='font-size:15px' align='right'> ".rp($row["potongan"])." </span> </p>";
      $nestedData[] = "<p style='font-size:15px' align='right'> ".rp($row["total"])." </span> </p>";
      $nestedData[] = "<p style='font-size:15px' align='right'> ".rp($row["jumlah_bayar"])." </span> </p>";



      $nestedData[] = "<button class='btn btn-danger btn-hapus btn-sm' data-id='". $row['id'] ."' data-faktur='". $row['no_faktur_penjualan'] ."' data-piutang='". $row['kredit'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>";

       $nestedData[] = " <button class='btn btn-success btn-edit-tbs btn-sm' data-id='". $row['id'] ."' data-kredit='". $row['kredit'] ."' data-jumlah-bayar='". $row['jumlah_bayar'] ."' data-no-faktur-penjualan='". $row['no_faktur_penjualan'] ."' data-potongan='". $row['potongan'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button>";


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