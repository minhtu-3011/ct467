<div class="container">
    <h2 class="text-center p-2">Quản Lý Phòng Lớp</h2>
    <div class="row">
        <div class="col-9">
            <form method="post" action="">
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="searchMaPhong" id="searchMaPhong" placeholder="Nhập mã phòng học">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                    <?php
                    if (isset($_POST['searchMaPhong']) && !empty($_POST['searchMaPhong'])) {
                        $searchMaPhong = $_POST['searchMaPhong'];
                        $conn = connectdb();
                        $sql = "SELECT * FROM phong_lop WHERE MaPhong = :MaPhong";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':MaPhong', $searchMaPhong);
                        $stmt->execute();
                        $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    ?>
                </div>
            </form>
        </div>
        <div class="col-3">
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#phongLopModal_add">Thêm Phòng Lớp</button>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Mã Phòng</th>
                        <th>Mã Lớp</th>
                        <th>Học Kỳ Năm Học</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($kq) && count($kq) > 0) {
                        foreach ($kq as $item) {
                            echo '
                                <tr>
                                    <form method="post" action="">
                                        <input type="hidden" name="MaPhong" value="' . htmlspecialchars($item['MaPhong']) . '">
                                        <td>' . htmlspecialchars($item['MaPhong']) . '</td>
                                        <td>' . htmlspecialchars($item['MaLop']) . '</td>
                                        <td>' . htmlspecialchars($item['HocKy_NamHoc']) . '</td>
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-danger btn-sm" name="delete_phong_lop" onclick="return confirm(\'Bạn có chắc chắn muốn xóa không?\');">Xóa</button>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#phongLopModal_edit' . htmlspecialchars($item['MaPhong']) . '">Sửa</button>
                                        </td>
                                    </form>
                                </tr>

                                <!-- Modal Chỉnh Sửa -->
                                <div class="modal fade" id="phongLopModal_edit' . htmlspecialchars($item['MaPhong']) . '" tabindex="-1" aria-labelledby="phongLopModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="post" action="">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Chỉnh Sửa Phòng Lớp</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="MaPhong" class="form-label">Mã Phòng:</label>
                                                        <input type="text" class="form-control" name="MaPhong" value="' . htmlspecialchars($item['MaPhong']) . '" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="MaLop" class="form-label">Mã Lớp:</label>
                                                        <input type="text" class="form-control" name="MaLop" value="' . htmlspecialchars($item['MaLop']) . '">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="HocKy_NamHoc" class="form-label">Học Kỳ Năm Học:</label>
                                                        <input type="text" class="form-control" name="HocKy_NamHoc" value="' . htmlspecialchars($item['HocKy_NamHoc']) . '">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary" name="edit_phong_lop">Lưu Thay Đổi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                    } else {
                        echo '<tr><td colspan="4" class="text-center">Không có phòng lớp nào.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Thêm Phòng Lớp -->
    <div class="modal fade" id="phongLopModal_add" tabindex="-1" aria-labelledby="phongLopModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Phòng Lớp</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="MaPhong" class="form-label">Mã Phòng</label>
                            <input type="text" class="form-control" name="MaPhong" required>
                        </div>
                        <div class="mb-3">
                            <label for="MaLop" class="form-label">Mã Lớp</label>
                            <input type="text" class="form-control" name="MaLop" required>
                        </div>
                        <div class="mb-3">
                            <label for="HocKy_NamHoc" class="form-label">Học Kỳ Năm Học</label>
                            <input type="text" class="form-control" name="HocKy_NamHoc" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary" name="add_phong_lop">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Xử lý thêm, chỉnh sửa và xóa
if (isset($_POST['add_phong_lop'])) {
    $MaPhong = $_POST['MaPhong'];
    $MaLop = $_POST['MaLop'];
    $HocKy_NamHoc = $_POST['HocKy_NamHoc'];

    $conn = connectdb();
    $sql = "INSERT INTO phong_lop (MaPhong, MaLop, HocKy_NamHoc) VALUES (:MaPhong, :MaLop, :HocKy_NamHoc)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaPhong', $MaPhong);
    $stmt->bindParam(':MaLop', $MaLop);
    $stmt->bindParam(':HocKy_NamHoc', $HocKy_NamHoc);
    $stmt->execute();

    header("Location:index.php?act=phong_lop");
    exit();
}

if (isset($_POST['edit_phong_lop'])) {
    $MaPhong = $_POST['MaPhong'];
    $MaLop = $_POST['MaLop'];
    $HocKy_NamHoc = $_POST['HocKy_NamHoc'];

    $conn = connectdb();
    $sql = "UPDATE phong_lop SET MaLop = :MaLop, HocKy_NamHoc = :HocKy_NamHoc WHERE MaPhong = :MaPhong";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaPhong', $MaPhong);
    $stmt->bindParam(':MaLop', $MaLop);
    $stmt->bindParam(':HocKy_NamHoc', $HocKy_NamHoc);
    $stmt->execute();

    header("Location:index.php?act=phong_lop");
    exit();
}

if (isset($_POST['delete_phong_lop'])) {
    $MaPhong = $_POST['MaPhong'];

    $conn = connectdb();
    $sql = "DELETE FROM phong_lop WHERE MaPhong = :MaPhong";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaPhong', $MaPhong);
    $stmt->execute();

    header("Location:index.php?act=phong_lop");
    exit();
}
?>
