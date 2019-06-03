<?php
namespace app\admin\controller;
use think\Db;
use think\Loader;

class Weichat extends Base {
	/**
	 * 	微信配置
	 *   */
	public function index(){
		$mod=model('WeichatConfig');
		if($this->request->isPost()){
			$res = $mod->updates();
			if(!$res){
				$this->error($mod->getError());
			}else{
				if(isset($_POST['id'])){
					$this->success('更新成功');
				}else{
					$this->success('新增成功');
				}
			}
		}else{
			$data=$mod->where('id',1)->find();
			if($data) $this->assign('data',$data);
			return $this->fetch();
		}
	}
	/*
	 * 微信客服
	 * */
    public function customer(){
        $config=Db::name('WeichatConfig')->where(array('id'=>1))->find();
        $appid=$config['appid'];
        $appSecret=$config['appsecret'];
        Loader::import('Org.Weichat.WeichatAuth', EXTEND_PATH);
        $oauth=new \WeichatAuth($appid, $appSecret);
        $oauth->getAccessToken();
        $res = $oauth->getKflist();
        if(isset($res['kf_list'])){
            $data=$res['kf_list'];
        }else{
            $data=array();
        }
        $this->assign('data',$data);
        return $this->fetch();
    }
    /*
	 * 添加微信客服
	 * */
    public function add_customer(){
        if(request()->isPost()){
            $kf_account=input('account');
            $nickname=input('nickname');
            $invite_wx=input('invite_wx');
            $config=Db::name('WeichatConfig')->where(array('id'=>1))->find();
            $appid=$config['appid'];
            $appSecret=$config['appsecret'];
            Loader::import('Org.Weichat.WeichatAuth', EXTEND_PATH);
            $oauth=new \WeichatAuth($appid, $appSecret);
            $oauth->getAccessToken();
            $res=$oauth->addKfaccount($kf_account,$nickname);
            //上传头像
            if($_FILES){
                $file_name = $_FILES['kf_headimgurl']['name'];
                $type = $_FILES['kf_headimgurl']['type'];
                $tmp_name = $_FILES['kf_headimgurl']['tmp_name'];
                if (class_exists('\CURLFile')) {
                    $media = curl_file_create(realpath($tmp_name), $type, $file_name);
                }else{
                    $media="@".realpath($tmp_name);
                }
                $res=$oauth->uploadKfhead($kf_account,$media);
            }
            if($res['errcode']==0){
                //邀请绑定客服帐号
                $res=$oauth->inviteWorker($kf_account,$invite_wx);
                if($res['errcode']==0){
                    $this->success('客服添加成功');
                }
            }
            if($res['errcode']==0) {
                $this->success('操作成功');
            }else{
                $this->error($this->customer_error($res['errcode']));
            }
        }else{
            return $this->fetch();
        }
    }
    /*
	 * 编辑微信客服
	 * */
    public function edit_customer(){
        if(request()->isPost()){
            $kf_account=input('account');
            $nickname=input('nickname');
            $invite_wx=input('invite_wx');
            $config=Db::name('WeichatConfig')->where(array('id'=>1))->find();
            $appid=$config['appid'];
            $appSecret=$config['appsecret'];
            Loader::import('Org.Weichat.WeichatAuth', EXTEND_PATH);
            $oauth=new \WeichatAuth($appid, $appSecret);
            $oauth->getAccessToken();
            if($nickname!=''){
                $res=$oauth->updateKfaccount($kf_account,$nickname);
                if($res['errcode']==0) {
                    $this->success('操作成功');
                }else{
                    $this->error($this->customer_error($res['errcode']));
                }
            }
            //上传头像
            if(isset($_FILES) && !empty($_FILES)){
                $file_name = $_FILES['kf_headimgurl']['name'];
                $type = $_FILES['kf_headimgurl']['type'];
                $tmp_name = $_FILES['kf_headimgurl']['tmp_name'];
                if (class_exists('\CURLFile')) {
                    $media = curl_file_create(realpath($tmp_name), $type, $file_name);
                }else{
                    $media="@".realpath($tmp_name);
                }
                $res=$oauth->uploadKfhead($kf_account,$media);
            }
            //邀请绑定客服帐号
            if(!empty($invite_wx)){
                $res=$oauth->inviteWorker($kf_account,$invite_wx);
                if($res['errcode']==0) {
                    $this->success('操作成功');
                }else{
                    $this->error($this->customer_error($res['errcode']));
                }
            }

            if(!isset($res['errcode']) || $res['errcode']==0) {
                $this->success('操作成功');
            }else{
                $this->error($this->customer_error($res['errcode']));
            }
        }else{
            $kf_account=input('account');
            $this->assign('kf_account',$kf_account);
            return $this->fetch('add_customer');
        }
    }
    /*
     * 删除客服
     * */
    public function del_customer($account){
        $config=Db::name('WeichatConfig')->where(array('id'=>1))->find();
        $appid=$config['appid'];
        $appSecret=$config['appsecret'];
        Loader::import('Org.Weichat.WeichatAuth', EXTEND_PATH);
        $oauth=new \WeichatAuth($appid, $appSecret);
        $oauth->getAccessToken();
        $res=$oauth->delKfaccount($account);
        if($res['errcode']==0) {
            $this->success('操作成功');
        }else{
            $this->error($this->customer_error($res['errcode']));
        }
    }
	/*
	 * 关键词回复
	 *   */
	public function reply(){
		$data=Db::name('WeichatReply')->order('listorder ASC')->paginate();
        $this->assign('data',$data);
        $this->assign('page',$data->render());
        return $this->fetch();
	}
	/*
	 * 添加文字回复
	 *   */
	public function add_reply_text(){
        return $this->fetch();
	}
    /*
     * 添加图片回复
     *   */
    public function add_reply_pic(){
        return $this->fetch();
    }
    /*
     * 添加图文回复
     *   */
    public function add_reply_news(){
        return $this->fetch();
    }
    /*
     * 修改关键词回复
     * */
    public function edit_reply($id){
        $data=Db::name('WeichatReply')->where('id',$id)->find();
        if(!$data) $this->error('记录不存在');
        if($data['type']=='text'){
            $data['text']=Db::name('WeichatReplyText')->where('reply_id',$data['id'])->find();
            $this->assign('data',$data);
            return $this->fetch('add_reply_text');
        }elseif ($data['type']=='image'){
            $data['pic']=Db::name('WeichatReplyPic')->where('reply_id',$data['id'])->find();
            $this->assign('data',$data);
            return $this->fetch('add_reply_pic');
        }elseif ($data['type']=='news'){
            $data['news']=Db::name('WeichatReplyNews')->where('reply_id',$data['id'])->limit(8)->select();
            $this->assign('data',$data);
            return $this->fetch('add_reply_news');
        }
    }
    /*
     * 更新回复
     *   */
    public function update_reply(){
        $res = model('WeichatReply')->updates();
        if(!$res){
            $this->error(model('WeichatReply')->getError());
        }else{
            if(isset($_POST['id'])){
                $this->success('更新成功','reply');
            }else{
                $this->success('新增成功');
            }
        }
    }
    /*
	 * 删除关键词
	 *   */
    public function del_reply($id){
        $mod=model('WeichatReply');
        if($mod->del($id)){
            $this->success('删除成功！');
        }else{
            $this->error('删除失败！');
        }
    }
	/*
	 * 自定义菜单
	 *   */
	public function menu(){
		$data=model('WeichatMenu')->select();
		$data=unlimitedForCat($data);
		$this->assign('data',$data);
		return $this->fetch();
	}
	/*
	 * 添加自定义菜单
	 *   */
	public function add_menu(){
		$mod=model('WeichatMenu');
    	//获取所有上级
    	$top_menu=$mod->where(array('parent_id'=>0,'status'=>1))->select();
    	$this->assign('top_menu',$top_menu);
    	//获取所有关键字
    	$keywords=model('WeichatReply')->field(array('id','keywords'))->where(array('status'=>1))->select();
    	$this->assign('keywords',$keywords);
    	return $this->fetch();
    	
	}
	/*
	 * 修改自定义菜单
	 *   */
	public function edit_menu($id){
		$mod=model('WeichatMenu');
		
		//获取所有上级
		$top_menu=$mod->where(array('parent_id'=>0,'status'=>1))->select();
		$this->assign('top_menu',$top_menu);
		//获取所有关键字
		$keywords=model('WeichatReply')->field(array('id','keywords'))->where(array('status'=>1))->select();
		$this->assign('keywords',$keywords);
		
		$data=$mod->details($id);
		$this->assign('data',$data);
		return $this->fetch('add_menu');
		
	}
	/*
	 * 更新菜单
	 * */
	public function update_menu(){
		$mod=model('WeichatMenu');
		$res = $mod->updates();
		if(!$res){
			$this->error($mod->getError());
		}else{
			if(isset($_POST['id'])){
				$this->success('更新成功');
			}else{
				$this->success('新增成功');
			}
		}
	}
	/*
	 * 删除自定义菜单
	 *   */
	public function del_menu($id){
		$mod=model('WeichatMenu');
		if($mod->del($id)){
			$this->success('删除成功！');
		}else{
			$this->error('删除失败！');
		}
	}
	/*
	 * 排序
	 *   */
	public function menu_listorder(){
		if($this->request->isPost()){
			$mod=model('WeichatMenu');
			foreach($_POST['listorders'] as $id => $listorder) {
				$id = intval($id);
				$mod->where(array('id'=>$id))->setField('listorder',$listorder);
			}
		}
		$this->success('操作成功！');
	}
	/*
	 * 修改状态
	 *   */
	public function menu_status($id){
		$status=input('status',0,'intval')?0:1;
		$mod=model('WeichatMenu');
		$mod->where(array('id'=>$id))->setField('status',$status);
		$this->redirect($_SERVER['HTTP_REFERER']);
	
	}
    /*
     * 上传素材
     *   */
    public function upload_media(){
        //上传头像
        if(isset($_FILES) && !empty($_FILES)){
            $file_name = $_FILES['media']['name'];
            $type = $_FILES['media']['type'];
            $tmp_name = $_FILES['media']['tmp_name'];
            if (class_exists('\CURLFile')) {
                $media = curl_file_create(realpath($tmp_name), $type, $file_name);
            }else{
                $media="@".realpath($tmp_name);
            }
        }else{
            $this->error('上传图片不存在');
        }
        $config=Db::name('WeichatConfig')->where(array('id'=>1))->find();
        $appid=$config['appid'];
        $appSecret=$config['appsecret'];
        Loader::import('Org.Weichat.WeichatAuth', EXTEND_PATH);
        $oauth=new \WeichatAuth($appid, $appSecret);
        $oauth->getAccessToken();
        $res=$oauth->materialAddMaterial($media,'image');
        if(isset($res['errcode'])) {
            $this->error('素材上传失败');
        }else{
            $this->success('操作成功','',$res);
        }
    }
    /*
     * 获取素材
     *   */
    public function get_media_list(){
        $page=input('page');
        $count=20;
        $offset=($page-1)*$count;
        $config=Db::name('WeichatConfig')->where(array('id'=>1))->find();
        $appid=$config['appid'];
        $appSecret=$config['appsecret'];
        Loader::import('Org.Weichat.WeichatAuth', EXTEND_PATH);
        $oauth=new \WeichatAuth($appid, $appSecret);
        $oauth->getAccessToken();
        $res=$oauth->mediaBatchGet('image',$offset,$count);
        if(isset($res['errcode']) && $res['errcode']>0){
            $this->error('获取失败');
        }else{
            $totalpage=ceil($res['total_count']/$count);
            if($totalpage>1){
                if($page==1){
                    $res['prev']=false;
                    $res['next']=true;
                }elseif($page==$totalpage){
                    $res['prev']=true;
                    $res['next']=false;
                }else{
                    $res['prev']=$res['next']=true;
                }
            }else{
                $res['prev']=$res['next']=false;
            }
            $this->success('获取成功','',$res);
        }
    }
	//同步到微信
	public function sendToWeichat(){
		$ch = curl_init();
		$config=db('WeichatConfig')->where(array('id'=>1))->find();
		if(!$config) $this->error('请先配置微信参数！','index');
		$appid=$config['appid'];
		$appSecret=$config['appsecret'];
		$token_access = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appSecret;
        curl_setopt($ch, CURLOPT_URL,$token_access);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $token_content = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Errno' . curl_error($ch);
        }
        curl_close($ch);

