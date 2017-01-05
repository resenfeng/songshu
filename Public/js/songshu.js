function login_hide() {
    var code = $(".verifyCode");
    var userId = $(".userName");//用户名
    var password = $(".userPwd");

    var msg = "";
    // alert(userId.val());
    if ($.trim(userId.val()) == ""){
        msg = "用户名不能为空！";
        userId.focus();
    }else if (!/^\w{5,20}$/.test($.trim(userId.val()))){
        msg = "用户名格式不正确！";
        userId.focus();
    }else if ($.trim(password.val()) == ""){
        msg = "密码不能为空！";
        password.focus();
    }else if (!/^\w{6,20}$/.test($.trim(password.val()))){
        msg = "密码格式不正确！";
        password.focus();
    }else if ($.trim(code.val()) == ""){
        msg = "验证码不能为空！";
        code.focus();
    }else if (!/^[0-9a-zA-Z]{4}$/.test($.trim(code.val())) && !(key == $.session.get('verifyCode'))){
        msg = "验证码格式不正确！";
        code.focus();
    }

    if(msg!=""){
        alert(msg);
    }
    else{

        $.ajax({
            url:'handleRequest.php',
                    type:'post',
                    dataType:'json',
                    data:{verifyCode:code.val(),userName:userId.val(),userPwd:password.val(),operation:"login"},
                success:function(data){
                    document.getElementById("register").style.display = "none";
                    document.getElementById("login").style.display = "none";
                    document.getElementById("account").style.display = "block";
                    alert($.cookie("userName"));
            },
            error:function () {
                alert("fail");
            }
        });

    }
    userId.val()=="";
    password.val()=="";
    code.val()=="";
}

function register_hide() {
    var email = $(".re_email");
    var userId = $(".userName");//用户名
    var password = $(".userPwd");
    var password1=$(".re_password1");
    var msg = "";
    // alert(userId.val());
    if ($.trim(userId.val()) == ""){
        msg = "用户名不能为空！";
        userId.focus();
    }else if (!/^\w{5,20}$/.test($.trim(userId.val()))){
        msg = "用户名格式不正确！";
        userId.focus();
    }else if(!CheckMail(email.val())) {
        msg = "邮箱格式不正确！";
    }else if ($.trim(password.val()) == ""){
        msg = "密码不能为空！";
        password.focus();
    }else if (!/^\w{6,20}$/.test($.trim(password.val()))){
        msg = "密码格式不正确！";
        password.focus();
    }
    else if(!($.trim(password.val())==$.trim(password1.val()))){
        msg = "两次输入密码不一致！";
        password1.focus();
    }
    if(msg!=""){
        alert(msg);
    }
    else{

        $.ajax({
            url:'http://223.3.93.117:8010/',
            type:'post',
            dataType:'json',
            data:{email:email.val(),userName:userId.val(),userPwd:password.val()},
            success:function(data){
                document.getElementById("register").style.display = "none";
                document.getElementById("login").style.display = "none";
                document.getElementById("account").style.display = "block";
                alert(data);
            }
        });

    }
}

function ChangeVerify() {
    $("#verify").attr("src","./Library/verifyImage.php");

}

function CheckMail(str)
{
    var result=str.match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/);
    if(result==null)
        return false;
    return true;
}

function login_show() {
    document.getElementById("register1").style.display = "block";
    document.getElementById("login1").style.display = "block";
    document.getElementById("account1").style.display = "none";
}