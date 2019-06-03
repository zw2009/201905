<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace app\common\taglib;
use think\template\TagLib;
/**
 * Html标签库驱动
 */
class Form extends TagLib{
    // 标签定义
    protected $tags   =  [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'editor'    => ['attr'=>'id,name,style,width,height,type','close'=>1],
        'image'     => ['attr'=>'name,width,height,value','close'=>0],
        'file'     => ['attr'=>'name,filesize,accept,value','close'=>0],
        'multiimage'=> ['attr'=>'name,width,height,value','close'=>0]
    ];

    /**
     * editor标签解析 插入可视化编辑器
     * 格式：{Form:editor name="intro"}{$data.intro|default=''}{/Form:editor}
     * @access public
     * @param array $tag 标签属性
     * @return string|void
     */
    public function tagEditor($tag,$content) {
        $id			=	!empty($tag['id'])?$tag['id']: '_editor';
        $name   	=	$tag['name'];
        if(strstr($name,'$')) $name="<?php echo $name;?>";
        $style   	=	!empty($tag['style'])?$tag['style']:'';
        $width		=	!empty($tag['width'])?$tag['width']: '100%';
        $height     =	!empty($tag['height'])?$tag['height'] :'320px';
        $itemconfig='';
        if(isset($tag['simple']) && $tag['simple']==true){
            $items = "[
			'source', '|', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
			'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
			'insertunorderedlist', '|', 'emoticons', 'image', 'multiimage', 'link', 'unlink']";
            $itemconfig = "items :{$items},";
        }

        $parseStr   =  "<script charset='utf-8'   src='__PLUGS__/kindeditor/kindeditor-all.js'></script>
						<script charset='utf-8'   src='__PLUGS__/kindeditor/lang/zh-CN.js'></script>
						<script>
							KindEditor.ready(function(K) {
								var options_".$name."={
									cssPath : '__PLUGS__/kindeditor/plugins/code/prettify.css',
									uploadJson : '".url('Admin/Common/editor_upload')."',
									fileManagerJson : '".url('Admin/Common/file_manager')."',
									allowFileManager : true,
									".$itemconfig."
									afterBlur: function () { this.sync(); }
								};
								var editor_".$name." = K.create('textarea[name=".$name."]',options_".$name.");
				        });
				        </script>
				        <textarea id=".$name." name=".$name." style='height:$height;width:$width'>$content</textarea>";

