// Enhanced NLP Features JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Toggle advanced NLP features
    const toggleAdvancedBtn = document.getElementById('toggleAdvancedFeatures');
    const advancedPanel = document.getElementById('advancedFeaturesPanel');
    
    if (toggleAdvancedBtn && advancedPanel) {
        toggleAdvancedBtn.addEventListener('click', function() {
            if (advancedPanel.style.display === 'none') {
                advancedPanel.style.display = 'block';
                this.innerHTML = '<i class="fas fa-cog me-2"></i>Ẩn tính năng';
                this.classList.remove('btn-outline-primary');
                this.classList.add('btn-primary');
            } else {
                advancedPanel.style.display = 'none';
                this.innerHTML = '<i class="fas fa-cog me-2"></i>Tính năng NLP';
                this.classList.remove('btn-primary');
                this.classList.add('btn-outline-primary');
            }
        });
    }
    
    // Toggle keyword legend
    const toggleBtn = document.getElementById('toggleKeywordLegend');
    const legend = document.getElementById('keywordLegend');
    
    if (toggleBtn && legend) {
        toggleBtn.addEventListener('click', function() {
            if (legend.style.display === 'none') {
                legend.style.display = 'block';
                legend.classList.add('animate__animated', 'animate__fadeInDown');
                this.innerHTML = '<i class="fas fa-eye-slash me-2"></i>Ẩn chi tiết';
            } else {
                legend.style.display = 'none';
                this.innerHTML = '<i class="fas fa-info-circle me-2"></i>Chi tiết phân tích';
            }
        });
    }
    
    // Enhanced keyword tooltips with detailed info
    document.querySelectorAll('[data-keyword]').forEach(element => {
        element.addEventListener('mouseenter', function() {
            const keyword = this.getAttribute('data-keyword');
            const type = this.getAttribute('data-type');
            
            // Add detailed tooltip information
            let tooltipText = '';
            switch(type) {
                case 'toeic_keyword':
                    tooltipText = `TOEIC Keyword: ${keyword} - Từ vựng quan trọng thường xuất hiện trong đề thi`;
                    break;
                case 'signal_word':
                    tooltipText = `Signal Word: ${keyword} - Từ nối/chỉ thị giúp hiểu logic đoạn văn`;
                    break;
                case 'question_keyword':
                    tooltipText = `Question Word: ${keyword} - Từ khóa câu hỏi cần chú ý`;
                    break;
                case 'grammar_structure':
                    tooltipText = `Grammar: ${keyword} - Cấu trúc ngữ pháp quan trọng`;
                    break;
                default:
                    tooltipText = `Keyword: ${keyword}`;
            }
            
            this.setAttribute('title', tooltipText);
        });
    });
    
    // Question difficulty indicator animation
    document.querySelectorAll('.difficulty-indicator').forEach(indicator => {
        indicator.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.2)';
        });
        
        indicator.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Enhanced option analysis display
    document.querySelectorAll('.enhanced-option').forEach(option => {
        option.addEventListener('mouseenter', function() {
            const analysis = this.querySelector('.option-analysis');
            if (analysis) {
                analysis.style.opacity = '1';
                analysis.style.transform = 'translateY(0)';
            }
        });
    });
    
    // Auto-scroll to questions with high difficulty
    function highlightDifficultQuestions() {
        const difficultQuestions = document.querySelectorAll('.difficulty-high');
        difficultQuestions.forEach((question, index) => {
            setTimeout(() => {
                question.style.boxShadow = '0 0 0 3px rgba(220, 38, 38, 0.3)';
                setTimeout(() => {
                    question.style.boxShadow = '';
                }, 2000);
            }, index * 1000);
        });
    }
    
    // Call highlight function after exam starts
    document.getElementById('startExamBtn')?.addEventListener('click', function() {
        setTimeout(highlightDifficultQuestions, 3000);
    });
    
    // Lazy loading cho NLP analysis
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '50px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                if (element.dataset.needsNlp === 'true') {
                    // Gọi API analyze.php để xử lý NLP động
                    analyzeContentDynamically(element);
                }
            }
        });
    }, observerOptions);
    
    // Observe các elements cần NLP processing
    document.querySelectorAll('[data-needs-nlp="true"]').forEach(el => {
        observer.observe(el);
    });
});

// Hàm gọi API analyze.php để xử lý NLP động
async function analyzeContentDynamically(element) {
    const text = element.textContent;
    const mode = document.body.dataset.examMode || 'practice';
    
    try {
        const response = await fetch('../api/analyze.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                text: text,
                mode: mode
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            element.innerHTML = result.data.highlighted_text;
            element.removeAttribute('data-needs-nlp');
        }
    } catch (error) {
        console.error('Error analyzing content:', error);
    }
}