<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index($id)
	{
		$this->load->model('Url_model');
		$result = $this->Url_model->getInfo($id);

		$data['pay_url'] = $result->pay_url;	
		$data['redbag_url'] = $result->redbag_url;	

		$this->load->view('welcome_message', $data);
	}

	public function input()
	{
		$data["signPackage"] = $this->getSignPackage();
		$this->load->view('input.html', $data);
	}

	public function post()
	{
		$data['url1'] = $_POST['url1'];
		$data['url2'] = $_POST['url2'];
		$this->load->model('Url_model');
		$this->Url_model->insertInfo();
		$this->load->view('success.html', $data);
	}

	//获取accesstoken
    public function getAccessToken()
    {
 		$APPID = 'wxe43ed0c0c91b2f3c';
 		$APPSECRET = '47e1bda71e378527cc0c80a394c779f4';
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$APPID."&secret=".$APPSECRET;
        // 微信返回的信息
        $returnData = json_decode($this->curlHttp($url));
        $resData['accessToken'] = $returnData->access_token;
        $resData['expiresIn'] = $returnData->expires_in;
        $resData['time'] = date("Y-m-d H:i",time());
 
        $res = $resData;
        return $res;
    }

    // 获取api_ticket
    public function getJsApiTicket($accessToken) {
 
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$accessToken."&&type=jsapi";
        // 微信返回的信息
        $returnData = json_decode($this->curlHttp($url));
 
        $resData['ticket'] = $returnData->ticket;
        $resData['expiresIn'] = $returnData ->expires_in;
        $resData['time'] = date("Y-m-d H:i",time());
        $resData['errcode'] = $returnData->errcode;
 
        return $resData;
    }

    // 获取签名
    public function getSignPackage() {
    	$this->load->helper('url');
        // 获取token
        $token = $this->getAccessToken();
        // 获取ticket
        $ticketList = $this->getJsApiTicket($token['accessToken']);
        $ticket = $ticketList['ticket'];
       
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        // var_dump('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        // 生成时间戳
        $timestamp = time();
        // 生成随机字符串
        $nonceStr = $this->createNoncestr();
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序 j -> n -> t -> u
        $string = "jsapi_ticket=".$ticket."&noncestr=".$nonceStr."&timestamp=".$timestamp."&url=".$url;
        $signature = sha1($string);
        $signPackage = array (
            "appId" => 'wxe43ed0c0c91b2f3c',
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string,
            "ticket" => $ticket,
            "token" => $token['accessToken']
        );

        // 返回数据给前端
        return $signPackage;
    }
 
    // 创建随机字符串
    public function createNoncestr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for($i = 0; $i < $length; $i ++) {
            $str .= substr ( $chars, mt_rand ( 0, strlen ( $chars ) - 1 ), 1 );
        }
        return $str;
    }
 
 	// 服务端发起请求
    public function curlHttp($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($curl, CURLOPT_TIMEOUT, 500 );
        curl_setopt($curl, CURLOPT_URL, $url );
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

}
