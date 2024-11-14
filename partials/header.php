<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/themify-icons/0.1.0/css/themify-icons.css">
    <title>Document</title>
</head>

<body>
<?php 
        if(isset($_SESSION['login_in']) && $_SESSION['login_in']==true){
            echo '
                <div class="top-site">
                    <div class="list d-flex align-items-center">
                        <a href="index.php?act=chunhiem" class="item btn btn-dark ms-4 me-4">Chủ nhiệm</a>
                        <a href="index.php?act=giaovien" class="item btn btn-dark me-4">Giáo viên</a>
                        <a href="index.php?act=lop" class="item btn btn-dark me-4">Lớp</a>
                        <a href="index.php?act=hocsinh" class="item btn btn-dark me-4">Học sinh</a>
                        <a href="index.php?act=phonghoc" class="item btn btn-dark me-4">Phòng Học</a>
                        <a href="index.php?act=monhoc" class="item btn btn-dark me-4">Môn Học</a>
                        <a href="index.php?act=diem" class="item btn btn-dark me-4">Kết quả</a>
                        <a href="index.php?act=phong_lop" class="item btn btn-dark me-4">Phòng Lớp</a>
                        <a href="index.php?act=xep_loai" class="item btn btn-dark me-4">Xếp Loại</a>
                        <a href="index.php?act=thong_ke" class="item btn btn-dark me-4">Thống Kê</a>
                        <a href="index.php?act=logout" class="item btn btn-dark me-4">Đăng xuất</a>
                    </div>
                </div>
            ';
        }
    ?>