<?php
session_start();
require_once './include.php';
$geter= $_GET['geter'];
//$username = $_SESSION['userName'];
$username="qqq";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="Public/css/chat.css" type="text/css" rel="stylesheet" />
    <title>聊天对话</title>
    <script type="text/javascript" src="Public/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript">

        //定义全局变量 http_request
        var http_request;

        //**********************发送消息******************
        $(function(){
            $("#sendmess").click(sendMessage);
        });

        function sendMessage(){
            var http_request = createAjaxObject();
            if(http_request){
                var url = "./user/sendMes.php";
                var sender = "<?php echo $username; ?>";
                var geter = "<?php echo $geter; ?>";
                var content = $("#sendBox").val();
                var data = "content="+content+"&sender="+sender+"&geter="+geter;
                //alert(data);
                http_request.open("post",url,true);
                http_request.setRequestHeader("content-type","application/x-www-form-urlencoded");
                http_request.onreadystatechange = function(){
                    if(http_request.readyState==4){
                        //等于200表示成功
                        if(http_request.status==200){
                            var res = http_request.responseText;
                            if(res!=""){
                                //res==""说明发送成功，然后就将发送信息写入messageBox
                                //var nowtime = new Date().toLocaleString();
                                var content1 = "<?php echo $username.' '; ?>"+res+"\r\n";
                                var content2 = content+"\r\n" ;
                                var contents = $("#messageBox").val()+content1+content2;
                                //alert(content);
                                $("#messageBox").val(contents);
                                $("#sendBox").val("");  //将发送框清除
                            }
                        }
                    }
                }
                http_request.send(data);
            }
        }

        //**********************接收消息**************
        setInterval(getMessage,1000); //每1秒发送一次请求
        function getMessage(){
            var http_request = createAjaxObject();
            if(http_request){
                var url = "./user/getMes.php";
                var sender = "<?php echo $username; ?>";
                var geter = "<?php echo $geter; ?>";
                var data = "sender="+sender+"&geter="+geter;
                //alert(data);
                http_request.open("post",url,true);
                http_request.setRequestHeader("content-type","application/x-www-form-urlencoded");
                http_request.onreadystatechange = function(){
                    if(http_request.readyState==4){
                        //等于200表示成功
                        if(http_request.status==200){
                            if(http_request.responseText=="nomessage"){return;}
                            var res = eval("("+http_request.responseText+")");
                            for(var i=0;i<res.length;i++){
                                var content1 = "<?php echo $geter; ?> "+res[i].stime+"\r\n";
                                var content2 = res[i].content+"\r\n" ;
                                var contents = $("#messageBox").val()+content1+content2;
                                //alert(content);
                                $("#messageBox").val(contents);
                            }
                        }
                    }
                }
                http_request.send(data);
            }
        }

        //创建ajax引擎对象
        function createAjaxObject(){
            if(window.ActiveXObject){
                var newRequest = new ActiveXObject("Microsoft.XMLHTTP");
            }else{
                var newRequest = new XMLHttpRequest();
            }
            return newRequest;
        }
    </script>
</head>

<body>
<div id="message">
    <hr />
    <p>与<?php echo $geter; ?>聊天中</p>
    <hr />
    <textarea readonly="readonly" id="messageBox"></textarea>
</div>
<div id="message2">
    <textarea name="content" id="sendBox"></textarea>
    <p><input type="button" value="发送" id="sendmess" /></p>
</div>
</body>
</html>
