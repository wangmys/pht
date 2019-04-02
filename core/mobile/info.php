<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Info_EweiShopV2Page extends MobileLoginPage
{
	protected $member;

	public function __construct()
	{
		global $_W;
		global $_GPC;
		parent::__construct();
		$this->member = m('member')->getInfo($_W['openid']);
	}

	protected function diyformData()
	{
		$template_flag = 0;
		$diyform_plugin = p('diyform');

		if ($diyform_plugin) {
			$set_config = $diyform_plugin->getSet();
			$user_diyform_open = $set_config['user_diyform_open'];

			if ($user_diyform_open == 1) {
				$template_flag = 1;
				$diyform_id = $set_config['user_diyform'];

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

	public function main()
	{
		global $_W;
		global $_GPC;
		
		$diyform_data = $this->diyformData();
		extract($diyform_data);
		$returnurl = urldecode(trim($_GPC['returnurl']));
		$member = $this->member;
		$wapset = m('common')->getSysset('wap');
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$show_data = 1;
		if ((!empty($new_area) && empty($member['datavalue'])) || (empty($new_area) && !empty($member['datavalue']))) {
			$show_data = 0;
		}
		$info = pdo_get('ewei_shop_info_user',['openid'=>$member['openid']]);
		if(empty($info)){
			header('Location:'.mobileUrl('info/register'));die;
		}

		include $this->template();
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$data = $_GPC['memberdata'];
		if(empty($data['city']) || empty($data['province']) || empty($data['area'])){
			unset($data['city']);
			unset($data['province']);
			unset($data['area']);
		}
		if(!empty($data['birthtime'])){
			$data['birthtime'] = strtotime($data['birthtime']);
		}
		if($data['sex']=='男'){
			$data['sex'] = 1;
		}else if($data['sex']=='女'){
			$data['sex'] = 0;
		}else{
			$data['sex'] = 2;
		}
		unset($data['datavalue']);
		$rs = pdo_update('ewei_shop_info_user',$data,['openid'=>$openid]);
		show_json(1);
	}

	public function face()
	{
		global $_W;
		global $_GPC;

		$member = $this->member;
		// echo "<pre>";
		// var_dump($member['province']);die;
		$areas =$member['province']." ".$member['city'];
		$addressarea = $member['area'];
		$show_data = 1;
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$address_street = intval($area_set['address_street']);
		if ((empty($member['datavalue']))) {
			$show_data = 0;
		}
		$info = pdo_get('ewei_shop_info_user',['openid'=>$member['openid']]);
		if ($_W['ispost']) {	
			$areas = $_GPC['areas'];
			$areaarr = explode(" ",$areas);
			$nickname = trim($_GPC['nickname']);
			$avatar = trim($_GPC['avatar']);
			$province = $areaarr[0];
			$cityarea = $areaarr[1]." ".$areaarr[2];
			$address = $_GPC['address'];
			$datavalue = $_GPC['datavalue'];
			$isdefault = 1;
			if (empty($nickname)) {
				show_json(0, '请填写昵称');
			}

			if (empty($avatar)) {
				show_json(0, '请上传头像');
			}

			pdo_update('ewei_shop_member', array('avatar' => $avatar, 'nickname' => $nickname,"province" => $province,"city" =>$cityarea,"area" => $address,"datavalue" =>$datavalue), array('id' => $member['id'], 'uniacid' => $_W['uniacid']));
			show_json(1);
		}

		include $this->template();
	}

	//个人中心	
	public function user()
	{	
		global $_W;
		global $_GPC;
		$u = pdo_get('ewei_shop_info_user',['openid'=>$_W['openid']]);
		if (empty($u)) {
			header('Location:'.mobileUrl('info/register'));
		}
		//用户信息
		$member = $this->member;
		//公司介绍
		$introduce = pdo_getall('ewei_shop_info_introduce',['enabled'=>1],[],'','displayorder DESC');
		//产品介绍
		$product = pdo_getall('ewei_shop_info_product',['enabled'=>1],[],'','displayorder DESC');
		//精彩视频
		$video = pdo_getall('ewei_shop_info_video',['enabled'=>1],[],'','displayorder DESC');

		// echo "<pre>";
		// print_r($introduce);
		// print_r($product);
		// print_r($video);
		// die;
		include $this->template('info/user');
	}

	//精彩视频播放
	public function videoPlay()
	{	
		global $_W;
		global $_GPC;

		$id = $_GPC['id'];
		$video = pdo_get('ewei_shop_info_video',['enabled'=>1,'id'=>$id]);

		include $this->template('info/videoPlay');
	}
}

?>
