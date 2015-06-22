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