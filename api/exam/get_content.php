<?php
/**
 * API để lấy nội dung bài thi với NLP processing
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../models/ExamModel.php';
require_once __DIR__ . '/../../services/exam_content_service.php';
require_once __DIR__ . '/../../services/nlp_helper.php';

header("Content-Type: application/json; charset=UTF-8");

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Phương thức không được hỗ trợ"
    ]);
    exit;
}

$exam_id = $_GET['exam_id'] ?? 0;
$mode = $_GET['mode'] ?? 'exam';
$show_results = isset($_GET['show_results']) && $_GET['show_results'] === 'true';

if (!$exam_id) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Thiếu ID bài thi"
    ]);
    exit;
}

try {
    $model = new ExamModel();
    $contentService = new ExamContentService();
    $conn = $model->getConn();
    
    // Lấy thông tin bài thi
    $exam_sql = "SELECT * FROM exam WHERE exam_id = $exam_id";
    $exam_result = mysqli_query($conn, $exam_sql);
    $exam = mysqli_fetch_assoc($exam_result);
    
    if (!$exam) {
        throw new Exception("Không tìm thấy bài thi");
    }
    
    $is_practice_mode = ($mode === 'practice');
    
    // Lấy dữ liệu passages
    $passages = [];
    if ($exam['type'] === 'Reading' || $exam['type'] === 'Full') {
        $passage_sql = "SELECT * FROM reading_passage WHERE exam_id = $exam_id";
        $passage_result = mysqli_query($conn, $passage_sql);
        while ($row = mysqli_fetch_assoc($passage_result)) {
            $passages[$row['passage_id']] = [
                'content' => $row['content'],
                'processed_content' => $contentService->processPassageContent(
                    $row['content'], 
                    $is_practice_mode, 
                    $show_results
                )
            ];
        }
    }
    
    // Lấy dữ liệu listenings
    $listenings = [];
    if ($exam['type'] === 'Listening' || $exam['type'] === 'Full') {
        $listening_sql = "SELECT * FROM listening WHERE exam_id = $exam_id";
        $listening_result = mysqli_query($conn, $listening_sql);
        while ($row = mysqli_fetch_assoc($listening_result)) {
            $listenings[$row['listening_id']] = [
                'content' => $row['content'],
                'audio_url' => $row['audio_url'],
                'processed_content' => $contentService->processListeningContent(
                    $row['content'], 
                    $is_practice_mode, 
                    $show_results
                )
            ];
        }
    }
    
    // Lấy câu hỏi
    $questions = [];
    $question_sql = "SELECT * FROM exam_question WHERE exam_id = $exam_id ORDER BY listening_id ASC, passage_id ASC, question_id ASC";
    $question_result = mysqli_query($conn, $question_sql);
    while ($row = mysqli_fetch_assoc($question_result)) {
        $questions[] = $row;
    }
    
    // Gom nhóm câu hỏi
    $grouped_questions = [];
    $grouped_listening_questions = [];
    $no_passage_questions = [];
    
    foreach ($questions as $q) {
        if (!empty($q['listening_id'])) {
            $grouped_listening_questions[$q['listening_id']][] = $q;
        } elseif (!empty($q['passage_id'])) {
            $grouped_questions[$q['passage_id']][] = $q;
        } else {
            $no_passage_questions[] = $q;
        }
    }
    
    // Trả về dữ liệu
    echo json_encode([
        "success" => true,
        "data" => [
            "exam" => $exam,
            "passages" => $passages,
            "listenings" => $listenings,
            "grouped_questions" => $grouped_questions,
            "grouped_listening_questions" => $grouped_listening_questions,
            "no_passage_questions" => $no_passage_questions,
            "is_practice_mode" => $is_practice_mode
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Lỗi: " . $e->getMessage()
    ]);
}
?>
