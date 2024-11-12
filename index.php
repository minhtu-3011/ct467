<?php
session_start();
ob_start();
include_once __DIR__ . "/partials/header.php";
include_once __DIR__ . "/connectDL.php";
include_once __DIR__ . "/handle_functions.php";

if (isset($_GET['act'])) {
    switch ($_GET['act']) {
        case 'logout':
            $_SESSION['login_in'] = false;
            header('location: index.php?act=login');
        case 'home':

            include "home.php";
            break;
        case 'chunhiem':
            $kq = getall_chunhiem();
            include "chunhiem.php";
            break;
        case 'giaovien':
            $kq = getall_giaovien();
            include "giaovien.php";
            break;
        case 'lop':
            $kq = getall_lop();
            include "lop.php";
            break;
        case 'register':
            if (isset($_POST['dangky']) && ($_POST['dangky'])) {
                $email = $_POST['email'];
                $sdt = $_POST['sdt'];
                $pass = $_POST['pass'];
                $name = $_POST['name'];
                addUser($name, $email, $pass, $sdt);
            }
            include "register.php";
            break;

        case 'login':

            if ((isset($_POST['login'])) && ($_POST['login'])) {
                $email = $_POST['email'];
                $pass = $_POST['pass'];

                if (check_user($email, $pass)) {
                    $_SESSION['login_in'] = true;
                    header("Location: index.php?act=home");
                    exit();
                }
            }
            include "login.php";
            break;
        default:

            include "register.php";
            break;
    }
} else {

    include "register.php";
}


include_once __DIR__ . "/partials/footer.php";

?>