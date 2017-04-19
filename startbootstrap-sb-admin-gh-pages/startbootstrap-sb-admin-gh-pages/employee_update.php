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
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$addressError = null;
		$phone_numberError = null;
		$emailError = null;
		$payError = null;
		$hiredateError = null;
		$birthdayError = null;
		$notesError = null;
		$emergencyinfoError = null;
		
		// keep track post values
		$name = $_POST['Client_Name'];
		$address = $_POST['Address'];
		$phone_number = $_POST['Phone_Number'];
		$email = $_POST['Email'];
		$pay = $_POST['Pay'];
		$hiredate = $_POST['Hire_Date'];
		$birthday = $_POST['Birthday'];
		$notes = $_POST['Notes'];
		$emergencyinfo = $_POST['Emergency_Info'];
		
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
		
		if (empty($email)) {
			$emailError = 'Please enter email';
			$valid = false;
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}
		
		if (empty($pay)) {
			$payError = 'Please enter a Payrate';
			$valid = false;
		} else if ( $pay < 8.90 ) {
			$payError = 'Minimum wage in michigan is $8.90';
			$valid = false;
		}
		
		if (empty($hiredate)) {
			$hiredateError = 'Please enter Hire Date';
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
		
		if (empty($emergencyinfo)) {
			$emergencyinfoError = 'Please enter Emergency Info';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Employees set Staff_Name = ?,Address = ?,Phone_Number = ?,Email = ?,Pay = ?,Hire_Date = ?,Emergency_Info = ?,Birthday = ?,Notes = ? WHERE Staff_Id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$address,$phone_number,$email,$pay,$hiredate,$emergencyinfo,$birthday,$notes, $id));
			Database::disconnect();
			header("Location: employees.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Employees where Staff_Id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$name = $data['Staff_Name'];
		$address = $data['Address'];
		$phone_number = $data['Phone_Number'];
		$email = $data['Email'];
		$pay = $data['Pay'];
		$emergencyinfo = $data['Emergency_Info'];
		$hiredate = $data['Hire_Date'];
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
		    			<h3>Update an Employee</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="employee_update.php" method="post">
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="Employee_Name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
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
					      	<input name="Phone_Number" type="tel" placeholder="Phone_Number" value="<?php echo !empty($phone_number)?$phone_number:'';?>">
					      	<?php if (!empty($phone_numberError)): ?>
					      		<span class="help-inline"><?php echo $phone_numberError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					    <label class="control-label">Email</label>
					    <div class="controls">
					      	<input name="Email" type="text"  placeholder="Email" value="<?php echo !empty($email)?$email:'';?>">
					      	<?php if (!empty($emailError)): ?>
					      		<span class="help-inline"><?php echo $emailError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($payError)?'error':'';?>">
					    <label class="control-label">Pay</label>
					    <div class="controls">
					      	<input name="Pay" type="number"  placeholder="Pay" value="<?php echo !empty($pay)?$pay:'';?>">
					      	<?php if (!empty($payError)): ?>
					      		<span class="help-inline"><?php echo $payError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($hiredateError)?'error':'';?>">
					    <label class="control-label">Hire Date</label>
					    <div class="controls">
					      	<input name="Hire_Date" type="date"  placeholder="Hire_Date" value="<?php echo !empty($hiredate)?$hiredate:'';?>">
					      	<?php if (!empty($hiredateError)): ?>
					      		<span class="help-inline"><?php echo $hiredateError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($emergencyinfo)?'error':'';?>">
					    <label class="control-label">Emergency Info</label>
					    <div class="controls">
					      	<input name="Emergency_Info" type="text"  placeholder="Emergency_Info" value="<?php echo !empty($emergencyinfo)?$emergencyinfo:'';?>">
					      	<?php if (!empty($emergencyinfoError)): ?>
					      		<span class="help-inline"><?php echo $emergencyinfoError;?></span>
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