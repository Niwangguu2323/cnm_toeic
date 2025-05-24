/**
 * NLP Scripts for Practice Mode
 */

// Load keyword legend
function loadKeywordLegend() {
  const legendHtml = `
        <div class="keyword-legend">
            <h6><i class="fas fa-info-circle me-2"></i>Chú thích từ khóa</h6>
            <div class="row">
                <div class="col-md-4">
                    <div class="legend-item">
                        <div class="legend-color legend-toeic"></div>
                        <small>Từ vựng TOEIC quan trọng</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="legend-item">
                        <div class="legend-color legend-signal"></div>
                        <small>Từ nối/chỉ thị</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="legend-item">
                        <div class="legend-color legend-question"></div>
                        <small>Từ khóa câu hỏi</small>
                    </div>
                </div>
            </div>
        </div>
    `

  document.getElementById("keyword-legend").innerHTML = legendHtml
}

// Add click event for highlighted keywords
function initializeKeywordInteraction() {
  document.querySelectorAll("[data-keyword]").forEach((element) => {
    element.addEventListener("click", function () {
      const keyword = this.getAttribute("data-keyword")
      const type = this.getAttribute("data-type")

      let message = `Từ khóa: "${keyword}"\nLoại: ${type}`

      if (type === "toeic_keyword") {
        message += "\nĐây là từ vựng TOEIC quan trọng, thường xuất hiện trong các bài thi."
      } else if (type === "signal_word") {
        message += "\nĐây là từ nối/chỉ thị giúp hiểu cấu trúc và logic của đoạn văn."
      } else if (type === "question_keyword") {
        message += "\nĐây là từ khóa thường xuất hiện trong câu hỏi TOEIC."
      }

      alert(message)
    })
  })
}

// Process content with NLP highlighting
async function processContentWithNLP(text, mode = "practice") {
  try {
    const response = await fetch("../api/nlp/analyze.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        text: text,
        mode: mode,
      }),
    })

    const result = await response.json()

    if (result.success) {
      return result.data.highlighted_text
    } else {
      console.error("NLP processing failed:", result.message)
      return text
    }
  } catch (error) {
    console.error("Error processing NLP:", error)
    return text
  }
}

// Declare examConfig variable
const examConfig = {
  isPracticeMode: true, // Example value, should be set according to actual configuration
}

// Initialize NLP features when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  if (typeof examConfig !== "undefined" && examConfig.isPracticeMode) {
    loadKeywordLegend()

    // Initialize keyword interaction after content is loaded
    setTimeout(() => {
      initializeKeywordInteraction()
    }, 1000)
  }
})
