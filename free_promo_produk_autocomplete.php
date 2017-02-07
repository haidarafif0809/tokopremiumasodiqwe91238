<?php
  
    include 'db.php';

    
    //get search term
    $searchTerm = $_GET['term'];
    
    //get matched data from skills table
    $query = $db->query("SELECT kode_barang, nama_barang FROM barang WHERE nama_barang LIKE '%".$searchTerm."%' OR kode_barang LIKE '%".$searchTerm."%' ORDER BY nama_barang ASC");
    while ($row = $query->fetch_assoc()) {
        $data[] = $row['kode_barang']."(".$row['nama_barang'].")";
    }
    
    //return json data
    echo json_encode($data);
?>