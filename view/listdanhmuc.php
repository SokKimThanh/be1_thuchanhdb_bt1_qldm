<?php
include_once "../controller/DanhMucController.php";
// list
$list = new DanhMucController();
if (!is_array($list->getList())) {
    echo "<h1>Không tìm thấy danh sách danh mục</h1>";
    return;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
</head>

<body>
    <?php
     if (isset($_GET['msg1']) == "insert") {
        echo "<div class='alert alert-success alert-dismissible' role='alert'>
        Record ADDED successfully
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      </div>";
    }
    if (isset($_GET['msg2']) == "update") {
        echo "<div class='alert alert-success alert-dismissible' role='alert'>
        Record UPDATED successfully
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      </div>";
    }
    if (isset($_GET['msg3']) == "delete") {
        echo "<div class='alert alert-success alert-dismissible' role='alert'>
        Record DELETED successfully
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      </div>";
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="display-h1">Thêm danh mục</h1>
                <form class="form-floating" action="../controller/themDanhMuc.php" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="txtAddMa" name="ma" placeholder="Mã danh mục" value="<?php echo $list->GUI() ?>" require="">
                        <label for="txtAddMa">Nhập mã danh mục</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="txtTenDanhMuc" name="ten" placeholder="Tên danh mục" value="" require="">
                        <label for="txtTenDanhMuc">Nhập tên danh mục</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea type="text" class="form-control" id="txtGhiChuDanhMuc" name="ghichu" placeholder="Ghi chú danh mục" require=""></textarea>
                        <label for="txtGhiChuDanhMuc">Nhập ghi chú danh mục</label>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h1 class="display-h1">Quản lý danh mục</h1>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mã</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Ghi chú</th>
                            <th scope="col" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $arr = $list->getList();
                        // print_r($arr);
                        // var_dump(Count($arr));
                        for ($i = 0; $i < Count($arr); $i++) {
                            $value = $arr[$i];
                            $stt = $i + 1;
                            echo    "<tr>
                                        <th scope='row'>{$stt}</th>
                                        <td>{$value->getMa()}</td>
                                        <td>{$value->getTen()}</td>
                                        <td>{$value->getGhiChu()}</td>";
                        ?>
                            <td class="text-center">
                                <a class="m-3 btn btn-warning" href=<?php echo "detaildanhmuc.php?editID={$value->getMa()}" ?>><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a class='m-3 btn btn-danger' href="../controller/xoaDanhMuc.php?deleteID=<?php echo "{$value->getMa()}" ?>" onclick="confirm('ban chac chan muon xoa?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        <?php
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>