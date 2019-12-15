<?php
	Session_start();
	unset($_SESSION['userId']);
	header('Location: index.php');
	exit();
 ?>	