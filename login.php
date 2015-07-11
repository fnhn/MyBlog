<?php
	$charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';


	session_start();
	$_SESSION['logined'] = 0;

	if(!isset($_POST['password']) || !isset($_POST['username']) || !isset($_POST['code']))
		exit;



	$password = trim($_POST['password']);
	$username = trim($_POST['username']);
	$code = trim($_POST['code']);

	if(!$password || !$username || !$code)
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

	$password = md5($password);

	if(!get_magic_quotes_gpc()) {
		$username = addslashes($username);
	}

	require('database.conf.php');

	@ $db = new mysqli($db_host, $db_username, $db_password, $db_database, $db_port);

	if(mysqli_connect_errno()) {
		$data['suc'] = 0;
		$data['reason'] = 'connect to the database failed.';
		echo json_encode($data);
		exit;
	}

	$db->query("set names 'utf8'");


	$result = $db->query("select * from User where username = '$username' and password = '$password'");

	if(!$result->num_rows) {
		$data['suc'] = 0;
		$data['reason'] = 'Username or password isn\'t correct';
		echo json_encode($data);
		exit;
	}

	$arr = $result->fetch_assoc();


	$_SESSION['logined'] = 1;
	$_SESSION['username'] = $username;
	$_SESSION['imgid'] = $arr['img_id'];
	$_SESSION['userid'] = $arr['id'];


	$data['suc'] = 1;
	$data['imgid'] = $arr['img_id'];
	$data['nickname'] = $username;
	echo json_encode($data);

?>