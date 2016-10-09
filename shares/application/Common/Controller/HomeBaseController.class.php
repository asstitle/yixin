<?php
namespace Common\Controller;
use Common\Controller\AppframeController;
class HomeBaseController extends AppframeController {
	
    protected $slide_model;
    protected $order_types;
    protected $shsjs;
    protected $fhfss;
	public function __construct() {
		$this->set_action_success_error_tpl();
		parent::__construct();
	}
	
	function _initialize() {
		parent::_initialize();

        $naver = M('nav')->where('cid = 1')->order('listorder')->select();
        $this->assign('naver', $naver);
        $this->assign('naver2', $naver);


        //自动登录
        //每次获取openid后，实现
        //判断session登錄
        if($_SESSION['openid'] && !sp_is_user_login()){
            //判断是否绑定账号 如绑定直接自动登录
            $user = M("oauth_user")->where("openid='".$_SESSION['openid']."' and openid <> ''")->find();
            if($user){
                sp_update_current_user($user);
            }
        }

		$this->site_options=get_site_options();
		$this->assign($this->site_options);
		$ucenter_syn=C("UCENTER_ENABLED");
		if($ucenter_syn){
			if(!isset($_SESSION["user"])){
				if(!empty($_COOKIE['thinkcmf_auth'])  && $_COOKIE['thinkcmf_auth']!="logout"){
					$thinkcmf_auth=sp_authcode($_COOKIE['thinkcmf_auth'],"DECODE");
					$thinkcmf_auth=explode("\t", $thinkcmf_auth);
					$auth_username=$thinkcmf_auth[1];
					$users_model=M('Users');
					$where['user_login']=$auth_username;
					$user=$users_model->where($where)->find();
					if(!empty($user)){
						$is_login=true;
						$_SESSION["user"]=$user;
					}
				}
			}else{
			}
		}

        $this->order_types = D("Common/Navs")->order_type;//订单状态
        $this->assign('order_type', $this->order_types);
        
        $this->shsjs = D("Common/Navs")->shsj;//送货方式
        $this->assign('shsj', $this->shsjs);
        
        $this->fhfss = D("Common/Navs")->fhfs;//发货方式
        $this->assign('fhfs', $this->fhfss);
		
		if(sp_is_user_login()){
			$this->assign("user",sp_get_current_user());
		}
        //幻灯片集合
		$this->slide_model = D("Common/Slide");
        $this->banner_value();
        
        //删除购物车
        $this->delete_car();
        
        //所有公共
        $this->all_public_function();

        //分享
        //如果session 为空 就去数据库查找
        $myself_id = $_SESSION['user']['id'];
//        if(!$myself_id){
//            $myself = M("oauth_user")->where("openid='".$_SESSION['openid']."' and openid<>''")->find();
//            if($myself){
//                $myself_id = $myself['id'];
//            }
//        }


        $options = $this->site_options;
        //微信的推广二维码地址 state为用户的uid
        $weixin_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $options['site_AppId'] . "&redirect_uri=http://yixin.woyii.com/openid.php&response_type=code&scope=snsapi_base&state=".$myself_id."#wechat_redirect";
        $jssdk = new \Org\Util\Jssdk($options['site_AppId'], $options['site_AppSecret']);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign("weixin_url",$weixin_url);
        //show_bug($signPackage);exit();
        //直接扫描用户的二维码注册时，直接到注册页面
        $weixin_url_reg = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $options['site_AppId'] . "&redirect_uri=http://yixin.woyii.com/openid.php&response_type=code&scope=snsapi_base&state=reg".$myself_id."#wechat_redirect";
        $this->assign("weixin_url_reg",$weixin_url_reg);
        
        $this->assign('signPackage1', $signPackage);
        
	}
    
    public function all_public_function () {
        //购物车商品数量
        $uid = get_current_userid();
        $where = "uid='$uid'";
        $sessionid = session_id();//获取浏览器sessionid
        if (!$uid) {
            $where = "sessionid='$sessionid'";
        }
        $car_count = M("user_buycar")->where($where)->count();
        $this->assign("car_count",$car_count);
    }
    
