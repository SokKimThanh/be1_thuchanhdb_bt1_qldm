<?php

/**
 * Lớp Danh mục quản lý danh mục gồm mã, tên, ghi chú
 * Sok Kim Thanh
 * 31/10/2023 7:32 CH
 * Sao chép: 04/11/2023 CH
 * Test processing: 04/11/2023 7:55 CH
 */

class SanPham
{
    // member of class
    private/* text(11) */ $ma; // mã danh mục
    private /* text(256) */ $ten; // tên danh mục
    private /* DanhMuc */ $danhmuc; //mã danh mục
    private /* decimal(10,0) */ $gia; // giá sản phẩm
    private /* int(10) */ $soluong; // số lượng
    private /* NhaSanXuat */ $nhasanxuat; //nhà sản xuất
    //constructor
    public function __construct($ma = "", $ten = "", $danhmuc = null/* Quan hệ aggregation */, $gia = 0, $soluong = 0, $nhasanxuat = null/* Quan hệ aggregation */)
    {
        if (strlen($ma) != 11) {
            echo strlen($ma);
            throw new Exception("Mã Sản phẩm không hợp lệ.");
        }
        // if (strlen($ten) == 0) {
        //     echo strlen($ten);
        //     throw new Exception("Tên sản phẩm không được phép để trống");
        // }
        if (strlen($ten) > 256) {
            echo strlen($ten);
            throw new Exception("Tên sản phẩm không hợp lệ.");
        }
        if ($gia < 0/* 2ty450 đồng */) {
            throw new Exception("Giá sản phẩm không hợp lệ.");
        }
        if ($gia > 2540000000000/* 2ty450 đồng */) {
            throw new Exception("Giá sản phẩm không hợp lệ.");
        }
        if ($soluong < 0) {
            throw new Exception("số lượng < 0");
        }
        if ($soluong > 300) {
            throw new Exception("số lượng > 300");
        }

        $this->ma = $ma;/* text(11) 11 ký tự số chuỗi */
        $this->ten = $ten;
        $this->danhmuc = $danhmuc;
        $this->gia = $gia;
        $this->soluong = $soluong;
        $this->nhasanxuat = $nhasanxuat;
    }

    //tostring
    public function __toString()
    {
        if ($this->danhmuc == null) {
            throw new Exception("danh mục null");
        }
        if ($this->nhasanxuat == null) {
            throw new Exception("nhasanxuat null");
        }
        return $this->ma . " " . $this->ten . " " . $this->danhmuc->__toString() . " " . $this->gia . " " . $this->soluong . " " . $this->nhasanxuat->__toString();
    }

    /**
     * Get the value of ma
     */
    public function getMa()
    {
        return $this->ma;
    }

    /**
     * Set the value of ma
     *
     * @return  self
     */
    public function setMa($ma)
    {
        if (strlen($ma) != 11) {
            throw new Exception("MA không hợp lệ.");
        }
        $this->ma = $ma;

        return $this;
    }

    /**
     * Get the value of ten
     */
    public function getTen()
    {
        return $this->ten;
    }

    /**
     * Set the value of ten
     *
     * @return  self
     */
    public function setTen($ten)
    {
        if (strlen($ten) == 0) {
            echo strlen($ten);
            throw new Exception("Tên sản phẩm không được phép để trống");
        }
        if (strlen($ten) > 256) {
            echo strlen($ten);
            throw new Exception("Tên sản phẩm không hợp lệ.");
        }
        $this->ten = $ten;

        return $this;
    }

    /**
     * Get the value of danhmuc
     */
    public function getDanhmuc()
    {
        return $this->danhmuc;
    }

    /**
     * Set the value of danhmuc
     *
     * @return  self
     */
    public function setDanhmuc($danhmuc)
    {
        $this->danhmuc = $danhmuc;

        return $this;
    }

    /**
     * Get the value of gia
     */
    public function getGia()
    {
        return $this->gia;
    }

    /**
     * Set the value of gia
     *
     * @return  self
     */
    public function setGia($gia)
    {
        if ($gia < 0/* âm đồng */) {
            throw new Exception("gia không hợp lệ.");
        }
        if ($gia > 2540000000000/* 2ty450 đồng */) {
            throw new Exception("gia không hợp lệ.");
        }
        $this->gia = $gia;

        return $this;
    }

    /**
     * Get the value of soluong
     */
    public function getSoluong()
    {
        return $this->soluong;
    }

    /**
     * Set the value of soluong
     *
     * @return  self
     */
    public function setSoluong($soluong)
    {
        if ($soluong < 0) {
            throw new Exception("soluong không hợp lệ.");
        }
        if ($soluong > 300) {
            throw new Exception("soluong không hợp lệ.");
        }
        $this->soluong = $soluong;

        return $this;
    }

    /**
     * Get the value of nhasanxuat
     */
    public function getNhasanxuat()
    {
        return $this->nhasanxuat;
    }

    /**
     * Set the value of nhasanxuat
     *
     * @return  self
     */
    public function setNhasanxuat($nhasanxuat)
    {

        $this->nhasanxuat = $nhasanxuat;

        return $this;
    }
}

// include 'danhmuc.php';
// include 'nhasanxuat.php';
// $sanpham1 = new SanPham("sp000000001", "san pham 1", new DanhMuc("dm000000001", "danh mục 1", "ghi chú danh mục 1"), 10000, 150, new NhaSanXuat("nsx13254678", "NhaSanXuat 1", "Ghi chu nha san xuat"));
// echo $sanpham1->__toString();
// echo $sanpham1->getNhasanxuat()->getMa();
