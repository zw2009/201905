<?php
return [
	'view_replace_str'       => [
        '__ALT__'=>'/static/admin/adminlte',
		'__CSS__'=>'/static/admin/css',
		'__JS__'=>'/static/admin/js',
		'__IMG__'=>'/static/admin/images',
		'__COMMON__'=>'/static/common',
		'__PLUGS__'=>'/static/common/plugs',
		'__UPIMG__'=>'/uploads/image/',
	],
	//数据库备份还原参数
	'DATA_BACKUP_PATH'=>"./Data/",//数据库备份根路径
	'DATA_BACKUP_PART_SIZE'=>'20971520',//数据库备份卷大小,单位：B；建议设置20M
	'DATA_BACKUP_COMPRESS'=>'1',//数据库备份文件是否启用压缩
	'DATA_BACKUP_COMPRESS_LEVEL'=>'9',//数据库备份文件压缩级别1:普通4:一般9:最高
	
	'UPIMG'=>'uploads/image/',
	
	'dispatch_success_tmpl'  => APP_PATH  . 'common' . DS . 'tpl' . DS . 'jump.html',
	'dispatch_error_tmpl'    => APP_PATH  . 'common' . DS . 'tpl' . DS . 'jump.html',
];