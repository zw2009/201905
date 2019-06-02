//更改密码点击
$("#findpwd").click(function() {
	changpwd();
})

//验证更改密码
function changpwd(){
	var myreg = /^[1][3,4,5,7,8][0-9]{9}$/;
	var userName = $("#username").val();
	var pwd = $("#pwd").val();
	var rpwd = $("#epwd").val();
	var codephone = $("#captcha").val();
	if(userName == null || userName.trim() == "") {
		alert("账号不能为空!");
	}else if(!myreg.test(userName)){
		alert("请输入正确的手机号码!");
	} else if(pwd == null || pwd.trim() == "") {
		alert("密码不能为空!");
	} else if(pwd != rpwd) {
		alert("两次密码不一致!");
	} else if(codephone == null || codephone.trim() == "") {
		alert("请输入验证码!");
	} else {
			$.ajax({
			type: "post",
			url: findpwdUrl,
			async: true,
			data:{
				userName:userName,
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
}
//点击发送验证码倒计时
/*var timer = "";
var nums = 60;
var validCode = true; //定义该变量是为了处理后面的重复点击事件
$("#getCode").on('click', function() {
	var code = $(this);
	if(validCode) {
		validCode = false;
		timer = setInterval(function() {
			if(nums > 0) {
				nums--;
				code.text(nums + "秒后重新发送");
			} else {
				clearInterval(timer);
				nums = 60; //重置回去
				validCode = true;
				code.text("发送验证码");
			}
		}, 1000)
	}

})*/


