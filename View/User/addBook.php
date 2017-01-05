<?php
require_once '../include.php';
//checkLogined();
$rows=getAllCate();
if(!$rows){
    alertMes("没有相应分类，请先添加分类!!", "addCate.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>添加商品</title>
    <meta name="author" content="baiyang" />
    <link type="text/css" href="../Public/css/addPro.css" rel="stylesheet" />
    <script type="text/javascript" src="../Public/plugins/kindeditor/kindeditor.js"></script>
    <script type="text/javascript" src="../Public/plugins/kindeditor/lang/zh_CN.js"></script>
    <script type="text/javascript" src="../Public/plugins/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript" src="../Public/plugins/My97DatePicker/lang/zh-cn.js"></script>
    <script type="text/javascript" src="../Public/js/jquery-1.6.4.js"></script>
    <!-- Date: 2016-03-27 -->
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
<body>
<!-- 提交表单的页面 -->
<form action="doUserOperation.php?operation=addBook" method="post" enctype="multipart/form-data" >

    <table width="70%"  border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td style="text-align: center" colspan="2"><b>添加商品</b></td>
        </tr>
        <tr>
            <td><span>商品名称:</span></td>
            <td>
                <input name="pName" type="text" />
            </td>
        </tr>
        <tr>
            <td>选择分类</td><td >
                <select name="cId">
                    <!-- 分类数据 -->
                    <?php foreach($rows as $row):?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['cName'];?></option>
                    <?php endforeach;?>
                </select></td>
        </tr>
        <tr>
            <td><span>价格：</span></td><td>
                <input name="iPrice" type="number" />
            </td>
        </tr>
        <tr>
            <td><span>商品数量:</span></td><td>
                <input name="pNum" type="number" />
            </td>
        </tr>
        <tr>
            <td><span>上架日期:</span></td><td>
                <input name="pubTime" type="text" onclick="WdatePicker()" />
            </td>
        </tr>
        <tr><td>图片：</td>
            <!-- 防止页面跳转 -->
            <td><a href="javascript:void(0)" class="selectFileBtn">添加附件</a>
                <div class="attachList" class="clear"></div>
            </td></tr>
        <tr>
            <td><span>描述:</span></td>
            <td >
                <textarea id="editor_id" name="pDesc" style="width:100%;height:300px"></textarea>
            </td>
        </tr>
        <td style="text-align: center" colspan="2">
            <button type="submit" class="add"  style="font-size:large" >添加</button>
        </td>
    </table>
</form>
</body>
</html>