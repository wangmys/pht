<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Cover_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		//注册首页链接
		$infoUrl = mobileUrl('info.info.user',array(),true);
		$infoQrcode = m('qrcode')->createQrcode($infoUrl);
		include $this->template();
	}

	//注册信息设置
	public function regset()
	{	
		global $_W;
		global $_GPC;

		include $this->template('info/regset');
	}
}