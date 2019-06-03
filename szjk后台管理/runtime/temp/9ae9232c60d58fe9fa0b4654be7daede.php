<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:50:"../application/index/view/default/index\index.html";i:1544630729;s:50:"../application/index/view/default/Common\base.html";i:1544630729;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo (isset($config['webname']) && ($config['webname'] !== '')?$config['webname']:"思众健康"); ?></title>
    <meta name="keywords" content="<?php echo $config['seo_keywords']; ?>" />
    <meta name="description" content="<?php echo $config['seo_description']; ?>" />
    <script type="text/javascript" src="__PLUGS__/jquery-1.10.2.min.js"></script>
    <link href="__PLUGS__/FlexSlider/flexslider.css" rel="stylesheet">
    <script type="text/javascript" src="__PLUGS__/FlexSlider/jquery.flexslider.js"></script>
    
<link rel="stylesheet" href="__PLUGS__/swiper/css/swiper.min.css">
<script src="__PLUGS__/swiper/js/swiper.min.js"></script>

    <link href="__CSS__/css.css" rel="stylesheet">
    <script>
        $(document).ready(function(e) {
            //pc端下拉
            $(".pcmenu_xun").hover(function(){
                $(this).addClass('active').find(".pcmenu_drop").slideToggle();
            },function(){
                $(this).removeClass('active').find(".pcmenu_drop").slideToggle();
            });
        });
    </script>
