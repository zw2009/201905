<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:59:"../application/index/view/default/article\info_service.html";i:1544630729;s:50:"../application/index/view/default/Common\base.html";i:1544630729;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $data['title']; ?>_<?php echo $config['webname']; ?></title>
    <meta name="keywords" content="<?php echo $data['keywords']; ?>" />
    <meta name="description" content="<?php echo $data['description']; ?>" />
    <script type="text/javascript" src="__PLUGS__/jquery-1.10.2.min.js"></script>
    <link href="__PLUGS__/FlexSlider/flexslider.css" rel="stylesheet">
    <script type="text/javascript" src="__PLUGS__/FlexSlider/jquery.flexslider.js"></script>
    
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
<body class="info_service">
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

<div class="inner-banner"></div>
<div class="inner-main">
	<div class="pleft">
		<div class="tbox">
			<b>脉先森连锁</b>
			<small>OUR CHAIN</small>
		</div>
		<ul class="mlist">
			<?php if(is_array($lists) || $lists instanceof \think\Collection || $lists instanceof \think\Paginator): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<li <?php if($data['id'] == $vo['id']): ?>class="active"<?php endif; ?>><a href="<?php echo url('info',['id'=>$vo['id']]); ?>"><?php echo $vo['title']; ?></a></li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
	<div class="pright">
		<div class="pcontent">
			<div class="content">
				<?php echo $data['content']; ?>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>

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