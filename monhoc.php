<div class="container">
    <h2 class="text-center p-2">Quản Lý Môn Học</h2>
    <div class="row">
        <div class="col-9">
            <form method="post" action="">
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="searchMaMonHoc" id="searchMaMonHoc" placeholder="Nhập mã môn học">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                    <?php
                    if (isset($_POST['searchMaMonHoc']) && !empty($_POST['searchMaMonHoc'])) {
                        $searchMaMonHoc = $_POST['searchMaMonHoc'];
                        $conn = connectdb();
                        $sql = "SELECT * FROM monhoc WHERE MaMonHoc = :MaMonHoc";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':MaMonHoc', $searchMaMonHoc);
                        $stmt->execute();
                        $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    ?>
                </div>
            </form>
        </div>
        <div class="col-3">
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#monhocModal_add">Thêm Môn Học</button>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>MaMonHoc</th>
                        <th>Tên Môn Học</th>
                        <th>Khối</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($kq) && count($kq) > 0) {
                        foreach ($kq as $monhoc) {
                            echo '
                                <tr>
                                    <form method="post" action="">
                                        <input type="hidden" name="MaMonHoc" value="' . htmlspecialchars($monhoc['MaMonHoc']) . '">
                                        <td>' . htmlspecialchars($monhoc['MaMonHoc']) . '</td>
                                        <td>' . htmlspecialchars($monhoc['TenMonHoc']) . '</td>
                                        <td>' . htmlspecialchars($monhoc['Khoi']) . '</td>
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-danger btn-sm" name="delete_monhoc" onclick="return confirm(\'Bạn có chắc chắn muốn xóa môn học này?\');">Xóa</button>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#monhocModal_edit' . htmlspecialchars($monhoc['MaMonHoc']) . '">Sửa</button>
                                        </td>
                                    </form>
                                </tr>

                                <!-- Modal Chỉnh Sửa -->
                                <div class="modal fade" id="monhocModal_edit' . htmlspecialchars($monhoc['MaMonHoc']) . '" tabindex="-1" aria-labelledby="monhocModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="post" action="">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Chỉnh Sửa Môn Học: ' . htmlspecialchars($monhoc['MaMonHoc']) . '</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="MaMonHoc" class="form-label">Mã Môn Học:</label>
                                                        <input type="text" class="form-control" name="MaMonHoc" value="' . htmlspecialchars($monhoc['MaMonHoc']) . '" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="TenMonHoc" class="form-label">Tên Môn Học:</label>
                                                        <input type="text" class="form-control" name="TenMonHoc" value="' . htmlspecialchars($monhoc['TenMonHoc']) . '">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="Khoi" class="form-label">Khối:</label>
                                                        <input type="text" class="form-control" name="Khoi" value="' . htmlspecialchars($monhoc['Khoi']) . '">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary" name="edit_monhoc">Lưu Thay Đổi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                    } else {
                        echo '<tr><td colspan="4" class="text-center">Không có môn học nào.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Thêm Môn Học -->
    <div class="modal fade" id="monhocModal_add" tabindex="-1" aria-labelledby="monhocModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Môn Học</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="MaMonHoc" class="form-label">Mã Môn Học</label>
                            <input type="text" class="form-control" name="MaMonHoc" required>
                        </div>
                        <div class="mb-3">
                            <label for="TenMonHoc" class="form-label">Tên Môn Học</label>
                            <input type="text" class="form-control" name="TenMonHoc" required>
                        </div>
                        <div class="mb-3">
                            <label for="Khoi" class="form-label">Khối</label>
                            <input type="text" class="form-control" name="Khoi" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary" name="add_monhoc">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Xử lý thêm, chỉnh sửa và xóa môn học
if (isset($_POST['add_monhoc'])) {
    $MaMonHoc = $_POST['MaMonHoc'];
    $TenMonHoc = $_POST['TenMonHoc'];
    $Khoi = $_POST['Khoi'];

    $conn = connectdb();
    $sql = "INSERT INTO monhoc (MaMonHoc, TenMonHoc, Khoi) VALUES (:MaMonHoc, :TenMonHoc, :Khoi)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaMonHoc', $MaMonHoc);
    $stmt->bindParam(':TenMonHoc', $TenMonHoc);
    $stmt->bindParam(':Khoi', $Khoi);
    $stmt->execute();

    header("Location:index.php?act=monhoc");
    exit();
}

if (isset($_POST['edit_monhoc'])) {
    $MaMonHoc = $_POST['MaMonHoc'];
    $TenMonHoc = $_POST['TenMonHoc'];
    $Khoi = $_POST['Khoi'];

    $conn = connectdb();
    $sql = "UPDATE monhoc SET TenMonHoc = :TenMonHoc, Khoi = :Khoi WHERE MaMonHoc = :MaMonHoc";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaMonHoc', $MaMonHoc);
    $stmt->bindParam(':TenMonHoc', $TenMonHoc);
    $stmt->bindParam(':Khoi', $Khoi);
    $stmt->execute();

    header("Location:index.php?act=monhoc");
    exit();
}

if (isset($_POST['delete_monhoc'])) {
    $MaMonHoc = $_POST['MaMonHoc'];

    $conn = connectdb();
    $sql = "DELETE FROM monhoc WHERE MaMonHoc = :MaMonHoc";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaMonHoc', $MaMonHoc);
    $stmt->execute();

    header("Location:index.php?act=monhoc");
    exit();
}
?>