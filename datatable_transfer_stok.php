<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'id'
);

// getting total number records without any search
$sql ="SELECT * ";
$sql.="FROM transfer_stok ";
$query=mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql ="SELECT * ";
$sql.="FROM transfer_stok where 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( no_faktur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR jam LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR tanggal_edit LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

			$pilih_akses_transfer_stok = $db->query("SELECT * FROM otoritas_transfer_stok WHERE id_otoritas = '$_SESSION[otoritas_id]'");
			$transfer_stok = mysqli_fetch_array($pilih_akses_transfer_stok);

			//menampilkan data
			$nestedData[] = $row['no_faktur'];
			$nestedData[] = $row['tanggal'];
			$nestedData[] = $row['jam'];
			$nestedData[] = $row['user'];
			$nestedData[] = $row['user_edit'];
			$nestedData[] = $row['tanggal_edit'];
			$nestedData[] = $row['keterangan'];
			$nestedData[] = rp($row['total']);


			$nestedData[] = "<button style='width:65px;' class='btn btn-info detail' no_faktur='". $row['no_faktur'] ."' ><i class='fa fa-th-list'></i> Detail </button>";

			if ($transfer_stok['transfer_stok_edit'] > 0) {
						 	$nestedData[] = "<a style='width:65px;' href='proses_edit_transfer_stok.php?no_faktur=". $row['no_faktur']."' class='btn btn-success'> 
						 	<i class='fa fa-edit'></i> Edit </a>";
						 }


			if ($transfer_stok['transfer_stok_hapus'] > 0) {// 

			$hpp_keluar = $db->query ("SELECT no_faktur FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$row[no_faktur]'");
			$row_hpp_keluar = mysqli_num_rows($hpp_keluar);

					
					if ($row_hpp_keluar > 0 ) 
					{// 	if ($row_hpp_keluar > 0 ) 					

						$nestedData[] = "<button style='width:65px;' class='btn btn-danger btn-alert' data-faktur='". $row['no_faktur'] ."'> <i class='fa fa-trash'> </i> Hapus </button>";

					} 

					else
					{

						$nestedData[] = "<button style='width:65px;' class='btn btn-danger btn-hapus' data-id='".$row['id']."' data-item='". $row['no_faktur'] ."'> <i class='fa fa-trash'> </i> Hapus </button>";			
		
					}
		}// 			if ($transfer_stok['transfer_stok_tambah'] > 0) {
		 
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
