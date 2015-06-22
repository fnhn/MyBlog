<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta charset="utf-8">
	<style type="text/css">
		* {
			margin: 0px;
			padding: 0px;
			font-family: '微软雅黑';
		}
		a {
			text-decoration: none;
		}
		a img {
			border: none;
		}
		.sidebar {
			position: fixed;
			width: 3%;
			height: 100%;
			background-color: rgb(47, 47, 47);
		}
		.sidebar li {
			padding: 20% 20%;
		}
		.sidebar li:hover {
			background-color: rgb(39, 40, 34);
		}
		.sidebar li img {
			width: 100%;
			padding: 20% 0%;
		}
		.container {
			width: 97%;
			padding-left: 3%;
		}
		.content {
			width: 70%;
			margin: auto;
			padding-top: 4%;
			display: none;
		}
		.loginbox {
			text-align: center;
			display: none;
		}
		.loginbox p {
			padding-top: 3%;
			text-align: center;
		}
		.loginbox h1 {
			color: rgb(117, 184, 0);
			font-size: 5.0em;
		}
		.inputbox {
			display: inline-block;
			margin-top: 2%;
			width: 60%;
			
			border-right: none;
			border-left: none;
			border-top: none;
			border-bottom: solid rgb(117, 185, 0) 3px;
			border-radius: 3px;
			font-size: 2.3em;
		}
		.btn {
			display: inline-block;
			line-height: 3.0em;
			width: 4%;
			background-color: rgb(117, 185, 0);
			border: none;
		}
		.guide {
			text-align: right;
			font-size: 1.1em;
			color: gray;
			padding-bottom: 7%;
		}
		.guide span {
			color: rgb(117, 185, 0);
		}

		.home {
			width: 97%;
			padding-left: 3%;
			text-align: center;
			padding-top: 20%;
			font-size: 5.0em;
			color: rgb(117, 185, 0);
			display: none;
		}

		.articlelist {
			margin: auto;
			padding: 6%;
			width: 70%;
			font-size: 2.0em;
			color: rgb(91, 192, 222);
			display: none;
		}
		.articlelist li a {
			color: rgb(20, 144, 252);
		}
		.articlelist li ul a {
			color: rgb(91, 192, 222);
		}
		.articlelist ul ul {
			margin-left: 5%;
		}

		.regbox {
			text-align: center;
			display: none;
		}
		.regbox p {
			padding-top: 3%;
			text-align: center;
		}
		.regbox h1 {
			color: rgb(117, 184, 0);
			font-size: 5.0em;
		}
		.errorbox {
			color: red;
			display: none;
		}
		.codeimg {
			width: 15%;
		}

	</style>
	<script type="text/javascript" src="js/jq.js"></script>
	<script type="text/javascript">
		function showLoginBox() {
			if(status == 'loginbox')
				return;

			$.post('islogined.php').done(function(data) {
				if(data == 'no') {
					$("#logincodeimg").attr("src", "tools/captcha.php?" + Math.random());
					status = "loginbox";
					update();
					
					
				}
				else if(data == 'yes') {
					$("#logincodeimg").attr("src", "tools/captcha.php?" + Math.random());
					status = 'loginedbox';
					update();
				}
				else {
					alert("error");
				}
			});
			$("#code").val("");
			$("#username").val("");
			$("#password").val("");
			
		}
		function showArticleList() {
			getTypeList();
			if(status == 'articlelist')
				return;
			status="articlelist";
			update();
		}
		function showHome() {
			if(status == 'home')
				return;
			status="home";
			update();
		}
		function showContent(item) {
			value = item.value;
			$.post("getarticle.php", {id: value}).done(function(data) {
				data = JSON.parse(data);
				$("#content").html(data['content']);
			});
			status="content";
			update();
		}
		function showRegBox() {
			if(status == 'regbox')
				return;
			status="regbox";
			update();
			$("#regcodeimg").attr("src", "tools/captcha.php?" + Math.random());
			$("#reg_code").val("");
			$("#reg_username").val("");
			$("#reg_password").val("");
			$("#reg_email").val("");
		}
		function checkReg() {
			if(!$("#reg_username").val()) {
				$("#regerror").html("The user name can not be null.");
				$("#regerror").css("display", "block");
				return false;
			}
			else if(!$("#reg_password").val()) {
				$("#regerror").html("The password can not be null.");
				$("#regerror").css("display", "block");
				return false;
			}
			else if(!$("#reg_email").val()) {
				$("#regerror").html("The email can not be null.");
				$("#regerror").css("display", "block");
				return false;
			}
			else if(!checkEmail($('#reg_email').val())) {
				$("#regerror").html("The email is in wrong formate.");
				$("#regerror").css("display", "block");
				return false;
			}
			else if(!$("#reg_code").val()) {
				$("#regerror").html("The verify code can not be null.");
				$("#regerror").css("display", "block");
				return false;
			}

			$("#regerror").css("display", "none");
			return true;
		}
		function checkEmail(email) {
			var match= /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
 			return match.test(email);
		}
		function checkLogin() {

			if(!$("#username").val()) {
				$("#loginerror").html("The user name can not be null.");
				$("#loginerror").css("display", "block");
				return false;
			}
			else if(!$("#password").val()) {
				$("#loginerror").html("The password can not be null.");
				$("#loginerror").css("display", "block");
				return false;
			}
			else if(!$("#code").val()) {
				$("#loginerror").html("The verify code can not be null.");
				$("#loginerror").css("display", "block");
				return false;
			}

			$("#loginerror").css("display", "none");
			return true;

		}
		function reg() {
			if(!checkReg())
				return;

			var password = $("#reg_password").val();
			var email = $("#reg_email").val();
			var username = $("#reg_username").val();
			var code = $("#reg_code").val();

			$.post( "reg.php", {
				password 	: password,
				username 	: username,
				email 		: email,
				code 		: code
			}).done(function(data) {
				var result = JSON.parse(data);
				if(result.suc) {
					status = "regsuc";
					update();
				}
				else {
					$("#regerror").html(result.reason);
					$("#regerror").css("display", "block");
				}
				
			});
			$("#regcodeimg").attr("src", "tools/captcha.php?" + Math.random());
			$("#reg_code").val("");
		}
		function login() {
			if(!checkLogin())
				return;

			var password = $("#password").val();
			var username = $("#username").val();
			var code = $("#code").val();

			$.post( "login.php", {
				password 	: password,
				username 	: username,
				code 		: code
			}).done(function(data) {
				var result = JSON.parse(data);
				if(result.suc) {
					status = "loginsuc";
					update();
				}
				else {
					$("#loginerror").html(result.reason);
					$("#loginerror").css("display", "block");
					$("#logincodeimg").attr("src", "tools/captcha.php?" + Math.random());
				}
				
			});
			
			$("#code").val("");
		}
		function logout() {
			$.post("logout.php").done(function(data) {
			$("#logincodeimg").attr("src", "tools/captcha.php?" + Math.random());
			status = 'loginbox';
			update();

			});
		}
		
		function update() {
			$("*[name='status']").hide(200);
			$("#" + status).show(200);
		}
		function checkKey(event) {
			if(event.keyCode == 13) {
				if(status == 'loginbox') {
					login();
				}
				else if(status == "regbox") {
					reg();
				}
			}
		}
		function getTypeList() {
			$.post("gettypelist.php").done(function(data) {
				typelist = JSON.parse(data);
				html_content = "";
				for(var index in typelist) {
					html_content += "<li value=\"" + index + "\"><a onclick=\"getTitleList(this)\" href=\"javascript:void(0)\">" + typelist[index] + "</a></li>";
				}
				$("#typelist").html(html_content);

			});
		}

		function getTitleList(item) {


			value = item.parentNode.value;
			$.post("gettitlelist.php", {typeid:value}).done(function(data) {
				titlelist = JSON.parse(data);
				html_content = "";
				for(var index in titlelist) {
					html_content += "<li value=\"" + index + "\" ><a onclick=\"showContent(this.parentNode)\" href=\"javascript:void(0)\">" + titlelist[index] + "</a></li>"
				}
				html_content = "<a onclick=\"getTitleList(this)\" href=\"javascript:void(0)\">" +  typelist[value] + "</a>" + "<ul>" + html_content + "</ul>";
				$(item.parentNode).html(html_content);
				
			});

			
		}

		var status = 'home';
		var logined = false;
		var typelist = [];
		var titlelist = [];
		window.onload = function() {
			update();
		}
	</script>
