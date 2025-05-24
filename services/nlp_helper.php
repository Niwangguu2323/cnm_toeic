<?php
/**
 * NLP Helper - Các hàm hỗ trợ xử lý ngôn ngữ tự nhiên
 */
require_once ("keyword_service.php");
class NLPHelper {
    
    /**
     * Kiểm tra chế độ thi (practice hay exam)
     * @param array $exam_data - Dữ liệu bài thi
     * @return string - 'practice' hoặc 'exam'
     */
    public static function determineExamMode($exam_data) {
        // Kiểm tra xem có phải chế độ luyện thi không
        // Có thể dựa vào URL parameter, session, hoặc database
        
        if (isset($_GET['mode']) && $_GET['mode'] === 'practice') {
            return 'practice';
        }
        
        if (isset($_SESSION['exam_mode']) && $_SESSION['exam_mode'] === 'practice') {
            return 'practice';
        }
        
        // Mặc định là chế độ thi thật
        return 'exam';
    }

    /**
     * Xử lý text với NLP highlighting
     */
    public static function processText($text, $mode = 'practice') {
        if ($mode === 'exam') {
            return nl2br(htmlspecialchars($text));
        }
        
        $keywordService = new KeywordService();
        $result = $keywordService->analyzeAndHighlight($text, $mode);
        
        return $result['highlighted_text'];
    }

    /**
     * Lấy CSS styles cho NLP
     */
    public static function getStyles() {
        $keywordService = new KeywordService();
        return $keywordService->getHighlightStyles();
    }
}
?>
