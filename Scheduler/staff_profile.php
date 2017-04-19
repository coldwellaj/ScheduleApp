<?php 
	session_start();
	require 'database.php';
	if(!isset($_SESSION['person_id'])){ // if "user" not set,
		session_destroy();
		header('Location: login.html');     // go to login page
		exit;
	}
	$id = null;
	if ( !empty($_SESSION['person_id'])) {
		$id = $_SESSION['person_id'];
	}
	
	if ( null==$id ) {
		header("Location: employees.html");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Employees 
				WHERE Staff_Id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
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
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Employee Profile For <?php echo $data['First_Name']?></h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Picture</label>
					    <div class="controls ">
							<?php 
							if ($data['File_Size'] > 0) 
								echo '<img  height=10%; width=30%; src="data:image/jpeg;base64,' . 
									base64_encode( $data['Content'] ) . '" />'; 
							else 
								echo 'No photo on file.';
							?><!-- converts to base 64 due to the need to read the binary files code and display img -->
					  </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Staff</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['First_Name'] . ' ' . $data['Last_Name'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Address</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['Address'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Phone Number</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['Phone_Number'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Pay</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo '$' . $data['Pay'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Hire Date</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['Hire_Date'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Birthday</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['Birthday'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Emergency Info</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['Emergency_Info'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Notes</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['Notes'];?>
						    </label>
					    </div>
					  </div>
					    <div class="form-actions">
							<a href="staff_register.html" class="btn btn-success">Edit Profile</a>
							<input type="button" class="btn" value="Back" onclick="history.back(-1)" />
					   </div>
					
					 
					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>