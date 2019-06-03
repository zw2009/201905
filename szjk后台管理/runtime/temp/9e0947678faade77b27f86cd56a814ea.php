<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:65:"D:\wwwroot\szjk\public/../application/admin\view\index\index.html";i:1544630728;s:65:"D:\wwwroot\szjk\public/../application/admin\view\Common\base.html";i:1544630727;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>思众健康 - 后台管理</title>
	<link rel="stylesheet" href="__ALT__/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="__ALT__/plugins/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="__ALT__/plugins/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="__ALT__/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="__ALT__/dist/css/skins/_all-skins.min.css">
	<link type="text/css" rel="stylesheet" href="__PLUGS__/fancySelect/fancySelect.css"/>
	<script src="__ALT__/plugins/jquery/dist/jquery.js"></script>
	<script type="text/javascript" src="__PLUGS__/fancySelect/fancySelect.js"></script>
	<script src="__ALT__/plugins/jquery-ui/jquery-ui.min.js"></script>
	<link rel="stylesheet" type="text/css" href="__CSS__/css.css" media="all">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
	<div class="main-header">
		<a href="<?php echo url('index'); ?>" class="logo">
			<span class="logo-mini">后台</span>
			<span class="logo-lg">思众健康</span>
		</a>
		<div class="navbar navbar-static-top">
			<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
				<span class="sr-only"></span>
			</a>
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<!--管理员-->
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="__IMG__/face.png" class="user-image" alt="User Image">
							<span class="hidden-xs"><?php echo $session['real_name']; ?></span>
						</a>
						<ul class="dropdown-menu">
							<!-- User image -->
							<li class="user-header">
								<img src="__IMG__/face.png" class="img-circle" alt="User Image">
								<p>
									<?php echo $session['real_name']; ?>
									<small>ID:<?php echo $session['id']; ?></small>
								</p>
							</li>
							<li class="user-footer">
								<div class="pull-left">
									<a href="<?php echo url('Shop/modify_password'); ?>" class="btn btn-default btn-flat">修改密码</a>
								</div>
								<div class="pull-right">
									<a href="<?php echo url('Common/logout'); ?>" class="btn btn-default btn-flat">退出</a>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!--菜单-->
	<div class="main-sidebar">
		<section class="sidebar">
			<!--管理员-->
			<div class="user-panel">
				<div class="pull-left image">
					<img src="__IMG__/face.png" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
					<p><?php echo $session['real_name']; ?></p>
					<a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
				</div>
			</div>
			<!--菜单导航-->
			<ul class="sidebar-menu" data-widget="tree">
				<li class="header">管理菜单</li>
				<li><a href="<?php echo url('Index/index'); ?>"><i class="fa fa-home"></i> <span>后台首页</span></a></li>
				<?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<li class="treeview <?php if(in_array(($vo['id']), is_array($arr_parent_id)?$arr_parent_id:explode(',',$arr_parent_id))): ?>active<?php endif; ?>">
					<a href="#">
						<i class="fa  fa-th-large"></i> <span><?php echo $vo['node_name']; ?></span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<?php if(isset($vo['child'])): ?>
					<ul class="treeview-menu">
						<?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?>
						<li <?php if(in_array(($sub['id']), is_array($arr_parent_id)?$arr_parent_id:explode(',',$arr_parent_id))): ?>class="active"<?php endif; ?> ><a href="<?php echo $sub['url']; ?>"><i class="fa fa-circle-o <?php if(in_array(($sub['id']), is_array($arr_parent_id)?$arr_parent_id:explode(',',$arr_parent_id))): ?>text-red<?php endif; ?>"></i><?php echo $sub['node_name']; ?></a></li>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
					<?php endif; ?>
				</li>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</section>
	</div>
	<div class="content-wrapper">
		<div class="content-header">
			<h1>
				<?php echo (isset($page_title) && ($page_title !== '')?$page_title:"后台管理"); ?>
			</h1>
			<?php if(!(empty($bread) || (($bread instanceof \think\Collection || $bread instanceof \think\Paginator ) && $bread->isEmpty()))): ?>
			<ol class="breadcrumb">
				<?php if(is_array($bread) || $bread instanceof \think\Collection || $bread instanceof \think\Paginator): $i = 0; $__LIST__ = $bread;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<li><a href="<?php echo $vo['url']; ?>"><!--<i class="fa fa-dashboard"></i>--> <?php echo $vo['node_name']; ?></a></li>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</ol>
			<?php endif; ?>
		</div>
		<!--内容-->
		<div class="content">
			
