<div class="container">
    <h2 class="text-center p-2">Quản Lý Chủ Nhiệm</h2>
    <div class="row">
        <div class="col-9">
            <form method="post" action="">
                <div class="mb-3 mt-4">
                    <div class="input-group">
                        <input type="text" class="form-control" name="searchMaGV" placeholder="Nhập mã giáo viên">
                        <input type="text" class="form-control" name="searchMaLop" placeholder="Nhập mã lớp">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>


                    </div>
                    <?php

                    // Tìm kiếm theo MaGV và MaLop
                    if (isset($_POST['searchMaGV']) || isset($_POST['searchMaLop'])) {
                        $kq = [];
                        $searchMaGV = $_POST['searchMaGV'] ?? '';
                        $searchMaLop = $_POST['searchMaLop'] ?? '';

                        // Thêm ký tự đại diện % cho tìm kiếm
                        $searchMaGV = '%' . $searchMaGV . '%';
                        $searchMaLop = '%' . $searchMaLop . '%';

                        $conn = connectdb();
                        $sql = "SELECT * FROM chunhiem WHERE MaGV LIKE :MaGV AND MaLop LIKE :MaLop";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':MaGV', $searchMaGV);
                        $stmt->bindParam(':MaLop', $searchMaLop);
                        $stmt->execute();
                        $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }

                    ?>
                </div>
            </form>
        </div>
        <div class="col-3 mt-4">
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#addChunhiemModal">Thêm Chủ Nhiệm</button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Mã GV</th>
                        <th>Mã Lớp</th>
                        <th>Năm Học</th>
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
                                        <input type="hidden" name="MaGV" value="' . $pd['MaGV'] . '">
                                        <input type="hidden" name="MaLop" value="' . $pd['MaLop'] . '">
                                        <input type="hidden" name="NamHoc" value="' . $pd['NamHoc'] . '">
                                        <td>' . $pd['MaGV'] . '</td>
                                        <td>' . $pd['MaLop'] . '</td>
                                        <td>' . $pd['NamHoc'] . '</td>
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-danger btn-sm" name="delete_chunhiem" onclick="return confirm(\'Bạn có chắc chắn muốn xóa chủ nhiệm này?\');">Xóa</button>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editChunhiemModal' . $pd['MaGV'] . '">Sửa</button>
                                        </td>
                                    </form>
                                </tr>

                                <!-- Modal Sửa Chủ Nhiệm -->
                                <div class="modal fade" id="editChunhiemModal' . $pd['MaGV'] . '" tabindex="-1" aria-labelledby="editChunhiemModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="post" action="">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editChunhiemModalLabel">Chỉnh Sửa Chủ Nhiệm: ' . $pd['MaGV'] . '</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="MaLop" class="form-label">Mã lớp:</label>
                                                        <input type="text" class="form-control" name="MaLop" value="' . $pd['MaLop'] . '" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="NamHoc" class="form-label">Năm học:</label>
                                                        <input type="text" class="form-control" name="NamHoc" value="' . $pd['NamHoc'] . '" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary" name="edit_chunhiem">Lưu Thay Đổi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                    } else {
                        echo '<tr><td colspan="4" class="text-center">Không có chủ nhiệm nào.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Thêm Chủ Nhiệm -->
    <div class="modal fade" id="addChunhiemModal" tabindex="-1" aria-labelledby="addChunhiemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addChunhiemModalLabel">Thêm Chủ Nhiệm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="MaGV" class="form-label">Mã giáo viên:</label>
                            <input type="text" class="form-control" name="MaGV" required>
                        </div>
                        <div class="mb-3">
                            <label for="MaLop" class="form-label">Mã lớp:</label>
                            <input type="text" class="form-control" name="MaLop" required>
                        </div>
                        <div class="mb-3">
                            <label for="NamHoc" class="form-label">Năm học:</label>
                            <input type="text" class="form-control" name="NamHoc" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" name="add_chunhiem">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php
// Thêm chủ nhiệm
if (isset($_POST['add_chunhiem'])) {
    $conn = connectdb();
    $MaGV = $_POST['MaGV'];
    // Kiểm tra gv
    $sql = "SELECT COUNT(*) FROM giaovien WHERE MaGV = :MaGV";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaGV', $MaGV);
    $stmt->execute();
    $countGV = $stmt->fetchColumn();

    if ($countGV == 0) {
        $_SESSION['error_message'] = "Mã giáo viên không tồn tại trong bảng giaovien.";
        header("Location: index.php?act=chunhiem");
        exit();
    }

    $MaLop = $_POST['MaLop'];
    // Kiểm tra maLop
    $sql = "SELECT COUNT(*) FROM lop WHERE MaLop = :MaLop";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaLop', $MaLop);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        $_SESSION['error_message'] = "Mã lớp không tồn tại trong bảng lop.";
        header("Location: index.php?act=chunhiem");
        exit();
    }

    $NamHoc = $_POST['NamHoc'];


    $query = "INSERT INTO chunhiem (MaGV, MaLop, NamHoc) VALUES (:MaGV, :MaLop, :NamHoc)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':MaGV', $MaGV);
    $stmt->bindParam(':MaLop', $MaLop);
    $stmt->bindParam(':NamHoc', $NamHoc);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Thêm chủ nhiệm thành công!";
        header("Location: index.php?act=chunhiem");
        exit();
    } else {
        $_SESSION['error_message'] = "Có lỗi xảy ra trong quá trình thêm chủ nhiệm.";
        header("Location: index.php?act=chunhiem");
        exit();
    }
}

// Sửa chủ nhiệm
if (isset($_POST['edit_chunhiem'])) {
    $conn = connectdb(); // Kết nối đến cơ sở dữ liệu
    $MaGV = $_POST['MaGV'];


    $MaLop = $_POST['MaLop'];



    $NamHoc = $_POST['NamHoc'];

    // Câu lệnh cập nhật
    $sql = "UPDATE chunhiem SET MaLop = :MaLop, NamHoc = :NamHoc WHERE MaGV = :MaGV";
    $stmt = $conn->prepare($sql);

    // Liên kết tham số
    $stmt->bindParam(':MaGV', $MaGV);
    $stmt->bindParam(':MaLop', $MaLop);
    $stmt->bindParam(':NamHoc', $NamHoc);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Cập nhật chủ nhiệm thành công!";
        header("Location: index.php?act=chunhiem"); // Chuyển hướng về trang danh sách
        exit();
    } else {
        $_SESSION['error_message'] = "Có lỗi xảy ra trong quá trình cập nhật.";
        header("Location: index.php?act=chunhiem");
        exit();
    }
}

// Xóa chủ nhiệm
if (isset($_POST['delete_chunhiem'])) {
    $MaGV = $_POST['MaGV'];
    $MaLop = $_POST['MaLop'];
    $NamHoc = $_POST['NamHoc'];
    
    $conn = connectdb();
    $query = "DELETE FROM chunhiem WHERE MaGV = :MaGV AND MaLop = :MaLop AND NamHoc = :NamHoc";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':MaGV', $MaGV);
    $stmt->bindParam(':MaLop', $MaLop);
    $stmt->bindParam(':NamHoc', $NamHoc);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Xóa chủ nhiệm thành công!";
        header("Location: index.php?act=chunhiem");
        exit();
    } else {
        $_SESSION['error_message'] = "Có lỗi xảy ra trong quá trình xóa.";
        header("Location: index.php?act=chunhiem");
        exit();
    }
}
?>