<?php
    include_once("../controllers/UserController.php");
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
        
       
        
        
       
        
    }

  
?>