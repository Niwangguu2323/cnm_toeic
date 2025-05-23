<?php
// Sử dụng đường dẫn tuyệt đối để đảm bảo tìm thấy file
require_once __DIR__ . '/../../models/UserModel.php';

// Thêm debug để kiểm tra lỗi
try {
    $model = new UserModel();
    $model->xuatDuLieu("SELECT * FROM user");
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Lỗi: " . $e->getMessage()]);
}
?>
