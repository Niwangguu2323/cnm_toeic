<?php
session_start();
require_once __DIR__ . '/../models/ExamModel.php';

$model = new ExamModel();
$exam_id = $_GET['id'] ?? 0;

$conn = $model->getConn();

$exam_sql = "SELECT * FROM exam WHERE exam_id = $exam_id";
$exam_result = mysqli_query($conn, $exam_sql);
$exam = mysqli_fetch_assoc($exam_result);

if (!$exam) {
    echo "<p>Không tìm thấy đề thi.</p>";
    exit;
}

// HÀM QUY ĐỔI ĐIỂM THEO BẢNG TOEIC
function quyDoiDiemReading($soCauDung) {
    $bangDiem = [
        0 => 5, 1 => 5, 2 => 5, 3 => 10, 4 => 15, 5 => 20,
        6 => 25, 7 => 30, 8 => 35, 9 => 40, 10 => 45, 11 => 50, 12 => 55,
        13 => 60, 14 => 65, 15 => 70, 16 => 75, 17 => 80, 18 => 85, 19 => 90,
        20 => 95, 21 => 100, 22 => 105, 23 => 110, 24 => 115, 25 => 120,
        26 => 125, 27 => 130, 28 => 135, 29 => 140, 30 => 145, 31 => 150,
        32 => 155, 33 => 160, 34 => 165, 35 => 170, 36 => 175, 37 => 180,
        38 => 185, 39 => 190, 40 => 195, 41 => 200, 42 => 205, 43 => 210,
        44 => 215, 45 => 220, 46 => 225, 47 => 230, 48 => 235, 49 => 240,
        50 => 245, 51 => 250, 52 => 255, 53 => 260, 54 => 265, 55 => 270,
        56 => 275, 57 => 280, 58 => 285, 59 => 290, 60 => 295, 61 => 300,
        62 => 305, 63 => 310, 64 => 315, 65 => 320, 66 => 325, 67 => 330,
        68 => 335, 69 => 340, 70 => 345, 71 => 350, 72 => 355, 73 => 360,
        74 => 365, 75 => 370, 76 => 375, 77 => 380, 78 => 385, 79 => 390,
        80 => 395, 81 => 400, 82 => 405, 83 => 410, 84 => 415, 85 => 420,
        86 => 425, 87 => 430, 88 => 435, 89 => 440, 90 => 445, 91 => 450,
        92 => 455, 93 => 460, 94 => 465, 95 => 470, 96 => 475, 97 => 480,
        98 => 485, 99 => 490, 100 => 495
    ];
    return $bangDiem[min(100, max(0, $soCauDung))];
}

function quyDoiDiemListening($soCauDung) {
    $bangDiem = [
        0 => 5, 1 => 15, 2 => 20, 3 => 25, 4 => 30, 5 => 35, 6 => 40,
        7 => 45, 8 => 50, 9 => 55, 10 => 60, 11 => 70, 12 => 75, 13 => 80,
        14 => 85, 15 => 90, 16 => 95, 17 => 100, 18 => 105, 19 => 110,
        20 => 115, 21 => 120, 22 => 125, 23 => 130, 24 => 135, 25 => 140,
        26 => 145, 27 => 150, 28 => 155, 29 => 160, 30 => 165, 31 => 170,
        32 => 175, 33 => 180, 34 => 185, 35 => 190, 36 => 195, 37 => 200,
        38 => 205, 39 => 210, 40 => 215, 41 => 220, 42 => 225, 43 => 230,
        44 => 235, 45 => 240, 46 => 245, 47 => 250, 48 => 255, 49 => 260,
        50 => 265, 51 => 270, 52 => 275, 53 => 280, 54 => 285, 55 => 290,
        56 => 295, 57 => 300, 58 => 305, 59 => 310, 60 => 315, 61 => 320,
        62 => 325, 63 => 330, 64 => 335, 65 => 340, 66 => 345, 67 => 350,
        68 => 355, 69 => 360, 70 => 365, 71 => 370, 72 => 375, 73 => 380,
        74 => 385, 75 => 390, 76 => 395, 77 => 400, 78 => 405, 79 => 410,
        80 => 415, 81 => 420, 82 => 425, 83 => 430, 84 => 435, 85 => 440,
        86 => 445, 87 => 450, 88 => 455, 89 => 460, 90 => 465, 91 => 470,
        92 => 475, 93 => 480, 94 => 485, 95 => 490, 96 => 495, 97 => 495,
        98 => 495, 99 => 495, 100 => 495
    ];
    return $bangDiem[min(100, max(0, $soCauDung))];
}

