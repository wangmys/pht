<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
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

	public function main()
	{
		global $_W;
		global $_GPC;
		include $this->template();
	}
	
	public function lists()
	{
		global $_W;
		global $_GPC;
		$keyword = trim($_GPC['keyword']);
		$age1 = trim($_GPC['age1']);
		$age2 = trim($_GPC['age2']);
		
		//获取页数
		$pindex = max(1, intval($_GPC['page']));
		//获取页行数
		$psize = 10;
		//分页信息
		$limit = " limit " . ($pindex - 1) * $psize . ',' . $psize;
		if($keyword || $age1 || $age2){
			if(!empty($keyword)){$k="%{$keyword}%";}else{$k='';}
			$sql = "SELECT user.*,member.nickname,member.avatar,member.openid FROM ims_ewei_shop_info_user as user LEFT JOIN ims_ewei_shop_member as member ON user.openid = member.openid WHERE user.username LIKE :username OR (age BETWEEN :age1 AND :age2) OR buystore LIKE :buystore";
			$params = array(':username' =>$k,':age1' => $age1,':age2' => $age2,':buystore' => $k);
			$info = pdo_fetchAll($sql.$limit,$params);
		}else{
			$sql = "SELECT user.*,member.nickname,member.avatar FROM ims_ewei_shop_info_user as user LEFT JOIN ims_ewei_shop_member as member ON user.openid = member.openid";
			$info = pdo_fetchAll($sql.$limit);
			$params = [];
		}
		// if(is_array($info)){
		// 	$custom = array_column($info,'custom');
		// }
		$custom = [];
		foreach ($info as $key => $val) {
			$custom[$val['id']] = unserialize($val['custom']);
		}
		$total = count(pdo_fetchall($sql,$params));
		$pager = pagination2($total, $pindex, $psize);
		include $this->template('info/infoList');
	}

	public function users()
	{
		global $_W;
		global $_GPC;
		$keyword = trim($_GPC['keyword']);
		$age1 = trim($_GPC['age1']);
		$age2 = trim($_GPC['age2']);
		
		//获取页数
		$pindex = max(1, intval($_GPC['page']));
		//获取页行数
		$psize = 10;
		//分页信息
		$limit = " limit " . ($pindex - 1) * $psize . ',' . $psize;
		if($keyword || $age1 || $age2){
			if(!empty($keyword)){$k="%{$keyword}%";}else{$k='';}
			$sql = "SELECT user.*,member.nickname,member.openid FROM ims_ewei_shop_info_user as user LEFT JOIN ims_ewei_shop_member as member ON user.openid = member.openid WHERE user.username LIKE :username OR (age BETWEEN :age1 AND :age2) OR buystore LIKE :buystore";
			$params = array(':username' =>$k,':age1' => $age1,':age2' => $age2,':buystore' => $k);
			$info = pdo_fetchAll($sql.$limit,$params);
		}else{
			$sql = "SELECT user.*,member.nickname FROM ims_ewei_shop_info_user as user LEFT JOIN ims_ewei_shop_member as member ON user.openid = member.openid";
			$info = pdo_fetchAll($sql.$limit);
			$params = [];
		}
		
		$total = count(pdo_fetchall($sql,$params));
		$pager = pagination2($total, $pindex, $psize);
		include $this->template('info/list');
	}
	//删除用户信息
	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		try{
			if($id){
				$result= pdo_delete('ewei_shop_info_user',array('id' => $id));
			}else{
				$id = $_GPC['ids'];
				$result= pdo_delete('ewei_shop_info_user',array('id in' => $id));
			}
		}catch(\Exception $e){
			show_json(2);
		}
		show_json(1);
	}

	//查看用户详情信息
	public function detail()
	{	
		global $_W;
		global $_GPC;
		$diyform_data = $this->diyformData();
		extract($diyform_data);
		$id = $_GPC['id'];
		$sql = "SELECT user.*,member.nickname,member.avatar FROM ims_ewei_shop_info_user as user LEFT JOIN ims_ewei_shop_member as member ON user.openid = member.openid WHERE user.id= :id";
			$params = [':id'=>$id];

		$data = pdo_fetch($sql.$limit,$params);
		if(is_array($data['custom']) || !empty($data['custom'])){
			$custom = unserialize($data['custom']);
		}
		include $this->template('info/detail');
	}
}

?>