<style>
	.chart{
		background:#fff;
		padding:10px;
		margin-bottom: 15px;
	}
	.chart canvas{
		display: block;
		width:100%;
		height:300px;
	}
	.chart-labels{
		height:40px;
		line-height:40px;
		color:#666;
		text-align:right;
	}
	.chart-labels .labels{
		display: inline-block;
	}
	.chart-labels i{
		vertical-align: middle;
		display: inline-block;
		width:15px;
		height:15px;
	}
	.chart-labels span{
		vertical-align: middle;
		padding-right:10px;
	}
	.chart-title{
		height:40px;
		line-height: 40px;
		text-align: center;
	}
	.show-num-mod {
		background-color: #fff;
		border:1px solid #cdcdcd;
		height:80px;
	}
	.show-num-mod dt {
		float:left;
		width:30%;
		height:78px;
		padding:22px 0;
		text-align:center;
		border-right:1px solid #cdcdcd;
	}
	.show-num-mod dt i{
		font-size:32px;
	}
	.show-num-mod dd{
		float:left;
		width:70%;
		padding:9px;
		text-align:center;
	}
	.show-num-mod dd strong{
		display:block;
		height:30px;
		line-height:30px;
		font-size:20px;
	}
	.show-num-mod dd span{
		display:block;
		height:30px;
		line-height:30px;
	}
</style>
<div class="row">
	<div class="col-lg-4 col-xs-6">
		<div class="small-box bg-yellow">
			<div class="inner">
				<h3><?php echo (isset($team) && ($team !== '')?$team:'0'); ?></h3>
				<p>医疗团队</p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			<a href="<?php echo url('Article/team'); ?>" class="small-box-footer">查看详情 <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<div class="col-lg-4 col-xs-6">
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3><?php echo (isset($linkstore) && ($linkstore !== '')?$linkstore:'0'); ?></h3>
				<p>连锁机构</p>
			</div>
			<div class="icon">
				<i class="ion ion-bag"></i>
			</div>
			<a href="<?php echo url('Article/linkstore'); ?>" class="small-box-footer">查看详情 <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<div class="col-lg-4 col-xs-6">
		<div class="small-box bg-green">
			<div class="inner">
				<h3><?php echo (isset($service) && ($service !== '')?$service:'0'); ?></h3>
				<p>服务科室</p>
			</div>
			<div class="icon">
				<i class="ion ion-stats-bars"></i>
			</div>
			<a href="<?php echo url('Article/service'); ?>" class="small-box-footer">查看详情 <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div>
</div>
<script>
    $(document).ready(function(){

    })
</script>

		</div>
	</div>

	<div class="main-footer">
		<strong><?php echo $copyright; ?></strong>
	</div>
</div>
<!-- 模态框 -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#addForm').on('show.bs.modal', function (event) {
            var flag=true;
            var button = $(event.relatedTarget);
            var url=button.data('href');
            $.ajax({
                url:url,
                async:false,
                success:function(data){
                    if(data.code==0){
                        alert(data.msg);
                        flag=false;
                    }else{
                        $('.modal-content').html(data);
                    }
                }
            });
            return flag;
        })

        //form表单提交
        $('.ajaxSubmit').click(function(){
            var that=this;
            var value=$(this).html();
            $(this).html('正在提交').attr('disabled','disabled');
            $.ajax({
                type: $(this).parents('form').attr('method'),
                url:  $(this).parents('form').attr('action'),
                data: $(this).parents('form').serialize(),
                success: function(ret) {
                    $(that).html(value).removeAttr('disabled');
                    if(ret.code==1){
                        alert(ret.msg);
                        window.location.href=ret.url;
                    }else{
                        alert(ret.msg);
                    }
                },
				error:function(ret){
                    $(that).html(value).removeAttr('disabled');
                    alert('系统错误');
				}
            });
            return false;
        })
        $('.breadcrumb li:last-child').addClass('active').html($('.breadcrumb li:last-child a').html());
    })
</script>
<div class="modal fade" id="addForm" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">

		</div>
	</div>
</div>
</body>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="__ALT__/bootstrap/js/bootstrap.min.js"></script>
<script src="__ALT__/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="__ALT__/plugins/fastclick/lib/fastclick.js"></script>
<script src="__ALT__/plugins/moment/min/moment.min.js"></script>
<script src="__ALT__/dist/js/adminlte.min.js"></script>


</html>