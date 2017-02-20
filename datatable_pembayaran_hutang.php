<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur_pembayaran', 
	1 => 'keterangan',
	2 => 'total',
	3=> 'nama_suplier',
	4=> 'tanggal',
	5=> 'tanggal_edit',
	6=> 'jam',
	7=> 'user_buat',
	8=> 'user_edit',
	9=> 'dari_kas',
	10=> 'nama',
	11=> 'nama_daftar_akun',
	12=> 'id'
);

// getting total number records without any search
$sql = "SELECT p.id,p.no_faktur_pembayaran,p.keterangan,p.total,p.nama_suplier,p.tanggal,p.tanggal_edit,p.jam,p.user_buat,p.user_edit,p.dari_kas,s.nama,da.nama_daftar_akun ";
$sql.="FROM pembayaran_hutang p INNER JOIN suplier s ON p.nama_suplier = s.id INNER JOIN daftar_akun da ON p.dari_kas = da.kode_daftar_akun ";
$query=mysqli_query($conn, $sql) or die("datatable_item_keluar.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT p.id,p.no_faktur_pembayaran,p.keterangan,p.total,p.nama_suplier,p.tanggal,p.tanggal_edit,p.jam,p.user_buat,p.user_edit,p.dari_kas,s.nama,da.nama_daftar_akun ";
$sql.="FROM pembayaran_hutang p INNER JOIN suplier s ON p.nama_suplier = s.id INNER JOIN daftar_akun da ON p.dari_kas = da.kode_daftar_akun WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( p.no_faktur_pembayaran LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR g.nama_gudang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR g.kode_gudang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR da.nama_daftar_akun LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.keterangan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR p.tanggal_edit LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR p.jam LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_item_keluar.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

    	//menampilkan data
		$nestedData[] = "<button class=' btn btn-info detail' no_faktur_pembayaran='". $row['no_faktur_pembayaran'] ."'> Detail  </button>";

		$pilih_akses_pembayaran_hutang = $db->query("SELECT * FROM otoritas_pembayaran WHERE id_otoritas = '$_SESSION[otoritas_id]'");
		$pembayaran_hutang = mysqli_fetch_array($pilih_akses_pembayaran_hutang);


		if ($pembayaran_hutang['pembayaran_hutang_edit'] > 0) {

				$nestedData[] = "<a href='proses_edit_pembayaran_hutang.php?no_faktur_pembayaran=". $row['no_faktur_pembayaran']."&nama=". $row['nama']."&cara_bayar=". $row['dari_kas']."' class='btn btn-success'> Edit  </a>";

			}



		if ($pembayaran_hutang['pembayaran_hutang_hapus'] > 0) {

					$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."' data-suplier='". $row['nama'] ."' data-no_faktur_pembayaran='". $row['no_faktur_pembayaran'] ."'> Hapus  </button>";
					} 

					$nestedData[] = "<a href='cetak_lap_pembayaran_hutang.php?no_faktur_pembayaran=".$row['no_faktur_pembayaran']."&nama_suplier=".$row['nama']."' class='btn btn-primary' target='blank'>Cetak Hutang  </a>";
						$nestedData[] = $row['no_faktur_pembayaran'];
						$nestedData[] = $row['tanggal'];
						$nestedData[] = $row['jam'];
						$nestedData[] = $row['nama'];
						$nestedData[] = $row['keterangan'];
						$nestedData[] = rp($row['total']);
						$nestedData[] = $row['user_buat'];
						$nestedData[] = $row['user_edit'];
						$nestedData[] = $row['tanggal_edit'];
						$nestedData[] = $row['nama_daftar_akun'];
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

