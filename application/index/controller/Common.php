<?php
namespace app\index\controller;
header("Content-Type:text/html; charset=utf-8");

use think\Controller;
use think\Db;


class Common extends Controller {
    public function _initialize(){
        $lunbotu= db('sh_lunbotu')
            ->select();//首页轮播图
        $jsao= db('sh_jsao')
            ->find(1);//首页关于我们
        $homeanli = db('cr_article')
            ->where('article_sort','22')
            ->order('status DESC,zhidtime DESC,addtime DESC')
            ->field('id,article_name')
            ->limit('13')
            ->select();//首页业务案例
        $hongmebanan = db('cr_article')
            ->where('article_sort','24')
            ->order('status DESC,zhidtime DESC,addtime DESC')
            ->field('id,article_name,addtime')
            ->limit('10')
            ->select();//首页办案风采
        $homedongtai= db('cr_article')
            ->where('article_sort','23')
            ->order('status DESC,zhidtime DESC,addtime DESC')
            ->field('id,article_name,article_content,addtime')
            ->limit('10')
            ->select();//首页国晖动态
        $homelingyu=db('sh_business')
            ->order('status DESC,zhidtime DESC,addtime DESC')
            ->select();//首页业务领域
        $homelingyu10= db('cr_article')
            ->where('article_sort','25')
            ->order('status DESC,zhidtime DESC,addtime DESC')
            ->field('id,article_name')
            ->select();//首页业务领域
        $sort = db('sh_sort')
            ->where('fat_id','14')
            ->field('id,sort_name')
            ->select();//首页法律法规子分类
        foreach($sort as $v){
            $sort_id[] = $v['id'];
        }
        $falvfag = db('cr_article')
            ->where('article_sort','in',$sort_id)
            ->alias('a')
            ->join('sh_sort b','a.article_sort = b.id ','LEFT')
            ->field('a.id,a.article_name,a.addtime,b.sort_name as fat_name')
            ->order('a.status DESC,a.zhidtime DESC,a.addtime DESC')
            ->limit('8')
            ->select();//首页法律法规

        $falvzs = db('cr_article')
            ->where('article_sort','3')
            ->alias('a')
            ->join('sh_sort b','a.article_sort = b.id ','LEFT')
            ->field('a.id,a.article_name,a.zhidtime,a.article_content,b.sort_name as fat_name')
            ->order('a.status DESC,a.zhidtime DESC,a.addtime DESC')
            ->limit('4')
            ->select();//首页法律责任
//        dump($falvzs);
//        die;
        $weituolvs = db('cr_article')
            ->where('article_sort','5')
            ->alias('a')
            ->join('sh_sort b','a.article_sort = b.id ','LEFT')
            ->field('a.id,a.article_name,a.addtime,b.sort_name as fat_name')
            ->order('a.status DESC,a.zhidtime DESC,a.addtime DESC')
            ->limit('8')
            ->select();//首页委托律师
        $falvzhis = db('sh_sort')
            ->where('fat_id','1')
            ->field('id,sort_name')
            ->select();//首页法律责任
        $lawyer= db('sh_lawyer')
            ->order('addtime DESC')
            ->paginate(11);;//律师列表
        $title = db('cr_home')->find('1');//首页seo关键字
        $title['article_name'] = '';
        $chain = db('sh_friend')
            ->select();//首页友情链接

        $sort = db('sh_sort')
            ->field('id,sort_name')
            ->select();//首页法律法规子分类
        foreach($sort as $v){
            $sort_id1[] = $v['id'];
        }
        $mobilenews = db('cr_article')
            ->where('article_sort','22')
            ->alias('a')
            ->join('sh_sort b','a.article_sort = b.id ','LEFT')
            ->field('a.id,a.article_name,a.addtime,article_fm,b.sort_name as fat_name')
            ->order('a.status DESC,a.zhidtime DESC,a.addtime DESC')
            ->limit('8')
            ->select();//首页新闻中心
        $sort_idz = "'" . join("','", array_values($sort_id1) ) . "'";
        $mobilenewss = Db::query("SELECT a.sort_name,b.* 
                                FROM sh_sort a
                                INNER JOIN (
                                  SELECT article_sort,count(*) 
                                    FROM cr_article 
                                    WHERE article_sort in ($sort_idz) 
                                    GROUP BY article_sort HAVING count(*)>1
                                ) b ON a.id=b.article_sort;");

        $crknowledge = db('cr_article')
            ->alias('a')
            ->join('sh_sort b','a.article_sort = b.id ','LEFT')
            ->field('a.id,a.article_name,a.addtime,b.sort_name as fat_name')
            ->order('a.status DESC,a.zhidtime DESC,a.addtime DESC')
            ->limit('8')
            ->select();//刑事知识
        // 渲染模板输出
        $this->assign([
            'jsao'=>$jsao,//首页关于我们
            'crknowledge'=>$crknowledge,//刑事知识
            'mobilenewss'=>$mobilenewss,//首页新闻中心模块数量
            'mobilenews'=>$mobilenews,//首页新闻中心
            'chain'=>$chain,//友情链接
            'title'=>$title,
            'lunbotu'=>$lunbotu,//首页轮播图
            'homeanli'=>$homeanli,//首页国晖案例
            'hongmebanan'=>$hongmebanan,//首页办案风采
            'homedongtai'=>$homedongtai,//首页国晖动态
            'homelingyu'=>$homelingyu,//首页国晖业务领域
            'homelingyu10'=>$homelingyu10,//业务领域
            'falvzhis'=>$falvzhis,//首页法律知识
            'lawyer'=>$lawyer,//律师列表
            'falvfag'=>$falvfag,//首页法律法规
            'weituolvs'=>$weituolvs,//'首页委托律师'
            'falvzs'=>$falvzs,//首页法律责任
        ]);
    }
}
