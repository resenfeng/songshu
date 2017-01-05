<?php

/**
 * Created by PhpStorm.
 * User: fs
 * Date: 16-12-23
 * Time: 下午9:35
 */
require "./Library/sqlOperation.php";
class userModel
{
    public function getUser($fields, $tables, $conditions){
        $querySql = new sqlOperation($fields, $tables, $conditions);
        $userRes = $querySql->select();
        return $userRes;
    }

    public function addUser($fields, $table){
        $insert = new sqlOperation($fields, $table, array());
        return $insert->insert();
    }
}