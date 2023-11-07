<?php

/**
 * Sok Kim Thanh 7:14 CH
 * Sửa nhà sản xuất
 * copy 05/11/2023 6:24 SA
 */
require_once "NhaSanXuatController.php";
$list = new NhaSanXuatController();
// sua
try {

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
    $nhasanxuat = new NhaSanXuat($ma, $ten, $ghichu);
    echo $mgs =  $list->Edit($nhasanxuat);
    header("Location: ../view/listnhasanxuat.php?msg2=update");
} catch (Exception $ex) {
    echo $ex->getMessage();
}
