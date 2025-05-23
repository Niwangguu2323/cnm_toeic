<?php
    // Sử dụng đường dẫn tuyệt đối thay vì tương đối
    require_once __DIR__ . '/../controllers/UserController.php';
    
    class UserModel{
        public function getUser(){
            $p= new UserController();
            $tblSP=$p->selectUser();
            if(!$tblSP){
                return -1;
            }else{
                if($tblSP->num_rows>0){
                    return $tblSP;
                }else{
                    return 0; // 0 có dòng dữ liệu
                }
            }
        }
        public function getUserbyusername($uname){
            $p= new UserController();
            $tblSP=$p->selectUserbyusername($uname);
            if(!$tblSP){
                return -1;
            }else{
                if($tblSP->num_rows>0){
                    return $tblSP;
                }else{
                    return 0; // 0 có dòng dữ liệu
                }
            }
        }   
        public function getUserbyEmail($email){
            $p= new UserController;
            $tblSP=$p->selectUserbyEmail($email);
            if(!$tblSP){
                return -1;
            }else{
                if($tblSP->num_rows>0){
                    return $tblSP;
                }else{
                    return 0; // 0 có dòng dữ liệu
                }
            }
        }

        public function xuatDuLieu($sql) {
            $p = new UserController();
            $result = $p->runQuery($sql); // giống cách gọi trong getUser()

            if (!$result) {
                http_response_code(500);
                echo json_encode(["error" => "Truy vấn thất bại"]);
                return;
            }

            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode($data);
        }

        // Hàm cập nhật thông tin người dùng
        public function updateUser($data) {
            try {
                $p = new UserController();
                
                // Chuẩn bị câu SQL update
                $sql = "UPDATE user SET 
                        user_name = '" . mysqli_real_escape_string($p->getConnection(), $data['user_name']) . "',
                        email = '" . mysqli_real_escape_string($p->getConnection(), $data['email']) . "',
                        password = '" . mysqli_real_escape_string($p->getConnection(), $data['password']) . "',
                        full_name = '" . mysqli_real_escape_string($p->getConnection(), $data['full_name']) . "',
                        phone = '" . mysqli_real_escape_string($p->getConnection(), $data['phone']) . "',
                        role = '" . mysqli_real_escape_string($p->getConnection(), $data['role']) . "'
                        WHERE user_id = " . intval($data['user_id']);
                
                // Thực thi câu lệnh update
                $result = $p->updateUser($sql);
                
                if ($result) {
                    return [
                        "success" => true,
                        "message" => "Cập nhật thông tin người dùng thành công"
                    ];
                } else {
                    return [
                        "success" => false,
                        "message" => "Không thể cập nhật thông tin người dùng"
                    ];
                }
                
            } catch (Exception $e) {
                return [
                    "success" => false,
                    "message" => "Lỗi: " . $e->getMessage()
                ];
            }
        }
        
    }
?>
