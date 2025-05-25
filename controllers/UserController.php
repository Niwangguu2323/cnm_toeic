<?php
require_once __DIR__ . '/../config/db.php';

class UserController {
    public function dangnhap($user, $pass) {
        $p = new ketnoi;
        $conn = $p->moketnoi();
        
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT user_name, password, full_name, phone,subscription_id FROM user WHERE email = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows) {
            $r = $result->fetch_assoc();
            // Check password (replace with password_hash/password_verify if possible)
            if ($r['MatKhau'] === $pass) {
                // Return entire user row for session data
                return $r;
            }
        }
        
        return 0;
    }
    public function themUser($sql) {
        // Tạo kết nối mới
        $conn = new ketNoi();

        // Mở kết nối đến cơ sở dữ liệu
        $con = $conn->moketnoi();

        // Kiểm tra kết nối
        if($con) {
            // Thực thi truy vấn
            if($con->query($sql) === TRUE) {
                // Đóng kết nối
                $conn->dongketnoi($con);
                return true; // Trả về true nếu thêm sản phẩm thành công
            } else {
                // Đóng kết nối
                $conn->dongketnoi($con);
                return false; // Trả về false nếu có lỗi khi thêm sản phẩm
            }
        } else {
            return false; // Trả về false nếu không thể kết nối đến cơ sở dữ liệu
        }

    }
    public function selectUser(){
            $p=new clsKetNoi();
            $con=$p->moketnoi();
            if($con){
                $str="select*from user";
                $tblSP=$con->query($str);
                $p->dongketnoi($con);
                return $tblSP;
            }else{
            return false;// khoong thể kết nối với CSDL
            }
        }
        public function selectUserbyusername($uname){
            $p=new clsKetNoi();
            $con=$p->moketnoi();
            if($con){
                $str="select*from user where user_name='$uname'";
                $tblSP=$con->query($str);
                $p->dongketnoi($con);
                return $tblSP;
            }else{
            return false;// khoong thể kết nối với CSDL
            }
        }
        public function selectUserbyEmail($email){
            $p=new clsKetNoi();
            $con=$p->moketnoi();
            if($con){
                $str="select*from user where email='$email'";
                $tblSP=$con->query($str);
                $p->dongketnoi($con);
                return $tblSP;
            }else{
            return false;// khoong thể kết nối với CSDL
            }
        }

        // Phương thức runQuery để thực thi câu lệnh SELECT
        public function runQuery($sql) {
            $p = new ketnoi(); 
            $con = $p->moketnoi();
            if($con) {
                $result = $con->query($sql);
                $p->dongketnoi($con);
                return $result;
            } else {
                return false; 
            }
        }

        // Phương thức updateUser để thực thi câu lệnh UPDATE
        public function updateUser($sql) {
            $p = new ketnoi();
            $con = $p->moketnoi();
            
            if($con) {
                if($con->query($sql) === TRUE) {
                    $p->dongketnoi($con);
                    return true; 
                } else {
                    $p->dongketnoi($con);
                    return false; 
                }
            } else {
                return false; 
            }
        }

        // Phương thức deleteUser để thực thi câu lệnh DELETE
        public function deleteUser($sql) {
            $p = new ketnoi();
            $con = $p->moketnoi();
            
            if($con) {
                if($con->query($sql) === TRUE) {
                    $p->dongketnoi($con);
                    return true; 
                } else {
                    $p->dongketnoi($con);
                    return false; 
                }
            } else {
                return false; 
            }
        }

        // Phương thức getConnection để lấy kết nối database (dùng cho escape string)
        public function getConnection() {
            $p = new ketnoi();
            return $p->moketnoi();
        }
    
}