</head>
<body onkeydown="checkKey(event)">
	<div id="sidebar" class="sidebar">
		<ul>
		<li>
			<a href="javascript:showHome()"><img src="picture/home.png" /></a>
		</li>
		<li><a href="javascript:showArticleList()"><img src="picture/document.png" /></a></li>
		<li><a href="javascript:showLoginBox()"><img src="picture/login.png" /></a></li>
	</div>
	
	<div class="container">
		<div class="articlelist" id="articlelist" name="status">
			<ul id="typelist">
			</ul>
		</div>
		<div class="content" id="content" name="status">
			<h1>This is the content.</h1>
		</div>
		<div class="home" id="home" name="status">
			Welcome to Fnhn's Blog.
		</div>
		<div id="loginbox" class="loginbox" name="status">
			<div class="errorbox" id="loginerror"></div>
			
			<div class="guide">
	        	Didn't have an account? click <a href="javascript:showRegBox()"><span>here</span></a> to sign up one.
	        </div>    
            <h1>Login here.</h1>
            <p>   
                <input class="inputbox" type="text" id="username" name="username" autocomplete="off" placeholder="User Name" value="" /><br><br>
                <input class="inputbox" type="password" id="password" name="password" autocomplete="off" placeholder="Password" value="" /><br><br>
                <input class="inputbox" type="text" style="width:45%" id="code" name="code" autocomplete="off" placeholder="Code" value="" />
                <img  class="codeimg" id="logincodeimg" title="Click to refresh" src="tools/captcha.php" align="absbottom" onclick="this.src='tools/captcha.php?' + Math.random();"></img>  
            </p> 
            <p>
            	<input class="btn" type="button" onclick="login()" value="Login" />
            </p> 

		</div>
		<div class="home" id="loginedbox" name="status">
			You have already logined.<br>
			<button class="btn" onclick="logout()">Logout</button>
		</div>
		<div class="regbox" id="regbox" name="status">
			<div class="errorbox" id="regerror"></div>
			<div class="guide">
	        	Already have an account? click <a href="javascript:showLoginBox()"><span>here</span></a> to login.
	        </div>    
            <h1>Register here.</h1>
            <p>   
                <input class="inputbox" type="text" id="reg_username" name="username" autocomplete="off" placeholder="User Name" value="" /><br><br>
                <input class="inputbox" type="password" id="reg_password" name="password" autocomplete="off" placeholder="Password" value="" /><br><br>
                <input class="inputbox" type="text" id="reg_email" name="email" autocomplete="off" placeholder="Email" value="" /><br><br>
                <input class="inputbox" type="text" style="width:45%" id="reg_code" name="code" autocomplete="off" placeholder="Code" value="" />
                <img  class="codeimg" id="regcodeimg" title="Click to refresh" src="tools/captcha.php" align="absbottom" onclick="this.src='tools/captcha.php?' + Math.random();"></img>  

            </p> 
            <p>
            	<input class="btn" type="button" onclick="reg()" value="Register" />
            </p>   
		</div>
		<div class = "home" id="regsuc" name="status">
			Register Success
		</div>
		<div class = "home" id="loginsuc" name="status">
			Login Success
		</div>
	</div>
</body>
</html>