// Hàm render câu hỏi với kết quả
function renderQuestionWithResults($q, $cauSo, $detailed_results, $show_results) {
    $qid = $q['question_id'];
    $user_answer = $detailed_results[$qid]['user_answer'] ?? null;
    $correct_answer = $detailed_results[$qid]['correct_answer'] ?? $q['correct_answer'];
    $is_correct = $detailed_results[$qid]['is_correct'] ?? null;
    
    ob_start(); // Bắt đầu output buffering
    ?>
    <div class="question-container animate-fade-in">
        <div class="d-flex align-items-start">
            <div class="question-number"><?= $cauSo ?></div>
            <div class="flex-grow-1">
                <div class="question-text">
                    <?= htmlspecialchars($q['content']) ?>
                    <?php if ($show_results && $is_correct !== null): ?>
                        <span class="correct-answer-indicator">
                            <i class="fas fa-<?= $is_correct ? 'check' : 'times' ?>"></i>
                            <?= $is_correct ? 'Đúng' : 'Sai' ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="option-group">
                    <?php foreach (['A','B','C','D'] as $i => $opt): 
                        $is_user_choice = ($user_answer === $opt);
                        $is_correct_choice = ($correct_answer === $opt);
                        
                        $option_class = '';
                        if ($show_results) {
                            if ($is_correct_choice && $is_user_choice) {
                                // Đáp án đúng và được chọn - màu xanh
                                $option_class = 'result-option correct';
                            } elseif ($is_correct_choice && !$is_user_choice) {
                                // Đáp án đúng nhưng không được chọn - màu vàng
                                $option_class = 'result-option correct-not-selected';
                            } elseif ($is_user_choice && !$is_correct_choice) {
                                // Đáp án sai được chọn - màu đỏ
                                $option_class = 'result-option incorrect';
                            } else {
                                // Đáp án không được chọn - mờ đi
                                $option_class = 'result-option not-selected';
                            }
                        }
                    ?>
                        <div class="option-item">
                            <input type="radio" 
                                   name="<?= $q['question_id'] ?>" 
                                   value="<?= $opt ?>" 
                                   id="q<?= $q['question_id'] . $opt ?>" 
                                   <?= $show_results ? 'disabled' : 'disabled' ?>
                                   <?= $is_user_choice ? 'checked' : '' ?>>
                            <label class="option-label <?= $option_class ?>" for="q<?= $q['question_id'] . $opt ?>">
                                <div class="option-letter"><?= $opt ?></div>
                                <div><?= htmlspecialchars($q["option_" . ($i + 1)]) ?></div>
                                <?php if ($show_results): ?>
                                    <?php if ($is_correct_choice && $is_user_choice): ?>
                                        <div class="result-icon correct">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                    <?php elseif ($is_correct_choice && !$is_user_choice): ?>
                                        <div class="result-icon" style="color: #f59e0b;">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </div>
                                    <?php elseif ($is_user_choice && !$is_correct_choice): ?>
                                        <div class="result-icon incorrect">
                                            <i class="fas fa-times-circle"></i>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if ($show_results && $is_correct !== null): ?>
                    <div class="question-result-summary <?= $is_correct ? 'correct' : 'incorrect' ?>">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-<?= $is_correct ? 'check-circle' : 'times-circle' ?> 
                               text-<?= $is_correct ? 'success' : 'danger' ?>"></i>
                            <strong>
                                <?php if ($is_correct): ?>
                                    Chính xác! Bạn đã chọn đáp án đúng.
                                <?php else: ?>
                                    Bạn đã chọn: <?= $user_answer ?> | Đáp án đúng: <?= $correct_answer ?>
                                <?php endif; ?>
                            </strong>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean(); // Trả về nội dung đã buffer
}

