<?php

	$digits = $_GET['number'];
	$sum = 0;
	
	for ($i=0; $i<strlen($digits); $i++) {
		$sum += $digits[$i];
	}
	echo "The sum of the digits of $digits is " . ($sum);
?>