<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$session_id = session_id();
$order = angkadoang($_POST['order']);
$dari_tgl = stringdoang($_POST['dari_tanggal']);
$sampai_tgl = stringdoang($_POST['sampai_tanggal']);

$destroy = $db->query("DELETE FROM tbs_target_penjualan WHERE session_id = '$session_id' ");

$query22 = $db->query("SELECT dp.kode_barang, dp.nama_barang, dp.satuan, s.nama FROM detail_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id WHERE dp.tanggal >= '$dari_tgl' AND dp.tanggal <= '$sampai_tgl' GROUP BY dp.kode_barang ORDER BY SUM(dp.jumlah_barang) DESC ");
while ($data22 = mysqli_fetch_array($query22)) {

        $kode_barang = $data22['kode_barang'];
        $nama_barang = $data22['nama_barang'];
        $satuan = $data22['satuan'];




            $jumlah_periodesss = $db->query("SELECT SUM(jumlah_barang) AS jumlah_periode FROM detail_penjualan  WHERE kode_barang = '$data22[kode_barang]' AND tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' ");
            $data123 = mysqli_fetch_array($jumlah_periodesss);

            $select10 = $db->query("SELECT SUM(sisa) AS stok FROM hpp_masuk WHERE kode_barang = '$data22[kode_barang]'");
            $ambil_sisa10 = mysqli_fetch_array($select10);
            $sisa_stok = $ambil_sisa10['stok'];
            $jumlah_periode = $data123['jumlah_periode'];

            //hitung hari
            $datetime1 = new DateTime($dari_tgl);
            $datetime2 = new DateTime($sampai_tgl);
            $difference = $datetime1->diff($datetime2);
            $difference->days;

            // hitung jumlah rata2 perhari
            $jumlah_perhari = $data123['jumlah_periode'] / $difference->days;
            $jumlah_perhari = round($jumlah_perhari);
            // hitung stok habis(hari)s
            $proyeksi = round($jumlah_perhari) * $order;
            $kebutuhan = $proyeksi - $ambil_sisa10['stok'];

            if ($kebutuhan < 0) {
                $kebutuhan = 0;
            }


       $query2 ="INSERT INTO  tbs_target_penjualan(session_id, kode_barang, nama_barang, satuan, jumlah_periode, jual_perhari, target_perhari, proyeksi, 
        stok_terakhir, kebutuhan, dari_tgl, sampai_tgl, order_hari) 
VALUES ('$session_id', '$kode_barang', '$nama_barang', '$satuan', '$jumlah_periode', '$jumlah_perhari', '$jumlah_perhari','$proyeksi', '$sisa_stok', '$kebutuhan', '$dari_tgl', '$sampai_tgl', '$order')";

       if ($db->query($query2) === TRUE) {
       } else {
       echo "Error: " . $query2 . "<br>" . $db->error;
       }

                
}


$x = 0;

$requestData= $_REQUEST;

if ($requestData['start'] > 0) 
{   
$x = $x + $requestData['start'];

}
$columns = array( 
// datatable column index  => database column name

    0=>'kode_barang', 
    1=>'nama_barang',
    2=>'satuan',
    3=>'penjualan_periode',
    4=>'penjulan_perhari',
    5=>'target',
    6=>'proyeksi',
    7=>'stok',
    8=>'kebutuhan'


);


// getting total number records without any search
$sql = "SELECT dp.id,dp.jumlah_periode,dp.jual_perhari,dp.target_perhari,dp.proyeksi,dp.stok_terakhir,dp.kebutuhan,dp.kode_barang, dp.nama_barang, dp.satuan, s.nama ";
$sql.=" FROM tbs_target_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id ";
$sql.=" WHERE dp.session_id = '$session_id' GROUP BY dp.kode_barang";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql = "SELECT dp.id,dp.jumlah_periode,dp.jual_perhari,dp.target_perhari,dp.proyeksi,dp.stok_terakhir,dp.kebutuhan,dp.kode_barang, dp.nama_barang, dp.satuan, s.nama ";
$sql.=" FROM tbs_target_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id";
$sql.=" WHERE dp.session_id = '$session_id' ";

    $sql.=" AND (dp.kode_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%'  ";  
    $sql.=" OR dp.nama_barang LIKE '".$requestData['search']['value']."%' ) GROUP BY dp.kode_barang";  
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

 $sql.="  ORDER BY dp.jumlah_periode DESC LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {

    $nestedData=array(); 
             

            $x = $x + 1;

    $nestedData[] = $x .".";      
    $nestedData[] = $row["kode_barang"];
    $nestedData[] = $row["nama_barang"];
    $nestedData[] = $row["nama"];
    $nestedData[] = rp($row['jumlah_periode']);
    $nestedData[] = rp($row['jual_perhari']);
    $nestedData[] = "<p style='color:red' class='edit-target-jual' data-kode='".$row['id']."'>
    <span id='id-kode-".$row['id']."'>".rp($row['target_perhari'])."<span/></p>
    <input type='hidden' style='color:red' class='edit' id='id-target-".$row['id']."' autofocus='' value='".rp(round($row['target_perhari']))."' data-kode='".$row['id']."' data-order='".$order."'>";

    $nestedData[] = "<span id='proyeksi-".$row['id']."'>".rp($row['proyeksi'])."<span/>";

    $nestedData[] = "<span id='stok-".$row['id']."'>".rp($row['stok_terakhir'])."</span>";

    $nestedData[] = "<span id='kebutuhan-".$row['id']."'>".rp($row['kebutuhan'])."</span>";
                    


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