Zippy Dee<br/>
<?php
	echo "<strong> Hello World <br/>Hows It \"Going\" World<br/></strong>";
	# echo '<strong> Hello World <br/>Hows It \"Going\" World</strong>';
	
	$a = 1;
	$b = 1.5;
	$c = "hello";
	$d = false;
	$e = array(1, 2, 3, 4, 5);
	# $f = hello;
	$g = null;
	
	echo "<br/> a + b equals " . ($a + $b);
	echo "<br/> b + c equals " . ($b + $c);
	echo "<br/> c + d equals " . ($c + $d);
	
	// add up the digits of $digits
	$digits = "1111111";
	$sum = 0;
	
	for ($i=0; $i<strlen($digits); $i++) {
		$sum += $digits[$i];
	}
	echo "<br /> The sum of the digits of $digits is " . ($sum);
?>