<?php

/**
 * Lớp tbl_nhasanxuat kết nối csdl và lấy ra toàn bộ thông tin của bảng(Thao tác trước trên phpmyadmin)
 * Select $sql = $connection->prepare("SELECT * FROM tbl_nhasanxuat");
 * Insert $sql = $connection->prepare("INSERT INTO `tbl_nhasanxuat` (`ma`, `ten`, `ghichu`) VALUES ('34234234234', '234234234234', '234234234');");
 * Update $sql = $connection->prepare("UPDATE `tbl_nhasanxuat` SET `ghichu` = '2342342343423423sadfasdf' WHERE `tbl_nhasanxuat`.`ma` = '34234234234';");
 * Delete $sql = $connection->prepare("DELETE FROM `tbl_nhasanxuat` WHERE `tbl_nhasanxuat`.`ma` = '12312312331'");
 * SearchById $sql = $connection->prepare("SELECT * FROM `tbl_nhasanxuat` WHERE `ma` LIKE '12312312331'");
 * 
 */
require_once 'db.php';
require_once 'iDB.php';
require_once 'nhasanxuat.php';

class Tbl_NhaSanXuat extends DB implements iDB
{
    //member of class
    private $arrList; // list nhà sản xuất
    private $table_name;
    private $db;
    // contructor
    public function __construct()
    {
        $this->arrList = array();
        $this->table_name = 'tbl_nhasanxuat';
        $this->db = new Db(); //connect database!
    }

    // properties
    /**
     * Get the value of arrList
     */
    public function getArrListNhaSanXuat()
    {
        return $this->arrList;
    }

    /**
     * Set the value of arrList
     *
     * @return  self
     */
    public function setArrListNhaSanXuat($arrList)
    {
        $this->arrList = $arrList;

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

        //việc 4: trả về mảng danh sách các đối tượng nhà sản xuất
        foreach ($array as $key => $value/* mảng value */) {

            //4.1 Khởi tạo đối tượng NhaSanXuat với các giá trị từ mảng $value
            $nhasanxuat = new NhaSanXuat($value['ma'], $value['ten'], $value['ghichu']);

            //4.2 Thêm đối tượng NhaSanXuat vào mảng arrList
            array_push($this->arrList, $nhasanxuat);
        }

        //việc 5: ngắt kết nối câu lệnh sql // Giải phóng bộ nhớ
        $sql->close();
        return $this->arrList; //Trả về thành công
    }
    function isNullOrEmptyString($str)
    {
        return (!isset($str) || trim($str) === '');
    }

    /**
     * Lấy ra 1 nhà sản xuất
     */
    public function SelectOne($id)
    {
        // var_dump($id);
        if ($this->isNullOrEmptyString($id)) {
            return INPUT_ERROR; //-1 không tồn tại biến tham chiếu
        }

        //Việc 1: Tạo câu sql
        $sql = self::$connection->prepare("SELECT * FROM /* tbl_nhasanxuat */{$this->table_name} WHERE ma LIKE /* '2156465453' */ ?");
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
            $nhasanxuat = new NhaSanXuat($row['ma'], $row['ten'], $row['ghichu']);

            // việc 6: Giải phóng bộ nhớ
            $sql->close();
            return $nhasanxuat; // Tìm thấy nhà sản xuất;
        }
    }
    /**
     * Thêm 1 nhà sản xuất
     * return 0: success -1:null $bienThamChieu; -2 thực thi câu truy van không thành công
     * mấy cái chấm hỏi gọi là biến tham chiếu
     */
    public function Insert(/* NhaSanXuat */$bienThamChieu)
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
     * Cập nhật một nhà sản xuất 
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
     * Xóa một nhà sản xuất 
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
     * Get the value of arrList
     */ 
    public function getArrList()
    {
        return $this->arrList;
    }

    /**
     * Set the value of arrList
     *
     * @return  self
     */ 
    public function setArrList($arrList)
    {
        $this->arrList = $arrList;

        return $this;
    }
}

// unit test

// 31/10/2023 9:00 PM
// $tbl_nhasanxuat = new Tbl_NhaSanXuat();
// print_r($tbl_nhasanxuat->SelectAll());

// 31/10/2023 10:00 PM
// $nhasanxuat = $tbl_nhasanxuat->SelectOne(/* $id */'nsx13254678');
// echo $nhasanxuat->__toString();

// 31/10/2023 11:20pm
// $nhasanxuat = new NhaSanXuat("nsx13254679", "SamSung", "Ghi chú nhà sản xuất");
// $tbl_nhasanxuat->Insert($nhasanxuat);

// 31/10/2023 11:40PM
// echo $tbl_nhasanxuat->SelectOne("nsx13254678")->__toString(); //nhasanxuat so 4 ghichu danh muc4
// $nhasanxuat = new NhaSanXuat("nsx13254678", "IPhone", "Ghi chú nhà sản xuất 5");
// $tbl_nhasanxuat->Update($nhasanxuat);
// echo $tbl_nhasanxuat->SelectOne("nsx13254678")->__toString();

// 01/11/2023 00:00 SA
// $tbl_nhasanxuat->Delete("nsx13254678");
// try {
//     $result = $tbl_nhasanxuat->SelectOne("nsx13254678");
//     if ($tbl_nhasanxuat->Delete("nsx13254678") == 0) {
//         echo "Xóa thành công";
//     } else {
//         echo "Xóa không thành công!";
//     }
// } catch (Exception $ex) {
//     echo "Lỗi: " . $ex->getMessage();
// }
 