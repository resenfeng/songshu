/**
 * Created by baiyang on 2017/1/5.
 */

    var name=$.cookie("userName");
if(name!=undefined){
    document.getElementById("register").style.display = "block";
    document.getElementById("login").style.display = "block";
    document.getElementById("account").style.display = "none";

}
else{
    document.getElementById("register").style.display = "none";
    document.getElementById("login").style.display = "none";
    document.getElementById("account").style.display = "block";
}