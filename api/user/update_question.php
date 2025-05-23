<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../models/ExamModel.php';

header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['question_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Thiếu ID câu hỏi"]);
    exit;
}

$model = new ExamModel();
$result = $model->updateQuestion($data);

if ($result) {
    echo json_encode(["success" => true, "message" => "Cập nhật thành công"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => true, "message" => "Cập nhật thất bại"]);
}
?>
