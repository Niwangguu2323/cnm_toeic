<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../models/UserModel.php';

header("Content-Type: application/json; charset=UTF-8");

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Phương thức không được hỗ trợ"
    ]);
    exit;
}

// Nhận dữ liệu từ request
$data = json_decode(file_get_contents("php://input"), true);

// Kiểm tra dữ liệu bắt buộc
if (!isset($data['user_id']) || !isset($data['user_name']) || !isset($data['email'])) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Thiếu thông tin bắt buộc (user_id, user_name, email)"
    ]);
    exit;
}

// Khởi tạo model
$model = new UserModel();

// Cập nhật người dùng
$result = $model->updateUser($data);

// Trả về kết quả
if ($result['success']) {
    echo json_encode($result);
} else {
    http_response_code(500);
    echo json_encode($result);
}
?>
