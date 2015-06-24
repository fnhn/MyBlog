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

	$content = $_POST['content'];

	if(!get_magic_quotes_gpc()) {
		$content = addslashes($content);
	}

	require('tools/xss.php');
	$content = RemoveXSS($content);

	$articleid = $_SESSION['articleid'];
	$userid = $_SESSION['userid'];
	$time = date("H:m:s");
	$date = date("Y-m-d");

	@ $db = new mysqli('localhost', 'root', 'fnhn32', 'blog');

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