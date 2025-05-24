/**
 * Main Exam Scripts
 */

// Declare examConfig variable
const examConfig = {
  examId: "12345",
  isPracticeMode: true,
  showResults: false,
  duration: 60, // in minutes
}

// Declare initializeKeywordInteraction variable
function initializeKeywordInteraction() {
  console.log("Keyword interaction initialized")
}

// Load exam content via AJAX
async function loadExamContent() {
  try {
    const response = await fetch(
      `../api/exam/get_content.php?exam_id=${examConfig.examId}&mode=${examConfig.isPracticeMode ? "practice" : "exam"}&show_results=${examConfig.showResults}`,
    )
    const result = await response.json()

    if (result.success) {
      renderExamContent(result.data)
    } else {
      console.error("Failed to load exam content:", result.message)
    }
  } catch (error) {
    console.error("Error loading exam content:", error)
  }
}

// Render exam content
function renderExamContent(data) {
  const contentContainer = document.getElementById("exam-content")
  let html = ""
  let questionNumber = 1

  // Render based on exam type
  if (data.exam.type === "Full") {
    // Listening section
    html += renderListeningSection(data.listenings, data.grouped_listening_questions, questionNumber)
    questionNumber += Object.values(data.grouped_listening_questions).flat().length

    // Reading section
    html += renderReadingSection(data.passages, data.grouped_questions, data.no_passage_questions, questionNumber)
  } else if (data.exam.type === "Reading") {
    html += renderReadingSection(data.passages, data.grouped_questions, data.no_passage_questions, questionNumber)
  } else if (data.exam.type === "Listening") {
    html += renderListeningSection(data.listenings, data.grouped_listening_questions, questionNumber)
  }

  contentContainer.innerHTML = html

  // Initialize NLP features if in practice mode
  if (examConfig.isPracticeMode && typeof initializeKeywordInteraction === "function") {
    setTimeout(() => {
      initializeKeywordInteraction()
    }, 500)
  }
}

// Render listening section
function renderListeningSection(listenings, groupedQuestions, startQuestionNumber) {
  let html = `
        <div class="section-header listening animate-fade-in">
            <div class="section-title">
                <div class="section-icon listening">
                    <i class="fas fa-headphones"></i>
                </div>
                <div>
                    <h2 class="mb-0">PHẦN I: LISTENING COMPREHENSION</h2>
                    <small class="text-muted">Phần nghe hiểu</small>
                </div>
            </div>
        </div>
    `

  let questionNumber = startQuestionNumber

  Object.entries(listenings).forEach(([lid, info]) => {
    html += `
            <div class="audio-container animate-fade-in">
                <div class="audio-header">
                    <div class="audio-icon">
                        <i class="fas fa-volume-up"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Đoạn nghe</h5>
                        <small class="text-muted">Nghe và trả lời các câu hỏi</small>
                    </div>
                </div>
                <p class="mb-3">${info.processed_content}</p>
                <audio controls class="audio-player">
                    <source src="../public/${info.audio_url}" type="audio/mpeg">
                    Trình duyệt của bạn không hỗ trợ phát audio.
                </audio>
        `

    if (groupedQuestions[lid]) {
      groupedQuestions[lid].forEach((question) => {
        html += renderQuestion(question, questionNumber++)
      })
    }

    html += "</div>"
  })

  return html
}

// Render reading section
function renderReadingSection(passages, groupedQuestions, noPassageQuestions, startQuestionNumber) {
  let html = `
        <div class="section-header reading animate-fade-in">
            <div class="section-title">
                <div class="section-icon reading">
                    <i class="fas fa-book-open"></i>
                </div>
                <div>
                    <h2 class="mb-0">PHẦN II: READING COMPREHENSION</h2>
                    <small class="text-muted">Phần đọc hiểu</small>
                </div>
            </div>
        </div>
    `

  let questionNumber = startQuestionNumber

  // No passage questions
  if (noPassageQuestions.length > 0) {
    html += `
            <div class="passage-container animate-fade-in">
                <div class="passage-header">
                    <div class="passage-icon">
                        <i class="fas fa-spell-check"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Ngữ pháp và từ vựng</h5>
                        <small class="text-muted">Chọn đáp án đúng nhất</small>
                    </div>
                </div>
        `

    noPassageQuestions.forEach((question) => {
      html += renderQuestion(question, questionNumber++)
    })

    html += "</div>"
  }

  // Passage questions
  Object.entries(passages).forEach(([pid, passage]) => {
    html += `
            <div class="passage-container animate-fade-in">
                <div class="passage-header">
                    <div class="passage-icon">
                        <i class="fas fa-file-text"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Đoạn văn</h5>
                        <small class="text-muted">Đọc đoạn văn và trả lời câu hỏi</small>
                    </div>
                </div>
                <div class="passage-content">
                    ${passage.processed_content}
                </div>
        `

    if (groupedQuestions[pid]) {
      groupedQuestions[pid].forEach((question) => {
        html += renderQuestion(question, questionNumber++)
      })
    }

    html += "</div>"
  })

  return html
}

