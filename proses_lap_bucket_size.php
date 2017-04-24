<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */


$dari_tgl = stringdoang($_POST['dari_tanggal']);
$sampai_tgl = stringdoang($_POST['sampai_tanggal']);
$kelipatan = angkadoang($_POST['kelipatan']);
$satu = 1;
$total_range = 0;

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name

    0=>'omset', 
    1=>'total_faktur',
    2=>'%'
);




// getting total number records without any search
$sql = "SELECT MAX(total) AS total ";
$sql.=" FROM penjualan";
$sql.=" WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT MAX(total) AS total ";
$sql.=" FROM penjualan";
$sql.=" WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND (tanggal LIKE '".$requestData['search']['value']."%' )";  
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();

$row=mysqli_fetch_array($query);

            $total1 = $kelipatan + $row['total'];
            
            while($kelipatan <= $total1) {

    $nestedData=array(); 

    $nestedData[] = rp($satu) ." - ". rp($kelipatan);

    $query2 = $db->query("SELECT COUNT(*) AS total_faktur FROM penjualan WHERE total BETWEEN '$satu' AND '$kelipatan' AND tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' ");
    $data2 = mysqli_fetch_array($query2);

    $query5 = $db->query("SELECT COUNT(*) AS total_faktur_semua FROM penjualan WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl'");
    $data5 = mysqli_fetch_array($query5);
    
    //hitung persen 
    $hitung = $data2['total_faktur'] / $data5['total_faktur_semua'] * 100;


    $nestedData[] = rp($data2['total_faktur']);
    
    $nestedData[] = rp(round($hitung));
      
    //hitung total range
    $total_range = $total_range + $hitung;
    $kelipatan1 = angkadoang($_POST['kelipatan']);
    $kelipatan += $kelipatan1;
    $satu += $kelipatan1;

    $data[] = $nestedData;
    
        
   
}
$nestedData=array();

$nestedData[] = "<font color='red'><b>TOTAL</b></font>";
$nestedData[] = "<font color='red'><b>".$data5['total_faktur_semua']."</b></font>";
$nestedData[] =  "<font color='red'><b>".$total_range."</b></font>";


$data[] = $nestedData;

$json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

echo json_encode($json_data);  // send data as json format

 ?>