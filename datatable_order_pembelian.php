<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

  $pilih_akses_tombol = $db->query("SELECT order_pembelian_edit, order_pembelian_hapus FROM otoritas_order_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
  $otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'cetak_order', 
  1 => 'detail',
  2 =>'cetak_order', 
	3 => 'detail',
	4 => 'suplier',
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
$sql = " SELECT po.keterangan,po.id,po.no_faktur_order,po.total,po.suplier,po.tanggal,po.jam,po.user,po.status_order,g.nama_gudang,po.kode_gudang,pl.nama ";
$sql.=" FROM pembelian_order po INNER JOIN gudang g ON po.kode_gudang = g.kode_gudang INNER JOIN suplier pl ON po.suplier = pl.id";
$query=mysqli_query($conn, $sql) or die("1.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT po.keterangan,po.id,po.no_faktur_order,po.total,po.suplier,po.tanggal,po.jam,po.user,po.status_order,g.nama_gudang,po.kode_gudang,pl.nama  ";
$sql.=" FROM pembelian_order po INNER JOIN gudang g ON po.kode_gudang = g.kode_gudang INNER JOIN suplier pl ON po.suplier = pl.id WHERE 1=1 ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( po.no_faktur_order LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR po.suplier LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR po.total LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR po.tanggal LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR po.kode_gudang LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR pl.nama LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("2.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY po.id DESC  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("3.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

if ($otoritas_tombol['order_pembelian_edit']) {
  if ($row['status_order'] == 'Di Order') {
    $nestedData[] = "<a href='proses_edit_pembelian_order.php?no_faktur=". $row['no_faktur_order']."&suplier=". $row['suplier']."&suplier=". $row['suplier']."&nama_gudang=".$row['nama_gudang']."&kode_gudang=".$row['kode_gudang']."' class='btn btn-sm btn-success'>Edit</a>"; 
  }
  else{
    $nestedData[] = "<p align='center'>x</p>";
  }
}

if ($otoritas_tombol['order_pembelian_hapus']) {
  if ($row['status_order'] == 'Di Order') {
    $nestedData[] = "<button class='btn btn-sm btn-danger btn-hapus' data-id='".$row['id']."' data-suplier='".$row['suplier']."' data-nama='".$row['nama']."' data-faktur='".$row['no_faktur_order']."' >Hapus</button>";
  }
  else{
    $nestedData[] = "<p align='center'>x</p>";
  }
}

    $nestedData[] = "<a href='cetak_pembelian_order.php?no_faktur=".$row['no_faktur_order']."' class='btn btn-sm btn-primary ' target='blank'> Cetak  </a>";

    $nestedData[] = "<button class='btn btn-sm btn-info detail' no_faktur='". $row['no_faktur_order'] ."' >Detail</button>";
    $nestedData[] = $row['no_faktur_order'];
    $nestedData[] = $row['suplier'] ." - ".$row['nama'];
    $nestedData[] = $row['kode_gudang'];
    $nestedData[] = $row['tanggal'];
    $nestedData[] = $row['jam'];
    $nestedData[] = $row['user'];
    $nestedData[] = rp($row['total']);
    if ($row['status_order'] == 'Di Order') {
      $nestedData[] = "<p style='color:blue;'>".$row['status_order']."</p>";
    }
    else{
      $nestedData[] = "<p style='color:red;'>".$row['status_order']."</p>";
    }
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