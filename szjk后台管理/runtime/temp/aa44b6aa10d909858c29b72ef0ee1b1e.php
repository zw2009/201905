<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:58:"../application/index/view/mobile/article\info_service.html";i:1544630729;s:49:"../application/index/view/mobile/Common\base.html";i:1544630729;}*/ ?>
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
<body class="index_article">

<header>
	<div class="header">
		<div class="nav-left">
			<a class="back" href="<?php echo url('Index/index'); ?>"></a>
		</div>
		<div class="header-title"><?php echo $data['title']; ?></div>
	</div>
</header>
<div class="inner-cont">
	<?php echo $data['content']; ?>
</div>


<footer>
	<p><?php echo $config['copyright']; ?></p>
	<p><a href="http://www.miitbeian.gov.cn">湘ICP备17000762号</a></p>
	<p>地址：<?php echo $config['address']; ?></p>
	<p>电话：<?php echo $config['hot_tel']; ?></p>
</footer>
</body>
</html>