// CHẤM ĐIỂM
$ketQua = "";
// Lưu trữ kết quả chấm điểm chi tiết
$detailed_results = [];
$show_results = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $soCauDungListening = 0;
    $soCauDungReading = 0;
    $tongCauListening = 0;
    $tongCauReading = 0;

    // Đếm tổng số câu theo từng loại
    if ($exam['type'] === 'Full') {
        // Đếm câu Listening
        $listening_count_sql = "SELECT COUNT(*) AS total FROM exam_question WHERE exam_id = $exam_id AND listening_id IS NOT NULL";
        $listening_count_result = mysqli_query($conn, $listening_count_sql);
        $listening_count_row = mysqli_fetch_assoc($listening_count_result);
        $tongCauListening = (int)($listening_count_row['total'] ?? 0);

        // Đếm câu Reading
        $reading_count_sql = "SELECT COUNT(*) AS total FROM exam_question WHERE exam_id = $exam_id AND (passage_id IS NOT NULL OR (listening_id IS NULL AND passage_id IS NULL))";
        $reading_count_result = mysqli_query($conn, $reading_count_sql);
        $reading_count_row = mysqli_fetch_assoc($reading_count_result);
        $tongCauReading = (int)($reading_count_row['total'] ?? 0);
    } else {
        // Đếm tổng số câu cho bài thi đơn lẻ
        $tong_sql = "SELECT COUNT(*) AS total FROM exam_question WHERE exam_id = $exam_id";
        $tong_result = mysqli_query($conn, $tong_sql);
        $tong_row = mysqli_fetch_assoc($tong_result);
        if ($exam['type'] === 'Reading') {
            $tongCauReading = (int)($tong_row['total'] ?? 0);
        } else {
            $tongCauListening = (int)($tong_row['total'] ?? 0);
        }
    }

    // Chấm điểm từng câu và lưu kết quả chi tiết
    foreach ($_POST as $qid => $traloi) {
        if (!is_numeric($qid)) continue;
        $qid = (int)$qid;
        $traloi = mysqli_real_escape_string($conn, $traloi);

        $sql = "SELECT correct_answer, listening_id, passage_id FROM exam_question WHERE question_id = $qid";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        
        if ($row) {
            $is_correct = strtoupper($row['correct_answer']) === strtoupper($traloi);
            
            // Lưu kết quả chi tiết
            $detailed_results[$qid] = [
                'user_answer' => $traloi,
                'correct_answer' => $row['correct_answer'],
                'is_correct' => $is_correct
            ];
            
            if ($is_correct) {
                // Phân loại câu đúng theo Listening hoặc Reading
                if (!empty($row['listening_id'])) {
                    $soCauDungListening++;
                } else {
                    $soCauDungReading++;
                }
            }
        }
    }

    $show_results = true;

    // Tính điểm theo loại bài thi
    $reading_score = null;
    $listening_score = null;
    $total_score = 0;

    if ($exam['type'] === 'Full') {
        $reading_score = quyDoiDiemReading($soCauDungReading);
        $listening_score = quyDoiDiemListening($soCauDungListening);
        $total_score = $reading_score + $listening_score;
        
        $ketQua = "🎯 <strong>Kết quả bài thi Full TOEIC:</strong><br>";
        $ketQua .= "🎧 Listening: <strong>$soCauDungListening / $tongCauListening</strong> câu đúng - Điểm: <strong>$listening_score</strong><br>";
        $ketQua .= "📘 Reading: <strong>$soCauDungReading / $tongCauReading</strong> câu đúng - Điểm: <strong>$reading_score</strong><br>";
        $ketQua .= "🏆 <strong>Tổng điểm TOEIC: $total_score / 990</strong>";
    } elseif ($exam['type'] === 'Reading') {
        $reading_score = quyDoiDiemReading($soCauDungReading);
        $total_score = $reading_score;
        $ketQua = "🎯 Bạn đã làm đúng <strong>$soCauDungReading / $tongCauReading</strong> câu hỏi!<br>";
        $ketQua .= "📘 Điểm Reading (quy đổi): <strong>$reading_score</strong>";
    } else {
        $listening_score = quyDoiDiemListening($soCauDungListening);
        $total_score = $listening_score;
        $ketQua = "🎯 Bạn đã làm đúng <strong>$soCauDungListening / $tongCauListening</strong> câu hỏi!<br>";
        $ketQua .= "🎧 Điểm Listening (quy đổi): <strong>$listening_score</strong>";
    }

    // Lưu kết quả vào database
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $date = date('Y-m-d');

        $insert_sql = "INSERT INTO exam_result (user_id, exam_id, listening_score, reading_score, total_score, time)
                       VALUES ($user_id, $exam_id, ". ($listening_score ?? 'NULL') . ", ". ($reading_score ?? 'NULL') . ", $total_score, '$date')";

        mysqli_query($conn, $insert_sql);
    }
}

