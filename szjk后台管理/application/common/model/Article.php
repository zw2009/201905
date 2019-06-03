<?php
namespace app\common\model;
use think\Db;
class Article extends Base{
    protected $autoWriteTimestamp = true;
	protected  function setcontentAttr($value){
		return htmlspecialchars($value);
	}
	public function getCateNameAttr($value,$data){
		return Db::name('Category')->where('id',$data['cate_id'])->value('name');
	}
    public function getCateTypeAttr($value,$data){
        return Db::name('Category')->where('id',$data['cate_id'])->value('type');
    }
	public function getContentAttr($value,$data){
	    return htmlspecialchars_decode(stripslashes($data['content']));
	}
	public function getCommentCountAttr($value,$data){
	    return Db::name('ArticleComment')->where('article_id',$data['id'])->count();
	}
	public function getAddonAttr($value,$data){
		$type=Db::name('Category')->where('id',$data['cate_id'])->value('type');
		if($type!='article'){
            $table='Addon'.ucfirst($type);
            $addon=Db::name($table)->where('article_id',$data['id'])->find();
		}else{
			$addon=array();
		}
		return $addon?$addon:array();
	}
	public function updates(){
		$data=input('post.');
		$data['admin_id']=session('admin.id');
		if($data['keywords']) $data['keywords']=str_replace(array('，'),array(','),$data['keywords']);

		/* 获取数据 */
		$validate = validate('Article');
		if(!$validate->check($data)){
			return $this->error($validate->getError());
		}

        if(!$data['type']) return $this->error('参数错误');
		if($data['type']=='linkstore'){
		    $addon=array(
		        'service'=>isset($data['service'])?$data['service']:'',
		        'province'=>isset($data['province'])?$data['province']:'',
		        'city'=>isset($data['city'])?$data['city']:'',
		        'area'=>isset($data['area'])?$data['area']:'',
		        'address'=>isset($data['address'])?$data['address']:'',
		        'tel'=>isset($data['tel'])?$data['tel']:''
            );
        }elseif($data['type']=='service'){
            $addon=array(
                'title_en'=>isset($data['title_en'])?$data['title_en']:''
            );
        }elseif($data['type']=='team'){
            $addon=array(
                'service'=>isset($data['service'])?$data['service']:''
            );
        }
		/* 添加或更新数据 */
		if(!isset($data['id'])){
			//新增数据
			$this->allowField(true)->save($data);
            $id=$this->id;
			if(!$id) return $this->error ('新增失败！');
		} else { 
			//更新数据
            $id=$data['id'];
			$status = $this->allowField(true)->isUpdate(true)->save($data);
			if(false === $status) return $this->error ('更新失败！');
		}
		//附加信息
        if(isset($addon)){
		    $addon['article_id']=$id;
		    $addon['update_time']=time();
		    $table='Addon'.ucfirst($data['type']);
		    Db::name($table)->where('article_id',$id)->delete();
            Db::name($table)->insert($addon);
        }
		return true;
	}

    /**
	 * 删除
     * @param $id
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
	public function del($id){
		$article=$this->where('id',$id)->find();
		if($article['is_system']==1) return $this->error('系统文章不得删除');
		if($this->destroy($id)){
			return true;
		}
		return $this->error("删除失败！");
	}
	
}

?>
