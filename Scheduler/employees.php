<?php
	session_start();
	if(!isset($_SESSION['person_id'])){ // if "user" not set,
		session_destroy();
		header('Location: login.html');     // go to login page
		exit;
	}
	if ($_SESSION['person_title'] == "staff"){
		header('Location: staff_home.html'); // go to staff home
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
	<ul class="nav nav-pills nav-justified">
	  <li role="presentation"><a href="home.html">Home</a></li>
	  <li role="presentation"><a href="client_create.html">New Client</a></li>
	  <li role="presentation"><a href="employee_create.html">New Employee</a></li>
	  <li role="presentation"><a href="shift_create.html">New Shift</a></li>
	  <li role="presentation"><a href="clients.html">View Clients</a></li>
	  <li role="presentation" class="active"><a href="employees.html">View Employees</a></li>
	  <li role="presentation"><a href="shifts.html">View All Shifts</a></li>
	  <li role="presentation"><a href="staff_profile.html">Profile</a></li>
	  <li role="presentation"><a href="logout.html">Logout</a></li>
	</ul>
    <div class="container">
    		<div class="row">
    			<h3>Employee List</h3>
    		</div>
			<div class="row">
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
						  <th>Schedule</th>
						  <th>Update</th>
						  <th>Delete</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT  Staff_Id, First_Name, Last_Name, Address, Phone_Number, Email, Pay, Hire_Date, Birthday
								FROM Employees';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['First_Name'] .' ' . $row['Last_Name'] . '</td>';
							   	echo '<td>'. $row['Address'] . '</td>';
								echo '<td>'. $row['Phone_Number'] . '</td>';
								echo '<td>'. $row['Email'] . '</td>';
								echo '<td>$'. $row['Pay'] . '</td>';
								echo '<td>'. $row['Hire_Date'] . '</td>';
								echo '<td>'. $row['Birthday'] . '</td>';
							   	echo '<td>';
							   	echo '<a class="btn btn-default" href="employee_read.html?id='.$row['Staff_Id'].'">Read</a>';
								echo '&nbsp;';
								echo '<td>';
							   	echo '<a class="btn btn-primary" href="employee_schedule.html?id='.$row['Staff_Id'].'">Schedule</a>';
							   	echo '&nbsp;';
								echo '<td>';
								echo '<a class="btn btn-success" href="employee_update.html?id='.$row['Staff_Id'].'">Update</a>';
								echo '&nbsp;';
								echo '<td>';
							   	echo '<a class="btn btn-danger" href="employee_delete.html?id='.$row['Staff_Id'].'">Delete</a>';
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