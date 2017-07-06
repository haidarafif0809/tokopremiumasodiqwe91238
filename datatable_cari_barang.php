<?php include 'session_login.php';

include 'db.php';
include 'sanitasi.php';
include 'persediaan.function.php';


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'kode_barang', 
	1 => 'nama_barang',
	2 => 'harga_beli',
	3 => 'harga_jual',
	4 => 'harga_jual2',
	5 => 'harga_jual3',
	6 => 'harga_jual4',
	7 => 'harga_jual5',
	8 => 'harga_jual6',
	9 => 'harga_jual7',
	10 => 'satuan',
	11 => 'tipe_barang',
	12 => 'kategori',
	13 => 'berkaitan_dgn_stok',
	14 => 'stok_barang',
	15 => 'gudang',
	16 => 'id_satuan'
);


$kategori = $requestData['kategori'];

if ($requestData['tipe'] == 'barang') {

	//menampilkan data produk yang tipe nya barang dan kategori nya semua
	if ($requestData['kategori'] == 'semua') {

		$sql = "SELECT COUNT(*) AS jumlah_data";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.berkaitan_dgn_stok = '$requestData[tipe]' ";


	}

	//menampilkan data produk yang tipe nya selain barang dan kategori nya selain semua

	else{
		$sql = "SELECT COUNT(*) AS jumlah_data";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.kategori = '$requestData[kategori]' AND b.berkaitan_dgn_stok = '$requestData[tipe]' ";
    }

}

else
{


	//menampilkan data produk yang tipe nya selain barang dan kategori nya semua
	if ($requestData['kategori']  == 'semua') {
    	$sql = "SELECT COUNT(*) AS jumlah_data";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id";
    
    }
    //menampilkan data produk yang tipe nya selain barang dan kategori nya semua
    else{
    	$sql = "SELECT COUNT(*) AS jumlah_data ";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.kategori = '$requestData[kategori]'";
    }
}
$query=mysqli_query($conn, $sql) or die("datatable_cari_barang.php: get employees");
$data_query = mysqli_fetch_array($query);
$totalData = $data_query['jumlah_data'];
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if ($requestData['tipe'] == 'barang') {
	if ($requestData['kategori']  == 'semua' AND $tipe = 'barang') {

		$sql = "SELECT s.id AS id_satuan,s.nama,b.id,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,kt.nama_kategori AS kategori ,b.gudang";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id LEFT JOIN kategori kt ON b.kategori = kt.id WHERE 1=1 AND b.berkaitan_dgn_stok = '$requestData[tipe]' ";


	}

	else{
		$sql = "SELECT s.id AS id_satuan,s.nama,b.id,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,kt.nama_kategori AS kategori ,b.gudang";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id LEFT JOIN kategori kt ON b.kategori = kt.id ";
		$sql.=" WHERE 1=1 AND b.kategori = '$kategori' AND b.berkaitan_dgn_stok = '$requestData[tipe]' ";
    }

}

else
{
	if ($requestData['kategori'] == 'semua') {
    	$sql = "SELECT s.id AS id_satuan,s.nama,b.id,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,kt.nama_kategori AS kategori,b.gudang";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id LEFT JOIN kategori kt ON b.kategori = kt.id ";
    
    }
    
    else{
    	$sql = "SELECT s.id AS id_satuan,s.nama,b.id,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,kt.nama_kategori AS kategori ,b.gudang";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id LEFT JOIN kategori kt ON b.kategori = kt.id WHERE 1=1 AND b.kategori = '$requestData[kategori]'";
    }
}

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( kode_barang = '".$requestData['search']['value']."' ";    
	$sql.=" OR nama_barang LIKE '".$requestData['search']['value']."%' )";

} 
$query=mysqli_query($conn, $sql) or die("datatable_cari_barang.php: query 1");

$totalFiltered = mysqli_num_rows($query); 

// when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: query 2");



$data = array();

