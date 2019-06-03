<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Index extends Base {
    /*
     * 首页
     * */
    public function index(){
        //网络
        $map['names']=Db::name('Area')
            ->where('ucode',0)
            ->column('code,name,shapes,pos_x,pos_y','code');
        $linkstore=model('Article')
            ->alias('a')
            ->field(['a.id','a.title','a.thumb','b.province','b.service','b.address','b.tel'])
            ->join('hly_addon_linkstore b','a.id=b.article_id')
            ->join('hly_category c','c.id=a.cate_id')
            ->where('c.type','linkstore')
            ->order('a.listorder ASC,a.update_time DESC')
            ->select();
        $temp=array();
        if($linkstore){
            foreach ($linkstore as $k=>$v){
                $temp[$v['province']][]=$v;
            }
        }
        foreach ($map['names'] as $k=>$v){
            $map['shapes'][$k]=$v['shapes'];
            $names=array(
                'id'=>$v['code'],
                'x'=>$v['pos_x'],
                'y'=>$v['pos_y'],
            );
            $names['name']=isset($temp[$k])?$v['name']:'';
            $names['color']=isset($temp[$k])?'#ff9900':'#dadada';
            $map['names'][$k]=$names;
        }
        $this->assign('linkstore',$temp);
        $this->assign('clinic',$linkstore);
        $this->assign('map',$map);
        //服务
        $service=model('Article')
            ->alias('a')
            ->field(['a.id','a.title','a.thumb','b.title_en','a.description'])
            ->join('hly_addon_service b','a.id=b.article_id')
            ->join('hly_category c','c.id=a.cate_id')
            ->where('c.type','service')
            ->order('a.listorder ASC,a.update_time DESC')
            ->limit(12)
            ->select();
        $this->assign('service',$service);
        //团队
        $team=model('Article')
            ->alias('a')
            ->field(['a.id','a.title','a.thumb','a.description','b.service'])
            ->join('hly_addon_team b','a.id=b.article_id')
            ->join('hly_category c','c.id=a.cate_id')
            ->where('c.type','team')
            ->order('a.listorder ASC,a.update_time DESC')
            ->limit(9)
            ->select();
        $this->assign('team',$team);
        //资讯
        $article=model('Article')
            ->alias('a')
            ->field(['a.id','a.title','a.thumb','a.description','a.update_time'])
            ->join('hly_category c','c.id=a.cate_id')
            ->where('c.type','article')
            ->order('a.listorder ASC,a.update_time DESC')
            ->limit(10)
            ->select();
        $this->assign('article',$article);
        $banner=model('Advert')->get_advert(1,10);
        $this->assign('banner',$banner);
    	return $this->fetch();
    }
    /*
     * 意见反馈
     * */
    public function feedback(){
            $data=array(
                'real_name'=>input('real_name'),
                'phone'=>input('phone'),
                'dist'=>input('dist'),
                'content'=>input('content'),
                'create_time'=>time(),
                'update_time'=>time()
            );
            if(empty($data['content'])) $this->error('反馈内容未填写');
            if(empty($data['real_name'])) $this->error('姓名未填写');
            if(empty($data['phone'])) $this->error('联系电话未填写');
            if(Db::name('Feedback')->insert($data)){
                $this->success('提交成功，我们会尽快与您联系');
            }else{
                $this->error('提交失败');
            }

    }

}
