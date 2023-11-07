<?php

/**
 * Sok Kim Thanh 2211tt0063 01/11/2023 8:34 SA
 * Controlller: Danh sách sản phẩm thêm xóa sửa tìm kiếm
 * Sao chép: 04/11/2023 CH
 */
include_once '../model/tbl_sanpham.php';
include_once 'CRUDController.php';
class SanPhamController implements CRUDController
{
    private $tbl_sanpham; /* db san pham */
    private $list;/* List san pham */

    public function __construct()
    {
        $this->tbl_sanpham = new Tbl_SanPham();
        $this->list = $this->tbl_sanpham->SelectAll();
    }

    public function GUI($length = 11)
    {
        // xử lý mã tự động 
        $characters = '01234567899';
        // 11 ký tự chuỗi số ngẫu nhiên
        $random_string = substr(str_shuffle($characters), 0, $length);

        return $random_string;
    }
    public function getList()
    {
        return $this->list;
    }
    public function Add($object)
    {
        if ($this->tbl_sanpham->Insert($object) == INPUT_ERROR) {
            throw new Exception("Không tồn tại biến tham chiếu");
        } else if ($this->tbl_sanpham->Insert($object) == QUERY_ERROR) {
            throw new Exception("Thực thi truy vấn thất bại");
        } else if ($this->tbl_sanpham->Insert($object) == INSERT_ERROR) {
            throw new Exception("ID đã tồn tại trong cơ sở dữ liệu.");
        } else {
            echo  "Thêm thành công";
            $this->list = $this->tbl_sanpham->SelectAll();
        }
    }
    public function Edit($object)
    {
        try {
            if ($this->tbl_sanpham->Update($object) == INPUT_ERROR) {
                throw new Exception("Không tồn tại biến tham chiếu");
            } else if ($this->tbl_sanpham->Update($object) == QUERY_ERROR) {
                throw new Exception("Thực thi truy vấn thất bại");
            } else {
                echo "Sửa thành công";
                $this->list = $this->tbl_sanpham->SelectAll();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function DeleteById($id)
    {
        try {
            if ($this->tbl_sanpham->Delete($id) == INPUT_ERROR) {
                throw new Exception("Không tồn tại biến tham chiếu");
            } else if ($this->tbl_sanpham->Delete($id) == QUERY_ERROR) {
                throw new Exception("Thực thi truy vấn thất bại");
            } else {
                echo "Xóa thành công";
                $this->list = $this->tbl_sanpham->SelectAll();
                $result = $this->tbl_sanpham->SelectOne($id);
                return $result;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function FindById($id)
    {
        try {
            if ($this->tbl_sanpham->SelectOne($id) == null) {
                throw new Exception("Tìm theo id không thành công");
                return null;
            } else {
                $sanpham = $this->tbl_sanpham->SelectOne($id);
                // echo "Tìm thành công";
                return $sanpham;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}


// Unit test
// include_once 'DanhMucController.php';

// $spCtrl  = new SanPhamController();
// $dmCtrl  = new DanhMucController();

// test add
// echo Count($spCtrl->getList());
// $dm = $dmCtrl->FindById("12345678911");
// var_dump($dm);
// $sp = new SanPham("sp000001002", "San pham 1", $dm, 30000, 123, "sános");
// $spCtrl->Add($sp);
// echo Count($spCtrl->getList());
// print_r($spCtrl->getList());

// test edit
// $spCtrl->FindById("sp000001002")->__toString();
// $dm = $dmCtrl->FindById("12345678911");
// var_dump($dm);
// $sp = new SanPham("sp000001002", "San pham 1", $dm, 123123, 123, "sános111");
// $spCtrl->Edit($sp);
// $spCtrl->FindById("sp000001002")->__toString();

// test delete success 04/11/2023 10:12 CH
// echo Count($spCtrl->getList());
// $spCtrl->DeleteById("sp000001002");
// echo Count($spCtrl->getList());
