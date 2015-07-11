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
	<style type="text/css">
		.preview_box {
			width: 60%;
			margin: auto;
		}
		.pubButton {
			float: right;
		}
	</style>
	<script type="text/javascript" src="js/jq.js"></script>
	<script type="text/javascript">
		function pub() {
			title = $("#title").val();5
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
		function preview() {
			content = $("#content").val();
			$("#preview_box").html(content);
		}
		function insertTitle() {
			var title = prompt("Enter the title");
			if(title == null)
				return;
			content = document.getElementById("content");
			insertText(content, "<center><h1 style=\"font-size: 2.3em;\">" + title + "</h1></center>\n");
			preview();
		}
		function insertPicture() {
			var picture_name = prompt("Enter the picture name");
			if(picture_name == null)
				return;
			content = document.getElementById("content");
			insertText(content, "<center><img style=\"width:60%;margin:1%;\" src=\"source/" + picture_name + "\"/></center>\n");
			preview();
		}
		function insertParagraph() {
			var paragraph = prompt("Enter the paragraph content");
			if(paragraph == null)
				return;
			content = document.getElementById("content");
			insertText(content, "<p style=\"margin:2%\">" + paragraph + "</p>\n");
			preview();
		}
		function insertBlueFonts() {
			var blue_fonts = prompt("Enter the content");
			if(blue_fonts == null)
				return;
			content = document.getElementById("content");
			insertText(content, "<b style=\"color:rgb(21,167,240);margin:0px 2px\">" + blue_fonts + "</b>");
			preview();
		}
		function insertText(obj, str) {
			if (document.selection) {
		         var sel = document.selection.createRange();
		         sel.text = str;
		     } else if (typeof obj.selectionStart === 'number' && typeof obj.selectionEnd === 'number') {
		         var startPos = obj.selectionStart,
		             endPos = obj.selectionEnd,
		             cursorPos = startPos,
		             tmpStr = obj.value;
		         obj.value = tmpStr.substring(0, startPos) + str + tmpStr.substring(endPos, tmpStr.length);
		         cursorPos += str.length;
		         obj.selectionStart = obj.selectionEnd = cursorPos;
		     } else {
		         obj.value += str;
		     }
		}
	</script>
</head>
<body>
	<input type="text" id="title" style="width:50%" placeholder="title"/>
	<br>
	<input type="text" id="type" style="width:50%" placeholder="type"/>
	<br>
	<textarea id="content" style="width: 100%; height: 500px" placeholder="content"></textarea>
	<button onclick="preview()">Preview</button>
	<button onclick="insertTitle()">Insert Title</button>
	<button onclick="insertPicture()">Insert Picture</button>
	<button onclick="insertParagraph()">Insert Paragraph</button>
	<button onclick="insertBlueFonts()">Insert Blue Fonts</button>
	<button class="pubButton" onclick="pub()">Pub</button>
	<div class="preview_box" id="preview_box"></div>
</body>
</html>