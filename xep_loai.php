<?php


// Hàm xếp loại học sinh
function xepLoaiHocSinh($diemTrungBinh) {
    if ($diemTrungBinh >= 9 && $diemTrungBinh <= 10) {
        return "Xuất sắc";
    } elseif ($diemTrungBinh >= 8 && $diemTrungBinh < 9) {
        return "Giỏi";
    } elseif ($diemTrungBinh >= 6.5 && $diemTrungBinh < 8) {
        return "Khá";
    } elseif ($diemTrungBinh >= 5 && $diemTrungBinh < 6.5) {
        return "Trung bình";
    } else {
        return "Yếu";
    }
}

if (isset($_POST['MaLop']) && !empty($_POST['MaLop'])) {
    $maLop = $_POST['MaLop'];
    $sortOrder = isset($_POST['sort_order']) ? $_POST['sort_order'] : 'ASC';  // Mặc định là 'ASC'

    $conn = connectdb();

    if ($conn) {
        // Truy vấn danh sách học sinh trong lớp và tính điểm trung bình cho từng học sinh, có sắp xếp theo điểm
        $stmt = $conn->prepare("SELECT HocSinh.MaHS, HocSinh.HoTen, AVG((Diem.DiemMieng + Diem.Diem15Phut + Diem.Diem1Tiet + Diem.DiemThi) / 4) AS DiemTrungBinh
                                FROM HocSinh
                                LEFT JOIN Diem ON HocSinh.MaHS = Diem.MaHS
                                WHERE HocSinh.MaLop = :MaLop
                                GROUP BY HocSinh.MaHS
                                ORDER BY DiemTrungBinh $sortOrder");
        $stmt->bindParam(':MaLop', $maLop);
        $stmt->execute();
        $hocSinhList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Điểm Trung Bình Học Sinh Theo Lớp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 class="text-center p-3">Tìm Điểm Trung Bình Học Sinh Theo Lớp</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="class_id" class="form-label">Nhập Mã Lớp</label>
            <input type="text" class="form-control" name="MaLop" id="class_id" placeholder="Nhập mã lớp" required>
        </div>
        <div class="mb-3">
        <label for="sort_order" class="form-label">Sắp Xếp Theo Điểm</label>
        <select class="form-control" name="sort_order" id="sort_order">
            <option value="ASC">Tăng Dần</option>
            <option value="DESC">Giảm Dần</option>
        </select>
    </div>
        <button type="submit" class="btn btn-primary">Tìm Điểm Trung Bình</button>
    </form>

    <?php if (isset($hocSinhList) && count($hocSinhList) > 0): ?>
        <div class="mt-4">
            <h4>Danh Sách Điểm Trung Bình Học Sinh</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã Học Sinh</th>
                        <th>Tên Học Sinh</th>
                        <th>Điểm Trung Bình</th>
                        <th>Xếp Loại</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hocSinhList as $hocSinh): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($hocSinh['MaHS']); ?></td>
                            <td><?php echo htmlspecialchars($hocSinh['HoTen']); ?></td>
                            <td><?php echo number_format($hocSinh['DiemTrungBinh'], 2); ?></td>
                            <td><?php echo xepLoaiHocSinh($hocSinh['DiemTrungBinh']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php elseif (isset($hocSinhList)): ?>
        <div class="mt-4">
            <p>Không có học sinh nào trong lớp này hoặc không có điểm.</p>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
