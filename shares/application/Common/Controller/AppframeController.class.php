<?php
namespace Common\Controller;
use Think\Controller;
/**
 * Appframe项目公共Controller
 */
class AppframeController extends Controller {

    protected $goods_states;
    public $ar_zdy;

    function _initialize() {
        //消除所有的magic_quotes_gpc转义
        //Input::noGPC();
        //跳转时间
        $this->assign("waitSecond", 3);
        //$this->assign("__token__", $this->getToken());
       	$time=time();
        $this->assign("js_debug",APP_DEBUG?"?v=$time":"");
        if(APP_DEBUG){
        	//sp_clear_cache();
        }
        
        $this->goods_states = D("Common/Navs")->goods_state;//取虚拟模型中产品上架状态
        $this->assign("goods_state", $this->goods_states);

        //自定义数组
        $this->ar_zdy = array(
            //性别
            'ar_sex' => array(//会员类型
                "1" =>  "男",
                "2" =>  "女",
            ),
            'ar_blur' => array(//true or false
                "0" =>  '<font color="red">╳</font>',
                "1" =>  '<font color="green">√</font>',
            ),
            'ar_usertype' => array(//会员类型
                "1" =>  '普通会员',
                "2" =>  '<font color=red>商家会员</font>',
                "3" =>  '<font color=blue>代理商</font>',
            ),
            'ar_storesh' => array(//商家审核状态
                "1" =>  "已审核",
                "2" =>  "待审核",
                "3" =>  "审核未通过",
            ),
            'ar_txtype' => array(//提现类别
                "1" =>  "会员提现",
                "2" =>  "商家提现",
                "3" =>  "代理提现",
            ),
            'ar_txstatus' => array(//提现状态
                "1" =>  "待处理",
                "2" =>  "已提现",
            ),
            'ar_op' => array(//op操作
                "fanxian"  =>  "消费返现",
                "shopping_jf"  =>  "积分消费",
                "shopping_xj"  =>  "线下消费",
                "shopping_wx"  =>  "微信付款",
                "tixian"  =>  "提现",
                "jifen_sk"  =>  "积分收款",
                "declaration"  =>  "商家报单",
                "declaration_wx"  =>  "商家微信报单",
                "weixin_sk"  =>  "微信收款",
                "fenyong"  =>  "推荐佣金",//代理商分佣
                "fenyong_qy"  =>  "区域分佣",//代理商区域分佣
                "fenyong_dl"  =>  "代理佣金",//代理商推荐的代理有收入时
//                "baodanfx"  =>  "报单返现",//商家报单返现
                "admin"  =>  "管理员操作",//管理员直接操作
            )
        );
        foreach($this->ar_zdy as $key => $val){
            $this->assign($key,$val);
        }
    }

    //获取表单令牌
    protected function getToken() {
        $tokenName = C('TOKEN_NAME');
        // 标识当前页面唯一性
        $tokenKey = md5($_SERVER['REQUEST_URI']);
        $tokenAray = session($tokenName);
        //获取令牌
        $tokenValue = $tokenAray[$tokenKey];
        return $tokenKey . '_' . $tokenValue;
    }

    /**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $type AJAX返回数据格式
     * @return void
     */
    protected function ajaxReturn($data, $type = '',$json_option=0) {
        
        $data['referer']=$data['url'] ? $data['url'] : "";
        $data['state']=$data['status'] ? "success" : "fail";
        
        if(empty($type)) $type  =   C('DEFAULT_AJAX_RETURN');
        switch (strtoupper($type)){
        	case 'JSON' :
        		// 返回JSON数据格式到客户端 包含状态信息
        		header('Content-Type:application/json; charset=utf-8');
        		exit(json_encode($data,$json_option));
        	case 'XML'  :
        		// 返回xml格式数据
        		header('Content-Type:text/xml; charset=utf-8');
        		exit(xml_encode($data));
        	case 'JSONP':
        		// 返回JSON数据格式到客户端 包含状态信息
        		header('Content-Type:application/json; charset=utf-8');
        		$handler  =   isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
        		exit($handler.'('.json_encode($data,$json_option).');');
        	case 'EVAL' :
        		// 返回可执行的js脚本
        		header('Content-Type:text/html; charset=utf-8');
        		exit($data);
        	case 'AJAX_UPLOAD':
        		// 返回JSON数据格式到客户端 包含状态信息
        		header('Content-Type:text/html; charset=utf-8');
        		exit(json_encode($data,$json_option));
        	default :
        		// 用于扩展其他返回格式数据
        		Hook::listen('ajax_return',$data);
        }
        
    }



    
    //分页
    protected function page($Total_Size = 1, $Page_Size = 0, $Current_Page = 1, $listRows = 6, $PageParam = '', $PageLink = '', $Static = FALSE) {
    	import('Page');
    	if ($Page_Size == 0) {
    		$Page_Size = C("PAGE_LISTROWS");
    	}
    	if (empty($PageParam)) {
    		$PageParam = C("VAR_PAGE");
    	}
    	$Page = new \Page($Total_Size, $Page_Size, $Current_Page, $listRows, $PageParam, $PageLink, $Static);
    	$Page->SetPager('default', '{first}{prev}{liststart}{list}{listend}{next}{last}', array("listlong" => "9", "first" => "首页", "last" => "尾页", "prev" => "上一页", "next" => "下一页", "list" => "*", "disabledclass" => ""));
    	return $Page;
    }


