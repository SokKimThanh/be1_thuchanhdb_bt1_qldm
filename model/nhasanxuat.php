<?php

/**
 * Lớp Danh mục quản lý nhà sản xuất gồm mã, tên, ghi chú
 * Sok Kim Thanh
 * 31/10/2023 7:32 CH
 * Sao chép 05/11/2023 5:25 SA
 */
class NhaSanXuat
{
    // member of class
    private/* text(11) */ $ma; // mã nhà sản xuất
    private /* text(256) */ $ten; // tên nhà sản xuất
    private /* text(256) */ $ghichu; //ghi chú nhà sản xuất

    //constructor
    public function __construct($ma = "", $ten = "", $ghichu = "")
    {
        if (strlen($ma) != 11) {
            throw new Exception("Mã nhà sản xuất không hợp lệ.");
        }
        if (strlen($ten) == 0) {
            echo strlen($ten);
            throw new Exception("Tên nhà sản xuất không được phép để trống");
        }
        if (strlen($ten) > 256) {
            throw new Exception("Tên nhà sản xuất không hợp lệ.");
        }
        if (strlen($ghichu) > 256) {
            throw new Exception("Ghi chú nhà sản xuất không hợp lệ.");
        }
        $this->ma = $ma;/* text(11) 11 ký tự số chuỗi */
        $this->ten = $ten;
        $this->ghichu = $ghichu;
    }

    //tostring
    public function __toString()
    {
        return $this->ma . " " . $this->ten . " " . $this->ghichu;
    }

    /**
     * Get the value of ma
     */
    public function getMa()
    {
        return $this->ma;
    }

    // /**
    //  * Set the value of ma
    //  *
    //  * @return  self
    //  */
    // public function setMa($ma)
    // {
    //     $this->ma = $ma;

    //     return $this;
    // }

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
        if (strlen($ten) > 256) {
            throw new Exception("TEN không hợp lệ.");
        }
        $this->ten = $ten;

        return $this;
    }

    /**
     * Get the value of ghichu
     */
    public function getGhichu()
    {
        return $this->ghichu;
    }

    /**
     * Set the value of ghichu
     *
     * @return  self
     */
    public function setGhichu($ghichu)
    {
        if (strlen($ghichu) > 256) {
            throw new Exception("TEN không hợp lệ.");
        }
        $this->ghichu = $ghichu;
        return $this;
    }
}
// $nhasanxuat = new NhaSanXuat("nsx13254678", "san pham 1", "Sản phẩm 1");
// echo $nhasanxuat->__toString();
