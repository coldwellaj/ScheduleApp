<?php
// Start or resume session, and create: $_SESSION[] array
session_start(); 

require 'database.php';

if ( !empty($_POST)) { // if $_POST filled then process the form

	// initialize $_POST variables
	$username = $_POST['username']; // username is email address
	$password = $_POST['password'];
	
	$passwordhash = MD5($password);
		
	// verify the username/password
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM Employees WHERE Email = ? AND Password = ? LIMIT 1";
	$q = $pdo->prepare($sql);
	$q->execute(array($username,$passwordhash));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	
	if($data) { // if successful login set session variables
		echo "success!";
		$_SESSION['person_id'] = $data['Staff_Id'];
		$_SESSION['person_title'] = $data['Title'];
		$_SESSION['person_first_name'] = $data['First_Name'];
		$_SESSION['person_last_name'] = $data['Last_Name'];
		Database::disconnect();
		if ($data['Title'] == "admin")
		{
			header("Location: home.html");
		}
		elseif ($data['Title'] == "staff")
		{
			if ($data['Password'] == MD5("temp"))
			{
				header("Location: staff_register.html");
			}
			else
			{
				header("Location: staff_home.html");
			}
		}
		
	}
	else { // otherwise go to login error page
		Database::disconnect();
		header("Location: login_error.html");
	}
} 
// if $_POST NOT filled then display login form, below.

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

		<div class="span10 offset1">		
			<div class="row">
				<h3>Login</h3>
			</div>
	
			<form class="form-horizontal" action="login.php" method="post">
								  
				<div class="control-group">
					<label class="control-label">Email</label>
					<div class="controls">
						<input name="username" type="text"  placeholder="Email" required>
					</div>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->
				
				<div class="control-group">
					<label class="control-label">Password</label>
					<div class="controls">
						<input name="password" type="password" placeholder="password" required>
					</div>	
				</div> 

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Sign in</button>
				</div>
				
			</form>
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->

  </body>
  
</html>
	

	