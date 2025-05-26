<?php
session_start();
require_once __DIR__ . '/../models/UserModel.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION["user_email"])) {
    header("Location: login.php");
    exit;
}

$message = '';
$messageType = '';

// Lấy thông tin user hiện tại
$userModel = new UserModel();
$userInfo = null;

try {
    $userResult = $userModel->getUserbyEmail($_SESSION["user_email"]);
    if ($userResult && $userResult->num_rows > 0) {
        $userInfo = $userResult->fetch_assoc();
    }
} catch (Exception $e) {
    $message = "Lỗi khi tải thông tin người dùng: " . $e->getMessage();
    $messageType = 'danger';
}

// Xử lý cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'update_info') {
            // Cập nhật thông tin cá nhân
            $updateData = [
                'user_id' => $userInfo['user_id'],
                'user_name' => trim($_POST['user_name']),
                'email' => trim($_POST['email']),
                'full_name' => trim($_POST['full_name']),
                'phone' => trim($_POST['phone']),
                'password' => $userInfo['password'], // Giữ nguyên mật khẩu cũ
                'role' => $userInfo['role'] // Giữ nguyên role
            ];

            // Validate dữ liệu
            if (empty($updateData['user_name']) || empty($updateData['email']) || empty($updateData['full_name'])) {
                $message = "Vui lòng điền đầy đủ thông tin bắt buộc!";
                $messageType = 'danger';
            } elseif (!filter_var($updateData['email'], FILTER_VALIDATE_EMAIL)) {
                $message = "Email không hợp lệ!";
                $messageType = 'danger';
            } else {
                // Kiểm tra email đã tồn tại (ngoại trừ email hiện tại)
                $checkEmailResult = $userModel->getUserbyEmail($updateData['email']);
                if ($checkEmailResult && $checkEmailResult->num_rows > 0) {
                    $existingUser = $checkEmailResult->fetch_assoc();
                    if ($existingUser['user_id'] != $userInfo['user_id']) {
                        $message = "Email này đã được sử dụng bởi tài khoản khác!";
                        $messageType = 'danger';
                    }
                }

                if (empty($message)) {
                    $result = $userModel->updateUser($updateData);
                    if ($result['success']) {
                        $message = "Cập nhật thông tin thành công!";
                        $messageType = 'success';
                        
                        // Cập nhật session nếu email thay đổi
                        if ($_SESSION["user_email"] !== $updateData['email']) {
                            $_SESSION["user_email"] = $updateData['email'];
                        }
                        
                        // Reload thông tin user
                        $userResult = $userModel->getUserbyEmail($updateData['email']);
                        if ($userResult && $userResult->num_rows > 0) {
                            $userInfo = $userResult->fetch_assoc();
                        }
                    } else {
                        $message = $result['message'];
                        $messageType = 'danger';
                    }
                }
            }
        } elseif ($_POST['action'] === 'change_password') {
            // Thay đổi mật khẩu
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            // Validate
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                $message = "Vui lòng điền đầy đủ thông tin mật khẩu!";
                $messageType = 'danger';
            } elseif ($newPassword !== $confirmPassword) {
                $message = "Mật khẩu mới và xác nhận mật khẩu không khớp!";
                $messageType = 'danger';
            } elseif (strlen($newPassword) < 6) {
                $message = "Mật khẩu mới phải có ít nhất 6 ký tự!";
                $messageType = 'danger';
            } elseif ($userInfo['password'] !== $currentPassword) {
                $message = "Mật khẩu hiện tại không đúng!";
                $messageType = 'danger';
            } else {
                // Cập nhật mật khẩu
                $updateData = [
                    'user_id' => $userInfo['user_id'],
                    'user_name' => $userInfo['user_name'],
                    'email' => $userInfo['email'],
                    'full_name' => $userInfo['full_name'],
                    'phone' => $userInfo['phone'],
                    'password' => $newPassword,
                    'role' => $userInfo['role']
                ];

                $result = $userModel->updateUser($updateData);
                if ($result['success']) {
                    $message = "Đổi mật khẩu thành công!";
                    $messageType = 'success';
                    
                    // Reload thông tin user
                    $userResult = $userModel->getUserbyEmail($userInfo['email']);
                    if ($userResult && $userResult->num_rows > 0) {
                        $userInfo = $userResult->fetch_assoc();
                    }
                } else {
                    $message = $result['message'];
                    $messageType = 'danger';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>Thông tin cá nhân - 2N Toeic Lab</title>
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

    <style>
        .profile-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .profile-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 2rem;
        }

        .profile-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="1000,100 1000,0 0,100"/></svg>');
            background-size: cover;
        }

        .profile-header .content {
            position: relative;
            z-index: 2;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fff, #f8f9fa);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .profile-avatar i {
            font-size: 3rem;
            color: #667eea;
        }

        .profile-body {
            padding: 2rem;
        }

        .nav-tabs-custom {
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 2rem;
        }

        .nav-tabs-custom .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            color: #6c757d;
            font-weight: 600;
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
        }

        .nav-tabs-custom .nav-link:hover {
            border-color: #667eea;
            color: #667eea;
        }

        .nav-tabs-custom .nav-link.active {
            color: #667eea;
            border-color: #667eea;
            background: none;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-custom {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .btn-outline-custom {
            border: 2px solid #667eea;
            color: #667eea;
            background: transparent;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .info-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 5px solid #667eea;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #dee2e6;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
        }

        .info-value {
            color: #6c757d;
        }

        .alert-custom {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .password-strength {
            margin-top: 0.5rem;
        }

        .strength-bar {
            height: 4px;
            border-radius: 2px;
            background: #e9ecef;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            width: 0%;
        }

        .strength-weak { background: #dc3545; }
        .strength-medium { background: #ffc107; }
        .strength-strong { background: #28a745; }

        @media (max-width: 768px) {
            .profile-container {
                padding: 1rem 0;
            }
            
            .profile-body {
                padding: 1rem;
            }
            
            .nav-tabs-custom .nav-link {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="../index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>2NToeicLab</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="../index.php" class="nav-item nav-link">Trang chủ</a>
                <a href="./about.php" class="nav-item nav-link">Về chúng tôi</a>
                <div class="nav-item dropdown">
                    <a href="./practice.php" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Luyện tập</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="./listening.php" class="dropdown-item">Nghe</a>
                        <a href="./reading.php" class="dropdown-item">Đọc</a>
                    </div>
                </div>
                <a href="./test.php" class="nav-item nav-link">Làm bài thi</a>
            </div>
            <?php if (isset($_SESSION["user_email"])): ?>
                <div class="nav-item dropdown me-4">
                    <a href="#" class="btn btn-primary dropdown-toggle py-4 px-lg-5 d-none d-lg-block" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-2"></i><?= explode('@', $_SESSION["user_email"])[0] ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="profile.php" class="dropdown-item active"><i class="fas fa-user-edit me-2"></i>Sửa thông tin</a>
                        <a href="exam_history.php" class="dropdown-item"><i class="fas fa-history me-2"></i>Lịch sử bài thi</a>
                        <a href="logout.php" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a>
                       <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <div class="dropdown-divider"></div>
                            <a href="../admin/exam_manage.php" class="dropdown-item"><i class="fas fa-tasks me-2"></i>Quản lý bài thi</a>
                            <a href="../admin/user_manage.php" class="dropdown-item"><i class="fas fa-users me-2"></i>Quản lý người dùng</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Đăng nhập<i class="fa fa-arrow-right ms-3"></i></a>
            <?php endif; ?>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Profile Content Start -->
    <div class="profile-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="profile-card">
                        <!-- Profile Header -->
                        <div class="profile-header">
                            <div class="content">
                                <div class="profile-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <h2 class="mb-2"><?= htmlspecialchars($userInfo['full_name'] ?? 'Người dùng') ?></h2>
                                <p class="mb-0 opacity-75">
                                    <i class="fas fa-envelope me-2"></i><?= htmlspecialchars($userInfo['email'] ?? '') ?>
                                </p>
                                <?php if (!empty($userInfo['role']) && $userInfo['role'] === 'admin'): ?>
                                    <span class="badge bg-warning mt-2">
                                        <i class="fas fa-crown me-1"></i>Quản trị viên
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Profile Body -->
                        <div class="profile-body">
                            <!-- Alert Messages -->
                            <?php if (!empty($message)): ?>
                                <div class="alert alert-<?= $messageType ?> alert-custom alert-dismissible fade show" role="alert">
                                    <i class="fas fa-<?= $messageType === 'success' ? 'check-circle' : 'exclamation-triangle' ?> me-2"></i>
                                    <?= htmlspecialchars($message) ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <!-- Navigation Tabs -->
                            <ul class="nav nav-tabs nav-tabs-custom" id="profileTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                                        <i class="fas fa-user me-2"></i>Thông tin cá nhân
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button" role="tab">
                                        <i class="fas fa-edit me-2"></i>Chỉnh sửa thông tin
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                                        <i class="fas fa-lock me-2"></i>Đổi mật khẩu
                                    </button>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content" id="profileTabContent">
                                <!-- Thông tin cá nhân -->
                                <div class="tab-pane fade show active" id="info" role="tabpanel">
                                    <div class="info-card">
                                        <h5 class="mb-3">
                                            <i class="fas fa-info-circle me-2 text-primary"></i>
                                            Thông tin tài khoản
                                        </h5>
                                        
                                        <div class="info-item">
                                            <span class="info-label">
                                                <i class="fas fa-user me-2"></i>Tên đăng nhập:
                                            </span>
                                            <span class="info-value"><?= htmlspecialchars($userInfo['user_name'] ?? 'Chưa cập nhật') ?></span>
                                        </div>
                                        
                                        <div class="info-item">
                                            <span class="info-label">
                                                <i class="fas fa-signature me-2"></i>Họ và tên:
                                            </span>
                                            <span class="info-value"><?= htmlspecialchars($userInfo['full_name'] ?? 'Chưa cập nhật') ?></span>
                                        </div>
                                        
                                        <div class="info-item">
                                            <span class="info-label">
                                                <i class="fas fa-envelope me-2"></i>Email:
                                            </span>
                                            <span class="info-value"><?= htmlspecialchars($userInfo['email'] ?? 'Chưa cập nhật') ?></span>
                                        </div>
                                        
                                        <div class="info-item">
                                            <span class="info-label">
                                                <i class="fas fa-phone me-2"></i>Số điện thoại:
                                            </span>
                                            <span class="info-value"><?= htmlspecialchars($userInfo['phone'] ?? 'Chưa cập nhật') ?></span>
                                        </div>
                                        
                                        <div class="info-item">
                                            <span class="info-label">
                                                <i class="fas fa-shield-alt me-2"></i>Vai trò:
                                            </span>
                                            <span class="info-value">
                                                <?php if ($userInfo['role'] === 'admin'): ?>
                                                    <span class="badge bg-warning">Quản trị viên</span>
                                                <?php else: ?>
                                                    <span class="badge bg-primary">Người dùng</span>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button class="btn btn-custom" onclick="document.getElementById('edit-tab').click()">
                                            <i class="fas fa-edit me-2"></i>Chỉnh sửa thông tin
                                        </button>
                                    </div>
                                </div>

                                <!-- Chỉnh sửa thông tin -->
                                <div class="tab-pane fade" id="edit" role="tabpanel">
                                    <form method="POST" id="updateInfoForm">
                                        <input type="hidden" name="action" value="update_info">
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        <i class="fas fa-user me-2"></i>Tên đăng nhập <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" name="user_name" 
                                                           value="<?= htmlspecialchars($userInfo['user_name'] ?? '') ?>" 
                                                           required maxlength="50">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        <i class="fas fa-envelope me-2"></i>Email <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="email" class="form-control" name="email" 
                                                           value="<?= htmlspecialchars($userInfo['email'] ?? '') ?>" 
                                                           required maxlength="100">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-signature me-2"></i>Họ và tên <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="full_name" 
                                                   value="<?= htmlspecialchars($userInfo['full_name'] ?? '') ?>" 
                                                   required maxlength="100">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-phone me-2"></i>Số điện thoại
                                            </label>
                                            <input type="tel" class="form-control" name="phone" 
                                                   value="<?= htmlspecialchars($userInfo['phone'] ?? '') ?>" 
                                                   maxlength="15" pattern="[0-9+\-\s()]*">
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-custom me-2">
                                                <i class="fas fa-save me-2"></i>Lưu thay đổi
                                            </button>
                                            <button type="button" class="btn btn-outline-custom" onclick="document.getElementById('info-tab').click()">
                                                <i class="fas fa-times me-2"></i>Hủy
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Đổi mật khẩu -->
                                <div class="tab-pane fade" id="password" role="tabpanel">
                                    <form method="POST" id="changePasswordForm">
                                        <input type="hidden" name="action" value="change_password">
                                        
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-lock me-2"></i>Mật khẩu hiện tại <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="current_password" 
                                                       id="currentPassword" required>
                                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('currentPassword')">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-key me-2"></i>Mật khẩu mới <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="new_password" 
                                                       id="newPassword" required minlength="6" onkeyup="checkPasswordStrength()">
                                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('newPassword')">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="password-strength">
                                                <div class="strength-bar">
                                                    <div class="strength-fill" id="strengthBar"></div>
                                                </div>
                                                <small class="text-muted" id="strengthText">Độ mạnh mật khẩu</small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-check-double me-2"></i>Xác nhận mật khẩu mới <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="confirm_password" 
                                                       id="confirmPassword" required minlength="6" onkeyup="checkPasswordMatch()">
                                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword')">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted" id="matchText"></small>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-custom me-2" id="changePasswordBtn">
                                                <i class="fas fa-key me-2"></i>Đổi mật khẩu
                                            </button>
                                            <button type="button" class="btn btn-outline-custom" onclick="resetPasswordForm()">
                                                <i class="fas fa-undo me-2"></i>Đặt lại
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Profile Content End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-0">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Menu</h4>
                    <a class="btn btn-link" href="../index.php">Trang chủ</a>
                    <a class="btn btn-link" href="about.php">Về chúng tôi</a>
                    <a class="btn btn-link" href="listening.php">Luyện tập kĩ năng nghe</a>
                    <a class="btn btn-link" href="reading.php">Luyện tập kĩ năng đọc</a>
                    <a class="btn btn-link" href="test.php">Làm bài thi</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Liên hệ</h4>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>0949 80 4347 (Nhi)</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>nhi@student.iuh.edu.vn</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Đăng ký tài khoản</h4>
                    <p>Đến với 2N Toeic Lab nào!!!</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Email của bạn">
                        <a type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2" href="register.php">Đăng ký</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-12 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">2N Toeic Lab - Hệ thống hỗ trợ luyện thi TOEIC 2 kỹ năng</a>, All Right Reserved.
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a><br><br>
                        Distributed By <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/libs/wow/wow.min.js"></script>
    <script src="../public/libs/easing/easing.min.js"></script>
    <script src="../public/libs/waypoints/waypoints.min.js"></script>
    <script src="../public/libs/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../public/js/main.js"></script>

    <script>
        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Check password strength
        function checkPasswordStrength() {
            const password = document.getElementById('newPassword').value;
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            
            let strength = 0;
            let text = '';
            let className = '';
            
            if (password.length >= 6) strength += 1;
            if (password.match(/[a-z]/)) strength += 1;
            if (password.match(/[A-Z]/)) strength += 1;
            if (password.match(/[0-9]/)) strength += 1;
            if (password.match(/[^a-zA-Z0-9]/)) strength += 1;
            
            switch (strength) {
                case 0:
                case 1:
                    text = 'Rất yếu';
                    className = 'strength-weak';
                    strengthBar.style.width = '20%';
                    break;
                case 2:
                    text = 'Yếu';
                    className = 'strength-weak';
                    strengthBar.style.width = '40%';
                    break;
                case 3:
                    text = 'Trung bình';
                    className = 'strength-medium';
                    strengthBar.style.width = '60%';
                    break;
                case 4:
                    text = 'Mạnh';
                    className = 'strength-strong';
                    strengthBar.style.width = '80%';
                    break;
                case 5:
                    text = 'Rất mạnh';
                    className = 'strength-strong';
                    strengthBar.style.width = '100%';
                    break;
            }
            
            strengthBar.className = 'strength-fill ' + className;
            strengthText.textContent = text;
            strengthText.className = 'text-muted';
        }

        // Check password match
        function checkPasswordMatch() {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const matchText = document.getElementById('matchText');
            const submitBtn = document.getElementById('changePasswordBtn');
            
            if (confirmPassword === '') {
                matchText.textContent = '';
                matchText.className = 'text-muted';
                return;
            }
            
            if (newPassword === confirmPassword) {
                matchText.textContent = 'Mật khẩu khớp';
                matchText.className = 'text-success';
                submitBtn.disabled = false;
            } else {
                matchText.textContent = 'Mật khẩu không khớp';
                matchText.className = 'text-danger';
                submitBtn.disabled = true;
            }
        }

        // Reset password form
        function resetPasswordForm() {
            document.getElementById('changePasswordForm').reset();
            document.getElementById('strengthBar').style.width = '0%';
            document.getElementById('strengthText').textContent = 'Độ mạnh mật khẩu';
            document.getElementById('matchText').textContent = '';
            document.getElementById('changePasswordBtn').disabled = false;
        }

        // Form validation
        document.getElementById('updateInfoForm').addEventListener('submit', function(e) {
            const email = this.querySelector('input[name="email"]').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Vui lòng nhập email hợp lệ!');
                return false;
            }
        });

        document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Mật khẩu mới và xác nhận mật khẩu không khớp!');
                return false;
            }
            
            if (newPassword.length < 6) {
                e.preventDefault();
                alert('Mật khẩu mới phải có ít nhất 6 ký tự!');
                return false;
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>

</html>
