<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../models/ExamModel.php';

header("Content-Type: application/json; charset=UTF-8");

// Nhận dữ liệu từ request
$data = json_decode(file_get_contents("php://input"), true);

// Kiểm tra dữ liệu
if (!isset($data['title']) || !isset($data['type']) || !isset($data['duration_minutes']) || !isset($data['difficulty_level'])) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Thiếu thông tin bài thi"
    ]);
    exit;
}

// Khởi tạo model
$model = new ExamModel();

// Thêm bài thi
$result = $model->insertExam($data);

// Trả về kết quả
if ($result['success']) {
    echo json_encode($result);
} else {
    http_response_code(500);
    echo json_encode($result);
}
?>
