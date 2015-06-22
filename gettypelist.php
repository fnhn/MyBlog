<?php

	$data = array();
	

	@ $db = new mysqli('localhost', 'root', 'fnhn32', 'blog');
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