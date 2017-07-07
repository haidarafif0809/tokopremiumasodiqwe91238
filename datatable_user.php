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
$sql = "SELECT ho.nama AS otoritas_user,j.nama AS nama_jabatan ,u.id,u.username,u.nama,u.alamat,u.password,u.jabatan,u.otoritas,u.status,u.status_sales ";
$sql.="FROM user u LEFT JOIN jabatan j ON u.jabatan = j.id LEFT JOIN hak_otoritas ho ON u.otoritas=  ho.id ";
$query=mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT ho.nama AS otoritas_user,j.nama AS nama_jabatan ,u.id,u.username,u.nama,u.alamat,u.password,u.jabatan,u.otoritas,u.status,u.status_sales ";
$sql.="FROM user u LEFT JOIN jabatan j ON u.jabatan = j.id LEFT JOIN hak_otoritas ho ON u.otoritas = ho.id  WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


	$sql.=" AND ( u.username LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR u.nama LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR u.alamat LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY u.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

    	//menampilkan data
	$pilih_akses_user_hapus = $db->query("SELECT user_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND user_hapus = '1'");
$user_hapus = mysqli_num_rows($pilih_akses_user_hapus);


    if ($user_hapus > 0){
			$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."' data-user='". $row['username'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button>";

		}
$pilih_akses_user_edit = $db->query("SELECT user_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND user_edit = '1'");
$user_edit = mysqli_num_rows($pilih_akses_user_edit);


    if ($user_edit > 0){

			$nestedData[] = "<a href='edituser.php?id=". $row['id']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit </a>";
		}
			$nestedData[] = "<button class='btn btn-warning btn-reset' data-reset-id='". $row['id'] ."' data-reset-user='". $row['username'] ."'><span class='glyphicon glyphicon-refresh'> </span> Reset Password </button>";
			$nestedData[] = $row['username'];
			$nestedData[] = $row['password'];
			$nestedData[] = $row['nama'];
			$nestedData[] = $row['alamat'];
			$nestedData[] = $row['nama_jabatan'];
			$nestedData[] = $row['otoritas_user'];
			$nestedData[] = $row['status'];

      if ($row['status_sales'] == "Iya") {
        
        $nestedData[] = "<i class='fa fa-check'> </i>";
      }
      else{
         $nestedData[] = "<i class='fa fa-close'> </i>";
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

