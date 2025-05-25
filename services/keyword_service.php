<?php
/**
 * Keyword Service - NLP-based keyword highlighting for TOEIC exam content
 * Giúp học viên dễ dàng nhận diện từ khóa quan trọng trong bài thi
 */

class KeywordService {
    
    // Danh sách từ khóa TOEIC thường gặp theo chủ đề
    private $toeic_keywords = [
        // Business & Work
        'business' => ['meeting', 'conference', 'presentation', 'proposal', 'contract', 'agreement', 'negotiation', 'deadline', 'schedule', 'appointment'],
        'finance' => ['budget', 'profit', 'revenue', 'expense', 'investment', 'loan', 'interest', 'payment', 'invoice', 'receipt'],
        'office' => ['department', 'manager', 'employee', 'colleague', 'supervisor', 'assistant', 'secretary', 'director', 'executive'],
        
        // Travel & Transportation
        'travel' => ['flight', 'airport', 'departure', 'arrival', 'boarding', 'gate', 'terminal', 'luggage', 'passport', 'visa'],
        'hotel' => ['reservation', 'check-in', 'check-out', 'reception', 'lobby', 'room service', 'amenities', 'facilities'],
        
        // Shopping & Services
        'shopping' => ['purchase', 'customer', 'service', 'product', 'quality', 'warranty', 'discount', 'promotion', 'sale'],
        'restaurant' => ['menu', 'order', 'reservation', 'waiter', 'chef', 'cuisine', 'ingredient', 'recipe'],
        
        // Time & Numbers
        'time' => ['morning', 'afternoon', 'evening', 'yesterday', 'today', 'tomorrow', 'weekly', 'monthly', 'annually'],
        'numbers' => ['first', 'second', 'third', 'several', 'many', 'few', 'most', 'least', 'approximately']
    ];
    
    // Từ nối và từ chỉ thị quan trọng
    private $signal_words = [
        'contrast' => ['however', 'although', 'despite', 'nevertheless', 'on the other hand', 'whereas', 'while'],
        'cause_effect' => ['because', 'since', 'therefore', 'consequently', 'as a result', 'due to', 'owing to'],
        'sequence' => ['first', 'then', 'next', 'finally', 'meanwhile', 'subsequently', 'previously'],
        'emphasis' => ['especially', 'particularly', 'notably', 'significantly', 'importantly', 'mainly']
    ];
    
    // Từ khóa câu hỏi thường gặp
    private $question_keywords = [
        'what', 'when', 'where', 'who', 'why', 'how', 'which', 'whose',
        'according to', 'mentioned', 'stated', 'indicated', 'suggested', 'implied'
    ];

    /**
     * Phân tích và highlight keywords trong văn bản
     * @param string $text - Văn bản cần phân tích
     * @param string $mode - Chế độ: 'practice' hoặc 'exam'
     * @return array - Kết quả phân tích và văn bản đã highlight
     */
    public function analyzeAndHighlight($text, $mode = 'practice') {
        // Nếu là chế độ thi thật, không highlight
        if ($mode === 'exam') {
            return [
                'original_text' => $text,
                'highlighted_text' => $text,
                'keywords_found' => [],
                'analysis' => ['message' => 'Highlighting disabled in exam mode']
            ];
        }
        
        // Làm sạch và chuẩn hóa văn bản
        $cleaned_text = $this->cleanText($text);
        
        // Tách từ (Tokenization)
        $tokens = $this->tokenize($cleaned_text);
        
        // Trích xuất keywords
        $keywords_found = $this->extractKeywords($tokens);
        
        // Phân tích ngữ pháp cơ bản
        $grammar_analysis = $this->analyzeGrammar($tokens);
        
        // Highlight văn bản
        $highlighted_text = $this->highlightText($text, $keywords_found);
        
        // Tạo gợi ý học tập
        $study_tips = $this->generateStudyTips($keywords_found, $grammar_analysis);
        
        return [
            'original_text' => $text,
            'highlighted_text' => $highlighted_text,
            'keywords_found' => $keywords_found,
            'analysis' => [
                'grammar' => $grammar_analysis,
                'study_tips' => $study_tips,
                'keyword_count' => count($keywords_found),
                'difficulty_level' => $this->assessDifficulty($keywords_found, $tokens)
            ]
        ];
    }
    
