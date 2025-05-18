<?php
require_once __DIR__ . '/../models/ExamModel.php';

$model = new ExamModel();
$exam_id = $_GET['id'] ?? 0;

// 1. Lấy thông tin đề thi
$exam_sql = "SELECT * FROM exam WHERE exam_id = $exam_id";
$exam_result = mysqli_query($model->conn, $exam_sql);
$exam = mysqli_fetch_assoc($exam_result);

if (!$exam) {
    echo "<p>Không tìm thấy đề thi.</p>";
    exit;
}

// 2. Lấy các đoạn văn nếu là đề đọc
$passages = [];
if ($exam['type'] === 'Reading') {
    $passage_sql = "SELECT * FROM reading_passage WHERE exam_id = $exam_id";
    $passage_result = mysqli_query($model->conn, $passage_sql);
    while ($row = mysqli_fetch_assoc($passage_result)) {
        $passages[$row['passage_id']] = $row['content'];
    }
}

// 3. Lấy tất cả câu hỏi thuộc đề này
$question_sql = "SELECT * FROM exam_question WHERE exam_id = $exam_id ORDER BY passage_id ASC, question_id ASC";
$question_result = mysqli_query($model->conn, $question_sql);
$questions = [];
while ($row = mysqli_fetch_assoc($question_result)) {
    $questions[] = $row;
}

// 4. Gom câu hỏi theo passage_id
$grouped_questions = [];
$no_passage_questions = [];

foreach ($questions as $q) {
    if ($q['passage_id']) {
        $grouped_questions[$q['passage_id']][] = $q;
    } else {
        $no_passage_questions[] = $q;
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
</head>
<body class="container py-4">
    <h2 class="mb-3">📘 Chi tiết bài thi: <?= htmlspecialchars($exam['title']) ?></h2>
    <p><strong>Loại:</strong> <?= $exam['type'] ?> | <strong>Thời gian:</strong> <?= $exam['duration_minutes'] ?> phút</p>
    <hr>

    <?php if ($exam['type'] === 'Reading'): ?>
        <!-- Hiển thị các đoạn văn và câu hỏi theo đoạn -->
        <?php foreach ($passages as $pid => $content): ?>
            <div class="passage-block">
                <h5>📄 Đoạn văn #<?= $pid ?></h5>
                <p><?= nl2br(htmlspecialchars($content)) ?></p>

                <?php if (!empty($grouped_questions[$pid])): ?>
                    <?php foreach ($grouped_questions[$pid] as $q): ?>
                        <div class="question-block">
                            <strong>Câu <?= $q['question_id'] ?>:</strong> <?= htmlspecialchars($q['content']) ?><br>
                            <ul>
                                <li>A. <?= htmlspecialchars($q['option_1']) ?></li>
                                <li>B. <?= htmlspecialchars($q['option_2']) ?></li>
                                <li>C. <?= htmlspecialchars($q['option_3']) ?></li>
                                <li>D. <?= htmlspecialchars($q['option_4']) ?></li>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <!-- Các câu hỏi không gắn passage -->
        <?php if (!empty($no_passage_questions)): ?>
            <h4 class="mt-4">🔍 Câu hỏi không gắn đoạn văn</h4>
            <?php foreach ($no_passage_questions as $q): ?>
                <div class="question-block">
                    <strong>Câu <?= $q['question_id'] ?>:</strong> <?= htmlspecialchars($q['content']) ?><br>
                    <ul>
                        <li>A. <?= htmlspecialchars($q['option_1']) ?></li>
                        <li>B. <?= htmlspecialchars($q['option_2']) ?></li>
                        <li>C. <?= htmlspecialchars($q['option_3']) ?></li>
                        <li>D. <?= htmlspecialchars($q['option_4']) ?></li>
                    </ul>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    <?php else: ?>
        <!-- Nếu là đề nghe -->
        <h4>🎧 Danh sách câu hỏi Listening</h4>
        <?php foreach ($questions as $q): ?>
            <div class="question-block">
                <strong>Câu <?= $q['question_id'] ?>:</strong> <?= htmlspecialchars($q['content']) ?><br>
                <?php if (!empty($q['audio_url'])): ?>
                    <audio controls>
                        <source src="<?= htmlspecialchars($q['audio_url']) ?>" type="audio/mpeg">
                        Trình duyệt của bạn không hỗ trợ audio.
                    </audio><br>
                <?php endif; ?>
                <ul>
                    <li>A. <?= htmlspecialchars($q['option_1']) ?></li>
                    <li>B. <?= htmlspecialchars($q['option_2']) ?></li>
                    <li>C. <?= htmlspecialchars($q['option_3']) ?></li>
                    <li>D. <?= htmlspecialchars($q['option_4']) ?></li>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
