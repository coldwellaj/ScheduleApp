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
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$addressError = null;
		$phone_numberError = null;
		$emailError = null;
		$birthdayError = null;
		$emergencyinfoError = null;
		$pictureError = null;
		$passwordError = null;
		$passwordconfirmError = null;
		
		// keep track post values
		$address = $_POST['Address'];
		$phone_number = $_POST['Phone_Number'];
		$email = $_POST['Email'];
		$birthday = $_POST['Birthday'];
		$emergencyinfo = $_POST['Emergency_Info'];
		$password = md5($_POST['Password']);
		$passwordconfirm = md5($_POST['Confirm_Password']);
		
		// initialize $_FILES variables
		$fileName = $_FILES['picture']['name'];
		$tmpName  = $_FILES['picture']['tmp_name'];
		$fileSize = $_FILES['picture']['size'];
		$fileType = $_FILES['picture']['type'];
		$content = file_get_contents($tmpName);
		
		// validate input
		$valid = true;
		
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
		
		if (empty($birthday)) {
			$birthdayError = 'Please enter Birthday';
			$valid = false;
		}
		
		if (empty($emergencyinfo)) {
			$emergencyinfoError = 'Please enter Emergency Info';
			$valid = false;
		}
		
		if ($password == 'd41d8cd98f00b204e9800998ecf8427e') {
			$password = null;
			$passwordError = 'Please enter password';
			$valid = false;
		}
		else
		{
			if ($password != $passwordconfirm) {
			$password = null;
			$passwordconfirm = null;
			$passwordError = 'Your two passwords do not match';
			$passwordconfirmError = 'Your two passwords do not match';
			$valid = false;
		}
		}
		
		if ($passwordconfirm == 'd41d8cd98f00b204e9800998ecf8427e') {
			$passwordconfirm = null;
			$passwordconfirmError = 'Please confirm password';
			$valid = false;
		}
		else
		{
			if ($password != $passwordconfirm) {
			$password = null;
			$passwordconfirm = null;
			$passwordError = 'Your two passwords do not match';
			$passwordconfirmError = 'Your two passwords do not match';
			$valid = false;
			}
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
				$pictureError = 'improper file type';
				$valid=false;
				
			}
		}
		
		
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Employees set Address = ?,Phone_Number = ?,Email = ?,Emergency_Info = ?,Birthday = ?,
			Password = ?,File_Name = ?,File_Type = ?,File_Size = ?,Content = ? WHERE Staff_Id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($address,$phone_number,$email,$emergencyinfo,$birthday,$password,
			$fileName,$fileType,$fileSize,$content, $id));
			Database::disconnect();
			if ($_SESSION['person_title'] == "admin") {
				header("Location: home.html");
			}
			else {
				header("Location: staff_home.html");
			}
			
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Employees where Staff_Id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$address = $data['Address'];
		$phone_number = $data['Phone_Number'];
		$email = $data['Email'];
		$emergencyinfo = $data['Emergency_Info'];
		$birthday = $data['Birthday'];
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
		    			<h3>Update <?php echo $_SESSION['person_first_name'] . ' ' . $_SESSION['person_last_name']?>'s Profile</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="staff_register.php" method="post" enctype="multipart/form-data">
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
					  <div class="control-group <?php echo !empty($emergencyinfoError)?'error':'';?>">
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
					  <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					    <label class="control-label">Password</label>
					    <div class="controls">
					      	<input name="Password" type="password" placeholder="Password" value="<?php echo null;?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($passwordconfirmError)?'error':'';?>">
					    <label class="control-label">Confirm Password</label>
					    <div class="controls">
					      	<input name="Confirm_Password" type="password" placeholder="Confirm Password" value="<?php echo null;?>">
					      	<?php if (!empty($passwordconfirmError)): ?>
					      		<span class="help-inline"><?php echo $passwordconfirmError;?></span>
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
						  <button type="submit" class="btn btn-success">Update</button>
						  <input type="button" class="btn" value="Back" onclick="history.back(-1)" />
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>