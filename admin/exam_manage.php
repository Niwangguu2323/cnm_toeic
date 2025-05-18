<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>2N Toeic Lab - Luyện thi</title>
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
    <a href="../index.php" class="btn btn-primary">Trở lại trang chủ</a> </br></br>
    <h3 class="mb-4">📘 Danh sách bài thi</h3>
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('../api/exam/get.php')
                .then(response => response.json())
                .then(data => {
                    let rows = '';
                    data.forEach(exam => {
                        rows += `
                            <tr data-id="${exam.exam_id}">
                                <td>${exam.exam_id}</td>
                                <td>${exam.title}</td>
                                <td>${exam.type}</td>
                                <td>${exam.duration_minutes}</td>
                                <td>${exam.difficulty_level}</td>
                            </tr>`;
                    });
                    document.querySelector('#examTable tbody').innerHTML = rows;

                    // Click vào dòng để xem chi tiết
                    document.querySelectorAll('#examTable tbody tr').forEach(row => {
                        row.addEventListener('click', () => {
                            const examId = row.getAttribute('data-id');
                            window.location.href = `exam_detail.php?id=${examId}`;
                        });
                    });
                })
                .catch(error => {
                    console.error('Lỗi khi gọi API:', error);
                });
        });
    </script>
</body>
</html>
