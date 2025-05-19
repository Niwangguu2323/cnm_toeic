<?php
session_start();
require_once __DIR__ . '/config/db.php';
$db = new ketnoi();
$conn = $db->moketnoi();
$exam_sql = "SELECT * FROM exam ORDER BY exam_id DESC LIMIT 3";
$exam_result = mysqli_query($conn, $exam_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>2N Toeic Lab - Hệ thống hỗ trợ luyện thi TOEIC 2 kỹ năng</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Icon IUH - hiển thị trên thanh tác vụ webweb-->
    <link href="public/img/logoiuh.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="public/libs/animate/animate.min.css" rel="stylesheet">
    <link href="public/libs/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="public/css/style.css" rel="stylesheet">
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
        <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3">2NToeicLab</i></h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link active">Trang chủ</a>
                <a href="templates/about.php" class="nav-item nav-link">Về chúng tôi</a>
                <div class="nav-item dropdown">
                    <a href="templates/practice.php" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Luyện tập</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="templates/listening.php" class="dropdown-item">Nghe</a>
                        <a href="templates/reading.php" class="dropdown-item">Đọc</a>
                    </div>
                </div>
                <a href="templates/test.php" class="nav-item nav-link">Làm bài thi</a>
            </div>
            <?php if (isset($_SESSION["user_email"])): ?>
                <div class="nav-item dropdown me-4">
                    <a href="#" class="btn btn-primary dropdown-toggle py-4 px-lg-5 d-none d-lg-block" data-bs-toggle="dropdown">
                        <?= explode('@', $_SESSION["user_email"])[0] ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="templates/profile.php" class="dropdown-item">Sửa thông tin</a>
                        <a href="templates/logout.php" class="dropdown-item text-danger">Đăng xuất</a>
                        <div class="dropdown-submenu">
                            <a href="#" class="dropdown-item submenu-toggle">Admin</a>
                            <ul class="submenu">
                            <li><a href="admin/exam_manage.php" class="dropdown-item">Quản lý bài thi</a></li>
                            <li><a href="#" class="dropdown-item">Quản lý người dùng</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <a href="templates/login.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Đăng nhập<i class="fa fa-arrow-right ms-3"></i></a>
            <?php endif; ?>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative" style="height: 100vh; min-height: 600px;">
                <img class="img-fluid w-100 h-100" src="public/img/carousel.jpg" style="object-fit: cover;" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-start" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8 text-center text-lg-start" style="max-width: 700px;">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown">2N Toeic Lab</h5>
                                <h1 class="display-3 text-white animated slideInDown">Hệ thống hỗ trợ luyện thi Toeic 2 kỹ năng</h1>
                                <p class="fs-5 text-white mb-4 pb-2">Ôn luyện thông minh - điểm số vượt trội!</p>
                                <a href="templates/about.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Về chúng tôi</a>
                                <a href="#" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Đăng ký ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-globe text-primary mb-4"></i>
                            <h5 class="mb-3">Chào mừng bạn</h5>
                            <p>Hướng dẫn chi tiết cho bạn lần đầu đến với hệ thống</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                            <h5 class="mb-3">Luyện tập kỹ năng</h5>
                            <p>Phát triển kỹ năng nghe và đọc tại đây</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                            <h5 class="mb-3">Thư viện bài thi</h5>
                            <p>Làm bài thi thử, biết điểm ngay</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-home text-primary mb-4"></i>
                            <h5 class="mb-3">2N Toeic Lab</h5>
                            <p>Cảm ơn bạn đã chọn chúng tôi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" src="public/img/about.jpg" alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">Về chúng tôi</h6>
                    <h1 class="mb-4">2N Toeic Lab</h1>
                    <p class="mb-4">Hệ thống được xây dựng bởi Nhi và Nar – hai tâm hồn yêu học hỏi đến từ IUH</p>
                    <p class="mb-4">Tại đây, việc luyện thi TOEIC trở nên dễ dàng và thú vị hơn bao giờ hết – vì chúng tôi hiểu điều bạn cần là sự hiệu quả và cảm hứng học tập.</p>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Hướng dẫn làm quen hệ thống</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Luyện tập kỹ năng</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Làm bài thi thử</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Liên hệ</p>
                        </div>
                    </div>
                    <a class="btn btn-primary py-3 px-5 mt-2" href="templates/about.php">Xem thêm</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Courses Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Các bài thi</h6>
                <h1 class="mb-5">Các bài thi mới nhất</h1>
            </div>
            <div class="row g-4 justify-content-center">
    <?php while ($exam = mysqli_fetch_assoc($exam_result)): ?>
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="course-item bg-light">
                <div class="text-center p-4 pb-0">
                    <h3 class="mb-0"><?= htmlspecialchars($exam['title']) ?></h3>
                </div>
                <div class="d-flex border-top">
                    <small class="flex-fill text-center border-end py-2">
                        <i class="fa fa-user-tie text-primary me-2"></i>Năm <?= date('Y') ?>
                    </small>
                    <small class="flex-fill text-center border-end py-2">
                        <i class="fa fa-clock text-primary me-2"></i><?= $exam['duration_minutes'] ?> phút
                    </small>
                </div>
                <div class="text-center p-4 pb-0">
                    <a class="btn btn-primary mb-0 w-100" href="templates/chitietbaithi.php?id=<?= $exam['exam_id'] ?>">Xem chi tiết bài thi</a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
        </div>
    </div>
    <!-- Courses End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Menu</h4>
                    <a class="btn btn-link" href="">Trang chủ</a>
                    <a class="btn btn-link" href="">Về chúng tôi</a>
                    <a class="btn btn-link" href="">Luyện tập kĩ năng nghe</a>
                    <a class="btn btn-link" href="">Luyện tập kĩ năng đọc</a>
                    <a class="btn btn-link" href="">Làm bài thi</a>
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
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Đăng ký</button>
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


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


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