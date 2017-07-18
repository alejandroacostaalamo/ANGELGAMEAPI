<?php
	
	session_start();

	$_SESSION['metodo']=$_GET['metodo'];

	echo 'metodo cambiado';

?>