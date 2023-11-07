<?php

/**
 * Sok Kim Thanh 7:14 CH
 * Sửa danh mục
 */
require_once "DanhMucController.php";
$list = new DanhMucController();
// sua
try {
    // them 
    // var_dump($_POST['ghichu']);
    // var_dump($_POST['ten']);
    // var_dump($_POST['ma']);

    if (isset($_POST['ma'])) {
        // echo "vaoday";
        if (!isset($_POST['ten']) && !isset($_POST['ghichu'])) {
            // echo "isAdd";
            return;
        }
        $ma = $_POST['ma'];
        $ten = $_POST['ten'];
        $ghichu = $_POST['ghichu'];
        $danhmuc = new DanhMuc($ma, $ten, $ghichu);
        echo $mgs =  $list->Edit($danhmuc);
        header("Location: ../view/listdanhmuc.php?msg2=update");
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