    /**
     * 验证码验证
     * @param type $verify 验证码
     * @param type $type 验证码类型
     * @return boolean
     */
    static public function verify($verify, $type = "verify") {
        $verifyArr = session("_verify_");
        if (!is_array($verifyArr)) {
            $verifyArr = array();
        }
        if ($verifyArr[$type] == strtolower($verify)) {
            unset($verifyArr[$type]);
            if (!$verifyArr) {
                $verifyArr = array();
            }
            session('_verify_', $verifyArr);
            return true;
        } else {
            return false;
        }
    }

    //空操作
    public function _empty() {
        $this->error('该页面不存在！');
    }
    
    /**
     * 检查操作频率
     * @param int $duration 距离最后一次操作的时长
     */
    protected function check_last_action($duration){
    	
    	$action=MODULE_NAME."-".CONTROLLER_NAME."-".ACTION_NAME;
    	$time=time();
    	
    	if(!empty($_SESSION['last_action']['action']) && $action==$_SESSION['last_action']['action']){
    		$mduration=$time-$_SESSION['last_action']['time'];
    		if($duration>$mduration){
    			$this->error("您的操作太过频繁，请稍后再试~~~");
    		}else{
    			$_SESSION['last_action']['time']=$time;
    		}
    	}else{
    		$_SESSION['last_action']['action']=$action;
    		$_SESSION['last_action']['time']=$time;
    	}
    }
    //自定义
    //数组处理
    /*
     * $ar  array
     */
    function disarray($ar){
        if(is_array($ar)){
            foreach($ar as $key => $val){
                $this->assign($key,$val);
            }
        }
    }
    //统计总待反点数
    function tjdf($date){
        $option = get_site_options();
        //查询所有会员 然后筛选合格的点数
        $where = array(
            "user_status"       =>      1
        );
        $userlist = M("oauth_user")->where($where)->select();
        $dfds = 0;//初始待返点数
        foreach($userlist as $key => $val){
            //获取当天和之后所有交易
            /*$where = array(
                "userid"       =>      $val['id'],
                "op"        =>      array(array("like","shopping_xj"),array("like","declaration"),array("like","shopping_wx"),"or"),
                "date"      =>      array('egt',$date)
            );*/            
            $where = "userid = '$val[id]' AND (op = 'shopping_xj' OR op = 'shopping_wx' OR (op='declaration' AND is_fanxian=1)) AND date >=".$date;
            
            $dtwf = M("user_integral")->where($where)->field("sum(`integral_sj`) price")->select();
            $alldtwf = 0;
            foreach($dtwf as $k => $v){
                $alldtwf = $v['price'];
            }
            $val['wfjf'] -= $alldtwf;

            if($val['wfjf']<0){
                $val['wfjf'] = 0;
            }
            //分2中情况 一 起始点<返佣点 二 反之
            if($option['site_qsd']<=$option['site_fyd']){
                //返佣点500的情况 999算1点
                $ds = floor($val['wfjf'] / $option['site_fyd']);
                if($ds<1&&$val['wfjf']>$option['site_qsd']){
                    //未返积分未到返佣点切大于了起始点 也算1
                    $ds = 1;
                }
            }else{
                if($val['wfjf']>=$option['site_qsd']){
                    $ds = ceil($val['wfjf'] / $option['site_fyd']);
                }else{
                    $ds = 0;
                }
            }
            $dfds += $ds;
        }
        return $dfds;
    }

