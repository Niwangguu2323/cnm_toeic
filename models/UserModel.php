<?php
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
        
    }
?>