</head>
<body class="index">
<div id="header">
    <div class="top">
        <div class="top-cont">
            <ul>
                <li>欢迎您光临思众健康官方网站！</li>
                <!--<li><a href="" onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('{dede:global.cfg_basehost/}');">设为首页</a></li>
                <li><a href="javascript:window.external.AddFavorite('{dede:global.cfg_basehost/}','{dede:global.cfg_webname/}')">收藏本站</a></li>-->
            </ul>
        </div>
    </div>
    <div class="pctop">
        <div class="pctop_nei">
            <div class="pclogo"></div>
            <div class="pctop_right">
                <div class="pcmenu">
                    <div class="pcmenu_xun">
                        <a href="<?php echo url('Index/index'); ?>" class="pcmenu_a">首页</a>
                    </div>
                    <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <div class="pcmenu_xun">
                        <a href="<?php echo url('Article/lists',['cid'=>$vo['id']]); ?>" class="pcmenu_a"><?php echo $vo['name']; ?></a>
                        <?php if(!(empty($vo['child']) || (($vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator ) && $vo['child']->isEmpty()))): ?>
                        <div class="pcmenu_drop">
                            <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?>
                            <a href="<?php echo url('Article/lists',['cid'=>$sub['id']]); ?>"><?php echo $sub['name']; ?></a>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

    <div class="index-banner">
        <ul class="slides">
            <?php if(is_array($banner) || $banner instanceof \think\Collection || $banner instanceof \think\Paginator): $i = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <li><a href="<?php echo $vo['link']; ?>" style="background-image: url(<?php echo $vo['picture']; ?>)"></a></li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <div class="index-service">
        <div class="index-title">
            <div class="title">服务项目</div>
            <div class="title-en">SERVICE PROJECT</div>
        </div>
        <div class="service-group">
            <ul class="slides">
                <?php if(is_array($service) || $service instanceof \think\Collection || $service instanceof \think\Paginator): $i = 0; $__LIST__ = $service;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li>
                    <a href="<?php echo url('Article/info',['id'=>$vo['id']]); ?>" class="item sHoverItem">
                        <div class="item-info sIntro"><?php echo $vo['description']; ?></div>
                        <div class="item-img"><img src="<?php echo $vo['thumb']; ?>"></div>
                        <div class="item-title"><?php echo $vo['title']; ?></div>
                    </a>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <a href="<?php echo url('Article/lists',['cid'=>2]); ?>" class="index-more"></a>
    </div>
    <div class="index-team">
        <div class="index-title">
            <div class="title">医疗团队</div>
            <div class="title-en">MEDICAL TEAM</div>
        </div>
        <div class="team-group">
            <ul class="slides">
                <?php if(is_array($team) || $team instanceof \think\Collection || $team instanceof \think\Paginator): $i = 0; $__LIST__ = $team;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li>
                    <a href="<?php echo url('Article/info',['id'=>$vo['id']]); ?>" class="item">
                        <img src="<?php echo $vo['thumb']; ?>"/>
                        <div class="item-info">
                            <div class="item-title">
                                <?php echo $vo['title']; ?>
                                <span><?php echo $vo['service']; ?></span>
                            </div>
                        </div>
                    </a>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <a href="<?php echo url('Article/lists',['cid'=>3]); ?>" class="index-more"></a>
    </div>
    <div class="index-net">
		<canvas id="mapbackgroup" style="width: 100%;height: 100%;position: absolute;z-index:1;"></canvas>
        <div class="index-title">
            <div class="title">网络机构</div>
            <div class="title-en">NET WORK</div>
        </div>
        <div class="net-area">
            <div id="map"></div>
            <div class="linkstore"></div>
        </div>
        <a href="<?php echo url('Article/lists',['cid'=>1]); ?>" class="index-more"></a>
    </div>
    <div class="index-news">
        <div class="index-title">
            <div class="title">健康新知</div>
            <div class="title-en">HEALTH KNOWLEDGE</div>
        </div>
        <div class="news-group">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php if(is_array($article) || $article instanceof \think\Collection || $article instanceof \think\Paginator): $i = 0; $__LIST__ = $article;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <a class="swiper-slide" href="<?php echo url('Article/info',['id'=>$vo['id']]); ?>" data-days="<?php echo date('d',$vo['update_time']); ?>" data-month="<?php echo date('Y-m',$vo['update_time']); ?>" data-title="<?php echo $vo['title']; ?>" data-description="<?php echo $vo['description']; ?>"><img src="<?php echo $vo['thumb']; ?>"></a>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="news-list"></div>
        </div>
        <a href="<?php echo url('Article/lists',['cid'=>5]); ?>" class="index-more"></a>
    </div>
    <div class="index-join">
        <div class="index-title">
            <div class="title">招商加盟</div>
            <div class="title-en">CHINA MERCHANTS TO US</div>
        </div>
        <div class="join-wrap">
            <div class="form">
                <form action="<?php echo url('feedback'); ?>">
                    <label class="input">
                        <div class="label user">姓名</div>
                        <input name="real_name" class="text">
                    </label>
                    <label class="input">
                        <div class="label tel">电话</div>
                        <input name="phone" class="text">
                    </label>
                    <label class="input">
                        <div class="label addr">加盟区域</div>
                        <input name="dist" class="text">
                    </label>
                    <label class="input">
                        <div class="label msg">留言</div>
                        <textarea name="content" class="textarea"></textarea>
                    </label>
                    <button type="submit">提交</button>
                </form>
            </div>
            <div class="contact">
                <div class="contact-info">
                    <div class="contact-us">
                        客户服务<small>CONTACT US</small>
                    </div>
                    <div class="words">有任何问题请反馈给我们，我们将第一时间联系到您！</div>
                    <div class="contact-item tel">
                        <div class="icon"></div>
                        <div class="detail">
                            <p>电话：<?php echo $config['hot_tel']; ?></p>
                            <p>传真：<?php echo $config['fax']; ?></p>
                        </div>
                    </div>
                    <div class="contact-item email">
                        <div class="icon"></div>
                        <div class="detail">
                            <p>邮箱：<?php echo $config['email']; ?></p>
                            <p>邮编：<?php echo $config['zipcode']; ?></p>
                        </div>
                    </div>
                    <div class="contact-item address">
                        <div class="icon"></div>
                        <div class="detail">
                            <p>地址：<?php echo $config['address']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script id="linkstore" type="text/html">
        <%each data as vo%>
        <a href="<?php echo url('Article/info'); ?>?id=<%vo.id%>" class="item"><%vo.title%></a>
        <%/each%>
    </script>
    <script type="text/javascript" src="__PLUGS__/svgMap/js/lib/raphael.js"></script>
    <script type="text/javascript" src="__PLUGS__/svgMap/js/map.js"></script>
    <script type="text/javascript" src="__PLUGS__/tmodjs.js"></script>
    <script type="text/javascript" src="__PLUGS__/shover.min.js"></script>
    <script>
	//定义画布宽高和生成点的个数
		var WIDTH = window.innerWidth, HEIGHT = window.innerHeight, POINT = 35;
		var canvas = document.getElementById('mapbackgroup');
		canvas.width = WIDTH,
		canvas.height = HEIGHT;
		var context = canvas.getContext('2d');
		context.strokeStyle = 'rgba(0,0,0,0.2)',
		context.strokeWidth = 1,
		context.fillStyle = 'rgba(0,0,0,0.1)';
		var circleArr = [];

		//线条：开始xy坐标，结束xy坐标，线条透明度
		function Line (x, y, _x, _y, o) {
			this.beginX = x,
			this.beginY = y,
			this.closeX = _x,
			this.closeY = _y,
			this.o = o;
		}
		//点：圆心xy坐标，半径，每帧移动xy的距离
		function Circle (x, y, r, moveX, moveY) {
			this.x = x,
			this.y = y,
			this.r = r,
			this.moveX = moveX,
			this.moveY = moveY;
		}
		//生成max和min之间的随机数
		function num (max, _min) {
			var min = arguments[1] || 0;
			return Math.floor(Math.random()*(max-min+1)+min);
		}
		// 绘制原点
		function drawCricle (cxt, x, y, r, moveX, moveY) {
			var circle = new Circle(x, y, r, moveX, moveY)
			cxt.beginPath()
			cxt.arc(circle.x, circle.y, circle.r, 0, 2*Math.PI)
			cxt.closePath()
			cxt.fill();
			return circle;
		}
		//绘制线条
		function drawLine (cxt, x, y, _x, _y, o) {
			var line = new Line(x, y, _x, _y, o)
			cxt.beginPath()
			cxt.strokeStyle = 'rgba(0,0,0,'+ o +')'
			cxt.moveTo(line.beginX, line.beginY)
			cxt.lineTo(line.closeX, line.closeY)
			cxt.closePath()
			cxt.stroke();

		}
		//初始化生成原点
		function init () {
			circleArr = [];
			for (var i = 0; i < POINT; i++) {
				circleArr.push(drawCricle(context, num(WIDTH), num(HEIGHT), num(15, 2), num(10, -10)/40, num(10, -10)/40));
			}
			draw();
		}
		//每帧绘制
		function draw () {
			context.clearRect(0,0,canvas.width, canvas.height);
			for (var i = 0; i < POINT; i++) {
				drawCricle(context, circleArr[i].x, circleArr[i].y, circleArr[i].r);
			}
			for (var i = 0; i < POINT; i++) {
				for (var j = 0; j < POINT; j++) {
					if (i + j < POINT) {
						var A = Math.abs(circleArr[i+j].x - circleArr[i].x),
							B = Math.abs(circleArr[i+j].y - circleArr[i].y);
						var lineLength = Math.sqrt(A*A + B*B);
						var C = 1/lineLength*7-0.009;
						var lineOpacity = C > 0.03 ? 0.03 : C;
						if (lineOpacity > 0) {
							drawLine(context, circleArr[i].x, circleArr[i].y, circleArr[i+j].x, circleArr[i+j].y, lineOpacity);
						}
					}
				}
			}
		}
		//调用执行
		window.onload = function () {
			init();
			var timer=setTimeout(function(){
                for (var i = 0; i < POINT; i++) {
                    var cir = circleArr[i];
                    cir.x += cir.moveX;
                    cir.y += cir.moveY;
                    if (cir.x > WIDTH) cir.x = 0;
                    else if (cir.x < 0) cir.x = WIDTH;
                    if (cir.y > HEIGHT) cir.y = 0;
                    else if (cir.y < 0) cir.y = HEIGHT;
                }
                draw();
                timer = setTimeout(arguments.callee, 16);
            },16);
		}
    </script>
    <script>
        $(document).ready(function(){
            var linkstore=<?php echo json_encode($linkstore); ?>;
            $('.index-banner').flexslider({
                animation: "slide",
                animationLoop: true,
                slideshowSpeed: 4000, // 自动播放速度毫秒
                animationSpeed: 1000, //滚动效果播放时长
                directionNav: false
            });
            $(".service-group").flexslider({
                animation: "slide",
                animationLoop: true,
                itemWidth: 250,
                itemMargin: 0,
                slideshow: false,
                controlNav:false,
                minItems: 4, // use function to pull in initial value
                maxItems: 4
            });
            $(".team-group").flexslider({
                animation: "slide",
                animationLoop: true,
                itemWidth: 333,
                itemMargin: 0,
                slideshow: false,
                controlNav:false,
                minItems: 3, // use function to pull in initial value
                maxItems: 3
            });
            var zoneMapConfig={
                width:700,
                height:700,
                shapes: <?php echo json_encode($map['shapes']); ?>,
                names:<?php echo json_encode($map['names']); ?>
            };
            $('#map').SVGMap({
                mapWidth:750,
                mapHeight: 750,
                mapConfig: zoneMapConfig,
                clickColorChange: false,
                external:true,
                clickCallback: function(stateData, obj){
                    var id=obj.id;
                    if(linkstore[id]!=undefined){
                        $('.linkstore').html(template('linkstore',{data:linkstore[id]}));
                    }else{
                        $('.linkstore').html('');
                    }
                }
            });

            var a=new sHover("sHoverItem","sIntro");
            a.set({
                slideSpeed:5,
                opacityChange:true,
                opacity:80
            });

            var swiper = new Swiper('.swiper-container',{
                effect : 'cube',
                pagination: {
                    el: '.news-list',
                    renderBullet: function (index, className) {
                        var days=$('.news-group .swiper-slide').eq(index).data('days');
                        var month=$('.news-group .swiper-slide').eq(index).data('month');
                        var title=$('.news-group .swiper-slide').eq(index).data('title');
                        var cont=$('.news-group .swiper-slide').eq(index).data('description');
                        return  '<div class="item '+className+'">' +
                                    '<div class="date">' +
                                        '<div class="days">'+days+'</div>' +
                                        '<div class="month">'+month+'</div>' +
                                    '</div>' +
                                    '<div class="news-info">' +
                                        '<div class="title">'+title+'</div>' +
                                        '<div class="cont">'+cont+'</div>' +
                                    '</div>' +
                                '</div>';
                    },
                },
            });
            for(i=0;i<swiper.pagination.bullets.length;i++){
                swiper.pagination.bullets[i].index=i
                swiper.pagination.bullets[i].onmouseover=function(){
                    swiper.slideTo(this.index);
                };
            }
        })
    </script>

<div id="footer">
    <div class="footer">
        <div class="logo">
            <img src="__IMG__/logo_footer.png">
        </div>
        <div class="cont">
            <ul>
                <?php if(is_array($cfooter) || $cfooter instanceof \think\Collection || $cfooter instanceof \think\Paginator): $i = 0; $__LIST__ = $cfooter;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li><a href="<?php echo url('Article/lists',['cid'=>$vo['id']]); ?>"><?php echo $vo['name']; ?></a></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <div class="copyright">
                <?php echo $config['copyright']; ?>
                <a href="http://www.miitbeian.gov.cn">湘ICP备17000762号</a>
            </div>
        </div>
        <div class="qrcode">
            <img src="__IMG__/qrcode.png">
        </div>
    </div>
</div>
</body>
</html>