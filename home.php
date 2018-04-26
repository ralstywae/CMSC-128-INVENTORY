<?php
	session_start();
	
	error_reporting(0);
	//Server Credentials
	$MyServerName = "localhost";
	$MyUserName = "root";
	$MyPassword = "";
	//Database
	$MyDBName = 'chem_glasswares';
	$MyConnection = mysqli_connect($MyServer, $MyUserName, $MyPassword, $MyDBName);
	
	//include("verify.php");
?>


<!DOCTYPE html>
<html>
<head>
	<title>Home: UPB Glasswares and Chemicals Inventory</title>
	<link rel="stylesheet" type="text/css" href="css/home.css">
	<?php 'loading head';include("head.php"); ?>
	<script src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/date_time.js"></script>
	<script src="datatables/DataTables/js/jquery.dataTables.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" charset="utf8" src="datatables/DataTables/js/dataTables.bootstrap4.js"></script>
	<link rel="stylesheet" href="datatables/DataTables/css/dataTables.bootstrap4.css">

	
</head>
<body>
		<div class="container">
			<div class="row container-fluid" style="color: black; background-color: #edeef2; border-radius: 5px; margin-bottom: 50px; border:2px solid #dbdbdb;">
				<div class="col-sm-4 timestamp" style="text-align: left !important;">
					<span id="date_time" style="color:black;"></span>
					<script type="text/javascript">window.onload = date_time('date_time');</script>
				</div>
				<div class="col-sm-4">
					Last Day of Classes: May 18, 2018
				</div>
				<div class="col-sm-4">
					Deadline of Returning:
				</div>
			</div>

			<div class="text-center" style="margin-bottom: 20px;">
					<button class="btn btn-primary" style="cursor: pointer;"><i class="fas fa-user-plus" style="font-size: 50px;"></i><br/>Add New User</button>
					<button class="btn btn-primary" style="cursor: pointer;"><i class="fas fa-user-times" style="font-size: 50px;"></i><br/>Delete User</button>
					<button class="btn btn-primary" style="cursor: pointer;"><i class="fas fa-list-ol" style="font-size: 50px;"></i><br/>Liability Table</button>
					<button class="btn btn-primary" style="cursor: pointer;"><i class="fas fa-list-alt" style="font-size: 50px;"></i><br/>Transaction Table</button>
			</div>
		
			<div class="row justify-content-between">
				<div class="col text-center">
					<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Not In Stock</h1>
				</div>
				<div class="col text-center">
					<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Insufficient Quantities</h1>
				</div>
			</div>
			<div class="row justify-content-between">
				<div class="col">
					<div style="background-color: #edeef2; border-radius: 10px; padding: 20px; height: 350px; overflow-y: scroll; border:2px solid #dbdbdb;">
	      			<table class="table table-striped table-condensed table-hover" id="nistab">
	      				<thead class="text-center">
	      					<tr>
	      						<th>ID</th>
	      						<th>Item Type</th>
	      						<th>Name</th>
	      					</tr>
	      				</thead>
	      				<tbody>
		      					<?php
		      					
								$MySearchQuery = "SELECT * FROM glasswares WHERE Quantity_Available = 0";
								$MyValues = $MyConnection -> query($MySearchQuery);
								if (($MyValues -> num_rows) > 0)
								{
										while ($MyResults = $MyValues -> fetch_assoc()) //from transaction table 
										{
											echo "<tr>";
											echo '<td>'.$MyResults['Glassware_Id'].'</td>';
											echo '<td> Glassware </td>';
											echo '<td>'.$MyResults['Name'].'</td>';
											echo "</tr>";
										}
								}
								
								$MySearchQuery = "SELECT * FROM chemicals WHERE Quantity_Available_ml =0 OR Quantity_Available_mg =0";
								$MyValues = $MyConnection -> query($MySearchQuery);
								if (($MyValues -> num_rows) > 0)
								{
									while ($MyResults = $MyValues -> fetch_assoc()) //from transaction table
									{
										echo "<tr>";					
										echo '<td>'.$MyResults['Chemical_Id'].'</td>';
										echo '<td> Chemical </td>';
										echo '<td>'.$MyResults['Name'].'</td>';
										echo "</tr>";
									}
								}	
								?>
	      				</tbody>
	      			</table>
					</div>	
				</div>
				
				<div class="col">
					<div style="background-color: #edeef2; border-radius: 10px; border-color:#d3d3d3 ; padding: 20px; height: 350px; overflow-y: scroll;border:2px solid #dbdbdb;">
						<table class="table table-striped table-condensed table-hover" id="nistab2">
	      				<thead class="text-center">
	      					<tr>
	      						<th>ID</th>
	      						<th>Item Type</th>
	      						<th>Name</th>
	      						<th>Quantity Left</th>
	      					</tr>
	      				</thead>
	      				<tbody>
		      					<?php
		      					
								$MySearchQuery = "SELECT * FROM glasswares WHERE Quantity_Available < 5 AND Quantity_Available > 0";
								$MyValues = $MyConnection -> query($MySearchQuery);
								if (($MyValues -> num_rows) > 0)
								{
										while ($MyResults = $MyValues -> fetch_assoc()) //from transaction table 
										{
											echo "<tr>";
											echo '<td>'.$MyResults['Glassware_Id'].'</td>';
											echo '<td> Glassware </td>';
											echo '<td>'.$MyResults['Name'].'</td>';
											echo '<td>'.$MyResults['Quantity_Available'].' pc/s</td>';
											echo "</tr>";
										}
								}
								
								$MySearchQuery = "SELECT * FROM chemicals WHERE (Quantity_Available_ml < 0.3*(Original_Amt) OR Quantity_Available_mg < 0.3*(Original_Amt)) AND Quantity_Available_mg > 0 AND Quantity_Available_ml > 0";
								$MyValues = $MyConnection -> query($MySearchQuery);
								if (($MyValues -> num_rows) > 0)
								{
									while ($MyResults = $MyValues -> fetch_assoc()) //from transaction table
									{
										echo "<tr>";					
										echo '<td>'.$MyResults['Chemical_Id'].'</td>';
										echo '<td> Chemical </td>';
										echo '<td>'.$MyResults['Name'].'</td>';
										echo '<td>';
										if (is_null($MyResults['Quantity_Available_ml'])){
											echo $MyResults['Quantity_Available_mg'].' mg</td>';
										}else{
											echo $MyResults['Quantity_Available_ml'].' ml</td>';
										}	
										echo "</tr>";
									}
								}	
								?>
	      				</tbody>
	      				</table>
					</div>
				</div>
		</div>
		<div class="container-fluid" style="padding-top :35px;padding-bottom :35px; margin-top:35px;margin-bottom:35px; background-color: #edeef2; border-radius: 10px; border:2px solid #dbdbdb;">
			<div class="container" style="padding: 10px;">
			<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Liabilities</h1>
			<div>
				<table class="table table-striped table-hover" id="tab_lia">
					<thead class="text-center">
						<tr>
							<th>Student Number</th>
							<th>Last Name</th>
							<th>First Name</th>
							<th>No. of Items</th>
							<th class="text-center">Details</th>
						</tr>
					</thead>
					<tbody>
								<?php
										$MySearchQuery = "SELECT * FROM borrower WHERE Amt_of_transactions > 0 LIMIT 5";
										$MyValues = $MyConnection -> query($MySearchQuery);
										if (($MyValues -> num_rows) > 0)
										{
											while ($MyResults = $MyValues -> fetch_assoc()) //from transaction table
											{		
												echo "<tr>";
												echo '<td>'.$MyResults['Student_Number'].'</td>';
												echo '<td>'.$MyResults['Last_Name'].'</td>';
												echo '<td>'.$MyResults['First_Name'].'</td>';
												echo '<td>'.$MyResults['Amt_of_transactions'].' transaction/s</td>';
												/*
													echo '
												<form role="form" action = "clear_liability.php" method="POST">
												<input class="hide" name="Student_Number" type="text" value="'.$MyResults["Student_Number"].'" />
												<input class="hide" name="Last_Name" type="text" value="'.$MyResults["Last_Name"].'" />
												<input class="hide" name="First_Name" type="text" value="'.$MyResults["First_Name"].'" />
												<td class="text-center"><input id="see_details" class="btn btn-success" style="cursor:pointer;" type="submit" value="See Details" /></td>
												</form>';
												*/
												echo '
												
												<td class="text-center">
													<button class="openmodal btn btn-success ">See Details</button>
												</td>

											
												<div class="modal see_details_modal">
												
													<div class="modal-content">
														<span class="close_modal" >&times;</span>
														<h3><strong>'.$MyResults['First_Name'].' '.$MyResults['Last_Name'].'</strong> </h3><br>
														Student Number: '. $MyResults['Student_Number'].' <br><br>

														

													</div>
												</div>
												';
												echo "</tr>";
											}
										}	
									?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-12 text-center">
			<button class="btn btn-primary" style="cursor: pointer;"> SEE FULL TABLE </button>
		</div>
		<div>
		
			<div class="col-lg-12">
			
				<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px; margin-top:35px;"><em>Transaction History for Glassware</h1>
	    	
	    		<div class="container" style="margin-bottom:35px;">
			          		<table class="table table-striped table-hover" id="tab_gla">
			          			<thead class="text-center" >
					            	<tr>
						                <th>Glassware Borrowed</th>
										<th>Amount Borrowed</th>
										<th>Date Borrowed</th>
										<th>Date Returned</th>
						                <th>Borrowers</th>
						                <th>Professor</th>
										<th>Subject </th>
										
					            	</tr>
					            </thead>
					            <tbody >
								
									<?php
										$MySearchQuery = "SELECT * FROM transaction JOIN glasswares USING (Glassware_Id) ORDER BY transaction.Date_Returned LIMIT 5";
										$MyValues = $MyConnection -> query($MySearchQuery);
										if (($MyValues -> num_rows) > 0)
										{
											while ($MyResults = $MyValues -> fetch_assoc()) //from transaction table
											{											
												echo '<tr>';
												echo '<td>'.$MyResults['Name'].'</td>';
												echo '<td>'.$MyResults['Qty_Borrowed_Glasswares'].'</td>';
												echo '<td>'.$MyResults['Date_Borrowed'].'</td>';
												if (is_null($MyResults['Date_Returned'])){
													echo '<td>'.'NOT YET RETURNED'.'</td>';
												}else{
													echo '<td>'.$MyResults['Date_Returned'].'</td>';
												}
												
												
												//get list of borrowers for this transaction
												$grp_id = $MyResults ['Group_Id'];
												$t_id = $MyResults['Trans_Id'];
											
												
												echo '<td>';
												$MySearchQuery2 = "SELECT * FROM borrower JOIN group_table USING (Group_Id) WHERE group_table.Group_Id = $grp_id";
												$MyValues2 = $MyConnection -> query($MySearchQuery2);
												while ($MyResults2 = $MyValues2 -> fetch_assoc()) 
												{											
													echo $MyResults2['Last_Name'].', '.$MyResults2['First_Name'].'<br> ';	
												}
												echo '</td>';
												
												$MySearchQuery3 = "SELECT * FROM group_table JOIN transaction USING (Group_Id) WHERE transaction.Glassware_Id>0  AND transaction.Group_Id = $grp_id AND transaction.Trans_Id = $t_id";
												$MyValues3 = $MyConnection -> query($MySearchQuery3);
											
												while ($MyResults3 = $MyValues3 -> fetch_assoc()) //from group table
												{											
													echo '<td>'.$MyResults3['Professor'].'</td>';
													echo '<td>'.$MyResults3['Subject'].'</td>';
													
												}
												
												echo '</tr>';
											}
											
											
											
											
										}
									?>
					        	</tbody>
					        </table>
				</div>
				<div class="col-sm-12 text-center">
					<button class="btn btn-primary" style="cursor: pointer;"> SEE FULL TABLE </button>
				</div>
				
				<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px; margin-top:35px;"><em>Transaction History for Chemicals</h1>
				<div class="container" style="margin-bottom:35px;">
			          		<table class="table table-striped table-hover" id="tab_che">
			          			<thead class="text-center" >
					            	<tr>
						                <th>Chemical Requested</th>
										<th>Amount (mg)</th>
										<th>Amount (ml)</th>
						                <th>Date Requested</th>
										<th>Borrowers</th>
						                <th>Professor</th>
										<th>Subject </th>
										
					            	</tr>
					            </thead>
					            <tbody >
									<?php
										$MySearchQuery = "SELECT * FROM transaction JOIN chemicals USING (Chemical_Id) ORDER BY transaction.Date_Returned LIMIT 5";
										$MyValues = $MyConnection -> query($MySearchQuery);
										if (($MyValues -> num_rows) > 0)
										{
											while ($MyResults = $MyValues -> fetch_assoc()) //from transaction table
											{											
												echo '<tr>';
												echo '<td>'.$MyResults['Name'].'</td>';
												echo '<td>'.$MyResults['Qty_Borrowed_Chemicals_mg'].'</td>';
												echo '<td>'.$MyResults['Qty_Borrowed_Chemicals_ml'].'</td>';
												echo '<td>'.$MyResults['Date_Borrowed'].'</td>';
												
												
												//get list of borrowers for this transaction
												$grp_id = $MyResults ['Group_Id'];
												$t_id = $MyResults['Trans_Id'];
												
												echo '<td>';
												$MySearchQuery2 = "SELECT * FROM borrower JOIN group_table USING (Group_Id) WHERE group_table.Group_Id = $grp_id";
												$MyValues2 = $MyConnection -> query($MySearchQuery2);
												while ($MyResults2 = $MyValues2 -> fetch_assoc()) 
												{											
													echo $MyResults2['Last_Name'].', '.$MyResults2['First_Name'].'<br> ';	
												}
												echo '</td>';
												
												$MySearchQuery3 = "SELECT * FROM group_table JOIN transaction USING (Group_Id) WHERE transaction.Chemical_Id>0  AND transaction.Group_Id = $grp_id AND transaction.Trans_Id = $t_id";
												$MyValues3 = $MyConnection -> query($MySearchQuery3);
											
												while ($MyResults3 = $MyValues3 -> fetch_assoc()) //from group table
												{											
													echo '<td>'.$MyResults3['Professor'].'</td>';
													echo '<td>'.$MyResults3['Subject'].'</td>';
													
												}//end while
												echo '</tr>';
											}
											
											
											
										}
									?>
					        	</tbody>
					        </table>
				</div>
				<div class="col-sm-12 text-center">
					<button class="btn btn-primary" style="cursor: pointer;"> SEE FULL TABLE </button>
				</div>	
			</div>	
			
			
			</div>
		</div>
	</div>
	<script>
		$('#nistab').DataTable({
			"searching":false,
			"paging":false,
			"info": false
		});
		$('#nistab2').DataTable({
			"searching":false,
			"paging":false,
			"info":false
		});
		$('#tab_lia').DataTable({
			"searching":false,
			"paging":false,
			"info":false,
		"columns":
		[
			null,
		    null,
		    null,	
		    { "orderable": false },
		    { "orderable": false }
		]
		});
		$('#tab_gla').DataTable({
			"searching":false,
			"paging":false,
			"info":false,
		"columns":
		[
			null,
			null,
		    null,
		    null,
		    null,
		    null,
		    null
		]
		});
		$('#tab_che').DataTable({
			"searching":false,
			"paging":false,
			"info":false,
		});

		//-------------Modal scripting
		var modals = document.getElementsByClassName('modal');
		var btns = document.getElementsByClassName("openmodal");
		var spans=document.getElementsByClassName("close_modal");

		for(let i=0;i<btns.length;i++){
   			 btns[i].onclick = function() {
        		modals[i].style.display = "block";
    		}
		}

		for(let i=0;i<spans.length;i++){
    		spans[i].onclick = function() {
        		modals[i].style.display = "none";
    		}	
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
		    if (event.target == modal) {
		        modal.style.display = "none";
		    }
		}
	</script>
	<?php include("footer.php")  ?>
</body>
</html>