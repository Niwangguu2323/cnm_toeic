<?php
session_start();
?>
<?php
require_once __DIR__ . '/../models/ExamModel.php';

$model = new ExamModel();
$exams = $model->getAllFullExams();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>2N Toeic Lab - Luyện Thi</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
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
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3">2NToeicLab</i></h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="../index.php" class="nav-item nav-link">Trang chủ</a>
                <a href="about.php" class="nav-item nav-link">Về chúng tôi</a>
                <div class="nav-item dropdown">
                    <a href="test.php" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Luyện tập</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="listening.php" class="dropdown-item">Nghe</a>
                        <a href="reading.php" class="dropdown-item">Đọc</a>
                    </div>
                </div>
                <a href="test.php" class="nav-item nav-link active">Làm bài thi</a>
            </div>
            <?php if (isset($_SESSION["user_email"])): ?>
                <div class="nav-item dropdown me-4">
                    <a href="#" class="btn btn-primary dropdown-toggle py-4 px-lg-5 d-none d-lg-block" data-bs-toggle="dropdown">
                        <?= explode('@', $_SESSION["user_email"])[0] ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="profile.php" class="dropdown-item">Sửa thông tin</a>
                        <a href="exam_history.php" class="dropdown-item"><i class="fas fa-history me-2"></i>Lịch sử bài thi</a>
                        <a href="logout.php" class="dropdown-item text-danger">Đăng xuất</a>
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <div class="dropdown-divider"></div>
                            <a href="../admin/exam_manage.php" class="dropdown-item">Quản lý bài thi</a>
                            <a href="../admin/user_manage.php" class="dropdown-item">Quản lý người dùng</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Đăng nhập<i class="fa fa-arrow-right ms-3"></i></a>
            <?php endif; ?>
        </div>
    </nav>
    <!-- Navbar End -->



    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Luyện thi</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Listening test list Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Các bài luyện thi</h6>
            </div>
             <div class="container">
        <div class="row g-4 justify-content-center">
            <?php if (!empty($exams)): ?>
                <?php foreach ($exams as $index => $exam): ?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="<?= 0.1 * ($index + 1) ?>s">
                        <div class="course-item bg-light">
                            <div class="text-center p-4 pb-0">
                                <h3 class="mb-0"><?= htmlspecialchars($exam['title']) ?></h3>
                            </div>
                            <div class="d-flex border-top">
                                <small class="flex-fill text-center border-end py-2">
                                    <i class="fa fa-user-tie text-primary me-2"></i>Năm 2025
                                </small>
                                <small class="flex-fill text-center border-end py-2">
                                    <i class="fa fa-clock text-primary me-2"></i><?= $exam['duration_minutes'] ?> phút
                                </small>
                            </div>
                            <div class="text-center p-4 pb-0">
                                <a class="btn btn-primary mb-3 w-100" href="examdetails.php?id=<?= $exam['exam_id'] ?>">
                                    Xem chi tiết bài thi
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Không có bài thi nghe nào trong hệ thống.</p>
            <?php endif; ?>
        </div>
    </div>
        </div> 
    </div>
    <!-- Listening test list end -->


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


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/wowjs@1.1.3/dist/wow.min.js"></script>
    <script> new WOW().init(); </script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>