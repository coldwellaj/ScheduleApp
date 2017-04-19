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
					<a href="employee_create.php" class="btn btn-success">Create Employee</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Staff Name</th>
		                  <th>Address</th>
		                  <th>Phone Number</th>
						  <th>Email</th>
						  <th>Pay</th>
						  <th>Hire Date</th>
						  <th>Birthday</th>
						  <th>Read</th>
						  <th>Update</th>
						  <th>Schedule</th>
						  <th>Delete</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT  Staff_Id, Staff_Name, Address, Phone_Number, Email, Pay, Hire_Date, Birthday
								FROM Employees';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['Staff_Name'] . '</td>';
							   	echo '<td>'. $row['Address'] . '</td>';
								echo '<td>'. $row['Phone_Number'] . '</td>';
								echo '<td>'. $row['Email'] . '</td>';
								echo '<td>'. $row['Pay'] . '</td>';
								echo '<td>'. $row['Hire_Date'] . '</td>';
								echo '<td>'. $row['Birthday'] . '</td>';
							   	echo '<td>';
							   	echo '<a class="btn" href="employee_read.php?id='.$row['Staff_Id'].'">Read</a>';
								echo '&nbsp;';
								echo '<td>';
							   	echo '<a class="btn btn-success" href="employee_update.php?id='.$row['Staff_Id'].'">Update</a>';
								echo '&nbsp;';
								echo '<td>';
							   	echo '<a class="btn btn-success" href="employee_schedule.php?id='.$row['Staff_Id'].'">Employee Schedule</a>';
							   	echo '&nbsp;';
								echo '<td>';
							   	echo '<a class="btn btn-danger" href="employee_delete.php?id='.$row['Staff_Id'].'">Delete</a>';
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