// Lấy dữ liệu cho bài thi
$passages = [];
$listenings = [];
$questions = [];

// Lấy passages cho Reading
if ($exam['type'] === 'Reading' || $exam['type'] === 'Full') {
    $passage_sql = "SELECT * FROM reading_passage WHERE exam_id = $exam_id";
    $passage_result = mysqli_query($conn, $passage_sql);
    while ($row = mysqli_fetch_assoc($passage_result)) {
        $passages[$row['passage_id']] = $row['content'];
    }
}

// Lấy listenings cho Listening
if ($exam['type'] === 'Listening' || $exam['type'] === 'Full') {
    $lsql = "SELECT * FROM listening WHERE exam_id = $exam_id";
    $lresult = mysqli_query($conn, $lsql);
    while ($row = mysqli_fetch_assoc($lresult)) {
        $listenings[$row['listening_id']] = [
            'content' => $row['content'],
            'audio_url' => $row['audio_url']
        ];
    }
}

// Lấy câu hỏi
$question_sql = "SELECT * FROM exam_question WHERE exam_id = $exam_id ORDER BY listening_id ASC, passage_id ASC, question_id ASC";
$question_result = mysqli_query($conn, $question_sql);
while ($row = mysqli_fetch_assoc($question_result)) {
    $questions[] = $row;
}

// Gom nhóm câu hỏi
$grouped_questions = [];
$grouped_listening_questions = [];
$no_passage_questions = [];
$no_listening_questions = [];

