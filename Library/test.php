<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 16-12-23
 * Time: 下午9:52
 */
require "sqlOperation.php";

//$f = array("category.categoryId", "category.categoryName", "category.bookId", "book.bookName", "book.bookNum");
//$t = array(
//    "table1" => "category",
//    "table2" => "book",
//    "multiply" => "category.bookId=book.bookId"
//);
//$c = array(
//    "category.categoryId" => 1
//);

//$f = array("categoryId", "categoryName");
//$t = array(
//    "table" => "category"
//);
//$c = array(
//    "categoryId" => 1
//);
//
//$f = array("category.categoryId", "category.categoryName", "category.bookId", "book.bookName", "book.bookNum");
//$t = array(
//    "table1" => "category",
//    "table2" => "book",
//    "table3" => "admin",
//    "multiply1" => "category.bookId=book.bookId",
//    "multiply2" => "ww.bookId=qq.bookId"
//);
//$c = array(
//    "category.categoryId" => 1
//);

$f = array(
    "user.user_id" => 3,
    "user.user_info_id" => 3,
    "user.user_type_id" => 3,
    "userInfo.user_name" => "yangbai",
    "userInfo.user_password" => "yangbai"
);
$t = array(
    "table1" => "user",
    "table2" => "userInfo"
//    "multiply1" => "user.user_info_id=userInfo.user_info_id"
);
$c = array();
$test = new sqlOperation($f, $t, $c);
//print_r($test->insert());
$test->insert();