// Render individual question
function renderQuestion(question, questionNumber) {
  return `
        <div class="question-container animate-fade-in">
            <div class="d-flex align-items-start">
                <div class="question-number">${questionNumber}</div>
                <div class="flex-grow-1">
                    <div class="question-text">
                        ${question.content}
                    </div>
                    <div class="option-group">
                        ${["A", "B", "C", "D"]
                          .map(
                            (opt, i) => `
                            <div class="option-item">
                                <input type="radio" 
                                       name="${question.question_id}" 
                                       value="${opt}" 
                                       id="q${question.question_id}${opt}" 
                                       disabled>
                                <label class="option-label" for="q${question.question_id}${opt}">
                                    <div class="option-letter">${opt}</div>
                                    <div>${question[`option_${i + 1}`]}</div>
                                </label>
                            </div>
                        `,
                          )
                          .join("")}
                    </div>
                </div>
            </div>
        </div>
    `
}

// Start Exam Function
document.getElementById("startExamBtn")?.addEventListener("click", function () {
  // Hide start button, show submit button
  this.classList.add("d-none")
  document.getElementById("submitExamBtn").classList.remove("d-none")

  // Enable all radio buttons
  document.querySelectorAll("input[type=radio]").forEach((input) => {
    input.disabled = false
  })

  // Show timer and progress
  document.getElementById("countdown-timer").style.display = "block"
  document.getElementById("progress-container").style.display = "block"

  // Start countdown timer
  startTimer()

  // Smooth scroll to first question
  setTimeout(() => {
    const firstQuestion = document.querySelector(".question-container")
    if (firstQuestion) {
      firstQuestion.scrollIntoView({ behavior: "smooth", block: "center" })
    }
  }, 500)
})

// Timer function
function startTimer() {
  let remainingTime = examConfig.duration * 60
  const totalTime = remainingTime
  const timerDisplay = document.getElementById("timer")

  const timerInterval = setInterval(() => {
    const minutes = Math.floor(remainingTime / 60)
    const seconds = remainingTime % 60
    timerDisplay.textContent = `${String(minutes).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`
    remainingTime--

    // Update progress bar
    const progress = ((totalTime - remainingTime) / totalTime) * 100
    document.getElementById("progress-fill").style.width = progress + "%"
    document.getElementById("progress-text").textContent = Math.round(progress) + "%"

    // Change timer color when time is running low
    if (remainingTime < 300) {
      // Last 5 minutes
      timerDisplay.parentElement.parentElement.style.background = "linear-gradient(135deg, #dc2626, #ef4444)"
    }

    if (remainingTime < 0) {
      clearInterval(timerInterval)
      timerDisplay.textContent = "00:00"
      alert("⏰ Thời gian của bạn đã hết. Bài thi sẽ được nộp tự động!")
      document.getElementById("submitForm").submit()
    }
  }, 1000)
}

// Progress tracking
document.addEventListener("change", (e) => {
  if (e.target.type === "radio") {
    updateProgress()
  }
})

function updateProgress() {
  const totalQuestions = document.querySelectorAll('input[type="radio"][name]').length / 4
  const answeredQuestions = new Set()

  document.querySelectorAll('input[type="radio"]:checked').forEach((input) => {
    answeredQuestions.add(input.name)
  })

  const progressPercentage = (answeredQuestions.size / totalQuestions) * 100
  document.getElementById("progress-fill").style.width = progressPercentage + "%"
  document.getElementById("progress-text").textContent = Math.round(progressPercentage) + "%"
}

// Confirmation before leaving page
window.addEventListener("beforeunload", (e) => {
  const hasStarted = document.getElementById("startExamBtn").classList.contains("d-none")
  if (hasStarted && !document.getElementById("submitForm").submitted) {
    e.preventDefault()
    e.returnValue = "Bạn có chắc chắn muốn rời khỏi trang? Tiến độ làm bài có thể bị mất."
  }
})

// Mark form as submitted when submitting
document.getElementById("submitForm").addEventListener("submit", function () {
  this.submitted = true
})
