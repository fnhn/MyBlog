<?php
	session_start();
	
	if(!isset($_SESSION['logined']) || !isset($_SESSION['username'])) {
		echo "404 not found";
		exit;
	}
	else if(!($_SESSION['logined'] == 1 && $_SESSION['username'] == 'fnhn')) {
		echo '404 not found';
		exit;
	}
?>

<html>
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="js/jq.js"></script>
	<script type="text/javascript">
		function pub() {
			title = $("#title").val();
			content = $("#content").val();
			type = $("#type").val();
			$.post("pub.php", {
				content: content,
				title: title,
				type: type
			}).done(function(data){
				alert(data);
			});
		}
	</script>
</head>
<body>
	<input type="text" id="title" style="width:50%" placeholder="title"/>
	<input type="text" id="type" style="width:50%" placeholder="type"/>
	<h1>内容</h1>
	<textarea id="content" style="width: 100%; height: 500px" placeholder="content"></textarea>
	<button onclick="pub()">Pub</button>
</body>
</html>