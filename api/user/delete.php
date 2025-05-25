<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../models/UserModel.php';

header("Content-Type: application/json; charset=UTF-8");

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Phương thức không được hỗ trợ"
    ]);
    exit;
}

// Lấy ID người dùng từ tham số URL
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Kiểm tra ID
if ($user_id <= 0) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "ID người dùng không hợp lệ"
    ]);
    exit;
}

// Khởi tạo model
$model = new UserModel();

// Xóa người dùng
$result = $model->deleteUser($user_id);

// Trả về kết quả
if ($result['success']) {
    echo json_encode($result);
} else {
    http_response_code(500);
    echo json_encode($result);
}
?>
