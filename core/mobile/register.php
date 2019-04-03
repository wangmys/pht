<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}
class Register_EweiShopV2Page extends PluginMobilePage
{
	protected function diyformData()
	{
		$template_flag = 0;
		$diyform_plugin = p('diyform');

		if ($diyform_plugin) {
			$set_config = $diyform_plugin->getSet();
			$info_diyform_open = $set_config['info_diyform_open'];
			if ($info_diyform_open == 1) {
				$template_flag = 1;
				$diyform_id = $set_config['info_diyform'];

				if (!empty($diyform_id)) {
					$formInfo = $diyform_plugin->getDiyformInfo($diyform_id);
					$fields = $formInfo['fields'];
					$diyform_data = iunserializer($this->member['diymemberdata']);
					$f_data = $diyform_plugin->getDiyformData($diyform_data, $fields, $this->member);
				}
			}
		}

		return array('template_flag' => $template_flag, 'set_config' => $set_config, 'diyform_plugin' => $diyform_plugin, 'formInfo' => $formInfo, 'diyform_id' => $diyform_id, 'diyform_data' => $diyform_data, 'fields' => $fields, 'f_data' => $f_data);
	}
	//显示注册页面
	public function main()
	{
		global $_W;
		global $_GPC;
		$diyform_data = $this->diyformData();
		extract($diyform_data);
		$title = json_encode($fields);
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
		//自定义信息
		$custom = $data['custom'];
		if(!empty($custom)){
			$data['custom'] = serialize($data['custom']);
		}

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