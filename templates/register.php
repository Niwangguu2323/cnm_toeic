<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$db = new ketnoi();
$conn = $db->moketnoi();

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = trim($_POST['user_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    // Kiểm tra username không có ký tự đặc biệt
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $user_name)) {
        $errors[] = "Tên đăng nhập không hợp lệ (không chứa ký tự đặc biệt)";
    }

    // Kiểm tra email hợp lệ
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ.";
    }

    // Kiểm tra mật khẩu trùng khớp
    if ($password !== $confirm_password) {
        $errors[] = "Mật khẩu xác nhận không khớp.";
    }

    // Kiểm tra số điện thoại
    if (!preg_match('/^[0-9]{9,11}$/', $phone)) {
        $errors[] = "Số điện thoại không hợp lệ.";
    }

    // Kiểm tra email đã tồn tại
    $email_check = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
    if (mysqli_num_rows($email_check) > 0) {
        $errors[] = "Email đã được đăng ký.";
    }

    // Nếu không có lỗi thì insert
    if (empty($errors)) {
        $password = mysqli_real_escape_string($conn, $password); // bạn có thể thay bằng password_hash
        $sql = "INSERT INTO user (user_name, email, password, full_name, phone)
                VALUES ('$user_name', '$email', '$password', '$full_name', '$phone')";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['user_email'] = $email;
            header("Location: ../index.php");
            exit;
        } else {
            $errors[] = "Đăng ký thất bại. Vui lòng thử lại.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>2N Toeic Lab - Về chúng tôi</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Icon IUH - hiển thị trên thanh tác vụ webweb-->
    <link href="../public/img/logoiuh.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../public/libs/animate/animate.min.css" rel="stylesheet">
    <link href="../public/libs/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../public/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start 
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
     Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="../index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>2NToeicLab</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <!-- Navbar End -->


    <!-- Login Page Start -->
   <div class="container-fluid bg-primary py-5 mb-5 page-header">
    <h2 class="text-center text-primary mb-4">Đăng ký tài khoản</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST" class="col-md-6 offset-md-3">
        <div class="mb-3">
            <input type="text" name="user_name" class="form-control rounded-pill" placeholder="Tên đăng nhập" required value="<?= htmlspecialchars($user_name ?? '') ?>">
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control rounded-pill" placeholder="Email" required value="<?= htmlspecialchars($email ?? '') ?>">
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control rounded-pill" placeholder="Mật khẩu" required>
        </div>
        <div class="mb-3">
            <input type="password" name="confirm_password" class="form-control rounded-pill" placeholder="Nhập lại mật khẩu" required>
        </div>
        <div class="mb-3">
            <input type="text" name="full_name" class="form-control rounded-pill" placeholder="Họ tên" required value="<?= htmlspecialchars($full_name ?? '') ?>">
        </div>
        <div class="mb-3">
            <input type="text" name="phone" class="form-control rounded-pill" placeholder="Số điện thoại" required value="<?= htmlspecialchars($phone ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-primary w-100 rounded-pill">Đăng ký</button>
        <p class="text-center mt-3 ">
             <a href="login.php">Đã có tài khoản? Đăng nhập</a>
        </p>
    </form>
</div>
    <!-- Login Page End -->
    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Menu</h4>
                    <a class="btn btn-link" href="../index.php">Trang chủ</a>
                    <a class="btn btn-link" href="about.php">Về chúng tôi</a>
                    <a class="btn btn-link" href="listening.php">Luyện tập kĩ năng nghe</a>
                    <a class="btn btn-link" href="reading.php">Luyện tập kĩ năng đọc</a>
                    <a class="btn btn-link" href="test.php">Làm bài thi</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Liên hệ</h4>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>0949 80 4347 (Nhi)</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>nhi@student.iuh.edu.vn</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Đăng ký tài khoản</h4>
                    <p>Đến với 2N Toeic Lab nào!!!</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Email của bạn">
                        <a type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2" href="register.php">Đăng ký</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-12 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">2N Toeic Lab - Hệ thống hỗ trợ luyện thi TOEIC 2 kỹ năng</a>, All Right Reserved.

                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a><br><br>
                        Distributed By <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>