<?php
session_start();
require_once __DIR__ . '/../models/ExamModel.php';

$model = new ExamModel();
$exam_id = $_GET['id'] ?? 0;

$conn = $model->getConn(); // Đảm bảo ExamModel có hàm getConn()

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
        // Dựa vào bảng bạn cung cấp
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
        // Dựa vào bảng bạn cung cấp
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
// CHẤM ĐIỂM
$ketQua = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $soCauDung = 0;

    // Lấy tổng số câu trong đề thi
    $tong_sql = "SELECT COUNT(*) AS total FROM exam_question WHERE exam_id = $exam_id";
    $tong_result = mysqli_query($conn, $tong_sql);
    $tong_row = mysqli_fetch_assoc($tong_result);
    $tongCau = (int)($tong_row['total'] ?? 0);

    foreach ($_POST as $qid => $traloi) {
    if (!is_numeric($qid)) continue;
    $qid = (int)$qid;
    $traloi = mysqli_real_escape_string($conn, $traloi);

    $sql = "SELECT correct_answer FROM exam_question WHERE question_id = $qid";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    if ($row && strtoupper($row['correct_answer']) === strtoupper($traloi)) {
        $soCauDung++;
    }
}
     $reading_score = null;
    $listening_score = null;

    if ($exam['type'] === 'Reading') {
        $reading_score = quyDoiDiemReading($soCauDung);
        $total_score = $reading_score;
    } else {
        $listening_score = quyDoiDiemListening($soCauDung);
        $total_score = $listening_score;
    }

    $ketQua = "🎯 Bạn đã làm đúng <strong>$soCauDung / $tongCau</strong> câu hỏi!<br>";
    if ($reading_score !== null) {
        $ketQua .= "📘 Điểm Reading (quy đổi): <strong>$reading_score</strong>";
    } else {
        $ketQua .= "🎧 Điểm Listening (quy đổi): <strong>$listening_score</strong>";
    }

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $date = date('Y-m-d');

        $insert_sql = "INSERT INTO exam_result (user_id, exam_id, listening_score, reading_score, total_score, time)
                       VALUES ($user_id, $exam_id, ". ($listening_score ?? 'NULL') . ", ". ($reading_score ?? 'NULL') . ", $total_score, '$date')";

        mysqli_query($conn, $insert_sql);
    }
}

// Lấy passage nếu là Reading
$passages = [];
if ($exam['type'] === 'Reading') {
    $passage_sql = "SELECT * FROM reading_passage WHERE exam_id = $exam_id";
    $passage_result = mysqli_query($conn, $passage_sql);
    while ($row = mysqli_fetch_assoc($passage_result)) {
        $passages[$row['passage_id']] = $row['content'];
    }
}

// Lấy câu hỏi
$question_sql = "SELECT * FROM exam_question WHERE exam_id = $exam_id ORDER BY passage_id ASC, question_id ASC";
$question_result = mysqli_query($conn, $question_sql);
$questions = [];
while ($row = mysqli_fetch_assoc($question_result)) {
    $questions[] = $row;
}

// Gom nhóm câu hỏi
$grouped_questions = [];
$no_passage_questions = [];
foreach ($questions as $q) {
    if ($q['passage_id']) {
        $grouped_questions[$q['passage_id']][] = $q;
    } else {
        $no_passage_questions[] = $q;
    }
}
// Lấy listening
$listenings = [];
$grouped_listening_questions = [];
$no_listening_questions = [];

