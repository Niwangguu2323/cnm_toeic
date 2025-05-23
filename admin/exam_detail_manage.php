<?php
session_start();

// Nếu chưa đăng nhập hoặc không phải là admin thì chặn truy cập
if (!isset($_SESSION["user_email"]) || $_SESSION["user_role"] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>2N Toeic Lab - Chi tiết bài thi</title>
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
</head>
<body class="p-4">
    <a href="../index.php" class="btn btn-secondary">Trở lại trang chủ</a> </br></br>
    <a href="exam_manage.php" class="btn btn-primary">Các bài thi</a> </br></br>
    <h3 class="mb-4">📘 Chi tiết bài thi</h3>
    <div class="container-fluid">
        <div class="row">
            <!-- BÊN TRÁI: DANH SÁCH CÂU HỎI -->
            <div class="col-md-9 table-responsive" style="overflow-x: auto;">
                <table class="table table-bordered table-striped table-hover" id="exam_detailTable">
                    <thead class="table-dark">
                        <tr>
                            <th>ID câu hỏi</th>
                            <th>ID bài thi</th>
                            <th>Nội dung câu hỏi</th>
                            <th>Đáp án đúng</th>
                            <th>Lựa chọn 1</th>
                            <th>Lựa chọn 2</th>
                            <th>Lựa chọn 3</th>
                            <th>Lựa chọn 4</th>
                            <th>ID đoạn văn</th>
                            <th>ID bài nghe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dữ liệu sẽ đổ vào đây bằng JS -->
                    </tbody>
                </table>
            </div>

            <!-- BÊN PHẢI: FORM CHỈNH SỬA -->
            <div class="col-md-3">
            <h4 class="mb-3">Sửa câu hỏi</h4>
            <form id="updateForm">
                
                <div class="mb-2"><label>Mã câu hỏi</label><input class="form-control" id="question_id" disabled></div>
                <div class="mb-2"><label>Nội dung</label><textarea class="form-control" id="content" rows="2"></textarea></div>
                <div class="mb-2"><label>Đáp án đúng</label><input class="form-control" id="correct_answer"></div>
                <div class="mb-2"><label>Option 1</label><input class="form-control" id="option_1"></div>
                <div class="mb-2"><label>Option 2</label><input class="form-control" id="option_2"></div>
                <div class="mb-2"><label>Option 3</label><input class="form-control" id="option_3"></div>
                <div class="mb-2"><label>Option 4</label><input class="form-control" id="option_4"></div>
                <button class="btn btn-success mt-3" type="submit">Cập nhật</button>
            </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const exam_id = params.get("id");

            if (!exam_id) {
                console.error("Không có exam_id trên URL!");
                return;
            }

            fetch(`../api/exam/getdetails.php?id=${exam_id}`)
                .then(response => response.json())
                .then(data => {
                    if (!Array.isArray(data)) {
                        console.error("Dữ liệu trả về không phải mảng:", data);
                        return;
                    }

                    let rows = '';
                    data.forEach(exam_question => {
                        rows += `
                            <tr data-id="${exam_question.question_id}">
                                <td>${exam_question.question_id}</td>
                                <td>${exam_question.exam_id}</td>
                                <td>${exam_question.content}</td>
                                <td>${exam_question.correct_answer}</td>
                                <td>${exam_question.option_1}</td>
                                <td>${exam_question.option_2}</td>
                                <td>${exam_question.option_3}</td>
                                <td>${exam_question.option_4}</td>
                                <td>${exam_question.passage_id}</td>
                                <td>${exam_question.listening_id}</td>
                            </tr>`;
                    });

                    const tbody = document.querySelector('#exam_detailTable tbody');
                    if (tbody) {
                        tbody.innerHTML = rows;

                        // GẮN SỰ KIỆN CLICK SAU KHI ĐÃ ĐỔ DỮ LIỆU
                        tbody.querySelectorAll('tr').forEach(row => {
                            row.addEventListener('click', () => {
                                const cells = row.children;
                                document.getElementById('question_id').value = cells[0].textContent;
                                document.getElementById('content').value = cells[2].textContent;
                                document.getElementById('correct_answer').value = cells[3].textContent;
                                document.getElementById('option_1').value = cells[4].textContent;
                                document.getElementById('option_2').value = cells[5].textContent;
                                document.getElementById('option_3').value = cells[6].textContent;
                                document.getElementById('option_4').value = cells[7].textContent
                            });
                        });
                    } else {
                        console.error("Không tìm thấy <tbody>");
                    }
                })
                .catch(error => {
                    console.error("Lỗi khi gọi API:", error);
                });

            // Sự kiện cập nhật
            document.getElementById('updateForm').addEventListener('submit', (e) => {
                e.preventDefault();
                const data = {
                    question_id: document.getElementById('question_id').value,
                    content: document.getElementById('content').value,
                    correct_answer: document.getElementById('correct_answer').value,
                    option_1: document.getElementById('option_1').value,
                    option_2: document.getElementById('option_2').value,
                    option_3: document.getElementById('option_3').value,
                    option_4: document.getElementById('option_4').value
                };

                fetch('../api/exam/update_question.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                })
                .then(async res => {
                    const text = await res.text();
                    try {
                        const json = JSON.parse(text);
                        if (res.ok) {
                            alert(json.message || 'Cập nhật thành công!');
                            location.reload();
                        } else {
                            alert(json.message || 'Lỗi server: ' + res.status);
                            console.error(json);
                        }
                    } catch (e) {
                        console.error('Không parse được JSON:', text);
                        alert('Server trả về dữ liệu không hợp lệ!');
                    }
                })
                .catch(err => {
                    console.error('Lỗi mạng hoặc fetch:', err);
                    alert('Không kết nối được đến server!');
                });
            });
        });
    </script>

</body>
</html>
