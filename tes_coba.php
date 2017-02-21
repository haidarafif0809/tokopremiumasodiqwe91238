<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="jquery/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>

<link rel="stylesheet" href="datatables/dataTables.bootstrap.css">
<script src="datatables/dataTables.bootstrap.js"></script>
<script src="my.js"></script>
<script src="datatables/jquery.dataTables.js"></script>
<script src="chosen/chosen.jquery.js"></script>
<link rel="stylesheet" href="jquery-ui/jquery-ui.css">
<link rel="stylesheet" href="chosen/chosen.css">
<link rel="stylesheet" href="pos.css">
  
<script src="jquery-ui/jquery-ui.js"></script>
</head>
<body onkeypress="myFunction(event)">
<p>Press a key on the keyboard in the input field to get the Unicode character code of the pressed key.</p>

<input type="text" size="40" >
<input type="text" id="coba" size="40" >

<p id="demo"></p>
<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
/* In this example, we use a cross-browser solution, because the keyCode property does not work on the onkeypress event in Firefox. However, the which property does.

Explanation of the first line in the function below: if the browser supports event.which, then use event.which, otherwise use event.keyCode */

function myFunction(event) {
    var x = event.which || event.keyCode;
    document.getElementById("demo").innerHTML = "The Unicode value is: " + x;
    if(x == 112){


     $("#myModal").modal();

    }
    else if(x == 118){
     $("#myModal").modal('hide');

    }

     else if(x == 97){
     $("#coba").focus();

    }
}
</script>


</body>
</html>