    //如果我的购物车里面商品已经不在 则删除此购物车此商品
    public function delete_car () {
        $uid = get_current_userid();
        $user_buycar = M("user_buycar")->where(" uid='$uid' ")->select();
        foreach ($user_buycar as $k=>$v) {
            $goods_id = $v['goods_id'];
            if (!M("goods")->where("id='$goods_id'")->find()) {
                $user_buycarid = $v['id'];
                M("user_buycar")->where("id='$user_buycarid'")->delete();
            }
        }
    }
    
    
    public function public_function () {
        /**
         * 首页方法
         **/ 
        //商品一级分类
        $goods_class_first = M("goods_class")->where("parent_id=0 AND is_index=1")->order("listorder DESC, id ASC")->select();
        $this->assign("goods_class_first",$goods_class_first);
        //所有品牌
        $goods_brand = M("goods_brand")->where("is_show=1 AND is_index")->order()->select();
        $this->assign("goods_brand",$goods_brand);
        //商品
        $goods = M("goods")
        ->alias("a")
        ->join(C ( 'DB_PREFIX' )."goods_pic d ON d.goods_id = a.id")
        ->where("a.is_status=2")
        ->field("a.*, d.imgurl")
        ->order("a.listorder DESC ,a.id DESC")
        ->limit(0,7)
        ->select();
        $this->assign("goods",$goods);
    }
    
    //首页banner赋值
    public function banner_value () {
        $this->assign("banner",$this->index_banner('banner'));//首页
    }
    
    
    public function index_banner ($value) {
        
        $banner = $this->slide_model
        ->alias("a")
        ->join(C ( 'DB_PREFIX' )."slide_cat b ON a.slide_cid = b.cid")
        ->where(" b.cat_idname='$value' AND b.cid=a.slide_cid AND a.slide_status=1 ")
        ->order("a.listorder DESC,a.slide_id ASC")
        ->field("a.*")
        ->select();
        
        return $banner;
    }
	
	protected function check_login(){
		if(!isset($_SESSION["user"])){
			$this->error('您还没有登录！',__ROOT__."/");
		}
		
	}
	
	protected function  check_user(){
		
		if($_SESSION["user"]['user_status']==2){
			$this->error('您还没有激活账号，请激活后再使用！',U("user/login/active"));
		}
		
		if($_SESSION["user"]['user_status']==0){
			$this->error('此账号已经被禁止使用，请联系管理员！',__ROOT__."/");
		}
	}
	
	//发送邮件
	protected  function _send_to_active(){
		$option = M('Options')->where(array('option_name'=>'member_email_active'))->find();
		if(!$option){
			$this->error('网站未配置账号激活信息，请联系网站管理员');
		}
		$options = json_decode($option['option_value'], true);
		//邮件标题
		$title = $options['title'];
		$uid=$_SESSION['user']['id'];
		$username=$_SESSION['user']['user_login'];
	
		$activekey=md5($uid.time().uniqid());
		$users_model=M("Users");
	
		$result=$users_model->where(array("id"=>$uid))->save(array("user_activation_key"=>$activekey));
		if(!$result){
			$this->error('激活码生成失败！');
		}
		//生成激活链接
		$url = U('user/register/active',array("hash"=>$activekey), "", true);
		//邮件内容
		$template = $options['template'];
		$content = str_replace(array('http://#link#','#username#'), array($url,$username),$template);
	
		$send_result=sp_send_email($_SESSION['user']['user_email'], $title, $content);
	
		if($send_result['error']){
			$this->error('激活邮件发送失败！');
		}
	}
	
