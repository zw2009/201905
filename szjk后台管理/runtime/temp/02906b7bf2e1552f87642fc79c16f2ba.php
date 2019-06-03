<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:67:"D:\wwwroot\szjk\public/../application/admin\view\article\index.html";i:1544630727;s:65:"D:\wwwroot\szjk\public/../application/admin\view\Common\base.html";i:1544630727;}*/ ?>
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
			
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">筛选</h3>
		</div>
		<div class="panel-body">
			<form class="form-inline filter">
				<div class="form-group">
					<label>标题：</label>
					<input type="text" name="keywords" class="form-control input-sm" placeholder="标题/关键字" value="<?php echo (isset($_GET['keywords']) && ($_GET['keywords'] !== '')?$_GET['keywords']:''); ?>">
				</div>
				<div class="form-group">
					<label>更新时间：</label>
					<div class="input-group">
				      	<input type="text" name="start_date" class="form-control input-sm" size="10" value="<?php echo (isset($_GET['start_date']) && ($_GET['start_date'] !== '')?$_GET['start_date']:''); ?>" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})">
				     	<div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
				    </div>
				</div>
				<div class="form-group">
					<label>到</label>
					<div class="input-group">
				      	<input type="text" name="end_date" class="form-control input-sm" size="10" value="<?php echo (isset($_GET['end_date']) && ($_GET['end_date'] !== '')?$_GET['end_date']:''); ?>" onClick="WdatePicker({dateFmt: 'yyyy-MM-dd'})">
				     	<div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
				    </div>
				</div>
				<div class="form-group">
				<button type="submit" class="btn btn-danger input-sm">搜索</button>
				</div>
			</form>
		</div>
	</div>
	
	<div class="form-group">
		<a href="<?php echo url('add',['type'=>$type]); ?>" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-plus"></i> 添加内容</a>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-body">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>标题</th>
						<th width="200" class="text-center">所属栏目</th>
						<th width="80" class="text-center">点击量</th>
						<th width="80" class="text-center">状态</th>
						<th width="80" class="text-center">推荐</th>
						<th width="80" class="text-center">系统文章</th>
						<th width="130" class="text-center">更新时间</th>
						<th width="120" class="text-right">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($data)): if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$news): $mod = ($i % 2 );++$i;?>
					<tr>
						<td><?php echo $news['id']; ?></td>
						<td><?php echo $news['title']; ?></td>
						<td class="text-center"><?php echo $news['cate_name']; ?></td>
						<td class="text-center"><?php echo $news['click_count']; ?></td>
						<td class="text-center">
							<a href="<?php echo url('news_status',array('id'=>$news['id'])); ?>"><?php echo yes_or_no($news['status']); ?></a>
						</td>
						<td class="text-center">
							<a href="<?php echo url('news_recommend',array('id'=>$news['id'])); ?>">
								<?php echo yes_or_no($news['is_recommend']); ?>
							</a>
						</td>
						<td class="text-center">
							<?php echo yes_or_no($news['is_system']); ?>
						</td>
						<td class="text-center"><?php echo date("Y-m-d H:i:s",$news['update_time']); ?></td>
						<td class="text-right">
							<a href="<?php echo url('edit',array('id'=>$news['id'])); ?>">编辑</a>
							<a href="<?php echo url('del',array('id'=>$news['id'])); ?>" onclick="javascript:return confirm('确定要删除该记录？');">删除</a>
						</td>
					</tr>
					<?php endforeach; endif; else: echo "" ;endif; endif; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="99" class="text-right"><?php echo $page; ?></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

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


<script language="javascript" type="text/javascript" src="__PLUGS__/datePicker/WdatePicker.js"></script>

</html>