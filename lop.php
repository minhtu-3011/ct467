<div class="container">
    <h2 class="text-center p-2">Quản Lý Lớp</h2>
    <div class="row">
        <div class="col-9">
            <form method="post" action="">
                <div class="mb-3">
                    <div class="input-group">

                        <input type="text" class="form-control" name="searchMaLop" id="searchMaLop" placeholder="Nhập mã lớp">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                    <!-- Kiểm tra nếu có yêu cầu tìm kiếm -->
                    <?php
                    if (isset($_POST['searchMaLop']) && !empty($_POST['searchMaLop'])) {
                        $searchMaLop = $_POST['searchMaLop'];

                        // Kết nối đến cơ sở dữ liệu
                        $conn = connectdb();

                        // Câu lệnh SQL tìm kiếm
                        $sql = "SELECT * FROM lop WHERE MaLop = :MaLop";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':MaLop', $searchMaLop);
                        $stmt->execute();

                        // Lấy kết quả
                        $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    ?>
                </div>

            </form>

        </div>
        <div class="col-3">
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#classModal_add">Thêm Lớp</button>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>MaLop</th>
                        <th>TenLop</th>
                        <th>NienKhoa</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    if (count($kq) > 0) {
                        foreach ($kq as $pd) {
                            echo '
                                <tr>
                                    <form method="post" action="">
                                        <input type="hidden" name="MaLop" value="' . $pd['MaLop'] . '">
                                        <td>' . $pd['MaLop'] . '</td>
                                        <td>' . $pd['TenLop'] . '</td>
                                        <td>' . $pd['NienKhoa'] . '</td>
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-danger btn-sm" name="delete_lop" onclick="return confirm(\'Bạn có chắc chắn muốn xóa lớp này?\');">Xóa</button>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#classModal_edit' . $pd['MaLop'] . '">Sửa</button>
                                        </td>
                                    </form>
                                </tr>

                                <!-- Modal Chỉnh Sửa -->
                                <div class="modal fade" id="classModal_edit' . $pd['MaLop'] . '" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="post" action="">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="classModalLabel">Chỉnh Sửa Lớp: ' . $pd['TenLop'] . '</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    
                                                    <div class="mb-3">
                                                        <label for="TenLop" class="form-label">Mã lớp:</label>
                                                        <input type="text" class="form-control" name="MaLop" value="' . $pd['MaLop'] . '"readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="TenLop" class="form-label">Tên Lớp:</label>
                                                        <input type="text" class="form-control" name="TenLop" value="' . $pd['TenLop'] . '">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="NienKhoa" class="form-label">Niên Khóa:</label>
                                                        <input type="text" class="form-control" name="NienKhoa" value="' . $pd['NienKhoa'] . '">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary" name="edit_lop">Lưu Thay Đổi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                    } else {
                        echo '<tr><td colspan="4" class="text-center">Không có lớp nào.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal thêm lớp -->
    <div class="modal fade" id="classModal_add" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="classModalLabel">Thêm Lớp</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="maLop" class="form-label">MaLop</label>
                            <input type="text" class="form-control" name="MaLop" required>
                        </div>
                        <div class="mb-3">
                            <label for="tenLop" class="form-label">TenLop</label>
                            <input type="text" class="form-control" name="TenLop" required>
                        </div>
                        <div class="mb-3">
                            <label for="nienKhoa" class="form-label">NienKhoa</label>
                            <input type="text" class="form-control" name="NienKhoa" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary" name="add_lop">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


<?php
if (isset($_POST['add_lop'])) {
    $conn = connectdb();  // Kết nối tới cơ sở dữ liệu
    $malop = $_POST['MaLop'];
    $tenlop = $_POST['TenLop'];
    $nienkhoa = $_POST['NienKhoa'];

    // Sử dụng câu lệnh chuẩn bị
    $query = "INSERT INTO lop (MaLop, TenLop, NienKhoa) VALUES (:malop, :tenlop, :nienkhoa)";
    $stmt = $conn->prepare($query);

    // Ràng buộc các tham số
    $stmt->bindParam(':malop', $malop);
    $stmt->bindParam(':tenlop', $tenlop);
    $stmt->bindParam(':nienkhoa', $nienkhoa);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Thêm lớp thành công!";
        header("Location: index.php?act=lop");
        exit(); // Thoát ngay sau khi chuyển hướng
    } else {
        $_SESSION['error_message'] = "Có lỗi xảy ra trong quá trình thêm lớp.";
        header("Location: index.php?act=lop");
        exit(); // Thoát ngay sau khi chuyển hướng
    }
}

if (isset($_POST['edit_lop'])) {
    $conn = connectdb(); // Kết nối đến cơ sở dữ liệu
    $MaLop = $_POST['MaLop'];
    $TenLop = $_POST['TenLop'];
    $NienKhoa = $_POST['NienKhoa'];

    $sql = "UPDATE lop SET TenLop = :TenLop, NienKhoa = :NienKhoa WHERE MaLop = :MaLop";
    $stmt = $conn->prepare($sql);

    // Liên kết tham số
    $stmt->bindParam(':MaLop', $MaLop);
    $stmt->bindParam(':TenLop', $TenLop);
    $stmt->bindParam(':NienKhoa', $NienKhoa);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Cập nhật lớp thành công!";
        header("Location: index.php?act=lop");
        exit(); // Thoát ngay sau khi chuyển hướng
    } else {
        $_SESSION['error_message'] = "Có lỗi xảy ra trong quá trình cập nhật.";
        header("Location: index.php?act=lop");
        exit(); // Thoát ngay sau khi chuyển hướng
    }
}


if (isset($_POST['delete_lop'])) {
    $conn = connectdb(); // Kết nối đến cơ sở dữ liệu
    $MaLop = $_POST['MaLop']; // Lấy mã lớp từ form

    $sql = "DELETE FROM lop WHERE MaLop = :MaLop";
    $stmt = $conn->prepare($sql);

    // Liên kết tham số
    $stmt->bindParam(':MaLop', $MaLop);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Xoá lớp thành công!";
        header("Location: index.php?act=lop");
        exit(); // Thoát ngay sau khi chuyển hướng
    } else {
        $_SESSION['error_message'] = "Có lỗi xảy ra trong quá trình Xoá lớp.";
        header("Location: index.php?act=lop");
        exit(); // Thoát ngay sau khi chuyển hướng
    }
}

// Xử lý cập nhật thông tin lớp
if (isset($_POST['edit_lop'])) {
    $MaLop = $_POST['MaLop'];
    $TenLop = $_POST['TenLop'];
    $NienKhoa = $_POST['NienKhoa'];

    $sql = "UPDATE lop SET TenLop = :TenLop, NienKhoa = :NienKhoa WHERE MaLop = :MaLop";
    $stmt = $conn->prepare($sql);

    // Liên kết tham số
    $stmt->bindParam(':MaLop', $MaLop);
    $stmt->bindParam(':TenLop', $TenLop);
    $stmt->bindParam(':NienKhoa', $NienKhoa);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Cập nhật lớp thành công!";
        header("Location: index.php?act=lop");
        exit();
    } else {
        $_SESSION['error_message'] = "Có lỗi xảy ra trong quá trình cập nhật.";
        header("Location: index.php?act=lop");
        exit();
    }
}


?>