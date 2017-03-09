<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'kode',
	1 =>'nama',
	2 =>'satuan',
	3 =>'poin',
	4 =>'hapus',
	5 =>'id'
);


// getting total number records without any search
$sql = "SELECT mp.id,mp.kode_barang,mp.nama_barang,mp.quantity_poin,s.nama ";
$sql.=" FROM master_poin mp LEFT JOIN satuan s ON mp.satuan = s.id ";
$query=mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT mp.id,mp.kode_barang,mp.nama_barang,mp.quantity_poin,s.nama ";
$sql.=" FROM master_poin mp LEFT JOIN satuan s ON mp.satuan = s.id WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


	$sql.=" AND ( mp.kode_barang LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR mp.nama_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.= " ORDER BY mp.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

    	//menampilkan data
			$nestedData[] = $row['kode_barang'];
			$nestedData[] = $row['nama_barang'];
			$nestedData[] = $row['nama'];
			$nestedData[] = "<p class='edit-poin' data-id='".$row['id']."'><span id='id-poin-".$row['id']."'>".rp($row['quantity_poin'])."</span></p>
			<input type='hidden' data-id='".$row['id']."' data-poin='".$row['quantity_poin']."' data-kode='".$row['kode_barang']."' class='edit-qty-poin' id='input-poin-".$row['id']."' autofocus='' value='".$row['quantity_poin']."' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);'>";
				
				/*			include 'db.php';

			$pilih_akses_pelanggan_hapus = $db->query("SELECT pelanggan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pelanggan_hapus = '1'");
			$pelanggan_hapus = mysqli_num_rows($pilih_akses_pelanggan_hapus);


			    if ($pelanggan_hapus > 0){

					}*/	

			$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."' data-kode='". $row['kode_barang'] ."' data-nama='". $row['nama_barang'] ."'> <i class='fa fa-trash'> </i> Hapus </button>";
		
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

