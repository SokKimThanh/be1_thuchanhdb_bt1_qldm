<?php

/**
 * Sok Kim Thanh
 * Sao chép: 04/11/2023 CH
 */
include_once '../controller/DanhMucController.php';
$list = new DanhMucController();
// Edit id
if (isset($_GET['editID']) && !empty($_GET['editID'])) {
    $editId = $_GET['editID'];
    // print_r($list->FindById($editId));
    if ($list->FindById($editId) != null) {
        $danhmuc = $list->FindById($editId);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD DANH MUC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="display-h1">Chi tiết danh mục</h1>
                <form class="form-floating" action="../controller/suaDanhMuc.php" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="txtMaDanhMuc" name="ma" maxlength="11" minlength="11" placeholder="Mã danh mục" value="<?php echo $danhmuc->getMa(); ?>" require="">
                        <label for="txtMaDanhMuc">Nhập mã danh mục</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="txtTenDanhMuc" name="ten" placeholder="Tên danh mục" value="<?php echo $danhmuc->getTen(); ?>" require="">
                        <label for="txtTenDanhMuc">Nhập tên danh mục</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea type="text" class="form-control" id="txtGhiChuDanhMuc" name="ghichu" placeholder="Ghi chú danh mục" require=""><?php echo $danhmuc->getGhichu() ?></textarea>
                        <label for="txtGhiChuDanhMuc">Nhập ghi chú danh mục</label>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>