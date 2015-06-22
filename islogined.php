<?php
	session_start();
	if(!isset($_SESSION['logined']))
	{
		echo 'no';
		exit;
	}
	else if($_SESSION['logined'] == 0)
	{
		echo 'no';
		exit;
	}
	else
	{
		echo 'yes';
		exit;
	}
?>