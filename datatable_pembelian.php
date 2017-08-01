<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur', 
	1 => 'total',
	2 => 'suplier',
	3=> 'tanggal',
	4=> 'tanggal_jt',
	5=> 'jam',
	6=> 'user',
	7=> 'status',
	8=> 'potongan',
	9=> 'tax',
	10=> 'sisa',
	11=> 'kredit',
	12=> 'nama',
	13=> 'nama_gudang',
	14=> 'kode_gudang',
	15=> 'id'
);


// getting total number records without any search
$sql = "SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,s.nama,g.nama_gudang, g.kode_gudang ";
$sql.="FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang ";
$query=mysqli_query($conn, $sql) or die("datatable_item_keluar.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,s.nama,g.nama_gudang, g.kode_gudang ";
$sql.="FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


	$sql.=" AND ( p.no_faktur LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR g.nama_gudang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR g.kode_gudang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' ";    
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
			$nestedData[] = "<button class='btn btn-info detail' no_faktur='". $row['no_faktur'] ."'> <span class='glyphicon glyphicon-th-list'></span> Detail </button>";

		

			$pilih_akses_pembelian_edit = $db->query("SELECT pembelian_edit FROM otoritas_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pembelian_edit = '1'");
			$pembelian_edit = mysqli_num_rows($pilih_akses_pembelian_edit);


			    if ($pembelian_edit > 0){
							$nestedData[] = "<a href='proses_edit_pembelian.php?no_faktur=". $row['no_faktur']."&suplier=". $row['suplier']."&nama_gudang=".$row['nama_gudang']."&kode_gudang=".$row['kode_gudang']."&nama_suplier=".$row['nama']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a>"; 
			}


			$pilih_akses_pembelian_hapus = $db->query("SELECT pembelian_hapus FROM otoritas_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pembelian_hapus = '1'");
			$pembelian_hapus = mysqli_num_rows($pilih_akses_pembelian_hapus);


			    if ($pembelian_hapus > 0){

			 $retur = $db->query ("SELECT no_faktur_pembelian FROM detail_retur_pembelian WHERE no_faktur_pembelian = '$row[no_faktur]'");
			 $row_retur = mysqli_num_rows($retur);


			 $hpp_keluar_penjualan = $db->query ("SELECT no_faktur FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$row[no_faktur]'");
			 $row_keluar = mysqli_num_rows($hpp_keluar_penjualan);

			 $hutang = $db->query ("SELECT no_faktur_pembelian FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$row[no_faktur]'");
			 $row_hutang = mysqli_num_rows($hutang);
					
					if ($row_retur > 0 || $row_keluar > 0 || $row_hutang > 0) {

						$nestedData[] = "<button class='btn btn-danger btn-alert' data-id='".$row['id']."' data-faktur='".$row['no_faktur']."'><span class='glyphicon glyphicon-trash'></span> Hapus  </button>"; 

					}
					else{

						$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='".$row['id']."' data-suplier='".$row['nama']."' data-faktur='".$row['no_faktur']."'><span class='glyphicon glyphicon-trash'></span> Hapus  </button>"; 

					} 
						
						}

						

						if ($row['status'] == 'Lunas') {

						$nestedData[] = "<a href='cetak_lap_pembelian_tunai.php?no_faktur=".$row['no_faktur']."&suplier=".$row['nama']."' id='cetak_tunai' class='btn btn-primary' target='blank'><span class='glyphicon glyphicon-print' > </span> Cetak </a>";
			}

			else{

				$nestedData[] = "";
				
			}

						
			if ($row['status'] == 'Hutang'){
				$nestedData[] = "<a href='cetak_lap_pembelian_hutang.php?no_faktur=".$row['no_faktur']."&suplier=".$row['nama']."' id='cetak_piutang' class='btn btn-primary' target='blank'><span class='glyphicon glyphicon-print' > </span> Cetak </a>";
			}

			else {

				$nestedData[] = "";
			}
						$nestedData[] = $row["no_faktur"];
						$nestedData[] = $row["nama_gudang"];
						$nestedData[] = $row["nama"];
						$nestedData[] = rp($row["total"]);
						$nestedData[] = $row["tanggal"];
						$nestedData[] = $row["tanggal_jt"];
						$nestedData[] = $row["jam"];
						$nestedData[] = $row["user"];
						$nestedData[] = $row["status"];
						$nestedData[] = rp($row["potongan"]);
						$nestedData[] = rp($row["tax"]);
						$nestedData[] = rp($row["sisa"]);
						$nestedData[] = rp($row["kredit"]);
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

