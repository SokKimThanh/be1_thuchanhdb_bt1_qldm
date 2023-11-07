<?php

/**
 * Sok Kim Thanh 7:14 CH
 * Sửa sản phẩm
 * Sao chép: 04/11/2023 CH
 */
require_once "SanPhamController.php";
require_once "DanhMucController.php";
require_once "NhaSanXuatController.php";
$spCtrl  = new SanPhamController();
$dmCtrl  = new DanhMucController();
$nsxCtrl  = new NhaSanXuatController();
// sua
try {
    if (!isset($_POST['ma'])) {
        throw new Exception('ma chưa hợp lệ');
        return;
    }
    if (!isset($_POST['ten'])) {
        throw new Exception('ten chưa hợp lệ');

        return;
    }
    if (!isset($_POST['danhmuc'])) {
        throw new Exception('danhmuc chưa hợp lệ');
        return;
    }

    if (!isset($_POST['gia'])) {
        throw new Exception('gia chưa hợp lệ');

        return;
    }
    if (!isset($_POST['soluong'])) {
        throw new Exception('soluong chưa hợp lệ');
        return;
    }
    if (!isset($_POST['nhasanxuat'])) {
        throw new Exception('nhasanxuat chưa hợp lệ');
        return;
    }
    $ma = $_POST['ma'];
    $ten = $_POST['ten'];
    $danhmuc = $_POST['danhmuc'];
    $nhasanxuat = $_POST['nhasanxuat'];
    //Tìm danh mục
    $dm = $dmCtrl->FindById(/* "12345678911" */$danhmuc);
    $nsx = $nsxCtrl->FindById(/* "12345678911" */$nhasanxuat);
    $gia = $_POST['gia'];
    $soluong = $_POST['soluong'];
    $sanpham = new SanPham($ma, $ten, $dm, $gia, $soluong, $nsx);
    echo $mgs =  $spCtrl->Edit($sanpham);
    header("Location: ../view/listsanpham.php?msg2=update");
} catch (Exception $ex) {
    echo $ex->getMessage();
}
