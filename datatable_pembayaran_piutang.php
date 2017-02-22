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
	1 => 'tanggal',
	2 => 'jam',
	3=> 'nama_suplier',
	4=> 'keterangan',
	5=> 'total',
	6=> 'user_buat',
	7=> 'user_edit',
	8=> 'tanggal_edit',
	9=> 'dari_kas',
	10=> 'nama_pelanggan',
	11=> 'nama_daftar_akun',
	12=> 'id'
);

// getting total number records without any search
$sql = "SELECT p.id, p.no_faktur_pembayaran, p.tanggal, p.jam, p.nama_suplier, p.keterangan, p.total, p.user_buat, p.user_edit, p.tanggal_edit, p.dari_kas, pl.nama_pelanggan,pl.kode_pelanggan, da.nama_daftar_akun ";
$sql.="FROM pembayaran_piutang p INNER JOIN pelanggan pl ON p.nama_suplier = pl.kode_pelanggan INNER JOIN daftar_akun da ON p.dari_kas = da.kode_daftar_akun ";
$query=mysqli_query($conn, $sql) or die("datatable_item_keluar.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT p.id, p.no_faktur_pembayaran, p.tanggal, p.jam, p.nama_suplier, p.keterangan, p.total, p.user_buat, p.user_edit, p.tanggal_edit, p.dari_kas, pl.nama_pelanggan,pl.kode_pelanggan, da.nama_daftar_akun ";
$sql.="FROM pembayaran_piutang p INNER JOIN pelanggan pl ON p.nama_suplier = pl.kode_pelanggan INNER JOIN daftar_akun da ON p.dari_kas = da.kode_daftar_akun WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( p.no_faktur_pembayaran LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR pl.nama_pelanggan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR pl.kode_pelanggan LIKE '".$requestData['search']['value']."%' ";
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

    	$perintah5 = $db->query("SELECT * FROM detail_pembayaran_piutang");
				$data5 = mysqli_fetch_array($perintah5);

				//menampilkan data
			$nestedData[] = "<button class='btn btn-info detail' no_faktur_pembayaran='". $row['no_faktur_pembayaran'] ."' ><span class='glyphicon glyphicon-th-list'></span> Detail </button>"; 
			$pilih_akses_pembayaran_piutang = $db->query("SELECT * FROM otoritas_pembayaran WHERE id_otoritas = '$_SESSION[otoritas_id]'");
			$pembayaran_piutang = mysqli_fetch_array($pilih_akses_pembayaran_piutang);

			if ($pembayaran_piutang['pembayaran_piutang_edit'] > 0) {
						$nestedData[] = "<a href='proses_edit_pembayaran_piutang.php?no_faktur_pembayaran=". $row['no_faktur_pembayaran']."&no_faktur_penjualan=". $data5['no_faktur_penjualan']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a>";
					}

			if ($pembayaran_piutang['pembayaran_piutang_hapus'] > 0) {		

						$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."' data-suplier='". $row['nama_suplier'] ."' data-no-faktur='". $row['no_faktur_pembayaran'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>";
			}

					$nestedData[] = "<a href='cetak_lap_pembayaran_piutang.php?no_faktur_pembayaran=".$row['no_faktur_pembayaran']."'  class='btn btn-primary' target='blank'><span class='glyphicon glyphicon-print'> </span> Cetak Piutang </a>";

						$nestedData[] = $row['no_faktur_pembayaran'];
						$nestedData[] = $row['tanggal'];
						$nestedData[] = $row['jam'];
						$nestedData[] = $row['kode_pelanggan'] ." - ". $row["nama_pelanggan"];
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

