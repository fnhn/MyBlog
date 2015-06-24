<?php

	session_start();
	$data = array();

	$id = $_POST['id'];
	if(!$id)
		exit;
	

	@ $db = new mysqli('localhost', 'root', 'fnhn32', 'blog');
	if(mysqli_connect_errno()) {
		echo "connect database failed.";
	}
	if(!get_magic_quotes_gpc()) {
		$id = addslashes($id);
	}
	$db->query("set names 'utf8'");
	$article= $db->query("select content from Article where id = $id");
	$arr = $article->fetch_assoc();
	$data['content'] = stripslashes($arr['content']);

	$db->close();

	$_SESSION['articleid'] = $id;

	echo json_encode($data);
?>