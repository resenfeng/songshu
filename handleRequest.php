<?php
/**
 * 获取用户的操作
 */
require './Controller/userController.php';

$data = $_POST;
$user = new userController();

switch ($data['operation']){
    case "login":
        echo $user->login($data);
        break;
    case "register":
        echo $user->register($data);
        break;
    default:
        break;
}