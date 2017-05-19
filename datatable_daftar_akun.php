<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$kategori = stringdoang($_POST['kategori']);

  $pilih_akses_daftar_akun = $db->query("SELECT  daftar_akun_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
  $daftar_akun = mysqli_fetch_array($pilih_akses_daftar_akun);
  
  $pilih_akses_grup_akun = $db->query("SELECT  grup_akun_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
  $grup_akun = mysqli_fetch_array($pilih_akses_grup_akun);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kode_jasa',
    1=>'nama_jasa',
    2=>'harga',
    3=>'komisi',
    4=>'dokter',
    5=>'analis',
    6=>'tanggal',
    7=>'jam',
    8=>'hapus',
    9=>'id'


);

// getting total number records without any search
// GRUP AKUN (1)
if ($kategori == "semua") {
  $sql =" SELECT id, kode_grup_akun, nama_grup_akun, kategori_akun, tipe_akun, parent ";
  $sql.=" FROM grup_akun WHERE tipe_akun = 'Akun Header' AND parent= '-'";
}
else{
  $sql =" SELECT id, kode_grup_akun, nama_grup_akun, kategori_akun, tipe_akun, parent ";
  $sql.=" FROM grup_akun WHERE kategori_akun = '$kategori' AND tipe_akun = 'Akun Header' AND parent= '-'";
}

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
//GRUP AKUN (1)
if ($kategori == "semua") {
  $sql =" SELECT id, kode_grup_akun, nama_grup_akun, kategori_akun, tipe_akun, parent ";
  $sql.=" FROM grup_akun WHERE tipe_akun = 'Akun Header' AND parent= '-'";
}
else{
  $sql =" SELECT id, kode_grup_akun, nama_grup_akun, kategori_akun, tipe_akun, parent ";
  $sql.=" FROM grup_akun WHERE kategori_akun = '$kategori' AND tipe_akun = 'Akun Header' AND parent= '-'";
}
    $sql.=" AND (kode_grup_akun LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR nama_grup_akun LIKE '".$requestData['search']['value']."%' )";

    $query=mysqli_query($conn, $sql) or die("eror 2");

    $totalFiltered = mysqli_num_rows($query);

}


 // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY kode_grup_akun ASC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
