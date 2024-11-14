<div class="container">
    <h2 class="text-center p-2">Quản Lý Phòng Học</h2>
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
                        $sql = "SELECT * FROM phonghoc WHERE MaPhong = :MaPhong";
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
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#roomModal_add">Thêm Phòng Học</button>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>MaPhong</th>
                        <th>Số Phòng</th>
                        <th>Số Chỗ Tối Đa</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($kq) && count($kq) > 0) {
                        foreach ($kq as $room) {
                            echo '
                                <tr>
                                    <form method="post" action="">
                                        <input type="hidden" name="MaPhong" value="' . htmlspecialchars($room['MaPhong']) . '">
                                        <td>' . htmlspecialchars($room['MaPhong']) . '</td>
                                        <td>' . htmlspecialchars($room['SoPhong']) . '</td>
                                        <td>' . htmlspecialchars($room['SoChoToiDa']) . '</td>
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-danger btn-sm" name="delete_room" onclick="return confirm(\'Bạn có chắc chắn muốn xóa phòng học này?\');">Xóa</button>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#roomModal_edit' . htmlspecialchars($room['MaPhong']) . '">Sửa</button>
                                        </td>
                                    </form>
                                </tr>

                                <!-- Modal Chỉnh Sửa -->
                                <div class="modal fade" id="roomModal_edit' . htmlspecialchars($room['MaPhong']) . '" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="post" action="">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Chỉnh Sửa Phòng Học: ' . htmlspecialchars($room['MaPhong']) . '</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="MaPhong" class="form-label">Mã Phòng:</label>
                                                        <input type="text" class="form-control" name="MaPhong" value="' . htmlspecialchars($room['MaPhong']) . '" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="SoPhong" class="form-label">Số Phòng:</label>
                                                        <input type="number" class="form-control" name="SoPhong" value="' . htmlspecialchars($room['SoPhong']) . '">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="SoChoToiDa" class="form-label">Số Chỗ Tối Đa:</label>
                                                        <input type="number" class="form-control" name="SoChoToiDa" value="' . htmlspecialchars($room['SoChoToiDa']) . '">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary" name="edit_room">Lưu Thay Đổi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                    } else {
                        echo '<tr><td colspan="4" class="text-center">Không có phòng học nào.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Thêm Phòng Học -->
    <div class="modal fade" id="roomModal_add" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Phòng Học</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="MaPhong" class="form-label">Mã Phòng</label>
                            <input type="text" class="form-control" name="MaPhong" required>
                        </div>
                        <div class="mb-3">
                            <label for="SoPhong" class="form-label">Số Phòng</label>
                            <input type="number" class="form-control" name="SoPhong" required>
                        </div>
                        <div class="mb-3">
                            <label for="SoChoToiDa" class="form-label">Số Chỗ Tối Đa</label>
                            <input type="number" class="form-control" name="SoChoToiDa" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary" name="add_room">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Xử lý thêm, chỉnh sửa và xóa phòng học
if (isset($_POST['add_room'])) {
    $MaPhong = $_POST['MaPhong'];
    $SoPhong = $_POST['SoPhong'];
    $SoChoToiDa = $_POST['SoChoToiDa'];

    $conn = connectdb();
    $sql = "INSERT INTO phonghoc (MaPhong, SoPhong, SoChoToiDa) VALUES (:MaPhong, :SoPhong, :SoChoToiDa)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaPhong', $MaPhong);
    $stmt->bindParam(':SoPhong', $SoPhong);
    $stmt->bindParam(':SoChoToiDa', $SoChoToiDa);
    $stmt->execute();

    header("Location:index.php?act=phonghoc");
    exit();
}

if (isset($_POST['edit_room'])) {
    $MaPhong = $_POST['MaPhong'];
    $SoPhong = $_POST['SoPhong'];
    $SoChoToiDa = $_POST['SoChoToiDa'];

    $conn = connectdb();
    $sql = "UPDATE phonghoc SET SoPhong = :SoPhong, SoChoToiDa = :SoChoToiDa WHERE MaPhong = :MaPhong";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaPhong', $MaPhong);
    $stmt->bindParam(':SoPhong', $SoPhong);
    $stmt->bindParam(':SoChoToiDa', $SoChoToiDa);
    $stmt->execute();

    header("Location:index.php?act=phonghoc");
    exit();
}

if (isset($_POST['delete_room'])) {
    $MaPhong = $_POST['MaPhong'];

    $conn = connectdb();
    $sql = "DELETE FROM phonghoc WHERE MaPhong = :MaPhong";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaPhong', $MaPhong);
    $stmt->execute();

    header("Location:index.php?act=phonghoc");
    exit();
}
?>