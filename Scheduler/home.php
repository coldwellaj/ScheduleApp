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
	  <li role="presentation" class="active"><a href="home.html">Home</a></li>
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
    			<h3>Lead Staff Home</h3>
    		</div>
			<div class="row">
				<p>
					<a href="client_create.html" class="btn btn-success">New Client</a>
					<a href="employee_create.html" class="btn btn-success">New Employee</a>
					<a href="shift_create.html" class="btn btn-success">New Shift</a>
				</p>
					<a href="clients.html" class="btn btn-success">View Clients</a>
					<a href="employees.html" class="btn btn-success">View Employees</a>
					<a href="shifts.html" class="btn btn-success">View All Shifts</a>
				<p>
				</p>
    	</div>
    </div> <!-- /container -->
  </body>
</html>