<?php

/**
 * Created by PhpStorm.
 * User: fs
 * Date: 16-12-23
 * Time: 下午9:30
 */
require "connectMysql.php";
class sqlOperation
{
    private $fields;
    private $tables;
    private $conditions;

    function __construct($fields, $tables, $conditions)
    {
        $this->fields = $fields;
        $this->tables = $tables;
        $this->conditions = $conditions;
    }

    public function select(){
        $querySql = "";
        $tText = "";
        $cText = "";

        foreach ($this->fields as $field) {
            if ($querySql == null)
                $sep = "";
            else
                $sep = ",";
            $querySql .= $sep . $field;
        }


        if (count($this->tables) > 1){
            $i = 1;
            foreach ($this->tables as $tKey=>$table) {
                if ($tText == null){
                    $sep1 = "";
                    $sep2 = "";
                }else{
                    $sep1 = " left join ";
                    $tempStr = 'multiply'.$i;
                    $sep2 = " on " . $this->tables[$tempStr];
                    $i++;
                }

                if (strstr($tKey, "multiply"))
                    break;
                $tText .= $sep1 . $table . $sep2;
            }
            $querySql .= " from " . $tText . " where ";
        }else{
            $tText = $this->tables['table'];
            $querySql .= " from " . $tText . " where ";
        }

        foreach ($this->conditions as $cKey => $cVal) {
            if ($cText == null)
                $sep = "";
            else
                $sep = " and ";
            if (is_numeric($cVal))
                $cText .= $sep . $cKey . "=" . $cVal;
            else
                $cText .= $sep . $cKey . "= '" . $cVal . "'";
        }
        $querySql = "select " . $querySql .$cText;

        $query = mysql_query($querySql, connect());
        $result = array();
        while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
            $result[] = $row;
        }

        if (!array_key_exists(1, $result) && !empty($result))
            $result = $result[0];

        return $result;
    }

    public function update(){
        //
    }

    public function delete(){
        //
    }

    public function insert(){
//        $tText = "";
        $keyText = "";
        $valText = "";

        foreach ($this->fields as $fKey => $fVal) {
            if ($keyText == null || $valText == null)
                $sep = "";
            else
                $sep = ",";
            $keyText .= $sep . $fKey;
            if (is_numeric($fVal))
                $valText .= $sep . $fVal;
            else
                $valText .= $sep . "'" . $fVal . "'";
        }

//        foreach ($this->tables as $table) {
//            if ($tText == null){
//                $sep1 = "";
//            }else{
//                $sep1 = ",";
//            }
//            $tText .= $sep1 . $table;
//        }
        $insertSql = "insert into " . $this->tables . " (" . $keyText . ") " . "values" . " (" . $valText . ")";
        if (!mysql_query($insertSql, connect()))
            return false;
        else
            return true;
    }
}