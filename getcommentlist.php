<?php
	$data = array();

	if(!isset($_POST['articleid'])) {
		exit;
	}

	$articleid = $_POST['articleid'];


	require('database.conf.php');

	@ $db = new mysqli($db_host, $db_username, $db_password, $db_database, $db_port);
	if(mysqli_connect_errno()) {
		$data['suc'] = 0;
		$data['reason'] = 'connect to the database failed.';
		echo json_encode($data);
		exit;
	}

	$db->query("set names 'utf8'");

	$result = $db->query("select * from Comment where article_id = '$articleid' order by date asc,time asc;");

	$limit = $result->num_rows;

	for($i = 0; $i < $limit; $i++) {
		$arr = $result->fetch_assoc();

		$userid = $arr['user_id'];
		$result1 = $db->query("select username, img_id from User where id = '$userid'");
		$arr1 = $result1->fetch_assoc();
		$username = $arr1['username'];
		$imgid = $arr1['img_id'];

		$data[$i] = array(
			'nickname'		=> stripslashes($username),
			'date'			=> $arr['date'],
			'time'			=> $arr['time'],
			'content'		=> stripslashes($arr['content']),
			'imgid'			=> $imgid
		);
	}	

	$db->close();

	echo json_encode($data);

?>