<?php
/**
 * Created by PhpStorm.
 * User: 冯森
 * Date: 2016/4/2
 * Time: 13:35
 */

/**
 * 构建上传文件信息
 * @return array
 */
function buildInfo()
{
    if (!$_FILES) {
        return;
    }
    $i = 0;
    foreach ($_FILES as $v) {
        //单文件
        if (is_string($v['name'])) {
            $files[$i] = $v;
            $i++;
        } else {
            //多文件
            foreach ($v['name'] as $key => $val) {
                $files[$i]['name'] = $val;
                $files[$i]['size'] = $v['size'][$key];
                $files[$i]['tmp_name'] = $v['tmp_name'][$key];
                $files[$i]['error'] = $v['error'][$key];
                $files[$i]['type'] = $v['type'][$key];
                $i++;
            }
        }
    }
    return $files;
}

/**
 * 上传文件的函数
 * @param string $path
 * @param array $allowExt
 * @param int $maxSize
 * @param bool|true $imgFlag
 */
function uploadFile($path = "../images/uploadImages", $allowExt = array("gif", "jpeg", "png", "jpg", "wbmp"), $maxSize = 2097152, $imgFlag = true)
{
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    $i = 0;
    $files = buildInfo();
    if (!($files && is_array($files))) {
        return;
    }
    foreach ($files as $file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $ext = getExt($file['name']);
            //检测文件的扩展名
            if (!in_array($ext, $allowExt)) {
                exit("非法文件类型");
            }
            //校验是否是一个真正的图片类型
            if ($imgFlag) {
                if (!getimagesize($file['tmp_name'])) {
                    exit("不是真正的图片类型");
                }
            }
            //上传文件的大小
            if ($file['size'] > $maxSize) {
                exit("上传文件过大");
            }
            if (!is_uploaded_file($file['tmp_name'])) {
                exit("不是通过HTTP POST方式上传上来的");
            }
            $filename = getUniName() . "." . $ext;
            $destination = $path . "/" . $filename;
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $file['name'] = $filename;
                unset($file['tmp_name'], $file['size'], $file['type']);
                $uploadedFiles[$i] = $file;
                $i++;
            }
        } else {
            switch ($file['error']) {
                case 1:
                    $mes = "超过了配置文件上传文件的大小";//UPLOAD_ERR_INI_SIZE
                    break;
                case 2:
                    $mes = "超过了表单设置上传文件的大小";            //UPLOAD_ERR_FORM_SIZE
                    break;
                case 3:
                    $mes = "文件部分被上传";//UPLOAD_ERR_PARTIAL
                    break;
                case 4:
                    $mes = "没有文件被上传1111";//UPLOAD_ERR_NO_FILE
                    break;
                case 6:
                    $mes = "没有找到临时目录";//UPLOAD_ERR_NO_TMP_DIR
                    break;
                case 7:
                    $mes = "文件不可写";//UPLOAD_ERR_CANT_WRITE;
                    break;
                case 8:
                    $mes = "由于PHP的扩展程序中断了文件上传";//UPLOAD_ERR_EXTENSION
                    break;
            }
            echo $mes;
        }
    }
    return $uploadedFiles;
}

/**
 * 生成缩略图
 * @param string $filename
 * @param string $destination
 * @param int $dst_w
 * @param int $dst_h
 * @param bool $isReservedSource
 * @param number $scale
 * @return string
 */
