<?php
session_start();
function rcon_query($command) {
	include_once 'rcon.php';
	$rcon_config = array(
		'ip' => 'balabala',
		'port' => 12450,
		'password' => '',
	);
	$host = $rcon_config['ip'];
	$port = $rcon_config['port'];
	$password = $rcon_config['password'];
	$timeout = 3;
	$rcon = new Rcon($host, $port, $password, $timeout);
	if ($rcon->connect()) {
		$rcon->send_command($command);
		return preg_replace("/§./", "", $rcon->get_response());
	}
}
if (empty($_SESSION['username'])) {
	die(json_encode(array('status' => 403, 'message' => '未登录'))); //判断网页登陆状态
}
Main::rcon_query("whitelist add " . $_SESSION['username']); //临时授权玩家白名单权限
sleep(20); //延迟20秒
Main::rcon_query("whitelist remove " . $_SESSION['username']); //取消授权玩家白名单权限
echo json_encode(array('status' => 200, 'message' => 'success'));