foreach ($questions as $q) {
    if (!empty($q['listening_id'])) {
        $grouped_listening_questions[$q['listening_id']][] = $q;
    } elseif (!empty($q['passage_id'])) {
        $grouped_questions[$q['passage_id']][] = $q;
    } else {
        if ($exam['type'] === 'Reading' || ($exam['type'] === 'Full' && empty($q['listening_id']))) {
            $no_passage_questions[] = $q;
        } else {
            $no_listening_questions[] = $q;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết bài thi: <?= htmlspecialchars($exam['title']) ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <!-- Thêm vào phần head -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
     <!-- Template Stylesheet -->
    <link href="../public/css/examdetails_style.css" rel="stylesheet">
</head>
<body>
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
                <a href="../index.php" class="nav-item nav-link active">Trang chủ</a>
                <a href="./about.php" class="nav-item nav-link">Về chúng tôi</a>
                <div class="nav-item dropdown">
                    <a href="templates/practice.php" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Luyện tập</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="./listening.php" class="dropdown-item">Nghe</a>
                        <a href="./reading.php" class="dropdown-item">Đọc</a>
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
                        <a href="./profile.php" class="dropdown-item">Sửa thông tin</a>
                        <a href="./logout.php" class="dropdown-item text-danger">Đăng xuất</a>
                        <a href="./exam_history.php" class="dropdown-item"><i class="fas fa-history me-2"></i>Lịch sử bài thi</a>
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <div class="dropdown-divider"></div>
                            <a href="../admin/exam_manage.php" class="dropdown-item">Quản lý bài thi</a>
                            <a href="../admin/user_manage.php" class="dropdown-item">Quản lý người dùng</a>
                        <?php endif; ?>
                    </div>
                </div> 
            <?php else: ?>
                <a href="./login.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Đăng nhập<i class="fa fa-arrow-right ms-3"></i></a>
            <?php endif; ?>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Exam Header -->
    <div class="exam-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="exam-title animate__animated animate__fadeInDown">
                        <?= htmlspecialchars($exam['title']) ?>
                    </h1>
                    <div class="exam-meta animate__animated animate__fadeInUp">
                        <div class="exam-meta-item">
                            <i class="fas fa-tag"></i>
                            <span><?= $exam['type'] ?></span>
                        </div>
                        <div class="exam-meta-item">
                            <i class="fas fa-clock"></i>
                            <span><?= $exam['duration_minutes'] ?> phút</span>
                        </div>
                        <div class="exam-meta-item">
                            <i class="fas fa-signal"></i>
                            <span>Độ khó: <?= $exam['difficulty_level'] ?></span>
                        </div>
                    </div>
                    
                    <?php if ($exam['type'] === 'Full'): ?>
                        <div class="alert alert-info alert-modern animate__animated animate__fadeInUp">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Bài thi Full TOEIC</strong> - Bao gồm cả phần Listening và Reading
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="content-wrapper">
                
                <!-- Result Display -->
                <?php if ($ketQua): ?>
                    <div class="result-container animate__animated animate__bounceIn">
                        <div class="result-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="result-text"><?= $ketQua ?></div>
                    </div>
                <?php endif; ?>

                <!-- Login Warning -->
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <div class="alert alert-warning alert-modern">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Vui lòng <a href="login.php" class="fw-bold">đăng nhập</a> để làm bài thi và lưu kết quả.
                    </div>
                <?php endif; ?>

                <!-- Timer -->
                <div id="countdown-timer" class="timer-container" style="display: none;">
                    <div class="timer-card">
                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <i class="fas fa-stopwatch fa-2x"></i>
                            <div>
                                <div class="fw-bold">Thời gian còn lại</div>
                                <div id="timer" class="timer-display">--:--</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div id="progress-container" class="progress-container" style="display: none;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold">Tiến độ làm bài</span>
                        <span id="progress-text">0%</span>
                    </div>
                    <div class="progress-bar-custom">
                        <div id="progress-fill" class="progress-fill"></div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <button id="startExamBtn" class="btn btn-modern btn-start">
                            <i class="fas fa-play me-2"></i>Bắt đầu làm bài
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Exam Form -->
                <form method="POST" id="submitForm">
                    <button type="submit" class="btn btn-modern btn-submit d-none" id="submitExamBtn">
                        <i class="fas fa-paper-plane me-2"></i>Nộp bài thi
                    </button>

                    <?php $cauSo = 1; ?>

                    <?php if ($exam['type'] === 'Full'): ?>
                        <!-- PHẦN LISTENING -->
                        <div class="section-header listening animate-fade-in">
                            <div class="section-title">
                                <div class="section-icon listening">
                                    <i class="fas fa-headphones"></i>
                                </div>
                                <div>
                                    <h2 class="mb-0">PHẦN I: LISTENING COMPREHENSION</h2>
                                    <small class="text-muted">Phần nghe hiểu</small>
                                </div>
                            </div>
                        </div>
                        
                        <?php foreach ($listenings as $lid => $info): ?>
                            <div class="audio-container animate-fade-in">
                                <div class="audio-header">
                                    <div class="audio-icon">
                                        <i class="fas fa-volume-up"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Đoạn nghe</h5>
                                        <small class="text-muted">Nghe và trả lời các câu hỏi</small>
                                    </div>
                                </div>
                                <p class="mb-3"><?= nl2br(htmlspecialchars($info['content'])) ?></p>
                                <audio controls class="audio-player">
                                    <source src="../public/<?= htmlspecialchars($info['audio_url']) ?>" type="audio/mpeg">
                                    Trình duyệt của bạn không hỗ trợ phát audio.
                                </audio>
                                
                                <?php foreach ($grouped_listening_questions[$lid] ?? [] as $q): ?>
                                    <?php echo renderQuestionWithResults($q, $cauSo++, $detailed_results, $show_results); ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>

                        <!-- PHẦN READING -->
                        <div class="section-header reading animate-fade-in">
                            <div class="section-title">
                                <div class="section-icon reading">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <div>
                                    <h2 class="mb-0">PHẦN II: READING COMPREHENSION</h2>
                                    <small class="text-muted">Phần đọc hiểu</small>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($no_passage_questions)): ?>
                            <div class="passage-container animate-fade-in">
                                <div class="passage-header">
                                    <div class="passage-icon">
                                        <i class="fas fa-spell-check"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Ngữ pháp và từ vựng</h5>
                                        <small class="text-muted">Chọn đáp án đúng nhất</small>
                                    </div>
                                </div>
                                <?php foreach ($no_passage_questions as $q): ?>
                                    <?php echo renderQuestionWithResults($q, $cauSo++, $detailed_results, $show_results); ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php foreach ($passages as $pid => $content): ?>
                            <div class="passage-container animate-fade-in">
                                <div class="passage-header">
                                    <div class="passage-icon">
                                        <i class="fas fa-file-text"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Đoạn văn</h5>
                                        <small class="text-muted">Đọc đoạn văn và trả lời câu hỏi</small>
                                    </div>
                                </div>
                                <div class="passage-content">
                                    <?= nl2br(htmlspecialchars($content)) ?>
                                </div>
                                <?php foreach ($grouped_questions[$pid] ?? [] as $q): ?>
                                    <?php echo renderQuestionWithResults($q, $cauSo++, $detailed_results, $show_results); ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>

                    <?php elseif ($exam['type'] === 'Reading'): ?>
                        <div class="section-header reading animate-fade-in">
                            <div class="section-title">
                                <div class="section-icon reading">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <div>
                                    <h2 class="mb-0">READING COMPREHENSION</h2>
                                    <small class="text-muted">Phần đọc hiểu</small>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($no_passage_questions)): ?>
                            <div class="passage-container animate-fade-in">
                                <div class="passage-header">
                                    <div class="passage-icon">
                                        <i class="fas fa-spell-check"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Ngữ pháp và từ vựng</h5>
                                        <small class="text-muted">Chọn đáp án đúng nhất</small>
                                    </div>
                                </div>
                                <?php foreach ($no_passage_questions as $q): ?>
                                    <?php echo renderQuestionWithResults($q, $cauSo++, $detailed_results, $show_results); ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php foreach ($passages as $pid => $content): ?>
                            <div class="passage-container animate-fade-in">
                                <div class="passage-header">
                                    <div class="passage-icon">
                                        <i class="fas fa-file-text"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Đoạn văn</h5>
                                        <small class="text-muted">Đọc đoạn văn và trả lời câu hỏi</small>
                                    </div>
                                </div>
                                <div class="passage-content">
                                    <?= nl2br(htmlspecialchars($content)) ?>
                                </div>
                                <?php foreach ($grouped_questions[$pid] ?? [] as $q): ?>
                                    <?php echo renderQuestionWithResults($q, $cauSo++, $detailed_results, $show_results); ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>

                    <?php elseif ($exam['type'] === 'Listening'): ?>
                        <div class="section-header listening animate-fade-in">
                            <div class="section-title">
                                <div class="section-icon listening">
                                    <i class="fas fa-headphones"></i>
                                </div>
                                <div>
                                    <h2 class="mb-0">LISTENING COMPREHENSION</h2>
                                    <small class="text-muted">Phần nghe hiểu</small>
                                </div>
                            </div>
                        </div>

                        <?php foreach ($listenings as $lid => $info): ?>
                            <div class="audio-container animate-fade-in">
                                <div class="audio-header">
                                    <div class="audio-icon">
                                        <i class="fas fa-volume-up"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Đoạn nghe</h5>
                                        <small class="text-muted">Nghe và trả lời các câu hỏi</small>
                                    </div>
                                </div>
                                <p class="mb-3"><?= nl2br(htmlspecialchars($info['content'])) ?></p>
                                <audio controls class="audio-player">
                                    <source src="../public/<?= htmlspecialchars($info['audio_url']) ?>" type="audio/mpeg">
                                    Trình duyệt của bạn không hỗ trợ phát audio.
                                </audio>
                                
                                <?php foreach ($grouped_listening_questions[$lid] ?? [] as $q): ?>
                                    <?php echo renderQuestionWithResults($q, $cauSo++, $detailed_results, $show_results); ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <div class="text-center mt-5">
                        <button type="submit" class="btn btn-modern btn-submit btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Nộp bài thi
                        </button>
                    </div>
                </form>
                <?php if ($show_results): ?>
    <!-- Results Legend -->
    <div class="results-legend animate__animated animate__fadeInUp">
        <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>Chú thích kết quả</h5>
        <div class="row">
            <div class="col-md-3">
                <div class="legend-item">
                    <div class="legend-color correct">
                        <i class="fas fa-check"></i>
                    </div>
                    <span>Đáp án đúng bạn chọn</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="legend-item">
                    <div class="legend-color correct-not-selected">
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <span>Đáp án đúng bạn bỏ lỡ</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="legend-item">
                    <div class="legend-color incorrect">
                        <i class="fas fa-times"></i>
                    </div>
                    <span>Đáp án bạn chọn sai</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="legend-item">
                    <div class="legend-color not-answered">
                        <i class="fas fa-minus"></i>
                    </div>
                    <span>Đáp án không được chọn</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Summary -->
    <div class="results-summary-card animate__animated animate__fadeInUp">
        <h4 class="mb-3"><i class="fas fa-chart-bar me-2"></i>Thống kê chi tiết</h4>
        <div class="summary-stats">
            <?php 
            $total_questions = count($detailed_results);
            $correct_count = array_sum(array_column($detailed_results, 'is_correct'));
            $incorrect_count = $total_questions - $correct_count;
            $accuracy = $total_questions > 0 ? round(($correct_count / $total_questions) * 100, 1) : 0;
            ?>
            <div class="stat-item">
                <div class="stat-number total"><?= $total_questions ?></div>
                <div class="stat-label">Tổng số câu</div>
            </div>
            <div class="stat-item">
                <div class="stat-number correct"><?= $correct_count ?></div>
                <div class="stat-label">Câu đúng</div>
            </div>
            <div class="stat-item">
                <div class="stat-number incorrect"><?= $incorrect_count ?></div>
                <div class="stat-label">Câu sai</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" style="color: <?= $accuracy >= 70 ? '#16a34a' : ($accuracy >= 50 ? '#d97706' : '#dc2626') ?>">
                    <?= $accuracy ?>%
                </div>
                <div class="stat-label">Độ chính xác</div>
            </div>
        </div>
    </div>
<?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-0">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Menu</h4>
                    <a class="btn btn-link text-light" href="">Trang chủ</a>
                    <a class="btn btn-link text-light" href="">Về chúng tôi</a>
                    <a class="btn btn-link text-light" href="">Luyện tập kĩ năng nghe</a>
                    <a class="btn btn-link text-light" href="">Luyện tập kĩ năng đọc</a>
                    <a class="btn btn-link text-light" href="">Làm bài thi</a>
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
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top" id="backToTop">
        <i class="bi bi-arrow-up"></i>
    </a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Start Exam Function
        document.getElementById('startExamBtn')?.addEventListener('click', function () {
            // Hide start button, show submit button
            this.classList.add('d-none');
            document.getElementById('submitExamBtn').classList.remove('d-none');

            // Enable all radio buttons
            document.querySelectorAll('input[type=radio]').forEach(input => {
                input.disabled = false;
            });

            // Show timer and progress
            document.getElementById('countdown-timer').style.display = 'block';
            document.getElementById('progress-container').style.display = 'block';

            // Start countdown timer
            let durationMinutes = <?= (int) $exam['duration_minutes'] ?>;
            let remainingTime = durationMinutes * 60;
            const totalTime = remainingTime;

            const timerDisplay = document.getElementById('timer');
            const timerInterval = setInterval(() => {
                const minutes = Math.floor(remainingTime / 60);
                const seconds = remainingTime % 60;
                timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                remainingTime--;

                // Update progress bar
                const progress = ((totalTime - remainingTime) / totalTime) * 100;
                document.getElementById('progress-fill').style.width = progress + '%';
                document.getElementById('progress-text').textContent = Math.round(progress) + '%';

                // Change timer color when time is running low
                if (remainingTime < 300) { // Last 5 minutes
                    timerDisplay.parentElement.parentElement.style.background = 'linear-gradient(135deg, #dc2626, #ef4444)';
                }

                if (remainingTime < 0) {
                    clearInterval(timerInterval);
                    timerDisplay.textContent = "00:00";
                    alert("⏰ Thời gian của bạn đã hết. Bài thi sẽ được nộp tự động!");
                    document.getElementById('submitForm').submit();
                }
            }, 1000);

            // Add animation to question containers
            const questionContainers = document.querySelectorAll('.question-container');
            questionContainers.forEach((container, index) => {
                setTimeout(() => {
                    container.classList.add('animate__animated', 'animate__fadeInUp');
                }, index * 100);
            });

            // Smooth scroll to first question
            setTimeout(() => {
                const firstQuestion = document.querySelector('.question-container');
                if (firstQuestion) {
                    firstQuestion.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }, 500);
        });

        // Progress tracking
        document.addEventListener('change', function(e) {
            if (e.target.type === 'radio') {
                updateProgress();
            }
        });

        function updateProgress() {
            const totalQuestions = document.querySelectorAll('input[type="radio"][name]').length / 4; // 4 options per question
            const answeredQuestions = new Set();
            
            document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
                answeredQuestions.add(input.name);
            });

            const progressPercentage = (answeredQuestions.size / totalQuestions) * 100;
            document.getElementById('progress-fill').style.width = progressPercentage + '%';
            document.getElementById('progress-text').textContent = Math.round(progressPercentage) + '%';
        }

        // Smooth scrolling for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Auto-save functionality (optional)
        let autoSaveInterval;
        function startAutoSave() {
            autoSaveInterval = setInterval(() => {
                const formData = new FormData(document.getElementById('submitForm'));
                // You can implement auto-save to localStorage or server here
                console.log('Auto-saving progress...');
            }, 30000); // Auto-save every 30 seconds
        }

        // Confirmation before leaving page
        window.addEventListener('beforeunload', function (e) {
            const hasStarted = document.getElementById('startExamBtn').classList.contains('d-none');
            if (hasStarted && !document.getElementById('submitForm').submitted) {
                e.preventDefault();
                e.returnValue = 'Bạn có chắc chắn muốn rời khỏi trang? Tiến độ làm bài có thể bị mất.';
            }
        });

        // Mark form as submitted when submitting
        document.getElementById('submitForm').addEventListener('submit', function() {
            this.submitted = true;
        });

        // Add hover effects to options
        document.addEventListener('DOMContentLoaded', function() {
            const optionLabels = document.querySelectorAll('.option-label');
            optionLabels.forEach(label => {
                label.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(5px)';
                });
                label.addEventListener('mouseleave', function() {
                    if (!this.previousElementSibling.checked) {
                        this.style.transform = 'translateX(0)';
                    }
                });
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'Enter') {
                const submitBtn = document.getElementById('submitExamBtn');
                if (!submitBtn.classList.contains('d-none')) {
                    submitBtn.click();
                }
            }
        });

        // Add visual feedback for selected answers
        document.addEventListener('change', function(e) {
            if (e.target.type === 'radio') {
                // Remove previous selection styling
                const questionContainer = e.target.closest('.question-container');
                questionContainer.querySelectorAll('.option-label').forEach(label => {
                    label.classList.remove('selected');
                });
                
                // Add styling to selected option
                e.target.nextElementSibling.classList.add('selected');
                
                // Add completion checkmark to question number
                const questionNumber = questionContainer.querySelector('.question-number');
                if (!questionNumber.querySelector('.fa-check')) {
                    questionNumber.innerHTML += ' <i class="fas fa-check" style="font-size: 0.8rem;"></i>';
                }
            }
        });

