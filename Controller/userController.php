<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 16-12-23
 * Time: 下午11:37
 */
require "./Model/userModel.php";
require "./Library/toJson.php";
class userController
{
    public function login($data)
    {
        session_start();
        $userName = $data['userName'];
        $password = $data['userPwd'];
        $verifyCode = $data['verifyCode'];

        if ($verifyCode == $_SESSION['verifyCode']){
            $field = array('user_name', 'user_password');
            $table = array('table' => 'userInfo');
            $condition = array('user_name' => $userName);

            $query = new userModel();
            $res = $query->getUser($field, $table, $condition);
            if ($res['user_password'] == md5($password)) {
                $_SESSION['userName'] = $res['user_name'];
                setcookie("userName",$res['user_name'],time()+7*24*3600);
                $code = 101;
                $mes = "登陆成功！";
            } else {
                $code = 100;
                $mes = "登陆失败！重新登陆";
            }
            return toJson($code, $mes, "");
        }else{
            return toJson(100, "验证码错误，请重新输入！", "");
        }
    }

    public function register($data){
        $getCount = new userModel();
        $count = $getCount->getUser(array("count(user_id)"), array("table" => "user"), array());

        $userFields = array(
            "user_id" => $count['count(user_id)'],
            "user_type_id" => 4,
            "user_info_id" => $count['count(user_id)']
        );
        $userTable = "user";

        $userInfoFields = array(
            "user_info_id" => $count['count(user_id)'],
            "user_name" => $data['username'],
            "user_password" => md5($data['password'])
        );
        $userInfoTable = "userInfo";

        $uModel = new userModel();
        if ($uModel->addUser($userFields, $userTable) && $uModel->addUser($userInfoFields, $userInfoTable))
            return toJson(201, "注册成功", "");
        else
            return toJson(200, "注册失败", "");
    }
}