<?php
/**
 * Created by PhpStorm.
 * User: 冯森
 * Date: 2016/3/23
 * Time: 21:12
 */
//header("content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
session_start();
define("ROOT",dirname(__FILE__));
set_include_path(".".PATH_SEPARATOR.ROOT."/lib".PATH_SEPARATOR.ROOT."/user".PATH_SEPARATOR.ROOT."/config".PATH_SEPARATOR.get_include_path());
require_once './lib/mysql.php';
//require_once 'verifyImage.php';
require_once './lib/getData.php';
require_once './lib/common.php';
require_once './lib/checkLogin.php';
require_once './lib/connectMysql.php';

connect();