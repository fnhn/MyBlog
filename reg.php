<?php
	$charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';

	session_start();

	if(!isset($_POST['password']) || !isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['code']))
		exit;

	$username = trim($_POST['username']);
	$email = trim($_POST['email']);
	$password = $_POST['password'];
	$code = trim($_POST['code']);

	if(!$password || !$username || !$email || !$code)
		exit;

	$code = strtolower($code);
	if($code != $_SESSION['authnum_session']) {
		$data['suc'] = 0;
		$data['reason'] = 'Verify code wrong.'. $_SESSION['authnum_session'];
		echo json_encode($data);
		$_SESSION['authnum_session'] = '';

		for($i = 0; $i < 4; $i++)  {
			$_SESSION['authnum_session'] .= $charset[mt_rand(0, 49)];
		}
		exit;
	}
	$_SESSION['authnum_session'] = '';

	for($i = 0; $i < 4; $i++)  {
		$_SESSION['authnum_session'] .= $charset[mt_rand(0, 49)];
	}

	if(!get_magic_quotes_gpc()) {
		$username = addslashes($username);
		$email = addslashes($email);
	}

	@ $db = new mysqli('localhost', 'root', 'fnhn32', 'blog');

	if(mysqli_connect_errno()) {
		$data['suc'] = 0;
		$data['reason'] = 'connect to the database failed.';
		echo json_encode($data);
		exit;
	}

	$db->query("set names 'utf8'");


	//check if the username exist
	$query = "select * from User where username = '$username'";
	$result = $db->query($query);
	if($result->num_rows >= 1) {
		$data['suc'] = 0;
		$data['reason'] = "The username already exists.";
		echo json_encode($data);
		exit;
	}



	$password = md5($password);
	$reg_time = date('Y-m-d');
	$img_id = mt_rand(0, 40);

	$query = "insert into User(username, password, email, img_id, reg_time) values('$username', '$password', '$email', $img_id, '$reg_time');";
	$result = $db->query($query);

	if(!$result) {
		$data['suc'] = 0;
		$data['reason'] = 'query failed';
		echo json_encode($data);
		exit;
	}


	$db->close();

	$data['suc'] = 1;

	echo json_encode($data);
?>