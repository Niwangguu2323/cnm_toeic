<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once __DIR__ . '/../models/ExamModel.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

try {
    $model = new ExamModel();
    $conn = $model->getConn();
    
    if (!$conn) {
        throw new Exception("Không thể kết nối database");
    }
    
    $user_id = (int)$_SESSION['user_id'];

    // Lấy thông tin user
    $user_sql = "SELECT * FROM user WHERE user_id = ?";
    $user_stmt = mysqli_prepare($conn, $user_sql);
    mysqli_stmt_bind_param($user_stmt, "i", $user_id);
    mysqli_stmt_execute($user_stmt);
    $user_result = mysqli_stmt_get_result($user_stmt);
    $user = mysqli_fetch_assoc($user_result);

    // Pagination
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // Filter
    $filter_type = isset($_GET['type']) && $_GET['type'] !== 'all' ? $_GET['type'] : '';
    $filter_date = isset($_GET['date']) ? $_GET['date'] : '';

    // Build query với prepared statements
    $where_conditions = ["er.user_id = ?"];
    $params = [$user_id];
    $types = "i";

    if ($filter_type) {
        $where_conditions[] = "e.type = ?";
        $params[] = $filter_type;
        $types .= "s";
    }
    if ($filter_date) {
        $where_conditions[] = "DATE(er.time) = ?";
        $params[] = $filter_date;
        $types .= "s";
    }

    $where_clause = implode(' AND ', $where_conditions);

    // Lấy lịch sử bài thi
    $history_sql = "
        SELECT 
            er.*,
            e.title,
            e.type,
            e.duration_minutes,
            e.difficulty_level
        FROM exam_result er
        JOIN exam e ON er.exam_id = e.exam_id
        WHERE $where_clause
        ORDER BY er.time DESC
        LIMIT ? OFFSET ?
    ";

    $history_stmt = mysqli_prepare($conn, $history_sql);
    $params[] = $limit;
    $params[] = $offset;
    $types .= "ii";
    
    mysqli_stmt_bind_param($history_stmt, $types, ...$params);
    mysqli_stmt_execute($history_stmt);
    $history_result = mysqli_stmt_get_result($history_stmt);

    // Đếm tổng số bài thi
    $count_sql = "
        SELECT COUNT(*) as total
        FROM exam_result er
        JOIN exam e ON er.exam_id = e.exam_id
        WHERE $where_clause
    ";
    
    // Remove limit and offset params for count query
    $count_params = array_slice($params, 0, -2);
    $count_types = substr($types, 0, -2);
    
    $count_stmt = mysqli_prepare($conn, $count_sql);
    if (!empty($count_params)) {
        mysqli_stmt_bind_param($count_stmt, $count_types, ...$count_params);
    }
    mysqli_stmt_execute($count_stmt);
    $count_result = mysqli_stmt_get_result($count_stmt);
    $total_records = mysqli_fetch_assoc($count_result)['total'];
    $total_pages = ceil($total_records / $limit);

    // Thống kê tổng quan
    $stats_sql = "
        SELECT 
            COUNT(*) as total_exams,
            COALESCE(AVG(total_score), 0) as avg_score,
            COALESCE(MAX(total_score), 0) as best_score,
            COALESCE(MIN(total_score), 0) as lowest_score,
            SUM(CASE WHEN e.type = 'Listening' THEN 1 ELSE 0 END) as listening_count,
            SUM(CASE WHEN e.type = 'Reading' THEN 1 ELSE 0 END) as reading_count,
            SUM(CASE WHEN e.type = 'Full' THEN 1 ELSE 0 END) as full_count
        FROM exam_result er
        JOIN exam e ON er.exam_id = e.exam_id
        WHERE er.user_id = ?
    ";
    $stats_stmt = mysqli_prepare($conn, $stats_sql);
    mysqli_stmt_bind_param($stats_stmt, "i", $user_id);
    mysqli_stmt_execute($stats_stmt);
    $stats_result = mysqli_stmt_get_result($stats_stmt);
    $stats = mysqli_fetch_assoc($stats_result);

    // Thống kê theo tháng (6 tháng gần nhất)
    $monthly_stats_sql = "
        SELECT 
            DATE_FORMAT(er.time, '%Y-%m') as month,
            COUNT(*) as exam_count,
            COALESCE(AVG(er.total_score), 0) as avg_score
        FROM exam_result er
        WHERE er.user_id = ? 
        AND er.time >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
        GROUP BY DATE_FORMAT(er.time, '%Y-%m')
        ORDER BY month DESC
    ";
    $monthly_stmt = mysqli_prepare($conn, $monthly_stats_sql);
    mysqli_stmt_bind_param($monthly_stmt, "i", $user_id);
    mysqli_stmt_execute($monthly_stmt);
    $monthly_result = mysqli_stmt_get_result($monthly_stmt);
    $monthly_stats = [];
    while ($row = mysqli_fetch_assoc($monthly_result)) {
        $monthly_stats[] = $row;
    }

} catch (Exception $e) {
    // Log error và hiển thị thông báo thân thiện
    error_log("Exam History Error: " . $e->getMessage());
    $error_message = "Có lỗi xảy ra khi tải dữ liệu. Vui lòng thử lại sau.";
    
    // Set default values để tránh lỗi
    $stats = [
        'total_exams' => 0,
        'avg_score' => 0,
        'best_score' => 0,
        'lowest_score' => 0,
        'listening_count' => 0,
        'reading_count' => 0,
        'full_count' => 0
    ];
    $monthly_stats = [];
    $total_records = 0;
    $total_pages = 0;
    $history_result = false;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Lịch sử bài thi - 2N Toeic Lab</title>
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

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .history-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .history-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }

        .exam-type-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .exam-type-listening {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
            color: white;
        }

        .exam-type-reading {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .exam-type-full {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            color: white;
        }

        .score-display {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .filter-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            margin-bottom: 2rem;
        }

        .btn-filter {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            color: white;
        }

        .pagination-modern .page-link {
            border: none;
            padding: 0.75rem 1rem;
            margin: 0 0.25rem;
            border-radius: 10px;
            color: #667eea;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pagination-modern .page-link:hover {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: translateY(-2px);
        }

        .pagination-modern .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
        }

        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            margin-bottom: 2rem;
        }

        .difficulty-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .difficulty-easy {
            background: #dcfce7;
            color: #166534;
        }

        .difficulty-medium {
            background: #fef3c7;
            color: #92400e;
        }

        .difficulty-hard {
            background: #fecaca;
            color: #991b1b;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #64748b;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="1000,100 1000,0 0,100"/></svg>');
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        @media (max-width: 768px) {
            .stats-number {
                font-size: 2rem;
            }
            
            .score-display {
                font-size: 1.5rem;
            }
            
            .filter-card {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <?php if (isset($error_message)): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 0; border-radius: 0;">
    <div class="container">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <?= $error_message ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>
   

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="../index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>2NToeicLab</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="../index.php" class="nav-item nav-link">Trang chủ</a>
                <a href="./about.php" class="nav-item nav-link">Về chúng tôi</a>
                <div class="nav-item dropdown">
                    <a href="./practice.php" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Luyện tập</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="./listening.php" class="dropdown-item">Nghe</a>
                        <a href="./reading.php" class="dropdown-item">Đọc</a>
                    </div>
                </div>
                <a href="./test.php" class="nav-item nav-link">Làm bài thi</a>
                <a href="./exam_history.php" class="nav-item nav-link active">Lịch sử</a>
            </div>
            <?php if (isset($_SESSION["user_email"])): ?>
                <div class="nav-item dropdown me-4">
                    <a href="#" class="btn btn-primary dropdown-toggle py-4 px-lg-5 d-none d-lg-block" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-2"></i><?= explode('@', $_SESSION["user_email"])[0] ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="profile.php" class="dropdown-item"><i class="fas fa-user-edit me-2"></i>Sửa thông tin</a>
                        <a href="exam_history.php" class="dropdown-item"><i class="fas fa-history me-2"></i>Lịch sử bài thi</a>
                        <a href="logout.php" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a>
                       <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <div class="dropdown-divider"></div>
                            <a href="../admin/exam_manage.php" class="dropdown-item"><i class="fas fa-tasks me-2"></i>Quản lý bài thi</a>
                            <a href="../admin/user_manage.php" class="dropdown-item"><i class="fas fa-users me-2"></i>Quản lý người dùng</a>
                            
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Đăng nhập<i class="fa fa-arrow-right ms-3"></i></a>
            <?php endif; ?>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Hero Section Start -->
    <div class="hero-section">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeInDown">
                    <i class="fas fa-history me-3"></i>Lịch sử bài thi
                </h1>
                <p class="lead mb-4 animate__animated animate__fadeInUp">
                    Xem lại hành trình học tập và theo dõi tiến bộ của bạn
                </p>
                <div class="row justify-content-center animate__animated animate__fadeInUp">
                    <div class="col-md-3 col-6 mb-3">
                        <div class="stats-card">
                            <div class="stats-number"><?= $stats['total_exams'] ?? 0 ?></div>
                            <div>Tổng bài thi</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="stats-card">
                            <div class="stats-number"><?= $stats['avg_score'] ? round($stats['avg_score']) : 0 ?></div>
                            <div>Điểm trung bình</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="stats-card">
                            <div class="stats-number"><?= $stats['best_score'] ?? 0 ?></div>
                            <div>Điểm cao nhất</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="stats-card">
                            <div class="stats-number"><?= ($stats['listening_count'] + $stats['reading_count'] + $stats['full_count']) ?? 0 ?></div>
                            <div>Bài hoàn thành</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section End -->

    <!-- Main Content Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <!-- Chart Section -->
            <?php if (!empty($monthly_stats)): ?>
            <div class="row mb-5">
                <div class="col-12">
                    <div class="chart-container">
                        <h4 class="mb-4"><i class="fas fa-chart-line me-2 text-primary"></i>Biểu đồ tiến bộ 6 tháng gần nhất</h4>
                        <canvas id="progressChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="filter-card">
                        <h5 class="mb-3"><i class="fas fa-filter me-2 text-primary"></i>Bộ lọc</h5>
                        <form method="GET" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Loại bài thi</label>
                                <select name="type" class="form-select">
                                    <option value="all" <?= $filter_type === 'all' ? 'selected' : '' ?>>Tất cả</option>
                                    <option value="Listening" <?= $filter_type === 'Listening' ? 'selected' : '' ?>>Listening</option>
                                    <option value="Reading" <?= $filter_type === 'Reading' ? 'selected' : '' ?>>Reading</option>
                                    <option value="Full" <?= $filter_type === 'Full' ? 'selected' : '' ?>>Full TOEIC</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Ngày thi</label>
                                <input type="date" name="date" class="form-select" value="<?= $filter_date ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-filter me-2">
                                        <i class="fas fa-search me-2"></i>Lọc
                                    </button>
                                    <a href="exam_history.php" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Xóa bộ lọc
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- History List -->
            <div class="row">
    <?php if (isset($history_result) && $history_result && mysqli_num_rows($history_result) > 0): ?>
        <?php while ($exam = mysqli_fetch_assoc($history_result)): ?>
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="history-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title mb-2"><?= htmlspecialchars($exam['title']) ?></h5>
                                <div class="d-flex gap-2 mb-2">
                                    <span class="exam-type-badge exam-type-<?= strtolower($exam['type']) ?>">
                                        <?= $exam['type'] ?>
                                    </span>
                                    <span class="difficulty-badge difficulty-<?= strtolower($exam['difficulty_level']) ?>">
                                        <?= ucfirst($exam['difficulty_level']) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="score-display"><?= $exam['total_score'] ?></div>
                                <small class="text-muted">/ <?= $exam['type'] === 'Full' ? '990' : '495' ?></small>
                            </div>
                        </div>

                        <?php if ($exam['type'] === 'Full' && $exam['listening_score'] && $exam['reading_score']): ?>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <div class="fw-bold text-info"><?= $exam['listening_score'] ?></div>
                                        <small class="text-muted">Listening</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <div class="fw-bold text-success"><?= $exam['reading_score'] ?></div>
                                        <small class="text-muted">Reading</small>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                <i class="fas fa-calendar me-2"></i>
                                <?= date('d/m/Y H:i', strtotime($exam['time'])) ?>
                            </div>
                            <div class="text-muted">
                                <i class="fas fa-clock me-2"></i>
                                <?= $exam['duration_minutes'] ?> phút
                            </div>
                        </div>

                        <div class="mt-3">
                            <a href="examdetails.php?id=<?= $exam['exam_id'] ?>" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-2"></i>Xem chi tiết
                            </a>
                            <a href="examdetails.php?id=<?= $exam['exam_id'] ?>" class="btn btn-primary btn-sm ms-2">
                                <i class="fas fa-redo me-2"></i>Làm lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-clipboard-list"></i>
                <h4>Chưa có lịch sử bài thi</h4>
                <p class="mb-4">Bạn chưa hoàn thành bài thi nào. Hãy bắt đầu làm bài thi đầu tiên!</p>
                <a href="test.php" class="btn btn-primary btn-lg">
                    <i class="fas fa-play me-2"></i>Bắt đầu làm bài thi
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="row mt-5">
                    <div class="col-12">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-modern justify-content-center">
                                <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $page - 1 ?>&type=<?= $filter_type ?>&date=<?= $filter_date ?>">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>&type=<?= $filter_type ?>&date=<?= $filter_date ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($page < $total_pages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $page + 1 ?>&type=<?= $filter_type ?>&date=<?= $filter_date ?>">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Main Content End -->

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
    <script src="../public/libs/wow/wow.min.js"></script>
    <script src="../public/libs/easing/easing.min.js"></script>
    <script src="../public/libs/waypoints/waypoints.min.js"></script>
    <script src="../public/libs/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../public/js/main.js"></script>

    <!-- Chart Script -->
    <?php if (!empty($monthly_stats)): ?>
    <script>
        // Prepare data for chart
        const monthlyData = <?= json_encode(array_reverse($monthly_stats)) ?>;
        const labels = monthlyData.map(item => {
            const date = new Date(item.month + '-01');
            return date.toLocaleDateString('vi-VN', { month: 'long', year: 'numeric' });
        });
        const examCounts = monthlyData.map(item => parseInt(item.exam_count));
        const avgScores = monthlyData.map(item => parseFloat(item.avg_score));

        // Create chart
        const ctx = document.getElementById('progressChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Số bài thi',
                    data: examCounts,
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    yAxisID: 'y'
                }, {
                    label: 'Điểm trung bình',
                    data: avgScores,
                    borderColor: '#764ba2',
                    backgroundColor: 'rgba(118, 75, 162, 0.1)',
                    tension: 0.4,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Tháng'
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Số bài thi'
                        },
                        beginAtZero: true
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Điểm trung bình'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                        beginAtZero: true,
                        max: 990
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false
                    }
                }
            }
        });
    </script>
    <?php endif; ?>

    <script>
        // Add animation to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.history-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Add hover effects
        document.querySelectorAll('.history-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>
