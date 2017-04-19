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

	if ( !empty($_POST)) {
		// keep track validation errors
		$firstNameError = null;
		$lastNameError = null;
		$addressError = null;
		$phone_numberError = null;
		$emailError = null;
		$payError = null;
		$hiredateError = null;
		$birthdayError = null;
		$notesError = null;
		$emergencyinfoError = null;
		$titleError = null;
		$pictureError = null;
		
		
		// keep track post values
		$firstName = $_POST['First_Name'];
		$lastName = $_POST['Last_Name'];
		$address = $_POST['Address'];
		$phone_number = $_POST['Phone_Number'];
		$email = $_POST['Email'];
		$pay = $_POST['Pay'];
		$hiredate = $_POST['Hire_Date'];
		$birthday = $_POST['Birthday'];
		$notes = $_POST['Notes'];
		$emergencyinfo = $_POST['Emergency_Info'];
		$password = MD5('temp');
		$title = $_POST['Title'];
		
		// initialize $_FILES variables
		$fileName = $_FILES['picture']['name'];
		$tmpName  = $_FILES['picture']['tmp_name'];
		$fileSize = $_FILES['picture']['size'];
		$fileType = $_FILES['picture']['type'];
		$content = file_get_contents($tmpName);
		
		// validate input
		$valid = true;
		if (empty($firstName)) {
			$firstNameError = 'Please enter Employee First Name';
			$valid = false;
		}
		
		if (empty($lastName)) {
			$lastNameError = 'Please enter Employee Last Name';
			$valid = false;
		}
		
		if (empty($address)) {
			$addressError = 'Please enter Address';
			$valid = false;
		}
		
		if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone_number)) {
			$phone_numberError = 'Please write Mobile Number in form 000-000-0000';
			$valid = false;
		}
		
		if (empty($email)) {
			$emailError = 'Please enter email';
			$valid = false;
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}
		
		// do not allow 2 records with same email address!
		$pdo = Database::connect();
		$sql = "SELECT * FROM Employees";
		foreach($pdo->query($sql) as $row) {

			if($email == $row['Email']) {
				$emailError = 'Email has already been registered!';
				$valid = false;
			}
		}
		Database::disconnect();
		
		if (empty($pay)) {
			$payError = 'Please enter a Payrate';
			$valid = false;
		} else if (!is_numeric($pay)) {
			$payError = 'Please enter a number';
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
		
		if (empty($title)) {
			$titleError = 'Please select Title';
			$valid = false;
		}
		
		// restrict file types for upload
		$types = array('image/jpeg','image/png');
		if($filesize > 0) {
			if(in_array($_FILES['picture']['type'], $types)) {
			}
			else {
				$fileName = null;
				$fileType = null;
				$fileSize = null;
				$fileContent = null;
				$picture = 'improper file type';
				$valid=false;
				
			}
		}
		
	
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO Employees (First_Name,Last_Name,Address,Phone_Number,Email,Pay,Hire_Date,Emergency_Info
			,Birthday,Notes,Password,Title,File_Name,File_Type,File_Size,Content) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($firstName,$lastName,$address,$phone_number,$email,$pay,$hiredate,$emergencyinfo,$birthday
			,$notes,$password,$title,$fileName,$fileType,$fileSize,$content));
			Database::disconnect();
			header("Location: employees.html");
		}

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
	  <li role="presentation"><a href="home.html">Home</a></li>
	  <li role="presentation"><a href="client_create.html">New Client</a></li>
	  <li role="presentation" class="active"><a href="employee_create.html">New Employee</a></li>
	  <li role="presentation"><a href="shift_create.html">New Shift</a></li>
	  <li role="presentation"><a href="clients.html">View Clients</a></li>
	  <li role="presentation"><a href="employees.html">View Employees</a></li>
	  <li role="presentation"><a href="shifts.html">View All Shifts</a></li>
	  <li role="presentation"><a href="staff_profile.html">Profile</a></li>
	  <li role="presentation"><a href="logout.html">Logout</a></li>
	</ul>
    <div class="container">
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Create an Employee</h3>
		    		</div>    		
	    			<form class="form-horizontal" action="employee_create.php" method="post" enctype="multipart/form-data">
					  <div class="control-group <?php echo !empty($firstNameError)?'error':'';?>">
					    <label class="control-label">First Name</label>
					    <div class="controls">
					      	<input name="First_Name" type="text"  placeholder="First Name" value="<?php echo !empty($firstName)?$firstName:'';?>">
					      	<?php if (!empty($firstNameError)): ?>
					      		<span class="help-inline"><?php echo $firstNameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($lastNameError)?'error':'';?>">
					    <label class="control-label">Last Name</label>
					    <div class="controls">
					      	<input name="Last_Name" type="text"  placeholder="Last Name" value="<?php echo !empty($lastName)?$lastName:'';?>">
					      	<?php if (!empty($lastNameError)): ?>
					      		<span class="help-inline"><?php echo $lastNameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($titleError)?'error':'';?>">
					    <label class="control-label">Title</label>
					    <div class="controls">
					      	<select name="Title">
								<option value ="admin">Admin</option>
								<option value ="staff">Staff</option>
							</select>
					      	<?php if (!empty($titleError)): ?>
					      		<span class="help-inline"><?php echo $titleError;?></span>
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
					      	<input name="Pay" type="text"  placeholder="Pay" value="<?php echo !empty($pay)?$pay:'';?>">
					      	<?php if (!empty($payError)): ?>
					      		<span class="help-inline"><?php echo $payError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($hiredateError)?'error':'';?>">
					    <label class="control-label">Hire Date</label>
					    <div class="controls">
					      	<input name="Hire_Date" type="date"  placeholder="Hire Date" value="<?php echo !empty($hiredate)?$hiredate:'';?>">
					      	<?php if (!empty($hiredateError)): ?>
					      		<span class="help-inline"><?php echo $hiredateError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($emergencyinfo)?'error':'';?>">
					    <label class="control-label">Emergency Info</label>
					    <div class="controls">
					      	<input name="Emergency_Info" type="text"  placeholder="Emergency Info" value="<?php echo !empty($emergencyinfo)?$emergencyinfo:'';?>">
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
					  <div class="control-group <?php echo !empty($pictureError)?'error':'';?>">
						<label class="control-label">Picture</label>
						<div class="controls">
							<input type="hidden" name="MAX_FILE_SIZE" value="16000000">
							<input name="picture" type="file" id="picture">
							
						</div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						 <input type="button" class="btn" value="Back" onclick="history.back(-1)" />
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>