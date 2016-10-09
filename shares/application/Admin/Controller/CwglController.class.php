<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/24
 * Time: 19:30
 */

namespace Admin\Controller;


use Common\Controller\AdminbaseController;

class CwglController extends AdminbaseController
{
    function index(){
        //获取时间段
        $formget = I("post.");
        $this->assign("formget",$formget);
        $start = $formget['start_time']?strtotime($formget['start_time']):0;
        $end = $formget['end_time']?strtotime($formget['end_time']):100000000000;
        $date = array('between',array($start,$end));

        //查询营业额

        //积分营业额
        $where = array(
            "op"        =>      "shopping_jf",
            "date"      =>      $date
        );
        $jfyy = M("user_integral")->where($where)->field("sum(`integral`) price")->find();
        $this->assign("jfyy",sprintf("%.2f",$jfyy['price']));

        //微支付营业额
        $where = array(
            "op"        =>      array(array("like","shopping_wx"),"or"),
            "date"      =>      $date
        );
        $wxyy = M("user_integral")->where($where)->field("sum(`integral_sj`) price")->find();
        $this->assign("wxyy",sprintf("%.2f",$wxyy['price']));

        //现金营业额
        $where = array(
            "op"        =>      "shopping_xj",
            "date"      =>      $date
        );
        $xjyy = M("user_integral")->where($where)->field("sum(`integral_sj`) price")->find();
        $this->assign("xjyy",sprintf("%.2f",$xjyy['price']));

        //总营业额 = 积分营业额 + 微支付营业额 + 现金营业额
        $allyy = sprintf("%.2f",$jfyy['price']+$wxyy['price']+$xjyy['price']);
        $this->assign("allyy",$allyy);

        //微支付营业额(操作金额) 统计平台收入用
        $where = array(
            "op"        =>      array(array("like","shopping_wx"),"or"),
            "date"      =>      $date
        );
        $wxcz = M("user_integral")->where($where)->field("sum(`integral`) price")->find();
        $this->assign("wxcz",sprintf("%.2f",$wxcz['price']));

        //查询管理员操作积分 统计时计入平台收入
        $where = array(
            "op"        =>      "admin",
            "date"      =>      $date
        );
        $adminjf = M("user_integral")->where($where)->field("sum(`integral_sj`) price")->find();
        $this->assign("adminjf",$adminjf['price']);

        //微信报单手续费 统计时计入平台收入
        $where = array(
            "op"        =>      array("like","declaration_wx") ,
            "date"      =>      $date
        );
        $wxbd = M("user_integral")->where($where)->field("sum(`integral`-`integral_sj`) price")->find();
        $this->assign("wxbd",$wxbd['price']);

        //查询手续费

        //-积分
        $where = array(
            "op"        =>      "jifen_sk",
            "date"      =>      $date
        );
        $jfsxf = M("user_integral")->where($where)->field("sum(`integral`-`integral_sj`) price")->find();
        $this->assign("jfsxf",sprintf("%.2f",$jfsxf['price']));
        //-微信
        $where = array(
            "op"        =>      array(array("like","weixin_sk"),"or"),
            "date"      =>      $date
        );
        $wxsxf = M("user_integral")->where($where)->field("sum(`integral`-`integral_sj`) price")->find();
        $this->assign("wxsxf",sprintf("%.2f",$wxsxf['price']));
        //-现金
        $where = array(
            "op"        =>      array(array("like","declaration"),array("like","declaration_wx"),"or"),
            "date"      =>      $date
        );
        $xjsxf = M("user_integral")->where($where)->field("sum(IF(`op`='declaration',`integral_sj`,`integral`-`integral_sj`)) price")->find();
        $this->assign("xjsxf",sprintf("%.2f",$xjsxf['price']));

        $where = array(
            "date"      =>      $date,
            "itype"     =>      array("gt",0)
        );
        //-提现
        $tx = M("user_withdraw")
            ->field("itype, sum(`fee`) price")
            ->where($where)
            ->group("itype")
            ->select();

        $listtx = array();
        foreach($tx AS $val) {
            $listtx[$val['itype']] = $val['price'];
        }
        $this->assign("tx",$listtx);

        //查询会员返现状态
        $fx = M("oauth_user")
            ->field("user_type,sum(`yfjf`) yfjf,sum(`wfjf`) wfjf,sum(`yfjf`+`wfjf`) alljf,sum(`score`) score")
            ->find();
        $this->assign("fx",$fx);

        //查询推荐返佣
        $where = array(
            "op"        =>      array(array("like","fenyong"),array("like","fenyong_qy"),"or"),
            "date"      =>      $date,
            "itype"     =>      array("gt",0)
        );

        $tjfy = M("user_integral")->where($where)->field("itype,sum(`integral_sj`) price")->group("itype")->select();
        $listfy = array();
        foreach($tjfy AS $val) {
            $listfy[$val['itype']] = $val['price'];
        }
        $this->assign("fy",$listfy);

        //提现
        //已提现
        $where = array(
            "date"      =>      $date,
            "itype"     =>      array("gt",0),
            "state"     =>      2
        );
        $tx = M("user_withdraw")
            ->field("itype, sum(`price`) price")
            ->where($where)
            ->group("itype")
            ->select();
        $listytx = array();
        foreach($tx AS $val) {
            $listytx[$val['itype']] = $val['price'];
        }
        $this->assign("ytx",$listytx);

        //待提现
        $where = array(
            "date"      =>      $date,
            "itype"     =>      array("gt",0),
            "state"     =>      1
        );
        $tx = M("user_withdraw")
            ->field("itype, sum(`price`) price")
            ->where($where)
            ->group("itype")
            ->select();
        $listdtx = array();
        foreach($tx AS $val) {
            $listdtx[$val['itype']] = $val['price'];
        }
        $this->assign("dtx",$listdtx);
        
        //商家余额
        $sjye = M("store")
            ->alias("s")//表别名
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON s.uid = ou.id")
            //->where("ou.user_type=2")//条件
            ->field("sum(s.score) score")
            ->find();
        $this->assign("sjye",$sjye['score']);
        //代理商余额
        $dlye = M("user_dl")
            ->alias("ud")//表别名
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ud.uid = ou.id")
            //->where("ou.user_type=3")//条件
            ->field("sum(ud.dl_score) score")
            ->find();
        $this->assign("dlye",$dlye['score']);

        //会员手续费返佣
        $where = array(
            "op"        =>      array(array("like","declaration"),array("like","jifen_sk"),array("like","weixin_sk"),"or"),
            "is_fanxian"        =>      1,
            "date"      =>      $date
        );
        $sxffy = M("user_integral")->where($where)->field("sum(IF(`op`='jifen_sk',`integral` - `integral_sj`,`integral_sj`)) price")->find();
        $this->assign("sxffy",$sxffy['price']);
        

        //明细统计
        $where = array(
            "ui.date"      =>      $date,
            "ui.op"      =>      array(array("like","declaration"),array("like","jifen_sk"),array("like","weixin_sk"),array("like","declaration_wx"),"or")
        );
        $count = M("user_integral")
            ->alias("ui")//表别名
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = ui.sellerid","LEFT")
            ->join(C ( 'DB_PREFIX' )."store s ON s.id = ui.userid","LEFT")
            ->where($where)
            ->count();//获取条数

        $page = $this->page($count, 99999);//设置分页信息

        $mx = M("user_integral")
            ->alias("ui")//表别名
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = ui.sellerid","LEFT")
            ->join(C ( 'DB_PREFIX' )."store s ON s.id = ui.userid","LEFT")
            ->where($where)//条件
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("ui.id desc")
            ->field("ui.*,CONCAT(ou.user_nicename, ' ', ou.mobile) user_nicename,ui.cur_integral,ou.mobile")//查询内容
            ->select();       
        //总消费
        $allxf = 0;
        //总赠送
        $allzs = 0;
        //总手续费
        $allsx = 0;
        //总推荐代理
        $allyhfy = 0;
        //总推荐商家
        $allsjfy = 0;
        //总区域返佣
        $allqysj = 0;
        foreach($mx as $key => $val){
            //积分消费
            if($val['op']=="jifen_sk"){
                $mx[$key]['xf'] = $val['integral'];
                $mx[$key]['zs'] = 0;
                $mx[$key]['sxf'] = $val['integral'] - $val['integral_sj'];
                $topuser = M("oauth_user")->field("mobile")->find($val['sellerid']);
                $mx[$key]['option'] = "会员积分消费";//代表哪方发起的交易
            }
            //现金报单
            if($val['op']=="declaration"){
                $mx[$key]['xf'] = $val['integral'];
                $mx[$key]['sxf'] = $val['integral_sj'];
                //赠送积分需要从对应用户明细里查询 时间戳对应
                $zsmx = M("user_integral")->where("date=".$val['date']." and op='shopping_xj'")->find();
                $mx[$key]['zs'] = $zsmx['integral_sj'];
                $topuser = M("oauth_user")->field("mobile")->find($val['userid']);
                $mx[$key]['option'] = "商家积分报单";
            }
            //微信报单
            if($val['op']=="declaration_wx"){
                $mx[$key]['xf'] = $val['integral'];
                $mx[$key]['sxf'] = $val['integral']- $val['integral_sj'];
                //赠送积分需要从对应用户明细里查询 时间戳对应
                $zsmx = M("user_integral")->where("date=".$val['date']." and op='shopping_xj'")->find();
                $mx[$key]['zs'] = $zsmx['integral_sj'];
                $topuser = M("oauth_user")->field("mobile")->find($val['userid']);
                $mx[$key]['option'] = "商家微信报单";
            }
            //微信消费
            if($val['op']=="weixin_sk"){
                $mx[$key]['xf'] = $val['integral'];
                $mx[$key]['zs'] = $val['integral_sj'];
                $mx[$key]['sxf'] = $val['integral'] - $val['integral_sj'];
                $topuser = M("oauth_user")->field("mobile")->find($val['userid']);
                $mx[$key]['option'] = "会员微信消费";
                
                //20160607 微信消费是以商家收款为主线，因此要查询出用户的实际赠送
                $tmpwhere = "out_trade_no='$val[out_trade_no]' AND op='shopping_wx'";
                $sjzj = M("user_integral")->field("integral_sj")->where($tmpwhere)->find();
                $mx[$key]['zs'] = $sjzj['integral_sj'];
                
            }
            //查询用户上级分佣明细
            $where = array(
                "sellerid"      =>      $val['sellerid'],
                "date"      =>      $val['date'],
                "op"        =>      "fenyong"
            );
            $topyh = M("user_integral")->where($where)->find();

            if($topyh){
                $mx[$key]['yhfy'] = $topyh['integral_sj'];
                
                //查询出会员返佣记录的userid对应的名称
                $topuser_user = M("oauth_user")->field("mobile")->find($topyh['userid']);
                $mx[$key]['topname'] = $topuser_user['mobile'];
            }else{
                $mx[$key]['yhfy'] = 0;
            }

            //查询商家上级分佣明细
            $where = array(
                "sellerid"      =>      $val['userid'],
                "date"      =>      $val['date'],
                "op"        =>      "fenyong"
            );
            $topseller = M("oauth_user")->field("mobile")->find($val['userid']);
            $topsj = M("user_integral")->where($where)->find();
            if($topsj){
                $mx[$key]['sjfy'] = $topsj['integral_sj'];
                $mx[$key]['topselelr'] = $topseller['mobile'];
            }else{
                $mx[$key]['sjfy'] = 0;
            }
            //区域代理上级分佣明细
            $where = array(
                "sellerid"      =>      array(array("like",$val['userid']),array("like",$val['sellerid']),"or"),
                "date"      =>      $val['date'],
                "op"        =>      "fenyong_qy"
            );
            $qysj = M("user_integral")->where($where)->field("sum(`integral_sj`) price")->find();
            if($qysj){
                $mx[$key]['qysj'] = $qysj['price'];
            }else{
                $mx[$key]['qysj'] = 0;
            }
            //查询商家
            $seller = M("oauth_user")
                ->alias("ou")//表别名
                ->join(C ( 'DB_PREFIX' )."store s ON ou.id = s.uid","LEFT")
                ->where("ou.id=".$val['userid'])//条件
                ->field("s.name,s.fybl,ou.mobile")//查询内容
                ->find();
                $mx[$key]['name'] = $seller['name'];
                $mx[$key]['fybl'] = $seller['fybl'];
                $mx[$key]['storemobile'] = $seller['mobile'];

            $allxf += $mx[$key]['xf'];
            $allzs += $mx[$key]['zs'];
            $allsx += $mx[$key]['sxf'];
            $allyhfy += $mx[$key]['yhfy'];
            $allsjfy += $mx[$key]['sjfy'];
            $allqysj += $mx[$key]['qysj'];
        }
        $ar = array(
          "allxf"       =>      $allxf,
          "allzs"       =>      $allzs,
          "allsx"       =>      $allsx,
          "allyhfy"       =>      $allyhfy,
          "allsjfy"       =>      $allsjfy,
          "allqysj"       =>      $allqysj
        );
        $this->assign($ar);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("mx",$mx);
        $this->display();
    }
    //导出提现
    function dctx(){
        $formget = I("post.");
        $start = $formget['start_time']?strtotime($formget['start_time']):0;
        $end = $formget['end_time']?strtotime($formget['end_time']):100000000000;
        $date = array('between',array($start,$end));

        //明细统计
        $where = array(
            "ui.date"      =>      $date,
            "ui.op"      =>      array(array("like","declaration"),array("like","jifen_sk"),array("like","weixin_sk"),array("like","declaration_wx"),"or")
        );        
        
        $mx = M("user_integral")
            ->alias("ui")//表别名
            ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = ui.sellerid","LEFT")
            ->join(C ( 'DB_PREFIX' )."store s ON s.id = ui.userid","LEFT")
            ->where($where)//条件
            ->order("ui.id desc")
            ->field("ui.*,CONCAT(ou.user_nicename, ' ', ou.mobile) user_nicename,ui.cur_integral")//查询内容
            ->select();
            
        foreach($mx as $key => $val){
            //积分消费或 微信消费
            if($val['op']=="jifen_sk"){
                $mx[$key]['xf'] = $val['integral'];
                $mx[$key]['zs'] = 0;
                $mx[$key]['sxf'] = $val['integral'] - $val['integral_sj'];
            }
            //现金消费
            if($val['op']=="declaration"){
                $mx[$key]['xf'] = $val['integral'];
                $mx[$key]['sxf'] = $val['integral_sj'];
                //赠送积分需要从对应用户明细里查询 时间戳对应
                $zsmx = M("user_integral")->where("date=".$val['date']." and op='shopping_xj'")->find();
                $mx[$key]['zs'] = $zsmx['integral_sj'];
            }
            //微信消费
            if($val['op']=="weixin_sk"){
                $mx[$key]['xf'] = $val['integral'];
                $mx[$key]['zs'] = $val['integral_sj'];
                $mx[$key]['sxf'] = $val['integral'] - $val['integral_sj'];
            }
            //查询用户上级分佣明细
            $where = array(
                "sellerid"      =>      $val['sellerid'],
                "date"      =>      $val['date'],
                "op"        =>      "fenyong"
            );
            $topuser = M("oauth_user")->field("mobile")->find($val['sellerid']);
            $topyh = M("user_integral")->where($where)->find();
            if($topyh){
                $mx[$key]['yhfy'] = $topyh['integral_sj'];
                
                //查询出会员返佣记录的userid对应的名称
                $topuser_user = M("oauth_user")->field("mobile")->find($topyh['userid']);
                $mx[$key]['topname'] = $topuser_user['mobile'];                
            }else{
                $mx[$key]['yhfy'] = 0;
            }

            //查询商家上级分佣明细
            $where = array(
                "sellerid"      =>      $val['userid'],
                "date"      =>      $val['date'],
                "op"        =>      "fenyong"
            );
            $topseller = M("oauth_user")->field("mobile")->find($val['userid']);
            $topsj = M("user_integral")->where($where)->find();
            if($topyh){
                $mx[$key]['sjfy'] = $topsj['integral_sj'];
                
                
                //查询出会员返佣记录的userid对应的名称
                //暂时取消
                //$topuser_user = M("oauth_user")->field("mobile")->find($topyh['userid']);
                //$mx[$key]['topselelr'] = $topuser_user['mobile'];
                
                $mx[$key]['topselelr'] = $topseller['mobile'];
            }else{
                $mx[$key]['sjfy'] = 0;
            }
            //区域代理上级分佣明细
            $where = array(
                "sellerid"      =>      array(array("like",$val['userid']),array("like",$val['sellerid']),"or"),
                "date"      =>      $val['date'],
                "op"        =>      "fenyong_qy"
            );
            $qysj = M("user_integral")->where($where)->field("sum(`integral_sj`) price")->find();
            if($qysj){
                $mx[$key]['qysj'] = $qysj['price'];
            }else{
                $mx[$key]['qysj'] = 0;
            }
            //查询商家
            $seller = M("oauth_user")
                ->alias("ou")//表别名
                ->join(C ( 'DB_PREFIX' )."store s ON ou.id = s.uid","LEFT")
                ->where("ou.id=".$val['userid'])//条件
                ->field("s.name,s.fybl")//查询内容
                ->find();
            $mx[$key]['name'] = $seller['name'];
            $mx[$key]['fybl'] = $seller['fybl'];
            $mx[$key]['lirun'] = $mx[$key]['sxf'] - $mx[$key]['yhfy'] - $mx[$key]['sjfy'] - $mx[$key]['qysj'];
            $mx[$key]['date'] = date("Y-m-d H:i",$mx[$key]['date']);
        }
        //如果点击导出
        $arytitle = array(
            array('user_nicename','会员名称','A', '25'),
            array('xf','会员消费','B', '15'),
            array('zs','会员赠送','C', '15'),
            array('name','商家店铺','D', '45'),
            array('sxf','手续费','E', '15'),
            array('fybl','赠送比例','F', '15'),
            array('yhfy','推荐用户','G', '15'),
            array('sjfy','推荐商家','H', '15'),
            array('qysj','区域代理商','I', '15'),
            array('lirun','利润','J', '15'),
            array('date','时间','J', '30'),
        );
        
        $filename = '财务明细统计';
        $this->exportExcel($filename, $arytitle, $mx); //文件名，标题数组，数据数组
    }
}