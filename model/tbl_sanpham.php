<?php

/**
 * Sok Kim Thanh
 * create_date: 31/10/2023 7:32 CH
 * Lớp tbl_sanpham kết nối csdl và lấy ra toàn bộ thông tin của bảng(Thao tác trước trên phpmyadmin)
 * 
 * Select $sql = $connection->prepare("SELECT * FROM tbl_sanpham");
 * Insert $sql = $connection->prepare("INSERT INTO `tbl_sanpham`( `ma`, `ten`, `danhmuc`, `gia`, `soluong`, `nhasanxuat` ) VALUES( 'sp000112', '123123', 'dm000111', '2000', '10', 'samsaum' )");
 * Update $sql = $connection->prepare("UPDATE `tbl_sanpham` SET `ten` = 'San pham 33', `danhmuc` = 'dm111222332', `gia` = '20000', `soluong` = '100', `nhasanxuat` = 'samsaums' WHERE `tbl_sanpham`.`ma` = 'sp000112323'");
 * Delete $sql = $connection->prepare("DELETE FROM `tbl_sanpham` WHERE `tbl_sanpham`.`ma` = '12312312331'");
 * SearchById $sql = $connection->prepare("SELECT * FROM `tbl_sanpham` WHERE `ma` LIKE '12312312331'");
 * 
 * Sao chép: 04/11/2023 7:00 CH
 * Test processing: 04/11/2023 7:55 CH
 */
require_once 'db.php';
require_once 'iDB.php';
require_once 'sanpham.php';
require_once 'tbl_danhmuc.php';
require_once 'tbl_nhasanxuat.php';

class Tbl_SanPham extends DB implements iDB
{
    //member of class
    private $arrlist;
    private $table_name;
    private $db;
    private $tbl_danhmuc;
    private $tbl_nhasanxuat;

    // contructor
    public function __construct()
    {
        $this->arrlist = array();
        $this->table_name = 'tbl_sanpham';
        $this->db = new Db(); //connect database! 
    }



    //method interface
    public function SelectAll()
    {
        //Việc 1: tạo câu truy vấn
        $sql = self::$connection->prepare("SELECT * FROM {$this->table_name}");
        //Việc 2: thực thi câu truy vấn
        try {
            $sql->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            // Giải phóng bộ nhớ
            $sql->close();
            return QUERY_ERROR; //-2 // thực thi truy vấn không thành công
        }

        //Việc 3: trả về mảng liên hợp
        $array = array();
        $array = $sql->get_result()->fetch_all(MYSQLI_ASSOC);

        // update 04/11/2023 8:20 CH 
        // selectOne($id) tbl_danhmuc: thêm các đối tượng danh mục
        $this->tbl_nhasanxuat = new Tbl_NhaSanXuat();
        $this->tbl_danhmuc = new Tbl_DanhMuc();

        //việc 4: trả về mảng danh sách các đối tượng sản phẩm
        foreach ($array as $key => $value/* mảng value */) {
            //Tìm danh mục theo id
            $danhmuc = $this->tbl_danhmuc->SelectOne($value['danhmuc']);

            // update : 05/11/2023 kết bảng nhà sản xuất
            // var_dump($value['nhasanxuat']);
            $nhasanxuat = $this->tbl_nhasanxuat->SelectOne($value['nhasanxuat']);
            // var_dump($danhmuc);
            if ($danhmuc != null) {
                if ($nhasanxuat != null) {
                    //4.1 Khởi tạo đối tượng SanPham với các giá trị từ mảng $value
                    $sanpham = new SanPham($value['ma'], $value['ten'], $danhmuc, $value['gia'], $value['soluong'], $nhasanxuat);

                    //4.2 Thêm đối tượng SanPham vào mảng arrlist
                    array_push($this->arrlist, $sanpham);
                }
            }
        }

        //việc 5: ngắt kết nối câu lệnh sql // Giải phóng bộ nhớ
        $sql->close();
        return $this->arrlist; //Trả về thành công
    }
    function isNullOrEmptyString($str)
    {
        return (!isset($str) || trim($str) === '');
    }

