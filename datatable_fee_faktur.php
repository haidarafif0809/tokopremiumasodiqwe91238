<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 => 'id',
	1=> 'kode_produk',
	2=> 'nama_produk',
	3=> 'jumlah_prosentase',
	4=> 'jumlah_uang',
	5=> 'user_buat',
	6=> 'nama'
);


// getting total number records without any search
$sql = "SELECT f.id,f.nama_petugas,f.jumlah_prosentase,f.jumlah_uang,f.user_buat,u.nama ";
$sql.="FROM fee_faktur f LEFT JOIN user u ON f.nama_petugas = u.id ";
$query=mysqli_query($conn, $sql) or die("datatable_fee_faktur.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT f.id,f.nama_petugas,f.jumlah_prosentase,f.jumlah_uang,f.user_buat,u.nama ";
$sql.="FROM fee_faktur f LEFT JOIN user u ON f.nama_petugas = u.id WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


	$sql.=" AND ( u.nama LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR f.kode_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR f.nama_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR f.jumlah_prosentase LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR f.jumlah_uang LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_fee_faktur.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY f.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

    	//menampilkan data
			$nestedData[] = $row['nama'];
			$nestedData[] = persen($row['jumlah_prosentase']);
			$nestedData[] = rp($row['jumlah_uang']);
			$nestedData[] = $row['user_buat'];


$pilih_akses_fee_fak_edit = $db->query("SELECT komisi_faktur_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND komisi_faktur_edit = '1'");
$fee_fak_edit = mysqli_num_rows($pilih_akses_fee_fak_edit);
    if ($fee_fak_edit > 0) { 	

			$nestedData[] = "<button class='btn btn-success btn-edit btn-sm' data-prosentase='". $row['jumlah_prosentase'] ."' data-nominal='". $row['jumlah_uang'] ."' data-id='". $row['id'] ."' > <span class='glyphicon glyphicon-edit'> </span> Edit </button>  </td>";
}



$pilih_akses_fee_faktur_hapus = $db->query("SELECT komisi_faktur_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND komisi_faktur_hapus = '1'");
$fee_faktur_hapus = mysqli_num_rows($pilih_akses_fee_faktur_hapus);

    if ($fee_faktur_hapus > 0) { 
			$nestedData[] = "<button class='btn btn-danger btn-hapus btn-sm' data-id='".$row['id']."' data-petugas='". $row['nama_petugas'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>";
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

