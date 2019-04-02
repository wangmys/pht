<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}
class Index_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		//音乐首页
		global $_W;
		global $_GPC;

		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$keywords = $_GPC['keywords'];
		// 查询出试听音乐
		if (empty($where)) {
			$data = pdo_fetchall("SELECT * FROM ims_ewei_shop_music WHERE find_in_set(:type,type) AND status=1 ",[':type'=>'1']);
		}else{
			$data = pdo_fetchall("SELECT * FROM ims_ewei_shop_music WHERE find_in_set(:type,type) AND status=1 AND music_name LIKE :music_name",[':type'=>'1',':music_name'=>"%{$keywords}%"]);
		}
		
		//查出轮播图数据
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if ($_GPC['enabled'] != '') {
			$condition .= ' and enabled=' . intval($_GPC['enabled']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and advname  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		//刻碟音乐
		// $dish = pdo_getall('ewei_shop_music_list',['type'=>'2','openid'=>$openid],['id']);
		$dishSql = "select list.id,music.id as music_id from ims_ewei_shop_music_list list 
		left join ims_ewei_shop_music music on list.music_id = music.id
		where list.openid=:openid and list.type=2 and music.status=1";
		$dish = pdo_fetchall($dishSql,[':openid'=>$openid]);

		$dishid = array_column($dish,'music_id');

		//我喜欢的音乐
		// $like = pdo_getall('ewei_shop_music_list',['type'=>'1','openid'=>$openid],['id']);
		$likeSql = "select list.id,music.id as music_id from ims_ewei_shop_music_list list 
		left join ims_ewei_shop_music music on list.music_id = music.id
		where list.openid=:openid and list.type=1 and music.status=1";

		$like = pdo_fetchall($likeSql,[':openid'=>$openid]);

		$likeid = array_column($like,'music_id');

		//全部音乐 
		$msuicall = pdo_getall('ewei_shop_music',['status'=>'1'],[],'',[],[1,1]);

		if(!empty($msuicall)){
			if(count($msuicall)==1){
				$testmusic = $msuicall[0];
			}else if(count($msuicall)>=2){
				$musickey = mt_rand(0,count($msuicall)-1);
				$testmusic = $msuicall[$musickey];
			}
		}
		
		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_music_adv') . ' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC limit ' . (($pindex - 1) * $psize) . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_music_adv') . ' WHERE 1 ' . $condition, $params);
		$pager = pagination2($total, $pindex, $psize);
		// echo '<pre>';
		// print_r($data);die;
		include $this->template('music/music/index');
		// include $this->template('music/audition/list');
	}

	//试听列表
	public function testList()
	{	
		global $_W;
		global $_GPC;

		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$keywords = $_GPC['keywords'];
		// 查询出试听音乐
		if (empty($keywords)) {
			$data = pdo_fetchall("SELECT * FROM ims_ewei_shop_music WHERE find_in_set(:type,type) AND status=1 ",[':type'=>'1']);
		}else{
			$data = pdo_fetchall("SELECT * FROM ims_ewei_shop_music WHERE find_in_set(:type,type) AND status=1 AND music_name LIKE :music_name",[':type'=>'1',':music_name'=>"%{$keywords}%"]);
		}
		
		//查出轮播图数据
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if ($_GPC['enabled'] != '') {
			$condition .= ' and enabled=' . intval($_GPC['enabled']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and advname  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		//查询出收藏的歌曲
		$like = pdo_getall('ewei_shop_music_list',['uniacid'=>$uniacid,'openid'=>$openid,'type'=>'1'],['music_id']);
		
		$ids = array_column($like,'music_id');

		//刻碟音乐
		$burn = pdo_getall('ewei_shop_music_list',['uniacid'=>$uniacid,'openid'=>$openid,'type'=>'2'],['music_id']);

		$burnid = array_column($burn,'music_id');
		
		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_music_adv') . ' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC limit ' . (($pindex - 1) * $psize) . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_music_adv') . ' WHERE 1 ' . $condition, $params);
		$pager = pagination2($total, $pindex, $psize);

		include $this->template('music/music/audition');
	}

	// 所有音乐 根据分类来显示音乐列表
	public function cateList()
	{
		global $_W;
		global $_GPC;

		$cate = $_GPC['cate'];
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];

		//查询出收藏的歌曲
		$like = pdo_getall('ewei_shop_music_list',['uniacid'=>$uniacid,'openid'=>$openid,'type'=>'1'],['music_id']);
		
		$ids = array_column($like,'music_id');

		//刻碟音乐
		$burn = pdo_getall('ewei_shop_music_list',['uniacid'=>$uniacid,'openid'=>$openid,'type'=>'2'],['music_id']);

		$burnid = array_column($burn,'music_id');

		$type_ids = pdo_getall('ewei_shop_music_list',['openid'=>$openid],['music_id','type']);
		$keys = [];
		foreach ($type_ids as $key => $val) {
			$keys[$val['type']][] = $val['music_id'];
		}
		$cate_list = pdo_getall('ewei_shop_music_cate',['enabled'=>'1']);
		if(empty($cate)){
			$data = pdo_getall('ewei_shop_music',['cate_id'=>$cate_list[0]['id'],'status'=>'1'],[],'',[],[1,10]);

			include $this->template('music/music/allMusic');die;
		}else{
			$arr = array_column($cate_list, 'id');
			in_array($cate,$arr) ? '' : die('访问出错');
			$data = pdo_getall('ewei_shop_music',['cate_id'=>$cate,'status'=>'1']);
			include $this->template('music/music/all-list');die;
		}
	}

	//原创音乐列表
	public function original()
	{	
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$keyword = $_GPC['keyword'];

		//查询出收藏的歌曲
		$like = pdo_getall('ewei_shop_music_list',['uniacid'=>$uniacid,'openid'=>$openid,'type'=>'1'],['music_id']);
		
		$ids = array_column($like,'music_id');

		//刻碟音乐
		$burn = pdo_getall('ewei_shop_music_list',['uniacid'=>$uniacid,'openid'=>$openid,'type'=>'2'],['music_id']);

		$burnid = array_column($burn,'music_id');

		if(!empty($keyword)){
			$data = pdo_fetchall("SELECT * FROM ims_ewei_shop_music WHERE find_in_set(:type,type) AND status=1 AND music_name LIKE :music_name",[':type'=>'2',':music_name'=>"%$keyword%"]);
		}else{
			$data = pdo_fetchall("SELECT * FROM ims_ewei_shop_music WHERE find_in_set(:type,type) AND status=1",[':type'=>'2']);
		}

		include $this->template('music/music/Original');die;
	}
	//添加至列表或移除列表 operate 操作
	public function operate()
	{
		global $_W;
		global $_GPC;
		//获取提交信息
		$data = $_GPC['data'];
		$data['uniacid'] = $_W['uniacid'];
		$data['openid'] = $_W['openid'];
		// 获取操作 状态 移除或者添加
		$status = $_GPC['status'];
		if($status=='add'){
			try{
				$rs = pdo_insert('ewei_shop_music_list',$data);
				if($data['type']=='1' && $rs){//如果是对收藏进行添加操作则收藏数 + 1
					pdo_update('ewei_shop_music',['collection +='=>1],['uniacid'=>$_W['uniacid']]);
				}
			}catch(\Exception $e){
				show_json('1','操作失败');
			}
		}else if($status=='remove'){
			try{
				$rs = pdo_delete('ewei_shop_music_list',$data);
				if($data['type']=='1' && $rs){//如果是对收藏进行取消操作则收藏数 - 1
					pdo_update('ewei_shop_music',['collection -='=>1],['uniacid'=>$_W['uniacid']]);
				}	
			}catch(\Exception $e){
				show_json('1','操作失败');
			}
		}
		show_json('1','已加入');
		
	}

	//显示歌单部分 我喜欢的
	public function sheetLike()
	{	
		// 我喜欢的
		global $_W;
		global $_GPC;
		//标题
		$this->merch_user['merchname'] = "我喜欢的";
		$where['openid'] = $_W['openid'];
		$where['type'] = '1';
		$music_ids = pdo_getall('ewei_shop_music_list',$where,'music_id');
		$music_ids = array_column($music_ids, 'music_id');

		$data = pdo_getall('ewei_shop_music',array('id in'=>$music_ids,'status'=>'1'));

		//刻碟音乐
		$burn = pdo_getall('ewei_shop_music_list',['uniacid'=>$_W['uniacid'],'openid'=>$_W['openid'],'type'=>'2'],['music_id']);

		$burnid = array_column($burn,'music_id');

		//收藏音乐
		$like = pdo_getall('ewei_shop_music_list',['uniacid'=>$_W['uniacid'],'openid'=>$_W['openid'],'type'=>'1'],['music_id']);

		$likeid = array_column($like,'music_id');

		if(!empty($data)){
			if(count($data)==1){
				$testmusic = $data[0];
			}else if(count($data)>=2){
				$musickey = mt_rand(0,count($data)-1);
				$testmusic = $data[$musickey];
			}
		}
		
		include $this->template('music/music/like');die;
	}

	// 我的刻碟
	public function sheetEngraved()
	{
		// 我的刻碟
		global $_W;
		global $_GPC;
		$this->merch_user['merchname'] = '我的刻碟';
		$where['openid'] = $_W['openid'];
		$where['type'] = '2';
		$music_ids = pdo_getall('ewei_shop_music_list',$where,'music_id');
		$music_ids = array_column($music_ids, 'music_id');
		$data = pdo_getall('ewei_shop_music',array('id in'=>$music_ids,'status'=>'1'));

		//获取刻碟容量
		$num = pdo_getcolumn('ewei_shop_music_config',['attr'=>'music_max'],'attr_val');
		if($number>$num){
			die("<script>alert('刻碟歌曲的数量不能大于{$num}首');location.href='".mobileUrl('music/index/sheetEngraved')."'</script>");
		}

		// include $this->template('music/audition/engraved_list');die;
		include $this->template('music/music/cds');die;
	}

	//确认刻碟界面
	public function confirm()
	{
		global $_W;
		global $_GPC;

		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$musics = $_GPC['option'];
		//刻碟歌曲数量
		$number = count($musics);
		//获取刻碟容量
		$num = pdo_getcolumn('ewei_shop_music_config',['attr'=>'music_max'],'attr_val');
		if($number>$num){
			die("<script>alert('刻碟歌曲的数量不能大于{$num}首');location.href='".mobileUrl('music/index/sheetEngraved')."'</script>");
		}
		$data = pdo_getall('ewei_shop_music',array('id in'=>$musics));

		//获取刻碟价格
		$music_price = pdo_getcolumn('ewei_shop_music_config',['attr'=>'music_price'],'attr_val');
		//获取运费
		$freight = pdo_getcolumn('ewei_shop_music_config',['attr'=>'freight'],'attr_val');

		//获取会员等级 判断是是否为会员
		$level = pdo_getcolumn('ewei_shop_member',['openid'=>$openid,'uniacid'=>$uniacid],'level');
		//生成提示信息
		$prompt_msg = '';
		//如果是会员 获取该会员等级的刻碟免费次数
		if($level > 0 || $level != '0'){
			//获取会员折扣信息
			$info = pdo_get('ewei_shop_member_level',$level,['discount','levelname']);
			$discount = $info['discount']> 0 ? $info['discount'] : 1;
			//获取会员免费刻碟次数
			$surplus = pdo_getcolumn('ewei_shop_member',['openid'=>$openid],'surplus');
			if($surplus > 0){
				$prompt_msg = '您是高级VIP，享受本季度免费刻碟';
				$free=true;
			}else{
				$free=false;
				$prompt_msg = '您的会员免费次数已用完,此次刻碟需要付费';
				//刻碟价格乘以会员折扣
				// $music_price = $music_price * ($discount/10);
			}

		}else{
			$free=false;
		}
		//把刻碟金额存入session
		$_SESSION['music_price'] = $music_price + $freight;
		//把刻碟订单号存入session
		$_SESSION['music_orders'] = m('common')->createNO('order', 'ordersn', 'MU');

		$address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where openid=:openid and deleted=0 and isdefault=1  and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		include $this->template('music/audition/confirm');die;
		// include $this->template('music/music/yesCds');die;
	}

	//显示支付页面
	public function showpay()
	{	
		global $_W;
		global $_GPC;
		//获取订单号
		$orders = $_SESSION['music_orders'];
		//获取刻碟金额
		$price = $_SESSION['music_price'];
		include $this->template('music/audition/recharge');die;
	}

	//刻碟支付程序
	public function money()
	{

		global $_W;
		global $_GPC;
		//获取公众号ID
		$data['uniacid'] = $_W['uniacid'];
		//获取用户ID
		$data['openid'] = $_W['openid'];
		//判断歌曲集合是否为空，是则赋值为空数组,不是则不进行操作
		$musics = empty($_GPC['option']) ? [] : $_GPC['option'];
		//将歌曲id拼接成字符串
		$data['music_ids'] = implode($musics,',');

		//生成订单号
		$data['orders'] = m('common')->createNO('order', 'ordersn', 'MU');
		
		//获取订单生成时间
		$data['create_time'] = time();
		//获取订单支付时间 因为是免费刻碟 下单时间即支付时间
		$data['create_time'] = time();

		//获取歌曲数量
		$data['number'] = count($musics);

		//刻碟价格
		// $data['price'] = $_GPC['price'];
		$data['price'] = 0;
		// pdo_insert('ewei_shop_music_record',[''])

		//刻碟状态 0 刻碟中 1 刻碟完成
		$data['schedule'] = '0';

		//支付状态 1已支付
		$data['status'] = '1';

		//支付方式 1免费刻碟 2余额 3微信 4后台支付
		$data['paytypevalue'] = '1';

		//分销上级ID
		$data['agentid'] = pdo_getcolumn('ewei_shop_member',['uniacid'=>$_W['uniacid'],'openid'=>$_W['openid']],'agentid');

		//加入收货人地址ID
		$data['addr_id'] = $_GPC['addrid'];

		//创建刻碟详情插入模板
		$mould = array('orders'=>$data['orders'],'music_id'=>'','number'=>'1','price'=>$data['price']);
		try{
			//插入刻碟记录
			$rs = pdo_insert('ewei_shop_music_record',$data);
			//拼接sql语句
			$SQL = 'insert into ims_ewei_shop_music_details (orders,music_id,number,price) values';
			foreach ($musics as $k => $v) {
				$SQL.="('{$data['orders']}',{$v},1,{$data['price']}),";
			}
			$SQL = trim($SQL,',');
			//执行插入刻碟详情记录
			$res = pdo_query($SQL);
			//将刻碟成功的歌曲从刻碟列表移除
			$del = pdo_delete('ewei_shop_music_list',['uniacid'=>$_W['uniacid'],'openid'=>$_W['openid'],'music_id in'=>$musics,'type'=>'2']);
			if($rs && $res && $del){
				//获取会员免费刻碟次数   如果会员免费刻碟次数大于0  那么该次刻碟则是免费刻碟，减去一次免费刻碟次数
				$surplus = pdo_getcolumn('ewei_shop_member',['openid'=>$_W['openid']],'surplus');
				if($surplus > 0){
					pdo_update('ewei_shop_member',['surplus -='=>1],['openid'=>$_W['openid']]);
				}
				show_json(1,array('url' => mobileUrl('music/index'),'message'=>'刻碟成功'));
			}else{
				show_json(2,array('url' => mobileUrl('music/index'),'message'=>'刻碟失败'));
			}
			
		}catch(\Exception $e){
			show_json(2,array('url' => mobileUrl('music/index'),'message'=>'刻碟失败'));
		}
		
	}

	public function story()
	{
		include $this->template('music/audition/story');
	}
}

?>
