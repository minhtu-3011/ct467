<div class="container">
    <h2 class="text-center p-2">Quản Lý Giáo Viên</h2>
    <div class="row">
        <div class="col-9">
            <form method="post" action="">
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="searchMaGV" id="searchMaGV" placeholder="Nhập mã giáo viên">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                    <?php
                    if (isset($_POST['searchMaGV']) && !empty($_POST['searchMaGV'])) {
                        $searchMaGV = $_POST['searchMaGV'];
                        $conn = connectdb();
                        $sql = "SELECT * FROM giaovien WHERE MaGV = :MaGV";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':MaGV', $searchMaGV);
                        $stmt->execute();
                        $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    ?>
                </div>
            </form>
        </div>
        <div class="col-3">
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#teacherModal_add">Thêm Giáo Viên</button>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>MaGV</th>
                        <th>Họ Tên</th>
                        <th>Ngày Sinh</th>
                        <th>Địa Chỉ</th>
                        <th>Số Điện Thoại</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($kq) > 0) {
                        foreach ($kq as $gv) {
                            echo '
                                <tr>
                                    <form method="post" action="">
                                        <input type="hidden" name="MaGV" value="' . $gv['MaGV'] . '">
                                        <td>' . $gv['MaGV'] . '</td>
                                        <td>' . $gv['HoTen'] . '</td>
                                        <td>' . $gv['NgaySinh'] . '</td>
                                        <td>' . $gv['DiaChi'] . '</td>
                                        <td>' . $gv['SoDienThoai'] . '</td>
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-danger btn-sm" name="delete_gv" onclick="return confirm(\'Bạn có chắc chắn muốn xóa giáo viên này?\');">Xóa</button>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#teacherModal_edit' . $gv['MaGV'] . '">Sửa</button>
                                        </td>
                                    </form>
                                </tr>
                                <!-- Modal Chỉnh Sửa -->
                                <div class="modal fade" id="teacherModal_edit' . $gv['MaGV'] . '" tabindex="-1" aria-labelledby="teacherModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="post" action="">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="teacherModalLabel">Chỉnh Sửa Giáo Viên: ' . $gv['HoTen'] . '</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="MaGV" class="form-label">Mã Giáo Viên:</label>
                                                        <input type="text" class="form-control" name="MaGV" value="' . $gv['MaGV'] . '" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="HoTen" class="form-label">Họ Tên:</label>
                                                        <input type="text" class="form-control" name="HoTen" value="' . $gv['HoTen'] . '" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="NgaySinh" class="form-label">Ngày Sinh:</label>
                                                        <input type="date" class="form-control" name="NgaySinh" value="' . $gv['NgaySinh'] . '" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="DiaChi" class="form-label">Địa Chỉ:</label>
                                                        <input type="text" class="form-control" name="DiaChi" value="' . $gv['DiaChi'] . '" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="SoDienThoai" class="form-label">Số Điện Thoại:</label>
                                                        <input type="text" class="form-control" name="SoDienThoai" value="' . $gv['SoDienThoai'] . '" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary" name="edit_gv">Lưu Thay Đổi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                    } else {
                        echo '<tr><td colspan="6" class="text-center">Không có giáo viên nào.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal thêm giáo viên -->
    <div class="modal fade" id="teacherModal_add" tabindex="-1" aria-labelledby="teacherModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teacherModalLabel">Thêm Giáo Viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="MaGV" class="form-label">Mã Giáo Viên</label>
                            <input type="text" class="form-control" name="MaGV" required>
                        </div>
                        <div class="mb-3">
                            <label for="HoTen" class="form-label">Họ Tên</label>
                            <input type="text" class="form-control" name="HoTen" required>
                        </div>
                        <div class="mb-3">
                            <label for="NgaySinh" class="form-label">Ngày Sinh</label>
                            <input type="date" class="form-control" name="NgaySinh" required>
                        </div>
                        <div class="mb-3">
                            <label for="DiaChi" class="form-label">Địa Chỉ</label>
                            <input type="text" class="form-control" name="DiaChi" required>
                        </div>
                        <div class="mb-3">
                            <label for="SoDienThoai" class="form-label">Số Điện Thoại</label>
                            <input type="text" class="form-control" name="SoDienThoai" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary" name="add_gv">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


<?php
if (isset($_POST['add_gv'])) {
    $conn = connectdb();
    $maGV = $_POST['MaGV'];
    $hoTen = $_POST['HoTen'];
    $ngaySinh = $_POST['NgaySinh'];
    $diaChi = $_POST['DiaChi'];
    $soDienThoai = $_POST['SoDienThoai'];

    $query = "INSERT INTO giaovien (MaGV, HoTen, NgaySinh, DiaChi, SoDienThoai) VALUES (:maGV, :hoTen, :ngaySinh, :diaChi, :soDienThoai)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':maGV', $maGV);
    $stmt->bindParam(':hoTen', $hoTen);
    $stmt->bindParam(':ngaySinh', $ngaySinh);
    $stmt->bindParam(':diaChi', $diaChi);
    $stmt->bindParam(':soDienThoai', $soDienThoai);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Thêm giáo viên thành công!";
        header("Location: index.php?act=giaovien");
        exit();
    } else {
        $_SESSION['error_message'] = "Có lỗi xảy ra trong quá trình thêm giáo viên.";
        header("Location: index.php?act=giaovien");
        exit();
    }
}

if (isset($_POST['edit_gv'])) {
    $conn = connectdb();
    $maGV = $_POST['MaGV'];
    $hoTen = $_POST['HoTen'];
    $ngaySinh = $_POST['NgaySinh'];
    $diaChi = $_POST['DiaChi'];
    $soDienThoai = $_POST['SoDienThoai'];

    $query = "UPDATE giaovien SET HoTen = :hoTen, NgaySinh = :ngaySinh, DiaChi = :diaChi, SoDienThoai = :soDienThoai WHERE MaGV = :maGV";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':maGV', $maGV);
    $stmt->bindParam(':hoTen', $hoTen);
    $stmt->bindParam(':ngaySinh', $ngaySinh);
    $stmt->bindParam(':diaChi', $diaChi);
    $stmt->bindParam(':soDienThoai', $soDienThoai);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Cập nhật giáo viên thành công!";
        header("Location: index.php?act=giaovien");
        exit();
    } else {
        $_SESSION['error_message'] = "Có lỗi xảy ra trong quá trình cập nhật giáo viên.";
        header("Location: index.php?act=giaovien");
        exit();
    }
}

if (isset($_POST['delete_gv'])) {
    $conn = connectdb();
    $maGV = $_POST['MaGV'];

    $sql = "DELETE FROM giaovien WHERE MaGV = :MaGV";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaGV', $maGV);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Xóa giáo viên thành công!";
        header("Location: index.php?act=giaovien");
        exit();
    } else {
        $_SESSION['error_message'] = "Có lỗi xảy ra trong quá trình xóa giáo viên.";
        header("Location: index.php?act=giaovien");
        exit();
    }
}
