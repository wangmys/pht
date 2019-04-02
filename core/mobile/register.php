<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}
class Register_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		$u = pdo_get('ewei_shop_info_user',['openid'=>$_W['openid']]);
		if (!empty($u)) {
			header('Location:'.mobileUrl('info/info/user'));
		}
		include $this->template('info/register/register');
	}

	//检测手机验证码
	public function checkCode()
	{	
		global $_W;
		global $_GPC;
		$mobile = trim($_GPC['mobile']);
		$verifycode = trim($_GPC['verifycode']);
		$key = '__ewei_shopv2_member_verifycodesession_' . $_W['uniacid'] . '_' . $mobile;
		if (!isset($_SESSION[$key]) || ($_SESSION[$key] !== $verifycode) || !isset($_SESSION['verifycodesendtime']) || (($_SESSION['verifycodesendtime'] + 600) < time())) {
			show_json(0, '验证码错误或已过期');
		}
		unset($_SESSION[$key]);
		show_json(1);
	}

	public function reg()
	{	
		global $_W;
		global $_GPC;
		$data = $_GPC['data'];
		if(empty($data)){
			show_json(0,'注册信息不能为空');
		}
		$arr = explode(' ',$data['city']);
		$data['province'] = $arr[0];//省
		$data['city'] = $arr[1];//市
		$data['area'] = $arr[2];//区
		foreach ($data as $key => $value) {
			if(empty($value) && $key!='medical' && $key!='sex'){
				show_json(0,'您填写的注册信息不完整');
			}
			if($key=='buytime' || $key=='birthtime'){//购买时间 || 出生日期
				$data[$key] = strtotime($value);
			}
		}
		$data['openid'] = $_W['openid'];
		if(empty($data['openid'])) show_json(0,'未获取到用户信息');
		$rs = pdo_insert('ewei_shop_info_user',$data);
		if($rs) show_json(1,['message'=>'注册成功','url'=>mobileUrl('info/info')]);
		show_json(0,'注册失败');
	}
}