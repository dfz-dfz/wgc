<?php
namespace Org\Util;

class Wxconnect{
	//返回的数据
	private $data="";
	//getCode()获取的code参数
	private $code="";
	//应用唯一标识
	private $appid="";
	//应用密钥AppSecret，在微信开放平台提交应用审核通过后获得
	private $AppSecret="";
	//接口调用凭证,通过getCode()获得
	private $access_token="";
	//重定向地址，需要进行UrlEncode
	public $callurl="";
	//授权用户唯一标识
	private $openid="";
	//记录错误信息
	private $error="";
	//用户刷新access_token
	private $refresh_token="";
	//access_token接口调用凭证超时时间，单位（秒）
	private $expires_in="";

	public function __construct(){
		$this->appid = C('wxlogin.appid');
		$this->AppSecret = C('wxlogin.AppSecret');
		$this->callurl=C('wxlogin.callback');
		if( !empty($_GET['code']) && $_GET['state'] == $_SESSION['wxstate'] ){
			$this->code = $_GET['code'];	//	获取返回code
		}else{
			$this->error="没获取code";
		}
	}

	//此方法跳转到授权页面
	public function getCode(){
		$http = 'https://open.weixin.qq.com/connect/oauth2/authorize?';
		$get = array(
				'appid'=>$this->appid,
				'redirect_uri'=>$this->callurl,
				'response_type'=>'code',
				'scope'=>'snsapi_userinfo',
				'state'=>mt_rand(100000,999999)
					);
		$_SESSION['wxstate'] = $get['state'];
		$http =$http.http_build_query($get).'#wechat_redirect';
		header('location:'.$http);
	}

	public function getOpenId(){
		if(empty($this->openid)){
			if( $this->getAuthCode() ){
				return $this->openid;
			}else{
				$this->checkerror();
			}
		}else{
			return $this->openid;
		}
	}

	public function getAccessToken(){
		if(empty($this->access_token)){
			if( $this->getAuthCode() ){
				return $this->access_token;
			}else{
				$this->checkerror();
			}
		}else{
			return $this->access_token;
		}
	}

	public function getAuthCode(){
		if($this->data){
			return $this->data;
		}
		$this->checkerror();
		$http = 'https://api.weixin.qq.com/sns/oauth2/access_token?';
		$get = array(
				'appid'=>$this->appid,
				'secret'=>$this->AppSecret,
				'code'=>$this->code,
				'grant_type'=>'authorization_code'
					);
		$http = $http.http_build_query($get);

		$data = $this->getUrl($http);

        if($data){
        	$this->data = json_decode($data);
        	$this->access_token = $this->data->access_token;
        	$this->openid = $this->data->openid;
        	$this->refresh_token = $this->data->refresh_token;
        	return json_decode($data);
        }else{
        	$this->error = "获取Access_token失败";
        	return false;
        }
	}

	private function getUrl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
	}

	public function checkerror(){
		if($this->error){
			echo "<pre>";
			var_dump($this->data);
			exit($this->error);
		}
	}

	public function refresh_token(){
		$this->checkerror();
		$http = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?';
		$get = array(
				'appid'=>$this->appid,
				'grant_type'=>'refresh_token',
				'refresh_token'=>$this->refresh_token
					);
		$http = $http.http_build_query($get);
		$data = $this->getUrl($http);
		if($data){
			$data = json_decode($data);
			$this->access_token = $data->access_token;
			return $data;
		}else{
			$this->error="更新token出错";
			return false;
		}
	}

	public function getUserInfo()
	{
		$this->checkerror();
		$http = 'https://api.weixin.qq.com/sns/userinfo?';
		$get = array(
				'access_token'=>$this->getAccessToken(),
				'openid'=>$this->getOpenId(),
				'lang'=>'zh_CN'
					);
		$http = $http.http_build_query($get);
		$data = $this->getUrl($http);
		if($data){
			return $data;
		}else{
			$this->error = "获取用户资料失败！";
			return false;
		}
	}
}