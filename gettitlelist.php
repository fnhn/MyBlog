<?php

	$data = array();

	$typeid = $_POST['typeid'];
	if(!$typeid)
		exit;
	

	require('database.conf.php');

	@ $db = new mysqli($db_host, $db_username, $db_password, $db_database, $db_port);
	if(mysqli_connect_errno()) {
		echo "connect database failed.";
	}
	if(!get_magic_quotes_gpc()) {
		$typeid = addslashes($typeid);
	}
	$db->query("set names 'utf8'");
	$type_list = $db->query("select id, title from Article where typeid = $typeid");
	$limit = $type_list->num_rows;
	for($i = 0; $i < $limit; $i++) {
		$arr = $type_list->fetch_assoc();
		$data[$arr['id']] = htmlspecialchars(stripslashes($arr['title']));
	}

	echo json_encode($data, 0);
?>