// otoritas hapus dan edit

 $query_otoritas_item = $db->query("SELECT item_hapus, item_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
 $data_otoritas_item = mysqli_fetch_array($query_otoritas_item);
				



while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 


		// perhitungan margin 
		$margin = hitungMargin($row['harga_beli'],$row['harga_jual'],$row['berkaitan_dgn_stok']);
           
        $stok_barang = cekStokHpp($row['kode_barang']);

        $total_hpp = hitungNilaiHpp($row['kode_barang']);

        	//otoritas hapus
                

	if ($data_otoritas_item['item_hapus'] > 0 AND $stok_barang == '0')  {

		$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."'  data-nama='". $row['nama_barang'] ."' data-kode='". $row['kode_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> ";
			 

	}
	elseif ($data_otoritas_item['item_hapus'] > 0 AND $stok_barang != '0') {
	 	# code...

	 	$nestedData[] = "Tidak Bisa Di Hapus";
	 } 

			          

		//otoritas edit
			  
	if ($data_otoritas_item['item_edit'] > 0 ) {

			   $nestedData[] = "<a href='editbarang.php?id=". $row['id']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit</a>";
			 
		}
	
			 
	
	
	

	$nestedData[] = $row["kode_barang"];
	$nestedData[] = $row["nama_barang"];

	$nestedData[] = "<p style='font-size:15px' align='right' class='edit-beli' data-id='".$row['id']."'> 
	<span id='text-beli-".$row['id']."'>".rp($row["harga_beli"])."</span> <input type='hidden' id='input-beli-".$row['id']."' 
	value='".$row['harga_beli']."' class='input_beli' data-jual-1='".$row['harga_jual']."'  data-berstok='".$row['berkaitan_dgn_stok']."'  
	data-id='".$row['id']."' data-kode='".$row['kode_barang']."' autofocus=''> </p>";




	$nestedData[] = persen($margin);

	$nestedData[] = "<p style='font-size:15px' align='right' class='edit-jual' data-id='".$row['id']."'> 
	<span id='text-jual-".$row['id']."'>".rp($row["harga_jual"])."</span> 
	<input type='hidden' id='input-jual-".$row['id']."' value='".$row['harga_jual']."' class='input_jual' data-beli='".$row['harga_beli']."' 
	data-id='".$row['id']."' data-kode='".$row['kode_barang']."' autofocus=''> </p>";

	$nestedData[] = "<p style='font-size:15px' align='right' class='edit-jual-2' data-id-2='".$row['id']."'>
	<span id='text-jual-2-".$row['id']."'>". rp($row['harga_jual2']) ."</span> <input type='hidden' id='input-jual-2-".$row['id']."' 
	value='".$row['harga_jual2']."' class='input_jual_2' data-beli='".$row['harga_beli']."' data-id-2='".$row['id']."' 
	data-kode='".$row['kode_barang']."' autofocus=''></p>";

     $nestedData[] = "<p style='font-size:15px' align='right' class='edit-jual-3' data-id-3='".$row['id']."'>
     <span id='text-jual-3-".$row['id']."'>". rp($row['harga_jual3']) ."</span> <input type='hidden' id='input-jual-3-".$row['id']."' 
     value='".$row['harga_jual3']."' class='input_jual_3'  data-beli='".$row['harga_beli']."' data-id-3='".$row['id']."' 
     data-kode='".$row['kode_barang']."' autofocus=''></p>";
	
	$nestedData[] = "<p style='font-size:15px' align='right' class='edit-jual-4' data-id-4='".$row['id']."'>
	<span id='text-jual-4-".$row['id']."'>". rp($row['harga_jual4']) ."</span> <input type='hidden' id='input-jual-4-".$row['id']."' 
	value='".$row['harga_jual4']."' class='input_jual_4' data-beli='".$row['harga_beli']."'
	 data-id-4='".$row['id']."' data-kode='".$row['kode_barang']."' autofocus=''></p>";

	$nestedData[] = "<p style='font-size:15px' align='right' class='edit-jual-5' data-id-5='".$row['id']."'>
	<span id='text-jual-5-".$row['id']."'>". rp($row['harga_jual5']) ."</span> <input type='hidden' id='input-jual-5-".$row['id']."' 
	value='".$row['harga_jual5']."' class='input_jual_5' data-beli='".$row['harga_beli']."' data-id-5='".$row['id']."' 
	data-kode='".$row['kode_barang']."' autofocus=''></p>";

	$nestedData[] = "<p style='font-size:15px' align='right' class='edit-jual-6' data-id-6='".$row['id']."'>
	<span id='text-jual-6-".$row['id']."'>". rp($row['harga_jual6']) ."</span> <input type='hidden' id='input-jual-6-".$row['id']."' 
	value='".$row['harga_jual6']."' class='input_jual_6' data-beli='".$row['harga_beli']."' data-id-6='".$row['id']."' 
	data-kode='".$row['kode_barang']."' autofocus=''></p>";

	$nestedData[] = "<p style='font-size:15px' align='right' class='edit-jual-7' data-id-7='".$row['id']."'>
	<span id='text-jual-7-".$row['id']."'>". rp($row['harga_jual7']) ."</span> <input type='hidden' id='input-jual-7-".$row['id']."' 
	value='".$row['harga_jual7']."' class='input_jual_7' data-beli='".$row['harga_beli']."' data-id-7='".$row['id']."' 
	data-kode='".$row['kode_barang']."' autofocus=''></p>";

	$nestedData[] = koma($total_hpp,2);

	if ($row['berkaitan_dgn_stok'] == 'Jasa') {

       $nestedData[] = "0";
     }
     else {
        $nestedData[] = $stok_barang;
      }

	$nestedData[] = $row["nama"];

	//satuan konversi
	$nestedData[] = "<a href='satuan_konversi.php?id=". $row['id']."&nama=". $row['nama']."&satuan=". $row['satuan']."&harga=". $row['harga_beli']."&kode_barang=". $row['kode_barang']."' class='btn btn-secondary'>Konversi</a> </td>";

	$nestedData[] = $row["kategori"];
	
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

