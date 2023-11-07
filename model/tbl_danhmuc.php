<?php

/**
 * Lớp tbl_danhmuc kết nối csdl và lấy ra toàn bộ thông tin của bảng(Thao tác trước trên phpmyadmin)
 * Select $sql = $connection->prepare("SELECT * FROM tbl_danhmuc");
 * Insert $sql = $connection->prepare("INSERT INTO `tbl_danhmuc` (`ma`, `ten`, `ghichu`) VALUES ('34234234234', '234234234234', '234234234');");
 * Update $sql = $connection->prepare("UPDATE `tbl_danhmuc` SET `ghichu` = '2342342343423423sadfasdf' WHERE `tbl_danhmuc`.`ma` = '34234234234';");
 * Delete $sql = $connection->prepare("DELETE FROM `tbl_danhmuc` WHERE `tbl_danhmuc`.`ma` = '12312312331'");
 * SearchById $sql = $connection->prepare("SELECT * FROM `tbl_danhmuc` WHERE `ma` LIKE '12312312331'");
 * 
 */
require_once 'db.php';
require_once 'iDB.php';
require_once 'danhmuc.php';

class Tbl_DanhMuc extends DB implements iDB
{
    //member of class
    private $arrListDanhMuc;
    private $table_name;
    private $db;
    // contructor
    public function __construct()
    {
        $this->arrListDanhMuc = array();
        $this->table_name = 'tbl_danhmuc';
        $this->db = new Db(); //connect database!
    }

    // properties
    /**
     * Get the value of arrListDanhMuc
     */
    public function getArrListDanhMuc()
    {
        return $this->arrListDanhMuc;
    }

    /**
     * Set the value of arrListDanhMuc
     *
     * @return  self
     */
    public function setArrListDanhMuc($arrListDanhMuc)
    {
        $this->arrListDanhMuc = $arrListDanhMuc;

        return $this;
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

        //việc 4: trả về mảng danh sách các đối tượng danh mục
        foreach ($array as $key => $value/* mảng value */) {

            //4.1 Khởi tạo đối tượng DanhMuc với các giá trị từ mảng $value
            $danhmuc = new DanhMuc($value['ma'], $value['ten'], $value['ghichu']);

            //4.2 Thêm đối tượng DanhMuc vào mảng arrListDanhMuc
            array_push($this->arrListDanhMuc, $danhmuc);
        }

        //việc 5: ngắt kết nối câu lệnh sql // Giải phóng bộ nhớ
        $sql->close();
        return $this->arrListDanhMuc; //Trả về thành công
    }
    function isNullOrEmptyString($str)
    {
        return (!isset($str) || trim($str) === '');
    }

    /**
     * Lấy ra 1 danh mục
     */
    public function SelectOne($id)
    {
        // var_dump($id);
        if ($this->isNullOrEmptyString($id)) {
            return INPUT_ERROR; //-1 không tồn tại biến tham chiếu
        }

        //Việc 1: Tạo câu sql
        $sql = self::$connection->prepare("SELECT * FROM /* tbl_danhmuc */{$this->table_name} WHERE ma LIKE /* '2156465453' */ ?");
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
        $row = $sql->get_result()->fetch_assoc();
        if ($row == null) {
            // throw new Exception("ID không tồn tại trong cơ sở dữ liệu.");
            $sql->close();
            return SELECT_ERROR; //-3 không tồn tại id
        } else {
            // việc 5: Tạo một đối tượng để chứa giá trị 
            $danhmuc = new DanhMuc($row['ma'], $row['ten'], $row['ghichu']);

            // việc 6: Giải phóng bộ nhớ
            $sql->close();
            return $danhmuc; // Tìm thấy danh mục;
        }
    }
    /**
     * Thêm 1 danh mục
     * return 0: success -1:null $bienThamChieu; -2 thực thi câu truy van không thành công
     * mấy cái chấm hỏi gọi là biến tham chiếu
     */
    public function Insert(/* DanhMuc */$bienThamChieu)
    {
        if ($this->isNullOrEmptyString($bienThamChieu)) {
            return INPUT_ERROR;/* -1 Không tồn tại tham chiếu */
        }

        // việc 0: bắt lỗi nhập trùng id
        $ma = $bienThamChieu->getMa();
        if ($this->SelectOne($ma) != null/*Không trùng id */) {
            // Việc 1: Tạo câu truy vấn Sql
            $sql = self::$connection->prepare("INSERT INTO {$this->table_name} VALUES (/* '2156465453' */?,/*  'Sản phẩm' */?, /* 'Danh mục sản phẩm' */?)");

            // Việc 1.1 Tạo biến để gán vào chấm hỏi   (ghi chú: hàm bind_param chỉ chấp nhận biến tham chiếu)

            $ten = $bienThamChieu->getTen();
            $ghichu = $bienThamChieu->getGhichu();

            // Việc 2: Thêm param
            $sql->bind_param("sss", $ma, $ten, $ghichu);

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
     * Cập nhật một danh mục 
     */
    public function Update($bienThamChieu)
    {
        if ($this->isNullOrEmptyString($bienThamChieu)) {
            return INPUT_ERROR;/* Không tồn tại tham chiếu */
        }


        // Việc 1: Tạo câu truy vấn Sql
        $sql = self::$connection->prepare("UPDATE {$this->table_name} SET ten = /* 'Sản phẩm aaa' */?, ghichu = /* Sản phẩm bbbb */ ? WHERE {$this->table_name}.ma = /* '2156465453' */?");

        // Việc 1.1 Tạo biến để gán vào chấm hỏi   (ghi chú: hàm bind_param chỉ chấp nhận biến tham chiếu)
        $ma = $bienThamChieu->getMa();
        $ten = $bienThamChieu->getTen();
        $ghichu = $bienThamChieu->getGhichu();

        // Việc 2: Thêm param
        $sql->bind_param("sss", $ten, $ghichu, $ma);

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
     * Xóa một danh mục 
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
}

// unit test

// 31/10/2023 9:00 PM
// $tbl_danhmuc = new Tbl_DanhMuc();
// print_r($tbl_danhmuc->SelectAll());

// 31/10/2023 10:00 PM
// $danhmuc = $tbl_danhmuc->SelectOne(/* $id */'2156465453');
// echo $danhmuc->__toString();

// 31/10/2023 11:20pm
// $danhmuc = new DanhMuc("1234567895", "Danh mục số 3", "Ghi chú danh mục");
// $tbl_danhmuc->Insert($danhmuc);

// 31/10/2023 11:40PM
// echo $tbl_danhmuc->SelectOne("1234567895")->__toString(); //danhmuc so 4 ghichu danh muc4
// $danhmuc = new DanhMuc("1234567895", "Danh mục số 5", "Ghi chú danh mục 5");
// $tbl_danhmuc->Update($danhmuc);
// echo $tbl_danhmuc->SelectOne("1234567895")->__toString();

// 01/11/2023 00:00 SA
// $tbl_danhmuc->Delete("1234567895");
// try {
//     $result = $tbl_danhmuc->SelectOne("1234567895");
//     if ($tbl_danhmuc->Delete("sfa") == 0) {
//         echo "Xóa thành công";
//     } else {
//         echo "Xóa không thành công!";
//     }
// } catch (Exception $ex) {
//     echo "Lỗi: " . $ex->getMessage();
// }
