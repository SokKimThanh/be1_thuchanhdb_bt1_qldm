<?php

/**
 * Sok Kim Thanh 2211tt0063 01/11/2023 8:34 SA
 * Controlller: Danh sách nhà sản xuất thêm xóa sửa tìm kiếm
 * Sao chép: 05/11/2023 5:22 SA
 */
include_once '../model/tbl_nhasanxuat.php';
include_once 'CRUDController.php';
class NhaSanXuatController implements CRUDController
{
    private $tbl_nhasanxuat; /* db nha san xuat */
    private $list;/* List nha san xuat */

    public function __construct()
    {
        $this->tbl_nhasanxuat = new Tbl_NhaSanXuat();
        $this->list = $this->tbl_nhasanxuat->SelectAll();
    }

    public function GUI($length = 11)
    {
        // xử lý mã tự động 
        $characters = '01234567899';
        // 11 ký tự chuỗi số ngẫu nhiên
        $random_string = substr(str_shuffle($characters), 0, $length);

        return $random_string;
    }

    public function Add($object)
    {
        if ($this->tbl_nhasanxuat->Insert($object) == INPUT_ERROR) {
            throw new Exception("Không tồn tại biến tham chiếu");
        } else if ($this->tbl_nhasanxuat->Insert($object) == QUERY_ERROR) {
            throw new Exception("Thực thi truy vấn thất bại");
        } else if ($this->tbl_nhasanxuat->Insert($object) == INSERT_ERROR) {
            throw new Exception("ID đã tồn tại trong cơ sở dữ liệu.");
        } else {
            echo  "Thêm thành công";
            $this->list = $this->tbl_nhasanxuat->SelectAll();
        }
    }
    public function Edit($object)
    {
        try {
            if ($this->tbl_nhasanxuat->Update($object) == INPUT_ERROR) {
                throw new Exception("Không tồn tại biến tham chiếu");
            } else if ($this->tbl_nhasanxuat->Update($object) == QUERY_ERROR) {
                throw new Exception("Thực thi truy vấn thất bại");
            } else {
                echo "Sửa thành công";
                $this->list = $this->tbl_nhasanxuat->SelectAll();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function DeleteById($id)
    {
        try {
            if ($this->tbl_nhasanxuat->Delete($id) == INPUT_ERROR) {
                throw new Exception("Không tồn tại biến tham chiếu");
            } else if ($this->tbl_nhasanxuat->Delete($id) == QUERY_ERROR) {
                throw new Exception("Thực thi truy vấn thất bại");
            } else {
                echo "Xóa thành công";
                $this->list = $this->tbl_nhasanxuat->SelectAll();
                $result = $this->tbl_nhasanxuat->SelectOne($id);
                return $result;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function FindById($id)
    {
        try {
            if ($this->tbl_nhasanxuat->SelectOne($id) == null) {
                throw new Exception("Tìm theo id không thành công");
                return null;
            } else {
                $nhasanxuat = $this->tbl_nhasanxuat->SelectOne($id);
                // echo "Tìm thành công";
                return $nhasanxuat;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get the value of list
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * Set the value of list
     *
     * @return  self
     */
    public function setList($list)
    {
        $this->list = $list;

        return $this;
    }
}


// Unit test
// date_default_timezone_set('Asia/Ho_Chi_Minh');
// echo date('d-m-Y H:i:s');
// include_once 'NhaSanXuatController.php';

// $nsxCtrl  = new NhaSanXuatController();

// test add
// echo Count($nsxCtrl->getList());
// $sp = new NhaSanXuat("nsx12345678");
// $nsxCtrl->Add($sp);
// echo Count($nsxCtrl->getList());
// print_r($nsxCtrl->getList());

// test edit
// $nsxCtrl->FindById("nsx12345678")->__toString();
 
// $sp = new NhaSanXuat("nsx12345678","samsung2","nhà sản xuất điện thoại hàn quốc lớn nhất châu á");
// $nsxCtrl->Edit($sp);
// $nsxCtrl->FindById("nsx12345678")->__toString();

// test delete success 05-11-2023 06:57:32
// echo Count($nsxCtrl->getList());
// $nsxCtrl->DeleteById("nsx12345678");
// echo Count($nsxCtrl->getList());