    /**
     * Làm sạch văn bản
     */
    private function cleanText($text) {
        // Loại bỏ HTML tags
        $text = strip_tags($text);
        // Loại bỏ ký tự đặc biệt không cần thiết
        $text = preg_replace('/[^\w\s\.\,\!\?\;\:\-$$$$\"\']/u', '', $text);
        return trim($text);
    }
    
    /**
     * Tách từ (Tokenization)
     */
    private function tokenize($text) {
        // Tách thành câu
        $sentences = preg_split('/[.!?]+/', $text);
        $tokens = [];
        
        foreach ($sentences as $sentence) {
            // Tách thành từ
            $words = preg_split('/\s+/', strtolower(trim($sentence)));
            $words = array_filter($words, function($word) {
                return strlen($word) > 1; // Loại bỏ từ quá ngắn
            });
            $tokens = array_merge($tokens, $words);
        }
        
        return array_unique($tokens);
    }
    
    /**
     * Trích xuất keywords quan trọng
     */
    private function extractKeywords($tokens) {
        $found_keywords = [];
        
        // Kiểm tra TOEIC keywords
        foreach ($this->toeic_keywords as $category => $keywords) {
            foreach ($keywords as $keyword) {
                if (in_array(strtolower($keyword), $tokens)) {
                    $found_keywords[] = [
                        'word' => $keyword,
                        'category' => $category,
                        'type' => 'toeic_keyword',
                        'importance' => 'high'
                    ];
                }
            }
        }
        
        // Kiểm tra signal words
        foreach ($this->signal_words as $type => $words) {
            foreach ($words as $word) {
                if (in_array(strtolower($word), $tokens)) {
                    $found_keywords[] = [
                        'word' => $word,
                        'category' => $type,
                        'type' => 'signal_word',
                        'importance' => 'medium'
                    ];
                }
            }
        }
        
        // Kiểm tra question keywords
        foreach ($this->question_keywords as $qword) {
            if (in_array(strtolower($qword), $tokens)) {
                $found_keywords[] = [
                    'word' => $qword,
                    'category' => 'question',
                    'type' => 'question_keyword',
                    'importance' => 'high'
                ];
            }
        }
        
        return $found_keywords;
    }
    
    /**
     * Phân tích ngữ pháp cơ bản
     */
    private function analyzeGrammar($tokens) {
        $analysis = [
            'verb_tenses' => [],
            'modal_verbs' => [],
            'prepositions' => [],
            'conjunctions' => []
        ];
        
        // Phát hiện thì động từ
        $verb_patterns = [
            'present_simple' => ['is', 'are', 'am', 'do', 'does'],
            'past_simple' => ['was', 'were', 'did'],
            'present_perfect' => ['have', 'has'],
            'future' => ['will', 'shall', 'going to']
        ];
        
        foreach ($verb_patterns as $tense => $verbs) {
            foreach ($verbs as $verb) {
                if (in_array($verb, $tokens)) {
                    $analysis['verb_tenses'][] = $tense;
                }
            }
        }
        
        // Phát hiện modal verbs
        $modals = ['can', 'could', 'may', 'might', 'must', 'should', 'would'];
        foreach ($modals as $modal) {
            if (in_array($modal, $tokens)) {
                $analysis['modal_verbs'][] = $modal;
            }
        }
        
        return $analysis;
    }
    
    /**
     * Highlight văn bản với các keywords đã tìm thấy
     */
    private function highlightText($text, $keywords) {
        $highlighted = $text;
        
        foreach ($keywords as $keyword_info) {
            $word = $keyword_info['word'];
            $type = $keyword_info['type'];
            $importance = $keyword_info['importance'];
            
            // Chọn màu highlight theo loại từ khóa
            $css_class = $this->getHighlightClass($type, $importance);
            
            // Highlight từ khóa (case-insensitive)
            $pattern = '/\b' . preg_quote($word, '/') . '\b/i';
            $replacement = '<span class="' . $css_class . '" data-keyword="' . $word . '" data-type="' . $type . '">' . $word . '</span>';
            $highlighted = preg_replace($pattern, $replacement, $highlighted);
        }
        
        return $highlighted;
    }
    
    /**
     * Lấy CSS class cho highlight
     */
    private function getHighlightClass($type, $importance) {
        $classes = [
            'toeic_keyword' => 'highlight-toeic',
            'signal_word' => 'highlight-signal',
            'question_keyword' => 'highlight-question'
        ];
        
        $base_class = $classes[$type] ?? 'highlight-default';
        $importance_class = 'importance-' . $importance;
        
        return $base_class . ' ' . $importance_class;
    }
    
