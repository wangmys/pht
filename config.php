<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'info',
	'name'    => '信息收集',
	'v3'      => true,
	'menu'    => array(
		'plugincom' => 1,
		'items'     => array(
			array('title' => '幻灯片管理', 'route' => 'adv'),
			array('title' => '信息列表', 'route' => 'index.lists'),
			array(
				'title'  => '个人中心',
				'route'  => '',
				'extend' => '',
				'items'  => array(
						array('title' => '公司介绍', 'route' => 'introduce'),
						array('title' => '精彩视频', 'route' => 'video'),
						array('title' => '产品介绍', 'route' => 'product')
					)
				),
			array('title' => '企业介绍', 'route' => 'business'),
			array(
				'title'  => '其他设置',
				'route'  => '',
				'extend' => '',
				'items'  => array(
						array('title' => '入口设置', 'route' => 'cover'),
						array('title' => '注册信息设置', 'route' => 'cover.regset')
					)
				)
			)
		)
	);

?>
