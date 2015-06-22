<?php

	$data = array();

	$typeid = $_POST['typeid'];
	if(!$typeid)
		exit;
	

	@ $db = new mysqli('localhost', 'root', 'fnhn32', 'blog');
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