<?php
/**
 * Created by PhpStorm.
 * User: 冯森
 * Date: 2016/3/28
 * Time: 13:34
 */
/**
 * 得到商品的所有信息
 * @return array
 */
//require_once "..\config\config.php";
//require_once "mysql.php";
function getAllBook()
{
    $sql = "select p.bookId,p.bookName,p.bookPrice,p.bookDes,p.isExchanged,p.isWanted,c.categoryId from book as p join category c on p.categoryId=c.categoryId";
    $rows = fetchAll($sql);
    return $rows;
}

/**
 *根据商品id得到商品图片
 * @param int $id
 * @return array
 */
function getAllImgByProId($id)
{
    $sql = "select albumPath from album where bookId={$id}";
//    $rows = fetchOne($sql);
    $result = mysql_query($sql);
    $rows = mysql_fetch_array($result, $result_type);
    return $rows;
}

/**
 * 根据id得到商品的详细信息
 * @param int $id
 * @return array
 */
function getProById($id)
{
    $sql = "select p.bookId,p.bookName,p.bookPrice,p.bookDes,p.isExchanged,p.isWanted,c.categoryId from book as p join category c on p.categoryId=c.categoryId where p.categoryId={$id}";
    $row = fetchOne($sql);
    return $row;
}


/**
 * 得到所有商品
 * @return array
 */
function getAllPros()
{
    $sql = "select p.bookId,p.bookName,p.bookPrice,p.bookDes,p.isExchanged,p.isWanted,c.categoryId from book as p join category c on p.categoryId=c.categoryId ";
    $rows = fetchAll($sql);
    return $rows;
}

/**
 *根据cid得到4条产品
 * @param int $cid
 * @return Array
 */
function getProsByCid($cid)
{
    $sql = "select p.bookId,p.bookName,p.bookPrice,p.bookDes,p.isExchanged,p.isWanted,c.categoryId from book as p join category c on p.categoryId=c.categoryId where p.categoryId={$cid} limit 4";
    $rows = fetchAll($sql);
    return $rows;
}

/**
 * 得到下4条产品
 * @param int $cid
 * @return array
 */
function getSmallProsByCid($cid)
{
    $sql = "select p.bookId,p.bookName,p.bookPrice,p.bookDes,p.isExchanged,p.isWanted,c.categoryId from book as p join category c on p.categoryId=c.categoryId where p.categoryId=={$cid} limit 4,4";
    $rows = fetchAll($sql);
    return $rows;
}

/**
 *得到商品ID和商品名称
 * @return array
 */
function getProInfo()
{
    $sql = "select bookId,bookName from book order by bookId asc";
    $rows = fetchAll($sql);
    return $rows;
}

/**
 * 根据ID得到指定分类信息
 * @param int $id
 * @return array
 */
function getCateById($id)
{
    $sql = "select categoryId,categoryName from category where categoryId={$id}";
    return fetchOne($sql);
}

/**
 * 得到所有分类
 * @return array
 */
function getAllCate()
{
    $sql = "select categoryId,categoryName from category";
    $rows = fetchAll($sql);
    return $rows;
}

/**
 * 得到所有的管理员
 * @return array
 */
function getAllAdmin()
{

    $sql = "select id,adminname,email from admin ";
    $rows = fetchAll($sql);
    return $rows;
}

function getAdminByPage($page, $pageSize = 2)
{
    $sql = "select * from admin";
    global $totalRows;
    $totalRows = getResultNum($sql);
    global $totalPage;
    $totalPage = ceil($totalRows / $pageSize);
    if ($page < 1 || $page == null || !is_numeric($page)) {
        $page = 1;
    }
    if ($page >= $totalPage) $page = $totalPage;
    $offset = ($page - 1) * $pageSize;
    $sql = "select id,adminname,email from admin limit {$offset},{$pageSize}";
    $rows = fetchAll($sql);
    return $rows;
}

function getAllUserInfo(){
    //
}

function getBookBySeller($sellername){
    $sql="select bookName,bookDes from book where sellerName={$sellername}";
    $rows=fetchAll($sql);
    return $rows;
}