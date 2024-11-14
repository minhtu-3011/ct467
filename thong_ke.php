<?php
// Kết nối cơ sở dữ liệu


// Lấy danh sách các lớp và số học sinh trong mỗi lớp
$conn = connectdb();
if ($conn) {
    $stmt = $conn->prepare("SELECT 
                                Lop.MaLop,
                                Lop.TenLop,
                                COUNT(HocSinh.MaHS) AS SoHocSinh,
                                GiaoVien.HoTen AS GiaoVienPhuTrach
                            FROM 
                                Lop
                            LEFT JOIN 
                                HocSinh ON Lop.MaLop = HocSinh.MaLop
                            LEFT JOIN 
                                ChuNhiem ON Lop.MaLop = ChuNhiem.MaLop
                            LEFT JOIN 
                                GiaoVien ON ChuNhiem.MaGV = GiaoVien.MaGV
                            GROUP BY 
                                Lop.MaLop, GiaoVien.HoTen");
    $stmt->execute();
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê Số Học Sinh Theo Lớp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 class="text-center p-3">Thống Kê Số Học Sinh Theo Lớp</h2>
    
    <!-- Bảng hiển thị số học sinh theo lớp -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã Lớp</th>
                <th>Tên Lớp</th>
                <th>Số Học Sinh</th>
                <th>Giáo Viên Phụ Trách</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($classes) && !empty($classes)): ?>
                <?php foreach ($classes as $class): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($class['MaLop']); ?></td>
                        <td><?php echo htmlspecialchars($class['TenLop']); ?></td>
                        <td><?php echo htmlspecialchars($class['SoHocSinh']); ?></td>
                        <td><?php echo htmlspecialchars($class['GiaoVienPhuTrach'] ?: 'Chưa có giáo viên'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Không có dữ liệu.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
