<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';
/* Database connection end */

$tipe = "barang_jasa";
$kategori  = "semua";

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;
$total_akhir_hpp = 0;
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



// getting total number records without any search
if ($tipe == 'barang') {
	if ($kategori == 'semua' AND $tipe = 'barang') {

		$sql = "SELECT s.id AS id_satuan,s.nama,b.id,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,b.kategori,b.gudang";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.berkaitan_dgn_stok = '$tipe' ";


	}

	else{
		$sql = "SELECT s.id AS id_satuan,s.nama,b.id,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,b.kategori,b.gudang";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.kategori = '$kategori' AND b.berkaitan_dgn_stok = '$tipe' ";
    }

}

else
{
	if ($kategori == 'semua') {
    	$sql = "SELECT s.id AS id_satuan,s.nama,b.id,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,b.kategori,b.gudang";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id";
    
    }
    
    else{
    	$sql = "SELECT s.id AS id_satuan,s.nama,b.id,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,b.kategori,b.gudang";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.kategori = '$kategori'";
    }
}
$query=mysqli_query($conn, $sql) or die("datatable_cari_barang.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if ($tipe == 'barang') {
	if ($kategori == 'semua' AND $tipe = 'barang') {

		$sql = "SELECT s.id AS id_satuan,s.nama,b.id,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,b.kategori,b.gudang";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE 1=1 AND b.berkaitan_dgn_stok = '$tipe' ";


	}

	else{
		$sql = "SELECT s.id AS id_satuan,s.nama,b.id,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,b.kategori,b.gudang";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id";
		$sql.="WHERE 1=1 AND b.kategori = '$kategori' AND b.berkaitan_dgn_stok = '$tipe' ";
    }

}

