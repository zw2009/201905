<?php
namespace app\common\validate;

use think\Validate;
class Article extends Validate{
	protected $rule = [
	    ['title','require|length:1,80','标题不得为空|标题长冬不得超过80个字符'],
	    ['cate_id','number|gt:0','文章分类选择有误|分类选择有误'],
	    ['keywords','max:40','关键词不得超过40个字符'],
	    ['description','length:0,255','描述内容不得超过255个字符'],
	    ['content','require','内容不得为空'],
	    ['listorder','number','排序填写有误'],
	];
}