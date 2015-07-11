<?php

	session_start();
	$data = array();

	$id = $_POST['id'];
	if(!$id)
		exit;
	
	require('database.conf.php');

	@ $db = new mysqli($db_host, $db_username, $db_password, $db_database, $db_port);
	if(mysqli_connect_errno()) {
		echo "connect database failed.";
	}
	if(!get_magic_quotes_gpc()) {
		$id = addslashes($id);
	}
	$db->query("set names 'utf8'");
	$article= $db->query("select content,time from Article where id = $id");
	$arr = $article->fetch_assoc();
	$data['content'] = stripslashes($arr['content']);
	$data['date'] = $arr['time'];

	$db->close();

	$_SESSION['articleid'] = $id;

	echo json_encode($data);
?>