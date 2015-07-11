<?php

	$data = array();
	

	require('database.conf.php');

	@ $db = new mysqli($db_host, $db_username, $db_password, $db_database, $db_port);
	if(mysqli_connect_errno()) {
		echo "connect database failed.";
	}
	$db->query("set names 'utf8'");
	$type_list = $db->query("select * from Type");
	$limit = $type_list->num_rows;
	for($i = 0; $i < $limit; $i++) {
		$arr = $type_list->fetch_assoc();
		$data[$arr['id']] = htmlspecialchars(stripslashes($arr['content']));
	}

	echo json_encode($data, 0);
?>