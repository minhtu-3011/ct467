<?php
function getall_lop(){
    $conn = connectdb();
    $stmt = $conn->prepare("SELECT * FROM lop");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $kq = $stmt->fetchAll();
    return $kq;
}
function getall_giaovien(){
    $conn = connectdb();
    $stmt = $conn->prepare("SELECT * FROM giaovien");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $kq = $stmt->fetchAll();
    return $kq;
}

function getall_chunhiem(){
    $conn = connectdb();
    $stmt = $conn->prepare("SELECT * FROM chunhiem");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $kq = $stmt->fetchAll();
    return $kq;
}

function getall_hocsinh() {
    $conn = connectdb();
    $sql = "SELECT * FROM hocsinh";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getall_phonghoc() {
    $conn = connectdb();
    $sql = "SELECT * FROM phonghoc";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getall_monhoc() {
    $conn = connectdb();
    $sql = "SELECT * FROM monhoc";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getall_diem() {
    $conn = connectdb();
    $sql = "SELECT * FROM diem";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getall_phong_lop() {
    $conn = connectdb();
    $sql = "SELECT * FROM phong_lop";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getall_xep_loai() {
    $conn = connectdb();
    $sql = "SELECT * FROM diem";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getall_thong_ke() {
    $conn = connectdb();
    $sql = "SELECT * FROM chunhiem";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



function check_user($email, $pass){
    $conn = connectdb();
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = '".$email."' AND pass = '".$pass."'");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $kq = $stmt->fetchAll();
    if(count($kq)>0) return true;
    else return false;
}

function addUser($name, $email,$pass, $sdt) {
    // Sử dụng biến $conn đã kết nối sẵn
    $conn = connectdb();

    try {
        // Tạo câu lệnh SQL để chèn người dùng mới
        $sql = "INSERT INTO users (name, email, sdt,pass)  VALUES (:name, :email, :sdt, :pass)";
        
        // Chuẩn bị câu truy vấn
        $stmt = $conn->prepare($sql);
        
        // Gán giá trị cho các tham số
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':sdt', $sdt);
        
        // Thực thi câu truy vấn
        $stmt->execute();
        
        echo "<div class='text-center'><p class='fs-2 text-success'>Người dùng đã được thêm thành công!</p></div>";
    } catch (PDOException $e) {
        echo "<p class='fs-2 text-danger'>Lỗi khi thêm người dùng</p>" . $e->getMessage();
    }
}
?>