    /**
     * Tạo gợi ý học tập
     */
    private function generateStudyTips($keywords, $grammar_analysis) {
        $tips = [];
        
        // Gợi ý dựa trên keywords tìm thấy
        $categories = array_unique(array_column($keywords, 'category'));
        
        foreach ($categories as $category) {
            switch ($category) {
                case 'business':
                    $tips[] = "💼 Văn bản chứa từ vựng kinh doanh. Chú ý các thuật ngữ về công việc và giao dịch.";
                    break;
                case 'travel':
                    $tips[] = "✈️ Chủ đề du lịch. Tập trung vào từ vựng về giao thông và lưu trú.";
                    break;
                case 'contrast':
                    $tips[] = "⚖️ Có từ nối chỉ sự tương phản. Chú ý các ý kiến đối lập.";
                    break;
                case 'cause_effect':
                    $tips[] = "🔗 Có mối quan hệ nguyên nhân - kết quả. Tìm hiểu logic của đoạn văn.";
                    break;
            }
        }
        
        // Gợi ý dựa trên ngữ pháp
        if (!empty($grammar_analysis['modal_verbs'])) {
            $tips[] = "📝 Chứa modal verbs. Chú ý ý nghĩa về khả năng, nghĩa vụ, hoặc dự đoán.";
        }
        
        return $tips;
    }
    
    /**
     * Đánh giá độ khó của văn bản
     */
    private function assessDifficulty($keywords, $tokens) {
        $total_words = count($tokens);
        $keyword_density = count($keywords) / max($total_words, 1);
        
        if ($keyword_density > 0.15) {
            return 'high';
        } elseif ($keyword_density > 0.08) {
            return 'medium';
        } else {
            return 'low';
        }
    }
    
    /**
     * Lấy CSS styles cho highlighting
     */
    public function getHighlightStyles() {
        return '
        <style>
        /* Keyword Highlighting Styles */
        .highlight-toeic {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            padding: 2px 4px;
            border-radius: 4px;
            font-weight: 600;
            border-bottom: 2px solid #f59e0b;
            cursor: help;
            transition: all 0.3s ease;
        }
        
        .highlight-signal {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
            padding: 2px 4px;
            border-radius: 4px;
            font-weight: 600;
            border-bottom: 2px solid #3b82f6;
            cursor: help;
            transition: all 0.3s ease;
        }
        
        .highlight-question {
            background: linear-gradient(135deg, #fecaca, #fca5a5);
            color: #dc2626;
            padding: 2px 4px;
            border-radius: 4px;
            font-weight: 600;
            border-bottom: 2px solid #ef4444;
            cursor: help;
            transition: all 0.3s ease;
        }
        
        .highlight-default {
            background: linear-gradient(135deg, #e5e7eb, #d1d5db);
            color: #374151;
            padding: 2px 4px;
            border-radius: 4px;
            font-weight: 500;
            cursor: help;
            transition: all 0.3s ease;
        }
        
        .importance-high {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transform: scale(1.02);
        }
        
        .importance-medium {
            opacity: 0.9;
        }
        
        .importance-low {
            opacity: 0.7;
        }
        
        /* Hover effects */
        [class*="highlight-"]:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            z-index: 10;
            position: relative;
        }
        
        /* Tooltip for keywords */
        [data-keyword]:hover::after {
            content: attr(data-type);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #1f2937;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
            margin-bottom: 5px;
        }
        
        /* Study tips panel */
        .study-tips-panel {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 1px solid #16a34a;
            border-radius: 12px;
            padding: 1rem;
            margin: 1rem 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .study-tips-panel h5 {
            color: #15803d;
            margin-bottom: 0.5rem;
        }
        
        .study-tips-panel ul {
            margin: 0;
            padding-left: 1.2rem;
        }
        
        .study-tips-panel li {
            margin-bottom: 0.3rem;
            color: #166534;
        }
        
        /* Keyword legend */
        .keyword-legend {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            margin: 1rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        
        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            margin-right: 0.5rem;
        }
        
        .legend-toeic { background: linear-gradient(135deg, #fef3c7, #fde68a); }
        .legend-signal { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
        .legend-question { background: linear-gradient(135deg, #fecaca, #fca5a5); }
        </style>';
    }
}
?>
