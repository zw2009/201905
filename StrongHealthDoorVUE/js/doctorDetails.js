var id = getUrlParam('heaId');
			
			/*获取数据遍历渲染*/
			$.ajax({
				type:"get",
				url:"json/pictext.json",
				async:true,
				dataType:"json",
				success:function(res){
					var con="";
					$.each(res.data,function(index,item){
					
						if(item.id == id){
							con+= '<h1>'+item.title+'</h1>'+
								  '<div class="content-article">'+
								  '<p class="one-p one">'+item.content+'</p>'+
								  '<p class="one-p"><img src="'+item.images[0].src+'" class="content-picture"></p>'+
								  '</div>'
						}
					})
					
					//conten.replace(/。/g, "。<br>")
					$(".qq_conent").append(con);
					var conten = $(".one").text();
					conten.replace(/。/g, "。<br>")
					console.log(conten);
					
				},
				error:function(res){
					console.log("连接失败！")
				}
			});