    /**
     * Lấy ra 1 sản phẩm
     */
    public function SelectOne($id)
    {
        // var_dump($id);
        if ($this->isNullOrEmptyString($id)) {
            return INPUT_ERROR; //-1 không tồn tại biến tham chiếu
        }

        //Việc 1: Tạo câu sql
        $sql = self::$connection->prepare("SELECT * FROM /* tbl_sanpham */{$this->table_name} WHERE ma LIKE /* '2156465453' */ ?");

        // $sql->bind_param("type", $varibles);
        // Type:
        // ● i - Integer
        // ● d - Double
        // ● s - String
        // ● b - Blob
        //Việc 2: Thực thi sql với param
        $sql->bind_param(/* type */"s", /* $variable */ $id);

        // Việc 3: Thực thi câu truy vấn
        try {
            $sql->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            // Giải phóng bộ nhớ
            $sql->close();
            return QUERY_ERROR; //-2 // thực thi truy vấn không thành công
        }

        //Việc 4: trả về một dòng
        $value = $sql->get_result()->fetch_assoc();
        if ($value == null) {
            // throw new Exception("Không tìm thấy id sản phẩm");
            // throw new Exception("ID không tồn tại trong cơ sở dữ liệu.");
            $sql->close();
            return SELECT_ERROR; //-3 không tồn tại id
        } else {
            // update 04/11/2023 8:20 CH 
            // selectOne($id) tbl_danhmuc: thêm các đối tượng danh mục

            // update 04/11/2023 8:54 CH FK_SANPHAM_DANHMUC
            $this->tbl_danhmuc = new Tbl_DanhMuc();
            $danhmuc = $this->tbl_danhmuc->SelectOne($value['danhmuc']);
            // var_dump($danhmuc);

            // update 05/11/2023 8:54 CH FK_SANPHAM_NHASANXUAT
            $this->tbl_nhasanxuat = new Tbl_NhaSanXuat();
            $nhasanxuat = $this->tbl_nhasanxuat->SelectOne($value['nhasanxuat']);
            // var_dump($nhasanxuat);

            // việc 4.1 kiểm tra danh mục tồn tại hay không?
            if ($danhmuc == null) {
                throw new Exception("Danh mục không tồn tại.");
                // việc 6: Giải phóng bộ nhớ
                $sql->close();
                return null; // không tìm thấy sản phẩm;
            }
            // việc 4.2 kiểm tra nhà sản xuất tồn tại hay không?
            if ($nhasanxuat == null) {
                throw new Exception("nhà sản xuất không tồn tại.");
                // việc 6: Giải phóng bộ nhớ
                $sql->close();
                return null; // không tìm thấy sản phẩm;
            }

            // việc 5: Tạo một đối tượng để chứa giá trị  
            $sanpham = new SanPham($value['ma'], $value['ten'], $danhmuc, $value['gia'], $value['soluong'], $nhasanxuat);
            // việc 6: Giải phóng bộ nhớ
            $sql->close();
            return $sanpham; // Tìm thấy sản phẩm; 
        }
    }
    /**
     * Thêm 1 sản phẩm
     * return 0: success -1:null $bienThamChieu; -2 thực thi câu truy van không thành công
     * mấy cái chấm hỏi gọi là biến tham chiếu
     */
    public function Insert(/* SanPham */$bienThamChieu)
    {
        if ($this->isNullOrEmptyString($bienThamChieu)) {
            return INPUT_ERROR;/* -1 Không tồn tại tham chiếu */
        }

        // việc 0: bắt lỗi nhập trùng id
        $ma = $bienThamChieu->getMa();
        if ($this->SelectOne($ma) != null/*Không trùng id */) {
            // Việc 1: Tạo câu truy vấn Sql
            $sql = self::$connection->prepare("INSERT INTO {$this->table_name} VALUES (/* 'sp000112' */?,? /* 'san pham 1' */,? /* 'dm000111' */,? /* '2000' */,? /* '10' */,? /* 'samsung' */)");

            // Việc 1.1 Tạo biến để gán vào chấm hỏi   (ghi chú: hàm bind_param chỉ chấp nhận biến tham chiếu)

            $ten = $bienThamChieu->getTen();
            $madanhmuc = $bienThamChieu->getDanhMuc()->getMa();
            $gia = $bienThamChieu->getGia();
            $soluong = $bienThamChieu->getSoLuong();
            $nhasanxuat = $bienThamChieu->getNhaSanXuat()->getMa();

            // Việc 2: Thêm param
            $sql->bind_param("sssdis", $ma, $ten, $madanhmuc, $gia, $soluong, $nhasanxuat);

            // Việc 3: Thực thi câu truy vấn
            try {
                $sql->execute();
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
                // Giải phóng bộ nhớ
                $sql->close();
                return QUERY_ERROR; //-2 // thực thi truy vấn không thành công
            }
            $sql->close(); // Giải phóng bộ nhớ
            return SUCCESS; // 0
        } else {
            return INSERT_ERROR;/*-3 Trùng id */
        }
    }
    /**
     * Cập nhật một sản phẩm 
     */
    public function Update($bienThamChieu)
    {
        if ($this->isNullOrEmptyString($bienThamChieu)) {
            return INPUT_ERROR;/* Không tồn tại tham chiếu */
        }


        // Việc 1: Tạo câu truy vấn Sql

        $sql = self::$connection->prepare("UPDATE {$this->table_name} SET ten = ? /* 'San pham 33' */, danhmuc = ?/* 'dm111222332' */, gia = ?/* '20000' */, soluong = ?/* '100' */, nhasanxuat = ?/* 'samsaums' */ WHERE {$this->table_name}.ma = /* '2156465453' */?");

        // Việc 1.1 Tạo biến để gán vào chấm hỏi   (ghi chú: hàm bind_param chỉ chấp nhận biến tham chiếu)
        $ma = $bienThamChieu->getMa();
        $ten = $bienThamChieu->getTen();
        $madanhmuc = $bienThamChieu->getDanhMuc()->getMa();
        $gia = $bienThamChieu->getGia();
        $soluong = $bienThamChieu->getSoLuong();
        $nhasanxuat = $bienThamChieu->getNhaSanXuat()->getMa();

        // Việc 2: Thêm param
        $sql->bind_param("ssdiss", $ten, $madanhmuc, $gia, $soluong, $nhasanxuat, $ma);

        // Việc 3: Thực thi câu truy vấn
        try {
            $sql->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            // Giải phóng bộ nhớ
            $sql->close();
            return QUERY_ERROR; //-2 // thực thi truy vấn không thành công
        }
        $sql->close(); // Giải phóng bộ nhớ
        return SUCCESS;
    }

