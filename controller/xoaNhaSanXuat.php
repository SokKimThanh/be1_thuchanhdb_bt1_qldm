<?php

/**
 * Sok Kim Thanh 7:14 CH
 * Xóa nhà sản xuất 
 * copy 05/11/2023 6:24 SA 
 */
require_once "NhaSanXuatController.php";
$list = new NhaSanXuatController();
// xoa
// var_dump($_POST['deleteID']);

if (isset($_GET['deleteID']) && !empty($_GET['deleteID'])) {
    $deleteId = $_GET['deleteID'];
    echo $msg = $list->DeleteById($deleteId);

    header("Location: ../view/listnhasanxuat.php?msg3=delete");
}
