<?php
/**
 * Created by PhpStorm.
 * User: 冯森
 * Date: 2016/3/24
 * Time: 8:05
 */
require_once '../include.php';

function regist()
{
    $arr = $_POST;
    if ($arr['password'] === $arr['password1']) {
        $arr = array_slice($arr, 0, 3);
        if ($arr["username"] != null && $arr["password"] != null && $arr["email"] != null) {
            if (insert("user", $arr)) {
                //$mes = "注册成功!<br/>1秒钟后跳转到登陆页面!<meta http-equiv='refresh' content='1;url=../index.html'/>";
                alertMes("注册成功", "../index.php");
            } else {
                $mes = "注册失败!<br/><a href='../index.php'>重新注册</a>|<a href='../index.php'>查看首页</a>";
            }
        } else {
            $mes = "注册失败!<br/><a href='../index.php'>重新注册</a>|<a href='../index.php'>查看首页</a>";
        }
    } else {
        $mes = "两次输入的密码不匹配，请重新输入!<br/>2秒钟后跳转到登陆页面!<meta http-equiv='refresh' content='2;url=../index.php'/>";
    }
    return $mes;
}

function login()
{
    session_start();
    $username = $_POST['username'];
    //addslashes():使用反斜线引用特殊字符
    //$username=addslashes($username);
//    $sqllog="update user set isLogin=1 where userName=$username";
//    mysql_query("$sqllog");
    $username = mysql_escape_string($username);
    $password = $_POST['password'];
    $sql = "select * from user where userName='{$username}' and password='{$password}'";
    $row = fetchOne($sql);
    if ($row) {
        $_SESSION['loginFlag'] = $row['id'];
        $_SESSION['userName'] = $row['userName'];
        setcookie("userName",$row['username'],time()+7*24*3600);
        $mes = "登陆成功！";
    } else {
        $mes = "登陆失败！重新登陆";
    }
    return $mes;
}

function logout()
{
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), "", time() - 1);
    }
    session_destroy();
    header("location:../index.php");
}

/**
 *
 * 添加商品
 * @return string
 */
function addBook()
{
    $arr = $_POST;
//    $path = "../images/uploadImages";//上传文件的存储了路径
//    $uploadFiles = uploadFile($path);
//    if (is_array($uploadFiles) && $uploadFiles) {
//        foreach ($uploadFiles as $key => $uploadFile) {
//            thumb($path . "/" . $uploadFile['name'], "../images/image50/" . $uploadFile['name'], 50, 50);
//            thumb($path . "/" . $uploadFile['name'], "../images/image220/" . $uploadFile['name'], 220, 220);
//            thumb($path . "/" . $uploadFile['name'], "../images/image350/" . $uploadFile['name'], 350, 350);
//            thumb($path . "/" . $uploadFile['name'], "../images/image800/" . $uploadFile['name'], 800, 800);
//        }
//    }
    $res = insert("book", $arr);
//    $pid = getInsertId();
//    if ($res && $pid) {
//        foreach ($uploadFiles as $uploadFile) {
//            $arr1['pid'] = $pid;
//            $arr1['albumPath'] = $uploadFile['name'];
////            addAlbum($arr1);
//            insert("album", $arr);
//
//        }
//        $mes = "添加成功！";
//    } else {
//        foreach ($uploadFiles as $uploadFile) {
//            if (file_exists("../images/image800/" . $uploadFile['name'])) {
//                unlink("../images/image800/" . $uploadFile['name']);
//            }
//            if (file_exists("../images/image50/" . $uploadFile['name'])) {
//                unlink("../images/image50/" . $uploadFile['name']);
//            }
//            if (file_exists("../images/image220/" . $uploadFile['name'])) {
//                unlink("../images/image220/" . $uploadFile['name']);
//            }
//            if (file_exists("../images/image350/" . $uploadFile['name'])) {
//                unlink("../images/image350/" . $uploadFile['name']);
//            }
//        }
//        $mes = "添加失败！请重新添加！";
//    }
    if ($res != null) {
        $mes = "添加成功";
    } else {
        $mes = "添加失败";
    }
    return $mes;
}

