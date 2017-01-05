<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 16-12-23
 * Time: 下午9:37
 */
/**
 * 连接数据库
 * @return resource
 */
define("DB_HOST","180.153.51.180:13003");
define("DB_USER","yyz");
define("DB_PWD","njyyzr312mysql");
define("DB_DBNAME","bookshop");
define("DB_CHARSET","utf8");
function connect()
{
    $link = mysql_connect(DB_HOST, DB_USER, DB_PWD) or die("数据库连接失败Error:".mysql_errno().":".mysql_error());
    mysql_set_charset(DB_CHARSET);
    mysql_select_db(DB_DBNAME) or die("指定数据库打开失败");
    return $link;
}