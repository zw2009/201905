/*视频专区内容渲染*/
		$.ajax({
			type: "get",
			url: "json/video.json",
			success: function(result) {
				videoShow(result);

			},
			error: function(data) {
				console.log("读取失败!")
			}

		});

		/*渲染视频专区方法*/
		function videoShow(result) {
			var resall = result.data;
			//截取后台数据前6条展示
			var res = resall.slice(0,6);
			var con = "";
			$.each(res, function(index, item) {
				
				con += '<div class="video-all">' +
					'<video id="my-player" class="video-js vjs-big-play-centered" controls preload="none" poster="" data-setup="{}" width="350" height="200">' +
					'<source src="' + item.src + '" type="video/mp4"></source>' +
					'</video>' +
					'<h4>' + item.name + '</h4>' +
					'</div>';
			});
			$("#vievtr").append(con);

			//取到所有的videoDOM
			var videos = document.querySelectorAll("video");
			//遍历每个video
			for(var i = videos.length - 1; i >= 0; i--) {
				//闭包同时执行
				(function() {
					var p = i;

					//监听每个video的play事件
					videos[p].addEventListener("play", function() {
						pauseAll(p)
					})
				})()
			}

			//排除当前方法
			function pauseAll(index) {
				for(var j = videos.length - 1; j >= 0; j--) {
					if(j != index) {
						videos[j].pause();
					}
				}
			}
			//禁用video标签右键功能
			$("video").on("contextmenu", function() {
				return false;
			});
			
		
			
		}
		
		
		/*图文专区渲染*/
		$.ajax({
			type:"get",
			url:"json/pictext.json",
			success:function(result){
				
				picText(result);
			},
			error:function(result){
				console.log("读取失败！");
			}
		});
		
		/*图文渲染方法*/
		function picText(result){
			var result1 = result.data;
			/*取列表的前三个显示*/
			var res = result1.slice(0,3);
			var cont1 = "";
			
			/*遍历第一层*/
			$.each(res,function(index,item){
				console.log(item.id)
				cont1 += "<a href='doctorDetails.html?heaId=" + item.id + "'>"+
						 '<div class="row pictext">'+
						 '<h3>'+item.title+'</h3>'+						 
						 '<p class="text-primary branch-name" id="imgAll">'+item.content+'</p>'+
						 "</a>"
				cont1 += '<div class="col-xs-12 imgflex">'
				/*遍历第二层images*/
				$.each(item.images, function(index2,item2) {
						cont1+=	'<a href="#" class="thumbnail">'+
								'<img src="'+item2.src+'" alt="...">'+
								'</a>'					
				});	 
				cont1 +='</div>'					
				cont1 +='</div>';	
			})
			//追加图文列表至子集
			$("#pictextall").append(cont1);		
			
			//跳转详情
		
		}