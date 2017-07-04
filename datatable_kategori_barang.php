<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 => 'id'
);


// getting total number records without any search
$sql = "SELECT * ";
$sql.="FROM kategori ";
$query=mysqli_query($conn, $sql) or die("datatable_kategori_barang.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT * ";
$sql.="FROM kategori WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


	$sql.=" AND ( nama_kategori LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_kategori_barang.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

    	//menampilkan data
			
				$nestedData[] = $row['nama_kategori'] ."</td>";


$pilih_akses_otoritas = $db->query("SELECT hak_otoritas_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_hapus = '1'");
$otoritas_hapus = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas_hapus > 0){

			$query_cek_kategori_barang = $db->query("SELECT kode_barang FROM barang WHERE kategori = '$row[nama_kategori]' ");
			$jumlah_cek_kategori_barang = mysqli_num_rows($query_cek_kategori_barang);

			 if ($jumlah_cek_kategori_barang == 0){

				$nestedData[] = "<button class='btn btn-danger btn-hapus btn-sm' data-id='". $row['id'] ."' data-kategori='". $row['nama_kategori'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";

			}
			else{
			$nestedData[] = "<p style='color:red;'>Sudah Terpakai</p>";
			}	

		}
		else{
			$nestedData[] = "<p></p>";
		}


$pilih_akses_otoritas = $db->query("SELECT hak_otoritas_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_edit = '1'");
$otoritas_edit = mysqli_num_rows($pilih_akses_otoritas);

if ($otoritas_edit > 0){

			$query_cek_kategori_barang = $db->query("SELECT kode_barang FROM barang WHERE kategori = '$row[nama_kategori]' ");
			$jumlah_cek_kategori_barang = mysqli_num_rows($query_cek_kategori_barang);

			 if ($jumlah_cek_kategori_barang == 0){

			$nestedData[] = "<button class='btn btn-warning btn-edit btn-sm' data-kategori='". $row['nama_kategori'] ."' data-id='". $row['id'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button>";

			}
			else{
			$nestedData[] = "<p style='color:red;'>Sudah Terpakai</p>";
			}	

		}
		else{
			$nestedData[] = "<p></p>";
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

