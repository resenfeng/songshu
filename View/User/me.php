<?php
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
    <link rel="icon" href="../images/icon/shongshu.jpg">
    <title>松鼠—个人账号</title>
    <!-- Bootstrap core CSS -->
    <script type="text/javascript" src="../Public/plugins/kindeditor/kindeditor.js"></script>
    <script type="text/javascript" src="../Public/plugins/kindeditor/lang/zh_CN.js"></script>
    <script type="text/javascript" src="../Public/plugins/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript" src="../Public/plugins/My97DatePicker/lang/zh-cn.js"></script>
    <script type="text/javascript" src="../Public/js/jquery-1.6.4.js"></script>
    <link href="../Public/css/bootstrap.css" rel="stylesheet">
    <script>
        KindEditor.ready(function(K) {
            window.editor = K.create('#editor_id');
        });
        $(document).ready(function(){

            $(".selectFileBtn").click(function(){
                //上传文件
                $fileField = $('<input type="file" name="thumbs[]"/>');
                $fileField.hide();
                $(".attachList").append($fileField);
                $fileField.trigger("click");
                $fileField.change(function(){
                    $path = $(this).val();
                    $filename = $path.substring($path.lastIndexOf("\\")+1);
                    //动态添加删除选项
                    $attachItem = $('<div class="attachItem"><div class="left">a.gif</div><div class="right"><a href="#" title="删除附件">删除</a></div></div>');
                    $attachItem.find(".left").html($filename);
                    $(".attachList").append($attachItem);
                });
            });
            $(".attachList>.attachItem").find('a').live('click',function(obj,i){
                $(this).parents('.attachItem').prev('input').remove();
                $(this).parents('.attachItem').remove();
            });
        });
    </script>
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
            <a href="../index.php"><img class="img-circle" src="../images/icon/shongshu.jpg" style="height: 50px;float: left;"></a>
                    <a class="navbar-brand" href="../index.php">&nbsp松鼠</a>
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
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </li>
                    </ul>
                </div>
                <button type="submit" class="btn btn-default">搜索</button>
            </form>
            <a class="navbar-brand" href="">高级搜索</a>
            <div class="nav navbar-nav navbar-right">
                <button type="button" class="btn btn-default navbar-btn btn-warning" data-toggle="modal" data-target="#login" data-whatever="@mdo">登录
                </button>
                <button type="button" class="btn btn-default navbar-btn btn-warning" data-toggle="modal" data-target="#register" data-whatever="@mdo">注册
                </button>
                <li class="dropdown" style="width: 110px; display: none;">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">你好！he <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="me.html">个人账户管理</a></li>
                        <li><a href="">购书车</a></li>
                        <li><a href="">收藏</a></li>
                        <li role="separator" class="divider"></li>
                        <!--                             <li class="dropdown-header">Nav header</li>
                        <li><a href="">Separated link</a></li> -->
                        <li><a href="">退出</a></li>
                    </ul>
                </li>
            </div>
        </div>
        <!--/.nav-collapse -->
    </div>

