<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:58:"../application/index/view/mobile/article\list_service.html";i:1544630729;s:49:"../application/index/view/mobile/Common\base.html";i:1544630729;}*/ ?>
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
<body class="list_service">

<header>
	<div class="header">
		<div class="nav-left">
			<a class="back" href="<?php echo url('Index/index'); ?>"></a>
		</div>
		<div class="header-title"><?php echo $topcate['name']; ?></div>
	</div>
</header>
<?php if(!(empty($subcate) || (($subcate instanceof \think\Collection || $subcate instanceof \think\Paginator ) && $subcate->isEmpty()))): ?>
<div class="nav">
	<div class="nav-list">
		<div class="nav-wrap">
			<?php if(is_array($subcate) || $subcate instanceof \think\Collection || $subcate instanceof \think\Paginator): $i = 0; $__LIST__ = $subcate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<a class="nav-item <?php if($vo['id'] == \think\Request::instance()->param('cid')): ?>active<?php endif; ?>" href="<?php echo url('lists',['cid'=>$vo['id']]); ?>"><?php echo $vo['name']; ?></a>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>
<div class="inner-list">
	<?php if(is_array($lists) || $lists instanceof \think\Collection || $lists instanceof \think\Paginator): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	<div class="item">
		<a href="<?php echo url('info',['id'=>$vo['id']]); ?>" class="item-img"><img src="<?php echo $vo['thumb']; ?>"></a>
		<div class="item-cont">
			<a class="title" href="<?php echo url('info',['id'=>$vo['id']]); ?>"><?php echo $vo['title']; ?></a>
			<div class="info"><?php echo $vo['description']; ?></div>
		</div>
	</div>
	<?php endforeach; endif; else: echo "" ;endif; ?>
	<div class="pageview"><?php echo $page; ?></div>
</div>
<script>
    $(document).ready(function(){
        $('.nav-wrap').width(9*$('.nav-item').size()+"rem");
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
