<?php

/**
 * Sok Kim Thanh 7:14 CH
 * Xóa danh mục
 */
require_once "DanhMucController.php";
$list = new DanhMucController();
// xoa
// var_dump($_POST['deleteID']);

if (isset($_GET['deleteID']) && !empty($_GET['deleteID'])) {
    $deleteId = $_GET['deleteID'];
    echo $msg = $list->DeleteById($deleteId);

    header("Location: ../view/listdanhmuc.php?msg3=delete");
}
