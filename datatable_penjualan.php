<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$status = stringdoang($_POST['status']);
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur', 
	1 => 'total',
    2 => 'kode_pelanggan',
    3 => 'tanggal',
    4 => 'tanggal_jt',
    5 => 'jam',
    6 => 'user',
    7 => 'sales',
    8 => 'kode_meja',
    9 => 'status',
    10 => 'potongan',
    11 => 'tax',
    12 => 'sisa',
    13 => 'kredit',
    14 => 'nama_gudang',
    15 => 'kode_gudang',
    16 => 'nama_pelanggan',
	17 => 'id'
);



if ($status == 'semua') {
// getting total number records without any search
$sql = "SELECT pl.kode_pelanggan AS code_card, p.id,p.no_faktur,p.total,p.kode_pelanggan,p.tanggal,p.tanggal_jt,p.jam,p.user,ser.nama AS sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,g.nama_gudang,p.kode_gudang,pl.nama_pelanggan ";
$sql.="FROM penjualan p LEFT JOIN gudang g ON p.kode_gudang = g.kode_gudang LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.id LEFT JOIN user ser ON p.sales = ser.id";
$query=mysqli_query($conn, $sql) or die("datatable_item_keluar.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
}
else{
	// getting total number records without any search
$sql = "SELECT pl.kode_pelanggan AS code_card, p.id,p.no_faktur,p.total,p.kode_pelanggan,p.tanggal,p.tanggal_jt,p.jam,p.user,ser.nama AS sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,g.nama_gudang,p.kode_gudang,pl.nama_pelanggan ";
$sql.="FROM penjualan p LEFT JOIN gudang g ON p.kode_gudang = g.kode_gudang LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.id LEFT JOIN user ser ON p.sales = ser.id WHERE p.status = '$status'";
$query=mysqli_query($conn, $sql) or die("datatable_item_keluar.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
}


if ($status == 'semua') {
// getting total number records without any search
$sql = "SELECT pl.kode_pelanggan AS code_card, p.id,p.no_faktur,p.total,p.kode_pelanggan,p.tanggal,p.tanggal_jt,p.jam,p.user,ser.nama AS sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,g.nama_gudang,p.kode_gudang,pl.nama_pelanggan ";
$sql.="FROM penjualan p LEFT JOIN gudang g ON p.kode_gudang = g.kode_gudang LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.id LEFT JOIN user ser ON p.sales = ser.id WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( p.no_faktur LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR pl.kode_pelanggan LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR g.nama_gudang LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR p.kode_meja LIKE '".$requestData['search']['value']."%' ";   
	$sql.=" OR pl.nama_pelanggan LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR p.jam LIKE '".$requestData['search']['value']."%' )";

	}
}
else{
// getting total number records without any search
$sql = "SELECT pl.kode_pelanggan AS code_card, p.id,p.no_faktur,p.total,p.kode_pelanggan,p.tanggal,p.tanggal_jt,p.jam,p.user,ser.nama AS sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,g.nama_gudang,p.kode_gudang,pl.nama_pelanggan ";
$sql.="FROM penjualan p INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.id INNER JOIN user ser ON p.sales = ser.id WHERE p.status = '$status'";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( p.no_faktur LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR pl.kode_pelanggan LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR g.nama_gudang LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR p.kode_meja LIKE '".$requestData['search']['value']."%' ";   
	$sql.=" OR pl.nama_pelanggan LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR p.jam LIKE '".$requestData['search']['value']."%' )";

	}
}
$query=mysqli_query($conn, $sql) or die("datatable_item_keluar.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

    	$pilih_akses_penjualan_edit = $db->query("SELECT penjualan_edit FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_edit = '1'");
$penjualan_edit = mysqli_num_rows($pilih_akses_penjualan_edit);


    if ($penjualan_edit > 0){

			$nestedData[] = "<a href='proses_edit_penjualan.php?no_faktur=". $row['no_faktur']."&kode_pelanggan=". $row['kode_pelanggan']."&nama_gudang=".$row['nama_gudang']."&kode_gudang=".$row['kode_gudang']."' class='btn btn-success'>Edit</a>";	


		}



$pilih_akses_penjualan_hapus = $db->query("SELECT penjualan_hapus FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_hapus = '1'");
$penjualan_hapus = mysqli_num_rows($pilih_akses_penjualan_hapus);


	if ($penjualan_hapus > 0){

$pilih = $db->query("SELECT no_faktur_penjualan FROM detail_retur_penjualan WHERE no_faktur_penjualan = '$row[no_faktur]'");
$row_retur = mysqli_num_rows($pilih);

$pilih = $db->query("SELECT no_faktur_penjualan FROM detail_pembayaran_piutang WHERE no_faktur_penjualan = '$row[no_faktur]'");
$row_piutang = mysqli_num_rows($pilih);

if ($row_retur > 0 || $row_piutang > 0) {

			$nestedData[] = "<button class='btn btn-danger btn-alert' data-id='".$row['id']."' data-faktur='".$row['no_faktur']."'>Hapus</button>";

} 

else {

			$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='".$row['id']."' data-pelanggan='".$row['nama_pelanggan']."' data-faktur='".$row['no_faktur']."' kode_meja='".$row['kode_meja']."'>Hapus</button>";
}




		}




if ($row['status'] == 'Lunas') {

	$nestedData[] ="<div class='dropdown'>
				<button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' style='width:150px'> Cetak Penjualan <span class='caret'></span></button>
				
				<ul class='dropdown-menu'>
				<li><a href='cetak_lap_penjualan_tunai.php?no_faktur=".$row['no_faktur']."' target='blank'> Cetak Penjualan </a></li> 
				<li><a href='cetak_lap_penjualan_tunai_besar.php?no_faktur=".$row['no_faktur']."' target='blank'> Cetak Penjualan Besar </a></li>
				</ul>
				</div>";
}

else{

	$nestedData[] = "";
}



if ($row['status'] == 'Piutang') {
	$nestedData[] = "<a href='cetak_lap_penjualan_piutang.php?no_faktur=".$row['no_faktur']."' id='cetak_piutang' class='btn btn-warning' target='blank'>Cetak Piutang</a>";
}

else{

	$nestedData[] = "";
	
}

			$nestedData[] = "<button class='btn btn-info detail' no_faktur='". $row['no_faktur'] ."' >Detail</button>";
			$nestedData[] = $row["no_faktur"];
			$nestedData[] = $row["nama_gudang"];
			

/*if ($row['status'] == 'Simpan Sementara') {
	$nestedData[] = "<a href='proses_pesanan_barang.php?no_faktur=".$row['no_faktur']."&kode_pelanggan=".$row['kode_pelanggan']."&nama_pelanggan=".$row['nama_pelanggan']."&nama_gudang=".$row['nama_gudang']."&kode_gudang=".$row['kode_gudang']."' class='btn btn-primary'>Bayar</a>";
}

else{

	$nestedData[] = "";
	
}*/
			$nestedData[] = $row["code_card"] ." - ". $row["nama_pelanggan"];
			$nestedData[] = koma($row["total"],2);
			$nestedData[] = $row["tanggal"];
			$nestedData[] = $row["tanggal_jt"];
			$nestedData[] = $row["jam"];
			$nestedData[] = $row["user"];
			$nestedData[] = $row["sales"];
			$nestedData[] = $row["status"];
			$nestedData[] = rp($row["potongan"]);
			$nestedData[] = rp($row["tax"]);
			$nestedData[] = rp($row["sisa"]);
			$nestedData[] = rp($row["kredit"]);
			
			

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