</nav>
<div class="container" style="position: relative;top:50px; width: 1170px;">
    <!-- 账户管理/购书车/收藏 -->
    <div class="123" style=" height: 1000px; ">
        <!-- 选择 -->
        <div class="pinned text-center " style=";width: 260px;height:400px;position: absolute;left: 0px;top:10px;" role="tablist">
            <div style="height: 60px;"></div>
            <div style="height: 175px;">
                <img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="150" height="150">
            </div>
            <div role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">账号管理</a></div>
            <hr>
            <div role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">我的图书</a></div>
            <hr>
            <div role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">售后</a></div>
            <hr>
        </div>
        <!-- 选择 end-->
        <!-- 主界面 -->
        <div class="tab-content" style="width: 860px; position: absolute;top:10px;right: 0px;">
            <!-- 账户管理主界面 -->
            <div role="tabpanel" class="tab-pane active" id="home">
                <div style="width: 840px;position: absolute;left: 0px;">

                    <div style="width: 800px;height:200px;">
                        <div style="width: 360px;height: 200px;position: absolute;left: 40px;margin-top:50px;">
                            <h3>HE</h3>
                            <h4><a>修改个人信息</a></h4>
                        </div>
                        <div style="width: 360px;height: 200px;position: absolute;left: 400px;top: 0px;margin-top:50px;">
                            <h4>账户安全：高</h4>
                            <h4>绑定邮箱：</h4>
                            <h4>绑定手机：</h4>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <!-- 账户管理主界面 end-->
            <!-- 购书车主界面 -->
            <div role="tabpanel" class="tab-pane" id="profile">
                <div style="height: 50px;"></div>
                <div style="width: 800px;height:200px;">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs text-center" role="tablist">
                        <li role="presentation" class="active"><a href="#my_book" aria-controls="home" role="tab" data-toggle="tab">我的书库</a></li>
                        <li role="presentation"><a href="#add_book" aria-controls="profile" role="tab" data-toggle="tab">添加图书</a></li>
                        <li role="presentation"><a href="#re_book" aria-controls="profile" role="tab" data-toggle="tab">修改图书</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="my_book">
                            <div style="height: 20px;"></div>
                            <div class="panel panel-default" style="height: 250px;">
                                <div style="height: 20px;"></div>
                                <div style="width: 20px;height: 200px;float: left;"></div>
                                <div style="float: left;">
                                    <img src="./images/s-l20.webp" alt="Generic placeholder image" width="150" height="200">
                                </div>
                                <div style="width: 30px;height:200px;float: left;"></div>
                                <div style=" float:left;">
                                    <h3>小王子</h3>
                                    <a>查看详情</a>
                                    <p>1231232123123</p>
                                </div>
                            </div>
                            <div class="panel panel-default" style="height: 250px;">
                                <div style="height: 20px;"></div>
                                <div style="width: 20px;height: 200px;float: left;"></div>
                                <div style="float: left;">
                                    <img src="./images/s-l20.webp" alt="Generic placeholder image" width="200" height="200">
                                </div>
                                <div style="width: 30px;height:200px;float: left;"></div>
                                <div style=" float:left;">
                                    <h3>小王子</h3>
                                    <a>查看详情</a>
                                    <p>1231232123123</p>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="add_book">
                            <!-- 提交表单的页面 -->
                            <form action="doUserOperation.php?operation=addBook" method="post" enctype="multipart/form-data" >

                                <table width="70%"  border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
                                    <tr>
                                        <td style="text-align: center" colspan="2"><b>添加图书</b></td>
                                    </tr>
                                    <tr>
                                        <td><span>图书名称:</span></td>
                                        <td>
                                            <input name="pName" type="text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>选择分类</td><td >
                                            <select name="categoryId">
                                                <!-- 分类数据 -->
                                                <?php foreach($rows as $row):?>
                                                    <option value="<?php echo $row['categoryId'];?>"><?php echo $row['categoryName'];?></option>
                                                <?php endforeach;?>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td><span>图书估价：</span></td><td>
                                            <input name="bookPrice" type="number" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span>图书数量:</span></td><td>
                                            <input name="bookNum" type="number" />
                                        </td>
                                    </tr>
                                    <tr><td>图书图片：</td>
                                        <!-- 防止页面跳转 -->
                                        <td><a href="javascript:void(0)" class="selectFileBtn">添加附件</a>
                                            <div class="attachList" class="clear"></div>
                                        </td></tr>
                                    <tr>
                                        <td><span>图书描述:</span></td>
                                        <td >
                                            <textarea id="editor_id" name="bookDes" style="width:100%;height:300px"></textarea>
                                        </td>
                                    </tr>
                                    <td style="text-align: center" colspan="2">
                                        <button type="submit" class="add"  style="font-size:large" >添加</button>
                                    </td>
                                </table>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="re_book">修改</div>
                    </div>
                </div>

            </div>
            <!-- 购书车主界面 end-->
            <!-- 收藏主界面 -->
            <div role="tabpanel" class="tab-pane" id="messages">789</div>
            <!-- 收藏主界面 end-->
        </div>
        <!-- 主界面 end-->
    </div>
    <!-- end--账户管理/购书车/收藏 -->
    <footer class="min-footer text-center" style=" float:bottom;">
        <hr>
        <p></p>
        <p>© Company 2014</p>
    </footer>
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
                            <img src="../BookShop/lib/getVerifyImage.php" alt="" />
                            <!--<img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=="-->
                            <!--alt="Generic placeholder image" width="250" height="30">-->
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
<script src=""></script>
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