<html lang="in" >
<head>

	<title>
	<?php 
	include_once 'db.php';
	
		$query1 = $db->query("SELECT * FROM perusahaan ");
		$data1 = mysqli_fetch_array($query1);

		echo $data1['nama_perusahaan'];

	 ?>
	</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap4.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
		<!-- Material Design Bootstrap -->
		<link href="css/mdb.min.css" rel="stylesheet">

		
		<link rel="stylesheet" href="datatables/dataTables.bootstrap.css">
		
		<link rel="icon" href="save_picture/Andaglos-UKM.jpg" type="image/x-icon">


		<link rel="stylesheet" href="jquery-ui/jquery-ui.css">
		<link rel="stylesheet" href="chosen/chosen.css">
		<link rel="stylesheet" href="pos.css">
		
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Quicksand" />


    	<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>		<script src="my.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap4.min.js"></script>
		

		<script src="chosen/chosen.jquery.js"></script>

		<script src="jquery-ui/jquery-ui.js"></script>




               
</head>
<body class="hidden-sn deep-orange-skin">



