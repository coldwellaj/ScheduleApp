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
	  <li role="presentation""><a href="home.html">Home</a></li>
	  <li role="presentation"><a href="client_create.html">New Client</a></li>
	  <li role="presentation"><a href="employee_create.html">New Employee</a></li>
	  <li role="presentation"><a href="shift_create.html">New Shift</a></li>
	  <li role="presentation"><a href="clients.html">View Clients</a></li>
	  <li role="presentation"><a href="employees.html">View Employees</a></li>
	  <li role="presentation"><a href="shifts.html">View All Shifts</a></li>
	  <li role="presentation"><a href="staff_profile.html">Profile</a></li>
	  <li role="presentation"><a href="logout.html">Logout</a></li>
	</ul>
    <div class="container">
    		<div class="row">
    			<h3>Client Schedule</h3>
    		</div>				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Shift Id</th>
		                  <th>Staff</th>
		                  <th>Time In</th>
						  <th>Time Out</th>
						  <th>Date</th>
						  <th>To Do</th>
						  <th>Read</th>
						  <th>Update</th>
						  <th>Delete</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $id = null;
					   if ( !empty($_GET['id'])) {
					   $id = $_REQUEST['id'];
					   }
					   
					   $sql = 'SELECT Shifts.Shift_Id, Employees.First_Name, Employees.Last_Name, Clients.Client_Name, Shifts.Time_In, Shifts.Time_Out, Shifts.Date, Shifts.To_Do 
								FROM Shifts 
								INNER JOIN Employees 
								ON Shifts.Staff_Id=Employees.Staff_Id 
								INNER JOIN Clients 
								ON Shifts.Client_Id=Clients.Client_Id
								WHERE Clients.Client_Id =' . $id;
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['Shift_Id'] . '</td>';
							   	echo '<td>'. $row['First_Name'] . ' ' . $row['Last_Name']. '</td>';
								echo '<td>'. $row['Time_In'] . '</td>';
								echo '<td>'. $row['Time_Out'] . '</td>';
								echo '<td>'. $row['Date'] . '</td>';
								echo '<td>'. $row['To_Do'] . '</td>';
							   	echo '<td>';
							   	echo '<a class="btn btn-default" href="shift_read.html?id='.$row['Shift_Id'].'">Read</a>';
							   	echo '&nbsp;';
								echo '<td>';
							   	echo '<a class="btn btn-success" href="shift_update.html?id='.$row['Shift_Id'].'">Update</a>';
							   	echo '&nbsp;';
								echo '<td>';
							   	echo '<a class="btn btn-danger" href="shift_delete.html?id='.$row['Shift_Id'].'">Delete</a>';
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