else
{
	if ($kategori == 'semua') {
    	$sql = "SELECT s.id AS id_satuan,s.nama,b.id,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,b.kategori,b.gudang";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id";
    
    }
    
    else{
    	$sql = "SELECT s.id AS id_satuan,s.nama,b.id,b.nama_barang,b.kode_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.id,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.berkaitan_dgn_stok,b.stok_barang,b.satuan,b.kategori,b.gudang";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE 1=1 AND b.kategori = '$kategori'";
    }
}

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( b.kode_barang LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR b.nama_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR b.kategori LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_cari_barang.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");



$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

		if ($row['berkaitan_dgn_stok'] == 'Jasa')
        {
            $f = 0;
        } 

        else
        {

        $a = $row['harga_beli'];
        $b = $row['harga_jual'];

          if ($b == '') {
              $f = 0;
          }
          else{
            $c = $b - $a;
            $d = $c;

            if ($d == 0 OR $b == 0) {
            	$f = 0;
            }
            else{

            	 //Gross Profit Margin itu rumusnya (harga jual-harga beli)/Harga jual x 100
            $e =  ($d / $b) * 100;

            $f = round($e,2);

            }
           
          }

        }

        $select_gudang = $db->query("SELECT nama_gudang FROM gudang WHERE kode_gudang = '$row[gudang]'");
            $ambil_gudang = mysqli_fetch_array($select_gudang);

            $select = $db->query("SELECT SUM(sisa) AS jumlah_barang FROM hpp_masuk WHERE kode_barang = '$row[kode_barang]'");
            $ambil_sisa = mysqli_fetch_array($select);

            $hpp_masuk = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE kode_barang = '$row[kode_barang]'");
            $cek_awal_masuk = mysqli_fetch_array($hpp_masuk);
            
            $hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE kode_barang = '$row[kode_barang]'");
            $cek_awal_keluar = mysqli_fetch_array($hpp_keluar);


            $total_hpp = $cek_awal_masuk['total_hpp'] - $cek_awal_keluar['total_hpp'];

        $total_akhir_hpp = $total_akhir_hpp + $total_hpp;

        //otoritas hapus
                $pilih_akses_barang_hapus = $db->query("SELECT item_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND item_hapus = '1'");
				$barang_hapus = mysqli_num_rows($pilih_akses_barang_hapus);
				

			    if ($barang_hapus > 0)  
			    {
			    	if ($ambil_sisa['jumlah_barang'] == '0' OR $ambil_sisa['jumlah_barang'] == '')
			    	{
			         
			             $nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."'  data-nama='". $row['nama_barang'] ."' data-kode='". $row['kode_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> ";
			        }
			        else
			        {
			            $nestedData[] = "can not be deleted";
			        }
			    }

			          

			    //otoritas edit
			    $pilih_akses_barang_edit = $db->query("SELECT item_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND item_edit = '1'");
				$barang_edit = mysqli_num_rows($pilih_akses_barang_edit);

			    if ($barang_edit > 0) {

			           if ($ambil_sisa['jumlah_barang'] == '0') 

			             {
			            $nestedData[] = "<a href='editbarang.php?id=". $row['id']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit</a>";
			            }
			    }

			    $pilih_akses_barang_edit = $db->query("SELECT item_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND item_edit = '1'");
				$barang_edit = mysqli_num_rows($pilih_akses_barang_edit);

			    if ($barang_edit > 0 AND $ambil_sisa['jumlah_barang'] != '0')
			            {

			            $nestedData[] = "<a href='editbarang.php?id=".$row['id']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit</a> ";
			            }

	$nestedData[] = $row["kode_barang"];
	$nestedData[] = $row["nama_barang"];

	$nestedData[] = "<p style='font-size:15px' align='right' class='edit-beli' data-id='".$row['id']."'> <span id='text-beli-".$row['id']."'>".rp($row["harga_beli"])."</span> <input type='hidden' id='input-beli-".$row['id']."' value='".$row['harga_beli']."' class='input_beli' data-id='".$row['id']."' data-kode='".$row['kode_barang']."' autofocus=''> </p>";




	$nestedData[] = persen($f);

	$nestedData[] = "<p style='font-size:15px' align='right' class='edit-jual' data-id='".$row['id']."'> <span id='text-jual-".$row['id']."'>".rp($row["harga_jual"])."</span> <input type='hidden' id='input-jual-".$row['id']."' value='".$row['harga_jual']."' class='input_jual' data-id='".$row['id']."' data-kode='".$row['kode_barang']."' autofocus=''> </p>";

	$nestedData[] = "<p style='font-size:15px' align='right' class='edit-jual-2' data-id-2='".$row['id']."'><span id='text-jual-2-".$row['id']."'>". rp($row['harga_jual2']) ."</span> <input type='hidden' id='input-jual-2-".$row['id']."' value='".$row['harga_jual2']."' class='input_jual_2' data-id-2='".$row['id']."' data-kode='".$row['kode_barang']."' autofocus=''></p>";

     $nestedData[] = "<p style='font-size:15px' align='right' class='edit-jual-3' data-id-3='".$row['id']."'><span id='text-jual-3-".$row['id']."'>". rp($row['harga_jual3']) ."</span> <input type='hidden' id='input-jual-3-".$row['id']."' value='".$row['harga_jual3']."' class='input_jual_3' data-id-3='".$row['id']."' data-kode='".$row['kode_barang']."' autofocus=''></p>";
	
	$nestedData[] = "<p style='font-size:15px' align='right' class='edit-jual-4' data-id-4='".$row['id']."'><span id='text-jual-4-".$row['id']."'>". rp($row['harga_jual4']) ."</span> <input type='hidden' id='input-jual-4-".$row['id']."' value='".$row['harga_jual4']."' class='input_jual_4' data-id-4='".$row['id']."' data-kode='".$row['kode_barang']."' autofocus=''></p>";
	$nestedData[] = "<p style='font-size:15px' align='right' class='edit-jual-5' data-id-5='".$row['id']."'><span id='text-jual-5-".$row['id']."'>". rp($row['harga_jual5']) ."</span> <input type='hidden' id='input-jual-5-".$row['id']."' value='".$row['harga_jual5']."' class='input_jual_5' data-id-5='".$row['id']."' data-kode='".$row['kode_barang']."' autofocus=''></p>";

	$nestedData[] = "<p style='font-size:15px' align='right' class='edit-jual-6' data-id-6='".$row['id']."'><span id='text-jual-6-".$row['id']."'>". rp($row['harga_jual6']) ."</span> <input type='hidden' id='input-jual-6-".$row['id']."' value='".$row['harga_jual6']."' class='input_jual_6' data-id-6='".$row['id']."' data-kode='".$row['kode_barang']."' autofocus=''></p>";

	$nestedData[] = "<p style='font-size:15px' align='right' class='edit-jual-7' data-id-7='".$row['id']."'><span id='text-jual-7-".$row['id']."'>". rp($row['harga_jual7']) ."</span> <input type='hidden' id='input-jual-7-".$row['id']."' value='".$row['harga_jual7']."' class='input_jual_7' data-id-7='".$row['id']."' data-kode='".$row['kode_barang']."' autofocus=''></p>";

	$nestedData[] = $total_hpp;

	if ($row['berkaitan_dgn_stok'] == 'Jasa') {

                $nestedData[] = "0";
            }
            else {
                $nestedData[] = $ambil_sisa['jumlah_barang'];
            }

	$nestedData[] = $row['nama'];


	$nestedData[] = "<a href='satuan_konversi.php?id=". $row['id']."&nama=". $row['nama']."&satuan=". $row['satuan']."&harga=". $row['harga_beli']."&kode_barang=". $row['kode_barang']."' class='btn btn-secondary'>Konversi</a> ";

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

