<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Video_EweiShopV2Page extends PluginWebPage
{
	//显示视频列表
	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$keyword = trim($_GPC['keyword']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$limit = ' ORDER BY displayorder DESC limit ' . (($pindex - 1) * $psize) . ',' . $psize;
		if($keyword){
			$sql = "SELECT * FROM ims_ewei_shop_info_video WHERE video_name LIKE :video_name OR video_name  uniacid = {$uniacid}";
			$params = [':video_name' => "%{$keyword}%"];

			$video = pdo_fetchAll($sql.$limit,$params);

		}else{
			$sql = "SELECT * FROM ims_ewei_shop_info_video WHERE uniacid = {$uniacid}";
			$params = [];
			$video = pdo_fetchAll($sql.$limit,$params);
		}
		
		$total = count(pdo_fetchAll($sql,$params));
		$pager = pagination2($total, $pindex, $psize);
		include $this->template('info/video/list');die;
	}

	//录入视频页面
	public function add()
	{

		$this->post('info/video/post');
	}


	protected function post($file_name)
	{
		global $_W;
		global $_GPC;

		$uniacid = $_W['uniacid'];

		$id = intval($_GPC['id']);

		if($id){
			$data = pdo_get('ewei_shop_info_video',array('id'=>$id));
			empty($data) ? die('没有该条视频信息!') : '';
		}
		include $this->template($file_name);
	}

	//显示编辑视频页面
	public function edit(){
		$this->post('info/video/post');
	}

	//将视频数据添加至数据库
	public function save()
	{
		global $_W;
		global $_GPC;
		//获取提交的视频信息
		$data = $_GPC['data'];
		$id = intval($_GPC['id']);
		//获取公众号ID信息
		$data['uniacid'] = $_W['uniacid'];
		$data['upload_time'] = time();
		$_W['ispost'] ? '' : die('非法访问');
		try{
			if($id){//如果ID存在执行修改操作,如果不存在执行插入操作
				$result= pdo_update('ewei_shop_info_video', $data , array('id' => $id));
			}else{
				$result= pdo_insert('ewei_shop_info_video', $data);
			}
		}catch(\Exception $e){
			show_json(2);
		}
		show_json(1,array('url' => webUrl('info/video')));
	}

	//删除视频
	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		try{
			if($id){
				$result= pdo_delete('ewei_shop_info_video',array('id' => $id));
			}else{
				$id = $_GPC['ids'];
				$result= pdo_delete('ewei_shop_info_video',array('id in' => $id));
			}
		}catch(\Exception $e){
			show_json(2);
		}
		show_json(1);
	}

	//更改视频发布状态
	public function enabled()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = (is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0);
		}
		$items = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_info_video') . ' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid']);
		foreach ($items as $item) {
			pdo_update('ewei_shop_info_video', array('enabled' => intval($_GPC['enabled'])), array('id' => $item['id']));
			plog('info.video.edit', ('修改视频发布状态<br/>ID: ' . $item['id'] . '<br/>标题: ' . $item['video_name'] . '<br/>状态: ' . $_GPC['enabled']) == 1 ? '发布' : '未发布');
		}
		show_json(1, array('url' => referer()));
	}

	public function displayorder()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$displayorder = intval($_GPC['value']);
		$item = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_info_video') . ' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid']);
		if (!empty($item)) {
			pdo_update('ewei_shop_info_video', array('displayorder' => $displayorder), array('id' => $id));
		}
		show_json(1,array('url' => referer()));
	}
}