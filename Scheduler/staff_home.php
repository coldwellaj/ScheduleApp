<?php
session_start();
if(!isset($_SESSION['person_id'])){ // if "user" not set,
	session_destroy();
	header('Location: login.html');     // go to login page
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
	<ul class="nav nav-pills nav-justified">
	  <li role="presentation" class="active"><a href="staff_home.html">Home</a></li>
	  <li role="presentation"><a href="staff_profile.html">Profile</a></li>
	  <li role="presentation"><a href="logout.html">Logout</a></li>
	</ul>
    <div class="container">
    		<div class="row">
    			<h3>Employee Schedule</h3>
    		</div>
			<div class="row">
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Shift Id</th>
		                  <th>Client</th>
		                  <th>Time In</th>
						  <th>Time Out</th>
						  <th>Date</th>
						  <th>To Do</th>
						  <th>Read</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   
					   $id = null;
					   if ( !empty($_SESSION['person_id'])) {
					   $id = $_SESSION['person_id'];
					   }
					   
					   $sql = 'SELECT Shifts.Shift_Id, Clients.Client_Name, Shifts.Time_In, Shifts.Time_Out, Shifts.Date, Shifts.To_Do 
								FROM Shifts 
								INNER JOIN Employees 
								ON Shifts.Staff_Id=Employees.Staff_Id 
								INNER JOIN Clients 
								ON Shifts.Client_Id=Clients.Client_Id
								WHERE Employees.Staff_Id = ' . $id;
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['Shift_Id'] . '</td>';
							   	echo '<td>'. $row['Client_Name'] . '</td>';
								echo '<td>'. $row['Time_In'] . '</td>';
								echo '<td>'. $row['Time_Out'] . '</td>';
								echo '<td>'. $row['Date'] . '</td>';
								echo '<td>'. $row['To_Do'] . '</td>';
							   	echo '<td>';
							   	echo '<a class="btn btn-default" href="shift_read.html?id='.$row['Shift_Id'].'">Read</a>';
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