        $token_info = json_decode($token_content);
        $access_token = $token_info->access_token;
		$menuApi = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
		
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$menuApi);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->menuToJson());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Errno' . curl_error($ch);
        }
        curl_close($ch);

        $msg_info = json_decode($tmpInfo);
        $msg = $msg_info->errmsg;
        if ($msg == 'ok') {
            $this->success('同步成功,需要重新关注或等待一定时间方可见效！');
        } elseif ($msg == 'access_token missing') {
            $this->error("您没有设置微信公众平台APPID和secret参数或参数填写不正确，请在公众账号中绑定参数！");
        } else {
            $this->error($msg);
        }
        exit();
	}
	/**
	 * 菜单数据
	 * @return mixed  */
	private function menuToJson(){
		$menu=model('WeichatMenu')->where(array('status'=>1,'parent_id'=>0))->order('listorder ASC,create_time DESC')->limit(3)->select();
		$arr=array();
		$i=0;
		foreach($menu as $v){
			$child=model('WeichatMenu')->where(array('status'=>1,'parent_id'=>$v['id']))->order('listorder ASC,create_time DESC')->limit(5)->select();
			if($child){
				$arr[$i]=array(
					'name'=>$v['name']
				);
				foreach($child as $val){
					if($val['type']=='click'){
						$arr[$i]['sub_button'][]=array(
							'type'=>$val['type'],
							'name'=>$val['name'],
							'key'=>$val['keywords_name']
						);
					}elseif($val['type']=='view'){
						$arr[$i]['sub_button'][]=array(
							'type'=>$val['type'],
							'name'=>$val['name'],
							'url'=>$val['link']
						);
					}
				}
			}else{
				if($v['type']=='click'){
					$arr[$i]=array(
						'name'=>$v['name'],
						'type'=>$v['type'],
						'key'=>$v['keywords_name']
					);
				}elseif($v['type']=='view'){
					$arr[$i]=array(
						'name'=>$v['name'],
						'type'=>$v['type'],
						'url'=>$v['link']
					);
				}
			}
			$i++;
		}
		$menuArr['button'] = $arr;
		$json = json_encode($menuArr);
		$json=$this->decodeUnicode($json);
		return $json;
	}
	//json字符中u编码转中文
	private function decodeUnicode($str){
		return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', create_function('$matches',
			'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'), $str);
	}
	/*
	 * 微信客服错误提示
	 * */
	private function customer_error($errcode){
        $err=array(
            '40005'=>'不支持的媒体类型',
            '40009'=>'媒体文件长度不合法',
            '41005'=>'media data missing hint: [Xpd7wa0320svr3]',
            '65400'=>'API不可用',
            '65401'=>'无效客服帐号',
            '65403'=>'客服昵称不合法',
            '65404'=>'客服帐号不合法',
            '65405'=>'帐号数目已达到上限，不能继续添加',
            '65406'=>'已经存在的客服帐号',
            '65407'=>'邀请对象已经是本公众号客服',
            '65408'=>'本公众号已发送邀请给该微信号',
            '65409'=>'无效的微信号',
            '65410'=>'邀请对象绑定公众号客服数量达到上限',
            '65411'=>'该帐号已经有一个等待确认的邀请，不能重复邀请',
            '65412'=>'该帐号已经绑定微信号，不能进行邀请',
        );
        return isset($err[$errcode])?$err[$errcode]:'未知错误';
    }
}