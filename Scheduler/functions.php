<?php
	include 'database.php';
	class Functions {
		
		public function __construct() {
			exit('No constructor required for class: Functions');
		}
		
<<<<<<< HEAD

		public function print_client_table() {
=======
		public function print_client_table() {
>>>>>>> efed16512bcef278d92966c896468ac9aabfbebf
			$pdo = Database::connect();
			$sql = 'SELECT Client_Id, Client_Name, Address, Phone_Number,Case_Manager, Case_Number, Hours, Gaurdian, Birthday, Notes 
					FROM Clients';
			foreach ($pdo->query($sql) as $row) {
					echo '<tr>';
					echo '<td>'. $row['Client_Id'] . '</td>';
					echo '<td>'. $row['Client_Name'] . '</td>';
					echo '<td>'. $row['Address'] . '</td>';
					echo '<td>'. $row['Phone_Number'] . '</td>';
					echo '<td>'. $row['Case_Manager'] . '</td>';
					echo '<td>'. $row['Case_Number'] . '</td>';
					echo '<td>'. $row['Hours'] . '</td>';
					echo '<td>'. $row['Gaurdian'] . '</td>';
					echo '<td>'. $row['Birthday'] . '</td>';
					echo '<td>';
					echo '<a class="btn btn-default" href="client_read.html?id='.$row['Client_Id'].'">Read</a>';
					echo '&nbsp;';
					echo '<td>';
					echo '<a class="btn btn-primary" href="client_schedule.html?id='.$row['Client_Id'].'">Schedule</a>';
					echo '&nbsp;';
					echo '<td>';
					echo '<a class="btn btn-success" href="client_update.html?id='.$row['Client_Id'].'">Update</a>';
					echo '&nbsp;';
					echo '<td>';
					echo '<a class="btn btn-danger" href="client_delete.html?id='.$row['Client_Id'].'">Delete</a>';
					echo '</td>';
					echo '</tr>';
			}
			Database::disconnect();
		}
	}
?>
