<?php
/**
 * Practice Mode Components - Các component cho chế độ luyện thi
 */

class PracticeModeModel {
    
    /**
     * Render Practice Mode Indicator với hướng dẫn NLP
     */
    public static function renderPracticeModeIndicator() {
        ob_start();
        ?>
        <div class="practice-mode-indicator animate__animated animate__bounceIn">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5><i class="fas fa-lightbulb me-2"></i>Chế độ luyện tập</h5>
                    <p class="mb-2">NLP sẽ phân tích và đánh dấu các từ khóa quan trọng, phân tích ngữ pháp và đánh giá độ khó để giúp bạn học hiệu quả hơn.</p>
                    
                    <!-- Inline Keyword Legend -->
                    <div class="inline-keyword-guide">
                        <h6 class="mb-2"><i class="fas fa-palette me-2"></i>Hướng dẫn màu sắc:</h6>
                        <div class="row g-2">
                            <div class="col-md-6 col-lg-3">
                                <div class="keyword-guide-item">
                                    <span class="highlight-toeic sample-highlight">Business</span>
                                    <small class="text-muted d-block">Từ vựng TOEIC quan trọng (Kinh doanh, Du lịch, Tài chính...)</small>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="keyword-guide-item">
                                    <span class="highlight-signal sample-highlight">However</span>
                                    <small class="text-muted d-block">Từ nối & từ chỉ thị (Tương phản, Nguyên nhân-kết quả...)</small>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="keyword-guide-item">
                                    <span class="highlight-question sample-highlight">According to</span>
                                    <small class="text-muted d-block">Từ khóa câu hỏi (What, When, According to...)</small>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="keyword-guide-item">
                                    <span class="highlight-grammar sample-highlight">Will have</span>
                                    <small class="text-muted d-block">Cấu trúc ngữ pháp (Thì, Modal verbs...)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-outline-primary btn-sm mb-2" id="toggleAdvancedFeatures">
                        <i class="fas fa-cog me-2"></i>Tính năng NLP
                    </button>
                    <button class="btn btn-outline-info btn-sm" id="toggleKeywordLegend">
                        <i class="fas fa-info-circle me-2"></i>Chi tiết phân tích
                    </button>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Render Advanced NLP Features Panel
     */
    public static function renderAdvancedFeaturesPanel() {
        ob_start();
        ?>
        <div class="advanced-features-panel" id="advancedFeaturesPanel" style="display: none;">
            <div class="row">
                <div class="col-md-6">
                    <div class="feature-card">
                        <h6><i class="fas fa-chart-line me-2"></i>Phân tích độ khó tự động</h6>
                        <p class="small mb-0">Hệ thống đánh giá độ khó dựa trên mật độ từ khóa và cấu trúc ngữ pháp</p>
                        <div class="difficulty-examples mt-2">
                            <span class="badge bg-success me-1">Dễ</span>
                            <span class="badge bg-warning me-1">Trung bình</span>
                            <span class="badge bg-danger">Khó</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-card">
                        <h6><i class="fas fa-tags me-2"></i>Phân loại chủ đề</h6>
                        <p class="small mb-0">Tự động nhận diện chủ đề: Business, Travel, Finance...</p>
                        <div class="topic-examples mt-2">
                            <span class="badge bg-primary me-1">Business</span>
                            <span class="badge bg-success">Travel</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="feature-card">
                        <h6><i class="fas fa-search me-2"></i>Phân tích ngữ pháp</h6>
                        <p class="small mb-0">Nhận diện thì động từ, modal verbs, và cấu trúc câu</p>
                        <div class="grammar-examples mt-2">
                            <span class="badge bg-info me-1">Present Perfect</span>
                            <span class="badge bg-secondary">Modal: Can</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-card">
                        <h6><i class="fas fa-highlighter me-2"></i>Highlighting từ khóa</h6>
                        <p class="small mb-0">Đánh dấu từ vựng TOEIC, từ nối và từ khóa quan trọng</p>
                        <div class="highlight-examples mt-2">
                            <span class="badge bg-warning me-1">TOEIC Keywords</span>
                            <span class="badge bg-info">Signal Words</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Render Detailed Keyword Legend
     */
    public static function renderDetailedKeywordLegend() {
        ob_start();
        ?>
        <div class="keyword-legend" id="keywordLegend" style="display: none;">
            <h6><i class="fas fa-book-open me-2"></i>Chi tiết phân tích từ khóa</h6>
            <div class="row">
                <div class="col-md-3">
                    <div class="legend-category">
                        <h6 class="legend-category-title">Từ vựng TOEIC</h6>
                        <div class="legend-item">
                            <div class="legend-color legend-toeic"></div>
                            <div>
                                <strong>Business & Work</strong>
                                <small class="d-block text-muted">meeting, contract, deadline, manager...</small>
                            </div>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color legend-toeic"></div>
                            <div>
                                <strong>Travel & Hotel</strong>
                                <small class="d-block text-muted">flight, reservation, check-in, luggage...</small>
                            </div>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color legend-toeic"></div>
                            <div>
                                <strong>Finance</strong>
                                <small class="d-block text-muted">budget, profit, investment, payment...</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="legend-category">
                        <h6 class="legend-category-title">Từ nối & Chỉ thị</h6>
                        <div class="legend-item">
                            <div class="legend-color legend-signal"></div>
                            <div>
                                <strong>Tương phản</strong>
                                <small class="d-block text-muted">however, although, despite, whereas...</small>
                            </div>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color legend-signal"></div>
                            <div>
                                <strong>Nguyên nhân-Kết quả</strong>
                                <small class="d-block text-muted">because, therefore, as a result...</small>
                            </div>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color legend-signal"></div>
                            <div>
                                <strong>Trình tự</strong>
                                <small class="d-block text-muted">first, then, finally, meanwhile...</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="legend-category">
                        <h6 class="legend-category-title">Từ khóa câu hỏi</h6>
                        <div class="legend-item">
                            <div class="legend-color legend-question"></div>
                            <div>
                                <strong>Wh-questions</strong>
                                <small class="d-block text-muted">what, when, where, who, why, how...</small>
                            </div>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color legend-question"></div>
                            <div>
                                <strong>Reference words</strong>
                                <small class="d-block text-muted">according to, mentioned, stated...</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="legend-category">
                        <h6 class="legend-category-title">Cấu trúc ngữ pháp</h6>
                        <div class="legend-item">
                            <div class="legend-color legend-grammar"></div>
                            <div>
                                <strong>Thì động từ</strong>
                                <small class="d-block text-muted">Present Perfect, Past Simple...</small>
                            </div>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color legend-grammar"></div>
                            <div>
                                <strong>Modal verbs</strong>
                                <small class="d-block text-muted">can, should, must, would...</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="legend-footer mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-mouse-pointer me-1"></i>
                            <strong>Hover</strong> vào từ được highlight để xem thông tin chi tiết
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small class="text-muted">
                            <i class="fas fa-lightbulb me-1"></i>
                            Độ sáng màu thể hiện mức độ quan trọng
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
?>