//WHILE GRUP AKUN (1)
while( $row = mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData = array(); 
      $default = '-';

      $nestedData[] = "<b><p>".$row["kode_grup_akun"]."</p></b>";

      $nestedData[] = "<b><p class='edit-nama' data-id='".$row['id']."'><span id='text-nama-". $row['id'] ."'>". $row['nama_grup_akun'] ."</span>
      <input type='hidden' id='input-nama-".$row['id']."' value='".$row['nama_grup_akun']."' class='input_nama' data-id='".$row['id']."' autofocus=''></p></b>";

//TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)
      $kategori_akun = "<b><p class='edit-kategori' data-id='".$row['id']."'><span id='text-kategori-".$row['id']."'>". $row['kategori_akun'] ."</span>
      <select style='display:none' id='select-kategori-".$row['id']."' value='".$row['kategori_akun']."' class='select-kategori' data-id='".$row['id']."' autofocus=''>";

      $kategori_akun .= "
          <option selected> ". $row['kategori_akun'] ."</option>
          <option>Aktiva</option>  
          <option>Kewajiban</option>  
          <option>Modal</option>  
          <option>Pendapatan</option>  
          <option>HPP</option>  
          <option>Biaya</option>
          <option>Pendapatan Lain</option>  
          <option>Biaya Lain</option>
      </select>";

      $nestedData[] = "<b><p>".$kategori_akun."</p></b>";
//TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)

//TAMPIL PARENT (KOLOM SUB AKUN)      
      $parent = "<b><p Class='edit-parent' data-id='".$row['id']."'><span id='text-parent-".$row['id']."'>". $row['parent'] ."</span>
      <select style='display:none' id='select-parent-".$row['id']."' value='".$row['parent']."' class='select-parent' data-id='".$row['id']."' autofocus=''>
      <option>".$default."</option>";      

      $query_kode_grup = $db->query("SELECT kode_grup_akun FROM grup_akun");
      while($data_kode_grup = mysqli_fetch_array($query_kode_grup))
      {
        if ($data_kode_grup['kode_grup_akun'] == $row['parent']) {          
            $parent .= "<option selected>".$data_kode_grup["kode_grup_akun"] ."</option>";
        }
        else{
            $parent .= "<option>".$data_kode_grup["kode_grup_akun"] ."</option>";
        }
      }

      $parent .= "</select></p></b>";

      $nestedData[] = "<b><p>".$parent."</p></b>";
//TAMPIL PARENT (KOLOM SUB AKUN) 

//TAMPIL TIPE AKUN (KOLOM TIPE AKUN)
      $tipe_akun = "<b><p class='edit-tipe' data-id='".$row['id']."'><span id='text-tipe-".$row['id']."'>". $row['tipe_akun'] ."</span>
      <select style='display:none' id='select-tipe-".$row['id']."' value='".$row['tipe_akun']."' class='select-tipe' data-id='".$row['id']."' autofocus=''>";

      $tipe_akun .= "
          <option selected> ". $row['tipe_akun'] ."</option>
          <option>Akun Header</option>  
          <option>Kas & Bank</option> 
          <option>Piutang Dagang</option> 
          <option>Piutang Non Dagang</option> 
          <option>Persediaan</option> 
          <option>Investasi Portofolio</option> 
          <option>Pajak Dibayar Dimuka</option> 
          <option>Beban Bayar Dimuka</option> 
          <option>Aktiva Tetap</option> 
          <option>Akumulasi Penyusutan</option> 
          <option>Hutang Dagang</option>  
          <option>Pendapatan Diterima Dimuka</option> 
          <option>Beban YMH Dibayar</option>  
          <option>Hutang Pajak</option> 
          <option>Hutang Bank Jangka Pendek</option>  
          <option>Hutang Bukan Bank Jangka Pendek</option>  
          <option>Hutang Non Dagang</option>  
          <option>Ekuitas</option>
          <option>Pendapatan Penjualan</option>   
          <option>Pendapatan Diluar Usaha</option>  
          <option>Harga Pokok Penjualan</option>  
          <option>Beban Administrasi dan Umum</option>
          <option>Beban Penjualan</option>
          <option>Beban Pemansaran</option>
          <option>Beban Operasional</option>
          <option>Beban Diluar Usaha</option>
          <option>Bunga Pinjaman</option>
          <option>Hutang Bank Jangka Panjang</option>
          <option>Hutang Bukan Bank Jangka Panjang</option>
          <option>Deviden</option>
          <option>Beban Pajak Penghasilan</option>
      </select>";

      $nestedData[] = "<b><p>".$tipe_akun."</p></b>";
//TAMPIL TIPE AKUN (KOLOM TIPE AKUN)

// TOMBOL HAPUS
  if ($grup_akun['grup_akun_hapus'] > 0) {

      $nestedData[] = "<button class='btn btn-floating btn-danger btn-hapus' data-id='". $row['id'] ."' data-akun='". $row['nama_grup_akun'] ."' kode-akun='". $row['kode_grup_akun'] ."'> <i class='fa fa-trash'> </i> Hapus </button>";
    }
    else{
      $nestedData[] = "";
    }
// TOMBOL HAPUS 

  $data[] = $nestedData;

  //SELECT DAFTAR AKUN IF
        $query_daftar_akun = $db->query("SELECT grup_akun FROM daftar_akun WHERE kategori_akun = '$kategori' AND grup_akun= '$row[kode_grup_akun]'");
        $data_daftar_akun = mysqli_fetch_array($query_daftar_akun);
    
    //JIKA GRUP AKUN TIDAK SAMA DENGAN GRUP AKUN DI DAFTAR AKUN
      if ($data_daftar_akun['grup_akun'] != $row['kode_grup_akun']) {
      //(**NOTE)
      //JIKA TIDAK ADA DAFTAR AKUN YANG LANGSUNG TERHUBUNG KE GRUP AKUN HEADER, MAKSUDNYA DAFTAR AKUN TIDAK TERHUBUNG LANGSUNG KE AKUN GRUP AKUN TERATAS< MELAINKAN TERHUBUNG KE SUB HEADER SUB HEADER DARI AKUN TERATAS.
      //(**NOTE)
      //JIKA TIDAK ADA DAFTAR AKUN YANG LANGSUNG TERHUBUNG KE GRUP AKUN HEADER, MAKSUDNYA DAFTAR AKUN TIDAK TERHUBUNG LANGSUNG KE AKUN GRUP AKUN TERATAS< MELAINKAN TERHUBUNG KE SUB HEADER SUB HEADER DARI AKUN TERATAS.


          //SELECT GRUP AKUN - SUB AKUN -> GRUP AKUN (1) DIATAS
          //GRUP AKUN (2)
            $query_grup_akun = $db->query("SELECT id, kode_grup_akun, nama_grup_akun, kategori_akun, tipe_akun, parent FROM grup_akun WHERE kategori_akun = '$kategori' AND tipe_akun = 'Akun Header' AND parent= '$row[kode_grup_akun]' ");
            while ($data_grup_akun = mysqli_fetch_array($query_grup_akun)){
                $nestedData = array(); 

                  $nestedData[] = "<b><p>".$data_grup_akun["kode_grup_akun"]."</p></b>";

                  $nestedData[] = "<b><p class='padding-25 edit-nama' data-id='".$data_grup_akun['id']."'><span id='text-nama-". $data_grup_akun['id'] ."'>". $data_grup_akun['nama_grup_akun'] ."</span>
                  <input type='hidden' id='input-nama-".$data_grup_akun['id']."' value='".$data_grup_akun['nama_grup_akun']."' class='input_nama' data-id='".$data_grup_akun['id']."' autofocus=''></p></b>";

            //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)
                  $kategori_akun = "<b><p class='edit-kategori' data-id='".$data_grup_akun['id']."'><span id='text-kategori-".$data_grup_akun['id']."'>". $data_grup_akun['kategori_akun'] ."</span>
                  <select style='display:none' id='select-kategori-".$data_grup_akun['id']."' value='".$data_grup_akun['kategori_akun']."' class='select-kategori' data-id='".$data_grup_akun['id']."' autofocus=''>";

                  $kategori_akun .= "
                      <option selected> ". $data_grup_akun['kategori_akun'] ."</option>
                      <option>Aktiva</option>  
                      <option>Kewajiban</option>  
                      <option>Modal</option>  
                      <option>Pendapatan</option>  
                      <option>HPP</option>  
                      <option>Biaya</option>
                      <option>Pendapatan Lain</option>  
                      <option>Biaya Lain</option>
                  </select>";

                  $nestedData[] = "<b><p>".$kategori_akun."</p></b>";
            //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)

            //TAMPIL PARENT (KOLOM SUB AKUN)
                  $parent = "<b><p Class='edit-parent' data-id='".$data_grup_akun['id']."'><span id='text-parent-".$data_grup_akun['id']."'>". $data_grup_akun['parent'] ."</span>
                    <select style='display:none' id='select-parent-".$data_grup_akun['id']."' value='".$data_grup_akun['parent']."' class='select-parent' data-id='".$data_grup_akun['id']."' autofocus=''>";      

                    $query_kode_grup = $db->query("SELECT kode_grup_akun FROM grup_akun");
                    while($data_kode_grup = mysqli_fetch_array($query_kode_grup))
                    {
                      if ($data_kode_grup['kode_grup_akun'] == $data_grup_akun['parent']) {          
                          $parent .= "<option selected>".$data_kode_grup["kode_grup_akun"] ."</option>";
                      }
                      else{
                          $parent .= "<option>".$data_kode_grup["kode_grup_akun"] ."</option>";
                      }
                    }

                    $parent .= "</select></p></b>";

                  $nestedData[] = "<b><p>".$parent."</p></b>";
            //TAMPIL PARENT (KOLOM SUB AKUN)
            
            //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)
                  $tipe_akun = "<b><p class='edit-tipe' data-id='".$data_grup_akun['id']."'><span id='text-tipe-".$data_grup_akun['id']."'>". $data_grup_akun['tipe_akun'] ."</span>
                  <select style='display:none' id='select-tipe-".$data_grup_akun['id']."' value='".$data_grup_akun['tipe_akun']."' class='select-tipe' data-id='".$data_grup_akun['id']."' autofocus=''>";

                  $tipe_akun .= "
                      <option selected> ". $data_grup_akun['tipe_akun'] ."</option>
                      <option>Akun Header</option>  
                      <option>Kas & Bank</option> 
                      <option>Piutang Dagang</option> 
                      <option>Piutang Non Dagang</option> 
                      <option>Persediaan</option> 
                      <option>Investasi Portofolio</option> 
                      <option>Pajak Dibayar Dimuka</option> 
                      <option>Beban Bayar Dimuka</option> 
                      <option>Aktiva Tetap</option> 
                      <option>Akumulasi Penyusutan</option> 
                      <option>Hutang Dagang</option>  
                      <option>Pendapatan Diterima Dimuka</option> 
                      <option>Beban YMH Dibayar</option>  
                      <option>Hutang Pajak</option> 
                      <option>Hutang Bank Jangka Pendek</option>  
                      <option>Hutang Bukan Bank Jangka Pendek</option>  
                      <option>Hutang Non Dagang</option>  
                      <option>Ekuitas</option>
                      <option>Pendapatan Penjualan</option>   
                      <option>Pendapatan Diluar Usaha</option>  
                      <option>Harga Pokok Penjualan</option>  
                      <option>Beban Administrasi dan Umum</option>
                      <option>Beban Penjualan</option>
                      <option>Beban Pemansaran</option>
                      <option>Beban Operasional</option>
                      <option>Beban Diluar Usaha</option>
                      <option>Bunga Pinjaman</option>
                      <option>Hutang Bank Jangka Panjang</option>
                      <option>Hutang Bukan Bank Jangka Panjang</option>
                      <option>Deviden</option>
                      <option>Beban Pajak Penghasilan</option>
                  </select>";

                  $nestedData[] = "<b><p>".$tipe_akun."</p></b>";
            //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)

            // TOMBOL HAPUS 
              if ($grup_akun['grup_akun_hapus'] > 0) {

                  $nestedData[] = "<button class='btn btn-floating btn-danger btn-hapus' data-id='". $data_grup_akun['id'] ."' data-akun='". $data_grup_akun['nama_grup_akun'] ."' kode-akun='". $data_grup_akun['kode_grup_akun'] ."'> <i class='fa fa-trash'> </i> Hapus </button>";
                }
              else{
                $nestedData[] = "";
              }
            // TOMBOL HAPUS 

                $data[] = $nestedData;

    //SELECT DAFTAR AKUN (1)
                $query_daftar_akun = $db->query("SELECT grup_akun FROM daftar_akun WHERE kategori_akun = '$kategori' AND grup_akun= '$data_grup_akun[kode_grup_akun]'");
                $data_daftar_akun = mysqli_fetch_array($query_daftar_akun);

    //JIKA GRUP AKUN TIDAK SAMA DENGAN GRUP AKUN DI DAFTAR AKUN
                if ($data_daftar_akun['grup_akun'] != $data_grup_akun['kode_grup_akun']) {
    
    //SELECT GRUP AKUN - SUB AKUN -> GRUP AKUN (2) DIATAS
                  //GRUP AKUN (3)
                  $query_grup_akun_sub = $db->query("SELECT id, kode_grup_akun, nama_grup_akun, kategori_akun, tipe_akun, parent FROM grup_akun WHERE kategori_akun = '$kategori' AND tipe_akun = 'Akun Header' AND parent= '$data_grup_akun[kode_grup_akun]' ");
                  while ($data_grup_akun_sub = mysqli_fetch_array($query_grup_akun_sub)){

                          $nestedData = array(); 

                            $nestedData[] = "<b><p>".$data_grup_akun_sub["kode_grup_akun"]."</p></b>";
                            
                            $nestedData[] = "<b><p class='padding-50 edit-nama' data-id='".$data_grup_akun_sub['id']."'><span id='text-nama-". $data_grup_akun_sub['id'] ."'>". $data_grup_akun_sub['nama_grup_akun'] ."</span><input type='hidden' id='input-nama-".$data_grup_akun_sub['id']."' value='".$data_grup_akun_sub['nama_grup_akun']."' class='input_nama' data-id='".$data_grup_akun_sub['id']."' autofocus=''></p></b>";
                            
                      //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)
                            $kategori_akun = "<b><p class='edit-kategori' data-id='".$data_grup_akun_sub['id']."'><span id='text-kategori-".$data_grup_akun_sub['id']."'>". $data_grup_akun_sub['kategori_akun'] ."</span>
                            <select style='display:none' id='select-kategori-".$data_grup_akun_sub['id']."' value='".$data_grup_akun_sub['kategori_akun']."' class='select-kategori' data-id='".$data_grup_akun_sub['id']."' autofocus=''>";

                            $kategori_akun .= "
                                <option selected> ". $data_grup_akun_sub['kategori_akun'] ."</option>
                                <option>Aktiva</option>  
                                <option>Kewajiban</option>  
                                <option>Modal</option>  
                                <option>Pendapatan</option>  
                                <option>HPP</option>  
                                <option>Biaya</option>
                                <option>Pendapatan Lain</option>  
                                <option>Biaya Lain</option>
                            </select>";

                            $nestedData[] = "<b><p>".$kategori_akun."</p></b>";
                      //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)

                      //TAMPIL PARENT (KOLOM SUB AKUN)
                            $parent = "<b><p Class='edit-parent' data-id='".$data_grup_akun_sub['id']."'><span id='text-parent-".$data_grup_akun_sub['id']."'>". $data_grup_akun_sub['parent'] ."</span>
                              <select style='display:none' id='select-parent-".$data_grup_akun_sub['id']."' value='".$data_grup_akun_sub['parent']."' class='select-parent' data-id='".$data_grup_akun_sub['id']."' autofocus=''>";      

                              $query_kode_grup = $db->query("SELECT kode_grup_akun FROM grup_akun");
                              while($data_kode_grup = mysqli_fetch_array($query_kode_grup))
                              {
                                if ($data_kode_grup['kode_grup_akun'] == $data_grup_akun_sub['parent']) {          
                                    $parent .= "<option selected>".$data_kode_grup["kode_grup_akun"] ."</option>";
                                }
                                else{
                                    $parent .= "<option>".$data_kode_grup["kode_grup_akun"] ."</option>";
                                }
                              }

                              $parent .= "</select></p></b>";

                            $nestedData[] = "<b><p>".$parent."</p></b>";
                      //TAMPIL PARENT (KOLOM SUB AKUN)
                      
                      //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)
                            $tipe_akun = "<b><p class='edit-tipe' data-id='".$data_grup_akun_sub['id']."'><span id='text-tipe-".$data_grup_akun_sub['id']."'>". $data_grup_akun_sub['tipe_akun'] ."</span>
                            <select style='display:none' id='select-tipe-".$data_grup_akun_sub['id']."' value='".$data_grup_akun_sub['tipe_akun']."' class='select-tipe' data-id='".$data_grup_akun_sub['id']."' autofocus=''>";

                            $tipe_akun .= "
                                <option selected> ". $data_grup_akun_sub['tipe_akun'] ."</option>
                                <option>Akun Header</option>  
                                <option>Kas & Bank</option> 
                                <option>Piutang Dagang</option> 
                                <option>Piutang Non Dagang</option> 
                                <option>Persediaan</option> 
                                <option>Investasi Portofolio</option> 
                                <option>Pajak Dibayar Dimuka</option> 
                                <option>Beban Bayar Dimuka</option> 
                                <option>Aktiva Tetap</option> 
                                <option>Akumulasi Penyusutan</option> 
                                <option>Hutang Dagang</option>  
                                <option>Pendapatan Diterima Dimuka</option> 
                                <option>Beban YMH Dibayar</option>  
                                <option>Hutang Pajak</option> 
                                <option>Hutang Bank Jangka Pendek</option>  
                                <option>Hutang Bukan Bank Jangka Pendek</option>  
                                <option>Hutang Non Dagang</option>  
                                <option>Ekuitas</option>
                                <option>Pendapatan Penjualan</option>   
                                <option>Pendapatan Diluar Usaha</option>  
                                <option>Harga Pokok Penjualan</option>  
                                <option>Beban Administrasi dan Umum</option>
                                <option>Beban Penjualan</option>
                                <option>Beban Pemansaran</option>
                                <option>Beban Operasional</option>
                                <option>Beban Diluar Usaha</option>
                                <option>Bunga Pinjaman</option>
                                <option>Hutang Bank Jangka Panjang</option>
                                <option>Hutang Bukan Bank Jangka Panjang</option>
                                <option>Deviden</option>
                                <option>Beban Pajak Penghasilan</option>
                            </select>";

                            $nestedData[] = "<b><p>".$tipe_akun."</p></b>";
                      //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)

                      // TOMBOL HAPUS 
                        if ($grup_akun['grup_akun_hapus'] > 0) {

                            $nestedData[] = "<button class='btn btn-floating btn-danger btn-hapus' data-id='". $data_grup_akun_sub['id'] ."' data-akun='". $data_grup_akun_sub['nama_grup_akun'] ."' kode-akun='". $data_grup_akun_sub['kode_grup_akun'] ."'> <i class='fa fa-trash'> </i> Hapus </button>";
                          }
                        else{
                          $nestedData[] = "";
                        }
                      // TOMBOL HAPUS 
            
                          $data[] = $nestedData;

    //SELECT DAFTAR AKUN JIKA GRUP AKUN TIDAK SAMA DENGAN ( != ) GRUP AKUN DI DAFTAR AKUN
                              $query_daftar_akun_if = $db->query("SELECT id, kode_daftar_akun, nama_daftar_akun, grup_akun, kategori_akun, tipe_akun FROM daftar_akun WHERE kategori_akun = '$kategori' AND grup_akun= '$data_grup_akun_sub[kode_grup_akun]'");
                              while ($data_daftar_akun_if = mysqli_fetch_array($query_daftar_akun_if)){

                                    $nestedData = array(); 

                                      $nestedData[] = "<p>".$data_daftar_akun_if["kode_daftar_akun"]."</p>";

                                      $nestedData[] = "<p class='padding-75 edit-nama' data-id='".$data_daftar_akun_if['id']."'><span id='text-nama-". $data_daftar_akun_if['id'] ."'>". $data_daftar_akun_if['nama_daftar_akun'] ."</span><input type='hidden' id='input-nama-".$data_daftar_akun_if['id']."' value='".$data_daftar_akun_if['nama_daftar_akun']."' class='input_nama_akun' data-id='".$data_daftar_akun_if['id']."' autofocus=''></p>";
            
                                  //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)
                                        $kategori_akun = "<p class='edit-kategori-akun' data-id='".$data_daftar_akun_if['id']."'><span id='text-kategori-".$data_daftar_akun_if['id']."'>". $data_daftar_akun_if['kategori_akun'] ."</span>
                                        <select style='display:none' id='select-kategori-".$data_daftar_akun_if['id']."' value='".$data_daftar_akun_if['kategori_akun']."' class='select-kategori-akun' data-id='".$data_daftar_akun_if['id']."' autofocus=''>";

                                        $kategori_akun .= "
                                            <option selected> ". $data_daftar_akun_if['kategori_akun'] ."</option>
                                            <option>Aktiva</option>  
                                            <option>Kewajiban</option>  
                                            <option>Modal</option>  
                                            <option>Pendapatan</option>  
                                            <option>HPP</option>  
                                            <option>Biaya</option>
                                            <option>Pendapatan Lain</option>  
                                            <option>Biaya Lain</option>
                                        </select>";

                                        $nestedData[] = "<p>".$kategori_akun."</p>";
                                  //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)

                                  //TAMPIL PARENT (KOLOM SUB AKUN)
                                        $parent = "<p Class='edit-parent' data-id='".$data_daftar_akun_if['id']."'><span id='text-parent-".$data_daftar_akun_if['id']."'>". $data_daftar_akun_if['grup_akun'] ."</span>
                                        <select style='display:none' id='select-parent-".$data_daftar_akun_if['id']."' value='".$data_daftar_akun_if['grup_akun']."' class='select-parent-akun' data-id='".$data_daftar_akun_if['id']."' autofocus=''>";      

                                        $query_kode_grup = $db->query("SELECT kode_grup_akun FROM grup_akun");
                                        while($data_kode_grup = mysqli_fetch_array($query_kode_grup))
                                        {
                                          if ($data_kode_grup['kode_grup_akun'] == $data_daftar_akun_if['grup_akun']) {          
                                              $parent .= "<option selected>".$data_kode_grup["kode_grup_akun"] ."</option>";
                                          }
                                          else{
                                              $parent .= "<option>".$data_kode_grup["kode_grup_akun"] ."</option>";
                                          }
                                        }

                                        $parent .= "</select></p>";

                                      $nestedData[] = "<p>".$parent."</p>";
                                  //TAMPIL PARENT (KOLOM SUB AKUN)   
                                  
                                  //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)
                                        $tipe_akun = "<p class='edit-tipe-akun' data-id='".$data_daftar_akun_if['id']."'><span id='text-tipe-".$data_daftar_akun_if['id']."'>". $data_daftar_akun_if['tipe_akun'] ."</span>
                                        <select style='display:none' id='select-tipe-".$data_daftar_akun_if['id']."' value='".$data_daftar_akun_if['tipe_akun']."' class='select-tipe-akun' data-id='".$data_daftar_akun_if['id']."' autofocus=''>";
                                        
                                        $tipe_akun .= "
                                            <option selected> ". $data_daftar_akun_if['tipe_akun'] ."</option>
                                            <option>Akun Header</option>  
                                            <option>Kas & Bank</option> 
                                            <option>Piutang Dagang</option> 
                                            <option>Piutang Non Dagang</option> 
                                            <option>Persediaan</option> 
                                            <option>Investasi Portofolio</option> 
                                            <option>Pajak Dibayar Dimuka</option> 
                                            <option>Beban Bayar Dimuka</option> 
                                            <option>Aktiva Tetap</option> 
                                            <option>Akumulasi Penyusutan</option> 
                                            <option>Hutang Dagang</option>  
                                            <option>Pendapatan Diterima Dimuka</option> 
                                            <option>Beban YMH Dibayar</option>  
                                            <option>Hutang Pajak</option> 
                                            <option>Hutang Bank Jangka Pendek</option>  
                                            <option>Hutang Bukan Bank Jangka Pendek</option>  
                                            <option>Hutang Non Dagang</option>  
                                            <option>Ekuitas</option>
                                            <option>Pendapatan Penjualan</option>   
                                            <option>Pendapatan Diluar Usaha</option>  
                                            <option>Harga Pokok Penjualan</option>  
                                            <option>Beban Administrasi dan Umum</option>
                                            <option>Beban Penjualan</option>
                                            <option>Beban Pemansaran</option>
                                            <option>Beban Operasional</option>
                                            <option>Beban Diluar Usaha</option>
                                            <option>Bunga Pinjaman</option>
                                            <option>Hutang Bank Jangka Panjang</option>
                                            <option>Hutang Bukan Bank Jangka Panjang</option>
                                            <option>Deviden</option>
                                            <option>Beban Pajak Penghasilan</option>
                                        </select>";

                                        $nestedData[] = "<p>".$tipe_akun."</p>";
                                  //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)

                                  // TOMBOL HAPUS 
                                    if ($daftar_akun['daftar_akun_hapus'] > 0) {   

                                        $nestedData[] = "<button class='btn btn-danger btn-floating btn-hapus-akun' data-id='". $data_daftar_akun_if['id'] ."' data-akun='". $data_daftar_akun_if['nama_daftar_akun'] ."' kode-akun='". $data_daftar_akun_if['kode_daftar_akun'] ."'> <i class='fa fa-trash'> </i> Hapus </button>";

                                      }
                                    else{
                                      $nestedData[] = "";
                                    }
                                  // TOMBOL HAPUS 
                                  
                                    $data[] = $nestedData;

                              }

                  }// END GRUP AKUN (3)

                }
                else{

    //SELECT DAFTAR AKUN JIKA GRUP AKUN SAMA DENGAN ( == ) GRUP AKUN DI DAFTAR AKUN

                              $query_daftar_akun_else = $db->query("SELECT id, kode_daftar_akun, nama_daftar_akun, grup_akun, kategori_akun, tipe_akun FROM daftar_akun WHERE kategori_akun = '$kategori' AND grup_akun= '$data_grup_akun[kode_grup_akun]'");
                              while ($data_daftar_akun_else = mysqli_fetch_array($query_daftar_akun_else)){

                                    $nestedData = array(); 

                                      $nestedData[] = "<p>".$data_daftar_akun_else["kode_daftar_akun"]."</p>";

                                      $nestedData[] = "<p class='padding-75 edit-nama' data-id='".$data_daftar_akun_else['id']."'><span id='text-nama-". $data_daftar_akun_else['id'] ."'>". $data_daftar_akun_else['nama_daftar_akun'] ."</span><input type='hidden' id='input-nama-".$data_daftar_akun_else['id']."' value='".$data_daftar_akun_else['nama_daftar_akun']."' class='input_nama_akun' data-id='".$data_daftar_akun_else['id']."' autofocus=''></p>";

                                  //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)
                                        $kategori_akun = "<p class='edit-kategori-akun' data-id='".$data_daftar_akun_else['id']."'><span id='text-kategori-".$data_daftar_akun_else['id']."'>". $data_daftar_akun_else['kategori_akun'] ."</span>
                                        <select style='display:none' id='select-kategori-".$data_daftar_akun_else['id']."' value='".$data_daftar_akun_else['kategori_akun']."' class='select-kategori-akun' data-id='".$data_daftar_akun_else['id']."' autofocus=''>";

                                        $kategori_akun .= "
                                            <option selected> ". $data_daftar_akun_else['kategori_akun'] ."</option>
                                            <option>Aktiva</option>  
                                            <option>Kewajiban</option>  
                                            <option>Modal</option>  
                                            <option>Pendapatan</option>  
                                            <option>HPP</option>  
                                            <option>Biaya</option>
                                            <option>Pendapatan Lain</option>  
                                            <option>Biaya Lain</option>
                                        </select>";

                                        $nestedData[] = "<p>".$kategori_akun."</p>";
                                  //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)

                                  //TAMPIL PARENT (KOLOM SUB AKUN)
                                      
                                      $parent = "<p Class='edit-parent' data-id='".$data_daftar_akun_else['id']."'><span id='text-parent-".$data_daftar_akun_else['id']."'>". $data_daftar_akun_else['grup_akun'] ."</span>
                                        <select style='display:none' id='select-parent-".$data_daftar_akun_else['id']."' value='".$data_daftar_akun_else['grup_akun']."' class='select-parent-akun' data-id='".$data_daftar_akun_else['id']."' autofocus=''>";      

                                        $query_kode_grup = $db->query("SELECT kode_grup_akun FROM grup_akun");
                                        while($data_kode_grup = mysqli_fetch_array($query_kode_grup))
                                        {
                                          if ($data_kode_grup['kode_grup_akun'] == $data_daftar_akun_else['grup_akun']) {          
                                              $parent .= "<option selected>".$data_kode_grup["kode_grup_akun"] ."</option>";
                                          }
                                          else{
                                              $parent .= "<option>".$data_kode_grup["kode_grup_akun"] ."</option>";
                                          }
                                        }

                                        $parent .= "</select></p>";

                                      $nestedData[] = "<p>".$parent."</p>";
                                  //TAMPIL PARENT (KOLOM SUB AKUN)

                                  //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)
                                        $tipe_akun = "<p class='edit-tipe-akun' data-id='".$data_daftar_akun_else['id']."'><span id='text-tipe-".$data_daftar_akun_else['id']."'>". $data_daftar_akun_else['tipe_akun'] ."</span>
                                        <select style='display:none' id='select-tipe-".$data_daftar_akun_else['id']."' value='".$data_daftar_akun_else['tipe_akun']."' class='select-tipe-akun' data-id='".$data_daftar_akun_else['id']."' autofocus=''>";
                                        
                                        $tipe_akun .= "
                                            <option selected> ". $data_daftar_akun_else['tipe_akun'] ."</option>
                                            <option>Akun Header</option>  
                                            <option>Kas & Bank</option> 
                                            <option>Piutang Dagang</option> 
                                            <option>Piutang Non Dagang</option> 
                                            <option>Persediaan</option> 
                                            <option>Investasi Portofolio</option> 
                                            <option>Pajak Dibayar Dimuka</option> 
                                            <option>Beban Bayar Dimuka</option> 
                                            <option>Aktiva Tetap</option> 
                                            <option>Akumulasi Penyusutan</option> 
                                            <option>Hutang Dagang</option>  
                                            <option>Pendapatan Diterima Dimuka</option> 
                                            <option>Beban YMH Dibayar</option>  
                                            <option>Hutang Pajak</option> 
                                            <option>Hutang Bank Jangka Pendek</option>  
                                            <option>Hutang Bukan Bank Jangka Pendek</option>  
                                            <option>Hutang Non Dagang</option>  
                                            <option>Ekuitas</option>
                                            <option>Pendapatan Penjualan</option>   
                                            <option>Pendapatan Diluar Usaha</option>  
                                            <option>Harga Pokok Penjualan</option>  
                                            <option>Beban Administrasi dan Umum</option>
                                            <option>Beban Penjualan</option>
                                            <option>Beban Pemansaran</option>
                                            <option>Beban Operasional</option>
                                            <option>Beban Diluar Usaha</option>
                                            <option>Bunga Pinjaman</option>
                                            <option>Hutang Bank Jangka Panjang</option>
                                            <option>Hutang Bukan Bank Jangka Panjang</option>
                                            <option>Deviden</option>
                                            <option>Beban Pajak Penghasilan</option>
                                        </select>";

                                        $nestedData[] = "<p>".$tipe_akun."</p>";
                                  //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)

                                  // TOMBOL HAPUS 
                                   if ($daftar_akun['daftar_akun_hapus'] > 0) {

                                        $nestedData[] = "<button class='btn btn-danger btn-floating btn-hapus-akun' data-id='". $data_daftar_akun_else['id'] ."' data-akun='". $data_daftar_akun_else['nama_daftar_akun'] ."' kode-akun='". $data_daftar_akun_else['kode_daftar_akun'] ."'> <i class='fa fa-trash'> </i> Hapus </button>";
                                      }
                                    else{
                                      $nestedData[] = "";
                                    }
                                  // TOMBOL HAPUS 
                                    $data[] = $nestedData;

                              }
                }
    //END JIKA GRUP AKUN TIDAK SAMA DENGAN GRUP AKUN DI DAFTAR AKUN


            }// END GRUP AKUN (2)

      }
      else{


    //SELECT DAFTAR AKUN (ELSE)
                $query_daftar_akun = $db->query("SELECT grup_akun FROM daftar_akun WHERE kategori_akun = '$kategori' AND grup_akun= '$row[kode_grup_akun]'");
                $data_daftar_akun = mysqli_fetch_array($query_daftar_akun);

    //JIKA GRUP AKUN TIDAK SAMA DENGAN GRUP AKUN DI DAFTAR AKUN
                if ($data_daftar_akun['grup_akun'] != $row['kode_grup_akun']) {
    
    //SELECT GRUP AKUN - SUB AKUN -> GRUP AKUN (2) DIATAS
                  //GRUP AKUN (3)
                  $query_grup_akun_sub = $db->query("SELECT id, kode_grup_akun, nama_grup_akun, kategori_akun, tipe_akun, parent FROM grup_akun WHERE kategori_akun = '$kategori' AND tipe_akun = 'Akun Header' AND parent= '$row[kode_grup_akun]' ");
                  while ($data_grup_akun_sub = mysqli_fetch_array($query_grup_akun_sub)){

                          $nestedData = array(); 

                            $nestedData[] = "<b><p>".$data_grup_akun_sub["kode_grup_akun"]."</p></b>";

                            $nestedData[] = "<b><p class='padding-50 edit-nama' data-id='".$data_grup_akun_sub['id']."'><span id='text-nama-". $data_grup_akun_sub['id'] ."'>". $data_grup_akun_sub['nama_grup_akun'] ."</span><input type='hidden' id='input-nama-".$data_grup_akun_sub['id']."' value='".$data_grup_akun_sub['nama_grup_akun']."' class='input_nama' data-id='".$data_grup_akun_sub['id']."' autofocus=''></p></b>";

                      //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)
                            $kategori_akun = "<b><p class='edit-kategori' data-id='".$data_grup_akun_sub['id']."'><span id='text-kategori-".$data_grup_akun_sub['id']."'>". $data_grup_akun_sub['kategori_akun'] ."</span>
                              <select style='display:none' id='select-kategori-".$data_grup_akun_sub['id']."' value='".$data_grup_akun_sub['kategori_akun']."' class='select-kategori' data-id='".$data_grup_akun_sub['id']."' autofocus=''>";

                            $kategori_akun .= "
                                  <option selected> ". $data_grup_akun_sub['kategori_akun'] ."</option>
                                  <option>Aktiva</option>  
                                  <option>Kewajiban</option>  
                                  <option>Modal</option>  
                                  <option>Pendapatan</option>  
                                  <option>HPP</option>  
                                  <option>Biaya</option>
                                  <option>Pendapatan Lain</option>  
                                  <option>Biaya Lain</option>
                              </select>";

                            $nestedData[] = "<b><p>".$kategori_akun."</p></b>";
                      //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)

                      //TAMPIL PARENT (KOLOM SUB AKUN)
                            $parent = "<b><p Class='edit-parent' data-id='".$data_grup_akun_sub['id']."'><span id='text-parent-".$data_grup_akun_sub['id']."'>". $data_grup_akun_sub['parent'] ."</span>
                              <select style='display:none' id='select-parent-".$data_grup_akun_sub['id']."' value='".$data_grup_akun_sub['parent']."' class='select-parent' data-id='".$data_grup_akun_sub['id']."' autofocus=''>";      

                              $query_kode_grup = $db->query("SELECT kode_grup_akun FROM grup_akun");
                              while($data_kode_grup = mysqli_fetch_array($query_kode_grup))
                              {
                                if ($data_kode_grup['kode_grup_akun'] == $data_grup_akun_sub['parent']) {          
                                    $parent .= "<option selected>".$data_kode_grup["kode_grup_akun"] ."</option>";
                                }
                                else{
                                    $parent .= "<option>".$data_kode_grup["kode_grup_akun"] ."</option>";
                                }
                              }

                              $parent .= "</select></p></b>";

                            $nestedData[] = "<b><p>".$parent."</p></b>";
                      //TAMPIL PARENT (KOLOM SUB AKUN)
                      
                      //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)
                            $tipe_akun = "<b><p class='edit-tipe' data-id='".$data_grup_akun_sub['id']."'><span id='text-tipe-".$data_grup_akun_sub['id']."'>". $data_grup_akun_sub['tipe_akun'] ."</span>
                            <select style='display:none' id='select-tipe-".$data_grup_akun_sub['id']."' value='".$data_grup_akun_sub['tipe_akun']."' class='select-tipe' data-id='".$data_grup_akun_sub['id']."' autofocus=''>";
                            
                            $tipe_akun .= "
                                <option selected> ". $data_grup_akun_sub['tipe_akun'] ."</option>
                                <option>Akun Header</option>  
                                <option>Kas & Bank</option> 
                                <option>Piutang Dagang</option> 
                                <option>Piutang Non Dagang</option> 
                                <option>Persediaan</option> 
                                <option>Investasi Portofolio</option> 
                                <option>Pajak Dibayar Dimuka</option> 
                                <option>Beban Bayar Dimuka</option> 
                                <option>Aktiva Tetap</option> 
                                <option>Akumulasi Penyusutan</option> 
                                <option>Hutang Dagang</option>  
                                <option>Pendapatan Diterima Dimuka</option> 
                                <option>Beban YMH Dibayar</option>  
                                <option>Hutang Pajak</option> 
                                <option>Hutang Bank Jangka Pendek</option>  
                                <option>Hutang Bukan Bank Jangka Pendek</option>  
                                <option>Hutang Non Dagang</option>  
                                <option>Ekuitas</option>
                                <option>Pendapatan Penjualan</option>   
                                <option>Pendapatan Diluar Usaha</option>  
                                <option>Harga Pokok Penjualan</option>  
                                <option>Beban Administrasi dan Umum</option>
                                <option>Beban Penjualan</option>
                                <option>Beban Pemansaran</option>
                                <option>Beban Operasional</option>
                                <option>Beban Diluar Usaha</option>
                                <option>Bunga Pinjaman</option>
                                <option>Hutang Bank Jangka Panjang</option>
                                <option>Hutang Bukan Bank Jangka Panjang</option>
                                <option>Deviden</option>
                                <option>Beban Pajak Penghasilan</option>
                            </select>";

                            $nestedData[] = "<b><p>".$tipe_akun."</p></b>";
                      //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)

                      // TOMBOL HAPUS 
                        if ($grup_akun['grup_akun_hapus'] > 0) {

                            $nestedData[] = "<button class='btn btn-floating btn-danger btn-hapus' data-id='". $data_grup_akun_sub['id'] ."' data-akun='". $data_grup_akun_sub['nama_grup_akun'] ."'> <i class='fa fa-trash'> </i> Hapus </button>";
                          }
                        else{
                          $nestedData[] = "";
                        }
                      // TOMBOL HAPUS 
                      
                          $data[] = $nestedData;

    //SELECT DAFTAR AKUN JIKA GRUP AKUN TIDAK SAMA DENGAN ( != ) GRUP AKUN DI DAFTAR AKUN
                              $query_daftar_akun_if = $db->query("SELECT id, kode_daftar_akun, nama_daftar_akun, grup_akun, kategori_akun, tipe_akun FROM daftar_akun WHERE kategori_akun = '$kategori' AND grup_akun= '$data_grup_akun_sub[kode_grup_akun]'");
                              while ($data_daftar_akun_if = mysqli_fetch_array($query_daftar_akun_if)){

                                    $nestedData = array(); 

                                      $nestedData[] = "<p>".$data_daftar_akun_if["kode_daftar_akun"]."</p>";

                                      $nestedData[] = "<p class='padding-75 edit-nama' data-id='".$data_daftar_akun_if['id']."'><span id='text-nama-". $data_daftar_akun_if['id'] ."'>". $data_daftar_akun_if['nama_daftar_akun'] ."</span><input type='hidden' id='input-nama-".$data_daftar_akun_if['id']."' value='".$data_daftar_akun_if['nama_daftar_akun']."' class='input_nama_akun' data-id='".$data_daftar_akun_if['id']."' autofocus=''></p>";

                                //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)
                                      $kategori_akun = "<p class='edit-kategori-akun' data-id='".$data_daftar_akun_if['id']."'><span id='text-kategori-".$data_daftar_akun_if['id']."'>". $data_daftar_akun_if['kategori_akun'] ."</span>
                                        <select style='display:none' id='select-kategori-".$data_daftar_akun_if['id']."' value='".$data_daftar_akun_if['kategori_akun']."' class='select-kategori-akun' data-id='".$data_daftar_akun_if['id']."' autofocus=''>";

                                      $kategori_akun .= "
                                            <option selected> ". $data_daftar_akun_if['kategori_akun'] ."</option>
                                            <option>Aktiva</option>  
                                            <option>Kewajiban</option>  
                                            <option>Modal</option>  
                                            <option>Pendapatan</option>  
                                            <option>HPP</option>  
                                            <option>Biaya</option>
                                            <option>Pendapatan Lain</option>  
                                            <option>Biaya Lain</option>
                                        </select>";

                                      $nestedData[] = "<p>".$kategori_akun."</p>";
                                //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)

                                //TAMPIL PARENT (KOLOM SUB AKUN)                                      
                                      $parent = "<p Class='edit-parent' data-id='".$data_daftar_akun_if['id']."'><span id='text-parent-".$data_daftar_akun_if['id']."'>". $data_daftar_akun_if['grup_akun'] ."</span>
                                        <select style='display:none' id='select-parent-".$data_daftar_akun_if['id']."' value='".$data_daftar_akun_if['grup_akun']."' class='select-parent-akun' data-id='".$data_daftar_akun_if['id']."' autofocus=''>";      

                                        $query_kode_grup = $db->query("SELECT kode_grup_akun FROM grup_akun");
                                        while($data_kode_grup = mysqli_fetch_array($query_kode_grup))
                                        {
                                          if ($data_kode_grup['kode_grup_akun'] == $data_daftar_akun_if['grup_akun']) {          
                                              $parent .= "<option selected>".$data_kode_grup["kode_grup_akun"] ."</option>";
                                          }
                                          else{
                                              $parent .= "<option>".$data_kode_grup["kode_grup_akun"] ."</option>";
                                          }
                                        }

                                        $parent .= "</select></p>";

                                      $nestedData[] = "<p>".$parent."</p>";
                                //TAMPIL PARENT (KOLOM SUB AKUN) 

                                  //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)
                                        $tipe_akun = "<p class='edit-tipe-akun' data-id='".$data_daftar_akun_if['id']."'><span id='text-tipe-".$data_daftar_akun_if['id']."'>". $data_daftar_akun_if['tipe_akun'] ."</span>
                                        <select style='display:none' id='select-tipe-".$data_daftar_akun_if['id']."' value='".$data_daftar_akun_if['tipe_akun']."' class='select-tipe-akun' data-id='".$data_daftar_akun_if['id']."' autofocus=''>";
                                        
                                        $tipe_akun .= "
                                            <option selected> ". $data_daftar_akun_if['tipe_akun'] ."</option>
                                            <option>Akun Header</option>  
                                            <option>Kas & Bank</option> 
                                            <option>Piutang Dagang</option> 
                                            <option>Piutang Non Dagang</option> 
                                            <option>Persediaan</option> 
                                            <option>Investasi Portofolio</option> 
                                            <option>Pajak Dibayar Dimuka</option> 
                                            <option>Beban Bayar Dimuka</option> 
                                            <option>Aktiva Tetap</option> 
                                            <option>Akumulasi Penyusutan</option> 
                                            <option>Hutang Dagang</option>  
                                            <option>Pendapatan Diterima Dimuka</option> 
                                            <option>Beban YMH Dibayar</option>  
                                            <option>Hutang Pajak</option> 
                                            <option>Hutang Bank Jangka Pendek</option>  
                                            <option>Hutang Bukan Bank Jangka Pendek</option>  
                                            <option>Hutang Non Dagang</option>  
                                            <option>Ekuitas</option>
                                            <option>Pendapatan Penjualan</option>   
                                            <option>Pendapatan Diluar Usaha</option>  
                                            <option>Harga Pokok Penjualan</option>  
                                            <option>Beban Administrasi dan Umum</option>
                                            <option>Beban Penjualan</option>
                                            <option>Beban Pemansaran</option>
                                            <option>Beban Operasional</option>
                                            <option>Beban Diluar Usaha</option>
                                            <option>Bunga Pinjaman</option>
                                            <option>Hutang Bank Jangka Panjang</option>
                                            <option>Hutang Bukan Bank Jangka Panjang</option>
                                            <option>Deviden</option>
                                            <option>Beban Pajak Penghasilan</option>
                                        </select>";

                                        $nestedData[] = "<p>".$tipe_akun."</p>";
                                  //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)

                                  // TOMBOL HAPUS 
                                    if ($daftar_akun['daftar_akun_hapus'] > 0) {

                                        $nestedData[] = "<button class='btn btn-danger btn-floating btn-hapus-akun' data-id='". $data_daftar_akun_if['id'] ."' data-akun='". $data_daftar_akun_if['nama_daftar_akun'] ."' kode-akun='". $data_daftar_akun_if['kode_daftar_akun'] ."'> <i class='fa fa-trash'> </i> Hapus </button>";
                                      }
                                    else{
                                      $nestedData[] = "";
                                    }
                                  // TOMBOL HAPUS 
                                  
                                    $data[] = $nestedData;

                              }

                  }// END GRUP AKUN (3)

                }
                else{
                //(**NOTE)
                //JIKA ADA DAFTAR AKUN YANG LANGSUNG TERHUBUNG KE GRUP AKUN HEADER, MAKSUDNYA ADA DAFTAR AKUN YANG LANGSUNG TERHUBUNG KE GRUP AKUN TERATAS TANPA TERHUBUNG KE SUB HEADER SUB HEADER LAINNYA
                //(**NOTE)
                //JIKA ADA DAFTAR AKUN YANG LANGSUNG TERHUBUNG KE GRUP AKUN HEADER, MAKSUDNYA ADA DAFTAR AKUN YANG LANGSUNG TERHUBUNG KE GRUP AKUN TERATAS TANPA TERHUBUNG KE SUB HEADER SUB HEADER LAINNYA

    //GRUP AKUN (3)
                  $query_grup_akun_sub = $db->query("SELECT id, kode_grup_akun, nama_grup_akun, kategori_akun, tipe_akun, parent FROM grup_akun WHERE kategori_akun = '$kategori' AND tipe_akun = 'Akun Header' AND parent= '$row[kode_grup_akun]' ");
                  while ($data_grup_akun_sub = mysqli_fetch_array($query_grup_akun_sub)){

                          $nestedData = array(); 

                            $nestedData[] = "<b><p>".$data_grup_akun_sub["kode_grup_akun"]."</p></b>";

                            $nestedData[] = "<b><p class='padding-50 edit-nama' data-id='".$data_grup_akun_sub['id']."'><span id='text-nama-". $data_grup_akun_sub['id'] ."'>". $data_grup_akun_sub['nama_grup_akun'] ."</span><input type='hidden' id='input-nama-".$data_grup_akun_sub['id']."' value='".$data_grup_akun_sub['nama_grup_akun']."' class='input_nama' data-id='".$data_grup_akun_sub['id']."' autofocus=''></p></b>";

                      //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)
                            $kategori_akun = "<b><p class='edit-kategori' data-id='".$data_grup_akun_sub['id']."'><span id='text-kategori-".$data_grup_akun_sub['id']."'>". $data_grup_akun_sub['kategori_akun'] ."</span>
                              <select style='display:none' id='select-kategori-".$data_grup_akun_sub['id']."' value='".$data_grup_akun_sub['kategori_akun']."' class='select-kategori' data-id='".$data_grup_akun_sub['id']."' autofocus=''>";

                            $kategori_akun .= "
                                  <option selected> ". $data_grup_akun_sub['kategori_akun'] ."</option>
                                  <option>Aktiva</option>  
                                  <option>Kewajiban</option>  
                                  <option>Modal</option>  
                                  <option>Pendapatan</option>  
                                  <option>HPP</option>  
                                  <option>Biaya</option>
                                  <option>Pendapatan Lain</option>  
                                  <option>Biaya Lain</option>
                              </select>";

                            $nestedData[] = "<b><p>".$kategori_akun."</p></b>";
                      //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)

                      //TAMPIL PARENT (KOLOM SUB AKUN)                            
                            $parent = "<b><p Class='edit-parent' data-id='".$data_grup_akun_sub['id']."'><span id='text-parent-".$data_grup_akun_sub['id']."'>". $data_grup_akun_sub['parent'] ."</span>
                              <select style='display:none' id='select-parent-".$data_grup_akun_sub['id']."' value='".$data_grup_akun_sub['parent']."' class='select-parent' data-id='".$data_grup_akun_sub['id']."' autofocus=''>";      

                              $query_kode_grup = $db->query("SELECT kode_grup_akun FROM grup_akun");
                              while($data_kode_grup = mysqli_fetch_array($query_kode_grup))
                              {
                                if ($data_kode_grup['kode_grup_akun'] == $data_grup_akun_sub['parent']) {          
                                    $parent .= "<option selected>".$data_kode_grup["kode_grup_akun"] ."</option>";
                                }
                                else{
                                    $parent .= "<option>".$data_kode_grup["kode_grup_akun"] ."</option>";
                                }
                              }

                              $parent .= "</select></p></b>";

                            $nestedData[] = "<b><p>".$parent."</p></b>";
                      //TAMPIL PARENT (KOLOM SUB AKUN)

                      //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)
                            $tipe_akun = "<b><p class='edit-tipe' data-id='".$data_grup_akun_sub['id']."'><span id='text-tipe-".$data_grup_akun_sub['id']."'>". $data_grup_akun_sub['tipe_akun'] ."</span>
                            <select style='display:none' id='select-tipe-".$data_grup_akun_sub['id']."' value='".$data_grup_akun_sub['tipe_akun']."' class='select-tipe' data-id='".$data_grup_akun_sub['id']."' autofocus=''>";
                            
                            $tipe_akun .= "
                                <option selected> ". $data_grup_akun_sub['tipe_akun'] ."</option>
                                <option>Akun Header</option>  
                                <option>Kas & Bank</option> 
                                <option>Piutang Dagang</option> 
                                <option>Piutang Non Dagang</option> 
                                <option>Persediaan</option> 
                                <option>Investasi Portofolio</option> 
                                <option>Pajak Dibayar Dimuka</option> 
                                <option>Beban Bayar Dimuka</option> 
                                <option>Aktiva Tetap</option> 
                                <option>Akumulasi Penyusutan</option> 
                                <option>Hutang Dagang</option>  
                                <option>Pendapatan Diterima Dimuka</option> 
                                <option>Beban YMH Dibayar</option>  
                                <option>Hutang Pajak</option> 
                                <option>Hutang Bank Jangka Pendek</option>  
                                <option>Hutang Bukan Bank Jangka Pendek</option>  
                                <option>Hutang Non Dagang</option>  
                                <option>Ekuitas</option>
                                <option>Pendapatan Penjualan</option>   
                                <option>Pendapatan Diluar Usaha</option>  
                                <option>Harga Pokok Penjualan</option>  
                                <option>Beban Administrasi dan Umum</option>
                                <option>Beban Penjualan</option>
                                <option>Beban Pemansaran</option>
                                <option>Beban Operasional</option>
                                <option>Beban Diluar Usaha</option>
                                <option>Bunga Pinjaman</option>
                                <option>Hutang Bank Jangka Panjang</option>
                                <option>Hutang Bukan Bank Jangka Panjang</option>
                                <option>Deviden</option>
                                <option>Beban Pajak Penghasilan</option>
                            </select>";

                            $nestedData[] = "<b><p>".$tipe_akun."</p></b>";
                      //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)

                      // TOMBOL HAPUS 
                        if ($grup_akun['grup_akun_hapus'] > 0) {

                            $nestedData[] = "<button class='btn btn-floating btn-danger btn-hapus' data-id='". $data_grup_akun_sub['id'] ."' data-akun='". $data_grup_akun_sub['nama_grup_akun'] ."' kode-akun='". $data_grup_akun_sub['kode_grup_akun'] ."'> <i class='fa fa-trash'> </i> Hapus </button>";
                          }
                        else{
                          $nestedData[] = "";
                        }
                      // TOMBOL HAPUS 
                      
                          $data[] = $nestedData;

    //SELECT DAFTAR AKUN JIKA GRUP AKUN TIDAK SAMA DENGAN ( != ) GRUP AKUN DI DAFTAR AKUN
                              $query_daftar_akun_if = $db->query("SELECT id, kode_daftar_akun, nama_daftar_akun, grup_akun, kategori_akun, tipe_akun FROM daftar_akun WHERE kategori_akun = '$kategori' AND grup_akun= '$data_grup_akun_sub[kode_grup_akun]'");
                              while ($data_daftar_akun_if = mysqli_fetch_array($query_daftar_akun_if)){

                                    $nestedData = array(); 

                                      $nestedData[] = "<p>".$data_daftar_akun_if["kode_daftar_akun"]."</p>";


                                      $nestedData[] = "<p class='padding-75 edit-nama' data-id='".$data_daftar_akun_if['id']."'><span id='text-nama-". $data_daftar_akun_if['id'] ."'>". $data_daftar_akun_if['nama_daftar_akun'] ."</span><input type='hidden' id='input-nama-".$data_daftar_akun_if['id']."' value='".$data_daftar_akun_if['nama_daftar_akun']."' class='input_nama_akun' data-id='".$data_daftar_akun_if['id']."' autofocus=''></p>";

                                //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)
                                      $kategori_akun = "<p class='edit-kategori-akun' data-id='".$data_daftar_akun_if['id']."'><span id='text-kategori-".$data_daftar_akun_if['id']."'>". $data_daftar_akun_if['kategori_akun'] ."</span>
                                        <select style='display:none' id='select-kategori-".$data_daftar_akun_if['id']."' value='".$data_daftar_akun_if['kategori_akun']."' class='select-kategori-akun' data-id='".$data_daftar_akun_if['id']."' autofocus=''>";

                                      $kategori_akun .= "
                                            <option selected> ". $data_daftar_akun_if['kategori_akun'] ."</option>
                                            <option>Aktiva</option>  
                                            <option>Kewajiban</option>  
                                            <option>Modal</option>  
                                            <option>Pendapatan</option>  
                                            <option>HPP</option>  
                                            <option>Biaya</option>
                                            <option>Pendapatan Lain</option>  
                                            <option>Biaya Lain</option>
                                        </select>";

                                      $nestedData[] = "<p>".$kategori_akun."</p>";
                                //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)

                                //TAMPIL PARENT (KOLOM SUB AKUN)                                     
                                      $parent = "<p Class='edit-parent' data-id='".$data_daftar_akun_if['id']."'><span id='text-parent-".$data_daftar_akun_if['id']."'>". $data_daftar_akun_if['grup_akun'] ."</span>
                                        <select style='display:none' id='select-parent-".$data_daftar_akun_if['id']."' value='".$data_daftar_akun_if['grup_akun']."' class='select-parent-akun' data-id='".$data_daftar_akun_if['id']."' autofocus=''>";      

                                        $query_kode_grup = $db->query("SELECT kode_grup_akun FROM grup_akun");
                                        while($data_kode_grup = mysqli_fetch_array($query_kode_grup))
                                        {
                                          if ($data_kode_grup['kode_grup_akun'] == $data_daftar_akun_if['grup_akun']) {          
                                              $parent .= "<option selected>".$data_kode_grup["kode_grup_akun"] ."</option>";
                                          }
                                          else{
                                              $parent .= "<option>".$data_kode_grup["kode_grup_akun"] ."</option>";
                                          }
                                        }

                                        $parent .= "</select></p>";

                                      $nestedData[] = "<p>".$parent."</p>";
                                //TAMPIL PARENT (KOLOM SUB AKUN)
                                
                                  //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)
                                        $tipe_akun = "<p class='edit-tipe-akun' data-id='".$data_daftar_akun_if['id']."'><span id='text-tipe-".$data_daftar_akun_if['id']."'>". $data_daftar_akun_if['tipe_akun'] ."</span>
                                        <select style='display:none' id='select-tipe-".$data_daftar_akun_if['id']."' value='".$data_daftar_akun_if['tipe_akun']."' class='select-tipe-akun' data-id='".$data_daftar_akun_if['id']."' autofocus=''>";
                                        
                                        $tipe_akun .= "
                                            <option selected> ". $data_daftar_akun_if['tipe_akun'] ."</option>
                                            <option>Akun Header</option>  
                                            <option>Kas & Bank</option> 
                                            <option>Piutang Dagang</option> 
                                            <option>Piutang Non Dagang</option> 
                                            <option>Persediaan</option> 
                                            <option>Investasi Portofolio</option> 
                                            <option>Pajak Dibayar Dimuka</option> 
                                            <option>Beban Bayar Dimuka</option> 
                                            <option>Aktiva Tetap</option> 
                                            <option>Akumulasi Penyusutan</option> 
                                            <option>Hutang Dagang</option>  
                                            <option>Pendapatan Diterima Dimuka</option> 
                                            <option>Beban YMH Dibayar</option>  
                                            <option>Hutang Pajak</option> 
                                            <option>Hutang Bank Jangka Pendek</option>  
                                            <option>Hutang Bukan Bank Jangka Pendek</option>  
                                            <option>Hutang Non Dagang</option>  
                                            <option>Ekuitas</option>
                                            <option>Pendapatan Penjualan</option>   
                                            <option>Pendapatan Diluar Usaha</option>  
                                            <option>Harga Pokok Penjualan</option>  
                                            <option>Beban Administrasi dan Umum</option>
                                            <option>Beban Penjualan</option>
                                            <option>Beban Pemansaran</option>
                                            <option>Beban Operasional</option>
                                            <option>Beban Diluar Usaha</option>
                                            <option>Bunga Pinjaman</option>
                                            <option>Hutang Bank Jangka Panjang</option>
                                            <option>Hutang Bukan Bank Jangka Panjang</option>
                                            <option>Deviden</option>
                                            <option>Beban Pajak Penghasilan</option>
                                        </select>";

                                        $nestedData[] = "<p>".$tipe_akun."</p>";
                                  //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)

                                  // TOMBOL HAPUS 
                                    if ($daftar_akun['daftar_akun_hapus'] > 0) {

                                        $nestedData[] = "<button class='btn btn-danger btn-floating btn-hapus-akun' data-id='". $data_daftar_akun_if['id'] ."' data-akun='". $data_daftar_akun_if['nama_daftar_akun'] ."' kode-akun='". $data_daftar_akun_if['kode_daftar_akun'] ."'> <i class='fa fa-trash'> </i> Hapus </button>";
                                      }
                                    else{
                                      $nestedData[] = "";
                                    }
                                  // TOMBOL HAPUS 
                                  
                                    $data[] = $nestedData;

                              }

                  }// END GRUP AKUN (3)

    //SELECT DAFTAR AKUN JIKA GRUP AKUN SAMA DENGAN ( == ) GRUP AKUN DI DAFTAR AKUN

                              $query_daftar_akun_else = $db->query("SELECT id, kode_daftar_akun, nama_daftar_akun, grup_akun, kategori_akun, tipe_akun FROM daftar_akun WHERE kategori_akun = '$kategori' AND grup_akun= '$row[kode_grup_akun]'");
                              while ($data_daftar_akun_else = mysqli_fetch_array($query_daftar_akun_else)){

                                    $nestedData = array(); 

                                      $nestedData[] = "<p>".$data_daftar_akun_else["kode_daftar_akun"]."</p>";

                                      $nestedData[] = "<p class='padding-50 edit-nama' data-id='".$data_daftar_akun_else['id']."'><span id='text-nama-". $data_daftar_akun_else['id'] ."'>". $data_daftar_akun_else['nama_daftar_akun'] ."</span><input type='hidden' id='input-nama-".$data_daftar_akun_else['id']."' value='".$data_daftar_akun_else['nama_daftar_akun']."' class='input_nama_akun' data-id='".$data_daftar_akun_else['id']."' autofocus=''></p>";

                                //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)
                                      $kategori_akun = "<p class='edit-kategori-akun' data-id='".$data_daftar_akun_else['id']."'><span id='text-kategori-".$data_daftar_akun_else['id']."'>". $data_daftar_akun_else['kategori_akun'] ."</span>
                                        <select style='display:none' id='select-kategori-".$data_daftar_akun_else['id']."' value='".$data_daftar_akun_else['kategori_akun']."' class='select-kategori-akun' data-id='".$data_daftar_akun_else['id']."' autofocus=''>";

                                      $kategori_akun .= "
                                            <option selected> ". $data_daftar_akun_else['kategori_akun'] ."</option>
                                            <option>Aktiva</option>  
                                            <option>Kewajiban</option>  
                                            <option>Modal</option>  
                                            <option>Pendapatan</option>  
                                            <option>HPP</option>  
                                            <option>Biaya</option>
                                            <option>Pendapatan Lain</option>  
                                            <option>Biaya Lain</option>
                                        </select>";

                                      $nestedData[] = "<p>".$kategori_akun."</p>";
                                //TAMPIL KATEGORI AKUN (KOLOM KLASIFIKASI)

                                //TAMPIL PARENT (KOLOM SUB AKUN)                                      
                                      $parent = "<p Class='edit-parent' data-id='".$data_daftar_akun_else['id']."'><span id='text-parent-".$data_daftar_akun_else['id']."'>". $data_daftar_akun_else['grup_akun'] ."</span>
                                        <select style='display:none' id='select-parent-".$data_daftar_akun_else['id']."' value='".$data_daftar_akun_else['grup_akun']."' class='select-parent-akun' data-id='".$data_daftar_akun_else['id']."' autofocus=''>";      

                                        $query_kode_grup = $db->query("SELECT kode_grup_akun FROM grup_akun");
                                        while($data_kode_grup = mysqli_fetch_array($query_kode_grup))
                                        {
                                          if ($data_kode_grup['kode_grup_akun'] == $data_daftar_akun_else['grup_akun']) {          
                                              $parent .= "<option selected>".$data_kode_grup["kode_grup_akun"] ."</option>";
                                          }
                                          else{
                                              $parent .= "<option>".$data_kode_grup["kode_grup_akun"] ."</option>";
                                          }
                                        }

                                        $parent .= "</select></p>";

                                      $nestedData[] = "<p>".$parent."</p>";
                                //TAMPIL PARENT (KOLOM SUB AKUN)
                              
                                  //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)
                                        $tipe_akun = "<p class='edit-tipe-akun' data-id='".$data_daftar_akun_else['id']."'><span id='text-tipe-".$data_daftar_akun_else['id']."'>". $data_daftar_akun_else['tipe_akun'] ."</span>
                                        <select style='display:none' id='select-tipe-".$data_daftar_akun_else['id']."' value='".$data_daftar_akun_else['tipe_akun']."' class='select-tipe-akun' data-id='".$data_daftar_akun_else['id']."' autofocus=''>";
                                        
                                        $tipe_akun .= "
                                            <option selected> ". $data_daftar_akun_else['tipe_akun'] ."</option>
                                            <option>Akun Header</option>  
                                            <option>Kas & Bank</option> 
                                            <option>Piutang Dagang</option> 
                                            <option>Piutang Non Dagang</option> 
                                            <option>Persediaan</option> 
                                            <option>Investasi Portofolio</option> 
                                            <option>Pajak Dibayar Dimuka</option> 
                                            <option>Beban Bayar Dimuka</option> 
                                            <option>Aktiva Tetap</option> 
                                            <option>Akumulasi Penyusutan</option> 
                                            <option>Hutang Dagang</option>  
                                            <option>Pendapatan Diterima Dimuka</option> 
                                            <option>Beban YMH Dibayar</option>  
                                            <option>Hutang Pajak</option> 
                                            <option>Hutang Bank Jangka Pendek</option>  
                                            <option>Hutang Bukan Bank Jangka Pendek</option>  
                                            <option>Hutang Non Dagang</option>  
                                            <option>Ekuitas</option>
                                            <option>Pendapatan Penjualan</option>   
                                            <option>Pendapatan Diluar Usaha</option>  
                                            <option>Harga Pokok Penjualan</option>  
                                            <option>Beban Administrasi dan Umum</option>
                                            <option>Beban Penjualan</option>
                                            <option>Beban Pemansaran</option>
                                            <option>Beban Operasional</option>
                                            <option>Beban Diluar Usaha</option>
                                            <option>Bunga Pinjaman</option>
                                            <option>Hutang Bank Jangka Panjang</option>
                                            <option>Hutang Bukan Bank Jangka Panjang</option>
                                            <option>Deviden</option>
                                            <option>Beban Pajak Penghasilan</option>
                                        </select>";

                                        $nestedData[] = "<p>".$tipe_akun."</p>";
                                  //TAMPIL TIPE AKUN (KOLOM TIPE AKUN)

                                  // TOMBOL HAPUS 
                                    if ($daftar_akun['daftar_akun_hapus'] > 0) {

                                        $nestedData[] = "<button class='btn btn-danger btn-floating btn-hapus-akun' data-id='". $data_daftar_akun_else['id'] ."' data-akun='". $data_daftar_akun_else['nama_daftar_akun'] ."' kode-akun='". $data_daftar_akun_else['kode_daftar_akun'] ."'> <i class='fa fa-trash'> </i> Hapus </button>";
                                      }
                                    else{
                                      $nestedData[] = "";
                                    }
                                  // TOMBOL HAPUS 
                                  
                                    $data[] = $nestedData;

                              }
                }
    //END JIKA GRUP AKUN TIDAK SAMA DENGAN GRUP AKUN DI DAFTAR AKUN
      }

  

} // END WHILE GRUP AKUN (1)



$json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

echo json_encode($json_data);  // send data as json format

 ?>