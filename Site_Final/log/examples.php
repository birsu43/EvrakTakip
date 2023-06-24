<?php
require_once 'user_info.php';


$userinfo = new UserInfo();

$ip = $userinfo->get_ip();

$get_os = $userinfo->get_os();

$get_browser = $userinfo->get_browser();

$get_device = $userinfo->get_device();

var_dump($ip,$get_os,$get_browser,$get_device);