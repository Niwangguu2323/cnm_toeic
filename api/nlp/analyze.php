<?php
/**
 * API endpoint để phân tích NLP cho nội dung
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../services/keyword_service.php';

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

// Kiểm tra dữ liệu
if (!isset($data['text']) || empty($data['text'])) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Thiếu nội dung văn bản cần phân tích"
    ]);
    exit;
}

$text = $data['text'];
$mode = $data['mode'] ?? 'practice';

try {
    // Khởi tạo service
    $keywordService = new KeywordService();
    
    // Phân tích văn bản
    $result = $keywordService->analyzeAndHighlight($text, $mode);
    
    // Trả về kết quả
    echo json_encode([
        "success" => true,
        "data" => $result,
        "styles" => $keywordService->getHighlightStyles()
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Lỗi khi phân tích: " . $e->getMessage()
    ]);
}
?>
