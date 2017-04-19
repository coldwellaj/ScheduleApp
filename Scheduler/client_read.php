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
		header("Location: clients.html");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Clients where Client_Id = ?";
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
		    			<h3>Read Client Info</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Client</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['Client_Name'];?>
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
					    <label class="control-label">Case Number</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['Case_Number'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Case Manager</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['Case_Manager'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Hours</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['Hours'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Gaurdian</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['Gaurdian'];?>
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