<?php
session_start();
if(!isset($_SESSION['person_id'])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');     // go to login page
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    		<div class="row">
    			<h3>PHP CRUD Grid</h3>
    		</div>
			<div class="row">
				<p>
					<a href="home.php" class="btn btn-success">Home</a>
					<a href="client_create.php" class="btn btn-success">Create Client</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Client Id</th>
		                  <th>Client Name</th>
		                  <th>Address</th>
		                  <th>Phone Number</th>
						  <th>Case Manager</th>
						  <th>Case Number</th>
						  <th>Hours</th>
						  <th>Gaurdian</th>
						  <th>Birthday</th>
						  <th>Read</th>
						  <th>Update</th>
						  <th>Client Schedule</th>
						  <th>Delete</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT Client_Id, Client_Name, Address, Phone_Number,Case_Manager, Case_Number, Hours, Gaurdian, Birthday, Notes 
								FROM Clients';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['Client_Id'] . '</td>';
							   	echo '<td>'. $row['Client_Name'] . '</td>';
							   	echo '<td>'. $row['Address'] . '</td>';
								echo '<td>'. $row['Phone_Number'] . '</td>';
								echo '<td>'. $row['Case_Manager'] . '</td>';
								echo '<td>'. $row['Case_Number'] . '</td>';
								echo '<td>'. $row['Hours'] . '</td>';
								echo '<td>'. $row['Gaurdian'] . '</td>';
								echo '<td>'. $row['Birthday'] . '</td>';
							   	echo '<td>';
							   	echo '<a class="btn" href="client_read.php?id='.$row['Client_Id'].'">Read</a>';
							   	echo '&nbsp;';
								echo '<td>';
							   	echo '<a class="btn btn-success" href="client_update.php?id='.$row['Client_Id'].'">Update</a>';
								echo '&nbsp;';
								echo '<td>';
							   	echo '<a class="btn btn-success" href="client_schedule.php?id='.$row['Client_Id'].'">Schedule</a>';
							   	echo '&nbsp;';
								echo '<td>';
							   	echo '<a class="btn btn-danger" href="client_delete.php?id='.$row['Client_Id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
    	</div>
    </div> <!-- /container -->
  </body>
</html>