/**
 *编辑商品
 * @param int $id
 * @return string
 */
function editBook($id)
{
    $arr = $_POST;
    $path = "./uploads";
    $uploadFiles = uploadFile($path);
    if (is_array($uploadFiles) && $uploadFiles) {
        foreach ($uploadFiles as $key => $uploadFile) {
            thumb($path . "/" . $uploadFile['name'], "../images/image50/" . $uploadFile['name'], 50, 50);
            thumb($path . "/" . $uploadFile['name'], "../images/image220/" . $uploadFile['name'], 220, 220);
            thumb($path . "/" . $uploadFile['name'], "../images/image350/" . $uploadFile['name'], 350, 350);
            thumb($path . "/" . $uploadFile['name'], "../images/image800/" . $uploadFile['name'], 800, 800);
        }
    }
    $where = "id={$id}";
    $res = update("product", $arr, $where);
    $pid = $id;
    if ($res && $pid) {
        if ($uploadFiles && is_array($uploadFiles)) {
            foreach ($uploadFiles as $uploadFile) {
                $arr1['pid'] = $pid;
                $arr1['albumPath'] = $uploadFile['name'];
                addAlbum($arr1);
            }
        }
        $mes = "<p>编辑成功!</p><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
    } else {
        if (is_array($uploadFiles) && $uploadFiles) {
            foreach ($uploadFiles as $uploadFile) {
                if (file_exists("../images/image800/" . $uploadFile['name'])) {
                    unlink("../images/image800/" . $uploadFile['name']);
                }
                if (file_exists("../images/image50/" . $uploadFile['name'])) {
                    unlink("../images/image50/" . $uploadFile['name']);
                }
                if (file_exists("../images/image220/" . $uploadFile['name'])) {
                    unlink("../images/image220/" . $uploadFile['name']);
                }
                if (file_exists("../images/image350/" . $uploadFile['name'])) {
                    unlink("../images/image350/" . $uploadFile['name']);
                }
            }
        }
        $mes = "<p>编辑失败!</p><a href='listPro.php' target='mainFrame'>重新编辑</a>";

    }
    return $mes;
}

/**
 * 删除商品
 * @param $id
 * @return string
 */
function delBook($id)
{
    $where = "id=$id";
    $res = delete("product", $where);
    $proImgs = getAllImgByProId($id);
    if ($proImgs && is_array($proImgs)) {
        foreach ($proImgs as $proImg) {
            if (file_exists("../images/uploadImages/" . $proImg['albumPath'])) {
                unlink("../images/uploadImages/" . $proImg['albumPath']);
            }
            if (file_exists("../images/image50/" . $proImg['albumPath'])) {
                unlink("../images/image50/" . $proImg['albumPath']);
            }
            if (file_exists("../images/image220/" . $proImg['albumPath'])) {
                unlink("../images/image220/" . $proImg['albumPath']);
            }
            if (file_exists("../images/image350/" . $proImg['albumPath'])) {
                unlink("../images/image350/" . $proImg['albumPath']);
            }
            if (file_exists("../images/image800/" . $proImg['albumPath'])) {
                unlink("../images/image800/" . $proImg['albumPath']);
            }
        }
    }
    $where1 = "pid={$id}";
    $res1 = delete("album", $where1);
    if ($res && $res1) {
        $mes = "删除成功!<br/><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
    } else {
        $mes = "删除失败!<br/><a href='listPro.php' target='mainFrame'>重新删除</a>";
    }
    return $mes;
}

function editInfo()
{
    $arr = $_POST;
    $username = $_POST['userName'];
    $where = "userName=" . $username;
    if (update("user", $arr, $where)) {
        $mes = "编辑成功!<br/><a href='mybook.php'>查看管理员列表</a>";
    } else {
        $mes = "编辑失败!<br/><a href='mybook.php'>请重新修改</a>";
    }
    session_destroy();
    return $mes;
}

function editPassword()
{
    //
}