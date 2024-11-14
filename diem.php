<div class="container">
    <h2 class="text-center p-2">Quản Lý Điểm Học Sinh</h2>
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
                        $sql = "SELECT * FROM diem WHERE MaHS = :MaHS";
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
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#diemModal_add">Thêm Điểm</button>
        </div>
    </div>
    <div class="row">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Mã Học Sinh</th>
                    <th>Tên Học Sinh</th>
                    <th>Mã Môn Học</th>
                    <th>Điểm Miệng</th>
                    <th>Điểm 15 Phút</th>
                    <th>Điểm 1 Tiết</th>
                    <th>Điểm Thi</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_POST['searchMaHS']) && !empty($_POST['searchMaHS'])) {
                    $searchMaHS = $_POST['searchMaHS'];
                    $conn = connectdb();
                    // Cập nhật câu lệnh SQL với JOIN để lấy tên học sinh
                    $sql = "SELECT diem.*, hocsinh.HoTen 
                            FROM diem 
                            JOIN hocsinh ON diem.MaHS = hocsinh.MaHS
                            WHERE diem.MaHS = :MaHS";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':MaHS', $searchMaHS);
                    $stmt->execute();
                    $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    // Nếu không có tìm kiếm mã học sinh, lấy tất cả điểm học sinh
                    $conn = connectdb();
                    $sql = "SELECT diem.*, hocsinh.HoTen
                            FROM diem 
                            JOIN hocsinh ON diem.MaHS = hocsinh.MaHS";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }

                if (isset($kq) && count($kq) > 0) {
                    foreach ($kq as $diem) {
                        echo '
                            <tr>
                                <form method="post" action="">
                                    <input type="hidden" name="MaHS" value="' . htmlspecialchars($diem['MaHS']) . '">
                                    <input type="hidden" name="MaMonHoc" value="' . htmlspecialchars($diem['MaMonHoc']) . '">
                                    <td>' . htmlspecialchars($diem['MaHS']) . '</td>
                                    <td>' . htmlspecialchars($diem['HoTen']) . '</td> <!-- Hiển thị tên học sinh -->
                                    <td>' . htmlspecialchars($diem['MaMonHoc']) . '</td>
                                    <td>' . htmlspecialchars($diem['DiemMieng']) . '</td>
                                    <td>' . htmlspecialchars($diem['Diem15Phut']) . '</td>
                                    <td>' . htmlspecialchars($diem['Diem1Tiet']) . '</td>
                                    <td>' . htmlspecialchars($diem['DiemThi']) . '</td>
                                    <td class="text-center">
                                        <button type="submit" class="btn btn-danger btn-sm" name="delete_diem" onclick="return confirm(\'Bạn có chắc chắn muốn xóa điểm học sinh này?\');">Xóa</button>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#diemModal_edit' . htmlspecialchars($diem['MaHS']) . '_' . htmlspecialchars($diem['MaMonHoc']) . '">Sửa</button>
                                    </td>
                                </form>
                            </tr>

                            <!-- Modal Chỉnh Sửa -->
                            <div class="modal fade" id="diemModal_edit' . htmlspecialchars($diem['MaHS']) . '_' . htmlspecialchars($diem['MaMonHoc']) . '" tabindex="-1" aria-labelledby="diemModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="post" action="">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Chỉnh Sửa Điểm Học Sinh: ' . htmlspecialchars($diem['MaHS']) . ' - ' . htmlspecialchars($diem['MaMonHoc']) . '</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="MaHS" class="form-label">Mã Học Sinh:</label>
                                                    <input type="text" class="form-control" name="MaHS" value="' . htmlspecialchars($diem['MaHS']) . '" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="HoTen" class="form-label">Tên Học Sinh:</label>
                                                    <input type="text" class="form-control" name="HoTen" value="' . htmlspecialchars($diem['HoTen']) . '" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="MaMonHoc" class="form-label">Mã Môn Học:</label>
                                                    <input type="text" class="form-control" name="MaMonHoc" value="' . htmlspecialchars($diem['MaMonHoc']) . '" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="DiemMieng" class="form-label">Điểm Miệng:</label>
                                                    <input type="number" step="0.01" class="form-control" name="DiemMieng" value="' . htmlspecialchars($diem['DiemMieng']) . '">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="Diem15Phut" class="form-label">Điểm 15 Phút:</label>
                                                    <input type="number" step="0.01" class="form-control" name="Diem15Phut" value="' . htmlspecialchars($diem['Diem15Phut']) . '">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="Diem1Tiet" class="form-label">Điểm 1 Tiết:</label>
                                                    <input type="number" step="0.01" class="form-control" name="Diem1Tiet" value="' . htmlspecialchars($diem['Diem1Tiet']) . '">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="DiemThi" class="form-label">Điểm Thi:</label>
                                                    <input type="number" step="0.01" class="form-control" name="DiemThi" value="' . htmlspecialchars($diem['DiemThi']) . '">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                <button type="submit" class="btn btn-primary" name="edit_diem">Lưu Thay Đổi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                } else {
                    echo '<tr><td colspan="7" class="text-center">Không có điểm học sinh nào.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


    <!-- Modal Thêm Điểm -->
    <div class="modal fade" id="diemModal_add" tabindex="-1" aria-labelledby="diemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm Điểm Học Sinh</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="MaHS" class="form-label">Mã Học Sinh:</label>
                            <input type="text" class="form-control" name="MaHS" required>
                        </div>
                        <div class="mb-3">
                            <label for="MaMonHoc" class="form-label">Mã Môn Học:</label>
                            <input type="text" class="form-control" name="MaMonHoc" required>
                        </div>
                        <div class="mb-3">
                            <label for="DiemMieng" class="form-label">Điểm Miệng:</label>
                            <input type="number" step="0.01" class="form-control" name="DiemMieng">
                        </div>
                        <div class="mb-3">
                            <label for="Diem15Phut" class="form-label">Điểm 15 Phút:</label>
                            <input type="number" step="0.01" class="form-control" name="Diem15Phut">
                        </div>
                        <div class="mb-3">
                            <label for="Diem1Tiet" class="form-label">Điểm 1 Tiết:</label>
                            <input type="number" step="0.01" class="form-control" name="Diem1Tiet">
                        </div>
                        <div class="mb-3">
                            <label for="DiemThi" class="form-label">Điểm Thi:</label>
                            <input type="number" step="0.01" class="form-control" name="DiemThi">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" name="add_diem">Thêm Điểm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php


if (isset($_POST['MaHS'])) {
    $MaHS = $_POST['MaHS'];

    // Kết nối cơ sở dữ liệu
    $conn = connectdb();
    $sql = "SELECT HoTen FROM hocsinh WHERE MaHS = :MaHS";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaHS', $MaHS);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra nếu tìm thấy học sinh
    if ($row) {
        $HoTen = $row['HoTen'];
    } else {
        $HoTen = "Không tìm thấy học sinh";  // Nếu không tìm thấy học sinh
    }
}
// Thêm điểm
if (isset($_POST['add_diem'])) {
    $MaHS = $_POST['MaHS'];
    $MaMonHoc = $_POST['MaMonHoc'];
    $DiemMieng = $_POST['DiemMieng'];
    $Diem15Phut = $_POST['Diem15Phut'];
    $Diem1Tiet = $_POST['Diem1Tiet'];
    $DiemThi = $_POST['DiemThi'];

    $conn = connectdb();
    $sql = "INSERT INTO diem (MaHS, MaMonHoc, DiemMieng, Diem15Phut, Diem1Tiet, DiemThi) VALUES (:MaHS, :MaMonHoc, :DiemMieng, :Diem15Phut, :Diem1Tiet, :DiemThi)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaHS', $MaHS);
    $stmt->bindParam(':MaMonHoc', $MaMonHoc);
    $stmt->bindParam(':DiemMieng', $DiemMieng);
    $stmt->bindParam(':Diem15Phut', $Diem15Phut);
    $stmt->bindParam(':Diem1Tiet', $Diem1Tiet);
    $stmt->bindParam(':DiemThi', $DiemThi);
    $stmt->execute();

    header("Location:index.php?act=diem");
    exit();
}

// Sửa điểm
if (isset($_POST['edit_diem'])) {
    $MaHS = $_POST['MaHS'];
    $MaMonHoc = $_POST['MaMonHoc'];
    $DiemMieng = $_POST['DiemMieng'];
    $Diem15Phut = $_POST['Diem15Phut'];
    $Diem1Tiet = $_POST['Diem1Tiet'];
    $DiemThi = $_POST['DiemThi'];

    $conn = connectdb();
    $sql = "UPDATE diem SET DiemMieng = :DiemMieng, Diem15Phut = :Diem15Phut, Diem1Tiet = :Diem1Tiet, DiemThi = :DiemThi WHERE MaHS = :MaHS AND MaMonHoc = :MaMonHoc";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaHS', $MaHS);
    $stmt->bindParam(':MaMonHoc', $MaMonHoc);
    $stmt->bindParam(':DiemMieng', $DiemMieng);
    $stmt->bindParam(':Diem15Phut', $Diem15Phut);
    $stmt->bindParam(':Diem1Tiet', $Diem1Tiet);
    $stmt->bindParam(':DiemThi', $DiemThi);
    $stmt->execute();

    header("Location:index.php?act=diem");
    exit();
}

// Xóa điểm
if (isset($_POST['delete_diem'])) {
    $MaHS = $_POST['MaHS'];
    $MaMonHoc = $_POST['MaMonHoc'];

    $conn = connectdb();
    $sql = "DELETE FROM diem WHERE MaHS = :MaHS AND MaMonHoc = :MaMonHoc";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':MaHS', $MaHS);
    $stmt->bindParam(':MaMonHoc', $MaMonHoc);
    $stmt->execute();

    header("Location:index.php?act=diem");
    exit();
}
?>