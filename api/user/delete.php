<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../models/ExamModel.php';

header("Content-Type: application/json; charset=UTF-8");

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405); // Method Not Allowed
    echo json_encode([
        "success" => false,
        "message" => "Phương thức không được hỗ trợ"
    ]);
    exit;
}

// Lấy ID bài thi từ tham số URL
$exam_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Kiểm tra ID
if ($exam_id <= 0) {
    http_response_code(400); // Bad Request
    echo json_encode([
        "success" => false,
        "message" => "ID bài thi không hợp lệ"
    ]);
    exit;
}

// Khởi tạo model
$model = new ExamModel();

// Xóa bài thi
$result = $model->deleteExam($exam_id);

// Trả về kết quả
if ($result['success']) {
    echo json_encode($result);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode($result);
}
?>
