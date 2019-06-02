//兼职全职切换
$('.job-change a').click(function() {
	var index = $(this).index();
	$(".bs-example").eq(index).show().siblings().hide()
})
//简历投递
$(".bs-example tr button").click(function() {
	$("#modede").modal("show");
	setTimeout(mohide, 1000);
	$(this).text("已投递");
})

//模态框隐藏
function mohide() {
	$("#modede").modal("hide");
}

//职位表格搜索
$("#seach").click(function() {
	var sea = $("#sea").val();
	$("table tbody tr").hide().find("th").filter(':contains(' + sea + ')').parents("table tbody tr").show();
})

//监听sea的焦点事件
$("#sea").blur(function() {
	if($("#sea").val() == null || $("#sea").val() == "") {
		$("table tbody tr").show();
	}
})