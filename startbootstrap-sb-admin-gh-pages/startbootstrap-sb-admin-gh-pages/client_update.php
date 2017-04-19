<?php 
	session_start();
	require 'database.php';


	if(!isset($_SESSION["person_id"])){ // if "user" not set,
		session_destroy();
		header('Location: login.php');     // go to login page
		exit;
	}
	$sessionid = $_SESSION['person_id'];

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: clients.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$addressError = null;
		$phone_numberError = null;
		$case_numberError = null;
		$case_managerError = null;
		$hoursError = null;
		$gaurdianError = null;
		$birthdayError = null;
		$notesError = null;
		
		// keep track post values
		$name = $_POST['Client_Name'];
		$address = $_POST['Address'];
		$phone_number = $_POST['Phone_Number'];
		$case_number = $_POST['Case_Number'];
		$case_manager = $_POST['Case_Manager'];
		$hours = $_POST['Hours'];
		$gaurdian = $_POST['Gaurdian'];
		$birthday = $_POST['Birthday'];
		$notes = $_POST['Notes'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Client Name';
			$valid = false;
		}
		
		if (empty($address)) {
			$addressError = 'Please enter Address';
			$valid = false;
		}
		
		if (empty($phone_number)) {
			$phone_numberError = 'Please enter Phone Number';
			$valid = false;
		}
		
		if (empty($case_number)) {
			$case_numberError = 'Please enter Case Number';
			$valid = false;
		}
		
		if (empty($case_manager)) {
			$case_managerError = 'Please enter a Case Manager';
			$valid = false;
		}
		
		if (empty($hours)) {
			$hoursError = 'Please enter Hours';
			$valid = false;
		}
		
		if (empty($gaurdian)) {
			$gaurdianError = 'Please enter Gaurdian Name';
			$valid = false;
		}
		
		if (empty($birthday)) {
			$birthdayError = 'Please enter Birthday';
			$valid = false;
		}
		
		if (empty($notes)) {
			$notesError = 'Please enter Notes';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Clients set Client_Name = ?, Address = ?, Phone_Number =?, Case_Number = ?, Case_Manager = ?, Hours = ?, Gaurdian = ?, Birthday = ?, Notes = ? WHERE Client_Id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$address,$phone_number,$case_number,$case_manager,$hours,$gaurdian,$birthday,$notes,$id));
			Database::disconnect();
			header("Location: clients.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Clients where Client_Id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$name = $data['Client_Name'];
		$address = $data['Address'];
		$phone_number = $data['Phone_Number'];
		$case_number = $data['Case_Number'];
		$case_manager = $data['Case_Manager'];
		$hours = $data['Hours'];
		$gaurdian = $data['Gaurdian'];
		$birthday = $data['Birthday'];
		$notes = $data['Notes'];
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
		    			<h3>Update a Client</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="client_update.php?id=<?php echo $id?>" method="post">
					   <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="Client_Name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($addressError)?'error':'';?>">
					    <label class="control-label">Address</label>
					    <div class="controls">
					      	<input name="Address" type="text" placeholder="Address" value="<?php echo !empty($address)?$address:'';?>">
					      	<?php if (!empty($addressError)): ?>
					      		<span class="help-inline"><?php echo $addressError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($phone_numberError)?'error':'';?>">
					    <label class="control-label">Phone Number</label>
					    <div class="controls">
					      	<input name="Phone_Number" type="tel" placeholder="Phone Number" value="<?php echo !empty($phone_number)?$phone_number:'';?>">
					      	<?php if (!empty($phone_numberError)): ?>
					      		<span class="help-inline"><?php echo $phone_numberError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($case_numberError)?'error':'';?>">
					    <label class="control-label">Case Number</label>
					    <div class="controls">
					      	<input name="Case_Number" type="text"  placeholder="Case Number" value="<?php echo !empty($case_number)?$case_number:'';?>">
					      	<?php if (!empty($case_numberError)): ?>
					      		<span class="help-inline"><?php echo $case_numberError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($case_managerError)?'error':'';?>">
					    <label class="control-label">Case Manager</label>
					    <div class="controls">
					      	<input name="Case_Manager" type="text"  placeholder="Case Manager" value="<?php echo !empty($case_manager)?$case_manager:'';?>">
					      	<?php if (!empty($case_managerError)): ?>
					      		<span class="help-inline"><?php echo $case_managerError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($hoursError)?'error':'';?>">
					    <label class="control-label">Hours</label>
					    <div class="controls">
					      	<input name="Hours" type="text"  placeholder="Hours" value="<?php echo !empty($hours)?$hours:'';?>">
					      	<?php if (!empty($hoursError)): ?>
					      		<span class="help-inline"><?php echo $hoursError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($gaurdianError)?'error':'';?>">
					    <label class="control-label">Gaurdian</label>
					    <div class="controls">
					      	<input name="Gaurdian" type="text"  placeholder="Gaurdian" value="<?php echo !empty($gaurdian)?$gaurdian:'';?>">
					      	<?php if (!empty($gaurdianError)): ?>
					      		<span class="help-inline"><?php echo $gaurdianError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($birthdayError)?'error':'';?>">
					    <label class="control-label">Birthday</label>
					    <div class="controls">
					      	<input name="Birthday" type="date"  placeholder="Birthday" value="<?php echo !empty($birthday)?$birthday:'';?>">
					      	<?php if (!empty($birthdayError)): ?>
					      		<span class="help-inline"><?php echo $birthdayError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($notesError)?'error':'';?>">
					    <label class="control-label">Notes</label>
					    <div class="controls">
					      	<input name="Notes" type="text"  placeholder="Notes" value="<?php echo !empty($notes)?$notes:'';?>">
					      	<?php if (!empty($notesError)): ?>
					      		<span class="help-inline"><?php echo $notes;?></span>
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