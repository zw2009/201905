<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:49:"../application/index/view/mobile/index\index.html";i:1544630729;s:49:"../application/index/view/mobile/Common\base.html";i:1544630729;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="format-detection" content="telephone=no"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>思众健康</title>
	<script type="text/javascript" src="__PLUGS__/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="__JS__/common.js"></script>
	<link rel="stylesheet" type="text/css" href="__PLUGS__/core/core.css">
	<script type="text/javascript" src="__PLUGS__/core/core.js"></script>
	
<link href="__PLUGS__/FlexSlider/flexslider.css" rel="stylesheet">
<script type="text/javascript" src="__PLUGS__/FlexSlider/jquery.flexslider.js"></script>
<link rel="stylesheet" type="text/css" href="__PLUGS__/lipster/jquery.flipster.min.css">
<script src="__PLUGS__/lipster/jquery.flipster.min.js"></script>
<link rel="stylesheet" type="text/css" href="__PLUGS__/bootstrap.modal/modal.css">
<script src="__PLUGS__/bootstrap.modal/bootstrap.modal.js"></script>

	<link rel="stylesheet" type="text/css" href="__CSS__/mobile.css">
</head>
<body class="index">

    <header>
        <div class="header">
            <div class="nav-left">
                <a class="menu"></a>
            </div>
            <div class="header-title"></div>
        </div>
    </header>
    <div class="index-banner">
        <ul class="slides">
            <?php if(is_array($banner) || $banner instanceof \think\Collection || $banner instanceof \think\Paginator): $i = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <li><a href="<?php echo $vo['link']; ?>" style="background-image: url(<?php echo $vo['picture']; ?>)"></a></li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <div class="index-team">
        <div class="index-title">
            <div class="title">医疗团队</div>
            <div class="title-en">MEDICAL TEAM</div>
        </div>
        <div class="team-group">
            <?php if(is_array($team) || $team instanceof \think\Collection || $team instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($team) ? array_slice($team,0,4, true) : $team->slice(0,4, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <a href="<?php echo url('Article/info',['id'=>$vo['id']]); ?>" class="item">
                <img src="<?php echo $vo['thumb']; ?>"/>
                <div class="item-info">
                    <?php echo $vo['title']; ?>
                    <span><?php echo $vo['service']; ?></span>
                </div>
            </a>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <div class="clearfix"></div>
        </div>
        <a href="<?php echo url('Article/lists',['cid'=>3]); ?>" class="index-more"></a>
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
                    <a href="<?php echo url('Article/info',['id'=>$vo['id']]); ?>" class="item">
                        <img src="<?php echo $vo['thumb']; ?>"/>
                        <div class="item-info">
                            <div class="item-title"><?php echo $vo['title']; ?></div>
                            <div class="item-cont"><?php echo $vo['description']; ?></div>
                        </div>
                    </a>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <a href="<?php echo url('Article/lists',['cid'=>2]); ?>" class="index-more"></a>
    </div>

    <div class="index-net">
        <div class="index-title">
            <div class="title">网络机构</div>
            <div class="title-en">NET WORK</div>
        </div>
        <div class="net-group">
            <?php if(is_array($clinic) || $clinic instanceof \think\Collection || $clinic instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($clinic) ? array_slice($clinic,0,4, true) : $clinic->slice(0,4, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <a class="item" href="<?php echo url('Article/info',['id'=>$vo['id']]); ?>">
                <img src="<?php echo $vo['thumb']; ?>">
                <div class="item-cont">
                    <h1><?php echo $vo['title']; ?></h1>
                    <p>服务项目：<?php echo $vo['service']; ?></p>
                    <p>地&emsp;&emsp;址：<?php echo $vo['address']; ?></p>
                    <p>预约电话：<?php echo $vo['tel']; ?></p>
                </div>
            </a>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <a href="<?php echo url('Article/lists',['cid'=>1]); ?>" class="index-more"></a>
    </div>
    <div class="index-news">
        <div class="index-title">
            <div class="title">健康新知</div>
            <div class="title-en">HEALTH KNOWLEDGE</div>
        </div>
        <div class="news-group">
            <?php if(is_array($article) || $article instanceof \think\Collection || $article instanceof \think\Paginator): $i = 0; $__LIST__ = $article;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <a class="item" href="<?php echo url('Article/info',['id'=>$vo['id']]); ?>">
                <div class="title"><?php echo $vo['title']; ?></div>
                <div class="date"><?php echo date("Y-m-d",$vo['update_time']); ?></div>
            </a>
            <?php endforeach; endif; else: echo "" ;endif; ?>
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
        </div>
    </div>
    <div class="modal bottom cate-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">思众健康</div>
                <div class="modal-body">
                    <ul>
                        <li <?php if(empty(\think\Request::instance()->param('cid')) || ((\think\Request::instance()->param('cid') instanceof \think\Collection || \think\Request::instance()->param('cid') instanceof \think\Paginator ) && \think\Request::instance()->param('cid')->isEmpty())): ?>class="active"<?php endif; ?>><a href="<?php echo url('Index/index'); ?>"><span>首页</span></a></li>
                        <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <li <?php if(\think\Request::instance()->param('cid') == $vo['id']): ?>class="active"<?php endif; ?>><a href="<?php echo url('Article/lists',['cid'=>$vo['id']]); ?>"><span><?php echo $vo['name']; ?></span></a></li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('.index-banner').flexslider({
                animation: "slide",
                animationLoop: true,
                slideshowSpeed: 5000, // 自动播放速度毫秒
                animationSpeed: 600, //滚动效果播放时长
                directionNav: false
            });
            $('.index-service').flipster({
                style: 'carousel',
                start: 0,
                enableTouch:true
            });
            $('.menu').click(function(){
                $('.cate-modal').modal('show');
            })
        })
    </script>


<footer>
	<p><?php echo $config['copyright']; ?></p>
	<p><a href="http://www.miitbeian.gov.cn">湘ICP备17000762号</a></p>
	<p>地址：<?php echo $config['address']; ?></p>
	<p>电话：<?php echo $config['hot_tel']; ?></p>
</footer>
</body>
</html>
