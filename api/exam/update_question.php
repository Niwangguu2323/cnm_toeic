<?php
require_once '../models/ExamModel.php';

header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['question_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Thiếu ID câu hỏi"]);
    exit;
}

$model = new ExamModel();
$result = $model->updateQuestion($data);

?>