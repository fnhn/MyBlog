function showLoginBox() {
			if(status == 'loginbox')
				return;

			$.post('islogined.php').done(function(data) {
				data = JSON.parse(data);
				if(data['message'] == 'no') {
					$("#logincodeimg").attr("src", "tools/captcha.php?" + Math.random());
					status = "loginbox";
					update();
					
					
				}
				else if(data['message'] == 'yes') {
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
				articleend = '<br>（转载请注明来源fnhn.sinaapp.com ';
				articleend += data['date'];
				articleend += '）<br>';
				$("#content").html(data['content'] + articleend);
				articleid = value;
				getCommentList();
			});
			
			
		}
		function showRegBox() {
			if(status == 'regbox')
				return;
			
			$("#regcodeimg").attr("src", "tools/captcha.php?" + Math.random());
			$("#reg_code").val("");
			$("#reg_username").val("");
			$("#reg_password").val("");
			$("#reg_email").val("");
			status="regbox";
			update();
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
					$("#regcodeimg").attr("src", "tools/captcha.php?" + Math.random());
					$("#reg_code").val("");
				}
				
			});
			
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
					imgid = result['imgid'];
					nickname = result['nickname'];
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

				$("#iconbox").css("display", "none");
				imgid = -1;
			});

		}
		
		function update() {
			$("*[name='status']").hide(200);
			$("#" + status).show(200);

			if(status != "content")
				$("#commentbox").css('display', 'none');
			else 
				$("#commentbox").css('display', 'block');

			if(imgid != -1) {
				if(status != 'loginbox' || status != 'regbox') {
					$("#icon").attr('src', 'icons/' + imgid + '.jpg');
					$('#nickname').html(nickname);
					$("#iconbox").css("display", "block");
				}
				else {
					$("#iconbox").css("display", "none");
				}
			}


		}
		function checkKey(event) {
			if(event.keyCode == 13) {
				if(status == 'loginbox') {
					login();
				}
				else if(status == "regbox") {
					reg();
				}

				if(event.ctrlKey && status == 'content') {
					submitComment();
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
				if(status == 'articlelist')
				return;
				status="articlelist";
				update();
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

		function submitComment() {
			content = $("#commentcontent").val();
			$.post('submitcomment.php', {content:content}).done(function(data) {
				data = JSON.parse(data);
				if(data.suc) {
					getCommentList(1);
					$("#commenterror").html("");
					$("#commentcontent").val("");
				}
				else {
					$("#commenterror").html(data['reason']);
					$("#commenterror").css("display", "block");
				}
				
			});
		}

		function getCommentList(x) {
			$.post('getcommentlist.php', {articleid: articleid}).done(function(data) {
			
				data = JSON.parse(data);

				prehtml = "";

				for(var index in data) {
					prehtml += "<div class=\"commentwraper\"><div class=\"commenticon\"><img src=\"icons/" + data[index].imgid + ".jpg\"></img></div><div class=\"commenttext\"><b>" + data[index].nickname +"</b><b>" + data[index].date +" " + data[index].time + "</b>\
						<pre>" + data[index].content + "</pre></div></div>";
				
				}
				
				$("#oldcommentbox").html(prehtml);

				if(x == 1)
					return;
				status = 'content';
				update();
				
			});
		}

		var status = 'home';
		var logined = false;
		var typelist = [];
		var titlelist = [];
		var imgid = -1;
		var articleid = -1;
		var nickname = 'fnhn';
		window.onload = function() {
			$.post('islogined.php').done(function(data) {
				data = JSON.parse(data);
				
				if(data['message'] == 'yes') {
					nickname = data['nickname'];
					imgid = data['imgid'];


					$("#icon").attr('src', 'icons/' + imgid + '.jpg');
					$('#nickname').html(nickname);
					$("#iconbox").css("display: block");
				}

				
			});


			update();
		}