<?php
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
    <h2 class="mb-3">Chi tiết bài thi: <?= htmlspecialchars($exam['title']) ?></h2>
    <p><strong>Loại:</strong> <?= $exam['type'] ?> | <strong>Thời gian:</strong> <?= $exam['duration_minutes'] ?> phút</p>
    <hr>

    <!-- Nút bắt đầu làm bài -->
    <button id="startExamBtn" class="btn btn-success mb-4">🎯 Làm bài thi</button>

    <!-- Nút nộp bài -->
    <form id="submitForm">
        <button type="submit" class="btn btn-primary mb-4 d-none" id="submitExamBtn">📝 Nộp bài</button>
    </form>

    <?php $cauSo = 1; ?>

    <?php if ($exam['type'] === 'Reading'): ?>

        <?php if (!empty($no_passage_questions)): ?>
            <h4 class="mt-4">Câu hỏi không gắn đoạn văn</h4>
            <?php foreach ($no_passage_questions as $q): ?>
                <div class="question-block">
                    <strong>Câu <?= $cauSo++ ?>:</strong> <?= htmlspecialchars($q['content']) ?>
                    <form class="question-form">
                        <?php
                        $options = [
                            'A' => $q['option_1'],
                            'B' => $q['option_2'],
                            'C' => $q['option_3'],
                            'D' => $q['option_4'],
                        ];
                        foreach ($options as $opt => $val): ?>
                            <div class="form-check">
                                <input class="form-check-input" disabled type="radio" name="q<?= $q['question_id'] ?>" value="<?= $opt ?>" id="q<?= $q['question_id'] . $opt ?>">
                                <label class="form-check-label" for="q<?= $q['question_id'] . $opt ?>">
                                    <?= $opt ?>. <?= htmlspecialchars($val) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php foreach ($passages as $pid => $content): ?>
            <div class="passage-block">
                <p><?= nl2br(htmlspecialchars($content)) ?></p>
                <?php foreach ($grouped_questions[$pid] ?? [] as $q): ?>
                    <div class="question-block">
                        <strong>Câu <?= $cauSo++ ?>:</strong> <?= htmlspecialchars($q['content']) ?>
                        <form class="question-form">
                            <?php
                            $options = [
                                'A' => $q['option_1'],
                                'B' => $q['option_2'],
                                'C' => $q['option_3'],
                                'D' => $q['option_4'],
                            ];
                            foreach ($options as $opt => $val): ?>
                                <div class="form-check">
                                    <input class="form-check-input" disabled type="radio" name="q<?= $q['question_id'] ?>" value="<?= $opt ?>" id="q<?= $q['question_id'] . $opt ?>">
                                    <label class="form-check-label" for="q<?= $q['question_id'] . $opt ?>">
                                        <?= $opt ?>. <?= htmlspecialchars($val) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

    <?php else: ?>
        <h4>🎧 Danh sách câu hỏi Listening</h4>
        <?php foreach ($questions as $q): ?>
            <div class="question-block">
                <strong>Câu <?= $cauSo++ ?>:</strong> <?= htmlspecialchars($q['content']) ?>
                <?php if (!empty($q['audio_url'])): ?>
                    <audio controls>
                        <source src="<?= htmlspecialchars($q['audio_url']) ?>" type="audio/mpeg">
                        Trình duyệt không hỗ trợ audio.
                    </audio>
                <?php endif; ?>
                <form class="question-form">
                    <?php
                    $options = [
                        'A' => $q['option_1'],
                        'B' => $q['option_2'],
                        'C' => $q['option_3'],
                        'D' => $q['option_4'],
                    ];
                    foreach ($options as $opt => $val): ?>
                        <div class="form-check">
                            <input class="form-check-input" disabled type="radio" name="q<?= $q['question_id'] ?>" value="<?= $opt ?>" id="q<?= $q['question_id'] . $opt ?>">
                            <label class="form-check-label" for="q<?= $q['question_id'] . $opt ?>">
                                <?= $opt ?>. <?= htmlspecialchars($val) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

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

        // Nộp bài
        document.getElementById('submitForm').addEventListener('submit', function (e) {
            e.preventDefault();
            alert("🎉 Bài thi đã được nộp!\n(Bạn có thể xử lý chấm điểm ở bước tiếp theo.)");
        });
    </script>
</body>
</html>
