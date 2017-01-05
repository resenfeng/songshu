<?php
require_once './include.php';
//session_start();
//$change=$_SESSION['userName'];
$change=checkLogined();
$order = $_REQUEST['order'] ? $_REQUEST['order'] : null;
$orderBy = $order ? "order by p." . $order : null;
$keywords = $_REQUEST['keywords'] ? $_REQUEST['keywords'] : null;
$where = $keywords ? "where p.pName like '%{$keywords}%'" : null;
//得到数据库中所有商品
$sql = "select p.bookId,p.bookName,p.bookPrice,p.bookDes,p.isExchanged,p.isWanted,p.sellerName,c.categoryId from book as p join category c on p.categoryId=c.categoryId {$where}  ";
$totalRows = getResultNum($sql);
$pageSize = 6;
$totalPage = ceil($totalRows / $pageSize);
$page = $_REQUEST['page'] ? (int)$_REQUEST['page'] : 1;
if ($page < 1 || $page == null || !is_numeric($page)) $page = 1;
if ($page > $totalPage) $page = $totalPage;
$offset = ($page - 1) * $pageSize;
$sql = "select p.bookId,p.bookName,p.bookPrice,p.bookDes,p.isExchanged,p.isWanted,p.sellerName,c.categoryId from book as p join category c on p.categoryId=c.categoryId {$where} {$orderBy} limit {$offset},{$pageSize}";
$rows = fetchAll($sql);

$rows1=getAllCate();
if(!$rows1){
    alertMes("没有相应分类，请先添加分类!!", "addCate.php");
}
//获取图书图片

//判断是否有新消息
$sql = "select id from message where sender='{$sellerName}' and geter='{$_SESSION['userName']}' and mloop=0;";
$res = mysql_query($sql,connect());
echo "<td><li title='".$sellerName."'>".$sellerName."点击此处开始聊天对话";
if(mysql_num_rows($res)>0){
    echo "<span style='color:red'>(有新消息)</span></li></td>";

}else{
    echo "</li></td>";
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
    <link rel="icon" href="./images/icon/shongshu.jpg">
    <title>松鼠-分类</title>
    <!-- Bootstrap core CSS -->
    <link href="Public/css/bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="Public/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="Public/js/common.js"></script>
    <script src="Public/js/songshu.js.php"></script>
    <script type="text/javascript">
        $(function(){
            $("#chat h3").hover(
                function() {
                    $(this).css("color","blue").css("cursor","pointer");
                    $(this).siblings().css("color","#000")
                }
                ,function(){
                    $(this).css("color","#000")
                }
            ).click(
                function(){
                    window.open("chat.php?geter="+$(this).attr("title"),"交流对话","width=600,height=600");
                }
            );
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
            <a href="./index.php"><img class="img-circle" src="./images/icon/shongshu.jpg" style="height: 50px;float: left;"></a>
            <a class="navbar-brand" href="./index.php">&nbsp松鼠</a>
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
                                <?php foreach($rows1 as $row):?>
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
                        <li><a href="./user/me.php">个人账户管理</a></li>
                        <li><a href="">购书车</a></li>
                        <li><a href="">收藏</a></li>
                        <li role="separator" class="divider"></li>
                        <!--                             <li class="dropdown-header">Nav header</li>
                        <li><a href="">Separated link</a></li> -->
                        <li><a href="">退出</a></li>
                    </ul>
                </li>
            </div>
            <script>
                function change() {
                    var username = "<?php echo $change;?>";
                    if (username == "") {
                        alert("ugtsigheuigslighes");
                    }else{
//                        alert(username);
                        document.getElementById("register1").style.display = "none";
                        document.getElementById("login1").style.display = "none";
                        document.getElementById("account1").style.display = "block";
                    }
                }
                change();
            </script>
        </div>
        <!--/.nav-collapse -->
    </div>

</nav>
<div class="container marketing" style="width: 1200px;">
    <div style="height: 50px;"></div>
    <div class="row" style="height: 50px;width: 1200px;">
        <ul class="nav nav-tabs" style="">
            <?php foreach($rows1 as $row):?>
                <li role="presentation"><a href="./classify.php" ><?php echo $row['categoryName'];?></a></li>
            <?php endforeach;?>
        </ul>
    </div>

    <div class="row">
        <div style="height:500px;">
            <div class="panel panel-default" style="height: 250px;">
                <table width="1200" height=250px >
                    <?php foreach ($rows as $row): ?>
                        <?php
                        $bookpic=getAllImgByProId($row["bookId"]);
                        ?>

                        <tr height="50" style="background-color:#EEEEEE; ">
                            <td rowspan="3" class="text-center" width="240">
                                <img src="./images/book/<?php echo $bookpic['albumPath'];?>" alt="Generic placeholder image" width="150" height="200">
                            </td>
                            <td width="600" style="border-right:1px solid #aaa;">
                                <h1>《<?php echo $row[bookName];?>》</h1>
                            </td>
                            <td rowspan="2" width="180" class="text-center">
                                <img class="img-circle" src="./images/s-l20.webp" alt="Generic placeholder image" width="150" height="150">
                            </td>
                            <td id="chat" width="190">
                                <h3 title='<?php echo $row[sellerName];?>'>拥有者：<?php echo $row[sellerName];?></h3>
                            </td>
                        </tr>
                        <tr style="background-color:#EEEEEE; ">
                            <td rowspan="2" width="600" style="border-right:1px solid #aaa;">
                                <div style="word-wrap:break-word; width: 580px;height:130px;">
                                    <p style="valign:top;">简述：<?php echo $row[bookDes];?></p>
                                </div>
                            </td>
                            <td width="190">
                                <div style="word-wrap:break-word; width: 180px;height:100px;">
                                    <a href=""></a>
                                </div>
                            </td>
                        </tr>
                        <tr height="70" style="background-color:#EEEEEE; ">
                            <td colspan="2" class="text-center">
                                <h3><a href="./user/seller.php">查看书库</a></h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($totalRows > $pageSize): ?>
                        <tr>
                            <td align="center" colspan="8"><?php echo showPage($page, $totalPage, "keywords={$keywords}&order={$order}"); ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
    <!--/.container-->
    <!-- login -->
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="loginModalLabel">登录</h4>
                </div>
                <div class="modal-body">
                    <form name="login" method="post" entype="multipart/form-data" action="./user/doUserOperation.php?operation=login">
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
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-primary" >确定</button>
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
                    <form method="post" entype="multipart/form-data" action="./user/doUserOperation.php?operation=regist">
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
    <script type="text/javascript">
        $(function() {
            $('.navbar-right .btn-primary,.navbar-right .dropdown-toggle').click(function() {
                $('.navbar-right .btn-primary,.navbar-right .dropdown-toggle').toggle();
            })
        })
    </script>
    <script src="Public/js/jquery.min.js"></script>
    <script src="Public/js/bootstrap.min.js"></script>
</body>

</html>