if ($exam['type'] === 'Listening') {
    $lsql = "SELECT * FROM listening WHERE exam_id = $exam_id";
    $lresult = mysqli_query($conn, $lsql);
    while ($row = mysqli_fetch_assoc($lresult)) {
        $listenings[$row['listening_id']] = [
            'content' => $row['content'],
            'audio_url' => $row['audio_url']
        ];
    }

    foreach ($questions as $q) {
        if (!empty($q['listening_id'])) {
            $grouped_listening_questions[$q['listening_id']][] = $q;
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
    <title>Chi tiết bài thi: <?= htmlspecialchars($exam['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .question-block { margin-bottom: 25px; }
        .passage-block { margin-top: 40px; padding: 20px; background-color: #f3f3f3; border-radius: 10px; }
    </style>
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
                <a href="../index.php" class="nav-item nav-link active">Trang chủ</a>
                <a href="./about.php" class="nav-item nav-link">Về chúng tôi</a>
                <div class="nav-item dropdown">
                    <a href="./practice.php" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Luyện tập</a>
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
                        <a href="profile.php" class="dropdown-item">Sửa thông tin</a>
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
  <div class="container py-4">
    <h2 class="mb-3">Chi tiết bài thi: <?= htmlspecialchars($exam['title']) ?></h2>
    <p><strong>Loại:</strong> <?= $exam['type'] ?> | <strong>Thời gian:</strong> <?= $exam['duration_minutes'] ?> phút</p>
    <hr>

    <?php if ($ketQua): ?>
        <div class="alert alert-success text-center"><?= $ketQua ?></div>
    <?php endif; ?>

    <?php if (!isset($_SESSION['user_id'])): ?>
    <div class="alert alert-warning">⚠️ Vui lòng <a href="login.php">đăng nhập</a> để làm bài thi.</div>
<?php else: ?>
    <button id="startExamBtn" class="btn btn-success mb-4">🎯 Làm bài thi</button>
<?php endif; ?>
   <!-- Thời gian làm bài -->
<div id="countdown-timer" class="mb-4 fs-5 fw-bold text-danger" style="display: none;">
    ⏳ Thời gian còn lại: <span id="timer">--:--</span>
</div>
    <form method="POST" id="submitForm">
        <button type="submit" class="btn btn-primary mb-4 d-none" id="submitExamBtn">📝 Nộp bài</button>

        <?php $cauSo = 1; ?>

        <?php if ($exam['type'] === 'Reading'): ?>
            <?php if (!empty($no_passage_questions)): ?>
                <h4 class="mt-4">Câu hỏi không gắn đoạn văn</h4>
                <?php foreach ($no_passage_questions as $q): ?>
                    <div class="question-block">
                        <strong>Câu <?= $cauSo++ ?>:</strong> <?= htmlspecialchars($q['content']) ?>
                        <?php foreach (['A','B','C','D'] as $i => $opt): ?>
                            <div class="form-check">
                                <input class="form-check-input" disabled type="radio" name="<?= $q['question_id'] ?>" value="<?= $opt ?>" id="q<?= $q['question_id'] . $opt ?>">
                                <label class="form-check-label" for="q<?= $q['question_id'] . $opt ?>">
                                    <?= $opt ?>. <?= htmlspecialchars($q["option_" . ($i + 1)]) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php foreach ($passages as $pid => $content): ?>
                <div class="passage-block bg-light p-3 my-4 rounded">
                    <p><?= nl2br(htmlspecialchars($content)) ?></p>
                    <?php foreach ($grouped_questions[$pid] ?? [] as $q): ?>
                        <div class="question-block">
                            <strong>Câu <?= $cauSo++ ?>:</strong> <?= htmlspecialchars($q['content']) ?>
                            <?php foreach (['A','B','C','D'] as $i => $opt): ?>
                                <div class="form-check">
                                    <input class="form-check-input" disabled type="radio" name="<?= $q['question_id'] ?>" value="<?= $opt ?>" id="q<?= $q['question_id'] . $opt ?>">
                                    <label class="form-check-label" for="q<?= $q['question_id'] . $opt ?>">
                                        <?= $opt ?>. <?= htmlspecialchars($q["option_" . ($i + 1)]) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <?php foreach ($listenings as $lid => $info): ?>
                <div class="p-3 my-4 bg-light rounded">
                    <p><strong>Đoạn nghe:</strong> <?= nl2br(htmlspecialchars($info['content'])) ?></p>
                    <audio controls>
                        <source src="../public/<?= htmlspecialchars($info['audio_url']) ?>" type="audio/mpeg">
                        Trình duyệt của bạn không hỗ trợ phát audio.
                    </audio>
                    <?php foreach ($grouped_listening_questions[$lid] ?? [] as $q): ?>
                        <div class="question-block mt-3">
                            <strong>Câu <?= $cauSo++ ?>:</strong> <?= htmlspecialchars($q['content']) ?>
                            <?php foreach (['A','B','C','D'] as $i => $opt): ?>
                                <div class="form-check">
                                    <input class="form-check-input" disabled type="radio" name="<?= $q['question_id'] ?>" value="<?= $opt ?>" id="q<?= $q['question_id'] . $opt ?>">
                                    <label class="form-check-label" for="q<?= $q['question_id'] . $opt ?>">
                                        <?= $opt ?>. <?= htmlspecialchars($q["option_" . ($i + 1)]) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary mt-4">📝 Nộp bài</button>
    </form>
</div>

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
    <!-- SCRIPT -->
    <script>
        // Khi nhấn "Làm bài thi"
        document.getElementById('startExamBtn').addEventListener('click', function () {
            this.classList.add('d-none');
            document.getElementById('submitExamBtn').classList.remove('d-none');

            // Gỡ disabled cho tất cả radio
            document.querySelectorAll('input[type=radio]').forEach(input => {
                input.disabled = false;
            });
        });

        
    </script>
    <script>
    document.getElementById('startExamBtn').addEventListener('click', function () {
        // Hiện nút nộp bài
        this.classList.add('d-none');
        document.getElementById('submitExamBtn').classList.remove('d-none');

        // Kích hoạt chọn đáp án
        document.querySelectorAll('input[type=radio]').forEach(input => {
            input.disabled = false;
        });

        // Hiển thị đồng hồ đếm ngược
        document.getElementById('countdown-timer').style.display = 'block';

        // Thời gian thi từ PHP (đơn vị phút)
        let durationMinutes = <?= (int) $exam['duration_minutes'] ?>;
        let remainingTime = durationMinutes * 60; // Đổi ra giây

        const timerDisplay = document.getElementById('timer');
        const timerInterval = setInterval(() => {
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            remainingTime--;

            if (remainingTime < 0) {
                clearInterval(timerInterval);
                timerDisplay.textContent = "00:00";
                alert("⏰ Thời gian của bạn đã hết. Bài thi sẽ được nộp tự động!");
                document.getElementById('submitForm').submit();
            }
        }, 1000);
    });
</script>

</body>
</html>