//function thumb($filename,$destination=null,$dst_w=null,$dst_h=null,$isReservedSource=true,$scale=0.5){
//    list($src_w,$src_h,$imagetype)=getimagesize($filename);
//    if(is_null($dst_w)||is_null($dst_h)){
//        $dst_w=ceil($src_w*$scale);
//        $dst_h=ceil($src_h*$scale);
//    }
//    $mime=image_type_to_mime_type($imagetype);
//    $createFun=str_replace("/", "createfrom", $mime);
//    $outFun=str_replace("/", null, $mime);
//    $src_image=$createFun($filename);
//    $dst_image=imagecreatetruecolor($dst_w, $dst_h);
//    imagecopyresampled($dst_image, $src_image, 0,0,0,0, $dst_w, $dst_h, $src_w, $src_h);
//    if($destination&&!file_exists(dirname($destination))){
//        mkdir(dirname($destination),0777,true);
//    }
//    $dstFilename=$destination==null?getUniName().".".getExt($filename):$destination;
//    $outFun($dst_image,$dstFilename);
//    imagedestroy($src_image);
//    imagedestroy($dst_image);
//    if(!$isReservedSource){
//        unlink($filename);
//    }
//    return $dstFilename;
//}
function thumb($src_img, $dst_img, $width = 75, $height = 75, $cut = 0, $proportion = 0)
{
    if (!is_file($src_img)) {
        return false;
    }
    $ot = fileext($dst_img);
    $otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
    $srcinfo = getimagesize($src_img);
    $src_w = $srcinfo[0];
    $src_h = $srcinfo[1];
    $type = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
    $createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);

    $dst_h = $height;
    $dst_w = $width;
    $x = $y = 0;
    /**
     * 缩略图不超过源图尺寸（前提是宽或高只有一个）
     */
    if (($width > $src_w && $height > $src_h) || ($height > $src_h && $width == 0) || ($width > $src_w && $height == 0)) {
        $proportion = 1;
    }
    if ($width > $src_w) {
        $dst_w = $width = $src_w;
    }
    if ($height > $src_h) {
        $dst_h = $height = $src_h;
    }

    if (!$width && !$height && !$proportion) {
        return false;
    }
    if (!$proportion) {
        if ($cut == 0) {
            if ($dst_w && $dst_h) {
                if ($dst_w / $src_w > $dst_h / $src_h) {
                    $dst_w = $src_w * ($dst_h / $src_h);
                    $x = 0 - ($dst_w - $width) / 2;
                } else {
                    $dst_h = $src_h * ($dst_w / $src_w);
                    $y = 0 - ($dst_h - $height) / 2;
                }
            } else if ($dst_w xor $dst_h) {
                if ($dst_w && !$dst_h)  //有宽无高
                {
                    $propor = $dst_w / $src_w;
                    $height = $dst_h = $src_h * $propor;
                } else if (!$dst_w && $dst_h)  //有高无宽
                {
                    $propor = $dst_h / $src_h;
                    $width = $dst_w = $src_w * $propor;
                }
            }
        } else {
            if (!$dst_h)  //裁剪时无高
            {
                $height = $dst_h = $dst_w;
            }
            if (!$dst_w)  //裁剪时无宽
            {
                $width = $dst_w = $dst_h;
            }
            $propor = min(max($dst_w / $src_w, $dst_h / $src_h), 1);
            $dst_w = (int)round($src_w * $propor);
            $dst_h = (int)round($src_h * $propor);
            $x = ($width - $dst_w) / 2;
            $y = ($height - $dst_h) / 2;
        }
    } else {
        $proportion = min($proportion, 1);
        $height = $dst_h = $src_h * $proportion;
        $width = $dst_w = $src_w * $proportion;
    }

    $src = $createfun($src_img);
    $dst = imagecreatetruecolor($width ? $width : $dst_w, $height ? $height : $dst_h);
    $white = imagecolorallocate($dst, 255, 255, 255);
    imagefill($dst, 0, 0, $white);

    if (function_exists('imagecopyresampled')) {
        imagecopyresampled($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    } else {
        imagecopyresized($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    }
    $otfunc($dst, $dst_img);
    imagedestroy($dst);
    imagedestroy($src);
    return true;
}

/**
 * 生成唯一字符串
 * @return string
 */
function getUniName()
{
    return md5(uniqid(microtime(true), true));
}

/**
 * 得到文件的扩展名
 * @param string $filename
 * @return string
 */
function getExt($filename)
{
    return strtolower(end(explode(".", $filename)));
}

function fileext($file)
{
    return pathinfo($file, PATHINFO_EXTENSION);
}