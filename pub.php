<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();

	echo "done1";
	
	if(!isset($_SESSION['logined']) || !isset($_SESSION['username'])) {
		echo "404 not found";
		exit;
	}
	else if(!($_SESSION['logined'] == 1 && $_SESSION['username'] == 'fnhn')) {
		echo '404 not found';
		exit;
	}

	$content = $_POST['content'];
	$title = $_POST['title'];
	$type = $_POST['type'];

	require('database.conf.php');

	@ $db = new mysqli($db_host, $db_username, $db_password, $db_database, $db_port);

	if(mysqli_connect_errno()) {
		echo "connect database failed.";
	}

	if(!get_magic_quotes_gpc()) {
		$content = addslashes($content);
		$title = addslashes($title);
		$type = addslashes($type);
	}

	$db->query("set names 'utf8'");

	//if type exists
	$result = $db->query("select * from Type where content = '$type'");
	if($result->num_rows == 0) {
		$db->query("insert into Type(content) values('$type')");
	}
	$result = $db->query("select id from Type where content = '$type'");
	$typeid = $result->fetch_assoc()['id'];
	$pub_time = date("Y-m-d");

	
	$db->query("insert into Article(title, content, auth, time, typeid) values('$title', '$content', 'fnhn', '$pub_time', $typeid)");
	$db->close();
?>