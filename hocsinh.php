<div class="container">
    <h2 class="text-center p-2">Quản Lý Học Sinh</h2>
    <div class="row">
        <div class="col-9">
            <form method="post" action="">
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="searchMaHS" id="searchMaHS" placeholder="Nhập mã học sinh">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                    <?php
                    if (isset($_POST['searchMaHS']) && !empty($_POST['searchMaHS'])) {
                        $searchMaHS = $_POST['searchMaHS'];
                        $conn = connectdb();
                        $sql = "SELECT * FROM hocsinh WHERE MaHS = :MaHS";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':MaHS', $searchMaHS);
                        $stmt->execute();
                        $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    ?>
                </div>
            </form>
        </div>
        <div class="col-3">
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#studentModal_add">Thêm Học Sinh</button>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>MaHS</th>
                        <th>TenHS</th>
                        <th>Ngày Sinh</th>
                        <th>Địa Chỉ</th>
                        <th>SDT Phụ Huynh</th>
                        <th>Lớp</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($kq) && count($kq) > 0) {
                        foreach ($kq as $hs) {
                            echo '
                                <tr>
                                    <form method="post" action="">
                                        <input type="hidden" name="MaHS" value="' . htmlspecialchars($hs['MaHS']) . '">
                                        <td>' . htmlspecialchars($hs['MaHS']) . '</td>
                                        <td>' . htmlspecialchars($hs['HoTen']) . '</td>
                                        <td>' . htmlspecialchars($hs['NgaySinh']) . '</td>
                                        <td>' . htmlspecialchars($hs['DiaChi']) . '</td>
                                        <td>' . htmlspecialchars($hs['SDTPhuHuynh']) . '</td>
                                        <td>' . htmlspecialchars($hs['MaLop']) . '</td>
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-danger btn-sm" name="delete_hs" onclick="return confirm(\'Bạn có chắc chắn muốn xóa học sinh này?\');">Xóa</button>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#studentModal_edit' . htmlspecialchars($hs['MaHS']) . '">Sửa</button>
                                        </td>
                                    </form>
                                </tr>

                                <!-- Modal Chỉnh Sửa -->
                                <div class="modal fade" id="studentModal_edit' . htmlspecialchars($hs['MaHS']) . '" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="post" action="">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Chỉnh Sửa Học Sinh: ' . htmlspecialchars($hs['HoTen']) . '</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="MaHS" class="form-label">Mã học sinh:</label>
                                                        <input type="text" class="form-control" name="MaHS" value="' . htmlspecialchars($hs['MaHS']) . '" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="TenHS" class="form-label">Tên Học Sinh:</label>
                                                        <input type="text" class="form-control" name="TenHS" value="' . htmlspecialchars($hs['HoTen']) . '">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="NgaySinh" class="form-label">Ngày Sinh:</label>
                                                        <input type="date" class="form-control" name="NgaySinh" value="' . htmlspecialchars($hs['NgaySinh']) . '">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="DiaChi" class="form-label">Địa Chỉ:</label>
                                                        <input type="text" class="form-control" name="DiaChi" value="' . htmlspecialchars($hs['DiaChi']) . '">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="SDTPhuHuynh" class="form-label">SĐT Phụ Huynh:</label>
                                                        <input type="text" class="form-control" name="SDTPhuHuynh" value="' . htmlspecialchars($hs['SDTPhuHuynh']) . '">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="MaLop" class="form-label">Lớp:</label>
                                                        <input type="text" class="form-control" name="MaLop" value="' . htmlspecialchars($hs['MaLop']) . '">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary" name="edit_hs">Lưu Thay Đổi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                    } else {
                        echo '<tr><td colspan="7" class="text-center">Không có học sinh nào.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal thêm học sinh -->
    <div class="modal fade" id="studentModal_add" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Học Sinh</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="MaHS" class="form-label">Mã Học Sinh</label>
                            <input type="text" class="form-control" name="MaHS" required>
                        </div>
                        <div class="mb-3">
                            <label for="TenHS" class="form-label">Tên Học Sinh</label>
                            <input type="text" class="form-control" name="TenHS" required>
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
                            <label for="SDTPhuHuynh" class="form-label">SĐT Phụ Huynh</label>
                            <input type="text" class="form-control" name="SDTPhuHuynh" required>
                        </div>
                        <div class="mb-3">
                            <label for="MaLop" class="form-label">Lớp</label>
                            <input type="text" class="form-control" name="MaLop" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary" name="add_hs">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Xử lý thêm, chỉnh sửa và xóa
if (isset($_POST['add_hs'])) {
    $MaHS = $_POST['MaHS'];
    $TenHS = $_POST['TenHS'];
    $NgaySinh = $_POST['NgaySinh'];
    $DiaChi = $_POST['DiaChi'];
    $SDTPhuHuynh = $_POST['SDTPhuHuynh'];
    $MaLop = $_POST['MaLop'];

    $conn = connectdb();
    $sql = "INSERT INTO hocsinh (MaHS, HoTen, NgaySinh, DiaChi, SDTPhuHuynh, MaLop) VALUES (:MaHS, :TenHS, :NgaySinh, :DiaChi, :SDTPhuHuynh, :MaLop)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaHS', $MaHS);
    $stmt->bindParam(':TenHS', $TenHS);
    $stmt->bindParam(':NgaySinh', $NgaySinh);
    $stmt->bindParam(':DiaChi', $DiaChi);
    $stmt->bindParam(':SDTPhuHuynh', $SDTPhuHuynh);
    $stmt->bindParam(':MaLop', $MaLop);
    $stmt->execute();

    header("Location:index.php?act=hocsinh");
    exit();
}

if (isset($_POST['edit_hs'])) {
    $MaHS = $_POST['MaHS'];
    $TenHS = $_POST['TenHS'];
    $NgaySinh = $_POST['NgaySinh'];
    $DiaChi = $_POST['DiaChi'];
    $SDTPhuHuynh = $_POST['SDTPhuHuynh'];
    $MaLop = $_POST['MaLop'];

    $conn = connectdb();
    $sql = "UPDATE hocsinh SET HoTen = :TenHS, NgaySinh = :NgaySinh, DiaChi = :DiaChi, SDTPhuHuynh = :SDTPhuHuynh, MaLop = :MaLop WHERE MaHS = :MaHS";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaHS', $MaHS);
    $stmt->bindParam(':TenHS', $TenHS);
    $stmt->bindParam(':NgaySinh', $NgaySinh);
    $stmt->bindParam(':DiaChi', $DiaChi);
    $stmt->bindParam(':SDTPhuHuynh', $SDTPhuHuynh);
    $stmt->bindParam(':MaLop', $MaLop);
    $stmt->execute();

    header("Location:index.php?act=hocsinh");
    exit();
}

if (isset($_POST['delete_hs'])) {
    $MaHS = $_POST['MaHS'];

    $conn = connectdb();
    $sql = "DELETE FROM hocsinh WHERE MaHS = :MaHS";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaHS', $MaHS);
    $stmt->execute();

    header("Location:index.php?act=hocsinh");
    exit();
}
?>
