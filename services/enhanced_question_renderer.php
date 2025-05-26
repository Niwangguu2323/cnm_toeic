<?php
/**
 * Enhanced Question Renderer - Xử lý render câu hỏi với NLP highlighting
 */

require_once __DIR__ . '/keyword_service.php';

class EnhancedQuestionRenderer {
    
    private $keywordService;
    
    public function __construct() {
        $this->keywordService = new KeywordService();
    }
    
    /**
     * Render câu hỏi với phân tích NLP
     */
    public function renderEnhancedQuestionWithNLP($q, $cauSo, $detailed_results, $show_results, $is_practice_mode) {
        $qid = $q['question_id'];
        $user_answer = $detailed_results[$qid]['user_answer'] ?? null;
        $correct_answer = $detailed_results[$qid]['correct_answer'] ?? $q['correct_answer'];
        $is_correct = $detailed_results[$qid]['is_correct'] ?? null;
        
        // Xử lý NLP cho nội dung câu hỏi
        $question_content = $q['content'];
        $question_analysis = null;
        $options_analysis = [];
        
        if ($is_practice_mode && !$show_results) {
            // Phân tích câu hỏi
            $analysis_result = $this->keywordService->analyzeAndHighlight($question_content, 'practice');
            $question_content = $analysis_result['highlighted_text'];
            $question_analysis = $analysis_result['analysis'];
            
            // Phân tích từng option
            foreach (['A','B','C','D'] as $i => $opt) {
                $option_text = $q["option_" . ($i + 1)];
                $option_result = $this->keywordService->analyzeAndHighlight($option_text, 'practice');
                $options_analysis[$opt] = [
                    'highlighted_text' => $option_result['highlighted_text'],
                    'analysis' => $option_result['analysis']
                ];
            }
        } else {
            $question_content = htmlspecialchars($q['content']);
            foreach (['A','B','C','D'] as $i => $opt) {
                $options_analysis[$opt] = [
                    'highlighted_text' => htmlspecialchars($q["option_" . ($i + 1)]),
                    'analysis' => null
                ];
            }
        }
        
        ob_start();
        ?>
        <div class="question-container enhanced-question animate-fade-in" data-question-id="<?= $qid ?>">
            <div class="d-flex align-items-start">
                <div class="question-number">
                    <?= $cauSo ?>
                    <?php if ($question_analysis && $question_analysis['difficulty_level']): ?>
                        <span class="difficulty-indicator difficulty-<?= $question_analysis['difficulty_level'] ?>" 
                              title="Độ khó: <?= ucfirst($question_analysis['difficulty_level']) ?>">
                            <i class="fas fa-circle"></i>
                        </span>
                    <?php endif; ?>
                </div>
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
                    
                    <!-- Question Analysis Panel -->
                    <?php if ($is_practice_mode && !$show_results && $question_analysis): ?>
                    <div class="question-analysis-panel">
                        <div class="analysis-summary">
                            <?php if (!empty($question_analysis['grammar']['verb_tenses'])): ?>
                                <span class="analysis-tag grammar-tag">
                                    <i class="fas fa-language me-1"></i>
                                    <?= implode(', ', array_unique($question_analysis['grammar']['verb_tenses'])) ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (!empty($question_analysis['grammar']['modal_verbs'])): ?>
                                <span class="analysis-tag modal-tag">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    Modal: <?= implode(', ', $question_analysis['grammar']['modal_verbs']) ?>
                                </span>
                            <?php endif; ?>
                            
                            <span class="analysis-tag keyword-tag">
                                <i class="fas fa-key me-1"></i>
                                <?= $question_analysis['keyword_count'] ?> từ khóa
                            </span>
                            
                            <span class="analysis-tag difficulty-tag difficulty-<?= $question_analysis['difficulty_level'] ?>">
                                <i class="fas fa-signal me-1"></i>
                                <?= ucfirst($question_analysis['difficulty_level']) ?>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
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
                        ?>
                            <div class="option-item enhanced-option">
                                <input type="radio" 
                                       name="<?= $q['question_id'] ?>" 
                                       value="<?= $opt ?>" 
                                       id="q<?= $q['question_id'] . $opt ?>" 
                                       <?= $show_results ? 'disabled' : 'disabled' ?>
                                       <?= $is_user_choice ? 'checked' : '' ?>>
                                <label class="option-label <?= $option_class ?>" for="q<?= $q['question_id'] . $opt ?>">
                                    <div class="option-letter"><?= $opt ?></div>
                                    <div class="option-content">
                                        <?= $options_analysis[$opt]['highlighted_text'] ?>
                                        
                                        <?php if ($is_practice_mode && !$show_results && $options_analysis[$opt]['analysis'] && $options_analysis[$opt]['analysis']['keyword_count'] > 0): ?>
                                            <div class="option-analysis">
                                                <small class="text-muted">
                                                    <i class="fas fa-tags me-1"></i>
                                                    <?= $options_analysis[$opt]['analysis']['keyword_count'] ?> từ khóa
                                                    <?php if (!empty($options_analysis[$opt]['analysis']['grammar']['verb_tenses'])): ?>
                                                        | <i class="fas fa-language me-1"></i>
                                                        <?= implode(', ', array_unique($options_analysis[$opt]['analysis']['grammar']['verb_tenses'])) ?>
                                                    <?php endif; ?>
                                                </small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
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
}
?>