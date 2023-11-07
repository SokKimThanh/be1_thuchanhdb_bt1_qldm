<?php

/**
 * Sok Kim Thanh 7:14 CH
 * Thêm danh mục
 */
include_once "DanhMucController.php";

$list = new DanhMucController();
$err_code = "";
// test
try {
    // var_dump($_POST['ma']);
    if (!isset($_POST['ma'])) {
        throw new Exception('madanhmuc chưa hợp lệ');
        return;
    }
    if (!isset($_POST['ten'])) {
        throw new Exception('ten chưa hợp lệ');
        return;
    }
    if (!isset($_POST['ghichu'])) {
        throw new Exception('ghichu chưa hợp lệ');
        return;
    }
    $ma = $_POST['ma'];
    $ten = $_POST['ten'];
    $ghichu = $_POST['ghichu'];
    $danhmuc = new DanhMuc($ma, $ten, $ghichu);
    $err_code = $list->Add($danhmuc);
    header("Location: ../view/listdanhmuc.php?msg1=insert&error_code={$err_code}");
} catch (Exception $ex) {
    echo $ex->getMessage();
}
