<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

<div class="container">
<h3><b> LAPORAN KOMISI PRODUK </b></h3><hr>

<a href="lap_jumlah_fee_petugas.php" class="btn btn-primary"> <i class="fa fa-list"> </i> KOMISI / PETUGAS</a><br><br>


<div class="table-responsive">
<table id="table-lap" class="table table-bordered">
            <thead>
                  <th style="background-color: #4CAF50; color: white;"> Nama Petugas </th>
                  <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
                  <th style="background-color: #4CAF50; color: white;"> Kode Produk </th>
                  <th style="background-color: #4CAF50; color: white;"> Nama Produk </th>
                  <th style="background-color: #4CAF50; color: white;"> Jumlah Komisi </th>
                  <th style="background-color: #4CAF50; color: white;"> Tanggal </th>
                  <th style="background-color: #4CAF50; color: white;"> Jam </th>
                  
            </thead>     

      </table>

</div>
</div>

            <script>
            $(document).ready(function(){

               $('#table-lap').DataTable().destroy();

                      var dataTable = $('#table-lap').DataTable( {
                      "processing": true,
                      "serverSide": true,
                      "info":     true,
                      "language": {
                    "emptyTable":     "My Custom Message On Empty Table"
                      },
                      "ajax":{
                        url :"table_lap_jumlah_fee.php", // json datasource
                        type: "post",  // method  , by default get
                        error: function(){  // error handling
                          $(".tbody").html("");
                          $("#table-lap").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                          $("#table-lap_processing").css("display","none");
                          
                        }
                      }
                


                    });

            });
            </script>


<?php 
include 'footer.php';
 ?>