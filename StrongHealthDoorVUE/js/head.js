$("#navLeft li").click(function() {
	$(this).addClass("cur").siblings().removeClass("cur");
})
$("#navLeft li").eq(0).click(function() {
	top.location.href = "health.html"
})
$("#navLeft li").eq(1).click(function() {
	top.location.href = "health.html"
})
$("#navLeft li").eq(2).click(function() {

	top.location.href = "doctor.html"
})
$("#navLeft li").eq(3).click(function() {

	top.location.href = "doctorCare.html"
})

/*跳转医疗云平台*/
$("#inStorng").click(function() {
	alert("暂未开通！");
})
/*跳转注册*/
$("#register").click(function() {
	top.location.href = "register.html";
})
/*跳转登陆*/
$("#login").click(function() {
	top.location.href = "login.html";
})