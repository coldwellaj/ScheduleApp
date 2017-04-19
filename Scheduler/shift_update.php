<?php 
	session_start();
	require 'database.php';
	if(!isset($_SESSION['person_id'])){ // if "user" not set,
		session_destroy();
		header('Location: login.html');     // go to login page
		exit;
	}
	if ($_SESSION['person_title'] == "staff"){
		header('Location: staff_home.html'); // go to staff home
	}

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: shifts.html");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$staffError = null;
		$clientError = null;
		$time_inError = null;
		$time_outError = null;
		$dateError = null;
		
		// keep track post values
		$staff = $_POST['Staff_Id'];
		$client = $_POST['Client_Id'];
		$time_in = $_POST['Time_In'];
		$time_out = $_POST['Time_Out'];
		$date = $_POST['Date'];
		$to_do = $_POST['To_Do'];
		
		// validate input
		$valid = true;
		if (empty($staff)) {
			$staffError = 'Please enter a Staff Id';
			$valid = false;
		}
		
		if (empty($client)) {
			$clientError = 'Please enter Client Id';
			$valid = false;
		}
		
		if (empty($time_in)) {
			$time_inError = 'Please enter a Start Time';
			$valid = false;
		}
		
		if (empty($time_out)) {
			$time_outError = 'Please enter an End Time';
			$valid = false;
		}
		
		if (empty($date)) {
			$dateError = 'Please enter a Date';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Shifts  set Staff_Id = ?, Client_Id = ?, Time_In =?, Time_Out = ?, Date = ?, To_Do = ? WHERE Shift_Id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($staff,$client,$time_in,$time_out,$date,$to_do,$id));
			Database::disconnect();
			header("Location: shifts.html");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Shifts where Shift_Id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$staff = $data['Staff_Id'];
		$client = $data['Client_Id'];
		$time_in = $data['Time_In'];
		$time_out = $data['Time_Out'];
		$date = $data['Date'];
		$to_do = $data['To_Do'];
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
		    			<h3>Update a Shift</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="shift_update.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($staffError)?'error':'';?>">
					    <label class="control-label">Staff Id</label>
					    <div class="controls">
					      	<select name="Staff_Id">
								<?php
									$pdo = Database::connect();
									$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$sql = "SELECT * FROM Employees ORDER BY Staff_Id DESC";
									foreach ($pdo->query($sql) as $row) {
										echo '<option value ="' . $row['Staff_Id'] . '" >' . $row['First_Name'].
										' ' . $row['Last_Name'] . '</option>';
									}
									Database::disconnect();
								?>
							</select>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($clientError)?'error':'';?>">
					    <label class="control-label">Client Id</label>
					    <div class="controls">
					      	<select name="Client_Id">
								<?php
									$pdo = Database::connect();
									$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$sql = "SELECT * FROM Clients ORDER BY Client_Id DESC";
									foreach ($pdo->query($sql) as $row) {
										echo '<option value ="' . $row['Client_Id'] . '" >' . $row['Client_Name'] . '</option>';
									}
									Database::disconnect();
								?>
							</select>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($time_inError)?'error':'';?>">
					    <label class="control-label">Start Time</label>
					    <div class="controls">
					      	<input name="Time_In" type="text"  placeholder="Time_In" value="<?php echo !empty($time_in)?$time_in:'';?>">
					      	<?php if (!empty($time_inError)): ?>
					      		<span class="help-inline"><?php echo $time_inError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($time_outError)?'error':'';?>">
					    <label class="control-label">End Time</label>
					    <div class="controls">
					      	<input name="Time_Out" type="text"  placeholder="Time_Out" value="<?php echo !empty($time_out)?$time_out:'';?>">
					      	<?php if (!empty($time_outError)): ?>
					      		<span class="help-inline"><?php echo $time_outError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
					    <label class="control-label">Date</label>
					    <div class="controls">
					      	<input name="Date" type="text"  placeholder="Date" value="<?php echo !empty($date)?$date:'';?>">
					      	<?php if (!empty($dateError)): ?>
					      		<span class="help-inline"><?php echo $dateError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($to_doError)?'error':'';?>">
					    <label class="control-label">To Do</label>
					    <div class="controls">
					      	<input name="To_Do" type="text"  placeholder="To_Do" value="<?php echo !empty($to_do)?$to_do:'';?>">
					      	<?php if (!empty($to_doError)): ?>
					      		<span class="help-inline"><?php echo $to_doError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <input type="button" class="btn" value="Back" onclick="history.back(-1)" />
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>