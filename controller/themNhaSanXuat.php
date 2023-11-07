<?php

/**
 * Sok Kim Thanh 7:14 CH
 * Thêm nhà sản xuất
 */
include_once "NhaSanXuatController.php";

$list = new NhaSanXuatController();
$err_code = "";
// test
try {
    // var_dump($_POST['ma']);
    if (!isset($_POST['ma'])) {
        throw new Exception('manhasanxuat chưa hợp lệ');
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
    $nhasanxuat = new NhaSanXuat($ma, $ten, $ghichu);
    $err_code = $list->Add($nhasanxuat);
    header("Location: ../view/listnhasanxuat.php?msg1=insert&error_code={$err_code}");
} catch (Exception $ex) {
    echo $ex->getMessage();
}
