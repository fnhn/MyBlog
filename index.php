<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta charset="utf-8">
	<META HTTP-EQUIV="pragma" CONTENT="no-cache">
	<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
	<META HTTP-EQUIV="expires" CONTENT="0">

	<link rel="stylesheet" href="css/main.css" />
	<script type="text/javascript" src="js/jq.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
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
		<div class="iconbox" id="iconbox">
			<img id="icon"></img>
			<p id="nickname"></p>
		</div>
		<div class="commentbox" id="commentbox">
			<li class="commenthead">Comment</li>
			<div class="hr"></div>
			<div class="oldcommentbox" id="oldcommentbox">
				<div class="commentwraper">
					<div class="commenticon">
						<img src="icons/8.jpg"></img>
					</div>
					<div class="commenttext">
						<b>nickname</b><b>2015-1-1 15:0:1</b>
						<p>This is the comment.This is the comment.This is the comment.This is the comment.This is the comment.This is the comment.This is the comment.This is the comment.</p>
					</div>
				</div>

				
			</div>
			<div class="errorbox" id="commenterror"></div>
			<textarea class="commentcontentbox" id="commentcontent" placeholder="Type comment here."></textarea><br>
			<button onclick="submitComment()">Submit</button>
		</div>
		
	</div>
</body>
</html>
