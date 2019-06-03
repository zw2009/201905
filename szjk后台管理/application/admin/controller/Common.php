<?php
namespace app\admin\controller;
use think\Controller;
class Common extends Controller{
	
	/**
	 * 登录
     * */
	public function login(){
		if($this->request->isPost()){
			$login_name=input('login_name');
			$password=input('password');
			$verify=input('verify');
			if(!model('Admin')->login($login_name,$password,$verify)) $this->error(model('Admin')->getError());
			$this->success('登录成功！','Index/index');
		}else{
			return view();
		}
	}
	/**
	 * 退出登录
	 *   */
	public function logout(){
		session('admin', null);
		$this->redirect('login');
	}
    /**
     * 清理缓存
     *   */
    public function del_cache(){
    	deldir(RUNTIME_PATH);
    	$this->success('缓存清理成功！');
    }
    /**
     * 上传插件上传图片
     *  */
    public function uploadify($width=0,$height=0){
    	if(!empty($_FILES)){
    		$data=uploadify(true,$width,$height);
    		if($data){
    			$res=array(
    					'status'=>1,
    					'data'=>$data
    			);
    			return json($res);
    		}else{
    			$res=array(
    					'status'=>0,
    					'data'=>'上传失败！'
    			);
    			return json($res);
    		}
    	}
    }
    /**
     * 编辑器图片上传
     *   */
    public function editor_upload(){
        $ext_arr = array(
            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
            'flash' => array('swf', 'flv'),
            'media' => array('mp4'),
            'file' => array('mp4'),
        );
        //PHP上传失败
        if (!empty($_FILES['imgFile']['error'])) {
            switch($_FILES['imgFile']['error']){
                case '1':
                    $error = '超过php.ini允许的大小。';
                    break;
                case '2':
                    $error = '超过表单允许的大小。';
                    break;
                case '3':
                    $error = '图片只有部分被上传。';
                    break;
                case '4':
                    $error = '请选择图片。';
                    break;
                case '6':
                    $error = '找不到临时目录。';
                    break;
                case '7':
                    $error = '写文件到硬盘出错。';
                    break;
                case '8':
                    $error = 'File upload stopped by extension。';
                    break;
                case '999':
                default:
                    $error = '未知错误。';
            }
            return json(array('error' => 1, 'message' => $error));
        }

        //有上传文件时
        if (empty($_FILES) === false) {
            //原文件名
            $file_name = $_FILES['imgFile']['name'];
            //服务器上临时文件名
            $tmp_name = $_FILES['imgFile']['tmp_name'];
            //文件大小
            $file_size = $_FILES['imgFile']['size'];
            //检查文件名
            if (!$file_name) {
                return json(array('error' => 1, 'message' => '请选择文件'));
            }
            //检查目录名
            $dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
            if (empty($ext_arr[$dir_name])) {
                return json(array('error' => 1, 'message' => '目录名不正确'));
            }
            //获得文件扩展名
            $temp_arr = explode(".", $file_name);
            $file_ext = array_pop($temp_arr);
            $file_ext = trim($file_ext);
            $file_ext = strtolower($file_ext);
            //检查扩展名
            if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
                return json(array('error' => 1, 'message' => "只允许" . implode(",", $ext_arr[$dir_name]) . "格式"));
            }
            $param=array();
            $param['accept']=$ext_arr[$dir_name];
            $param['dir']=$_GET['dir'];
            $param['file_ext']=$file_ext;
            $param['tmp_name']=$tmp_name;
            if($_GET['dir']=='image'){
                $width=input('width',0);
                $height=input('height',0);
                $is_thumb=0;
                if($width>0 && $height>0) $is_thumb=1;
                $info = uploads_single('imgFile',$is_thumb,$width,$height);
                if($info['code']===1) {
                    return json(array('error' => 0, 'url' => "/uploads/".$_GET['dir']."/".$info['data']));
                }else{
                    return json(array('error' => 1, 'message' => $info['msg']));
                }
            }else{
                /*$filesize=input('filesize',20*1024*1024);
                if($filesize>$file_size){
                    return json(array('error' => 1, 'message' => "文件太大，请压缩后上传"));
                }*/
                $info = uploads_file('imgFile',$_GET['dir']);
                if($info['code']===1) {
                    return json(array('error' => 0, 'url' => "/uploads/".$_GET['dir']."/".$info['data']));
                }else{
                    return json(array('error' => 1, 'message' => $info['msg']));
                }
            }

        }
    }
    /**
     * 编辑器图片管理
     *   */
    public function file_manager(){
    	$php_path = dirname(__FILE__) . '/';
    	$php_url = dirname($_SERVER['PHP_SELF']) . '/';
    	//根目录路径，可以指定绝对路径，比如 /var/www/attached/
    	$root_path = $php_path.'../../../public/uploads/';
    	//根目录URL，可以指定绝对路径，比如 http://www.yoursite.com/attached/
    	$root_url = '/uploads/';
    	//图片扩展名
    	$ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
    
    	//目录名
    	$dir_name = empty($_GET['dir']) ? '' : trim($_GET['dir']);
    	if (!in_array($dir_name, array('', 'image', 'flash', 'media', 'file'))) {
    		echo "Invalid Directory name.";
    		exit;
    	}
    	if ($dir_name !== '') {
    		$root_path .= $dir_name . "/";
    		$root_url .= $dir_name . "/";
    		//dump($root_path);
    		if (!file_exists($root_path)) {
    			mkdir($root_path);
    		}
    	}
    
    	//根据path参数，设置各路径和URL
    	if (empty($_GET['path'])) {
    		$current_path = realpath($root_path) . '/';
    		$current_url = $root_url;
    		$current_dir_path = '';
    		$moveup_dir_path = '';
    	} else {
    		$current_path = realpath($root_path) . '/' . $_GET['path'];
    		$current_url = $root_url . $_GET['path'];
    		$current_dir_path = $_GET['path'];
    		$moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
    	}
    	//echo realpath($root_path);
    	//排序形式，name or size or type
    	$order = empty($_GET['order']) ? 'name' : strtolower($_GET['order']);
    
    	//不允许使用..移动到上一级目录
    	if (preg_match('/\.\./', $current_path)) {
    		echo 'Access is not allowed.';
    		exit;
    	}
    	//最后一个字符不是/
    	if (!preg_match('/\/$/', $current_path)) {
    		echo 'Parameter is not valid.';
    		exit;
    	}
    	//目录不存在或不是目录
    	if (!file_exists($current_path) || !is_dir($current_path)) {
    		echo 'Directory does not exist.';
    		exit;
    	}
    
    	//遍历目录取得文件信息
    	$file_list = array();
    	$handle = opendir($current_path);
    	if ($handle) {
    		$i = 0;
    		while (false !== ($filename = readdir($handle))) {
    			if ($filename{0} == '.') continue;
    			$file = $current_path . $filename;
    			if (is_dir($file)) {
    				$file_list[$i]['is_dir'] = true; //是否文件夹
    				$file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
    				$file_list[$i]['filesize'] = 0; //文件大小
    				$file_list[$i]['is_photo'] = false; //是否图片
    				$file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
    			} else {
    				$file_list[$i]['is_dir'] = false;
    				$file_list[$i]['has_file'] = false;
    				$file_list[$i]['filesize'] = filesize($file);
    				$file_list[$i]['dir_path'] = '';
    				$file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    				$file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
    				$file_list[$i]['filetype'] = $file_ext;
    			}
    			$file_list[$i]['filename'] = $filename; //文件名，包含扩展名
    			$file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
    			$i++;
    		}
    		closedir($handle);
    	}
    
    	//usort($file_list, 'cmp_func');
    	$result = array();
    	//相对于根目录的上一级目录
    	$result['moveup_dir_path'] = $moveup_dir_path;
    	//相对于根目录的当前目录
    	$result['current_dir_path'] = $current_dir_path;
    	//当前目录的URL
    	$result['current_url'] = $current_url;
    	//文件数
    	$result['total_count'] = count($file_list);
    	//文件列表数组
    	$result['file_list'] = $file_list;
    
    	//输出JSON字符串
    	header('Content-type: application/json; charset=UTF-8');
    	return json($result);
    }
}
?>