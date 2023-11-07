<?php
include_once "../controller/SanPhamController.php";
include_once "../controller/DanhMucController.php";
include_once "../controller/NhaSanXuatController.php";
$spCtrl  = new SanPhamController();
$dmCtrl  = new DanhMucController();
$nsxCtrl  = new NhaSanXuatController();
// Edit id
if (!isset($_GET['editID'])) {
    // var_dump(isset($_GET['editID']));
    throw new Exception('Không tìm thấy editID' . $_GET['editID']);
}
if (empty($_GET['editID'])) {
    throw new Exception('Không tìm thấy editID');
}
$editId = $_GET['editID'];
// print_r($list->FindById($editId));
if ($spCtrl->FindById($editId) == null) {
    throw new Exception('Không tìm thấy sản phẩm chi tiết');
}
$sanpham = $spCtrl->FindById($editId);
// echo $sanpham->getNhasanxuat()->__toString();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD SAN PHAM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="display-h1">Chi tiết sản phẩm</h1>
                <form class="form-floating" action="../controller/suaSanPham.php" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="ma" name="ma" placeholder="Mã sản phẩm" value="<?php echo $sanpham->getMa(); ?>" require="">
                        <label for="ma">Nhập mã sản phẩm</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="ten" name="ten" placeholder="Tên sản phẩm" value="<?php echo $sanpham->getTen(); ?>" require="">
                        <label for="ten">Nhập tên sản phẩm</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="danhmuc" aria-label="Default select example">
                            <?php
                            // Việc 1: Tạo danh sách danh mục mới
                            $arr = $dmCtrl->getList();
                            print_r($arr);
                            // Việc 2: Đổ dữ liệu lên listview
                            for ($i = 0; $i < Count($arr); $i++) {
                                $value = $arr[$i];
                                // var_dump($value);
                                // việc 3: chọn mặc định giá trị danh mục của sản phẩm
                                if ($value->getMa() == $sanpham->getDanhmuc()->getMa()) {
                                    echo "<option selected value='{$value->getMa()}'>{$value->getTen()}</option>";
                                } else {
                                    echo "<option value='{$value->getMa()}'>{$value->getTen()}</option>";
                                }
                            }
                            ?>
                        </select>
                        <label for="danhmuc">Chọn danh mục </label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="soluong" name="soluong" placeholder="Số lượng" value="<?php echo $sanpham->getSoluong(); ?>" require="">
                        <label for="soluong">Nhập số lượng sản phẩm</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="dongia" name="gia" placeholder="Đơn giá" value="<?php echo $sanpham->getGia(); ?>" require="">
                        <label for="dongia">Nhập đơn giá sản phẩm</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="nhasanxuat" aria-label="Default select example">
                            <?php
                            // Việc 1: Tạo danh sách danh mục mới
                            $arrr = $nsxCtrl->getList();
                            print_r($arrr);
                            // Việc 2: Đổ dữ liệu lên listview
                            for ($i = 0; $i < Count($arrr); $i++) {
                                $value = $arrr[$i];
                                // var_dump($value);
                                // việc 3: chọn mặc định giá trị danh mục của sản phẩm
                                if ($value->getMa() == $sanpham->getNhasanxuat()->getMa()) {
                                    echo "<option selected value='{$value->getMa()}'>{$value->getTen()}</option>";
                                } else {
                                    echo "<option value='{$value->getMa()}'>{$value->getTen()}</option>";
                                }
                            }
                            ?>
                        </select>
                        <label for="danhmuc">Chọn danh mục </label>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>