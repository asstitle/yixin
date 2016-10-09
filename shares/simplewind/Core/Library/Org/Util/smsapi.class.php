<?php
namespace Org\Util;
/**
 * 短信接口
 * @author：凌翌航
 */
class smsapi {

    /**
     * 短信接口API地址
     */
    var $api_url = array(
        'send' => 'sdk2.zucp.net:8060/webservice.asmx/mt',
        'balance' => 'sdk2.zucp.net:8060/webservice.asmx/GetBalance',
    );

    /**
     * 定义账户密码
     */
    var $sn = null;
    var $pwd = null;

    /**
     * 定义远程传输
     */
    var $t = null;

    /**
     * 存放程序执行过程中的错误信息，这样做的一个好处是：程序可以支持多语言。
     * 程序在执行相关的操作时，error_no值将被改变，可能被赋为空或大等0的数字.
     * 为空或0表示动作成功；大于0的数字表示动作失败，该数字代表错误号。
     *
     * @access  public
     * @var     array       $errors
     */
    var $errors = array(
        'api_errors' => array('error_no' => -1, 'error_msg' => ''),
        'server_errors' => array('error_no' => -1, 'error_msg' => '')
    );

    function __construct() {
        $this->sms();
    }

    function sms() {
        //$sms_setting = getcache('sms','sms');
        //$sms_uid = $sms_setting[1]['userid'];
        //$sms_pid = $sms_setting[1]['productid'];
        //$sms_passwd = $sms_setting[1]['sms_key'];
        //$this->sn = $sms_pid;
       // $this->pwd = $sms_passwd;
        
        $this->sn = "SDK-WSS-010-04011";
        $this->pwd = '$-fd$f-4';
        //pc_base::load_app_class('Transport', 'content', 0); //引入Sms类
        $this->t = new \Org\Util\Transport(-1, -1, -1, false);
    }

    /**
     * 发送短信
     */
    function send($moblie, $content) {

        $contents = $this->get_contents($moblie, $content);
        if (!$contents) {
            $this->errors['api_errors']['error_no'] = 3; //发送的信息有误
            return false;
        }

        /* 获取API URL */
        $sms_url = $this->get_url('send');
        if (!$sms_url) {
            $this->errors['api_errors']['error_no'] = 6; //URL不对
            return false;
        }

        $send_str = array(
            'sn' => $this->sn,
            'pwd' => strtoupper(md5($this->sn . $this->pwd)),
            'mobile' => $contents['phones'],
            'content' => $contents['content'],
            'ext' => '',
            'stime' => '',
            'rrid' => ''
        );
        $response = $this->t->request($sms_url, $send_str, 'POST');
        $result = $this->filter_result($response);
        if (count($result['result']) > 1) {
            $this->errors['server_errors']['error_no'] = $result['str'];
            return $result;
        } else {
            return true;
        }
    }

    /**
     * 获取剩余短信数量
     */
    function getBalance() {
        /* 获取API URL */
        $sms_url = $this->get_url('balance');
        if (!$sms_url) {
            $this->errors['api_errors']['error_no'] = 6; //URL不对
            return false;
        }
        $send_str = array(
            'sn' => $this->sn,
            'pwd' => $this->pwd,
        );
        $response = $this->t->request($sms_url, $send_str, 'POST');
        $result = $this->filter_result($response);
        return $result['str'];
    }

    /**
     * 转码
     */
    function dgg_iconv($source_lang, $target_lang, $source_string = '') {
        static $chs = NULL;

        /* 如果字符串为空或者字符串不需要转换，直接返回 */
        if ($source_lang == $target_lang || $source_string == '' || preg_match("/[\x80-\xFF]+/", $source_string) == 0) {
            return $source_string;
        }

        if ($chs === NULL) {
            //pc_base::load_app_class('Chinese', 'content', 0); //引入smsapi类
            $chs = new \Org\Util\Chinese(APP_PATH);
        }

        return $chs->Convert($source_lang, $target_lang, $source_string);
    }

    //检查手机号和发送的内容并生成生成短信队列
    function get_contents($phones, $msg) {
        if (empty($phones) || empty($msg)) {
            return false;
        }


        $phones = explode(',', $phones);
        foreach ($phones as $key => $value) {

            if ($this->is_moblie($value)) {
                $phone[] = $value;
            }
        }

        if (!empty($phone)) {
            $msg = $msg . "【顶呱呱集团】";
            $phone_array['phones'] = implode(',', $phone);
            $phone_array['content'] = $this->dgg_iconv('UTF-8', 'GBK', $msg);
            return $phone_array;
        } else {
            return false;
        }
    }

    /**
     * 返回指定键名的URL
     *
     * @access  public
     * @param   string      $key        URL的名字，即数组的键名
     * @return  string or boolean       如果由形参指定的键名对应的URL值存在就返回该URL，否则返回false。
     */
    function get_url($key) {
        $url = $this->api_url[$key];

        if (empty($url)) {
            return false;
        }

        return $url;
    }

    /**
     * 检测手机号码是否正确
     *
     */
    function is_moblie($moblie) {
        return preg_match("/^0?(13[0-9]|15[012356789]|18[01236789]|14[57]|17[01236789])[0-9]{8}$/", $moblie);
    }

    /**
     * 处理返回数据 
     */
    function filter_result($response) {
        preg_match('/<string xmlns=\"http:\/\/tempuri.org\/\">(.*)<\/string>/', $response['body'], $str);
        $result = explode("-", $str[1]);
        return array('result' => $result, 'str' => $str);
    }

}
