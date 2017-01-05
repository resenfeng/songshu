<?php
/**
 * Created by PhpStorm.
 * User: FengSen
 * Date: 2016/4/16
 * Time: 17:42
 */
function checkLogined()
{
    if ($_COOKIE['userName'] != "") {
        $mes="logined";
        return $mes;
    }
}