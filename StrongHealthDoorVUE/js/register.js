$("#register").click(function() {
	var myreg = /^[1][3,4,5,7,8][0-9]{9}$/;
	var userName = $("#username").val();
	var uName = $("#uname").val();
	var pwd = $("#pwd").val();
	var rpwd = $("#epwd").val();
	var codephone = $("#captcha").val();
	if(userName == null || userName.trim() == "") {
		alert("账号不能为空!");
	}else if(!myreg.test(userName)){
		alert("请输入正确的手机号码!");
	} else if(uName == null || uName.trim() == "") {
		alert("昵称不能为空!");
	} else if(pwd == null || pwd.trim() == "") {
		alert("密码不能为空!");
	} else if(pwd != rpwd) {
		alert("两次密码不一致!");
	} else if(codephone == null || codephone.trim() == "") {
		alert("请输入验证码");
	} else {
		$.ajax({
			type: "post",
			url: registerUrl,
			async: true,
			data:{
				userName:userName,
				uName:uName,
				pwd:hex_md5(pwd),
				codephone:codephone
			},
			dataType: "json",
			success: function(res, status, xhr) {
				if(res.status == "0") {
					window.alert({
						title: "提示",
						content: "注册成功",
						buttons: ["确定", "取消"],
						callback: function(id, data, dataType, err) {
							if(data == "0") {
								window.location.href = "login.html";
							}
						}
					})
				} else {
					alert(res.message);
				}
			},
			error: function(xhr, type) {
				alert("ajax error!")
			}
		});
	}
})