    //返现操作
    function backnow($price,$date){
        if(!$price || !$date){
            $this->error("参数错误！");
        }
        
        //设置超时
        set_time_limit(0);
        
        $option = get_site_options();
        $where = array(
            "user_status"           =>          1
        );

        $dfds = $this->tjdf($date);//待返点数
        $mdje = $price / $dfds;//每点金额
        $ye = 0;//初始化余额

        //查询所有会员 然后筛选合格的人
        $userlist = M("oauth_user")->where($where)->select();
        foreach($userlist as $key => $val){

            //用户未返金额实际应减去当天过后的交易积分并加上
            /*$where = array(
                "userid"       =>      $val['id'],
                "op"        =>      array(array("like","shopping_xj"),array("like","declaration"),array("like","shopping_wx"),"or"),
                "date"      =>      array('egt',$date)
            );*/
            //`userid` = 46 AND ( `op` LIKE 'shopping_xj' OR `op` LIKE 'declaration' OR `op` LIKE 'shopping_wx' ) AND `date` >= 1466697600 
            $where = "userid = '$val[id]' AND (op = 'shopping_xj' OR op = 'shopping_wx' OR (op='declaration' AND is_fanxian=1)) AND date >=".$date;
            $dtwf = M("user_integral")->where($where)->field("sum(`integral_sj`) price")->select();
            $alldtwf = 0;
            foreach($dtwf as $k => $v){
                $alldtwf += $v['price'];
            }
            $val['wfjf'] -= $alldtwf;
            
            //分2中情况 一 起始点<返佣点 二 反之
            if($option['site_qsd']<$option['site_fyd']){
                //返佣点500的情况 999算1点
                $ds = floor($val['wfjf'] / $option['site_fyd']);
                if($ds<1&&$val['wfjf']>$option['site_qsd']){
                    //未返积分未到返佣点切大于了起始点 也算1
                    $ds = 1;
                }
            }else{
                if($val['wfjf']>=$option['site_qsd']){
                    $ds = floor($val['wfjf'] / $option['site_fyd']);
                }else{
                    $ds = 0;
                }
            }
            
            /*if ($val['id'] == 46) {
                file_put_contents('_1.txt', "wfjf= $val[wfjf] ds=$ds lastsql=".M("user_integral")->getLastSql());
            }*/
            
            //上面计算该会员的点数 如大于0  则参与返现
            if($ds>0){
                //获取该会员应返多少钱
                $yf = sprintf("%.2f",$ds * $mdje);

                //获取会员信息
                $user = M("oauth_user")->find($val['id']);
                //如果会员未返积分小于应返金额 则产生余额
                if($user['wfjf']<$yf){
                    $addprice = $user['wfjf'];//增加的积分就是未返积分
                    $user['score'] += $addprice;
                    $ye += $yf - $user['wfjf'];//余额
                    $user['wfjf'] = 0;//清空未返积分
                }else{
                    $addprice = $yf;
                    $user['score'] += $addprice;
                    $user['wfjf'] -= $yf;//跟新未返积分
                }
                
                /** 
                 * 判断用户当天是否已经有返现记录，如果有，则不返现
                 *
                $day = date('Y-m-d', time());
                $start_date = strtotime($day." 00:00:00");
                $end_date   = strtotime($day." 23:59:59");
                $where = "userid='$val[id]' AND op='fanxian' AND date >= '{$start_date}' AND date <='{$end_date}'";
                $fanxian = M("user_integral")->where($where)->find();
                if ($fanxian) {
                    continue;
                } */
                
                //跟新已反积分
                $user['yfjf'] += $addprice;
                M("oauth_user")->save($user);
                //产生明细
                $ar = array(
                    "userid"        =>      $val['id'],
                    "sellerid"        =>      "",
                    "op"        =>      "fanxian",
                    "itype"        =>      1,
                    "integral"        =>      $yf,
                    "integral_sj"        =>      $addprice,
                    "cur_integral"        =>      $user['score'],
                    "remark"        =>      "您已成功返现！获得 ".$addprice." 积分",
                    "date"        =>      time()
                );
                M("user_integral")->add($ar);
                
                //给用户发微信推送 用户消息发送
                /*
                sendmessage(0, $user['id'], "积分返现", "您得到".$addprice."积分", array(
                    $user['openid'],
                    "您得到".$addprice."积分",
                    ($user['user_nicename']?$user['user_nicename']:$user['mobile']),
                    time(),
                    $addprice,
                    $user['score'],
                    "积分返现",
                    "感谢您的使用！",
                    U("User/score",array("openid"=>$user['openid']))
                ),1,time());  */              
            }
        }

        //添加返现记录
        $ar = array(
            "price"         =>          $price,
            "dfds"         =>          $dfds,
            //"syje"         =>          $ye,//余额 客户取消 改为每点金额
            "syje"         =>          sprintf("%.2f",$mdje),//余额 客户取消 改为每点金额
            "fx_date"         =>          $date,
            "date"         =>          time(),
        );
        M("record_fx")->add($ar);
        $this->success("返现完成！");
    }
}