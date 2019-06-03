<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:57:"../application/index/view/mobile/article\index_about.html";i:1544630729;s:49:"../application/index/view/mobile/Common\base.html";i:1544630729;}*/ ?>
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
	
	<link rel="stylesheet" type="text/css" href="__CSS__/mobile.css">
</head>
<body class="index_about">

<header>
    <div class="header">
        <div class="nav-left">
            <a class="back" href="<?php echo url('Index/index'); ?>"></a>
        </div>
        <div class="header-title"><?php echo $data['name']; ?></div>
    </div>
</header>
<div class="inner-list">
    <div class="ptitle"></div>
    <?php if(is_array($subcate) || $subcate instanceof \think\Collection || $subcate instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($subcate) ? array_slice($subcate,0,5, true) : $subcate->slice(0,5, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <div class="item item_<?php echo $i; ?>">
        <div class="item-img"><img src="__IMG__/about_img_<?php echo $i; ?>.png" class="pimg"></div>
        <div class="pcont">
            <div class="title"><?php echo $vo['name']; ?> </div>
            <div class="content"><?php echo $vo['seo_description']; ?> </div>
            <div class="more"><a href="<?php echo url('lists',['cid'=>$vo['id']]); ?>">更多</a></div>
        </div>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</div>


<footer>
	<p><?php echo $config['copyright']; ?></p>
	<p><a href="http://www.miitbeian.gov.cn">湘ICP备17000762号</a></p>
	<p>地址：<?php echo $config['address']; ?></p>
	<p>电话：<?php echo $config['hot_tel']; ?></p>
</footer>
</body>
</html>
