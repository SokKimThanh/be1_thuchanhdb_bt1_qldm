<?php

/**
 * Sok Kim Thanh
 * Sao chép: 04/11/2023 CH
 */
include_once '../controller/NhaSanXuatController.php';
$list = new NhaSanXuatController();
// Edit id
if (isset($_GET['editID']) && !empty($_GET['editID'])) {
    $editId = $_GET['editID'];
    // print_r($list->FindById($editId));
    if ($list->FindById($editId) != null) {
        $nhasanxuat = $list->FindById($editId);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD NHA SAN XUAT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="display-h1">Chi tiết nhà sản xuất</h1>
                <form class="form-floating" action="../controller/suaNhaSanXuat.php" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="txtMaNhaSanXuat" name="ma" maxlength="11" minlength="11" placeholder="Mã nhà sản xuất" value="<?php echo $nhasanxuat->getMa(); ?>" require="">
                        <label for="txtMaNhaSanXuat">Nhập mã nhà sản xuất</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="txtTenNhaSanXuat" name="ten" placeholder="Tên nhà sản xuất" value="<?php echo $nhasanxuat->getTen(); ?>" require="">
                        <label for="txtTenNhaSanXuat">Nhập tên nhà sản xuất</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea type="text" class="form-control" id="txtGhiChuNhaSanXuat" name="ghichu" placeholder="Ghi chú nhà sản xuất" require=""><?php echo $nhasanxuat->getGhichu() ?></textarea>
                        <label for="txtGhiChuNhaSanXuat">Nhập ghi chú nhà sản xuất</label>
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