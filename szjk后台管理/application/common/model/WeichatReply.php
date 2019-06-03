<?php
namespace app\common\model;
use think\Db;
class WeichatReply extends Base{
    protected $autoWriteTimestamp = true;
	/*
	 * 新增/修改
	 * @return string|boolean  */
	public function updates($post=null){
		if($post===null) $post=input('post.');
		$data=array(
			'title'=>$post['title'],
			'keywords'=>$post['keywords'],
			'status'=>$post['status'],
			'listorder'=>$post['listorder'],
			'type'=>$post['type'],
		);
		if($post['type']=='text'){//文字回复
    		$content=array(
    			'content'=>isset($post['text']['content'])?$post['text']['content']:''
			);
            if(empty($content['content'])) return $this->error('回复内容不得为空');
		} elseif ($post ['type'] == 'image') {// 图片回复
            $content=array(
                'media_id'=>isset($post['pic']['media_id'])?$post['pic']['media_id']:''
        	);
            if(empty($content['media_id'])) return $this->error('回复图片不得为空');
		} elseif($post ['type'] == 'news') {
			$news=$post['news'];
			if(!isset($news) || empty($news)) return $this->error('回复内容不得为空');
			foreach($news as $k=>$v){
				$temp=array(
                    'pic'=>$v['pic'],
					'title'=>$v['title'],
                    'description'=>$v['description'],
					'url'=>isset($v['is_edit']) && !empty($v['is_edit'])?'':$v['url'],
					'content'=>isset($v['is_edit']) && !empty($v['is_edit'])?$v['content']:'',
				);
				if(empty($temp['pic']) || empty($temp['title']) || empty($temp['description'])) continue;
				if(empty($temp['url']) && empty($temp['content'])) continue;
                if(isset($v['id']) && !empty($v['id'])) $temp['id']=$v['id'];
				$content[]=$temp;
			}
			if(!isset($content) || empty($content))  return $this->error('回复内容不得为空');
		}else{
            return $this->error ( '类型选择有误！' );
		}
		if(isset($post['id'])) $data['id']=$post['id'];

		/* 添加或更新数据 */
		if(!isset($data['id'])){
			//新增数据
			$this->allowField(true)->save($data);
			$reply_id=$this->id;
			if(!$reply_id) return $this->error ('新增失败！');
		} else { 
			//更新数据
			$reply_id=$data['id'];
			$status = $this->allowField(true)->isUpdate(true)->save($data);
			if(false === $status) return $this->error ('更新失败！');
		}
        if($post['type']=='text'){
            $content['reply_id']=$reply_id;
			Db::name('WeichatReplyText')->where('reply_id',$reply_id)->delete();
			Db::name('WeichatReplyText')->insert($content);
        }elseif ($post['type']=='image'){
            $content['reply_id']=$reply_id;
            Db::name('WeichatReplyPic')->where('reply_id',$reply_id)->delete();
            Db::name('WeichatReplyPic')->insert($content);
        }elseif ($post['type']=='news'){
        	$ids=array_column($content,'id');
        	$ids=$ids?$ids:'';
            Db::name('WeichatReplyNews')->where('reply_id',$reply_id)->where('id','not in',$ids)->delete();
			foreach ($content as $k=>$v){
				$v['reply_id']=$reply_id;
				if(isset($v['id'])){
                    $v['update_time']=time();
                    $id=$v['id'];
                    unset($v['id']);
                    Db::name('WeichatReplyNews')->where('id',$id)->update($v);
				}else{
                    $v['update_time']=$v['create_time']=time();
                    Db::name('WeichatReplyNews')->insert($v);
				}
			}
        }
		return true;
	}
	/*
	 * 删除
	 * @param unknown $id
	 * @return boolean  */
	public function del($id){
		$reply=$this->where('id',$id)->find();
		if(!$reply) $this->error('记录不存在');
		if($this->destroy($id)){
			if($reply['type']=='text'){
				Db::name('WeichatReplyText')->where('reply_id',$id)->delete();
			}elseif ($reply['type']=='image'){
                Db::name('WeichatReplyPic')->where('reply_id',$id)->delete();
			}elseif ($reply['type']=='news'){
                Db::name('WeichatReplyNews')->where('reply_id',$id)->delete();
			}
			return true;
		}
		return $this->error("删除失败！");
	}
	
	
}

?>
