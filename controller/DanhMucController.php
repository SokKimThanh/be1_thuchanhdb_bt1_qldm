<?php

/**
 * Sok Kim Thanh 2211tt0063 01/11/2023 8:34 SA
 * Controlller: Danh sách danh mục thêm xóa sửa tìm kiếm
 */
include_once '../model/tbl_danhmuc.php';
include_once 'CRUDController.php';
class DanhMucController implements CRUDController
{
    private $tbl_danhmuc; /* db danh muc */
    private $list;/* List danh muc */

    public function __construct()
    {
        $this->tbl_danhmuc = new Tbl_DanhMuc();
        $this->list = $this->tbl_danhmuc->SelectAll();
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
        if ($this->tbl_danhmuc->Insert($object) == INPUT_ERROR) {
            throw new Exception("Không tồn tại biến tham chiếu");
            return INPUT_ERROR;
        } else if ($this->tbl_danhmuc->Insert($object) == QUERY_ERROR) {
            throw new Exception("Thực thi truy vấn thất bại");
            return QUERY_ERROR;
        } else if ($this->tbl_danhmuc->Insert($object) == INSERT_ERROR) {
            throw new Exception("ID đã tồn tại trong cơ sở dữ liệu.");
            return INSERT_ERROR;
        } else {
            echo  "Thêm thành công";
            $this->list = $this->tbl_danhmuc->SelectAll();
            return SUCCESS;
        }
    }
    public function Edit($object)
    {
        try {
            if ($this->tbl_danhmuc->Update($object) == INPUT_ERROR) {
                throw new Exception("Không tồn tại biến tham chiếu");
                return INPUT_ERROR;
            } else if ($this->tbl_danhmuc->Update($object) == QUERY_ERROR) {
                throw new Exception("Thực thi truy vấn thất bại");
                return QUERY_ERROR;
            } else {
                // echo SUCCESS . ":Thêm thành công";
                echo "Sửa thành công";
                $this->list = $this->tbl_danhmuc->SelectAll();
                return SUCCESS;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function DeleteById($id)
    {
        try {
            if ($this->tbl_danhmuc->Delete($id) == INPUT_ERROR) {
                throw new Exception("Không tồn tại biến tham chiếu");
                return INPUT_ERROR;
            } else if ($this->tbl_danhmuc->Delete($id) == QUERY_ERROR) {
                throw new Exception("Thực thi truy vấn thất bại");
                return QUERY_ERROR;
            } else {
                echo "Xóa thành công";
                $this->list = $this->tbl_danhmuc->SelectAll();
                $result = $this->tbl_danhmuc->SelectOne($id);
                return $result;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function FindById($id)
    {
        try {
            if ($this->tbl_danhmuc->SelectOne($id) == null) {
                throw new Exception("Tìm theo id không thành công");
                return null;
            } else {
                $danhmuc = $this->tbl_danhmuc->SelectOne($id);
                return $danhmuc;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
