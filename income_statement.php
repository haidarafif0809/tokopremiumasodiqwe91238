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

                  <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y/m/d"); ?>" required="">
                  </div>

                  <button type="submit" name="submit" id="submit" class="btn btn-info" > Submit </button>

</form>
<span id="result">
 <table id="tableuser" class="table table-bordered">
                  <thead>
                  
                  <th bgcolor="#F39C12" style="color:white"> Profit And Lose Statement </th>

                  </thead>

                  <tbody>
                  <tr>
                         <td>Sales :</td>   

                  </tr>

                  <tr>
                        <td>Cost Of Good Sold :</td>
                  </tr>

                  <tr>
                        <td>Gross Profit :</td>
                  </tr>

                  <tr>
                        <td>Expenses :</td>
                  </tr>

                  <tr>
                        <td>Net Profit :</td>
                  </tr>



                  </tbody>
</table>
</span>
</div>


<script type="text/javascript">
$("#submit").click(function(){

      
      var sampai_tanggal = $("#sampai_tanggal").val();

$.post("proses_income_statement.php", {sampai_tanggal:sampai_tanggal},function(info){

 $("#result").html(info);
});


});      
$("form").submit(function(){

return false;

});

</script>>


<?php 
include 'footer.php';
 ?>