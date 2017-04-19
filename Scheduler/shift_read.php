<?php 
	session_start();
	require 'database.php';
	if(!isset($_SESSION['person_id'])){ // if "user" not set,
		session_destroy();
		header('Location: login.html');     // go to login page
		exit;
	}
	
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: shifts.html");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT Employees.First_Name, Employees.Last_Name, Clients.Client_Name, 
				Shifts.Time_In, Shifts.Time_Out, Shifts.Date, Shifts.To_Do 
				FROM Shifts 
				INNER JOIN Employees 
				ON Shifts.Staff_Id=Employees.Staff_Id 
				INNER JOIN Clients 
				ON Shifts.Client_Id=Clients.Client_Id
				where Shifts.Shift_Id = ?";
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
		    			<h3>Read a Shift</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Staff</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['First_Name'] . ' ' . $data['Last_Name'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Client</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['Client_Name'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Time In</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['Time_In'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Time Out</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['Time_Out'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Date</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['Date'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">To Do</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['To_Do'];?>
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