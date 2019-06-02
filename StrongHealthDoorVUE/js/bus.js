//头部公用悬停

function load(num) {
	$(".headif").contents().find("#navLeft li").eq(num).addClass("cur");
}

$(".health-left ul li").click(function() {
	var index = $(this).index();
	$(this).addClass("cur").siblings().removeClass("cur");
	$(".health-right ul").eq(index).show().siblings().hide();
})

//点击发送验证码倒计时
var time = 60;

function send(obj) {
	var timer = setInterval(function() {
		time--;
		$(obj).text(time + 's后重新发送');
		$(obj).removeClass('btn-outline-secondary');
		$(obj).prop('disabled', true);
		if(time == 0) {
			time = 60;
			clearInterval(timer);
			$(obj).addClass('btn-outline-secondary');
			$(obj).prop('disabled', false);
			$(obj).text('发送验证码');
		}
	}, 1000);
	var phone = $('input[name=username]').val();
	/*$.post('?a=接收方法sendSms',{phone:phone},function(res){
		if(res.status == 1){
			alert(res,msg);
		}else{
			alert(res,msg);
		}
	},'json');*/
}
//提交验证码到后台
function post() {
	var code = $('input[name=code]').val();
	/*$.post('?a=post', {
		code: code
	}, function(res) {
		if(res.status == 1) {
			alert(res.msg);
		} else {
			alert(res.msg);
		}
	}, 'json');*/
}

/*获取页面传值的方法*/
function getUrlParam(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
	var r = window.location.search.substr(1).match(reg); //匹配目标参数
	if(r != null) return unescape(r[2]);
	return null; //返回参数值
}