// Ẩn nút bắt đầu nếu đã có kết quả
<?php if ($show_results): ?>
document.addEventListener('DOMContentLoaded', function() {
    const startBtn = document.getElementById('startExamBtn');
    const submitBtn = document.getElementById('submitExamBtn');
    if (startBtn) startBtn.style.display = 'none';
    if (submitBtn) submitBtn.style.display = 'none';
    
    // Scroll to results
    const resultContainer = document.querySelector('.result-container');
    if (resultContainer) {
        setTimeout(() => {
            resultContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 500);
    }
});
<?php endif; ?>

// Back to Top functionality
document.addEventListener('DOMContentLoaded', function() {
    const backToTopBtn = document.getElementById('backToTop');
    
    // Show/hide button based on scroll position
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopBtn.style.display = 'flex';
            backToTopBtn.style.opacity = '1';
        } else {
            backToTopBtn.style.opacity = '0';
            setTimeout(() => {
                if (window.pageYOffset <= 300) {
                    backToTopBtn.style.display = 'none';
                }
            }, 300);
        }
    });
    
    // Smooth scroll to top
    backToTopBtn.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Initially hide the button
    backToTopBtn.style.display = 'none';
});
    </script>

    <style>
        .option-label.selected {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe) !important;
            border-color: var(--primary-color) !important;
            transform: translateX(5px) !important;
        }

        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: none;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
            z-index: 1000;
            opacity: 0;
        }

        .back-to-top:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
            color: white;
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        }

        .back-to-top:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.3);
        }

        /* Loading animation for audio */
        .audio-player::-webkit-media-controls-panel {
            background-color: white;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--light-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        }

        .result-option.correct-not-selected {
            background: linear-gradient(135deg, #fef3c7, #fde68a) !important;
            border-color: #f59e0b !important;
            color: #92400e !important;
        }

        .legend-color.correct-not-selected {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
        }
    </style>
</body>
</html>
