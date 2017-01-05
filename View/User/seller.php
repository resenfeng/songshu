<?php
session_start();
require_once '../include.php';
$rows=getAllCate();
if(!$rows){
    alertMes("没有相应分类，请先添加分类!!", "addCate.php");
}

?>

<!DOCTYPE html>
<!-- saved from url=(0042)http://v3.bootcss.com/examples/offcanvas/# -->
<html lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="http://v3.bootcss.com/favicon.ico">
        <title>松鼠网—个人账号</title>
        <!-- Bootstrap core CSS -->
        <link href="../Public/css/bootstrap.css" rel="stylesheet">
    </head>
    <body youdao="bind">
        <!-- Static navbar -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container" style="width: 1200px">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="">松鼠</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <ul class="nav navbar-nav">
                                <li>
                                    <input type="text" style="width: 500px;" class="form-control" placeholder="搜索">
                                </li>
                                <li class="dropdown">
                                    <select class="form-control" style="width: 150px;">
                                        <option>全部分类</option>
                                        <?php foreach($rows as $row):?>
                                            <option value="<?php echo $row['categoryId'];?>"><?php echo $row['categoryName'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </li>
                            </ul>
                        </div>
                        <button type="submit" class="btn btn-default">搜索</button>
                    </form>
                    <a class="navbar-brand" href="">高级搜索</a>
                    <div class="nav navbar-nav navbar-right">
                        <button type="button" class="btn btn-default navbar-btn btn-primary" data-toggle="modal" data-target="#login" data-whatever="@mdo">登录
                        </button>
                        <button type="button" class="btn btn-default navbar-btn btn-primary" data-toggle="modal" data-target="#register" data-whatever="@mdo">注册
                        </button>
                        <li class="dropdown" style="width: 110px; display: none;">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">你好！he <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="./mybook.php">个人账户管理</a></li>
                                <li><a href="" onclick="login_show()">退出</a></li>
                            </ul>
                        </li>
                    </div>
                </div>
                <!--/.nav-collapse -->
            </div>
        </nav>
        <div class="container" style="position: relative;top:50px; width: 1170px;">
            <!-- 账户管理/购书车/收藏 -->
            <div class="123 row" style=" height: 1000px; ">
                <!-- 选择 -->
                <div class="pinned " style=";width: 260px;height:400px;position: absolute;left: 0px;top:10px;" role="tablist">
                    <div style="height: 60px;"></div>
                    <div class="text-center" style="height: 175px;">
                        <img class="img-circle" src="" alt="Generic placeholder image" width="150" height="150">
                    </div>
                    <div class="text-center">
                    <h3>姓名：123</h3></div>
                    <hr>
                    <div >
                    <h4>邮箱：123@songshu.com</h4></div>
                    <hr>
                    <div >
                    <h4>电话：123111111</h4></div>
                    <hr>
                    <div>
                    <h4>简介：</h4></div>
                </div>
                <!-- 选择 end-->
                <!-- 主界面 -->
                <div class="tab-content" style="width: 860px; position: absolute;top:10px;right: 0px;">
                    <!-- 账户管理主界面 -->
                    <div style="height: 20px;"></div>
                    <table width="860" height=250px >
                        <tr height="250" style="background-color:#EEEEEE; ">
                            <td  class="text-center" width="250">
                                <img src="../images/s-l20.webp" alt="Generic placeholder image" width="200" height="200">
                            </td>
                            <td width="610" >
                                <h3>小王子</h3>
                                <div style="word-wrap:break-word; width: 500px;height:120px;">
                                    <p style="valign:top;">简介：11111111111111111</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- 主界面 end-->
            </div>
            <!-- end--账户管理/购书车/收藏 -->
        </div>
        <!-- 模态框 -->
        <!-- login -->
        <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="loginModalLabel">登录</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" entype="multipart/form-data" action="../user/doUserOperation.php?operation=login">
                            <div class="form-group">
                                <label class="control-label">用户名:</label>
                                <input type="text" class="form-control" name="username">
                            </div>
                            <div class="form-group">
                                <label class="control-label">密码:</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="form-group">
                                <label class="control-label">验证码:</label>
                                <div>
                                    <input type="text" style=" width:280px; height:34px;" name="verify">
                                    <img src="../lib/verifyImage.php" alt="" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-primary">确定</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- login_end -->
        <!-- register -->
        <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">注册</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" entype="multipart/form-data" action="../user/doUserOperation.php?operation=regist">
                            <div class="form-group">
                                <label class="control-label">用户名:</label>
                                <input type="text" class="form-control" name="username">
                            </div>
                            <div class="form-group">
                                <label class="control-label">邮箱:</label>
                                <input type="text" class="form-control" name="email">
                            </div>
                            <div class="form-group">
                                <label class="control-label">密码:</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="form-group">
                                <label class="control-label">确认密码:</label>
                                <input type="password" class="form-control" name="password1">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-primary">确定</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- register_end -->
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Include jQuery and jquery.pin -->
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="../Public/js/jquery.pin.js"></script>
        <!-- PIN ALL THE THINGS! -->
        <script>
        $(".pinned").pin({
        containerSelector: ".123"
        });
        </script>
        <!-- That's all - pretty easy, right? -->
        <script type="text/javascript">
        $(function() {
        $('.navbar-right .btn-primary,.navbar-right .dropdown-toggle').click(function() {
        $('.navbar-right .btn-primary,.navbar-right .dropdown-toggle').toggle();
        })
        })
        </script>
        <script src="../Public/js/jquery.min.js"></script>
        <script src="../Public/js/bootstrap.min.js"></script>
    </body>
</html>