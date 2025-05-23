<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>2N Toeic Lab - Quản lý người dùng</title>
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
    <a href="#" class="btn btn-danger" id="btnDeleteUser">Xóa người dùng</a> </br></br>
    <h3 class="mb-4">📘 Danh sách người dùng</h3>
    <div class="container-fluid">
        <div class="row">
            <!-- BÊN TRÁI: DANH SÁCH NGƯỜI DÙNG -->
            <div class="col-md-8 table-responsive" style="overflow-x: auto;">
                <table class="table table-bordered table-striped table-hover" id="userTable">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên người dùng</th>
                            <th>Email</th>
                            <th>Mật khẩu</th>
                            <th>Tên đầy đủ</th>
                            <th>Số điện thoại</th>
                            <th>Loại người dùng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dữ liệu sẽ đổ vào đây bằng JS -->
                    </tbody>
                </table>
            </div>

            <!-- BÊN PHẢI: FORM CHỈNH SỬA -->
            <div class="col-md-4">
            <h4 class="mb-3">Sửa thông tin người dùng</h4>
            <form id="updateForm">
                
                <div class="mb-2"><label>ID</label><input class="form-control" id="user_id" disabled></div>
                <div class="mb-2"><label>Tên người dùng</label><input class="form-control" id="user_name"></div>
                <div class="mb-2"><label>Email</label><input class="form-control" id="email"></div>
                <div class="mb-2"><label>Mật khẩu</label><input class="form-control" id="password"></div>
                <div class="mb-2"><label>Tên đầy đủ</label><input class="form-control" id="full_name"></div>
                <div class="mb-2"><label>Số điện thoại</label><input class="form-control" id="phone"></div>
                <div class="mb-2"><label>Loại người dùng</label>
                    <select class="form-select" id="role" required>
                        <option value="">Chọn loại người dùng</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button class="btn btn-success mt-3" type="submit">Cập nhật</button>
            </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('../api/user/get.php')
                .then(response => response.json())
                .then(data => {
                    console.log("Dữ liệu nhận được:", data); // Debug log
                    
                    if (!Array.isArray(data)) {
                        console.error("Dữ liệu trả về không phải mảng:", data);
                        return;
                    }

                    let rows = '';
                    data.forEach(user => {
                        rows += `
                            <tr data-id="${user.user_id}">
                                <td>${user.user_id}</td>
                                <td>${user.user_name}</td>
                                <td>${user.email}</td>
                                <td>${user.password}</td>
                                <td>${user.full_name}</td>
                                <td>${user.phone}</td>
                                <td>${user.role}</td>
                            </tr>`;
                    });

                    const tbody = document.querySelector('#userTable tbody');
                    if (tbody) {
                        tbody.innerHTML = rows;

                        // GẮN SỰ KIỆN CLICK CHỌN DÒNG
                        tbody.querySelectorAll('tr').forEach(row => {
                            row.addEventListener('click', () => {
                                const cells = row.children;
                                document.getElementById('user_id').value = cells[0].textContent;
                                document.getElementById('user_name').value = cells[1].textContent;
                                document.getElementById('email').value = cells[2].textContent;
                                document.getElementById('password').value = cells[3].textContent;
                                document.getElementById('full_name').value = cells[4].textContent;
                                document.getElementById('phone').value = cells[5].textContent;
                                document.getElementById('role').value = cells[6].textContent;
                            });
                        });
                    } else {
                        console.error("Không tìm thấy <tbody>!");
                    }
                })
                .catch(error => {
                    console.error("Lỗi khi gọi API:", error);
                });

            // Sự kiện cập nhật
            document.getElementById('updateForm').addEventListener('submit', (e) => {
                e.preventDefault();
                const data = {
                    user_id: document.getElementById('user_id').value,
                    user_name: document.getElementById('user_name').value,
                    email: document.getElementById('email').value,
                    password: document.getElementById('password').value,
                    full_name: document.getElementById('full_name').value,
                    phone: document.getElementById('phone').value,
                    role: document.getElementById('role').value
                };

                fetch('../api/user/update.php', {
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
