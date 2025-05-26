<?php
/**
 * Exam Content Service - Xử lý nội dung bài thi
 */

require_once __DIR__ . '/keyword_service.php';
require_once __DIR__ . '/nlp_helper.php';

class ExamContentService {
    
    private $keywordService;
    
    public function __construct() {
        $this->keywordService = new KeywordService();
    }
    
    /**
     * Render câu hỏi với kết quả và NLP highlighting
     */
    public function renderQuestionWithResults($q, $cauSo, $detailed_results, $show_results, $is_practice_mode) {
        $qid = $q['question_id'];
        $user_answer = $detailed_results[$qid]['user_answer'] ?? null;
        $correct_answer = $detailed_results[$qid]['correct_answer'] ?? $q['correct_answer'];
        $is_correct = $detailed_results[$qid]['is_correct'] ?? null;
        
        // Xử lý NLP cho nội dung câu hỏi
        $question_content = $q['content'];
        if ($is_practice_mode && !$show_results) {
            $nlp_result = $this->keywordService->analyzeAndHighlight($question_content, 'practice');
            $question_content = $nlp_result['highlighted_text'];
        }
        
        ob_start();
        ?>
        <div class="question-container animate-fade-in">
            <div class="d-flex align-items-start">
                <div class="question-number"><?= $cauSo ?></div>
                <div class="flex-grow-1">
                    <div class="question-text">
                        <?= $question_content ?>
                        <?php if ($show_results && $is_correct !== null): ?>
                            <span class="correct-answer-indicator">
                                <i class="fas fa-<?= $is_correct ? 'check' : 'times' ?>"></i>
                                <?= $is_correct ? 'Đúng' : 'Sai' ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="option-group">
                        <?php foreach (['A','B','C','D'] as $i => $opt): 
                            $is_user_choice = ($user_answer === $opt);
                            $is_correct_choice = ($correct_answer === $opt);
                            
                            $option_class = '';
                            if ($show_results) {
                                if ($is_correct_choice && $is_user_choice) {
                                    $option_class = 'result-option correct';
                                } elseif ($is_correct_choice && !$is_user_choice) {
                                    $option_class = 'result-option correct-not-selected';
                                } elseif ($is_user_choice && !$is_correct_choice) {
                                    $option_class = 'result-option incorrect';
                                } else {
                                    $option_class = 'result-option not-selected';
                                }
                            }
                            
                            // Xử lý NLP cho options
                            $option_text = $q["option_" . ($i + 1)];
                            if ($is_practice_mode && !$show_results) {
                                $option_nlp = $this->keywordService->analyzeAndHighlight($option_text, 'practice');
                                $option_text = $option_nlp['highlighted_text'];
                            }
                        ?>
                            <div class="option-item">
                                <input type="radio" 
                                       name="<?= $q['question_id'] ?>" 
                                       value="<?= $opt ?>" 
                                       id="q<?= $q['question_id'] . $opt ?>" 
                                       <?= $show_results ? 'disabled' : 'disabled' ?>
                                       <?= $is_user_choice ? 'checked' : '' ?>>
                                <label class="option-label <?= $option_class ?>" for="q<?= $q['question_id'] . $opt ?>">
                                    <div class="option-letter"><?= $opt ?></div>
                                    <div><?= $option_text ?></div>
                                    <?php if ($show_results): ?>
                                        <?php if ($is_correct_choice && $is_user_choice): ?>
                                            <div class="result-icon correct">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                        <?php elseif ($is_correct_choice && !$is_user_choice): ?>
                                            <div class="result-icon" style="color: #f59e0b;">
                                                <i class="fas fa-exclamation-circle"></i>
                                            </div>
                                        <?php elseif ($is_user_choice && !$is_correct_choice): ?>
                                            <div class="result-icon incorrect">
                                                <i class="fas fa-times-circle"></i>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php if ($show_results && $is_correct !== null): ?>
                        <div class="question-result-summary <?= $is_correct ? 'correct' : 'incorrect' ?>">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-<?= $is_correct ? 'check-circle' : 'times-circle' ?> 
                                   text-<?= $is_correct ? 'success' : 'danger' ?>"></i>
                                <strong>
                                    <?php if ($is_correct): ?>
                                        Chính xác! Bạn đã chọn đáp án đúng.
                                    <?php else: ?>
                                        Bạn đã chọn: <?= $user_answer ?> | Đáp án đúng: <?= $correct_answer ?>
                                    <?php endif; ?>
                                </strong>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Xử lý nội dung passage với NLP
     */
    public function processPassageContent($content, $is_practice_mode, $show_results) {
        if ($is_practice_mode && !$show_results) {
            $passage_nlp = $this->keywordService->analyzeAndHighlight($content, 'practice');
            $processed_content = nl2br($passage_nlp['highlighted_text']);
            
            return $processed_content;
        } else {
            return nl2br(htmlspecialchars($content));
        }
    }
    
    /**
     * Xử lý nội dung listening với NLP
     */
    public function processListeningContent($content, $is_practice_mode, $show_results) {
        if ($is_practice_mode && !$show_results) {
            $listening_nlp = $this->keywordService->analyzeAndHighlight($content, 'practice');
            return nl2br($listening_nlp['highlighted_text']);
        } else {
            return nl2br(htmlspecialchars($content));
        }
    }
}
?>
