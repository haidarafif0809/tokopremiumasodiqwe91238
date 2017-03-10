<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name

	0 =>'detail', 
	1 =>'hapus', 
	2 =>'edit',
	3 =>'cetak', 
	4 =>'no_faktur', 
	5 => 'pelanggan',
	6 => 'poin_terakhir',
	7=> 'sisa_poin',
	8=> 'total_poin',
	9=> 'jam',
	10=> 'tanggal',
	11=> 'id'	

);

// getting total number records without any search
$sql = "SELECT tp.sisa_poin, tp.total_poin , p.nama_pelanggan, tp.no_faktur, tp.jam, tp.tanggal, tp.id, tp.poin_pelanggan_terakhir , tp.pelanggan, tp.user, p.kode_pelanggan , user_edit, date(waktu_edit) AS waktu_edit";
$sql.=" FROM tukar_poin tp LEFT JOIN pelanggan p ON tp.pelanggan = p.id ";
$query=mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



// getting total number records without any search

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql = "SELECT tp.sisa_poin, tp.total_poin , p.nama_pelanggan, tp.no_faktur, tp.jam, tp.tanggal, tp.id, tp.poin_pelanggan_terakhir , tp.pelanggan , tp.user, p.kode_pelanggan , date(waktu_edit) AS waktu_edit, user_edit";
$sql.=" FROM tukar_poin tp LEFT JOIN pelanggan p ON tp.pelanggan = p.id ";
$sql.= "WHERE 1=1 ";

	$sql.=" AND ( tp.no_faktur LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR p.nama_pelanggan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.kode_pelanggan LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR tp.tanggal LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR tp.user LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR tp.jam LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.= " ORDER BY tp.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("eeror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

    	//menampilkan data
			$nestedData[] = "<button style='width:65px;' class='btn btn-info detail' no_faktur='". $row['no_faktur'] ."'> <span class='fa fa-th-list'></span> Detail </button>";


$pilih_akses_tukar_poin_edit = $db->query("SELECT tukar_poin_edit FROM otoritas_tukar_poin WHERE id_otoritas = '$_SESSION[otoritas_id]' AND tukar_poin_edit = '1'");
$tukar_poin_edit = mysqli_num_rows($pilih_akses_tukar_poin_edit);

$pilih_akses_tukar_poin_hapus = $db->query("SELECT tukar_poin_hapus FROM otoritas_tukar_poin WHERE id_otoritas = '$_SESSION[otoritas_id]' AND tukar_poin_hapus = '1'");
$tukar_poin_hapus = mysqli_num_rows($pilih_akses_tukar_poin_hapus);


			if ($tukar_poin_edit > 0){
				$nestedData[] = "<a style='width:50px;' href='proses_edit_tukar_poin.php?no_faktur=". $row['no_faktur']."&pelanggan=". $row['pelanggan']."&tanggal=".$row['tanggal']."' 
				class='btn btn-success'> <i class='fa fa-edit'></i> Edit </a>"; 
			}

			    if ($tukar_poin_hapus > 0){


			$nestedData[] = "<button style='width:65px;' class='btn btn-danger btn-hapus' data-id='".$row['id']."' data-no_faktur='".$row['no_faktur']."'><i class='fa fa-trash'></i> Hapus  </button>"; 
			}


			$nestedData[] = "<a style='width:65px;' href='cetak_tukar_poin.php?no_faktur=".$row['no_faktur']."&tanggal=".$row['tanggal']."' id='cetak' class='btn btn-primary' target='blank'><i class='fa fa-print' > </i> Cetak </a>";
		


						$nestedData[] = $row["no_faktur"];
						$nestedData[] = $row["kode_pelanggan"]." || ".$row["nama_pelanggan"];
						$nestedData[] = rp($row["poin_pelanggan_terakhir"]);
						$nestedData[] = rp($row["sisa_poin"]);
						$nestedData[] = rp($row["total_poin"]);
						$nestedData[] = $row["user"];
						$nestedData[] = $row["user_edit"];
						$nestedData[] = $row["jam"];
						$nestedData[] = $row["tanggal"];
						$nestedData[] = $row["waktu_edit"];
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

