<?php 
	session_start();
	require 'database.php';
	if(!isset($_SESSION['person_id'])){ // if "user" not set,
		session_destroy();
		header('Location: login.php');     // go to login page
		exit;
	}
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: employees.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT Staff_Name,Address,Phone_Number,Email,Pay,Hire_Date,Birthday,Emergency_Info,Notes
								FROM Employees 
								where Staff_Id = ?";
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
		    			<h3>Read Employee Info</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Staff</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['Staff_Name'];?>
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
						  <input type="button" class="btn" value="Back" onclick="history.back(-1)" />
					   </div>
					
					 
					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>