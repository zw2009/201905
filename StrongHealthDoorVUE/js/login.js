$("#login").click(function() {
	login();
})

function login() {
	var myreg = /^[1][3,4,5,7,8][0-9]{9}$/;
	var name = $("#sname").val();
	var pwd = $("#spwd").val();
	if(!myreg.test(name)) {
		alert("请输入正确的手机号码!");
	} else if(pwd == null || pwd.trim() == "") {
		alert("请输入登录密码!");
	} else {

		$.ajax({
			type: "POST",
			url: "login",
			data: {
				userName: name,
				pass: hex_md5(pwd)
			},
			async: true,
			dataType: "json",
			success: function(data, status, xhr) {
				if(data.status == '0') {
					sessionStorage.setItem("islog", "1");
					location.href = "index.html";
				} else {
					alert("您输入的账号或密码错误!");
				}
			},
			error: function(data) {
				alert("登陆失败!");
			}
		});
	}
}