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
	2 =>'cetak', 
	3 =>'no_trx', 
	4 => 'keterangan',
	5 => 'order',
	6=> 'user',
	7=> 'tanggal',
	8=> 'jam',
	9=> 'id'

);

// getting total number records without any search
$sql = "SELECT no_trx,keterangan,order_hari,id , date(waktu) AS tanggal , time(waktu) AS jam ,dari_tgl, sampai_tgl, user";
$sql.=" FROM target_penjualan ";
$query=mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT no_trx,keterangan,order_hari,id , date(waktu) AS tanggal , time(waktu) AS jam ,dari_tgl, sampai_tgl, user";
$sql.=" FROM target_penjualan";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


	$sql.=" AND ( no_trx LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR keterangan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR order_hari LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR user LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR TIME(waktu) LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR DATE(waktu) LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.= " ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("eeror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

    	//menampilkan data
			$nestedData[] = "<button class='btn btn-info detail' no_trx='". $row['no_trx'] ."'> <span class='fa fa-th-list'></span> Detail </button>";

		
			/*
			 			$pilih_akses_pembelian_edit = $db->query("SELECT pembelian_edit FROM otoritas_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pembelian_edit = '1'");
			$pembelian_edit = mysqli_num_rows($pilih_akses_pembelian_edit);


			    if ($pembelian_edit > 0){
							$nestedData[] = "<a href='proses_edit_pembelian.php?no_faktur=". $row['no_faktur']."&suplier=". $row['suplier']."&nama_gudang=".$row['nama_gudang']."&kode_gudang=".$row['kode_gudang']."&nama_suplier=".$row['nama']."' class='btn btn-success'> <span class='fa fa-edit'></span> Edit </a>"; 
			}
			*/


			$pilih_akses_target_jual_hapus = $db->query("SELECT target_jual_hapus FROM otoritas_target_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND target_jual_hapus = '1'");
			$target_jual_hapus = mysqli_num_rows($pilih_akses_target_jual_hapus);


			    if ($target_jual_hapus > 0){


						$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='".$row['id']."' data-trx='".$row['no_trx']."'><span class='fa fa-trash'></span> Hapus  </button>"; 

			

			}


			$nestedData[] = "<a href='cetak_target_jual.php?no_trx=".$row['no_trx']."&daritgl=".$row['dari_tgl']."&sampai_tanggal=".$row['sampai_tgl']."&order=".$row['order_hari']."&keterangan=".$row['keterangan']."' id='cetak' class='btn btn-primary' target='blank'><span class='fa fa-print' > </span> Cetak </a>";
		
						
						$nestedData[] = $row["no_trx"];
						$nestedData[] = $row["keterangan"];
						$nestedData[] = rp($row["order_hari"]). " Hari";
						$nestedData[] = $row["user"];
						$nestedData[] = $row["tanggal"];
						$nestedData[] = $row["jam"];
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

