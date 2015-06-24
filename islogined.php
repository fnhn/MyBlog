<?php
	session_start();
	if(!isset($_SESSION['logined']))
	{
		$data['message'] = 'no';
		echo json_encode($data);
		exit;
	}
	else
	{
		$data['message'] = 'yes';
		$data['nickname'] = $_SESSION['username'];
		$data['imgid'] = $_SESSION['imgid'];
		echo json_encode($data);
		exit;
	}
?>