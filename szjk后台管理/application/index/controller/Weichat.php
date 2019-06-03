<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use Org\Weichat\WeichatApi;
class Weichat extends Controller {
   public function index(){
	   	//调试
	   	try{
	   		$config=Db::name('WeichatConfig')->where(array('id'=>1))->find();
	   		$appid		= $config['appid'];
			$appSecret	= $config['appsecret'];
	   		$token 		= $config['token']; //微信后台填写的TOKEN
	   		$crypt 		= $config['aeskey']; //消息加密KEY（EncodingAESKey）
	   		/* 加载微信SDK */
	   		$wechat = new WeichatApi($token, $appid, $crypt);
	   		/* 获取请求信息 */
	   		$data = $wechat->request();
	   		if($data){
	   			if(is_array($data)){
	   				$this->run($wechat, $data);
	   			}else{
	   				//验证token
	   				echo $data;
	   				exit;
	   			}
	   		}
	   	} catch(\Exception $e){
	   		$str=$e->getMessage()."<br/>";
	   		$str.=$e->getFile()."<br/>";
	   		$str.=$e->getLine()."<br/>";
	   		file_put_contents(APP_PATH .'/index/controller/error.log',$str);
	   	}
   }
   
   /**
    * DEMO
    * @param  Object $wechat Wechat对象
    * @param  array  $data   接受到微信推送的消息
    */
   	private function run($wechat, $data){
   		$pic_root = 'http://'.$_SERVER['HTTP_HOST'].'/uploads/image/';
   		//事件消息
   		if($data['MsgType'] == WeichatApi::MSG_TYPE_EVENT){
   			//关注事件
   			if($data['Event']==WeichatApi::MSG_EVENT_SUBSCRIBE){
   				$mod=Db::name('WeichatReply');
   				$reply_type=Db::name('WeichatConfig')->where(array('id'=>1))->value('subscribe');
   				if($reply_type==1){
   					//纯文本回复
   					$text=$mod->where(array('type'=>'text'))->value('content');
   					$wechat->replyText($text);
   					exit;
   				}else{
   					//图文回复
   					$pic=$mod->where(array('type'=>'pic'))->find();
   					if($pic){
   						$wechat->replyNewsOnce($pic['title'],$pic['content'],$pic['link'],$pic_root.$pic['pic']);
   						exit;
   					}else{
   						$wechat->replyText('感谢您的关注！');
   						exit;
   					}
   				}
   			}else{
   				$keywords = $data['EventKey'];
   			}
   			
   		}
   		elseif($data['MsgType'] == WeichatApi::MSG_TYPE_VOICE){
   			if (isset($data['Recognition']) && !empty($data['Recognition'])){
   				$keywords=$data['Recognition'];
   				$wechat->replyText($keywords);
   			}else{
   				//文本回复
   				$wechat->replyText('未开启语音识别功能或者识别内容为空');
   				exit;
   			}
   		}
   		//文本消息
   		elseif($data['MsgType'] == WeichatApi::MSG_TYPE_TEXT){
   			$keywords = $data['Content'];
   		}
   		
   		if($keywords){
   			$mod=Db::name('WeichatKeywords');
   			$res=$mod->where(array('keywords'=>array('in',$keywords),'status'=>1))->find();
   			if($res){
   				if($res['type']=='text'){
   					//文本回复
   					$wechat->replyText($res['content']);
   					exit;
   				}elseif($res['type']=='pic'){
   					//图文回复
   					$wechat->replyNewsOnce($res['title'],$res['content'],$res['link'],$pic_root.$res['pic']);
   					exit;
   				}
   			}else{
   				$default_reply=Db::name('WeichatConfig')->where(array('id'=>1))->value('default_reply');
   				if($default_reply){
   					//文本回复
   					$wechat->replyText($default_reply);
   					exit;
   				}
   			}
   		}
   		echo "";
   		exit;
   }
}