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
					<a href="employees.php" class="btn btn-success">Employees</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Shift Id</th>
		                  <th>Staff</th>
		                  <th>Client</th>
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
					   
					   $sql = 'SELECT Shifts.Shift_Id, Employees.Staff_Name, Clients.Client_Name, Shifts.Time_In, Shifts.Time_Out, Shifts.Date, Shifts.To_Do 
								FROM Shifts 
								INNER JOIN Employees 
								ON Shifts.Staff_Id=Employees.Staff_Id 
								INNER JOIN Clients 
								ON Shifts.Client_Id=Clients.Client_Id
								WHERE Employees.Staff_Id = ' . $id;
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['Shift_Id'] . '</td>';
							   	echo '<td>'. $row['Staff_Name'] . '</td>';
							   	echo '<td>'. $row['Client_Name'] . '</td>';
								echo '<td>'. $row['Time_In'] . '</td>';
								echo '<td>'. $row['Time_Out'] . '</td>';
								echo '<td>'. $row['Date'] . '</td>';
								echo '<td>'. $row['To_Do'] . '</td>';
							   	echo '<td>';
							   	echo '<a class="btn" href="shift_read.php?id='.$row['Shift_Id'].'">Read</a>';
							   	echo '&nbsp;';
								echo '<td>';
							   	echo '<a class="btn btn-success" href="shift_update.php?id='.$row['Shift_Id'].'">Update</a>';
							   	echo '&nbsp;';
								echo '<td>';
							   	echo '<a class="btn btn-danger" href="shift_delete.php?id='.$row['Shift_Id'].'">Delete</a>';
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