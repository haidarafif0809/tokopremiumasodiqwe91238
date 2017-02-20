<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

    



// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'cetak_order', 
  1 => 'detail',
  2 =>'cetak_order', 
	3 => 'detail',
	4 => 'kode_pelanggan',
	5 => 'kode_gudang',
	6 => 'tanggal',
  7 => 'jam',
  8 => 'petugas_kasir',
  9 => 'total',
  10 => 'status_order',
  11 => 'keterangan',
  12 => 'id'
);




// getting total number records without any search
$sql = " SELECT u.nama,po.keterangan,po.id,po.no_faktur_order,po.total,po.kode_pelanggan,po.tanggal,po.jam,po.user,po.status_order,g.nama_gudang,po.kode_gudang,pl.nama_pelanggan ";
$sql.=" FROM penjualan_order po INNER JOIN gudang g ON po.kode_gudang = g.kode_gudang INNER JOIN pelanggan pl ON po.kode_pelanggan = pl.kode_pelanggan INNER JOIN user u ON po.user = u.id";
$query=mysqli_query($conn, $sql) or die("1.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT  u.nama,po.keterangan,po.id,po.no_faktur_order,po.total,po.kode_pelanggan,po.tanggal,po.jam,po.user,po.status_order,g.nama_gudang,po.kode_gudang,pl.nama_pelanggan  ";
$sql.=" FROM penjualan_order po INNER JOIN gudang g ON po.kode_gudang = g.kode_gudang INNER JOIN pelanggan pl ON po.kode_pelanggan = pl.kode_pelanggan INNER JOIN user u ON po.user = u.id WHERE 1=1 ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( po.no_faktur_order LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR po.kode_pelanggan LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR po.total LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR po.tanggal LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR po.kode_gudang LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR u.nama LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR pl.nama_pelanggan LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("2.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY po.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("3.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

     $pilih_akses_penjualan_edit = $db->query("SELECT penjualan_edit FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_edit = '1'");
$penjualan_edit = mysqli_num_rows($pilih_akses_penjualan_edit);


    if ($penjualan_edit > 0){

      

      $nestedData[] = "<a href='proses_edit_penjualan_order.php?no_faktur=". $row['no_faktur_order']."&kode_pelanggan=". $row['kode_pelanggan']."&nama_pelanggan=". $row['nama_pelanggan']."&nama_gudang=".$row['nama_gudang']."&kode_gudang=".$row['kode_gudang']."' class='btn btn-success'>Edit</a>"; 


    }


$pilih_akses_penjualan_hapus = $db->query("SELECT penjualan_hapus FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_hapus = '1'");
$penjualan_hapus = mysqli_num_rows($pilih_akses_penjualan_hapus);


  if ($penjualan_hapus > 0){

      $nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='".$row['id']."' data-pelanggan='".$row['nama_pelanggan']."' data-faktur='".$row['no_faktur_order']."' >Hapus</button>";
}




$nestedData[] = "<a href='cetak_penjualan_order.php?no_faktur=".$row['no_faktur_order']."' class='btn btn-primary ' target='blank'> Cetak  </a>";


    $nestedData[] = "<button class='btn btn-info detail' no_faktur='". $row['no_faktur_order'] ."' >Detail</button>";
    $nestedData[] = $row['no_faktur_order'];
    $nestedData[] = $row['kode_pelanggan'] ." - ".$row['nama_pelanggan'];
    $nestedData[] = $row['kode_gudang'];
    $nestedData[] = $row['tanggal'];
    $nestedData[] = $row['jam'];
    $nestedData[] = $row['nama'];
    $nestedData[] = rp($row['total']);
    $nestedData[] = $row['status_order'];
    $nestedData[] = $row['keterangan'];
    $nestedData[] = $row['id'];

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



    

