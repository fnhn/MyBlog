<?php
	session_start();
	if(!isset($_POST['content']))
		exit;
	if(!isset($_SESSION['logined']))
	{
		$data['suc'] = 0;
		$data['reason'] = 'You haven\' login yet.';
		echo json_encode($data);
		exit;
	}

	$content = trim($_POST['content']);

	if(!$content) {
		$data['suc'] = 0;
		$data['reason'] = 'You can not send a empty message.';
		echo json_encode($data);
		exit;
	}

	if(!get_magic_quotes_gpc()) {
		$content = addslashes($content);
	}

	require('tools/xss.php');
	$content = RemoveXSS($content);

	$articleid = $_SESSION['articleid'];
	$userid = $_SESSION['userid'];
	$time = date("H:i:s");
	$date = date("Y-m-d");

	require('database.conf.php');

	@ $db = new mysqli($db_host, $db_username, $db_password, $db_database, $db_port);

	if(mysqli_connect_errno()) {
		$data['suc'] = 0;
		$data['reason'] = 'connect to the database failed.';
		echo json_encode($data);
		exit;
	}

	$db->query("set names 'utf8'");
	$db->query("insert into Comment(article_id, user_id, content, date, time) values($articleid, $userid, '$content', '$date', '$time')");

	$data['suc'] = 1;

	echo json_encode($data);


?>