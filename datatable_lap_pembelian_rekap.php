<?php include 'session_login.php';

include 'db.php';
include 'sanitasi.php';

	$dari_tanggal = stringdoang($_POST['dari_tanggal']);
	$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

	$total_potongan = 0;
	$total_tax = 0;
	$total_beli = 0;
	$total_sisa = 0;
	$total_kredit = 0;

	$query_sum_total = $db->query("SELECT SUM(total) as total,SUM(potongan) as potongan ,SUM(tax) as tax,SUM(sisa) as sisa,SUM(kredit) as kredit FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
	$data_sum_total = mysqli_fetch_array($query_sum_total);
		
	$total_potongan = $total_potongan + $data_sum_total['potongan'];
	$total_tax = $total_tax + $data_sum_total['tax'];
	$total_beli = $total_beli + $data_sum_total['total'];
	$total_sisa = $total_sisa += $data_sum_total['sisa'];
	$total_kredit = $total_kredit + $data_sum_total['kredit'];

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'tanggal',
	 1=>'no_faktur',
	 2=>'total',
	 3=>'suplier',
	 4=>'tanggal',
	 5=>'tanggal_jt',
	 6=>'jam',
	 7=>'user',
	 8=>'status',
	 9=>'potongan',
	 10=>'tax',
	 11=>'sisa',
	 12=>'kredit',
	 13=>'nama',
	 14=>'id'
);

// getting total number records without any search
$sql ="SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,s.nama";
$sql.="FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql ="SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,s.nama";
$sql.="FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( p.no_faktur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.tanggal_jt LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.jam LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY p.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

				$nestedData[] = $row['no_faktur'];
				$nestedData[] = $row['nama'];
				$nestedData[] = $row['tanggal'];
				$nestedData[] = $row['jam'];
				$nestedData[] = $row['user'];
				$nestedData[] = $row['status'];
				$nestedData[] = rp($row['potongan']);
				$nestedData[] = rp($row['tax']);
				$nestedData[] = rp($row['total']);
				$nestedData[] = rp($row['sisa']);
				$nestedData[] = rp($row['kredit']);

				$data[] = $nestedData;
			}

			$nestedData=array(); 

				$nestedData[] = "<b style='color:red'>TOTAL</b>";
				$nestedData[] = "";
				$nestedData[] = "";
				$nestedData[] = "";
				$nestedData[] = "";
				$nestedData[] = "";
				$nestedData[] = "<b style='color:red'>".rp($total_potongan)."</b>";
				$nestedData[] = "<b style='color:red'>".rp($total_tax)."</b>";
				$nestedData[] = "<b style='color:red'>".rp($total_beli)."</b>";
				$nestedData[] = "<b style='color:red'>".rp($total_sisa)."</b>";
				$nestedData[] = "<b style='color:red'>".rp($total_kredit)."</b>";
				
			$data[] = $nestedData;

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>