    /**
     * Xóa một sản phẩm 
     */
    public function Delete($id)
    {
        if ($this->isNullOrEmptyString($id)) {
            return INPUT_ERROR;/* Không tồn tại tham chiếu */
        }

        // Việc 1: Tạo câu truy vấn Sql
        $sql = self::$connection->prepare("DELETE FROM {$this->table_name} WHERE {$this->table_name}.ma = ?/* '2156465453' */");

        // Việc 2: Thêm param
        $sql->bind_param("s", $id);

        // Việc 3: Thực thi câu truy vấn
        $result = $sql->execute();
        if (!$result) {
            $sql->close(); // Giải phóng bộ nhớ
            return QUERY_ERROR;
        }
        $sql->close(); // Giải phóng bộ nhớ
        return SUCCESS;
    }

    /**
     * Get the value of arrlist
     */
    public function getArrlist()
    {
        return $this->arrlist;
    }

    /**
     * Set the value of arrlist
     *
     * @return  self
     */
    public function setArrlist($arrlist)
    {
        $this->arrlist = $arrlist;

        return $this;
    }
}

// unit test

// 04/11/2023 7:58 CH - test success
// 04/11/2023 9:37 CH - test success
// $tbl_sanpham = new Tbl_SanPham();
// $tbl_danhmuc  = new Tbl_DanhMuc();
// $tbl_nhasanxuat  = new Tbl_NhaSanXuat();
// print_r($tbl_sanpham->SelectAll());

// 04/11/2023 7:58 CH - test failed - no call db danh muc
// 04/11/2023 8:52 CH - test success - fk_sanpham_danhmuc
// 05/11/2023 9:49 CH - test failed - fk_sanpham_nhasanxuat
// $sanpham = $tbl_sanpham->SelectOne(/* $id */'48912763950');
// echo $sanpham->__toString();

// 04/11/2023 09:05 CH - test success
// $tbl_danhmuc->Insert(new DanhMuc("dm000000001", "danh mục 1", "ghi chú danh mục 1"));
// $tbl_nhasanxuat->Insert(new NhaSanXuat("nsx13254678", "NhaSanXuat 1", "Ghi chu nha san xuat"));
// $danhmuc = $tbl_danhmuc->SelectOne("dm111222333");
// $nhasanxuat = $tbl_nhasanxuat->SelectOne("nsx13254678");
// $sanpham = new SanPham("sp000000001", "san pham 1", $danhmuc, 10000, 150, $nhasanxuat);
// $tbl_sanpham->Insert($sanpham);
// Count($tbl_sanpham->getArrlist());

// 04/11/2023 09:21 CH - test update success
// echo $tbl_sanpham->SelectOne("sp000000001");

// test update - failed - 10:25SA  nhìn thấy lỗi update toàn bộ chuỗi ma ten ghi chu nhà sản xuất vào trong cột nhà sản xuất của bảng sản phẩm csdl
// test update - success - 10:32SA gọi getMa khi update nhà sản xuất
// var_dump($tbl_nhasanxuat->SelectOne("nsx13254678"));
// var_dump($tbl_danhmuc->SelectOne("dm000000001"));

// $nhasanxuat = $tbl_nhasanxuat->SelectOne("nsx13254679");
// $danhmuc = $tbl_danhmuc->SelectOne("dm111222333");

// // echo $sanpham  = $tbl_sanpham->SelectOne("sp000000001");
// $sanpham = new SanPham("sp000000001", "san pham 123123", $danhmuc, 2222, 111, $nhasanxuat);
// $tbl_sanpham->Update($sanpham);
// $sanpham1  = $tbl_sanpham->SelectOne("sp000000001");
// print_r($sanpham1);
// 04/11/2023 09:21 CH - test success
// $tbl_sanpham->Delete("sp090511222");
// try {
//     $result = $tbl_sanpham->SelectOne("sp090511222");
//     if ($tbl_sanpham->Delete("sp090511222") == 0) {
//         echo "Xóa thành công";
//     } else {
//         echo "Xóa không thành công!";
//     }
// } catch (Exception $ex) {
//     echo "Lỗi: " . $ex->getMessage();
// }
