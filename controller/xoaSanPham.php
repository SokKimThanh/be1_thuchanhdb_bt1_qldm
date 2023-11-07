<?php

/**
 * Sok Kim Thanh 7:14 CH
 * Xóa sản phẩm
 * Sao chép: 04/11/2023 CH
 */
include_once "SanPhamController.php";
$list = new SanPhamController();
// xoa
var_dump($_POST['deleteID']);

if (isset($_GET['deleteID']) && !empty($_GET['deleteID'])) {
    $deleteId = $_GET['deleteID'];
    echo $msg = $list->DeleteById($deleteId);

    header("Location: ../view/listsanpham.php?msg3=delete");
}
