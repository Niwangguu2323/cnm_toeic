<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>2N Toeic Lab - Quản lý bài thi</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="../public/img/logoiuh.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../public/libs/animate/animate.min.css" rel="stylesheet">
    <link href="../public/libs/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../public/css/style.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        /* Style cho hàng được chọn */
        .selected-row {
            background-color: #e0f7fa !important;
        }
        
        /* Cursor pointer cho các hàng */
        #examTable tbody tr {
            cursor: pointer;
        }
    </style>
</head>
<body class="p-4">
    <a href="../index.php" class="btn btn-secondary">Trở lại trang chủ</a> </br></br>
    <a href="#" class="btn btn-primary" id="btnAddExam">Thêm bài thi</a>
    <a href="#" class="btn btn-danger" id="btnDeleteExam">Xóa bài thi</a></br></br>
    <h3 class="mb-4">📘 Danh sách bài thi</h3>
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Click vào bài thi để chọn, double-click để xem chi tiết.
    </div>
    <table class="table table-bordered table-striped table-hover" id="examTable">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Loại</th>
                <th>Thời lượng (phút)</th>
                <th>Độ khó</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dữ liệu sẽ đổ vào đây bằng JS -->
        </tbody>
    </table>

    <!-- Modal Thêm Bài Thi -->
    <div class="modal fade" id="addExamModal" tabindex="-1" aria-labelledby="addExamModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExamModalLabel">Thêm bài thi mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addExamForm">
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Loại</label>
                            <select class="form-select" id="type" required>
                                <option value="">Chọn loại</option>
                                <option value="Reading">Reading</option>
                                <option value="Listening">Listening</option>
                                <option value="Full">Full Test</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="duration_minutes" class="form-label">Thời lượng (phút)</label>
                            <input type="number" class="form-control" id="duration_minutes" required min="1">
                        </div>
                        <div class="mb-3">
                            <label for="difficulty_level" class="form-label">Độ khó</label>
                            <select class="form-select" id="difficulty_level" required>
                                <option value="">Chọn độ khó</option>
                                <option value="1">Dễ</option>
                                <option value="2">Trung bình</option>
                                <option value="3">Khó</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="json_file" class="form-label">Tải file câu hỏi (JSON)</label>
                            <input type="file" class="form-control" id="json_file" accept=".json">
                            <small class="text-muted">Chọn file JSON chứa danh sách câu hỏi</small>
                        </div>
                        <div class="mb-3">
                            <label for="questions_json" class="form-label">Nội dung câu hỏi (JSON)</label>
                            <textarea class="form-control" id="questions_json" rows="5" placeholder="Nội dung JSON sẽ hiển thị ở đây sau khi tải file" readonly></textarea>
                            <small class="text-muted">Định dạng: [{"content":"Nội dung","correct_answer":"A","option_1":"...","option_2":"...","option_3":"...","option_4":"..."}]</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="btnSubmitExam">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Xác nhận xóa -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa bài thi "<span id="examTitleToDelete"></span>" không?</p>
                    <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác và sẽ xóa tất cả câu hỏi liên quan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmDelete">Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Biến lưu trữ ID bài thi đang được chọn
            let selectedExamId = null;
            let selectedExamTitle = null;

            // Lấy danh sách bài thi
            loadExams();

            // Mở modal khi nhấn nút thêm bài thi
            document.getElementById('btnAddExam').addEventListener('click', () => {
                const addExamModal = new bootstrap.Modal(document.getElementById('addExamModal'));
                addExamModal.show();
            });

            // Xử lý sự kiện khi chọn file JSON
            document.getElementById('json_file').addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    // Kiểm tra file có phải là JSON không
                    if (file.type !== 'application/json' && !file.name.endsWith('.json')) {
                        alert('Vui lòng chọn file JSON!');
                        event.target.value = ''; // Reset input
                        return;
                    }

                    // Đọc file
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        try {
                            // Kiểm tra nội dung JSON hợp lệ
                            const jsonContent = e.target.result;
                            JSON.parse(jsonContent); // Thử parse để kiểm tra
                            
                            // Hiển thị nội dung vào textarea
                            document.getElementById('questions_json').value = jsonContent;
                        } catch (error) {
                            alert('File JSON không hợp lệ: ' + error.message);
                            event.target.value = ''; // Reset input
                            document.getElementById('questions_json').value = '';
                        }
                    };
                    reader.onerror = () => {
                        alert('Không thể đọc file!');
                        event.target.value = ''; // Reset input
                    };
                    reader.readAsText(file);
                }
            });

            // Xử lý sự kiện submit form thêm bài thi
            document.getElementById('btnSubmitExam').addEventListener('click', () => {
                const title = document.getElementById('title').value;
                const type = document.getElementById('type').value;
                const duration_minutes = document.getElementById('duration_minutes').value;
                const difficulty_level = document.getElementById('difficulty_level').value;
                const questions_json = document.getElementById('questions_json').value;

                // Kiểm tra dữ liệu
                if (!title || !type || !duration_minutes || !difficulty_level) {
                    alert('Vui lòng điền đầy đủ thông tin bài thi!');
                    return;
                }

                if (!questions_json) {
                    alert('Vui lòng tải file JSON câu hỏi!');
                    return;
                }

                // Chuẩn bị dữ liệu
                const examData = {
                    title: title,
                    type: type,
                    duration_minutes: duration_minutes,
                    difficulty_level: difficulty_level,
                    questions: JSON.parse(questions_json)
                };

                // Gửi dữ liệu
                fetch('../api/exam/insert.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(examData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Thêm bài thi thành công!');
                        // Đóng modal
                        const addExamModal = bootstrap.Modal.getInstance(document.getElementById('addExamModal'));
                        addExamModal.hide();
                        // Làm mới danh sách
                        loadExams();
                        // Reset form
                        document.getElementById('addExamForm').reset();
                        document.getElementById('questions_json').value = '';
                    } else {
                        alert('Lỗi: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi thêm bài thi:', error);
                    alert('Không thể thêm bài thi. Vui lòng thử lại sau.');
                });
            });

            // Xử lý sự kiện khi nhấn nút xóa bài thi
            document.getElementById('btnDeleteExam').addEventListener('click', () => {
                if (!selectedExamId) {
                    alert('Vui lòng chọn một bài thi để xóa!');
                    return;
                }

                // Hiển thị tên bài thi trong modal xác nhận
                document.getElementById('examTitleToDelete').textContent = selectedExamTitle;
                
                // Hiển thị modal xác nhận
                const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                deleteConfirmModal.show();
            });

            // Xử lý sự kiện khi xác nhận xóa
            document.getElementById('btnConfirmDelete').addEventListener('click', () => {
                if (!selectedExamId) return;

                // Gửi yêu cầu xóa
                fetch(`../api/exam/delete.php?id=${selectedExamId}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Xóa bài thi thành công!');
                        // Đóng modal
                        const deleteConfirmModal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
                        deleteConfirmModal.hide();
                        // Làm mới danh sách
                        loadExams();
                        // Reset biến lưu trữ
                        selectedExamId = null;
                        selectedExamTitle = null;
                    } else {
                        alert('Lỗi: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi xóa bài thi:', error);
                    alert('Không thể xóa bài thi. Vui lòng thử lại sau.');
                });
            });

            // Hàm tải danh sách bài thi
            function loadExams() {
                fetch('../api/exam/get.php')
                    .then(response => response.json())
                    .then(data => {
                        let rows = '';
                        data.forEach(exam => {
                            rows += `
                                <tr data-id="${exam.exam_id}" data-title="${exam.title}">
                                    <td>${exam.exam_id}</td>
                                    <td>${exam.title}</td>
                                    <td>${exam.type}</td>
                                    <td>${exam.duration_minutes}</td>
                                    <td>${exam.difficulty_level}</td>
                                </tr>`;
                        });
                        document.querySelector('#examTable tbody').innerHTML = rows;

                        // Gắn sự kiện click và double-click cho các hàng
                        document.querySelectorAll('#examTable tbody tr').forEach(row => {
                            // Sự kiện click để chọn hàng
                            row.addEventListener('click', () => {
                                // Bỏ chọn tất cả các hàng khác
                                document.querySelectorAll('#examTable tbody tr').forEach(r => {
                                    r.classList.remove('selected-row');
                                });
                                
                                // Chọn hàng hiện tại
                                row.classList.add('selected-row');
                                
                                // Lưu ID và tiêu đề bài thi đang chọn
                                selectedExamId = row.getAttribute('data-id');
                                selectedExamTitle = row.getAttribute('data-title');
                            });
                            
                            // Sự kiện double-click để xem chi tiết
                            row.addEventListener('dblclick', () => {
                                const examId = row.getAttribute('data-id');
                                window.location.href = `exam_detail_manage.php?id=${examId}`;
                            });
                        });
                    })
                    .catch(error => {
                        console.error('Lỗi khi gọi API:', error);
                    });
            }
        });
    </script>
</body>
</html>
