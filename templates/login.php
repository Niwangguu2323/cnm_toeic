<?php
session_start();

$correct_email = "nhivanar@gmail.com";
$correct_password = "nhivanar";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["txt_email"] ?? '';
    $password = $_POST["password"] ?? '';

    if ($email === $correct_email && $password === $correct_password) {
        $_SESSION["user_email"] = $email;
        header("Location: ../index.php");
        exit;
    } else {
        $error = "Email hoặc mật khẩu không đúng";
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
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Đăng nhập</h1>
                    <form action="" method="POST" class="col-5 mx-auto" autocomplete="off">
                            <input type="text" style="display:none">
                            <input type="password" style="display:none">
                        <div class="mb-3">
                            <input type="email" class="form-control rounded-pill" id="email" name="txt_email" placeholder="Nhập email của bạn" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control rounded-pill" id="password" name="password" placeholder="Nhập mật khẩu" required>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill">Đăng nhập</button>
                        <br>
                        <a href="#" style="color:red font-style:italic">Bạn chưa có tài khoản? Đăng ký tại đây</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Page End -->

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