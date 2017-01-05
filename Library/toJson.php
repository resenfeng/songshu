<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 16-12-24
 * Time: 下午5:04
 */
function toJson($code, $mes, $data){
    $rArray = array(
        "code" => $code,
        "message" => $mes,
        "data" => $data
    );

    return json_encode($rArray);
}