        return $parseStr;
    }
    /**
     * image标签解析 调用编辑器上传组件
     * 格式： {Form:image name="pic" width="100" height="100" value='../images/abc.png'/}
     * @access public
     * @param array $tag 标签属性
     * @return string|void
     */
    public function tagImage($tag) {
        $name   	=	$tag['name'];
        $value      =   isset($tag['value'])?$tag['value']:'';
        $width      =   isset($tag['width'])?$tag['width']:'';
        $height     =   isset($tag['height'])?$tag['height']:'';
        if(strstr($name,'$')) $name="<?php echo $name;?>";
        $flag  = substr($value, 0, 1);
        if ('$' == $flag || ':' == $flag) {
            $value = $this->autoBuildVar($value);
            $value = "<?php echo isset($value)?$value:''?>";
        } else {
            $value = '\'' . $value . '\'';
        }
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randpwd = '';
        for ($i = 0; $i < 5; $i++){
            $randpwd .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        $id         =   uniqid().$randpwd;
        $parseStr   =  "<script charset='utf-8'   src='__PLUGS__/kindeditor/kindeditor-all.js'></script>
						<script charset='utf-8'   src='__PLUGS__/kindeditor/lang/zh-CN.js'></script>
                        <link rel='stylesheet' href='__PLUGS__/kindeditor/themes/default/default.css' />
						<script>
						    var K=window.KindEditor;
                            var options={
                                cssPath : '__PLUGS__/kindeditor/plugins/code/prettify.css',
                                uploadJson : \"{:url('Admin/Common/editor_upload',['width'=>'$width','height'=>'$height'])}\",
                                fileManagerJson : \"{:url('Admin/Common/file_manager')}\",
                                allowFileManager : true
                            };
                            var Image = K.editor(options);
                            $(document).ready(function(){
                                var ele='input[name=$name]';
                                $('body').delegate('#$id','click',function(){
                                    Image.loadPlugin('image', function() {
                                        Image.plugin.imageDialog({
                                            imageUrl : K(ele).val(),
                                            clickFn : function(url) {
                                                K(ele).val(url);
                                                $('.img-preview[data-id=$id] img').attr('src',url);
                                                Image.hideDialog();
                                            }
                                        });
                                    });
                                })
                                $('.img-del[data-id=$id]').click(function(){
                                     $('.img-preview[data-id=$id] img').attr('src','');
                                     $(ele).val('');
                                })
                            })
                            
				        </script>
				        <div class='input-group'>
                            <input type='text' class='form-control' name='$name' readonly value={$value}>
                            <label class='input-group-addon' id='$id'>选择图片</label>
                        </div>
                        <div class='img-preview' data-id='$id' style='position:relative;width:125px;height:95px;border:1px solid #ddd;padding:2px;border-radius: 5px;margin-top:9px;'>
                            <span class='img-del' data-id='$id' style='position: absolute;right:-6px;top:-6px;background: #fff;width:18px;height:18px;line-height:16px;text-align:center;color:#ddd;border:1px solid #ddd;border-radius: 10px;cursor:pointer;'>&times;</span>
                            <img src='$value' onerror='this.src=\"__COMMON__/images/nopic.png\"' style='display: block;width: 120px;height: 90px;'>
                        </div>
                        ";
        return $parseStr;
    }
    public function tagMultiimage($tag) {
        $name   	=	$tag['name']."[]";
        $value      =   isset($tag['value'])?$tag['value']:'';
        $width      =   isset($tag['width'])?$tag['width']:'';
        $height     =   isset($tag['height'])?$tag['height']:'';
        if(strstr($name,'$')) $name="<?php echo $name;?>";
        $flag  = substr($value, 0, 1);
        if ('$' == $flag || ':' == $flag) {
            $value = $this->autoBuildVar($value);
        } else {
            $value = '\'' . $value . '\'';
        }
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randpwd = '';
        for ($i = 0; $i < 5; $i++){
            $randpwd .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        $id         =   uniqid().$randpwd;
        $parseStr   =  "<script charset='utf-8'   src='__PLUGS__/kindeditor/kindeditor-all.js'></script>
						<script charset='utf-8'   src='__PLUGS__/kindeditor/lang/zh-CN.js'></script>
                        <link rel='stylesheet' href='__PLUGS__/kindeditor/themes/default/default.css' />
						<script>
						    var K=window.KindEditor;
                            var options={
                                cssPath : '__PLUGS__/kindeditor/plugins/code/prettify.css',
                                uploadJson : \"{:url('Admin/Common/editor_upload',['width'=>'$width','height'=>'$height'])}\",
                                fileManagerJson : \"{:url('Admin/Common/file_manager')}\",
                                allowFileManager : true
                            };
                            var Image = K.editor(options);
                            $(document).ready(function(){
                                var ele='input[name=$name]';
                                var itemCss='position:relative;width:150px;height:150px;float:left;margin:0 15px 15px 0;border:1px dashed #ddd;background-size: cover;';
                                var delCss='position: absolute;right:-6px;top:-6px;background: #fff;width:18px;height:18px;line-height:16px;text-align:center;color:#ddd;border:1px solid #ddd;border-radius: 10px;cursor:pointer;';
                                $('body').delegate('#$id','click',function(){
                                    Image.loadPlugin('image', function() {
                                        Image.plugin.imageDialog({
                                            imageUrl : '',
                                            clickFn : function(url) {
                                                $('#$id').before('<div class=\"multi-priview-item\" style=\"background:url('+url+') no-repeat center center;'+itemCss+'\"><div class=\"multi-del\" style=\"'+delCss+'\">&times;</div><input type=\"hidden\" value=\"'+url+'\" name=\"$name\"></div>');
                                                Image.hideDialog();
                                            }
                                        });
                                    });
                                })
                                $('body').delegate('.multi-priview-item .multi-del','click',function(){
                                    $(this).parents('.multi-priview-item').remove();
                                })
                            })
				        </script>
				        ";
        $parseStr.='<div class="multi-priview" data-id="'.$id.'">
				            <?php if(isset('.$value.') && is_array('.$value.')){?>
				            <?php foreach('.$value.' as $k=>$v){?>
				            <div class="multi-priview-item" style="position:relative;width:150px;height:150px;float:left;margin:0 15px 15px 0;border:1px dashed #ddd;background-size: cover;background-image:url(<?php echo $v;?>)">
                                <div class="multi-del" style="position: absolute;right:-6px;top:-6px;background: #fff;width:18px;height:18px;line-height:16px;text-align:center;color:#ddd;border:1px solid #ddd;border-radius: 10px;cursor:pointer;">&times;</div>
                                <input name="'.$name.'" type="hidden" value=\'<?php echo $v;?>\'>
                            </div>
                            <?php }}?>
                            <div id="'.$id.'" style="width:150px;height:150px;float:left;margin:0 10px 10px 0;border:1px dashed #ddd;background:url(__COMMON__/images/upimg.png) no-repeat center center;background-size: 50%;"></div>
                        </div>';
        return $parseStr;
    }
    /**
     * image标签解析 调用编辑器上传组件
     * 格式： {Form:image name="pic" width="100" height="100" value='../images/abc.png'/}
     * @access public
     * @param array $tag 标签属性
     * @return string|void
     */
    public function tagFile($tag) {
        $name   	=	$tag['name'];
        $value      =   isset($tag['value'])?$tag['value']:'';
        $filesize   =   isset($tag['filesize'])?$tag['filesize']:'';
        $accept      =   isset($tag['accept'])?$tag['accept']:'';
        if(strstr($name,'$')) $name="<?php echo $name;?>";
        $flag  = substr($value, 0, 1);
        if ('$' == $flag || ':' == $flag) {
            $value = $this->autoBuildVar($value);
            $value = "<?php echo isset($value)?$value:''?>";
        } else {
            $value = '\'' . $value . '\'';
        }
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randpwd = '';
        for ($i = 0; $i < 5; $i++){
            $randpwd .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        $id         =   uniqid().$randpwd;
        $parseStr   =  "<script charset='utf-8'   src='__PLUGS__/kindeditor/kindeditor-all.js'></script>
						<script charset='utf-8'   src='__PLUGS__/kindeditor/lang/zh-CN.js'></script>
                        <link rel='stylesheet' href='__PLUGS__/kindeditor/themes/default/default.css' />
						<script>
						    var K=window.KindEditor;
                            var options={
                                cssPath : '__PLUGS__/kindeditor/plugins/code/prettify.css',
                                uploadJson : \"{:url('Admin/Common/editor_upload',['filesize'=>'$filesize','accept '=>'$accept'])}\",
                                fileManagerJson : \"{:url('Admin/Common/file_manager')}\",
                                allowFileManager : true
                            };
                            var Files = K.editor(options);
                            $(document).ready(function(){
                                var ele='input[name=$name]';
                                $('body').delegate('#$id','click',function(){
                                    Files.loadPlugin('insertfile', function() {
                                        Files.plugin.fileDialog({
                                            imageUrl : K(ele).val(),
                                            clickFn : function(url) {
                                                K(ele).val(url);
								                Files.hideDialog();
                                            }
                                        });
                                    });
                                })
                                $('body').delegate('#".$id."_del','click',function(){
                                    K(ele).val('');
                                })
                            })
                            
				        </script>
				        <div class='input-group'>
                            <input type='text' class='form-control' name='$name' readonly value={$value}>
                            <label class='input-group-addon' id='".$id."_del'>&times;</label>
                            <label class='input-group-addon' id='$id'>选择文件</label>
                        </div>
                        ";
        return $parseStr;
    }
}