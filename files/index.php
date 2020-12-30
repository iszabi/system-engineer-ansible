<?php
	$link = mysqli_connect('localhost', 'dbuser', 'dbpassword', 'dbname');
	if (!$link) {
	die('Could not connect: ' . mysql_error());
	}
	echo 'Alma.com served successfully';
	mysqli_close($link);
?>
