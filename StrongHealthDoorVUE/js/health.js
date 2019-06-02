$(".health-left ul li").click(function() {
	var index = $(this).index();
	$(this).addClass("cur").siblings().removeClass("cur");
	$(".health-right ul").eq(index).show().siblings().hide();
})
$(".health-left ul li").eq(0).click(function() {
	$(".health-right ul").show();
})

//新闻列表渲染
$.ajax({
	type: 'get',
	url: 'json/newList.json',
	dataType: 'json',
	async: true,
	success: function(res) {
		var data = res.data;
		var lis = "";

		$.each(data, function(i, v) {
			lis += '<li class="clearfix">' +
				'<div class="leftfix" onclick="lisopen(' + v.id + ')">' +
				'<h3 class="textover">' + v.title + '</h3>' +
				'<p class="textover3">' + v.content + '</p>' +
				'</div>' +
				'<div class="rightfix">' +
				'<img src="' + v.img + '" />' +
				'</div>' +
				'</li>'
		});

		$("#newsList").append(lis);
	},
	error: function(res) {
		console.log("连接失败！")
	}

})

function lisopen(newid) {
	location.href = "healthDetails.html?newid=" + newid;
}

//疾病诊疗列表渲染
$.ajax({
	type: 'get',
	url: 'json/diseaseList.json',
	dataType: 'json',
	async: true,
	success: function(res) {
		var data = res.data;
		var lis = "";

		$.each(data, function(i, v) {
			lis += '<li class="clearfix">' +
				'<div class="leftfix" onclick="lisopen1(' + v.id + ')">' +
				'<h3 class="textover">' + v.title + '</h3>' +
				'<p class="textover3">' + v.content + '</p>' +
				'</div>' +
				'<div class="rightfix">' +
				'<img src="' + v.img + '" />' +
				'</div>' +
				'</li>'
		});

		$("#diseaseList").append(lis);
	},
	error: function(res) {
		console.log("连接失败！")
	}

})

function lisopen1(disid) {
	location.href = "healthDetails.html?disid=" + disid;
}

//生活养生列表渲染
$.ajax({
	type: 'get',
	url: 'json/regimenList.json',
	dataType: 'json',
	async: true,
	success: function(res) {
		var data = res.data;
		var lis = "";

		$.each(data, function(i, v) {
			lis += '<li class="clearfix">' +
				'<div class="leftfix" onclick="lisopen2(' + v.id + ')">' +
				'<h3 class="textover">' + v.title + '</h3>' +
				'<p class="textover3">' + v.content + '</p>' +
				'</div>' +
				'<div class="rightfix">' +
				'<img src="' + v.img + '" />' +
				'</div>' +
				'</li>'
		});

		$("#regimenList").append(lis);
	},
	error: function(res) {
		console.log("连接失败！")
	}

})

function lisopen2(regid) {
	location.href = "healthDetails.html?regid=" + regid;
}