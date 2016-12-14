<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'db.php';

  ?>


  <script>
  $(function() {
    $( "#sampai_tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
  });
  </script>


<div class="container">
<form class="form-inline" role="form">
              

                  <div class="form-group"> 

                  <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Tanggal" value="<?php echo date("Y/m/d"); ?>" required="">
                  </div>

                  <button type="submit" name="submit" id="submit" class="btn btn-info" > Submit </button>

</form>
<span id="result">

<table id="tableuser" class="table table-bordered">
                  <thead>
                  
                  <th bgcolor="#F39C12" style="color:white"> Asset </th>
                  <th bgcolor="#F39C12" style="color:white"> Liability  </th>
            
                  </thead>

                  <tbody>
                        <tr>
                         <td>Cash : </td>
                         <td> Account Payable :</td>     

                        </tr>
                        <tr>
                          <td> Account Receivable :</td>
                          <td> Notes Payable :</td>    

                        </tr>
                        <tr>
                          <td> Inventory :</td>
                          <td> Tax Payable : </td>


                        </tr>

                        <tr>
                              <td> Equipment :</td>
                              <td> Total Liability :</td>
                        </tr>
                        <tr>

                        <td>Property :</td>
                        <td bgcolor="#F39C12" style="color:white"> <b> Equity </b></td>

                        </tr>
                        <tr>
                              
                              <td> (Depresiasi) : </td>
                              <td> Original Investment :</td>
                        </tr>
                        <tr>
                             <td> Goodwill :</td> 
                             <td> Retained Earning :</td>
                        </tr>
                        <tr>
                              <td> (Amortisasi) :</td>
                              <td> Earning Week To Date :</td>
                        </tr>
                        <tr>
                              <td> Total Asset : </td>
                              <td> Total Equity :</td>
                        </tr>

                  </tbody>
</table>
</span>
</div>

<script type="text/javascript">
$("#submit").click(function(){

      var sampai_tanggal = $("#sampai_tanggal").val();

$.post("proses_neraca.php", {sampai_tanggal:sampai_tanggal},function(info){

 $("#result").html(info);
});


});      
$("form").submit(function(){

return false;

});

</script>

<?php 
include 'footer.php';
 ?>