	/**
	 * 加载模板和页面输出 可以返回输出内容
	 * @access public
	 * @param string $templateFile 模板文件名
	 * @param string $charset 模板输出字符集
	 * @param string $contentType 输出类型
	 * @param string $content 模板输出内容
	 * @return mixed
	 */
	public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
		//echo $this->parseTemplate($templateFile);
		parent::display($this->parseTemplate($templateFile), $charset, $contentType);
	}
	
	public function fetch($templateFile='',$content='',$prefix=''){
		return parent::fetch($this->parseTemplate($templateFile),$content,$prefix);
	}
	
	/**
	 * 自动定位模板文件
	 * @access protected
	 * @param string $template 模板文件规则
	 * @return string
	 */
	public function parseTemplate($template='') {
		
		$tmpl_path=C("SP_TMPL_PATH");
		// 获取当前主题名称
		$theme      =    C('SP_DEFAULT_THEME');
		if(C('TMPL_DETECT_THEME')) {// 自动侦测模板主题
			$t = C('VAR_TEMPLATE');
			if (isset($_GET[$t])){
				$theme = $_GET[$t];
			}elseif(cookie('think_template')){
				$theme = cookie('think_template');
			}
			if(!file_exists($tmpl_path."/".$theme)){
				$theme  =   C('SP_DEFAULT_THEME');
			}
			cookie('think_template',$theme,864000);
		}
		
		if(C('MOBILE_TPL_ENABLED')){//开启手机模板支持
			if(sp_is_mobile()){
				if(file_exists($tmpl_path."/".$theme."_mobile")){
					$theme  =   $theme."_mobile";
				}
			}
		}
		
		
		
		
		C('SP_DEFAULT_THEME',$theme);
		
		$current_tmpl_path=$tmpl_path.$theme."/";
		// 获取当前主题的模版路径
		define('THEME_PATH', $current_tmpl_path);
		
		C("TMPL_PARSE_STRING.__TMPL__",__ROOT__."/".$current_tmpl_path);
		
		C('SP_VIEW_PATH',$tmpl_path);
		C('DEFAULT_THEME',$theme);
		
		if(is_file($template)) {
			return $template;
		}
		$depr       =   C('TMPL_FILE_DEPR');
		$template   =   str_replace(':', $depr, $template);
		
		// 获取当前模块
		$module   =  MODULE_NAME;
		if(strpos($template,'@')){ // 跨模块调用模版文件
			list($module,$template)  =   explode('@',$template);
		}
		
		
		// 分析模板文件规则
		if('' == $template) {
			// 如果模板文件名为空 按照默认规则定位
			$template = "/".CONTROLLER_NAME . $depr . ACTION_NAME;
		}elseif(false === strpos($template, '/')){
			$template = "/".CONTROLLER_NAME . $depr . $template;
		}
		
		$file=$current_tmpl_path.$module.$template.C('TMPL_TEMPLATE_SUFFIX');
		if(!is_file($file)) E(L('_TEMPLATE_NOT_EXIST_').':'.$file);
		return $file;
	}
	
	
	private function set_action_success_error_tpl(){
		$theme      =    C('SP_DEFAULT_THEME');
		if(C('TMPL_DETECT_THEME')) {// 自动侦测模板主题
			if(cookie('think_template')){
				$theme = cookie('think_template');
			}
		}
		$tpl_path=C("SP_TMPL_PATH").$theme."/";
		$defaultjump=THINK_PATH.'Tpl/dispatch_jump.tpl';
		$action_success=$tpl_path.C("SP_TMPL_ACTION_SUCCESS").C("TMPL_TEMPLATE_SUFFIX");
		$action_error=$tpl_path.C("SP_TMPL_ACTION_ERROR").C("TMPL_TEMPLATE_SUFFIX");
		if(file_exists($action_success)){
			C("TMPL_ACTION_SUCCESS",$action_success);
		}else{
			C("TMPL_ACTION_SUCCESS",$defaultjump);
		}
		
		if(file_exists($action_error)){
			C("TMPL_ACTION_ERROR",$action_error);
		}else{
			C("TMPL_ACTION_ERROR",$defaultjump);
		}
	}
	
    //计算运费模板
    public function express_template ($goods_idString,$numsString) {
        $uid = get_current_userid();
        
        $goods_idArray = explode(',',$goods_idString);//商品ID
        $numsArray = explode(',',$numsString);//商品数量
        
        $sjfsArray = array();//价格数组
        foreach ($goods_idArray as $k=>$v) {
            //找到对应的快递模板
            $goods = M("goods")
            ->alias("a")
            ->join(C ( 'DB_PREFIX' )."express b ON a.express_id = b.id")
            ->where("a.id='$v'")
            ->field("a.goods_g, a.goods_v, b.*")
            ->find();
            
            if (intval($goods['shipping']) == 1) {
                switch (intval($goods['valuation_type'])) {
                    case 1://按件数
                        $sjfsArray[] = $this->transport_type(explode(',', $goods['transport_type']), $goods, intval($numsArray[$k]));//返回当前计算方式
                        
                    break;
                    
                    case 2://按重量
                        $goods_g = $goods['goods_g'];
                        $sjfsArray[] = $this->transport_type(explode(',', $goods['transport_type']), $goods, $goods_g*intval($numsArray[$k]));//返回当前计算方式
                        
                    break;
                    
                    case 3://按体积
                        $goods_v = $goods['goods_v'];
                        $sjfsArray[] = $this->transport_type(explode(',', $goods['transport_type']), $goods, $goods_v*intval($numsArray[$k]));//返回当前计算方式
                    break;
                }
            }
        }
        
        //如果存在
        $data = array();
        $calculation = 0;//运费
        $calculation2 = 0;//EMS
        $calculation3 = 0;//平邮
        if ($sjfsArray) {
            foreach ($sjfsArray as $k=>$v) {
                if ($v['calculation1']) {
                    $calculation += $v['calculation1'];
                }
                
                if ($v['calculation2']) {
                    $calculation2 += $v['calculation2'];
                }
                
                if ($v['calculation3']) {
                    $calculation3 += $v['calculation3'];
                }
            }
            
            //组合返回数据
            $calculation && $data[] = array('id'=>1,'name'=>"快递",'price'=>$calculation);
            $calculation2 && $data[] = array('id'=>2,'name'=>"EMS",'price'=>$calculation2);
            $calculation3 && $data[] = array('id'=>3,'name'=>"平邮",'price'=>$calculation3);
        } else {
            //否则卖家包运费
            $data[] = array('id'=>0,'name'=>"包运费",'price'=>0);
        }
        return $data;
    }
    
    //循环快递
    public function transport_type ($transport_type,$goods,$nums) {
        
        //返回当前几种计算方式
        $cal_priceArray = array();
        if (in_array(1,$transport_type)) {
            //快递
            $cal_priceArray['calculation1'] = $this->is_address($zone,unserialize($goods['calculation1']),$nums);//判断是选择哪个计算方式
            
        }
        
        if (in_array(2,$transport_type)) {
            //EMS
            $cal_priceArray['calculation2'] = $this->is_address($zone,unserialize($goods['calculation2']),$nums);//判断是选择哪个计算方式
        }
        
        if (in_array(3,$transport_type)) {
            //平邮
            $cal_priceArray['calculation3'] = $this->is_address($zone,unserialize($goods['calculation3']),$nums);//判断是选择哪个计算方式
        }
        return $cal_priceArray;
    }
    
    //判断当前用户对应计算
    public function is_address ($zone,$calculation,$nums) {
        $jsfs = $calculation;
        
        
        $calculation_price = 0;
        if ($jsfs) {
            if ($nums <= intval($jsfs['a'])) {
                $calculation_price = intval($jsfs['b']);
            }
            //如果超出默认限额
            if ($nums > intval($jsfs['a'])) {
                $calculation_price = floor(($nums - intval($jsfs["a"]))/intval($jsfs['c']))*intval($jsfs['d'])+intval($jsfs['b']);
            }
        }
        
        return $calculation_price;
    }
	
    //处理数组集合
    public function deal_array ($arr,$zd) {
        $String_id = '';
        foreach ($arr as $k=>$v) {
            if ($k == 0) {
                $String_id .= $v[$zd];
            } else {
                $String_id .= ','.$v[$zd];
            }
        }
        return $String_id;
    }
    
    //根据当前分类ID取第三级分类id集
    public function search_three ($id) {
        $now_cen = 1;//当前层级
        $goods_class_id = strval($id);
        
        for ($n = 1; $n <999; $n++) {
            $list = M("goods_class")->where("id='$id'")->field("id,name,parent_id")->find();
            $id = $list['parent_id'];
            if ($id == 0) {
                $now_cen = $n;
                break;
            }
        }
        
        //根据当前级别循环取ids
        for ($n = 1; $n <= 2-$now_cen; $n++) {
            $goods_class = M("goods_class")->where("parent_id in ($goods_class_id)")->order("id ASC")->field("id,name,parent_id")->select();
            
            $goods_class_id .= $this->deal_array($goods_class,"id"); 
            
            if (!$goods_class_id) {
                break;
            }
        }
        if ($goods_class_id) {
            //截取出第一个id
            $goods_class_id = substr($goods_class_id,1);
        }
        return $goods_class_id;
        
    }
    
    //站点链接
    function getsiteurl() {
//    	$uri = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : ($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
//    	return 'http://'.$_SERVER['HTTP_HOST'];
        return "http://yixin.woyii.com/index.php/";
    }


    //上传图片- 会员头像
    function uploadfilelogo(){
        if (IS_POST) {
            //上传处理类
            $config=array(
                'rootPath' => './'.C("UPLOADPATH"),
                'savePath' => '',
                'maxSize' => 11048576,//大概10M
                'saveName'   =>    array('uniqid',''),
                'exts'       =>    array('jpg', 'gif', 'png', 'jpeg',"bmp"),
                'autoSub'    =>    false,
            );
            $upload = new \Think\Upload($config);//
            $info=$upload->upload();
            //开始上传
            if ($info) {
                //上传成功
                //写入附件数据库信息
                $first=array_shift($info);
                if(!empty($first['url'])){
                    $url=$first['url'];
                }else{
                    $url=C("TMPL_PARSE_STRING.__UPLOAD__").$first['savename'];
                }
                //保存图片
                $this->table = M("oauth_user");
                $ar = array();
                $ar['user_img'] = $url;
                $ar['id'] = sp_get_current_userid();
                $this->table->save($ar);
                //跟新session
                sp_update_current_user($this->table->find(sp_get_current_userid()));
                echo $url;
                exit;
            }
        }
    }
    //上传图片- 商家logo
    function uploadfilelogo2(){
        if (IS_POST) {
            //上传处理类
            $config=array(
                'rootPath' => './'.C("UPLOADPATH"),
                'savePath' => '',
                'maxSize' => 11048576,//大概10M
                'saveName'   =>    array('uniqid',''),
                'exts'       =>    array('jpg', 'gif', 'png', 'jpeg',"bmp"),
                'autoSub'    =>    false,
            );
            $upload = new \Think\Upload($config);//
            $info=$upload->upload();
            //开始上传
            if ($info) {
                //上传成功
                //写入附件数据库信息
                $first=array_shift($info);
                if(!empty($first['url'])){
                    $url=$first['url'];
                }else{
                    $url=C("TMPL_PARSE_STRING.__UPLOAD__").$first['savename'];
                }
                //根据会员id获取此商家的id
                $user = M("oauth_user")
                    ->alias("ou")//表别名
                    ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id")
                    ->where("ou.id=".sp_get_current_userid())//条件
                    ->field("s.*")//查询内容
                    ->find();
                //保存图片
                $this->table = M("store");
                $ar = array();
                $ar['logo'] = $url;
                $ar['id'] = $user['id'];
                $this->table->save($ar);
                echo $url;
                exit;
            }
        }
    }
    //商家店铺 只获取地址 不修改数据库
    function uploadlogo(){
        if (IS_POST) {
            //上传处理类
            $config=array(
                'rootPath' => './'.C("UPLOADPATH"),
                'savePath' => '',
                'maxSize' => 11048576,//大概10M
                'saveName'   =>    array('uniqid',''),
                'exts'       =>    array('jpg', 'gif', 'png', 'jpeg',"bmp"),
                'autoSub'    =>    false,
            );
            $upload = new \Think\Upload($config);//
            $info=$upload->upload();
            //开始上传
            if ($info) {
                //上传成功
                //写入附件数据库信息
                $first=array_shift($info);
                if(!empty($first['url'])){
                    $url=$first['url'];
                }else{
                    $url=C("TMPL_PARSE_STRING.__UPLOAD__").$first['savename'];
                }
                echo $url;
                exit;
            }
        }
    }
    //推荐人提成 如有推荐人 根据推荐人身份提成
    /**
     * t        本身身份 1会员 2商家
     * id       自己id
     * uid      上级id
     * price    实际金额
     */
    function pubtc($t,$id,$uid='',$price,$date){
        $options = get_site_options();
        //判断是否存在上级
        if($uid){
            //查询上级用户信息
            $topuser = M("oauth_user")->find($uid);
            $bl = 0;
            //上级是会员
            if($topuser['user_type']==1){
                //判断是否启用
                if($topuser['user_status']==1){
                    if($t==1){
                        $bl = $options['site_uubl']/100;
                    }
                }
            }else if($topuser['user_type']==2) {
                //判断是否启用 商家启用的同时 会员也启用
                $sjseller = M("store")->where("uid=".$uid)->find();
                if($sjseller['isenable']==1&&$topuser['user_status']==1){
                    //上级是商家
                    if($t==1){
                        $bl = $options['site_subl']/100;
                    }
                }
            }

            //如果上级是会员或商家 进入这里 如果上级是代理商进else
            if($bl>0){
                $user = M("oauth_user")->find($id);

                //提成金额
                $tcmoney = $price * $bl;

                //用户和商家提成到会员账户
                $topuser['score'] += $tcmoney;
                M("oauth_user")->save($topuser);

                $ar = array(
                    "userid"        =>      $uid,
                    "sellerid"        =>      $id,
                    "op"        =>      "fenyong",
                    "itype"        =>      1,
                    "integral"        =>      $price,
                    "integral_sj"        =>      $tcmoney,
                    "cur_integral"        =>      $topuser['score'],
                    "remark"        =>      "您推荐的会员 ".($user['user_nicename']?$user['user_nicename']:$user['mobile'])." 赠送了".$price."，您获得 ".$tcmoney." 积分",
                    "date"        =>      $date
                );
                M("user_integral")->add($ar);
                //消息发送
                sendmessage($id,$uid,"会员消费佣金","您推荐的会员 ".($user['user_nicename']?$user['user_nicename']:$user['mobile'])." 赠送了".$price."，您获得 ".$tcmoney." 积分",array(
                    $topuser['openid'],
                    "您推荐的会员 ".($user['user_nicename']?$user['user_nicename']:$user['mobile'])." 赠送了".$price."，您获得 ".$tcmoney." 积分",
                    ($topuser['user_nicename']?$topuser['user_nicename']:$topuser['mobile']),
                    $date,
                    $tcmoney,
                    $topuser['score'],
                    "会员消费佣金",
                    "感谢您的使用！",
                    U("User/score",array("openid"=>$topuser['openid'])) //以前这里是$user
                ),1,$date);
            }else if($topuser['user_type']==3){
                //上级是代理

                //获取上级代理级别
                $lv = M("user_dl")
                    ->alias("ud")//表别名
                    ->join(C ( 'DB_PREFIX' )."dl_level dl ON ud.lid = dl.id")
                    ->where("ud.uid=".$topuser['id'])//条件
                    ->field("ud.*, dl.fybl, dl.fybl_sj")//查询内容
                    ->find();
//file_put_contents(time().'_0.txt', print_r($lv, true));exit;
                //代理是否禁用
                if($lv['isenable']==1){
                    //根据本身身份 来选择分佣比例 用户称呼不同
                    if($t==1){
                        $bl = $lv['fybl']/100;
                        $user = M("oauth_user")->find($id);
                    }else if($t==2){
                        $bl = $lv['fybl_sj']/100;
                        $user = M("oauth_user")
                            ->alias("ou")//表别名
                            ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id")
                            ->where("ou.id=".$id)//条件
                            ->field("ou.*,s.name user_nicename")//查询内容
                            ->find();
                    }
                    if($bl>0){
                        //提成金额
                        $tcmoney = $price * $bl;
                        //代理商
                        $dl = M("user_dl")->where("uid=".$topuser['id'])->find();
                        //代理商提成到代理商账户
                        $dl['dl_score'] += $tcmoney;
                        M("user_dl")->save($dl);
                        //明细
                        $ar = array(
                            "userid"        =>      $uid,
                            "sellerid"        =>      $id,
                            "op"        =>      "fenyong",
                            "itype"        =>      3,
                            "integral"        =>      $price,
                            "integral_sj"        =>      $tcmoney,
                            "cur_integral"        =>      $dl['dl_score'],
                            "remark"        =>      "您推荐的 ".($user['user_nicename']?$user['user_nicename']:$user['mobile'])." 赠送了".$price."，您获得 ".$tcmoney." 积分",
                            "date"        =>      $date
                        );
                        M("user_integral")->add($ar);
                        //
                        //消息发送
                        sendmessage($id,$uid,"会员消费佣金","您推荐的 ".($user['user_nicename']?$user['user_nicename']:$user['mobile'])." 赠送了".$price."，您获得 ".$tcmoney." 积分",array(
                            $topuser['openid'],
                            "您推荐的 ".($user['user_nicename']?$user['user_nicename']:$user['mobile'])." 赠送了".$price."，您获得 ".$tcmoney." 积分",
                            ($topuser['user_nicename']?$topuser['user_nicename']:$topuser['mobile']),
                            $date,
                            $tcmoney,
                            $dl['dl_score'],
                            "会员消费佣金",
                            "感谢您的使用！",
                            U("Agent/score",array("openid"=>$topuser['openid']))   //以前这里是$user
                        ),1,$date);                       
                        
                        //2019-7-19 
                        //代理商A推荐的代理商B，代理商B推荐的商家有收入时，代理商B此时有收入，
                        //同时给代理商A再按代理商B的收入比例增加收入，注：只有指定的代理商A有此
                        $agent_recomm_user = M("oauth_user")->find($user['tjrr']);;
                        $this->agent_recomm_dlfy($agent_recomm_user, $tcmoney);
                        
                    }                    
                }
            }
        }

        //如果是商家
        if($t==2){
            //判断此区域是否存在区域代理
            //此用户的
            $seller = M("oauth_user")
                ->alias("ou")//表别名
                ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id")
                ->where("ou.id=".$id)//条件
                ->field("s.*")//查询内容
                ->find();
            //验证用户地址 必须存在区域才会查询上级代理商
            if($seller['sheng']!="请选择省份"&&$seller['shi']!="请选择市"&&$seller['qu']!="请选择区|县"){
                $where = array(
                    "ud.sheng"         =>       $seller['sheng'],
                    "ud.shi"         =>         array(array("like",$seller['shi']),array("like","请选择市"),"or"),
                    "ud.qu"         =>          array(array("like",$seller['qu']),array("like","请选择区|县"),"or"),
                    "ud.isenable"      =>       1
                );
                $dllist = M("user_dl")
                    ->alias("ud")//表别名
                    ->join(C ( 'DB_PREFIX' )."dl_level dl ON ud.lid = dl.id")
                    ->join(C ( 'DB_PREFIX' )."oauth_user ou ON ou.id = ud.uid")
                    ->where($where)//条件
                    ->field("ud.*,dl.qyfd,ou.id uid")//查询内容
                    ->select();
                foreach($dllist as $key => $lv){
                    //根据本身身份 来选择分佣比例 用户称呼不同
                    $bl = $lv['qyfd']/100;
                    if($t==1){
                        $user = M("oauth_user")->find($id);
                    }else if($t==2){
                        $user = M("oauth_user")
                            ->alias("ou")//表别名
                            ->join(C ( 'DB_PREFIX' )."store s ON s.uid = ou.id")
                            ->where("ou.id=".$id)//条件
                            ->field("ou.*,s.name user_nicename")//查询内容
                            ->select();
                    }
                    if($bl>0){
                        //提成金额
                        $tcmoney = $price * $bl;
                        //代理商
                        $dl = M("user_dl")->find($lv['id']);
                        //代理商提成到代理商账户
                        $dl['dl_score'] += $tcmoney;
                        M("user_dl")->save($dl);
                        //明细
                        $ar = array(
                            "userid"        =>      $lv['uid'],
                            "sellerid"        =>      $id,
                            "op"        =>      "fenyong_qy",
                            "itype"        =>      3,
                            "integral"        =>      $price,
                            "integral_sj"        =>      $tcmoney,
                            "cur_integral"        =>      $dl['dl_score'],
                            "remark"        =>      "您所在区域 ".($user['user_nicename']?$user['user_nicename']:$user['mobile'])." 赠送了".$price."元，您获得 ".$tcmoney." 积分",
                            "date"        =>      $date
                        );
                        M("user_integral")->add($ar);
                        //消息发送
                        sendmessage($id,$lv['uid'],"代理区域佣金","您所在区域 ".($user['user_nicename']?$user['user_nicename']:$user['mobile'])." 赠送了".$price."元，您获得 ".$tcmoney." 积分",array(),3,$date);
                        
                        //2019-7-19 
                        //代理商A推荐的代理商B，代理商B推荐的商家有收入时，代理商B此时有收入，
                        //同时给代理商A再按代理商B的收入比例增加收入，注：只有指定的代理商A有此
                        ///// 此处未测试  
                        //$agent_recomm_user = M("oauth_user")->find($user['tjrr']);;
                        //$this->agent_recomm_dlfy($agent_recomm_user, $tcmoney);
                        
                    }
                }
            }
        }
    }
    
    //2019-7-19 
    //代理商A推荐的代理商B，代理商B推荐的商家有收入时，代理商B此时有收入，
    //同时给代理商A再按代理商B的收入比例增加收入，注：只有指定的代理商A有此  
    public function agent_recomm_dlfy ($topuser, $tcmoney) {
//file_put_contents(time().'_1.txt', print_r($topuser, true). ' tcmoney='.$tcmoney);
        //判断有无推荐人
        if (!$topuser['tjrr']) {
            return false;
        }
        
        if ($tcmoney <= 0) {
            return false;
        }
        
        //用户信息
        $user = M("oauth_user")->find($topuser['tjrr']);//file_put_contents(time().'_2.txt', print_r($user, true));
        if (!$user) {
            return false;
        }

        //代理信息
        $agent = M("user_dl")
            ->alias("ud")//表别名
            ->join(C ( 'DB_PREFIX' )."dl_level dl ON ud.lid = dl.id")
            ->where("ud.uid=".$topuser['tjrr'])
            ->field("ud.*, dl.dlfy")
            ->find();
            
        if (!$agent) {
            return false;
        }
        
        if ($agent['dlfy'] <= 0) {
            return false;
        }
        
        //计算代理推荐代理获取的代理提成
        $tcmoney = round($tcmoney * $agent['dlfy'] / 100, 2);
        
        if ($tcmoney <= 0) {
            return false;
        }
        
        $date = time();
        //代理商
        //$dl = M("user_dl")->where("uid=".$topuser['id'])->find();
        //代理商提成到代理商账户
        $agent['dl_score'] += $tcmoney;
        M("user_dl")->save($agent);
        
        //明细
        $remark = "您推荐的代理 ".($topuser['user_nicename']?$topuser['user_nicename']:$topuser['mobile'])." ，您获得 ".$tcmoney." 积分";
        $ar = array(
            "userid"        =>      $user['id'],
            "sellerid"        =>      0,
            "op"        =>      "fenyong_dl",
            "itype"        =>      3,
            "integral"        =>      $tcmoney,
            "integral_sj"        =>      $tcmoney,
            "cur_integral"        =>      $agent['dl_score'],
            "remark"        =>      $remark,
            "date"        =>      $date
        );
        M("user_integral")->add($ar);
        //
        //消息发送
        sendmessage($topuser['id'], $user['id'], "代理推荐佣金", $remark, array(
            $user['openid'],
            $remark,
            ($user['user_nicename']?$user['user_nicename']:$user['mobile']),
            $date,
            $tcmoney,
            $agent['dl_score'],
            "代理推荐佣金",
            "感谢您的使用！",
            U("Agent/score",array("openid"=>$user['openid']))   //以前这里是$user
        ),1,$date);

        
    }
    
    
}