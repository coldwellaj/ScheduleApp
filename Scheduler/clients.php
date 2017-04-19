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
	  <li role="presentation" class="active"><a href="clients.html">View Clients</a></li>
	  <li role="presentation"><a href="employees.html">View Employees</a></li>
	  <li role="presentation"><a href="shifts.html">View All Shifts</a></li>
	  <li role="presentation"><a href="staff_profile.html">Profile</a></li>
	  <li role="presentation"><a href="logout.html">Logout</a></li>
	</ul>
    <div class="container">
    		<div class="row">
    			<h3>Clients List</h3>
    		</div>
			<div class="row">
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
						  <th>Client Schedule</th>
						  <th>Update</th>
						  <th>Delete</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
<<<<<<< HEAD
						include 'functions.php';
						Functions::print_client_table();
=======
						include 'functions.php';
						Functions::print_clients_table();
>>>>>>> efed16512bcef278d92966c896468ac9aabfbebf
					  ?>
				      </tbody>
	            </table>
    	</div>
    </div> <!-- /container -->
  </body>
</html>
