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
    			<h3>Lead Staff Home</h3>
    		</div>
			<div class="row">
				<p>
					<a href="client_create.php" class="btn btn-success">New Client</a>
					<a href="employee_create.php" class="btn btn-success">New Employee</a>
					<a href="shift_create.php" class="btn btn-success">New Shift</a>
				</p>
					<a href="clients.php" class="btn btn-success">View Clients</a>
					<a href="employees.php" class="btn btn-success">View Employees</a>
					<a href="shifts.php" class="btn btn-success">View All Shifts</a>
				<p>
				</p>
    	</div>
    </div> <!-- /container -->
  </body>
</html>