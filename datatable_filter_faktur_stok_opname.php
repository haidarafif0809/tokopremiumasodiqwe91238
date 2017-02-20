
<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$dari_tanggal = $_POST['dari_tanggal'];
$sampai_tanggal= $_POST['sampai_tanggal'];

$pilih_akses_stok_opname = $db->query("SELECT * FROM otoritas_stok_opname WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$stok_opname = mysqli_fetch_array($pilih_akses_stok_opname);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'id'
);

// getting total number records without any search
$sql ="SELECT * ";
$sql.=" FROM stok_opname WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql ="SELECT * ";
$sql.=" FROM stok_opname WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( no_faktur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR jam LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR tanggal_edit LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY tanggal ASC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

			
			//menampilkan data
			$nestedData[] = $row['no_faktur'];
			$nestedData[] = $row['tanggal'];
			$nestedData[] = $row['jam'];
			$nestedData[] = $row['status'];
			$nestedData[] = $row['keterangan'];
			$nestedData[] = rp($row['total_selisih']);
			
			$nestedData[] = $row['user'];

			$nestedData[] = "<button class='btn btn-info detail' no_faktur='". $row['no_faktur'] ."' ><span class='glyphicon glyphicon-th-list'></span> Detail </button>";

			if ($stok_opname['stok_opname_edit'] > 0) {
						$nestedData[] = "<a href='proses_edit_stok_opname.php?no_faktur=". $row['no_faktur']."&tanggal=". $row['tanggal']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a>";
			}

			if ($stok_opname['stok_opname_hapus'] > 0) {

			$pilih = $db->query("SELECT no_faktur FROM hpp_masuk WHERE no_faktur = '$row[no_faktur]' AND sisa != jumlah_kuantitas");
			$row_alert = mysqli_num_rows($pilih);

				
				if ($row_alert > 0) {

				$nestedData[] = "<button class='btn btn-danger btn-alert' data-id='". $row['id'] ."' data-faktur='". $row['no_faktur'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> ";
				} 

				else {

					$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."'  data-faktur='". $row['no_faktur'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>";
				}


							
			}
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